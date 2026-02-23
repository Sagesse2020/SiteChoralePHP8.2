<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chorale Foi Parfaite</title>
  <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
  <style>
    /* =========================
       Styles généraux
    ========================= */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Cambria', 'Cochin', 'Georgia', 'Times', 'Times New Roman', serif;
    }

    body {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      background: linear-gradient(rgba(9,158,226,0.5), rgba(9,158,226,0.5)),
                  url('https://images.unsplash.com/photo-1579048098170-ffb569cc1028') no-repeat center center/cover;
      color: #1a1a1a;
    }

    a { text-decoration: none; }

    /* =========================
       Navigation
    ========================= */
    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 15px 30px;
      background-color: #0044cc;
      flex-wrap: wrap;
      position: relative;
    }

    .logo-container {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .logo-img { width: 100px; height: auto; border-radius: 5px; }
    .logo-text { font-size: 24px; font-weight: bold; color: #fff; }

    nav ul {
      display: flex;
      list-style: none;
      gap: 15px;
      flex-wrap: wrap;
    }

    nav ul li a {
      color: #fff;
      font-weight: 500;
      transition: color 0.3s;
    }

    nav ul li a:hover { color: #00ffcc; }

    .dropdown-button {
      background-color: #0066ff;
      color: white;
      padding: 8px 12px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .icon-settings div {
      width: 25px; height: 3px;
      background-color: white;
      margin: 4px 0;
    }

    .dropdown-menu {
      display: none;
      position: absolute;
      top: 50px;
      right: 0;
      background-color: white;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      list-style: none;
      padding: 10px 0;
      border-radius: 5px;
      min-width: 200px;
      z-index: 1000;
      opacity: 0;
      transform: translateY(-10px);
      transition: opacity 0.3s, transform 0.3s;
    }

    .nav-item:hover .dropdown-menu {
      display: block;
      opacity: 1;
      transform: translateY(0);
    }

    .dropdown-menu li {
      padding: 10px 20px;
      border-bottom: 1px solid #eee;
    }

    .dropdown-menu li:last-child { border-bottom: none; }
    .dropdown-menu li a { color: #000; }
    .dropdown-menu li a:hover { color: #0044cc; }

    /* =========================
       Hero Section
    ========================= */
    .hero {
      text-align: center;
      padding: 80px 20px 40px;
    }

    .hero h1 {
      font-size: 36px;
      font-weight: bold;
      margin-bottom: 20px;
      animation: fadeInDown 1s ease-in-out;
    }

    .hero p {
      font-size: 18px;
      max-width: 90%;
      margin: 0 auto 30px auto;
      line-height: 1.6;
      animation: fadeInUp 1.5s ease-in-out;
    }

    .hero img {
      max-width: 90%;
      height: auto;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(8,245,146,0.4);
      animation: zoomIn 2s ease-in-out;
    }

    /* =========================
       Footer
    ========================= */
    footer {
      background-color: #043113;
      text-align: center;
      padding: 20px 10px;
      color: white;
    }

    .social-icons a {
      margin: 0 10px;
      font-size: 24px;
      transition: transform 0.3s;
      color: inherit;
    }

    .social-icons a:hover { transform: scale(1.2); }

    .fa-facebook { color: #1877F2; }
    .fa-tiktok { color: #fff; }
    .fa-whatsapp { color: #25D366; }
    .fa-youtube { color: #FF0000; }

    /* =========================
       Animations
    ========================= */
    @keyframes fadeInDown { from { opacity: 0; transform: translateY(-50px); } to { opacity:1; transform: translateY(0);} }
    @keyframes fadeInUp { from { opacity:0; transform: translateY(50px);} to {opacity:1; transform:translateY(0);} }
    @keyframes zoomIn { from { transform: scale(0.8); opacity:0;} to {transform:scale(1); opacity:1;} }

    /* =========================
       Responsive
    ========================= */
    @media (max-width: 768px) {
      nav {
        flex-direction: column;
        align-items: flex-start;
      }

      nav ul {
        flex-direction: column;
        width: 100%;
        gap: 10px;
        margin-top: 10px;
      }

      .hero h1 { font-size: 28px; }
      .hero p { font-size: 16px; }
      .hero img { max-width: 100%; }
      .logo-text { font-size: 20px; }
    }

    @media (max-width: 480px) {
      .hero h1 { font-size: 22px; }
      .hero p { font-size: 14px; }
      nav ul li a { font-size: 14px; }
    }

  </style>
</head>
<body>
  <!-- Navigation -->
  <nav>
    <div class="logo-container">
      <img src="{{ asset('logo_chorale.png') }}" alt="Logo Chorale Foi Parfaite" class="logo-img">
      <span class="logo-text">Chorale Foi Parfaite</span>
    </div>

    <ul>
      <li><a href="{{ route('galeries.index') }}"><i class="fas fa-images"></i> Galeries</a></li>
      <li><a href="{{ route('groupes_vocaux.index') }}"><i class="fas fa-microphone"></i> Voix</a></li>
      <li><a href="{{ route('choristes.index') }}"><i class="fas fa-users"></i> Choristes</a></li>
      <li><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Se connecter</a></li>
      <li><a href="{{ route('register') }}"><i class="fas fa-user-plus"></i> S'inscrire</a></li>

      <li class="nav-item">
        <button class="dropdown-button">
          <div class="icon-settings"><div></div><div></div><div></div></div>
        </button>
        <ul class="dropdown-menu">
          <li><a href="{{ route('mission') }}"><i class="fas fa-bullseye"></i> Mission</a></li>
          <li><a href="{{ route('historique') }}"><i class="fas fa-history"></i> Historique</a></li>
          <li><a href="{{ route('vision') }}"><i class="fas fa-eye"></i> Vision</a></li>
          <li><a href="{{ route('infos') }}"><i class="fas fa-info-circle"></i> Infos</a></li>
          <li><a href="{{ route('aide') }}" class="help-float"><i class="fas fa-question"></i> Aide</a></li>
        </ul>
      </li>
    </ul>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <h1>Bienvenue dans la communauté Foi Parfaite</h1>
    <p>Une communauté unie par la passion du chant et la gloire de Dieu. Rejoignez-nous pour une expérience musicale et spirituelle unique.</p>
    <img src="{{ asset('chorale_img.jpeg') }}" alt="Chorale Foi Parfaite">
  </section>

  <!-- Footer -->
  <footer>
    <p>Suivez-nous sur nos réseaux</p>
    <div class="social-icons">
      <a href="https://www.facebook.com/share/16riUmXBqu/" target="_blank"><i class="fab fa-facebook"></i></a>
      <a href="https://www.tiktok.com/@choralefoiparfait" target="_blank"><i class="fab fa-tiktok"></i></a>
      <a href="https://youtube.com/@choralefoiparfaite?si=og8TeBjZG2nDLH6o" target="_blank"><i class="fab fa-youtube"></i></a>
    </div>
    <p> &copy; {{ date('Y') }} Chorale Foi Parfaite. Tous droits réservés. </p>
  </footer>
</body>
</html>
