<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon profil - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin-top: 50px;
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #007bff;
            margin-bottom: 30px;
        }
        .avatar {
            display: block;
            margin-bottom: 10px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
        }
        .input-group-text {
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Mettre à jour mon profil</h1>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('profile-update') }}" enctype="multipart/form-data">
        @csrf

        <!-- Nom -->
        <div class="mb-3">
            <label for="name" class="form-label">Nom</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
        </div>

        <!-- Ancien mot de passe -->
        <div class="mb-3">
            <label for="old-password" class="form-label">Ancien mot de passe</label>
            <div class="input-group">
                <input type="password" id="old-password" name="old-password" class="form-control" required>
                <span class="input-group-text" onclick="togglePassword('old-password', this)">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>
        </div>

        <!-- Nouveau mot de passe -->
        <div class="mb-3">
            <label for="new-password" class="form-label">Nouveau mot de passe (facultatif)</label>
            <div class="input-group">
                <input type="password" id="new-password" name="new-password" class="form-control">
                <span class="input-group-text" onclick="togglePassword('new-password', this)">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>
        </div>

        <!-- Confirmation -->
        <div class="mb-3">
            <label for="new-password_confirmation" class="form-label">Confirmer le nouveau mot de passe</label>
            <div class="input-group">
                <input type="password" id="new-password_confirmation" name="new-password_confirmation" class="form-control">
                <span class="input-group-text" onclick="togglePassword('new-password_confirmation', this)">
                    <i class="fa-solid fa-eye"></i>
                </span>
            </div>
        </div>

        <!-- Photo -->
        <div class="mb-3">
            <label class="form-label">Photo actuelle :</label><br>
            <img id="profilePreview"
                 src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('default-avatar.png') }}"
                 alt="Profil" class="avatar">
            <input type="file" name="photo" id="photoInput" accept="image/*" class="form-control mt-2">
        </div>

        <button type="submit" class="btn btn-primary w-100">Mettre à jour</button>
    </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
<script>
    // Prévisualisation photo
    document.getElementById('photoInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePreview').setAttribute('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // Fonction afficher/masquer mot de passe
    function togglePassword(inputId, iconElement) {
        const input = document.getElementById(inputId);
        const icon = iconElement.querySelector('i');
        if(input.type === 'password') {
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
