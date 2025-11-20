<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des choristes</title>
    <style>
         /* Général : corps de la page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Conteneur principal */
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Titre principal */
        h1 {
            text-align: center;
            font-size: 2.2em;
            margin-bottom: 20px;
            color: #007bff;
        }

        /* Style du message "Aucun client disponible" */
        p {
            text-align: center;
            font-size: 1.2em;
            color: #d9534f;
        }

        /* Table de clients */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table th,
        table td {
            padding: 12px;
            text-align: left;
            border-bottom: 2px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: white;
            font-size: 1em;
        }

        table td {
            background-color: #f9f9f9;
            font-size: 1em;
        }

        table tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        /* Améliorer la visibilité des bordures lors du survol */
        table tr:hover td {
            background-color: #e9ecef;
        }

        /* Boutons actions */
        .action-buttons a, .action-buttons button {
            margin-right: 5px;
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            cursor: pointer;
        }

        .action-buttons a {
            background-color: #28a745;
        }

        .action-buttons button {
            background-color: #dc3545;
        }

        .action-buttons button:hover,
        .action-buttons a:hover {
            opacity: 0.8;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 10px 15px;
            margin: 0 5px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .pagination a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Liste des choristes</h1>

    @if($choristes->isEmpty())
        <p>Aucun choriste disponible.</p>
    @else
        <table border="4px">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Nom du choriste</th>
                    <th>Voix du choriste</th>
                    @if(auth()->user()->niveau_admin === 3)
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($choristes as $choriste)
                    <tr>
                        <td>{{ $choriste->id }}</td>
                        <td>{{ $choriste->nom }}</td>
                        <td>{{ $choriste->groupe->nom ?? 'Non affecté' }}</td>
                        @if(auth()->user()->niveau_admin === 3)
                            <td class="action-buttons">
                                <a href="{{ route('choristes.edit', $choriste->id) }}">Modifier</a>
                                <form action="{{ route('choristes.destroy', $choriste->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ce choriste ?')">Supprimer</button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
</body>
</html>
