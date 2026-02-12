<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Connexion') }}</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

    <style>
        :root {
            --primary: #0ef;
            --bg: #1f293a;
            --card: rgba(0,0,0,0.55);
            --border: #2c4766;
            --text: #ffffff;
            --muted: #cccccc;
            --danger: #ff4d4d;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1f293a, #111827);
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 420px;
            background: var(--card);
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        h2 {
            text-align: center;
            color: var(--primary);
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 22px;
            position: relative;
        }

        .form-group input {
            width: 100%;
            height: 48px;
            border-radius: 30px;
            border: 2px solid var(--border);
            background: rgba(255,255,255,0.05);
            padding: 0 18px;
            font-size: 0.95rem;
            color: var(--text);
            outline: none;
            transition: 0.3s;
        }

        .form-group input:focus {
            border-color: var(--primary);
            background: rgba(255,255,255,0.1);
        }

        .form-group label {
            position: absolute;
            top: 50%;
            left: 18px;
            transform: translateY(-50%);
            font-size: 0.9rem;
            color: var(--muted);
            pointer-events: none;
            transition: 0.3s;
            background: transparent;
        }

        .form-group input:focus ~ label,
        .form-group input:valid ~ label {
            top: -8px;
            font-size: 0.75rem;
            padding: 0 6px;
            background: var(--bg);
            color: var(--primary);
        }

        /* Password eye */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--muted);
            font-size: 1rem;
        }

        .toggle-password:hover {
            color: var(--primary);
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.85rem;
            color: var(--text);
            margin-bottom: 10px;
        }

        .forgot {
            text-align: right;
            margin-bottom: 20px;
        }

        .forgot a {
            font-size: 0.85rem;
            color: var(--text);
            text-decoration: none;
        }

        .forgot a:hover {
            color: var(--primary);
        }

        .btn {
            width: 100%;
            height: 46px;
            border-radius: 30px;
            border: none;
            background: var(--primary);
            color: #001a1a;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #00cfd0;
        }

        .signup {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9rem;
            color: var(--text);
        }

        .signup a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .error {
            background: rgba(255,77,77,0.1);
            border: 1px solid var(--danger);
            color: var(--danger);
            padding: 10px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 15px;
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">
    <h2>Connexion</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Email -->
        <div class="form-group">
            <input type="email" name="email" value="{{ old('email') }}" required>
            <label>Email</label>
        </div>

        <!-- Password -->
        <div class="form-group password-wrapper">
            <input type="password" name="password" id="password" required>
            <label>Mot de passe</label>
            <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
        </div>

        <!-- Remember -->
        <div class="remember">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <span>Se souvenir de moi</span>
        </div>

        <!-- Forgot -->
        <div class="forgot">
            <a href="{{ route('password.request') }}">Mot de passe oublié ?</a>
        </div>

        <button type="submit" class="btn">Se connecter</button>

        <div class="signup">
            Pas encore de compte ?
            <a href="{{ route('register') }}">Créer un compte</a>
        </div>
    </form>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.querySelector('.toggle-password');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.replace('fa-eye-slash', 'fa-eye');
        }
    }
</script>

</body>
</html>
