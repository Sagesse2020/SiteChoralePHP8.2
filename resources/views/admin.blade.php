<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Administration Chorale</title>

<link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Cambria, Georgia, serif;}

body{
    min-height:100vh;
    display:flex;
    flex-direction:column;
    background:blue,
    url('https://images.unsplash.com/photo-1579048098170-ffb569cc1028')
    no-repeat center/cover;
}

nav{
    background:blue;
    padding:15px 25px;
    display:flex;
    align-items:center;
    justify-content:space-between;
}

.logo{width:170px;}

.menu{display:flex;gap:15px;list-style:none;}

.menu a{
    color:white;
    text-decoration:none;
    padding:8px 12px;
    font-size:14px;
}

.menu a:hover{
    background:#003399;
    border-radius:5px;
    color:blue;
}

.dropdown{position:relative;}
.dropdown-content{
    display:none;
    position:absolute;
    background:white;
    min-width:220px;
    box-shadow:0 8px 16px rgba(0,0,0,.2);
}
.dropdown-content a{color:#333;display:block;}
.dropdown:hover .dropdown-content{display:block;}

.hero{
    flex-grow:1;
    text-align:center;
    padding:60px 20px;
}

.hero h1{font-size:40px;}
.hero p{margin-top:15px;}

footer{
    background:#0a2209;
    color:white;
    text-align:center;
    padding:20px;
}
</style>
</head>

<body>

<nav>
<img src="{{ asset('logo_chorale.png') }}" class="logo">

<ul class="menu">

<li><a href="{{ route('welcome') }}"><i class="fas fa-home"></i> Accueil</a></li>

@if(auth()->user()->role >= 2)
<li class="dropdown">
    <a href="#"><i class="fas fa-music"></i> Gestion Chorale</a>
    <div class="dropdown-content">
        <a href="{{ route('app_accueilGroupe') }}">Voix</a>
        <a href="{{ route('app_accueilChoriste') }}">Choristes</a>
    </div>
</li>

<li class="dropdown">
    <a href="#"><i class="fas fa-folder-open"></i> Contenu</a>
    <div class="dropdown-content">
        <a href="{{ route('app_accueilEvenement') }}">Événements</a>
        <a href="{{ route('app_accueilGalerie') }}">Galeries</a>
        <a href="{{ route('app_accueilPublication') }}">Publications</a>
        <a href="{{ route('app_accueilPublicite') }}">Publicités</a>
    </div>
</li>

<li class="dropdown">
    <a href="#"><i class="fas fa-tools"></i> Outils</a>
    <div class="dropdown-content">
        <a href="{{ route('statistiques') }}">Statistiques</a>
        <a href="{{ route('commentaires.index') }}">Commentaires</a>
    </div>
</li>
@endif

@if(auth()->user()->role == 3)
<li class="dropdown">
    <a href="#"><i class="fas fa-users"></i> Utilisateurs</a>
    <div class="dropdown-content">
        <a href="{{ route('users') }}">Créer utilisateur</a>
        <a href="{{ route('users.index') }}">Liste utilisateurs</a>
    </div>
</li>

<li class="dropdown">
    <a href="#"><i class="fas fa-music"></i> Gestion Chorale</a>
    <div class="dropdown-content">
        <a href="{{ route('app_accueilGroupe') }}">Voix</a>
        <a href="{{ route('app_accueilChoriste') }}">Choristes</a>
    </div>
</li>

<li class="dropdown">
    <a href="#"><i class="fas fa-folder-open"></i> Contenu</a>
    <div class="dropdown-content">
        <a href="{{ route('app_accueilEvenement') }}">Événements</a>
        <a href="{{ route('app_accueilGalerie') }}">Galeries</a>
        <a href="{{ route('app_accueilPublication') }}">Publications</a>
        <a href="{{ route('app_accueilPublicite') }}">Publicités</a>
    </div>
</li>

<li class="dropdown">
    <a href="#"><i class="fas fa-tools"></i> Outils</a>
    <div class="dropdown-content">
        <a href="{{ route('statistiques') }}">Statistiques</a>
        <a href="{{ route('commentaires.index') }}">Commentaires</a>
    </div>
</li>
@endif


<li><a href="{{ route('profil') }}"><i class="fas fa-user"></i> Profil</a></li>

</ul>
</nav>

<section class="hero">
<h1>
@if(auth()->user()->role == 3)
Bienvenue Administrateur Général
@elseif(auth()->user()->role == 2)
Bienvenue Leader de la Chorale
@else
Bienvenue membre
@endif
</h1>

<p>
@if(auth()->user()->role == 3)
Contrôle total de la plateforme.
@elseif(auth()->user()->role == 2)
Gestion opérationnelle de la chorale.
@else
Accès aux informations
@endif
</p>
</section>

<footer>
<p>&copy; 2025 Chorale Foi Parfaite</p>
</footer>

</body>
</html>
