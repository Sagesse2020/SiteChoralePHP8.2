<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Inscription') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #1f293a;
        }

        .container {
            position: relative;
            width: 256px;
            height: 256px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container span {
            position: absolute;
            left: 0;
            width: 32px;
            height: 6px;
            background: #2c4766;
            border-radius: 8px;
            transform-origin: 128px;
            transform: scale(2.2) rotate(calc(var(--i) * (360deg / 50)));
            animation: blink 3s linear infinite;
            animation-delay: calc(var(--i) * (3s / 50));
        }

        @keyframes blink {
            0% { background: #0ef; }
            25% { background: #2c4766; }
        }

        .login-box {
            position: absolute;
            width: 400px;
            padding: 40px;
            background: rgba(0,0,0,0.5);
            border-radius: 8px;
        }

        h2 {
            font-size: 2em;
            color: #0ef;
            text-align: center;
            margin-bottom: 20px;
        }

        .input-box {
            position: relative;
            margin: 25px 0;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            height: 50px;
            background: rgba(255,255,255,0.05);
            border: 2px solid #2c4766;
            outline: none;
            border-radius: 40px;
            font-size: 1em;
            color: #fff;
            padding: 0 20px;
            transition: .5s ease;
        }

        input:focus {
            border-color: #0ef;
            background: rgba(255,255,255,0.1);
        }

        label {
            position: absolute;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            font-size: 1em;
            color: #ccc;
            pointer-events: none;
            transition: .5s ease;
        }

        input:focus ~ label,
        input:valid ~ label {
            top: 1px;
            font-size: .8em;
            background: #1f293a;
            padding: 0 6px;
            color: #0ef;
        }

        .btn {
            width: 100%;
            height: 45px;
            background: #0ef;
            border: none;
            outline: none;
            border-radius: 40px;
            cursor: pointer;
            font-size: 1em;
            color: #1f313a;
            font-weight: 600;
        }

        .signup-link {
            text-align: center;
            margin: 20px 0 10px;
        }

        .signup-link a {
            font-size: 1em;
            color: #0ef;
            text-decoration: none;
            font-weight: 600;
        }

        .error {
            color: #ff4d4d;
            font-size: 0.8rem;
            margin-top: 5px;
            text-align: left;
            padding-left: 15px;
        }
    </style>
</head>
<body>
    <!-- Effet décoratif -->
    <div class="container">
        @for ($i = 1; $i <= 50; $i++)
            <span style="--i:{{ $i }}"></span>
        @endfor
    </div>

    <!-- Formulaire d'inscription -->
    <div class="login-box">
        <h2>Inscription</h2>
        <form action="{{ route('register') }}" method="POST">
            @csrf

            <div class="input-box">
                <input type="text" id="name" name="name" value="{{ old('name') }}">
                <label for="name">Nom</label>
                @error('name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-box">
                <input type="email" id="email" name="email" value="{{ old('email') }}">
                <label for="email">Email</label>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-box">
                <input type="password" id="password" name="password">
                <label for="password">Mot de passe</label>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="input-box">
                <input type="password" id="password_confirmation" name="password_confirmation">
                <label for="password_confirmation">Confirmer le mot de passe</label>
            </div>

            <button type="submit" class="btn">S'inscrire</button>

            <div class="signup-link">
                <p>Déjà un compte ? <a href="{{ route('login') }}">Connectez-vous</a></p>
            </div>
        </form>
    </div>
</body>
</html>
