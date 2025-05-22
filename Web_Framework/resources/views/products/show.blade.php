@extends('layouts.app')

@section('title', 'Detail Produk')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Detail Produk</h1>
            <div>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">Edit</a>
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                
                @if($product->description)
                    <p class="card-text">{{ $product->description }}</p>
                @endif

                <table class="table table-borderless">
                    <tr>
                        <td><strong>Harga:</strong></td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Stok:</strong></td>
                        <td>{{ $product->stock }} unit</td>
                    </tr>
                    <tr>
                        <td><strong>Dibuat:</strong></td>
                        <td>{{ $product->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <td><strong>Diperbarui:</strong></td>
                        <td>{{ $product->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                </table>

                <form action="{{ route('products.destroy', $product) }}" method="POST" class="mt-3">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" 
                            onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus Produk</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection