<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cryonis RPG - Login</title>
    
    <style>
        /* Reset e Fontes */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }

        body {
            background-color: #030303; /* Fundo preto do lado esquerdo */
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

        /* Lado Esquerdo (Formulário) */
        .left-side {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        /* Lado Direito (Imagem) */
        .right-side {
            flex: 1.2; /* Ocupa um pouco mais de espaço na tela grande */
            background: linear-gradient(135deg, #1a0b2e, #4c1d95); /* Fundo caso a imagem não carregue */
            
            /* PARA COLOCAR A SUA IMAGEM DA MONTANHA: */
            /* 1. Salve a imagem na pasta public/images/ do seu projeto com o nome bg-login.jpg */
            /* 2. Descomente a linha abaixo tirando as barras (//) */
            /* background-image: url('/images/bg-login.jpg'); */
            
            background-size: cover;
            background-position: center;
            display: none; /* Esconde no celular */
        }

        /* Mostra a imagem em telas maiores que um tablet */
        @media (min-width: 768px) {
            .right-side {
                display: block;
            }
        }

        /* Container do Login */
        .login-container {
            width: 100%;
            max-width: 380px;
        }

        h1 {
            font-size: 2.2rem;
            margin-bottom: 2.5rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .dot {
            color: #f472b6; /* Ponto rosa */
        }

        /* Campos de Input */
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
            border: 1px solid #4c1d95; /* Borda roxa escura */
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

        /* Links */
        .forgot-link {
            display: block;
            text-align: right;
            font-size: 0.8rem;
            color: #a1a1aa;
            text-decoration: underline;
            margin-bottom: 2rem;
            transition: color 0.3s;
        }

        .forgot-link:hover, .register-link:hover {
            color: #fff;
        }

        /* Botão Entrar */
        .btn-submit {
            width: 100%;
            padding: 14px;
            /* Degradê exato do seu print: Roxo > Rosa > Pêssego */
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

        .register-link {
            display: block;
            text-align: center;
            font-size: 0.8rem;
            color: #a1a1aa;
            text-decoration: underline;
        }
    </style>
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