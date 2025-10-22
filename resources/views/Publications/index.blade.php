<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Liste des publications</title>
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
        color: #007bff; /* couleur de base */
    }

    p.empty-message {
        text-align: center;
        font-size: 1.2em;
        color: #d9534f;
    }

    ul {
        list-style: none;
        padding: 0;
    }

    li {
        margin-bottom: 20px;
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 6px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    }

    li img {
        max-width: 200px;
        display: block;
        margin-bottom: 10px;
    }

    .btn {
        display: inline-block;
        background-color: #007bff; /* couleur de base */
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        border: none;
        cursor: pointer;
        width: 100px; /* même largeur pour tous */
        text-align: center;
        margin-right: 5px;
    }

    .btn:hover {
        background-color: #0056b3;
    }

    .btn-container {
        display: flex;
        gap: 5px;
    }
</style>
</head>
<body>
<div class="container">
    <h1>Liste des publications</h1>

    @if(session('success'))
        <div style="color:green; text-align:center;">{{ session('success') }}</div>
    @endif

    @if($publications->count() > 0)
        <ul>
            @foreach($publications as $pub)
                <li>
                    <h3>{{ $pub->titre }}</h3>
                    <p>{{ $pub->contenu }}</p>
                    @if($pub->image)
                        <img src="{{ asset('storage/'.$pub->image) }}" alt="{{ $pub->titre }}">
                    @endif
                    <small>Publié le {{ \Carbon\Carbon::parse($pub->date_publication)->format('d/m/Y') }}</small>

                    @if(auth()->user()->role === 'admin')
                    <div class="btn-container">
                        <a href="{{ route('publications.edit', $pub) }}" class="btn">Modifier</a>
                        <form action="{{ route('publications.destroy', $pub) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" onclick="return confirm('Supprimer cette publication ?')">Supprimer</button>
                        </form>
                    </div>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p class="empty-message">Aucune publication disponible.</p>
    @endif
</div>
</body>
</html>
