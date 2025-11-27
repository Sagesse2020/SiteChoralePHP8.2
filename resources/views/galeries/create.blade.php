<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Creer une galerie</title>

<style>
    /* ================== Base ================== */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7fa;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .container {
        width: 90%;
        max-width: 900px;
        margin: 50px auto;
        padding: 30px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    h1 {
        text-align: center;
        color: #007bff;
        margin-bottom: 40px;
    }

    /* ================== Formulaire ================== */
    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px 12px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        transition: 0.3s;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #007bff;
        outline: none;
        background-color: #fff;
    }

    /* ================== Boutons ================== */
    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        border: none;
        transition: 0.3s;
        margin: 5px;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
    }
    .btn-primary:hover { background-color: #0056b3; }

    .btn-secondary {
        background-color: #f0f0f0;
        color: #333;
    }
    .btn-secondary:hover { background-color: #e0e0e0; }

    .form-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 25px;
    }

    /* ================== Alertes ================== */
    .alert-success {
        padding: 15px;
        background-color: #d4edda;
        color: #155724;
        border-radius: 5px;
        margin-bottom: 20px;
        text-align: center;
    }

</style>
</head>

<body>

<div class="container">

    <h1>Créer une nouvelle galerie</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('galeries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Titre de la galerie -->
        <div class="form-group">
            <label for="titre">Titre de la galerie</label>
            <input type="text" id="titre" name="titre" value="{{ old('titre') }}" required>
        </div>

        <!-- Sélection de l'événement -->
        <div class="form-group">
            <label for="evenement_id">Événement associé</label>
            <select id="evenement_id" name="evenement_id" required>
                <option value="">Sélectionnez l'événement</option>
                @foreach($evenements as $Evenement)
                    <option value="{{ $Evenement->id }}">
                        {{ $Evenement->titre }} ({{ $Evenement->date ?? 'Non spécifiée' }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Upload multiple images -->
        <div class="form-group">
            <label for="images">Ajouter une ou plusieurs images</label>
            <input type="file" id="images" name="images[]" multiple required>
        </div>

        <!-- Boutons -->
        <div class="form-buttons">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <button type="reset" class="btn btn-secondary">Réinitialiser</button>
        </div>
    </form>

</div>

</body>
</html>
