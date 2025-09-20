<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.site','Laravel'))</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">


    <style>
        /* Layout pantalla completa */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        .login-wrapper {
            min-height: 100vh;
            display: flex;
            flex-wrap: wrap;
        }

        /* Panel izquierdo con imagen de fondo */
        .login-left {
            flex: 1 1 50%;
            background: url('https://images.unsplash.com/photo-1505692794403-34d4982d7b91?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
        }

        .login-overlay {
            background: rgba(0, 0, 0, .4);
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
        }

        .login-overlay h1 {
            font-size: 2.5rem;
            font-weight: 700;
        }

        /* Panel derecho con formulario */
        .login-right {
            flex: 1 1 50%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }
    </style>
<body>
    <div class="login-wrapper">
        {{-- Panel con imagen / slogan --}}
        <div class="login-left">
            <div class="login-overlay">
                <div>
                    <h1>{{ config('app.site') }}</h1>
                    <p class="lead">Bienvenido a nuestro portal de propiedades</p>
                </div>
            </div>
        </div>

        {{-- Panel de formulario --}}
        <div class="login-right">
            <div class="login-card">
                <h2 class="mb-4 text-center">Iniciar sesión</h2>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" required>
                        @error('password')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Recordarme</label>
                        </div>
                        @if (Route::has('password.request'))
                        <a class="small text-decoration-none" href="{{ route('password.request') }}">
                            ¿Olvidó su contraseña?
                        </a>
                        @endif
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">Ingresar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>