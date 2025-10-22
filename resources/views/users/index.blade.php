<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #1f293a;
            color: white;
            display: flex;
            justify-content: center;
            padding: 30px;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            background: rgba(0,0,0,0.6);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background: #0ef;
            color: #1f293a;
        }
        tr:nth-child(even) {
            background: rgba(255,255,255,0.05);
        }
        .btn-delete {
            background: #ff4d4d;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-edit {
            background: #0ef;
            color: #1f293a;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            margin-right: 5px;
        }
        .alert {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
        .alert-success { background: #28a745; }
        .alert-error { background: #dc3545; }

        /* Modale */
        .modal {
            display: none;
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100%;
            background: rgba(0,0,0,0.6);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: #2d3748;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            color: white;
        }
        .modal-content h3 {
            margin-bottom: 15px;
        }
        .modal-content input, .modal-content select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: none;
        }
        .modal-content button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-save {
            background: #0ef;
            color: #1f293a;
        }
        .btn-close {
            background: #dc3545;
            color: white;
            float: right;
        }
    </style>
</head>
<body>
<div>
    <h2>Liste des utilisateurs</h2>

    <!-- Messages de succès/erreur -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Niveau</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role ?? 'N/A' }}</td>
                    <td>{{ $user->role === 'admin' ? 'Admin niveau '.$user->niveau_admin : '-' }}</td>
                    <td>
                        <!-- Vérification hiérarchie pour afficher les boutons -->
                        @php
                            $canEdit = true;
                            $canDelete = true;
                            if($user->role === 'admin' && Auth::user()->niveau_admin <= $user->niveau_admin){
                                $canEdit = false;
                                $canDelete = false;
                            }
                        @endphp

                        @if($canEdit)
                            <button class="btn-edit" onclick="openEditModal({{ $user->id }}, '{{ $user->name }}', '{{ $user->email }}', '{{ $user->role }}', {{ $user->niveau_admin ?? 0 }})">Modifier</button>
                        @endif

                        @if($canDelete)
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Supprimer</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Aucun utilisateur trouvé</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modale Modification -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <button class="btn-close" onclick="closeEditModal()">X</button>
        <h3>Modifier l'utilisateur</h3>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="name" id="editName" placeholder="Nom" required>
            <input type="email" name="email" id="editEmail" placeholder="Email" required>
            <select name="role" id="editRole">
                <option value="user">Utilisateur</option>
                @if(Auth::user()->niveau_admin >= 2)
                    <option value="admin">Admin</option>
                @endif
            </select>
            <select name="niveau_admin" id="editNiveau">
                @for($i = 1; $i < Auth::user()->niveau_admin; $i++)
                    <option value="{{ $i }}">Admin niveau {{ $i }}</option>
                @endfor
            </select>
            <button type="submit" class="btn-save">Enregistrer</button>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, name, email, role, niveau) {
        document.getElementById('editForm').action = '/users/' + id; // route users.update
        document.getElementById('editName').value = name;
        document.getElementById('editEmail').value = email;
        document.getElementById('editRole').value = role ?? 'user';
        document.getElementById('editNiveau').value = niveau ?? 0;
        document.getElementById('editModal').style.display = 'flex';
    }
    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }
</script>
</body>
</html>
