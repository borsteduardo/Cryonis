<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cryonis RPG - Cadastro</title>
    
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
            flex: 1.2;
            background: linear-gradient(135deg, #1a0b2e, #4c1d95);
            
            /* PARA USAR A MESMA IMAGEM DA MONTANHA DO LOGIN: */
            /* Descomente a linha abaixo tirando as barras (//) */
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

        /* Container do Cadastro */
        .register-container {
            width: 100%;
            max-width: 380px;
        }

        h1 {
            font-size: 2.2rem;
            margin-bottom: 2rem; /* Margem um pouco menor para caber os 4 campos */
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .dot {
            color: #f472b6;
        }

        /* Campos de Input */
        .input-group {
            margin-bottom: 1.2rem;
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
            padding: 12px 16px; /* Padding um pouco menor para ajustar a altura */
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

        /* Botão Cadastrar */
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
            margin-top: 1rem;
            margin-bottom: 2rem;
        }

        .btn-submit:hover {
            opacity: 0.9;
            transform: translateY(-1px);
        }

        .login-link {
            display: block;
            text-align: center;
            font-size: 0.8rem;
            color: #a1a1aa;
            text-decoration: underline;
            transition: color 0.3s;
        }

        .login-link:hover {
            color: #fff;
        }
    </style>
</head>
<body>

    <div class="split-layout">
        <!-- LADO ESQUERDO: FORMULÁRIO -->
        <div class="left-side">
            <div class="register-container">
                
                <h1>Crie sua conta <span class="dot">.</span></h1>

                <!-- O Formulário aponta para a rota oficial de registro do Laravel -->
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="input-group">
                        <label>👤 Nome</label>
                        <input type="text" name="name" class="input-field" required autofocus>
                    </div>

                    <div class="input-group">
                        <label>✉ Email</label>
                        <input type="email" name="email" class="input-field" required>
                    </div>

                    <div class="input-group">
                        <label>🔒 Senha</label>
                        <input type="password" name="password" class="input-field" required>
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

        <!-- LADO DIREITO: ARTE DA MONTANHA -->
        <div class="right-side"></div>
    </div>

</body>
</html>