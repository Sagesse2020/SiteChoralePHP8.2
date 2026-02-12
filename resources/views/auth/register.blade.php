<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Inscription') }}</title>

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

        .register-container {
            width: 100%;
            max-width: 450px;
            background: var(--card);
            padding: 40px 30px;
            border-radius: 14px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }

        h2 {
            text-align: center;
            color: var(--primary);
            margin-bottom: 30px;
        }

        .form-group {
            position: relative;
            margin-bottom: 22px;
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
            margin-top: 10px;
        }

        .btn:hover {
            background: #00cfd0;
        }

        .login-link {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9rem;
            color: var(--text);
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
        }

        .error {
            margin-top: 6px;
            font-size: 0.75rem;
            color: var(--danger);
            padding-left: 15px;
        }

        @media (max-width: 480px) {
            .register-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>

<div class="register-container">
    <h2>Inscription</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nom -->
        <div class="form-group">
            <input type="text" name="name" value="{{ old('name') }}" required>
            <label>Nom</label>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div class="form-group">
            <input type="email" name="email" value="{{ old('email') }}" required>
            <label>Email</label>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Mot de passe -->
        <div class="form-group password-wrapper">
            <input type="password" id="password" name="password" required>
            <label>Mot de passe</label>
            <i class="fas fa-eye toggle-password" onclick="togglePassword('password', this)"></i>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirmation -->
        <div class="form-group password-wrapper">
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            <label>Confirmer le mot de passe</label>
            <i class="fas fa-eye toggle-password" onclick="togglePassword('password_confirmation', this)"></i>
        </div>

        <button type="submit" class="btn">S'inscrire</button>

        <div class="login-link">
            Déjà un compte ?
            <a href="{{ route('login') }}">Se connecter</a>
        </div>
    </form>
</div>

<script>
    function togglePassword(fieldId, icon) {
        const input = document.getElementById(fieldId);

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
