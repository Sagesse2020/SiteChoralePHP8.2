<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un choriste</title>

    <style>
        /* ------------------------ */
        /*   STYLES GÉNÉRAUX        */
        /* ------------------------ */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 60%;
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

        /* ------------------------ */
        /*   FORMULAIRE             */
        /* ------------------------ */
        form {
            margin-top: 20px;
        }

        label {
            display: block;
            font-size: 1.1em;
            margin-bottom: 8px;
            color: #555;
        }

        input[type="text"],
        select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 1em;
            background-color: #f9f9f9;
        }

        select:hover,
        input[type="text"]:hover {
            background-color: #eef2f7;
        }

        /* Boutons */
        .btn-container {
            text-align: center;
            margin-top: 20px;
        }

        .btn-submit {
            background-color: #28a745;
            border: none;
            padding: 12px 25px;
            font-size: 1.1em;
            color: white;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: #218838;
        }

        .btn-retour {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 18px;
            text-decoration: none;
            border-radius: 6px;
            margin-right: 15px;
        }

        .btn-retour:hover {
            background-color: #0056b3;
        }

        /* ------------------------ */
        /*   MESSAGE D'ERREURS      */
        /* ------------------------ */
        .alert {
            background-color: #f8d7da;
            color: #842029;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #f5c2c7;
        }
    </style>
</head>

<body>

<div class="container">
    <h1>Modifier un choriste</h1>

    <!-- Affichage des erreurs -->
    @if ($errors->any())
        <div class="alert">
            <strong>Attention :</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Vérification sécurité admin niveau 3 -->
    @if(auth()->user()->role === 'admin' && auth()->user()->niveau_admin == 3)

        <a href="{{ route('choristes.index') }}" class="btn-retour">← Retour</a>

        <form action="{{ route('choristes.update', $choristes->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label>Nom du choriste :</label>
            <input type="text" name="nom" value="{{ $choristes->nom }}" required>

            <label>Voix du choriste :</label>
            <select name="groupe_id" required>
                @foreach($groupes as $groupe)
                    <option value="{{ $groupe->id }}"
                        @if($choristes->groupe_id == $groupe->id) selected @endif>
                        {{ $groupe->nom }}
                    </option>
                @endforeach
            </select>

            <div class="btn-container">
                <button type="submit" class="btn-submit">Enregistrer les modifications</button>
            </div>
        </form>

    @else
        <div class="alert">
            🚫 Vous n’avez pas les permissions nécessaires pour modifier un choriste.
        </div>
    @endif

</div>

</body>
</html>
