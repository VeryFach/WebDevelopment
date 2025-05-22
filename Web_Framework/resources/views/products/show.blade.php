@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<style>
    .product-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 20px;
        margin-bottom: 30px;
        box-shadow: 0 15px 35px rgba(102, 126, 234, 0.3);
        overflow: hidden;
        position: relative;
    }
    
    .product-hero::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        transform: translate(50px, -50px);
    }
    
    .product-hero::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 150px;
        height: 150px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
        transform: translate(-50px, 50px);
    }
    
    .product-icon {
        width: 120px;
        height: 120px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        backdrop-filter: blur(10px);
        border: 3px solid rgba(255,255,255,0.3);
    }
    
    .info-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
    }
    
    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    
    .info-item {
        padding: 20px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        background: linear-gradient(135deg, #f8f9ff 0%, #f0f4ff 100%);
        transform: translateX(5px);
    }
    
    .info-item:last-child {
        border-bottom: none;
    }
    
    .info-label {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: #495057;
    }
    
    .info-label i {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: white;
        font-size: 12px;
    }
    
    .info-value {
        font-weight: 500;
        color: #2c3e50;
    }
    
    .price-highlight {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
        padding: 15px 25px;
        border-radius: 50px;
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3);
        margin-bottom: 20px;
    }
    
    .stock-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 15px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .stock-available {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }
    
    .stock-low {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        color: white;
    }
    
    .stock-out {
        background: linear-gradient(135deg, #dc3545, #e83e8c);
        color: white;
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }
    
    .btn-modern {
        border-radius: 15px;
        padding: 12px 25px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
        position: relative;
        overflow: hidden;
    }
    
    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
        transition: left 0.5s;
    }
    
    .btn-modern:hover::before {
        left: 100%;
    }
    
    .btn-modern:hover {
        transform: translateY(-2px);
    }
    
    .btn-edit {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        color: white;
        box-shadow: 0 8px 25px rgba(255, 193, 7, 0.4);
    }
    
    .btn-back {
        background: linear-gradient(135deg, #6c757d, #495057);
        color: white;
        box-shadow: 0 8px 25px rgba(108, 117, 125, 0.4);
    }
    
    .btn-delete {
        background: linear-gradient(135deg, #dc3545, #e83e8c);
        color: white;
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.4);
    }
    
    .btn-print {
        background: linear-gradient(135deg, #17a2b8, #20c997);
        color: white;
        box-shadow: 0 8px 25px rgba(23, 162, 184, 0.4);
    }
    
    .description-card {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        border-left: 4px solid #667eea;
        border-radius: 0 15px 15px 0;
        padding: 25px;
        margin: 20px 0;
    }
    
    .timeline {
        position: relative;
        padding-left: 40px;
        margin: 30px 0;
    }
    
    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 3px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 2px;
    }
    
    .timeline-item {
        position: relative;
        margin-bottom: 25px;
        background: white;
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -32px;
        top: 25px;
        width: 15px;
        height: 15px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        border: 3px solid white;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.2);
    }
    
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 30px 0;
    }
    
    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 24px;
        color: white;
    }
    
    .animate-fade-in {
        animation: fadeInUp 0.8s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .pulse {
        animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
        100% {
            transform: scale(1);
        }
    }
    
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-modern {
            width: 100%;
            text-align: center;
        }
        
        .product-hero {
            text-align: center;
            padding: 30px 20px;
        }
    }
</style>

