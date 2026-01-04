@extends('layouts.app')

@section('title', 'Inicio - Tu Mercado SENA')

@section('styles')
<style>
    /* Search Bar Section */
    .search-section-wrapper {
        background: #f0f2f5;
        padding: 20px 0;
        border-bottom: 1px solid #e0e0e0;
    }
    .search-container-bar {
        max-width: 1000px;
        margin: 0 auto;
        background: white;
        border-radius: 8px;
        border: 1px solid #ccc;
        padding: 5px;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .search-input {
        flex: 2;
        border: none;
        padding: 10px 15px;
        font-size: 1rem;
        outline: none;
        color: #555;
    }
    .search-category {
        flex: 1;
        border: none;
        border-left: 1px solid #eee;
        padding: 10px 15px;
        font-size: 1rem;
        color: #555;
        outline: none;
        background: transparent;
        cursor: pointer;
    }
    .search-btn {
        background: #aabcc3; /* Match screenshot greyish-blue */
        color: #333;
        border: none;
        padding: 8px 25px;
        border-radius: 5px;
        font-weight: 600;
        cursor: pointer;
        margin-left: 5px;
        transition: background 0.3s;
    }
    .search-btn:hover {
        background: #95aab3;
    }
</style>
@endsection

@section('content')
    <!-- Search Bar Section -->
    <div class="search-section-wrapper">
        <form action="{{ route('welcome') }}" method="GET">
            <div class="search-container-bar">
                <input type="text" name="search" class="search-input" placeholder="Buscar productos...">
                
                <select name="category" class="search-category">
                    <option value="">Categorías</option>
                    <option value="1">Tecnología</option>
                    <option value="2">Ropa</option>
                    <option value="3">Hogar</option>
                </select>

                <button type="submit" class="search-btn">Buscar</button>
            </div>
        </form>
    </div>

    <main class="main container">
        @if($products->isEmpty())
            <div style="text-align: center; padding: 50px; background: white; border-radius: 15px; box-shadow: var(--shadow); margin-top: 20px;">
                <i class="fas fa-box-open" style="font-size: 50px; color: var(--color-primary); margin-bottom: 20px;"></i>
                <h2>No hay productos aún</h2>
                <p>Sé el primero en publicar un producto.</p>
                <a href="{{ route('products.create') }}" class="btn-primary" style="display:inline-block; margin-top:15px;">Publicar Producto</a>
            </div>
        @else
            <div class="products-grid">
                @foreach($products as $product)
                <div class="product-card">
                    <div class="product-image placeholder">
                        <i class="fas fa-image"></i>
                    </div>
                    <a href="{{ route('products.show', $product->id) }}">
                        <div class="product-info">
                            <h3 class="product-name">{{ $product->nombre }}</h3>
                            <div class="product-price">${{ number_format($product->precio, 0) }}</div>
                            <div class="product-seller">
                                <i class="fas fa-user-circle"></i> {{ $product->vendedor ? $product->vendedor->nickname : 'Vendedor' }}
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @endif
    </main>

    <footer class="welcome-footer">
        <p>&copy; {{ date('Y') }} Tu Mercado SENA - Todos los derechos reservados</p>
    </footer> --}}
@endsection
</html>
