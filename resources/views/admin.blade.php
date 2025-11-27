<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrateur</title>

    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif; }
        body { background: linear-gradient(rgba(8,199,212,0.5)), url('https://images.unsplash.com/photo-1579048098170-ffb569cc1028') no-repeat center center/cover; height: 100vh; display: flex; flex-direction: column; justify-content: space-between; color: black; }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 40px;
            background-color: blue;
        }

        .logo {
            width: 200px;      /* largeur plus grande pour visibilité */
            max-height: 100px;  /* garde la hauteur de la barre */
            object-fit: contain;
        }

        nav ul {
            display: flex;
            list-style: none;
            gap: 8px;
        }

        nav ul li a {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav ul li a i { margin-right: 8px; }

        nav ul li a:hover { color: #00ffd6; }

        .hero { text-align: center; padding: 100px 30px 30px; }

        .hero h1 { font-size: 48px; font-weight: bold; margin-bottom: 20px; }

        .hero p { font-size: 20px; max-width: 700px; margin: 0 auto; line-height: 1.6; }

        .hero img { margin-top: 20px; max-width: 90%; border-radius: 15px; box-shadow: 0 8px 20px rgb(8,245,146); }

        footer { background-color: rgb(10,34,9); text-align: center; padding: 20px; color: white; }

        .social-icons { margin-top: 10px; }
        .social-icons a { margin: 0 10px; font-size: 24px; transition: transform 0.3s; }
        .social-icons a:hover { transform: scale(1.2); }

        .fa-facebook { color: #1877F2; }
        .fa-tiktok { color: white; }
        .fa-whatsapp { color: #25D366; }
        .fa-youtube { color: #FF0000; }
    </style>
</head>
<body>
    <nav>
        <img src="{{ asset('logo_chorale.png') }}" alt="Logo Chorale" class="logo">
        <ul>
            <li><a href="{{ route('welcome') }}"><i class="fas fa-home"></i> Accueil</a></li>
            <li><a href="{{ route('app_accueilGroupe') }}"><i class="fas fa-microphone"></i> Voix</a></li>
            <li><a href="{{ route('app_accueilChoriste') }}"><i class="fas fa-users"></i> Choristes</a></li>
            <li><a href="{{ route('app_accueilEvenement') }}"><i class="fas fa-calendar-alt"></i> Événements</a></li>
            <li><a href="{{ route('app_accueilGalerie') }}"><i class="fas fa-images"></i> Galeries</a></li>
            <li><a href="{{ route('app_accueilPublicite') }}"><i class="fas fa-bullhorn"></i> Publicités</a></li>
            <li><a href="{{ route('app_accueilPublication') }}"><i class="fas fa-newspaper"></i> Publications</a></li>
            <li><a href="{{ route('users') }}"><i class="fas fa-user-plus"></i> Créer un utilisateur</a></li>
            <li><a href="{{ route('users.index') }}"><i class="fas fa-users"></i> Liste des utilisateurs</a></li>
            <li><a href="{{ route('profil') }}"><i class="fas fa-user"></i> Profil</a></li>
            <li><a href="{{ route('statistiques') }}"><i class="fas fa-chart-bar"></i> Statistiques</a></li>
            <li><a href="{{ route('commentaires.index') }}"><i class="fas fa-comment-alt"></i>Commentaires</a></li>

        </ul>
    </nav>

    <section class="hero">
        <h1>Bienvenue cher administrateur</h1>
        <p>Cette page personnelle est conçue pour l'administration du site</p>
        <img src="{{ asset('Admin.jpg') }}" alt="Chorale Foi Parfaite">
    </section>

    <footer>
        <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-tiktok"></i></a>
            <a href="#"><i class="fab fa-whatsapp"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
        </div>
        <p>&copy; 2025 Chorale Foi Parfaite. Tous droits réservés.</p>
    </footer>
</body>
</html>
