<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cryonis RPG - Login</title>
    
    </head>
<body>

    <div class="split-layout">
        <div class="left-side">
            <div class="login-container">
                
                <h1>Faça seu login<span class="dot">.</span></h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-group">
                        <label>✉ Email</label>
                        <input type="email" name="email" class="input-field" required autofocus>
                    </div>

                    <div class="input-group">
                        <label>🔒 Senha</label>
                        <input type="password" name="password" class="input-field" required>
                    </div>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">? Esqueci minha senha</a>
                    @endif

                    <button type="submit" class="btn-submit">Entrar</button>
                </form>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="register-link">Ainda não tenho uma conta 👤</a>
                @endif

            </div>
        </div>

        <div class="right-side"></div>
    </div>

</body>
</html>