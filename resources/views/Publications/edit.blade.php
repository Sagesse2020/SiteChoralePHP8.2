<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Modifier la Publication</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7fa;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .container {
        width: 80%;
        margin: 50px auto;
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        font-size: 2.2em;
        margin-bottom: 20px;
        color: #007bff;
    }

    label {
        display: block;
        margin-top: 15px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="date"],
    textarea,
    input[type="file"] {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 1em;
    }

    button {
        background-color: #007bff;
        color: white;
        padding: 10px 20px;
        margin-top: 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 1em;
        width: 150px; /* même taille pour tous les boutons */
        text-align: center;
        transition: background-color 0.3s, transform 0.2s;
    }

    button:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    .btn-container {
        display: flex;
        gap: 10px;
        margin-top: 20px;
    }

    .btn-delete {
        background-color: #dc3545;
    }

    .btn-delete:hover {
        background-color: #b02a37;
    }

    .error-list {
        color: red;
        margin-bottom: 20px;
    }

    img {
        margin-top: 10px;
        border-radius: 5px;
    }
</style>
</head>
<body>
<div class="container">
   <div class="container">
    <h1>Modifier la Publication</h1>

    @if ($errors->any())
        <div class="error-list">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('publications.update', $publication) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="titre">Titre :</label>
        <input type="text" name="titre" value="{{ old('titre', $publication->titre) }}" required>

        <label for="contenu">Contenu :</label>
        <textarea name="contenu" rows="4" required>{{ old('contenu', $publication->contenu) }}</textarea>

        @if($publication->image)
            <label>Image actuelle :</label>
            <img src="{{ asset('storage/'.$publication->image) }}" alt="Image" width="200">
        @endif

        <label for="image">Nouvelle Image (optionnelle) :</label>
        <input type="file" name="image">

        <label for="date_publication">Date de publication :</label>
        <input type="date" name="date_publication" value="{{ old('date_publication', $publication->date_publication) }}" required>

        <div class="btn-container">
            <button type="submit">Mettre à jour</button>
        </div>
    </form>
</div>
</body>
</html>
