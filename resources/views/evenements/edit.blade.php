<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name') }} - Modifier Événement</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: #f8f9fa;
            color: #333;
        }
        h1 {
            text-align: center;
            font-size: 2rem;
            color: #0056b3;
            margin-top: 1rem;
        }
        .container {
            max-width: 700px;
            margin: 2rem auto;
            background: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        label {
            display: block;
            margin-top: 1rem;
            font-weight: bold;
        }
        input[type="text"], input[type="date"], textarea, select {
            width: 100%;
            padding: 0.6rem;
            margin-top: 0.3rem;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            margin-top: 1.5rem;
            background-color: #0078D4;
            color: white;
            padding: 0.7rem 1.2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background-color: #005fa3;
        }
        .img-preview {
            margin-top: 1rem;
            max-width: 200px;
            border-radius: 8px;
        }
    </style>
</head>
<body>

    <h1>Modifier Événement</h1>

    <div class="container">
        @if(session('success'))
            <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 6px;">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px;">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('evenements.update', $evenement->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label for="titre">Titre</label>
            <input type="text" name="titre" id="titre" value="{{ old('titre', $evenement->titre) }}" required>

            <label for="description">Description</label>
            <textarea name="description" id="description" rows="4" required>{{ old('description', $evenement->description) }}</textarea>

            <label for="date">Date</label>
            <input type="date" name="date" id="date" value="{{ old('date', $evenement->date->format('Y-m-d')) }}" required>

            <label for="lieu">Lieu</label>
            <input type="text" name="lieu" id="lieu" value="{{ old('lieu', $evenement->lieu) }}" required>

            <label for="type">Type</label>
            <input type="text" name="type" id="type" value="{{ old('type', $evenement->type) }}" required>

            <label for="image">Image (laisser vide si inchangée)</label>
            <input type="file" name="image" id="image" accept="image/*">
            @if($evenement->image)
                <img src="{{ asset('storage/' . $evenement->image) }}" alt="Image actuelle" class="img-preview">
            @endif

            <button type="submit">Enregistrer les modifications</button>
        </form>

        <a href="{{ route('evenements.index') }}" style="display:block; margin-top:1rem; text-align:center; color:#0078D4;">← Retour à la liste des événements</a>
    </div>

</body>
</html>
