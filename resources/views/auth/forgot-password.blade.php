<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cryonis RPG - Recuperar Senha</title>
    
    <style>
        /* Reset e Fontes */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #030303;
            color: #ffffff;
            min-height: 100vh;
            display: flex;
        }

        /* Layout Dividido */
        .split-layout {
            display: flex;
            width: 100%;
            min-height: 100vh;
        }

        .left-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .right-side {
            flex: 1.2;
            background: linear-gradient(135deg, #1a0b2e, #4c1d95);
            /* background-image: url('/images/bg-login.jpg'); */
            background-size: cover;
            background-position: center;
            display: none;
        }

        @media (min-width: 768px) {
            .right-side {
                display: block;
            }
        }

        .reset-container {
            width: 100%;
            max-width: 380px;
        }

        h1 {
            font-size: 2.2rem;
            margin-bottom: 1rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .dot {
            color: #f472b6;
        }
        
        .description {
            font-size: 0.9rem;
            color: #a1a1aa;
            margin-bottom: 2rem;
            line-height: 1.5;
        }

        /* Mensagem de Sucesso (Quando o email é enviado) */
        .status-message {
            background-color: rgba(16, 185, 129, 0.1);
            border: 1px solid #10b981;
            color: #34d399;
            padding: 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: #a1a1aa;
            margin-bottom: 0.5rem;
        }

        .input-field {
            width: 100%;
            padding: 14px 16px;
            background-color: #09090b;
            border: 1px solid #4c1d95;
            border-radius: 8px;
            color: #fff;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
        }

        .input-field:focus {
            border-color: #8b5cf6;
            box-shadow: 0 0 10px rgba(139, 92, 246, 0.3);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(90deg, #6d28d9, #db2777, #fca5a5); 
            border: none;
            border-radius: 8px;
            color: #fff;
            font-weight: bold;
            font-size: 1rem;
            cursor: pointer;
            transition: opacity 0.3s, transform 0.2s;
            margin-bottom: 2rem;
        }

        .btn-submit:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .login-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-size: 0.85rem;
            color: #a1a1aa;
            text-decoration: none;
            transition: color 0.3s;
        }

        .login-link:hover {
            color: #fff;
        }
    </style>
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