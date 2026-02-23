<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Administration - Chorale Foi Parfaite</title>

<link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

<style>
/* =========================
   Styles généraux
========================= */
* {
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Segoe UI', sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    flex-direction:column;
    background: linear-gradient(135deg,#f0f8ff,#d9e8ff);
}

/* =========================
   Header / Navigation
========================= */
header{
    background:#003366;
    padding:15px 25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
}

.logo{
    width:150px;
}

.menu-toggle{
    display:none;
    font-size:28px;
    color:white;
    cursor:pointer;
}

.nav-links{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.nav-links a,
.nav-links button{
    color:white;
    text-decoration:none;
    font-size:14px;
    background:none;
    border:none;
    cursor:pointer;
    padding:8px 12px;
    border-radius:5px;
    transition: background 0.3s, color 0.3s;
}

.nav-links a:hover,
.nav-links button:hover{
    background:#0055aa;
    color:#00ffd6;
}

.dropdown{
    position:relative;
}

.dropdown-content{
    display:none;
    position:absolute;
    background:white;
    min-width:220px;
    box-shadow:0 8px 16px rgba(0,0,0,.2);
    border-radius:5px;
    overflow:hidden;
    z-index:1000;
}

.dropdown-content a{
    color:#003366;
    padding:10px 15px;
    display:block;
    text-decoration:none;
}

.dropdown-content a:hover{
    background:#f0f0f0;
}

.dropdown:hover .dropdown-content{
    display:block;
}

main{
    flex:1;
    text-align:center;
    padding:60px 20px;
}

main h1{
    font-size:clamp(24px,5vw,40px);
    color:#003366;
}

main p{
    margin-top:15px;
    font-size:18px;
    max-width:600px;
    margin-inline:auto;
}

.cards{
    margin-top:40px;
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.card{
    background:white;
    padding:25px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s, box-shadow 0.3s;
}

.card:hover{
    transform: translateY(-5px);
    box-shadow:0 10px 20px rgba(0,0,0,0.15);
}

.card i{
    font-size:30px;
    color:#003366;
    margin-bottom:10px;
}

footer{
    background:#001f33;
    color:#ccc;
    text-align:center;
    padding:15px;
}

@media(max-width:850px){
    .menu-toggle{
        display:block;
    }
    .nav-links{
        display:none;
        flex-direction:column;
        width:100%;
        margin-top:15px;
        background:#003366;
        border-radius:5px;
        padding:10px 0;
    }
    .nav-links.active{
        display:flex;
    }
    .nav-links a, .nav-links button{
        padding:12px 20px;
        font-size:16px;
        width:100%;
        text-align:left;
    }
}

@media(max-width:600px){
    .cards{
        grid-template-columns:1fr;
    }
    main h1{
        font-size:24px;
    }
    main p{
        font-size:16px;
    }
}
</style>
</head>

<body>

<header>
    <img src="{{ asset('logo_chorale.png') }}" class="logo">

    <i class="fas fa-bars menu-toggle" onclick="toggleMenu()"></i>

    <nav class="nav-links" id="menu">

        @auth
            <a href="{{ route('publicites.index') }}"><i class="fas fa-bullhorn"></i> Publicités</a>
            <a href="{{ route('publications.index') }}"><i class="fas fa-newspaper"></i> Publications</a>
            <a href="{{ route('evenements.index') }}"><i class="fas fa-calendar-alt"></i> Événements</a>
            <a href="{{ route('profil') }}"><i class="fas fa-user"></i> Profil</a>

            @if(auth()->user()->niveau_admin >= 2)
                <div class="dropdown">
                    <button><i class="fas fa-music"></i> Gestion Chorale</button>
                    <div class="dropdown-content">
                        <a href="{{ route('app_accueilGroupe') }}">Voix</a>
                        <a href="{{ route('app_accueilChoriste') }}">Choristes</a>
                    </div>
                </div>

                <div class="dropdown">
                    <button><i class="fas fa-folder-open"></i> Contenu</button>
                    <div class="dropdown-content">
                        <a href="{{ route('app_accueilEvenement') }}">Événements</a>
                        <a href="{{ route('app_accueilGalerie') }}">Galeries</a>
                        <a href="{{ route('app_accueilPublication') }}">Publications</a>
                        <a href="{{ route('app_accueilPublicite') }}">Publicités</a>
                    </div>
                </div>

                <div class="dropdown">
                    <button><i class="fas fa-tools"></i> Outils</button>
                    <div class="dropdown-content">
                        <a href="{{ route('statistiques') }}">Statistiques</a>
                        <a href="{{ route('commentaires.index') }}">Commentaires</a>
                    </div>
                </div>
            @endif

            @if(auth()->user()->niveau_admin == 3)
                <div class="dropdown">
                    <button><i class="fas fa-users"></i> Utilisateurs</button>
                    <div class="dropdown-content">
                        <a href="{{ route('users.create') }}">Créer utilisateur</a>
                        <a href="{{ route('users.index') }}">Liste utilisateurs</a>
                    </div>
                </div>
            @endif

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">
                    <i class="fas fa-sign-out-alt"></i> Déconnexion
                </button>
            </form>
        @endauth

        @guest
            <a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Connexion</a>
            <a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> Inscription</a>
        @endguest

    </nav>
</header>

<main>
    <h1>
        @if(auth()->user()->niveau_admin == 3)
            Bienvenue Administrateur Général
        @elseif(auth()->user()->niveau_admin == 2)
            Bienvenue Leader de la Chorale
        @else
            Bienvenue membre
        @endif
    </h1>
    <p>
        @if(auth()->user()->niveau_admin == 3)
            Contrôle total de la plateforme.
        @elseif(auth()->user()->niveau_admin == 2)
            Gestion opérationnelle de la chorale.
        @else
            Accès aux informations.
        @endif
    </p>
     <p class="info-text">
     Les cartes ci-dessous présentent les modules disponibles.
     Utilisez le menu d’administration pour gérer chaque fonctionnalité.
    </p>
    @auth
    <div class="cards">
<div class="card">
<span class="badge">Présentation</span>
<i class="fas fa-bullhorn"></i>
<h3>Gestion Publicités</h3>
</div>

<div class="card">
<span class="badge">Présentation</span>
<i class="fas fa-newspaper"></i>
<h3>Gestion Publications</h3>
</div>

<div class="card">
<span class="badge">Présentation</span>
<i class="fas fa-calendar-alt"></i>
<h3>Gestion Événements</h3>
</div>

@if(auth()->user()->niveau_admin==3)
<div class="card">
<span class="badge">Présentation</span>
<i class="fas fa-users"></i>
<h3>Gestion Utilisateurs</h3>
</div>
@endif
</div>
    @endauth
</main>
<footer>
    &copy; {{ date('Y') }} Chorale Foi Parfaite. Tous droits réservés.
</footer>
<script>
function toggleMenu(){
    document.getElementById('menu').classList.toggle('active');
}
</script>
</body>
</html>
