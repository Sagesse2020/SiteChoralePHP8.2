<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Chorale Foi Parfaite - Accueil</title>

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

/* NAVBAR */
header{
    background:#0044cc;
    padding:15px 25px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    flex-wrap:wrap;
}

.logo{
    width:160px;
    object-fit:contain;
}

.menu-toggle{
    display:none;
    font-size:26px;
    color:white;
    cursor:pointer;
}

.nav-links{
    display:flex;
    flex-wrap:wrap;
    gap:12px;
}

.nav-links a{
    color:white;
    text-decoration:none;
    font-size:14px;
    padding:6px 8px;
}

.nav-links a:hover{
    color:#00ffd6;
}

/* CONTENT */
main{
    flex-grow:1;
    text-align:center;
    padding:60px 20px;
}

main h1{
    font-size:clamp(28px,5vw,48px);
    color:#0044cc;
    margin-bottom:15px;
}

main p{
    font-size:clamp(16px,3vw,20px);
    max-width:600px;
    margin:auto;
}

main img{
    margin-top:25px;
    width:100%;
    max-width:500px;
}

/* FOOTER */
footer{
    background:#001f33;
    color:#ccc;
    text-align:center;
    padding:20px;
}

/* RESPONSIVE */
@media(max-width:850px){
    .menu-toggle{
        display:block;
    }

    .nav-links{
        display:none;
        width:100%;
        flex-direction:column;
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
        <a href="{{ route('publicites.index') }}"><i class="fas fa-bullhorn"></i> Publicités</a>
        <a href="{{ route('publications.index') }}"><i class="fas fa-newspaper"></i> Publications</a>
        <a href="{{ route('evenements.index') }}"><i class="fas fa-calendar-alt"></i> Événements</a>
        <a href="{{ route('profil') }}"><i class="fas fa-user"></i> Profil</a>
        <a href="{{ route('commentaires.index') }}"><i class="fas fa-comment-alt"></i> Commentaires</a>
        <a href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
    </nav>
</header>

<main>
    <h1>Bienvenue à la Chorale Foi Parfaite</h1>
    <p>Louons ensemble, chantons pour le Seigneur, dans l'harmonie et la foi.</p>
    <img src="{{ asset('users.jpeg') }}">
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
