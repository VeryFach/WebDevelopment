@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
<div class="page-header">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="mb-0"><i class="fas fa-boxes me-3"></i>Manajemen Produk</h1>
                <p class="mb-0 mt-2 opacity-75">Kelola semua produk dalam sistem</p>
            </div>
            <div class="col-md-4 text-end">
                <a href="{{ route('products.create') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-plus me-2"></i>Tambah Produk
                </a>
            </div>
        </div>
    </div>
</div>

@if($products->count() > 0)
    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="icon"><i class="fas fa-box"></i></div>
                <h4 class="mb-0">{{ $products->total() }}</h4>
                <small class="text-muted">Total Produk</small>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="icon"><i class="fas fa-warehouse"></i></div>
                <h4 class="mb-0">{{ $products->sum('stock') }}</h4>
                <small class="text-muted">Total Stok</small>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="icon"><i class="fas fa-dollar-sign"></i></div>
                <h4 class="mb-0">Rp {{ number_format($products->avg('price'), 0, ',', '.') }}</h4>
                <small class="text-muted">Rata-rata Harga</small>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="icon"><i class="fas fa-chart-line"></i></div>
                <h4 class="mb-0">{{ $products->where('stock', '>', 0)->count() }}</h4>
                <small class="text-muted">Stok Tersedia</small>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-transparent border-0 p-4">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Produk</h5>
                </div>
                <div class="col-auto">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Cari produk..." id="searchInput">
                        <button class="btn btn-outline-secondary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th><i class="fas fa-hashtag me-2"></i>ID</th>
                        <th><i class="fas fa-tag me-2"></i>Nama Produk</th>
                        <th><i class="fas fa-money-bill-wave me-2"></i>Harga</th>
                        <th><i class="fas fa-boxes me-2"></i>Stok</th>
                        <th><i class="fas fa-calendar me-2"></i>Tanggal</th>
                        <th><i class="fas fa-cogs me-2"></i>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <span class="badge bg-primary">#{{ $product->id }}</span>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-cube text-primary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $product->name }}</h6>
                                    @if($product->description)
                                        <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="fw-bold text-success">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            @if($product->stock > 10)
                                <span class="badge bg-success">{{ $product->stock }} unit</span>
                            @elseif($product->stock > 0)
                                <span class="badge bg-warning">{{ $product->stock }} unit</span>
                            @else
                                <span class="badge bg-danger">Habis</span>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ $product->created_at->format('d/m/Y') }}
                            </small>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('products.show', $product) }}" 
                                   class="btn btn-sm btn-info" 
                                   data-bs-toggle="tooltip" 
                                   title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('products.edit', $product) }}" 
                                   class="btn btn-sm btn-warning"
                                   data-bs-toggle="tooltip" 
                                   title="Edit Produk">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-danger" 
                                            data-bs-toggle="tooltip" 
                                            title="Hapus Produk"
                                            onclick="return confirm('Yakin ingin menghapus produk {{ $product->name }}?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
            <div class="card-footer bg-transparent border-0 p-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@else
    <div class="text-center py-5">
        <div class="card mx-auto" style="max-width: 400px;">
            <div class="card-body p-5">
                <div class="mb-4">
                    <i class="fas fa-box-open fa-4x text-muted"></i>
                </div>
                <h4 class="text-muted">Belum Ada Produk</h4>
                <p class="text-muted mb-4">Mulai dengan menambahkan produk pertama Anda</p>
                <a href="{{ route('products.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
                </a>
            </div>
        </div>
    </div>
@endif

<!-- Floating Action Button -->
<div class="floating-action">
    <a href="{{ route('products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i>
    </a>
</div>

<script>
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection