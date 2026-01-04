@extends('layouts.app')

@section('title', 'Perfil - Tu Mercado SENA')

@section('styles')
    <style>
        /* Specific styles for Profile Page */
        .profile-layout {
            display: flex;
            gap: 30px;
            margin-top: 40px;
            flex-wrap: wrap;
        }

        .sidebar {
            flex: 0 0 250px;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            height: fit-content;
            border: 1px solid #e0e0e0;
        }

        .sidebar-menu {
            list-style: none;
        }

        .sidebar-menu li {
            margin-bottom: 5px;
        }

        .sidebar-menu a {
            display: block;
            padding: 12px 15px;
            color: #555;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .sidebar-menu a:hover {
            background: #f5f7f9;
            color: var(--color-primary);
        }

        .sidebar-menu a.active {
            background: #dbe4e8; /* Active grey/blue */
            color: #333;
            font-weight: 600;
        }

        .profile-content {
            flex: 1;
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid #e0e0e0;
            min-width: 300px;
        }

        .profile-header-title {
            color: #538392;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        /* Avatar Section */
        .avatar-section {
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
            position: relative;
        }
        .avatar-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #fff;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            position: relative;
            background: #eee;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .edit-avatar-badge {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: var(--color-primary);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            border: 2px solid white;
            cursor: pointer;
        }

        /* Form Styles */
        .section-label {
            color: #7b99a6;
            font-weight: 700;
            margin-bottom: 20px;
            font-size: 1.1rem;
        }

        .form-group-profile {
            margin-bottom: 25px;
        }
        .form-group-profile label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: #555;
            font-size: 0.95rem;
        }
        .form-group-profile input, 
        .form-group-profile textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            color: #333;
            outline: none;
            transition: border 0.3s;
        }
        .form-group-profile input:focus, 
        .form-group-profile textarea:focus {
            border-color: var(--color-primary);
        }
        .form-group-profile input.readonly {
            background: #f9f9f9;
            color: #777;
            cursor: not-allowed;
        }
        .helper-text {
            font-size: 0.85rem;
            color: #888;
            margin-top: 5px;
        }
        
        .btn-save {
            background: linear-gradient(135deg, #6c8a94 0%, #538392 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            font-size: 1rem;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(83, 131, 146, 0.3);
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

        <div class="profile-layout">
            <!-- Sidebar -->
            <aside class="sidebar">
                <ul class="sidebar-menu">
                    <li><a href="#" class="active">Información Personal</a></li>
                    <li><a href="#">Configuración</a></li>
                    <li><a href="#">Seguridad</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" id="logout-form">
                            @csrf
                            <a href="#" onclick="document.getElementById('logout-form').submit()">Cerrar sesión</a>
                        </form>
                    </li>
                </ul>
            </aside>

            <!-- Main Content -->
            <div class="profile-content">
                <h2 class="profile-header-title">Información Personal</h2>

                <!-- Avatar -->
                <div class="avatar-section">
                    <div class="avatar-circle">
                         @if(Auth::user()->usuario && Auth::user()->usuario->imagen != 'default.png')
                            <img src="{{ asset('storage/'.Auth::user()->usuario->imagen) }}" alt="Profile" style="width:100%; height:100%; object-fit:cover;">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->usuario->nickname }}&background=random&size=128" alt="Profile" style="width:100%; height:100%; object-fit:cover;">
                        @endif
                        <div class="edit-avatar-badge">
                            <i class="fas fa-pen"></i>
                        </div>
                    </div>
                </div>

                <div class="section-label">Datos Básicos</div>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group-profile">
                        <label>Nombre de Usuario *</label>
                        <input type="text" name="nickname" value="{{ old('nickname', $usuario->nickname) }}" required>
                    </div>

                    <div class="form-group-profile">
                        <label>Correo Electrónico</label>
                        <input type="email" class="readonly" value="{{ $user->email }}" readonly>
                        <div class="helper-text">El correo no se puede cambiar</div>
                    </div>

                    <div class="form-group-profile">
                        <label>Descripción</label>
                        <textarea name="descripcion" rows="4">{{ old('descripcion', $usuario->descripcion) }}</textarea>
                    </div>

                    <div class="form-group-profile">
                        <label>Enlace (Redes sociales, sitio web, etc.)</label>
                        <input type="url" name="link" value="{{ old('link', $usuario->link) }}" placeholder="https://...">
                        <div class="helper-text">Comparte tus redes sociales o sitio web</div>
                    </div>

                    <div style="border-top: 1px solid #eee; margin: 30px 0;"></div>

                    <button type="submit" class="btn-save">Guardar Cambios</button>
                </form>
            </div>
        </div>
    </main>
@endsection
