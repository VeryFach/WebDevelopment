@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<style>
    .edit-hero {
        background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%);
        color: white;
        border-radius: 25px;
        margin-bottom: 40px;
        box-shadow: 0 20px 40px rgba(253, 126, 20, 0.3);
        overflow: hidden;
        position: relative;
    }
    
    .edit-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }
    
    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .form-container {
        background: white;
        border-radius: 25px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        overflow: hidden;
        position: relative;
    }
    
    .form-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #fd7e14, #ffc107, #28a745, #17a2b8, #6f42c1);
        background-size: 400% 100%;
        animation: gradientShift 3s ease infinite;
    }
    
    @keyframes gradientShift {
        0%, 100% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
    }
    
    .form-group {
        position: relative;
        margin-bottom: 30px;
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        font-size: 0.95rem;
    }
    
    .form-label i {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        color: white;
        font-size: 14px;
    }
    
    .form-control {
        border: 2px solid #e9ecef;
        border-radius: 15px;
        padding: 15px 20px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: #f8f9fa;
    }
    
    .form-control:focus {
        border-color: #fd7e14;
        box-shadow: 0 0 0 0.2rem rgba(253, 126, 20, 0.25);
        background: white;
        transform: translateY(-2px);
    }
    
    .form-control:hover {
        background: white;
        border-color: #dee2e6;
    }
    
    .input-group {
        position: relative;
    }
    
    .input-group-text {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        color: white;
        font-weight: 600;
        border-radius: 15px 0 0 15px;
        padding: 15px 20px;
    }
    
    .btn-modern {
        border-radius: 15px;
        padding: 15px 30px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
        min-width: 120px;
    }
    
    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.6s;
    }
    
    .btn-modern:hover::before {
        left: 100%;
    }
    
    .btn-modern:hover {
        transform: translateY(-3px);
    }
    
    .btn-primary-modern {
        background: linear-gradient(135deg, #fd7e14, #ffc107);
        color: white;
        box-shadow: 0 8px 25px rgba(253, 126, 20, 0.4);
    }
    
    .btn-primary-modern:hover {
        box-shadow: 0 12px 35px rgba(253, 126, 20, 0.6);
    }
    
    .btn-secondary-modern {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white;
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
    }
    
    .btn-info-modern {
        background: linear-gradient(135deg, #17a2b8, #20c997);
        color: white;
        box-shadow: 0 8px 25px rgba(23, 162, 184, 0.4);
    }
    
    .comparison-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-top: 30px;
        overflow: hidden;
    }
    
    .comparison-header {
        background: linear-gradient(135deg, #6f42c1, #e83e8c);
        color: white;
        padding: 20px;
        text-align: center;
    }
    
    .comparison-content {
        padding: 30px;
    }
    
    .old-data, .new-data {
        padding: 20px;
        border-radius: 15px;
        margin-bottom: 20px;
    }
    
    .old-data {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-left: 4px solid #6c757d;
    }
    
    .new-data {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        border-left: 4px solid #28a745;
    }
    
    .data-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid rgba(0,0,0,0.1);
    }
    
    .data-item:last-child {
        border-bottom: none;
    }
    
    .data-label {
        font-weight: 600;
        color: #495057;
    }
    
    .data-value {
        font-weight: 500;
        color: #2c3e50;
    }
    
    .preview-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-top: 30px;
        transition: all 0.3s ease;
    }
    
    .preview-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .preview-header {
        background: linear-gradient(135deg, #17a2b8, #20c997);
        color: white;
        padding: 20px;
        display: flex;
        align-items: center;
    }
    
    .preview-icon {
        width: 50px;
        height: 50px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
    }
    
    .floating-save {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
        animation: pulse 2s infinite;
    }
    
    .floating-save .btn {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        font-size: 1.5rem;
    }
    
    .progress-steps {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        position: relative;
    }
    
    .progress-steps::before {
        content: '';
        position: absolute;
        top: 25px;
        left: 0;
        right: 0;
        height: 2px;
        background: #e9ecef;
        z-index: 1;
    }
    
    .progress-line {
        position: absolute;
        top: 25px;
        left: 0;
        height: 2px;
        background: linear-gradient(90deg, #fd7e14, #ffc107);
        z-index: 2;
        transition: width 0.5s ease;
    }
    
    .step {
        background: white;
        border: 3px solid #e9ecef;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        z-index: 3;
        position: relative;
        transition: all 0.3s ease;
    }
    
    .step.active {
        background: linear-gradient(135deg, #fd7e14, #ffc107);
        border-color: #fd7e14;
        color: white;
        transform: scale(1.1);
    }
    
    .step.completed {
        background: linear-gradient(135deg, #28a745, #20c997);
        border-color: #28a745;
        color: white;
    }
    
    .animate-in {
        animation: slideInUp 0.6s ease-out;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .invalid-feedback {
        display: block;
        font-size: 0.875rem;
        color: #dc3545;
        margin-top: 8px;
        padding: 8px 12px;
        background: rgba(220, 53, 69, 0.1);
        border-radius: 8px;
        border-left: 3px solid #dc3545;
    }
    
    .form-control.is-invalid {
        border-color: #dc3545;
        animation: shake 0.5s;
    }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    
    .help-text {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 5px;
        font-style: italic;
    }
    
    @media (max-width: 768px) {
        .form-container {
            margin: 0 10px;
        }
        
        .btn-modern {
            width: 100%;
            margin-bottom: 10px;
        }
        
        .floating-save {
            bottom: 20px;
            right: 20px;
        }
        
        .comparison-content {
            padding: 20px;
        }
        
        .old-data, .new-data {
            padding: 15px;
        }
    }
</style>

<div class="container-fluid animate-in">
    <!-- Hero Section -->
    <div class="edit-hero">
        <div class="row align-items-center" style="position: relative; z-index: 2;">
            <div class="col-md-8 p-5">
                <h1 class="display-5 mb-3 fw-bold">
                    <i class="fas fa-edit me-3"></i>
                    Edit Produk
                </h1>
                <p class="lead mb-0 opacity-75">
                    Perbarui informasi produk: <strong>{{ $product->name }}</strong>
                </p>
                <small class="opacity-50">ID: #{{ $product->id }} | Dibuat: {{ $product->created_at->format('d/m/Y') }}</small>
            </div>
            <div class="col-md-4 text-end p-5">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('products.show', $product) }}" class="btn btn-info-modern btn-modern">
                        <i class="fas fa-eye me-2"></i>Detail
                    </a>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary-modern btn-modern">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="form-container animate-in">
                <!-- Progress Steps -->
                <div class="p-4">
                    <div class="progress-steps">
                        <div class="progress-line" id="progressLine" style="width: 0%"></div>
                        <div class="step completed">1</div>
                        <div class="step active">2</div>
                        <div class="step">3</div>
                        <div class="step">4</div>
                    </div>
                </div>

                <div class="p-5">
                    <form action="{{ route('products.update', $product) }}" method="POST" id="editForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-tag" style="background: linear-gradient(135deg, #fd7e14, #ffc107);"></i>
                                Nama Produk
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $product->name) }}" 
                                   placeholder="Masukkan nama produk yang menarik"
                                   required>
                            <div class="help-text">
                                Gunakan nama yang mudah diingat dan menggambarkan produk
                            </div>
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left" style="background: linear-gradient(135deg, #6f42c1, #e83e8c);"></i>
                                Deskripsi Produk
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Jelaskan detail produk, fitur, dan keunggulan...">{{ old('description', $product->description) }}</textarea>
                            <div class="help-text">
                                Deskripsi yang detail membantu customer memahami produk lebih baik
                            </div>
                            @error('description')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price" class="form-label">
                                        <i class="fas fa-money-bill-wave" style="background: linear-gradient(135deg, #28a745, #20c997);"></i>
                                        Harga Produk
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" 
                                               step="0.01" 
                                               class="form-control @error('price') is-invalid @enderror" 
                                               id="price" 
                                               name="price" 
                                               value="{{ old('price', $product->price) }}" 
                                               placeholder="0"
                                               required>
                                    </div>
                                    <div class="help-text">
                                        Harga saat ini: Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </div>
                                    @error('price')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock" class="form-label">
                                        <i class="fas fa-boxes" style="background: linear-gradient(135deg, #17a2b8, #6610f2);"></i>
                                        Jumlah Stok
                                    </label>
                                    <div class="input-group">
                                        <input type="number" 
                                               class="form-control @error('stock') is-invalid @enderror" 
                                               id="stock" 
                                               name="stock" 
                                               value="{{ old('stock', $product->stock) }}" 
                                               placeholder="0"
                                               min="0"
                                               required>
                                        <span class="input-group-text" style="background: linear-gradient(135deg, #17a2b8, #6610f2); color: white; border: none;">unit</span>
                                    </div>
                                    <div class="help-text">
                                        Stok saat ini: {{ $product->stock }} unit
                                    </div>
                                    @error('stock')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 pt-4 border-top">
                            <button type="submit" class="btn btn-primary-modern btn-modern flex-fill">
                                <i class="fas fa-save me-2"></i>Update Produk
                            </button>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-info-modern btn-modern">
                                <i class="fas fa-eye me-2"></i>Detail
                            </a>
                            <a href="{{ route('products.index') }}" class="btn btn-secondary-modern btn-modern">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Live Preview -->
            <div class="preview-card animate-in">
                <div class="preview-header">
                    <div class="preview-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Live Preview</h6>
                        <small class="opacity-75">Pratinjau perubahan real-time</small>
                    </div>
                </div>
                <div class="p-4">
                    <div class="text-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-cube fa-2x text-primary"></i>
                        </div>
                    </div>
                    
                    <h5 id="previewName" class="text-center mb-3">{{ $product->name }}</h5>
                    <p id="previewDescription" class="text-muted text-center mb-4">
                        {{ $product->description ?: 'Tidak ada deskripsi' }}
                    </p>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="bg-success bg-opacity-10 rounded p-3">
                                <h6 class="text-success mb-1" id="previewPrice">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </h6>
                                <small class="text-muted">Harga</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="bg-info bg-opacity-10 rounded p-3">
                                <h6 class="text-info mb-1" id="previewStock">{{ $product->stock }} unit</h6>
                                <small class="text-muted">Stok</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Comparison -->
            <div class="comparison-card animate-in">
                <div class="comparison-header">
                    <h6 class="mb-0">
                        <i class="fas fa-balance-scale me-2"></i>
                        Perbandingan Data
                    </h6>
                </div>
                <div class="comparison-content">
                    <div class="old-data">
                        <h6 class="mb-3">
                            <i class="fas fa-history me-2"></i>
                            Data Lama
                        </h6>
                        <div class="data-item">
                            <span class="data-label">Nama:</span>
                            <span class="data-value">{{ $product->name }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Harga:</span>
                            <span class="data-value">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Stok:</span>
                            <span class="data-value">{{ $product->stock }} unit</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Deskripsi:</span>
                            <span class="data-value">{{ Str::limit($product->description ?: 'Tidak ada', 30) }}</span>
                        </div>
                    </div>

                    <div class="new-data">
                        <h6 class="mb-3">
                            <i class="fas fa-arrow-up me-2"></i>
                            Data Baru
                        </h6>
                        <div class="data-item">
                            <span class="data-label">Nama:</span>
                            <span class="data-value" id="newName">{{ $product->name }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Harga:</span>
                            <span class="data-value" id="newPrice">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Stok:</span>
                            <span class="data-value" id="newStock">{{ $product->stock }} unit</span>
                        </div>
                        <div class="data-item">
                            <span class="data-label">Deskripsi:</span>
                            <span class="data-value" id="newDescription">{{ Str::limit($product->description ?: 'Tidak ada', 30) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="preview-card animate-in mt-4">
                <div class="preview-header">
                    <div class="preview-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div>
                        <h6 class="mb-0">Statistik Cepat</h6>
                        <small class="opacity-75">Informasi tambahan</small>
                    </div>
                </div>
                <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Persentase Perubahan Harga:</span>
                        <span class="badge bg-info" id="priceChange">0%</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Perubahan Stok:</span>
                        <span class="badge bg-success" id="stockChange">0 unit</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Status Stok:</span>
                        <span class="badge" id="stockStatus">
                            @if($product->stock > 10)
                                <span class="bg-success">Baik</span>
                            @elseif($product->stock > 0)
                                <span class="bg-warning">Rendah</span>
                            @else
                                <span class="bg-danger">Habis</span>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Floating Save Button -->
<div class="floating-save">
    <button type="submit" form="editForm" class="btn btn-primary-modern btn-modern" data-bs-toggle="tooltip" title="Quick Save">
        <i class="fas fa-save"></i>
    </button>
</div>

<script>
    // Original values for comparison
    const originalData = {
        name: '{{ $product->name }}',
        price: {{ $product->price }},
        stock: {{ $product->stock }},
        description: '{{ $product->description }}'
    };

    // Real-time preview updates
    function updatePreview() {
        const name = document.getElementById('name').value || originalData.name;
        const description = document.getElementById('description').value || 'Tidak ada deskripsi';
        const price = parseFloat(document.getElementById('price').value) || 0;
        const stock = parseInt(document.getElementById('stock').value) || 0;

        // Update preview
        document.getElementById('previewName').textContent = name;
        document.getElementById('previewDescription').textContent = description;
        document.getElementById('previewPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('previewStock').textContent = stock + ' unit';

        // Update comparison
        document.getElementById('newName').textContent = name;
        document.getElementById('newPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('newStock').textContent = stock + ' unit';
        document.getElementById('newDescription').textContent = description.substring(0, 30) + (description.length > 30 ? '...' : '');

        // Calculate changes
        const priceChange = ((price - originalData.price) / originalData.price * 100).toFixed(1);
        const stockChange = stock - originalData.stock;

        document.getElementById('priceChange').textContent = priceChange + '%';
        document.getElementById('priceChange').className = 'badge ' + (priceChange > 0 ? 'bg-success' : priceChange < 0 ? 'bg-danger' : 'bg-secondary');
        
        document.getElementById('stockChange').textContent = (stockChange > 0 ? '+' : '') + stockChange + ' unit';
        document.getElementById('stockChange').className = 'badge ' + (stockChange > 0 ? 'bg-success' : stockChange < 0 ? 'bg-danger' : 'bg-secondary');

        // Update stock status
        const statusElement = document.getElementById('stockStatus');
        if (stock > 10) {
            statusElement.innerHTML = '<span class="bg-success">Baik</span>';
        } else if (stock > 0) {
            statusElement.innerHTML = '<span class="bg-warning">Rendah</span>';
        } else {
            statusElement.innerHTML = '<span class="bg-danger">Habis</span>';
        }

        // Update progress
        updateProgress();
    }

    // Progress tracking
    function updateProgress() {
        const fields = ['name', 'description', 'price', 'stock'];
        let filledFields = 0;
        
        fields.forEach(field => {
            const element = document.getElementById(field);
            if (element && element.value.trim() !== '') {
                filledFields++;
            }
        });

        const progress = (filledFields / fields.length) * 100;
        document.getElementById('progressLine').style.width = progress + '%';

        // Update step indicators
        const steps = document.querySelectorAll('.step');
        steps.forEach((step, index) => {
            if (index < Math.ceil(filledFields)) {
                step.classList.add('completed');
                step.classList.remove('active');
            } else if (index === Math.ceil(filledFields)) {
                step.classList.add('active');
                step.classList.remove('completed');
            } else {
                step.classList.remove('active', 'completed');
            }
        });
    }

    // Add event listeners
    ['name', 'description', 'price', 'stock'].forEach(fieldId => {
        const element = document.getElementById(fieldId);
        if (element) {
            element.addEventListener('input', updatePreview);
            element.addEventListener('keyup', updatePreview);
        }
    });

    // Format currency input
    document.getElementById('price').addEventListener('blur', function() {
        if (this.value) {
            const value = parseFloat(this.value);
            if (!isNaN(value)) {
                this.value = value.toFixed(2);
            }
        }
        updatePreview();
    });

    // Form validation and enhancement
    document.getElementById('editForm').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Menyimpan...';
            submitBtn.disabled = true;
        }

        // Add loading class to floating button
        const floatingBtn = document.querySelector('.floating-save .btn');
        if (floatingBtn) {
            floatingBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            floatingBtn.disabled = true;
        }
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto-resize textarea
    const textarea = document.getElementById('description');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = (this.scrollHeight) + 'px';
        });
    }

    // Add focus effects
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Ctrl + S to save
        if (e.ctrlKey && e.key === 's') {
            e.preventDefault();
            document.getElementById('editForm').dispatchEvent(new Event('submit'));
        }
        
        // Escape to cancel
        if (e.key === 'Escape') {
            if (confirm('Apakah Anda yakin ingin membatalkan perubahan?')) {
                window.location.href = '{{ route("products.index") }}';
            }
        }
    });

    // Animation on load
    document.addEventListener('DOMContentLoaded', function() {
        updatePreview();
        
        // Stagger animation for form groups
        const formGroups = document.querySelectorAll('.form-group');
        formGroups.forEach((group, index) => {
            setTimeout(() => {
                group.classList.add('animate-in');
            }, index * 100);
        });
    });

    // Smooth scroll to error fields
    const errorFields = document.querySelectorAll('.is-invalid');
    if (errorFields.length > 0) {
        errorFields[0].scrollIntoView({ 
            behavior: 'smooth', 
            block: 'center' 
        });
        errorFields[0].focus();
    }

    // Add change detection
    let hasChanges = false;
    document.querySelectorAll('input, textarea').forEach(element => {
        element.addEventListener('input', function() {
            hasChanges = true;
            document.title = '• ' + document.title.replace('• ', '');
        });
    });

    // Warn before leaving with unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (hasChanges) {
            e.preventDefault();
            e.returnValue = 'Ada perubahan yang belum disimpan. Yakin ingin meninggalkan halaman?';
            return e.returnValue;
        }
    });

    // Reset change detection on form submit
    document.getElementById('editForm').addEventListener('submit', function() {
        hasChanges = false;
    });

    // Add visual feedback for successful field completion
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() !== '' && !this.classList.contains('is-invalid')) {
                this.style.borderColor = '#28a745';
                setTimeout(() => {
                    this.style.borderColor = '';
                }, 2000);
            }
        });
    });

    // Auto-save draft (localStorage)
    function saveDraft() {
        const formData = {
            name: document.getElementById('name').value,
            description: document.getElementById('description').value,
            price: document.getElementById('price').value,
            stock: document.getElementById('stock').value,
            timestamp: Date.now()
        };
        localStorage.setItem('edit_product_draft_{{ $product->id }}', JSON.stringify(formData));
    }

    // Load draft if exists
    function loadDraft() {
        const draft = localStorage.getItem('edit_product_draft_{{ $product->id }}');
        if (draft) {
            const data = JSON.parse(draft);
            // Only load if draft is less than 1 hour old
            if (Date.now() - data.timestamp < 3600000) {
                if (confirm('Ditemukan draft yang belum disimpan. Muat draft tersebut?')) {
                    document.getElementById('name').value = data.name;
                    document.getElementById('description').value = data.description;
                    document.getElementById('price').value = data.price;
                    document.getElementById('stock').value = data.stock;
                    updatePreview();
                }
            }
        }
    }

    // Auto-save every 30 seconds
    setInterval(saveDraft, 30000);

    // Load draft on page load
    loadDraft();

    // Clear draft on successful submit
    document.getElementById('editForm').addEventListener('submit', function() {
        localStorage.removeItem('edit_product_draft_{{ $product->id }}');
    });

    // Add number formatting for better UX
    document.getElementById('price').addEventListener('input', function() {
        // Format number with thousands separator while typing
        let value = this.value.replace(/[^0-9.]/g, '');
        if (value) {
            // Don't format while decimal is open
            if (!value.includes('.') || value.split('.')[1].length <= 2) {
                const parts = value.split('.');
                parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                this.value = parts.join('.');
            }
        }
    });

    // Enhanced error handling
    function showError(message) {
        const toast = document.createElement('div');
        toast.className = 'position-fixed top-0 end-0 m-3 alert alert-danger';
        toast.style.zIndex = '9999';
        toast.innerHTML = `<i class="fas fa-exclamation-circle me-2"></i>${message}`;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 5000);
    }

    // Enhanced success feedback
    function showSuccess(message) {
        const toast = document.createElement('div');
        toast.className = 'position-fixed top-0 end-0 m-3 alert alert-success';
        toast.style.zIndex = '9999';
        toast.innerHTML = `<i class="fas fa-check-circle me-2"></i>${message}`;
        document.body.appendChild(toast);
        
        setTimeout(() => {
            toast.remove();
        }, 3000);
    }
