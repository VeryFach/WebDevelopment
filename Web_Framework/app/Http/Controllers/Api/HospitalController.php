<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class HospitalController extends Controller
{
    /**
     * Mencari rumah sakit berdasarkan berbagai kriteria
     */
    public function search(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|min:2',
            'city' => 'nullable|string|min:2',
            'type' => 'nullable|in:public,private,specialized',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'radius' => 'nullable|numeric|min:0.1|max:100', // dalam km
            'emergency_only' => 'nullable|boolean',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|between:1,100',
            'export_csv' => 'nullable|boolean', // Parameter untuk export CSV
            'save_csv' => 'nullable|boolean' // Parameter untuk menyimpan CSV di server
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = Hospital::active();

        // Filter berdasarkan nama
        if ($request->filled('name')) {
            $query->searchByName($request->name);
        }

        // Filter berdasarkan kota
        if ($request->filled('city')) {
            $query->inCity($request->city);
        }

        // Filter berdasarkan tipe
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // Filter hanya yang memiliki layanan darurat
        if ($request->boolean('emergency_only')) {
            $query->withEmergency();
        }

        // Pencarian berdasarkan radius (jika latitude dan longitude disediakan)
        if ($request->filled(['latitude', 'longitude'])) {
            $lat = $request->latitude;
            $lon = $request->longitude;
            $radius = $request->radius ?? 10; // Default 10km

            // Menggunakan formula Haversine untuk mencari dalam radius
            $query->whereRaw("
                (6371 * acos(
                    cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(latitude))
                )) <= ?
            ", [$lat, $lon, $lat, $radius]);

            // Mengurutkan berdasarkan jarak terdekat
            $query->selectRaw("
                *,
                (6371 * acos(
                    cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(latitude))
                )) as distance
            ", [$lat, $lon, $lat])
            ->orderBy('distance');
        } else {
            // Jika tidak ada koordinat, urutkan berdasarkan nama
            $query->orderBy('name');
        }

        // Jika export_csv atau save_csv true, ambil semua data tanpa pagination
        if ($request->boolean('export_csv') || $request->boolean('save_csv')) {
            $hospitals = $query->get();
            
            // Jika save_csv true, simpan ke server
            if ($request->boolean('save_csv')) {
                $csvPath = $this->saveHospitalsToCsv($hospitals, $request);
                
                return response()->json([
                    'success' => true,
                    'message' => 'Hospitals retrieved and saved to CSV successfully',
                    'data' => $hospitals,
                    'csv_file' => $csvPath,
                    'total_records' => $hospitals->count()
                ]);
            }
            
            // Jika export_csv true, return sebagai download
            if ($request->boolean('export_csv')) {
                return $this->exportHospitalsToCsv($hospitals, $request);
            }
        }

        $perPage = $request->per_page ?? 15;
        $hospitals = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Hospitals retrieved successfully',
            'data' => $hospitals->items(),
            'pagination' => [
                'current_page' => $hospitals->currentPage(),
                'last_page' => $hospitals->lastPage(),
                'per_page' => $hospitals->perPage(),
                'total' => $hospitals->total(),
            ]
        ]);
    }

    /**
     * Mencari rumah sakit terdekat berdasarkan koordinat
     */
    public function nearest(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'limit' => 'nullable|integer|between:1,50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $lat = $request->latitude;
        $lon = $request->longitude;
        $limit = $request->limit ?? 10;

        $hospitals = Hospital::active()
            ->selectRaw("
                *,
                (6371 * acos(
                    cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) +
                    sin(radians(?)) * sin(radians(latitude))
                )) as distance
            ", [$lat, $lon, $lat])
            ->orderBy('distance')
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Nearest hospitals retrieved successfully',
            'data' => $hospitals,
            'user_location' => [
                'latitude' => $lat,
                'longitude' => $lon
            ]
        ]);
    }

    /**
     * Mendapatkan detail rumah sakit berdasarkan ID
     */
    public function show($id): JsonResponse
    {
        $hospital = Hospital::active()->find($id);

        if (!$hospital) {
            return response()->json([
                'success' => false,
                'message' => 'Hospital not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Hospital details retrieved successfully',
            'data' => $hospital
        ]);
    }

    /**
     * Mendapatkan daftar semua rumah sakit
     */
    public function index(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|between:1,100'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $perPage = $request->per_page ?? 15;
        $hospitals = Hospital::active()
            ->orderBy('name')
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'All hospitals retrieved successfully',
            'data' => $hospitals->items(),
            'pagination' => [
                'current_page' => $hospitals->currentPage(),
                'last_page' => $hospitals->lastPage(),
                'per_page' => $hospitals->perPage(),
                'total' => $hospitals->total(),
            ]
        ]);
    }

    /**
     * Mendapatkan statistik rumah sakit
     */
    public function statistics(): JsonResponse
    {
        $stats = [
            'total_hospitals' => Hospital::active()->count(),
            'by_type' => Hospital::active()
                ->select('type', DB::raw('count(*) as count'))
                ->groupBy('type')
                ->get(),
            'with_emergency' => Hospital::active()->withEmergency()->count(),
            'by_city' => Hospital::active()
                ->select('city', DB::raw('count(*) as count'))
                ->groupBy('city')
                ->orderBy('count', 'desc')
                ->limit(10)
                ->get()
        ];

        return response()->json([
            'success' => true,
            'message' => 'Hospital statistics retrieved successfully',
            'data' => $stats
        ]);
    }

    /**
     * Menyimpan data rumah sakit ke file CSV di server
     */
    private function saveHospitalsToCsv($hospitals, Request $request): string
    {
        // Generate filename dengan timestamp dan filter yang digunakan
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filters = [];
        
        if ($request->filled('city')) {
            $filters[] = 'city-' . str_replace(' ', '-', $request->city);
        }
        if ($request->filled('type')) {
            $filters[] = 'type-' . $request->type;
        }
        if ($request->filled('name')) {
            $filters[] = 'name-' . str_replace(' ', '-', $request->name);
        }
        
        $filterString = !empty($filters) ? '_' . implode('_', $filters) : '';
        $filename = "hospitals_search_{$timestamp}{$filterString}.csv";
        
        // Path untuk menyimpan file
        $path = "exports/hospitals/{$filename}";
        
        // Membuat header CSV
        $headers = [
            'ID',
            'Nama Rumah Sakit',
            'Alamat',
            'Kota',
            'Provinsi',
            'Telepon',
            'Email',
            'Latitude',
            'Longitude',
            'Tipe',
            'Layanan Darurat',
            'Kapasitas Tempat Tidur',
            'Layanan Tersedia',
            'Status',
            'Dibuat Pada',
            'Diperbarui Pada'
        ];
        
        // Jika ada data jarak, tambahkan kolom jarak
        if ($hospitals->first() && isset($hospitals->first()->distance)) {
            $headers[] = 'Jarak (KM)';
        }
        
        // Membuat content CSV
        $csvContent = implode(',', $headers) . "\n";
        
        foreach ($hospitals as $hospital) {
            $row = [
                $hospital->id,
                '"' . str_replace('"', '""', $hospital->name) . '"',
                '"' . str_replace('"', '""', $hospital->address) . '"',
                '"' . str_replace('"', '""', $hospital->city) . '"',
                '"' . str_replace('"', '""', $hospital->province) . '"',
                '"' . ($hospital->phone ?? '') . '"',
                '"' . ($hospital->email ?? '') . '"',
                $hospital->latitude,
                $hospital->longitude,
                $hospital->type,
                $hospital->emergency_service ? 'Ya' : 'Tidak',
                $hospital->bed_capacity ?? 0,
                '"' . implode(', ', $hospital->services ?? []) . '"',
                $hospital->status,
                $hospital->created_at->format('Y-m-d H:i:s'),
                $hospital->updated_at->format('Y-m-d H:i:s')
            ];
            
            // Tambahkan jarak jika ada
            if (isset($hospital->distance)) {
                $row[] = number_format($hospital->distance, 2);
            }
            
            $csvContent .= implode(',', $row) . "\n";
        }
        
        // Menyimpan file ke storage
        Storage::put($path, $csvContent);
        
        return $path;
    }

    /**
     * Export data rumah sakit sebagai CSV download
     */
    private function exportHospitalsToCsv($hospitals, Request $request): StreamedResponse
    {
        // Generate filename
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filters = [];
        
        if ($request->filled('city')) {
            $filters[] = 'city-' . str_replace(' ', '-', $request->city);
        }
        if ($request->filled('type')) {
            $filters[] = 'type-' . $request->type;
        }
        if ($request->filled('name')) {
            $filters[] = 'name-' . str_replace(' ', '-', $request->name);
        }
        
        $filterString = !empty($filters) ? '_' . implode('_', $filters) : '';
        $filename = "hospitals_search_{$timestamp}{$filterString}.csv";
        
        $response = new StreamedResponse(function() use ($hospitals) {
            $handle = fopen('php://output', 'w');
            
            // Header CSV
            $headers = [
                'ID',
                'Nama Rumah Sakit',
                'Alamat',
                'Kota',
                'Provinsi',
                'Telepon',
                'Email',
                'Latitude',
                'Longitude',
                'Tipe',
                'Layanan Darurat',
                'Kapasitas Tempat Tidur',
                'Layanan Tersedia',
                'Status',
                'Dibuat Pada',
                'Diperbarui Pada'
            ];
            
            // Jika ada data jarak, tambahkan kolom jarak
            if ($hospitals->first() && isset($hospitals->first()->distance)) {
                $headers[] = 'Jarak (KM)';
            }
            
            fputcsv($handle, $headers);
            
            // Data rows
            foreach ($hospitals as $hospital) {
                $row = [
                    $hospital->id,
                    $hospital->name,
                    $hospital->address,
                    $hospital->city,
                    $hospital->province,
                    $hospital->phone ?? '',
                    $hospital->email ?? '',
                    $hospital->latitude,
                    $hospital->longitude,
                    $hospital->type,
                    $hospital->emergency_service ? 'Ya' : 'Tidak',
                    $hospital->bed_capacity ?? 0,
                    implode(', ', $hospital->services ?? []),
                    $hospital->status,
                    $hospital->created_at->format('Y-m-d H:i:s'),
                    $hospital->updated_at->format('Y-m-d H:i:s')
                ];
                
                // Tambahkan jarak jika ada
                if (isset($hospital->distance)) {
                    $row[] = number_format($hospital->distance, 2);
                }
                
                fputcsv($handle, $row);
            }
            
            fclose($handle);
        });
        
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');
        
        return $response;
    }

    /**
     * Download file CSV yang sudah disimpan
     */
    public function downloadCsv($filename): StreamedResponse
    {
        $path = "exports/hospitals/{$filename}";
        
        if (!Storage::exists($path)) {
            abort(404, 'File not found');
        }
        
        return Storage::download($path);
    }

    /**
     * Mendapatkan daftar file CSV yang tersedia
     */
    public function listCsvFiles(): JsonResponse
    {
        $files = Storage::files('exports/hospitals');
        $csvFiles = [];
        
        foreach ($files as $file) {
            if (pathinfo($file, PATHINFO_EXTENSION) === 'csv') {
                $csvFiles[] = [
                    'filename' => basename($file),
                    'path' => $file,
                    'size' => Storage::size($file),
                    'last_modified' => Storage::lastModified($file),
                    'download_url' => url("api/hospitals/csv/download/" . basename($file))
                ];
            }
        }
        
        return response()->json([
            'success' => true,
            'message' => 'CSV files retrieved successfully',
            'data' => $csvFiles
        ]);
    }
}