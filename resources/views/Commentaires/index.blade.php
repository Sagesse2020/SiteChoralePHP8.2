<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaires - Chorale Foi Parfaite</title>
    <style>
        body {
            background: #f2f7fb;
            font-family: Cambria, serif;
            padding: 20px;
            color: #333;
        }

        h1 {
            text-align: center;
            color: #0044cc;
            margin-bottom: 30px;
        }

        .commentaire, .reponse, .formulaire {
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            background: #fff;
        }

        .reponse {
            background: #f9f9ff;
            border-left: 4px solid #0044cc;
            margin-left: 30px;
        }

        .pseudo {
            font-weight: bold;
            color: #222;
        }

        .meta {
            font-size: 13px;
            color: #777;
            margin-bottom: 8px;
        }

        .contenu {
            font-size: 15px;
            margin-bottom: 10px;
        }

        input, textarea, button {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-family: inherit;
        }

        button {
            background-color: #0044cc;
            color: white;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #0033aa;
        }

        .btn-supprimer {
            background-color: crimson;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin-top: 5px;
        }

        .btn-supprimer:hover {
            background-color: darkred;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

    <h1>💬 Section Commentaires</h1>

    {{-- ✅ Message de succès --}}
    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    {{-- ✅ Formulaire d’ajout de commentaire --}}
    <div class="formulaire">
        <form action="{{ route('commentaires.store') }}" method="POST">
            @csrf
            <label>Nom de l'utilisateur inscrit :</label>
            <input type="text" name="pseudo" required>
            <label>Message :</label>
            <textarea name="contenu" rows="3" required></textarea>

            <button type="submit">➕ Ajouter un commentaire</button>
        </form>
    </div>

    {{-- ✅ Liste des commentaires --}}
    @foreach($commentaires as $commentaire)
        <div class="commentaire">
            <p class="pseudo">{{ $commentaire->user->name ?? $commentaire->pseudo }}</p>
            <p class="meta">Posté le {{ $commentaire->created_at->format('d/m/Y à H:i') }}</p>
            <p class="contenu">{{ $commentaire->contenu }}</p>

            {{-- 🔒 Bouton supprimer visible uniquement pour admin niveau 3 --}}
            @if(Auth::check() && Auth::user()->role === 'admin' && Auth::user()->niveau_admin == 3)
                <form action="{{ route('commentaires.destroy', $commentaire->id) }}" method="POST" onsubmit="return confirm('Supprimer ce commentaire ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-supprimer">🗑️ Supprimer</button>
                </form>
            @endif

            {{-- ✅ Réponses --}}
            @foreach($commentaire->reponses as $reponse)
                <div class="reponse">
                    <p class="pseudo">{{ $reponse->user->name ?? $reponse->pseudo }}</p>
                    <p class="meta">Réponse au commentaire de <strong>{{ $commentaire->user->name ?? $commentaire->pseudo }}</strong> — {{ $reponse->created_at->format('d/m/Y à H:i') }}</p>
                    <p class="contenu">{{ $reponse->contenu }}</p>

                    {{-- 🔒 Bouton supprimer pour admin niveau 3 --}}
                    @if(Auth::check() && Auth::user()->role === 'admin' && Auth::user()->niveau_admin == 3)
                        <form action="{{ route('commentaires.destroy', $reponse->id) }}" method="POST" onsubmit="return confirm('Supprimer cette réponse ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-supprimer">🗑️ Supprimer</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endforeach

    {{-- Pagination --}}
    <div style="text-align: center; margin-top: 20px;">
        {{ $commentaires->links() }}
    </div>

</body>
</html>
