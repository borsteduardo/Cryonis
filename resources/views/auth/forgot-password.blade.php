<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cryonis RPG - Recuperar Senha</title>
    
    </head>
<body>

    <div class="split-layout">
        <div class="left-side">
            <div class="reset-container">
                
                <h1>Recuperar Senha <span class="dot">.</span></h1>
                
                <p class="description">
                    Esqueceu sua senha? Sem problemas. Informe o seu endereço de e-mail e nós enviaremos um link para você criar uma nova.
                </p>

                <!-- Status de Sessão (Aparece quando o email é enviado com sucesso) -->
                @if (session('status'))
                    <div class="status-message">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="input-group">
                        <label>✉ Email da Conta</label>
                        <input type="email" name="email" class="input-field" value="{{ old('email') }}" required autofocus>
                        @error('email')
                            <span style="color: #ef4444; font-size: 0.8rem; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">Enviar Link de Recuperação</button>
                </form>

                <a href="{{ route('login') }}" class="login-link">
                    <span>⬅</span> Voltar para o Login
                </a>

            </div>
        </div>

        <div class="right-side"></div>
    </div>

</body>
</html>