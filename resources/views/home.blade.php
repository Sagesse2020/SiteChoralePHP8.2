<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Accueil - Chorale Foi Parfaite</title>

<link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:'Segoe UI', sans-serif;
}

body{
    min-height:100vh;
    display:flex;
    flex-direction:column;
    background:linear-gradient(135deg,#f0f8ff,#d9e8ff);
}

/* ===== HEADER ===== */
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
    font-size:26px;
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
}

.nav-links a:hover,
.nav-links button:hover{
    color:#00ffd6;
}

/* ===== MAIN ===== */
main{
    flex:1;
    text-align:center;
    padding:60px 20px;
}

main h1{
    font-size:clamp(28px,5vw,48px);
    color:#003366;
}

main p{
    margin-top:15px;
    font-size:18px;
    max-width:600px;
    margin-inline:auto;
}

/* ===== INFO TEXT ===== */
.info-text{
    margin-top:30px;
    font-size:15px;
    color:#555;
    max-width:700px;
    margin-inline:auto;
    background:#eef4ff;
    padding:12px 18px;
    border-left:4px solid #003366;
    border-radius:6px;
}

/* ===== CARDS ===== */
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
    cursor:default; /* non cliquable */
}

.card:hover{
    transform:none;
    box-shadow:0 5px 15px rgba(0,0,0,0.1);
}

.card i{
    font-size:30px;
    color:#003366;
    margin-bottom:10px;
}

.badge{
    display:inline-block;
    font-size:11px;
    background:#003366;
    color:white;
    padding:3px 8px;
    border-radius:12px;
    margin-bottom:10px;
}

/* ===== FOOTER ===== */
footer{
    background:#001f33;
    color:#ccc;
    text-align:center;
    padding:15px;
}

/* ===== RESPONSIVE ===== */
@media(max-width:850px){
    .menu-toggle{
        display:block;
    }
    .nav-links{
        display:none;
        flex-direction:column;
        width:100%;
        margin-top:15px;
    }
    .nav-links.active{
        display:flex;
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
            <a href="{{ route('commentaires.index') }}"><i class="fas fa-comment"></i> Commentaires</a>
            <a href="{{ route('publications.index') }}"><i class="fas fa-newspaper"></i> Publications</a>
            <a href="{{ route('evenements.index') }}"><i class="fas fa-calendar-alt"></i> Événements</a>
            <a href="{{ route('profil') }}"><i class="fas fa-user"></i> Profil</a>

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
    <h1>Bienvenue {{ auth()->check() ? auth()->user()->name : 'à la Chorale Foi Parfaite' }}</h1>

    <p>
        Louons ensemble et chantons pour le Seigneur dans l'harmonie et la foi.
    </p>

    @auth
        <p class="info-text">
            Les éléments ci-dessous présentent les fonctionnalités disponibles dans l’application.
            Utilisez le menu en haut pour y accéder.
        </p>

        <div class="cards">
            <div class="card">
                <span class="badge">Présentation</span>
                <i class="fas fa-bullhorn"></i>
                <h3>Publicités</h3>
            </div>

            <div class="card">
                <span class="badge">Présentation</span>
                <i class="fas fa-calendar-alt"></i>
                <h3>Événements</h3>
            </div>

            <div class="card">
                <span class="badge">Présentation</span>
                <i class="fas fa-newspaper"></i>
                <h3>Publications</h3>
            </div>
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
