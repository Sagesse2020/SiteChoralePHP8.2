<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modifier Galerie</title>
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
        max-width: 800px;
        margin: 50px auto;
        padding: 25px 30px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    h1 {
        text-align: center;
        color: #007bff;
        margin-bottom: 30px;
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

    .btn-delete {
        background-color: #dc3545;
        color: #fff;
    }
    .btn-delete:hover { background-color: #b02a37; }

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

    /* ================== Image ================== */
    .current-image {
        display: block;
        margin-top: 10px;
        border-radius: 5px;
        max-width: 100%;
        height: auto;
    }
</style>
</head>
<body>

<div class="container">

    <h1>Modifier la galerie</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('galeries.update', $galerie->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="titre">Titre de l'image</label>
            <input type="text" id="titre" name="titre" value="{{ old('titre', $galerie->titre) }}" required>
        </div>

        <div class="form-group">
            <label for="evenement_id">Événement associé</label>
            <select id="evenement_id" name="evenement_id" required>
                <option value="">Sélectionnez l'événement</option>
                @foreach($evenements as $Evenement)
                    <option value="{{ $Evenement->id }}" @if($Evenement->id == $galerie->evenement_id) selected @endif>
                        {{ $Evenement->titre }} ({{ $Evenement->date ?? 'Non spécifiée' }})
                    </option>
                @endforeach
            </select>
        </div>

        @if($galerie->evenement->image)
            <div class="form-group">
                <label>Image de l'événement :</label>
                <img src="{{ asset('storage/'.$galerie->evenement->image) }}" alt="Image de l'événement" class="current-image">
            </div>
        @endif

        <div class="form-buttons">
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </div>
    </form>

    <form action="{{ route('galeries.destroy', $galerie->id) }}" method="POST" onsubmit="return confirm('Supprimer cette galerie ?')">
        @csrf
        @method('DELETE')
        <div class="form-buttons">
            <button type="submit" class="btn btn-delete">Supprimer</button>
        </div>
    </form>

</div>

</body>
</html>
