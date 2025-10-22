<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier utilisateur</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #1f293a;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        form {
            background: rgba(0,0,0,0.6);
            padding: 20px;
            border-radius: 10px;
            width: 400px;
        }
        h2 { text-align: center; margin-bottom: 20px; color: #0ef; }
        label { display: block; margin-top: 10px; }
        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: none;
        }
        .btn {
            margin-top: 20px;
            width: 100%;
            padding: 10px;
            background: #0ef;
            color: #1f293a;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover { background: #00c8c8; }
    </style>
</head>
<body>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <h2>Modifier utilisateur</h2>

        <label for="name">Nom</label>
        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>

        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>

        <label for="role">Rôle</label>
        <select name="role" id="role" required>
            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Utilisateur</option>
            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrateur</option>
        </select>

        <label for="password">Nouveau mot de passe (optionnel)</label>
        <input type="password" id="password" name="password">

        <label for="password_confirmation">Confirmer le mot de passe</label>
        <input type="password" id="password_confirmation" name="password_confirmation">

        <button type="submit" class="btn">Enregistrer</button>
    </form>
</body>
</html>
