@extends('layouts.app')

@section('title', $product->nombre . ' - Tu Mercado SENA')

@section('styles')
    <style>
    /* Product Details Styles */
    .product-details-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        padding: 40px;
        display: flex;
        gap: 40px;
        flex-wrap: wrap;
        margin-top: 30px;
    }

    /* Left Column: Image */
    .product-image-section {
        flex: 1;
        min-width: 300px;
        max-width: 500px;
    }
    
    .main-image-container {
        width: 100%;
        padding-top: 100%; /* 1:1 Aspect Ratio */
        position: relative;
        background-color: #d1d9e0; /* Greyish background from screenshot */
        border-radius: 12px;
        overflow: hidden;
        cursor: zoom-in;
        margin-bottom: 15px;
    }

    .main-image-content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Thumbnails (Ghost UI for "Max 4 images") */
    .thumbnails-container {
        display: flex;
        gap: 10px;
    }
    .thumbnail {
        width: 70px;
        height: 70px;
        background: #f0f0f0;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 2px solid transparent;
    }
    .thumbnail.active {
        border-color: var(--color-primary);
    }
    .thumbnail i {
        color: #ccc;
    }

    /* Right Column: Details */
    .product-info-section {
        flex: 1;
        min-width: 300px;
    }

    .product-title {
        color: #538392;
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .product-price-lg {
        color: #7b99a6; /* Color from screenshot */
        font-size: 2.2rem;
        font-weight: 800;
        margin-bottom: 25px;
    }

    /* Metadata Box */
    .metadata-box {
        background: #eef3f5; /* Light grey/blue */
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 25px;
        border: 1px solid #e0e0e0;
    }
    
    .metadata-item {
        margin-bottom: 8px;
        font-size: 1rem;
        color: #444;
    }
    .metadata-label {
        font-weight: 700;
        color: #333;
    }

    .section-title {
        color: #538392;
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 15px;
        margin-top: 20px;
    }

    .product-description-text {
        color: #555;
        line-height: 1.6;
    }

    .seller-box {
        background: #dbe4e8; /* Slightly darker grey from screenshot */
        padding: 15px 20px;
        border-radius: 10px;
        margin-top: 25px;
        font-weight: 600;
        color: #333;
    }

    /* Buttons row */
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
    }

    .btn-favorite {
        background: #f5f5f5;
        border: 1px solid #ddd;
        color: #555;
        padding: 10px 20px;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 600;
        transition: all 0.2s;
    }
    .btn-favorite:hover {
        background: #eee;
    }

    .btn-contact {
        background: #849ca5;
        color: white;
        border: none;
        padding: 10px 25px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: background 0.2s;
    }
    .btn-contact:hover {
        background: #6f858e;
    }

    /* Zoom Overlay */
    .zoom-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.9);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }
    .zoom-overlay img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
    }
    .zoom-close {
        position: absolute;
        top: 20px;
        right: 20px;
        color: white;
        font-size: 3rem;
        cursor: pointer;
    }
    </style>
@endsection

@section('content')
    <main class="main container">
        
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif
        @if(session('info'))
            <div style="background: #cce5ff; color: #004085; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('info') }}
            </div>
        @endif

        <div class="product-details-container">
            <!-- Left: Images -->
            <div class="product-image-section">
                <div class="main-image-container" onclick="openZoom()">
                    <div class="main-image-content">
                        @if($product->image)
                             <img id="zoomImageSrc" src="{{ $product->image }}" alt="{{ $product->nombre }}" style="max-width:80%; max-height:80%;">
                        @else
                             <!-- Placeholder Bag Icon from screenshot -->
                             <i class="fas fa-shopping-bag" style="font-size: 150px; color: white; text-shadow: 0 5px 15px rgba(0,0,0,0.1);"></i>
                        @endif
                    </div>
                </div>
                
                <!-- Thumbnails (Visual Only) -->
                <div class="thumbnails-container">
                    <div class="thumbnail active">
                        @if($product->image) <img src="{{ $product->image }}" style="width:100%; height:100%; object-fit:cover; border-radius:6px;"> @else <i class="fas fa-image"></i> @endif
                    </div>
                    <div class="thumbnail"><i class="fas fa-plus"></i></div>
                    <div class="thumbnail"><i class="fas fa-plus"></i></div>
                    <div class="thumbnail"><i class="fas fa-plus"></i></div>
                </div>
            </div>

            <!-- Right: Details -->
            <div class="product-info-section">
                <h1 class="product-title">{{ $product->nombre }}</h1>
                <div class="product-price-lg">{{ number_format($product->precio, 0, ',', '.') }} COP</div>

                <div class="metadata-box">
                    <div class="metadata-item"><span class="metadata-label">Categoría:</span> {{ $product->subcategoria_id }} (Simulado)</div>
                    <div class="metadata-item"><span class="metadata-label">Condición:</span> Nuevo</div>
                    <div class="metadata-item"><span class="metadata-label">Disponibles:</span> {{ $product->disponibles }}</div>
                    <div class="metadata-item"><span class="metadata-label">Publicado:</span> {{ $product->created_at->format('d/m/Y') }}</div>
                </div>

                <div class="section-title">Descripción</div>
                <p class="product-description-text">
                    {{ $product->descripcion }}
                </p>

                <div class="seller-box">
                    Vendedor <br>
                    <span style="font-weight:400">{{ $product->vendedor ? $product->vendedor->nickname : 'Usuario' }}</span>
                </div>

                <div class="action-buttons">
                    @if(Auth::user()->usuario && Auth::user()->usuario->id != $product->vendedor_id)
                    <form action="{{ route('favorites.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="seller_id" value="{{ $product->vendedor_id }}">
                        <button type="submit" class="btn-favorite">
                            <i class="fas fa-heart" style="color: #ff6b6b;"></i> Añadir a Favoritos
                        </button>
                    </form>
                    @endif
                    <button class="btn-contact">Contactar Vendedor</button>
                </div>
            </div>
        </div>
    </main>
    
    <!-- Toast Messages -->
    @if(session('success'))
        <div style="position:fixed; bottom:20px; right:20px; background:#4caf50; color:white; padding:15px 25px; border-radius:8px; box-shadow:0 4px 12px rgba(0,0,0,0.2); animation: fadeInUp 0.5s;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Zoom Overlay -->
    <div class="zoom-overlay" id="zoomOverlay" onclick="closeZoom()">
        <span class="zoom-close">&times;</span>
        <img id="zoomImg" src="">
    </div>

    <script>
        function openZoom() {
            // Get source from the rendered image or use placeholder logic
            // Since we use background icon for placeholder, we might not have a src for 'zoomImg' if no image exists.
            // Simplified: Only zoom if there is an image.
            
            const img = document.getElementById('zoomImageSrc');
            if(img) {
                document.getElementById('zoomImg').src = img.src;
                document.getElementById('zoomOverlay').style.display = 'flex';
            }
        }

        function closeZoom() {
            document.getElementById('zoomOverlay').style.display = 'none';
        }
    </script>
@endsection
