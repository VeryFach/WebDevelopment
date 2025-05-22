@extends('layouts.app')

@section('title', 'Tambah Produk')

@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0"><i class="fas fa-plus-circle me-3"></i>Tambah Produk Baru</h1>
                <p class="mb-0 mt-2 opacity-75">Isi form di bawah untuk menambahkan produk baru</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('products.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-transparent border-0 p-4">
                <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Form Produk Baru</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('products.store') }}" method="POST" id="productForm">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <label for="name" class="form-label">
                                <i class="fas fa-tag me-2"></i>Nama Produk
                            </label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   placeholder="Masukkan nama produk"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left me-2"></i>Deskripsi
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4"
                                      placeholder="Masukkan deskripsi produk (opsional)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="price" class="form-label">
                                <i class="fas fa-money-bill-wave me-2"></i>Harga
                            </label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" 
                                       step="0.01" 
                                       class="form-control @error('price') is-invalid @enderror" 
                                       id="price" 
                                       name="price" 
                                       value="{{ old('price') }}" 
                                       placeholder="0"
                                       required>
                                @error('price')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="stock" class="form-label">
                                <i class="fas fa-boxes me-2"></i>Stok
                            </label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control @error('stock') is-invalid @enderror" 
                                       id="stock" 
                                       name="stock" 
                                       value="{{ old('stock') }}" 
                                       placeholder="0"
                                       required>
                                <span class="input-group-text">unit</span>
                                @error('stock')
                                    <div class="invalid-feedback">
                                        <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-3 pt-3 border-top">
                        <button type="submit" class="btn btn-primary btn-lg flex-fill">
                            <i class="fas fa-save me-2"></i>Simpan Produk
                        </button>
                        <a href="{{ route('products.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times me-2"></i>Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="card mt-4" id="previewCard" style="display: none;">
            <div class="card-header bg-transparent">
                <h6 class="mb-0"><i class="fas fa-eye me-2"></i>Preview Produk</h6>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <div class="avatar-lg bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto">
                            <i class="fas fa-cube fa-2x text-primary"></i>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <h5 id="previewName">-</h5>
                        <p class="text-muted mb-2" id="previewDescription">-</p>
                        <div class="row">
                            <div class="col-sm-6">
                                <small class="text-muted">Harga:</small>
                                <div class="fw-bold text-success" id="previewPrice">Rp 0</div>
                            </div>
                            <div class="col-sm-6">
                                <small class="text-muted">Stok:</small>
                                <div class="fw-bold" id="previewStock">0 unit</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Real-time preview
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const priceInput = document.getElementById('price');
    const stockInput = document.getElementById('stock');
    const previewCard = document.getElementById('previewCard');

    function updatePreview() {
        const name = nameInput.value || '-';
        const description = descriptionInput.value || '-';
        const price = priceInput.value ? parseFloat(priceInput.value) : 0;
        const stock = stockInput.value || 0;

        document.getElementById('previewName').textContent = name;
        document.getElementById('previewDescription').textContent = description;
        document.getElementById('previewPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
        document.getElementById('previewStock').textContent = stock + ' unit';

        // Show preview card if any field has value
        if (name !== '-' || description !== '-' || price > 0 || stock > 0) {
            previewCard.style.display = 'block';
        } else {
            previewCard.style.display = 'none';
        }
    }

    // Add event listeners
    [nameInput, descriptionInput, priceInput, stockInput].forEach(input => {
        input.addEventListener('input', updatePreview);
    });

    // Format currency input
    priceInput.addEventListener('blur', function() {
        if (this.value) {
            const value = parseFloat(this.value);
            if (!isNaN(value)) {
                this.value = value.toFixed(2);
            }
        }
    });
</script>
@endsection