</script>

<!-- Additional Styles for Enhanced UX -->
<style>
    .focused {
        transform: scale(1.02);
        transition: transform 0.2s ease;
    }
    
    .form-control:valid:not(:placeholder-shown):not(.is-invalid) {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='m2.3 6.73.5-.3 2-2L7.2 1.8l.8.8L7.5 3.1 4.7 5.9l-.7.7-1.1-1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }
    
    .animate-in {
        animation: slideInUp 0.6s ease-out forwards;
    }
    
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Loading states */
    .btn:disabled {
        cursor: not-allowed;
        opacity: 0.7;
    }
    
    /* Custom scrollbar for textarea */
    textarea::-webkit-scrollbar {
        width: 8px;
    }
    
    textarea::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 4px;
    }
    
    textarea::-webkit-scrollbar-thumb {
        background: #fd7e14;
        border-radius: 4px;
    }
    
    textarea::-webkit-scrollbar-thumb:hover {
        background: #e06900;
    }
    
    /* Enhanced mobile responsiveness */
    @media (max-width: 576px) {
        .edit-hero {
            text-align: center;
            padding: 20px;
        }
        
        .edit-hero h1 {
            font-size: 1.8rem;
        }
        
        .form-container {
            margin: 0;
            border-radius: 15px;
        }
        
        .preview-card, .comparison-card {
            margin-top: 20px;
            border-radius: 15px;
        }
        
        .floating-save {
            bottom: 15px;
            right: 15px;
        }
        
        .floating-save .btn {
            width: 60px;
            height: 60px;
            font-size: 1.2rem;
        }
    }
    
    /* Print styles */
    @media print {
        .btn, .floating-save, .comparison-card {
            display: none !important;
        }
        
        .form-container {
            box-shadow: none !important;
            border: 1px solid #ddd !important;
        }
        
        .edit-hero {
            background: #fd7e14 !important;
            -webkit-print-color-adjust: exact;
        }
    }
</style>
@endsection