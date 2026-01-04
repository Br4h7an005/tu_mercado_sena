@extends('layouts.app')

@section('title', 'Publicar Producto - Tu Mercado SENA')

@section('styles')
<style>
    /* Ensure form styles match the theme */
    .auth-box {
        background: white;
        padding: 40px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        border: 1px solid #e0e0e0;
    }
</style>
@endsection

@section('content')
    <main class="main container">
        <div class="auth-box" style="max-width: 600px; margin: 0 auto;">
            <h1 class="auth-title" style="color: var(--color-primary); font-size: 2rem;">Publicar Producto</h1>
            
            <form action="{{ route('products.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Nombre del Producto</label>
                    <input type="text" name="nombre" required>
                </div>
                
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="descripcion" rows="4" style="width:100%; padding:10px; border-radius:10px; border:1px solid #ccc;" required></textarea>
                </div>

                <div style="display: flex; gap: 15px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Precio</label>
                        <input type="number" name="precio" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Disponibles</label>
                        <input type="number" name="disponibles" value="1" min="1" required>
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%;">Publicar Ahora</button>
            </form>
        </div>
    </main>
@endsection
