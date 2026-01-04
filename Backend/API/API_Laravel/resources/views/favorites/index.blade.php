@extends('layouts.app')

@section('title', 'Mis Favoritos - Tu Mercado SENA')

@section('content')
    <main class="main container">
        <div class="page-header">
            <h1>Vendedores Favoritos</h1>
            <a href="{{ route('welcome') }}" class="btn-secondary">Volver al Inicio</a>
        </div>

        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if($favorites->isEmpty())
            <div style="text-align: center; padding: 50px; background: white; border-radius: 15px; box-shadow: var(--shadow);">
                <i class="fas fa-heart-broken" style="font-size: 50px; color: #ccc; margin-bottom: 20px;"></i>
                <h2>No tienes favoritos aún</h2>
                <p>Explora productos y agrégalos a tus favoritos.</p>
                <a href="{{ route('welcome') }}" class="btn-primary" style="display:inline-block; margin-top:15px;">Explorar Productos</a>
            </div>
        @else
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px;">
                @foreach($favorites as $fav)
                    <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: var(--shadow); display: flex; flex-direction: column; align-items: center; text-align: center;">
                        <div style="width: 80px; height: 80px; background: var(--color-secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: white; margin-bottom: 15px;">
                            {{ strtoupper(substr($fav->votado->nickname ?? 'U', 0, 1)) }}
                        </div>
                        <h3 style="margin-bottom: 5px; color: var(--color-primary);">{{ $fav->votado->nickname ?? 'Usuario Desconocido' }}</h3>
                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 20px;">
                            <i class="fas fa-envelope"></i> {{ $fav->votado->cuenta->email ?? 'Sin correo' }}
                        </p>
                        
                        <div style="display: flex; gap: 10px; width: 100%;">
                            {{-- Botón ver perfil (futuro) --}}
                            <button class="btn-secondary" style="flex: 1; font-size: 0.9rem;">
                                <i class="fas fa-user"></i> Ver Perfil
                            </button>
                            
                            {{-- Botón eliminar --}}
                            <form action="{{ route('favorites.destroy', $fav->votado_id) }}" method="POST" style="flex: 1;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-primary" style="width: 100%; background: #dc3545; font-size: 0.9rem;">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>
@endsection
