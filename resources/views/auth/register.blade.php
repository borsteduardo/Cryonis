<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cryonis RPG - Cadastro</title>
    
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