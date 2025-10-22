<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un utilisateur</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            background-color: #f0f8ff;
            margin: 0;
            padding: 2rem 0;
            min-height: 100vh;
        }

        .register-container {
            width: 100%;
            max-width: 480px;
            background-color: #fff;
            padding: 2rem;
            border: 1px solid #d0d7de;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }

        h2 { color: #0044cc; text-align: center; margin-bottom: 1.5rem; }
        label { display: block; margin: 0.5rem 0 0.2rem; color: #333; font-weight: bold; }
        input, select {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 0.8rem;
            border: 1px solid #0044cc;
            border-radius: 6px;
            outline: none;
            transition: 0.2s;
        }
        input:focus, select:focus { border-color: #007bff; box-shadow: 0 0 4px rgba(0,123,255,0.4); }

        .btn {
            width: 100%;
            padding: 0.9rem;
            background-color: #0044cc;
            color: #fff;
            font-weight: bold;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: 0.3s;
        }
        .btn:hover { background-color: #002f80; }

        .error { color: red; font-size: 0.9rem; margin-bottom: 0.8rem; }
        .success { color: green; font-size: 0.95rem; margin-bottom: 1rem; text-align: center; }

        .roles-info {
            background-color: #e9f3ff;
            border-left: 4px solid #0044cc;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 6px;
            font-size: 0.9rem;
            color: #333;
        }
        .roles-info h4 { color: #0044cc; margin-top: 0; }
        .roles-info ul { padding-left: 20px; margin-top: 0.5rem; }
        .roles-info li { margin-bottom: 0.3rem; }
    </style>
</head>
<body>
    <div class="register-container">
    <h2>Créer un nouvel utilisateur</h2>

    @if(session('success')) <p class="success">{{ session('success') }}</p> @endif
    @if(session('error')) <p class="error">{{ session('error') }}</p> @endif

    <div class="roles-info">
        <h4>🧩 Rôles disponibles</h4>
        <ul>
            <li>Utilisateur : accès limité.</li>
            <li>Administrateur : accès complet selon le niveau.</li>
        </ul>
        <h4>🏆 Niveaux d’Administrateur</h4>
        <ul>
            <li>Niveau 1 : Admin junior.</li>
            <li>Niveau 2 : Admin intermédiaire.</li>
            <li>Niveau 3 : Super admin.</li>
        </ul>
    </div>

    @php
        $currentUserNiveau = Auth::check() && Auth::user()->role === 'admin' ? Auth::user()->niveau_admin : 0;
    @endphp

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <label for="name">Nom complet :</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
        @error('name') <p class="error">{{ $message }}</p> @enderror

        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        @error('email') <p class="error">{{ $message }}</p> @enderror

        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        @error('password') <p class="error">{{ $message }}</p> @enderror

        <label for="password_confirmation">Confirmer le mot de passe :</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
        @error('password_confirmation') <p class="error">{{ $message }}</p> @enderror

        <label for="role">Rôle :</label>
        <select name="role" id="role" required>
            <option value="user" {{ old('role')=='user'?'selected':'' }}>Utilisateur</option>
            @if($currentUserNiveau > 0)
                <option value="admin" {{ old('role')=='admin'?'selected':'' }}>Administrateur</option>
            @endif
        </select>
        @error('role') <p class="error">{{ $message }}</p> @enderror

        <div id="niveauAdminContainer" style="display:none;">
            <label for="niveau_admin">Niveau d’administrateur :</label>
            <select name="niveau_admin" id="niveau_admin">
                @for($i=1; $i <= $currentUserNiveau; $i++)
                    <option value="{{ $i }}" {{ old('niveau_admin')==$i?'selected':'' }}>Admin niveau {{ $i }}</option>
                @endfor
            </select>
            @error('niveau_admin') <p class="error">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn">Créer l’utilisateur</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const niveauContainer = document.getElementById('niveauAdminContainer');

    function toggleNiveau() {
        niveauContainer.style.display = (roleSelect.value==='admin') ? 'block':'none';
    }

    toggleNiveau();
    roleSelect.addEventListener('change', toggleNiveau);
});
</script>
</body>
</html>
