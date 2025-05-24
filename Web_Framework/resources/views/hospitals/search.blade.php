<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Rumah Sakit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Pencarian Rumah Sakit</h1>
        
        <div class="card mb-4">
            <div class="card-body">
                <form id="searchForm">
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name" class="form-label">Nama Rumah Sakit</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="form-label">Kota</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                        <div class="col-md-4">
                            <label for="type" class="form-label">Tipe</label>
                            <select class="form-control" id="type" name="type">
                                <option value="">Semua Tipe</option>
                                <option value="public">Publik</option>
                                <option value="private">Swasta</option>
                                <option value="specialized">Spesialis</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="number" class="form-control" id="latitude" name="latitude" step="any">
                        </div>
                        <div class="col-md-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="number" class="form-control" id="longitude" name="longitude" step="any">
                        </div>
                        <div class="col-md-3">
                            <label for="radius" class="form-label">Radius (KM)</label>
                            <input type="number" class="form-control" id="radius" name="radius" value="10">
                        </div>
                        <div class="col-md-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="emergency_only" name="emergency_only">
                                <label class="form-check-label" for="emergency_only">
                                    Hanya yang ada IGD
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <button type="button" class="btn btn-primary" onclick="searchHospitals()">Cari</button>
                        <button type="button" class="btn btn-success" onclick="exportToCsv()">Export CSV</button>
                        <button type="button" class="btn btn-info" onclick="saveToCsv()">Simpan ke Server</button>
                        <button type="button" class="btn btn-secondary" onclick="getCurrentLocation()">Gunakan Lokasi Saya</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div id="results"></div>
        <div id="csvInfo" class="alert alert-info" style="display: none;"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function getFormData() {
            const form = document.getElementById('searchForm');
            const formData = new FormData(form);
            const params = new URLSearchParams();
            
            for (let [key, value] of formData.entries()) {
                if (value.trim() !== '') {
                    params.append(key, value);
                }
            }
            
            return params.toString();
        }
        
        function searchHospitals() {
            const params = getFormData();
            
            fetch(`/api/hospitals/search?${params}`)
                .then(response => response.json())
                .then(data => {
                    displayResults(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mencari data');
                });
        }
        
        function exportToCsv() {
            const params = getFormData() + '&export_csv=true';
            
            // Create a temporary link to download
            const link = document.createElement('a');
            link.href = `/api/hospitals/search?${params}`;
            link.download = 'hospitals_export.csv';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
        
        function saveToCsv() {
            const params = getFormData() + '&save_csv=true';
            
            fetch(`/api/hospitals/search?${params}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('csvInfo').style.display = 'block';
                        document.getElementById('csvInfo').innerHTML = `
                            <strong>File CSV berhasil disimpan!</strong><br>
                            Path: ${data.csv_file}<br>
                            Total records: ${data.total_records}<br>
                            <a href="/api/hospitals/csv/download/${data.csv_file.split('/').pop()}" class="btn btn-sm btn-primary mt-2">Download File</a>
                        `;
                        displayResults(data);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat menyimpan CSV');
                });
        }
        
        function getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                });
            } else {
                alert("Geolocation tidak didukung oleh browser ini.");
            }
        }
        
        function displayResults(data) {
            const resultsDiv = document.getElementById('results');
            
            if (data.success && data.data.length > 0) {
                let html = '<div class="card"><div class="card-body">';
                html += `<h5>Hasil Pencarian (${data.data.length} rumah sakit)</h5>`;
                html += '<div class="row">';
                
                data.data.forEach(hospital => {
                    html += `
                        <div class="col-md-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">${hospital.name}</h6>
                                    <p class="card-text">
                                        <strong>Alamat:</strong> ${hospital.address}<br>
                                        <strong>Kota:</strong> ${hospital.city}<br>
                                        <strong>Tipe:</strong> ${hospital.type}<br>
                                        <strong>IGD:</strong> ${hospital.emergency_service ? 'Ya' : 'Tidak'}<br>
                                        <strong>Telepon:</strong> ${hospital.phone || 'N/A'}
                                        ${hospital.distance ? `<br><strong>Jarak:</strong> ${hospital.distance.toFixed(2)} km` : ''}
                                    </p>
                                </div>
                            </div>
                        </div>
                    `;
                });
                
                html += '</div></div></div>';
                resultsDiv.innerHTML = html;
            } else {
                resultsDiv.innerHTML = '<div class="alert alert-warning">Tidak ada rumah sakit yang ditemukan</div>';
            }
        }
    </script>
</body>
</html>