<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Créer un utilisateur</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}

body{
    background:linear-gradient(135deg,#0044cc,#00aaff);
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    padding:20px;
}

.card{
    width:100%;
    max-width:520px;
    background:#fff;
    padding:30px;
    border-radius:16px;
    box-shadow:0 15px 35px rgba(0,0,0,0.15);
}

h2{
    text-align:center;
    color:#0044cc;
    margin-bottom:25px;
}

label{
    font-weight:600;
    margin-bottom:6px;
    display:block;
}

.input-group{
    position:relative;
    margin-bottom:18px;
}

input, select{
    width:100%;
    padding:12px 14px;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:15px;
    transition:0.3s;
}

input:focus, select:focus{
    border-color:#0044cc;
    box-shadow:0 0 0 3px rgba(0,68,204,0.1);
    outline:none;
}

.eye{
    position:absolute;
    right:12px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    font-size:18px;
    color:#666;
}

button{
    width:100%;
    padding:14px;
    background:#0044cc;
    color:white;
    border:none;
    border-radius:8px;
    font-weight:600;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#003399;
}

.alert{
    padding:10px;
    border-radius:6px;
    margin-bottom:15px;
    font-size:14px;
}

.success{background:#e6ffed;color:#1e7e34;}
.error{background:#ffe6e6;color:#cc0000;}

.roles-info{
    background:#f4f9ff;
    border-left:4px solid #0044cc;
    padding:15px;
    border-radius:8px;
    margin-bottom:20px;
    font-size:14px;
}

@media(max-width:500px){
    .card{padding:20px;}
}
</style>
</head>
<body>

<div class="card">
<h2>Créer un utilisateur</h2>

@if(session('success'))
<div class="alert success">{{ session('success') }}</div>
@endif

@if(session('error'))
<div class="alert error">{{ session('error') }}</div>
@endif

<div class="roles-info">
<strong>Rôles :</strong><br>
Utilisateur = accès limité<br>
Administrateur = accès selon niveau
</div>

@php
$currentUserNiveau = Auth::check() ? Auth::user()->niveau_admin : 0;
@endphp

<form action="{{ route('users.store') }}" method="POST">
@csrf

<label>Nom complet</label>
<div class="input-group">
<input type="text" name="name" value="{{ old('name') }}" required>
</div>
@error('name') <div class="alert error">{{ $message }}</div> @enderror

<label>Email</label>
<div class="input-group">
<input type="email" name="email" value="{{ old('email') }}" required>
</div>
@error('email') <div class="alert error">{{ $message }}</div> @enderror

<label>Mot de passe</label>
<div class="input-group">
<input type="password" name="password" id="password" required>
<span class="eye" onclick="togglePassword('password', this)">👁</span>
</div>
@error('password') <div class="alert error">{{ $message }}</div> @enderror

<label>Confirmer mot de passe</label>
<div class="input-group">
<input type="password" name="password_confirmation" id="password_confirmation" required>
<span class="eye" onclick="togglePassword('password_confirmation', this)">👁</span>
</div>

<label>Rôle</label>
<div class="input-group">
<select name="role" id="role" required>
<option value="user">Utilisateur</option>
@if($currentUserNiveau > 0)
<option value="admin">Administrateur</option>
@endif
</select>
</div>

<div id="niveauContainer" style="display:none;">
<label>Niveau Admin</label>
<div class="input-group">
<select name="niveau_admin">
@for($i=1;$i<=$currentUserNiveau;$i++)
<option value="{{ $i }}">Admin niveau {{ $i }}</option>
@endfor
</select>
</div>
</div>

<button type="submit">Créer l'utilisateur</button>

</form>
</div>

<script>
function togglePassword(id, el){
    const input = document.getElementById(id);
    if(input.type === "password"){
        input.type = "text";
        el.textContent = "🙈";
    }else{
        input.type = "password";
        el.textContent = "👁";
    }
}

const roleSelect = document.getElementById('role');
const niveauContainer = document.getElementById('niveauContainer');

function toggleNiveau(){
    niveauContainer.style.display = roleSelect.value === 'admin' ? 'block' : 'none';
}

roleSelect.addEventListener('change', toggleNiveau);
toggleNiveau();
</script>

</body>
</html>