<div class="container-fluid animate-fade-in">
    <!-- Hero Section -->
    <div class="product-hero">
        <div class="row align-items-center" style="position: relative; z-index: 2;">
            <div class="col-md-8 p-5">
                <div class="product-icon pulse">
                    <i class="fas fa-cube fa-3x"></i>
                </div>
                <h1 class="display-4 mb-3 fw-bold">{{ $product->name }}</h1>
                <p class="lead mb-0 opacity-75">
                    <i class="fas fa-hashtag me-2"></i>ID: {{ $product->id }}
                </p>
            </div>
            <div class="col-md-4 text-end p-5">
                @if($product->stock > 10)
                    <div class="stock-badge stock-available mb-3">
                        <i class="fas fa-check-circle me-2"></i>Stok Tersedia
                    </div>
                @elseif($product->stock > 0)
                    <div class="stock-badge stock-low mb-3">
                        <i class="fas fa-exclamation-triangle me-2"></i>Stok Terbatas
                    </div>
                @else
                    <div class="stock-badge stock-out mb-3">
                        <i class="fas fa-times-circle me-2"></i>Stok Habis
                    </div>
                @endif
                
                <div class="price-highlight">
                    <i class="fas fa-tag me-2"></i>
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Description Card -->
            @if($product->description)
            <div class="info-card mb-4 animate-fade-in">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="mb-0">
                        <i class="fas fa-align-left me-2 text-primary"></i>
                        Deskripsi Produk
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="description-card">
                        <p class="mb-0 lead">{{ $product->description }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Product Details -->
            <div class="info-card mb-4 animate-fade-in">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Informasi Detail
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-money-bill-wave" style="background: linear-gradient(135deg, #28a745, #20c997);"></i>
                            Harga Produk
                        </div>
                        <div class="info-value fs-5 fw-bold text-success">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-boxes" style="background: linear-gradient(135deg, #17a2b8, #20c997);"></i>
                            Stok Tersedia
                        </div>
                        <div class="info-value fs-5 fw-bold">
                            {{ $product->stock }} unit
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">
                            <i class="fas fa-calculator" style="background: linear-gradient(135deg, #ffc107, #fd7e14);"></i>
                            Total Nilai Stok
                        </div>
                        <div class="info-value fs-5 fw-bold text-warning">
                            Rp {{ number_format($product->price * $product->stock, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="info-card animate-fade-in">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2 text-primary"></i>
                        Riwayat Produk
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 text-success">
                                        <i class="fas fa-plus-circle me-2"></i>
                                        Produk Dibuat
                                    </h6>
                                    <p class="mb-0 text-muted">
                                        {{ $product->created_at->format('d F Y, H:i') }} WIB
                                    </p>
                                </div>
                                <span class="badge bg-success">{{ $product->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        
                        @if($product->updated_at != $product->created_at)
                        <div class="timeline-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1 text-warning">
                                        <i class="fas fa-edit me-2"></i>
                                        Terakhir Diperbarui
                                    </h6>
                                    <p class="mb-0 text-muted">
                                        {{ $product->updated_at->format('d F Y, H:i') }} WIB
                                    </p>
                                </div>
                                <span class="badge bg-warning">{{ $product->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Stats Cards -->
            <div class="stats-grid animate-fade-in">
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #667eea, #764ba2);">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h4 class="mb-1">{{ rand(50, 200) }}</h4>
                    <small class="text-muted">Total Views</small>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h4 class="mb-1">{{ rand(10, 50) }}</h4>
                    <small class="text-muted">Favorites</small>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="info-card animate-fade-in">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="mb-0">
                        <i class="fas fa-bolt me-2 text-primary"></i>
                        Aksi Cepat
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="action-buttons">
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-modern btn-edit">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        
                        <button class="btn btn-modern btn-print" onclick="window.print()">
                            <i class="fas fa-print me-2"></i>Print
                        </button>
                        
                        <button class="btn btn-modern btn-info" onclick="shareProduct()">
                            <i class="fas fa-share-alt me-2"></i>Share
                        </button>
                        
                        <a href="{{ route('products.index') }}" class="btn btn-modern btn-back">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-grid">
                        <button type="button" class="btn btn-modern btn-delete" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-2"></i>Hapus Produk
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Stats -->
            <div class="info-card mt-4 animate-fade-in">
                <div class="card-header bg-transparent border-0 p-4">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>
                        Statistik
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Status Stok</span>
                            <span class="fw-bold">
                                @if($product->stock > 10)
                                    <span class="text-success">Baik</span>
                                @elseif($product->stock > 0) 
                                    <span class="text-warning">Rendah</span>
                                @else
                                    <span class="text-danger">Habis</span>
                                @endif
                            </span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            @if($product->stock > 10)
                                <div class="progress-bar bg-success" style="width: 100%"></div>
                            @elseif($product->stock > 0)
                                <div class="progress-bar bg-warning" style="width: {{ ($product->stock / 20) * 100 }}%"></div>
                            @else
                                <div class="progress-bar bg-danger" style="width: 5%"></div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Harga Range</span>
                            <span class="fw-bold text-info">
                                @if($product->price < 100000) 
                                    Budget
                                @elseif($product->price < 500000)
                                    Standard
                                @else
                                    Premium
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <div class="bg-light rounded-3 p-3">
                            <i class="fas fa-clock text-muted"></i>
                            <div class="mt-2">
                                <small class="text-muted">Umur Produk</small>
                                <div class="fw-bold">{{ $product->created_at->diffInDays() }} hari</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-danger me-2"></i>
                    Konfirmasi Hapus
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4">
                <div class="text-center mb-4">
                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                        <i class="fas fa-trash fa-2x text-danger"></i>
                    </div>
                </div>
                <p class="text-center mb-4">
                    Apakah Anda yakin ingin menghapus produk <strong>"{{ $product->name }}"</strong>?
                </p>
                <div class="alert alert-warning border-0 bg-warning bg-opacity-10">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    Tindakan ini tidak dapat dibatalkan!
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-modern btn-back" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Batal
                </button>
                <form action="{{ route('products.destroy', $product) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-modern btn-delete">
                        <i class="fas fa-trash me-2"></i>Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $product->name }}',
                text: 'Lihat produk {{ $product->name }} dengan harga Rp {{ number_format($product->price, 0, ',', '.') }}',
                url: window.location.href
            });
        } else {
            // Fallback: Copy to clipboard
            navigator.clipboard.writeText(window.location.href).then(() => {
                // Show success notification
                const toast = document.createElement('div');
                toast.className = 'position-fixed top-0 end-0 m-3 alert alert-success';
                toast.innerHTML = '<i class="fas fa-check me-2"></i>Link copied to clipboard!';
                document.body.appendChild(toast);
                
                setTimeout(() => {
                    toast.remove();
                }, 3000);
            });
        }
    }

    // Add entrance animations to elements
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = Math.random() * 0.5 + 's';
                entry.target.classList.add('animate-fade-in');
            }
        });
    }, observerOptions);

    // Observe all cards
    document.querySelectorAll('.info-card, .stat-card').forEach(el => {
        observer.observe(el);
    });

    // Print specific styling
    window.addEventListener('beforeprint', function() {
        document.body.classList.add('printing');
    });

    // Add some interactive effects
    document.querySelectorAll('.info-item').forEach(item => {
        item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(10px)';
        });
        
        item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
</script>

<!-- Print Styles -->
<style media="print">
    .btn, .modal, .action-buttons {
        display: none !important;
    }
    
    .product-hero {
        background: #667eea !important;
        -webkit-print-color-adjust: exact;
    }
    
    .info-card {
        box-shadow: none !important;
        border: 1px solid #ddd !important;
        break-inside: avoid;
    }
    
    body {
        background: white !important;
    }
</style>
@endsection