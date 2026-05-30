<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cryonis RPG - Cadastro</title>
    
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        body { background-color: #030303; color: #ffffff; min-height: 100vh; display: flex; }
        .split-layout { display: flex; width: 100%; min-height: 100vh; }
        .left-side { flex: 1; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 2rem; }
        .right-side { flex: 1.2; background: linear-gradient(135deg, #1a0b2e, #4c1d95); background-size: cover; background-position: center; display: none; }
        @media (min-width: 768px) { .right-side { display: block; } }
        
        .register-container { width: 100%; max-width: 380px; }
        h1 { font-size: 2.2rem; margin-bottom: 2rem; font-weight: 700; letter-spacing: 0.5px; }
        .dot { color: #f472b6; }

        .input-group { margin-bottom: 1.2rem; }
        .input-group label { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; color: #a1a1aa; margin-bottom: 0.5rem; }
        
        .input-field { width: 100%; padding: 12px 16px; background-color: #09090b; border: 1px solid #4c1d95; border-radius: 8px; color: #fff; font-size: 1rem; outline: none; transition: all 0.3s ease; }
        .input-field:focus { border-color: #8b5cf6; box-shadow: 0 0 10px rgba(139, 92, 246, 0.3); }

        /* ESTILO DO ERRO */
        .error-msg { color: #f87171; font-size: 0.75rem; margin-top: 0.25rem; display: block; }
        .input-field.has-error { border-color: #f87171; }

        .btn-submit { width: 100%; padding: 14px; background: linear-gradient(90deg, #6d28d9, #db2777, #fca5a5); border: none; border-radius: 8px; color: #fff; font-weight: bold; font-size: 1rem; cursor: pointer; transition: opacity 0.3s, transform 0.2s; margin-top: 1rem; margin-bottom: 2rem; }
        .btn-submit:hover { opacity: 0.9; transform: translateY(-1px); }
        .login-link { display: block; text-align: center; font-size: 0.8rem; color: #a1a1aa; text-decoration: underline; transition: color 0.3s; }
        .login-link:hover { color: #fff; }
    </style>
</head>
<body>

    <div class="split-layout">
        <div class="left-side">
            <div class="register-container">
                
                <h1>Crie sua conta <span class="dot">.</span></h1>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="input-group">
                        <label>👤 Nome</label>
                        <input type="text" name="name" class="input-field {{ $errors->has('name') ? 'has-error' : '' }}" value="{{ old('name') }}" required autofocus>
                        @if ($errors->has('name'))
                            <span class="error-msg">{{ $errors->first('name') }}</span>
                        @endif
                    </div>

                    <div class="input-group">
                        <label>✉ Email</label>
                        <input type="email" name="email" class="input-field {{ $errors->has('email') ? 'has-error' : '' }}" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="error-msg">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="input-group">
                        <label>🔒 Senha</label>
                        <input type="password" name="password" class="input-field {{ $errors->has('password') ? 'has-error' : '' }}" required>
                        @if ($errors->has('password'))
                            <span class="error-msg">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="input-group">
                        <label>🔐 Confirmar Senha</label>
                        <input type="password" name="password_confirmation" class="input-field" required>
                    </div>

                    <button type="submit" class="btn-submit">Cadastrar</button>
                </form>

                <a href="{{ route('login') }}" class="login-link">Já tenho uma conta ➡</a>
            </div>
        </div>
        <div class="right-side"></div>
    </div>
</body>
</html>