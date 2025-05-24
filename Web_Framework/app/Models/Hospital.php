<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'province',
        'phone',
        'email',
        'latitude',
        'longitude',
        'type',
        'services',
        'emergency_service',
        'bed_capacity',
        'status'
    ];

    protected $casts = [
        'services' => 'array',
        'emergency_service' => 'boolean',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Scope untuk hospital aktif
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope untuk pencarian berdasarkan nama
    public function scopeSearchByName($query, $name)
    {
        return $query->where('name', 'LIKE', '%' . $name . '%');
    }

    // Scope untuk pencarian berdasarkan kota
    public function scopeInCity($query, $city)
    {
        return $query->where('city', 'LIKE', '%' . $city . '%');
    }

    // Scope untuk pencarian berdasarkan tipe
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope untuk hospital dengan layanan darurat
    public function scopeWithEmergency($query)
    {
        return $query->where('emergency_service', true);
    }

    // Method untuk menghitung jarak menggunakan formula Haversine
    public function calculateDistance($lat2, $lon2)
    {
        $lat1 = $this->latitude;
        $lon1 = $this->longitude;
        
        $earthRadius = 6371; // Radius bumi dalam kilometer
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        return $earthRadius * $c;
    }
}