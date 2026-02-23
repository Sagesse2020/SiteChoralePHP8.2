<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos - Application Chorale Foi Parfaite</title>
    <style>
        /* Reset et style global */
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: #f4f7fb;
            color: #333;
            line-height: 1.7;
            margin: 0;
            padding: 0;
        }

         a {
            color: #f6f8fd;
        }

        main {
            max-width: 950px;
            margin: 50px auto;
            padding: 0 25px;
        }

        h1, h2 {
            color: #2b4a80;
        }

        h1 {
            font-size: 2.8rem;
            text-align: center;
            margin-bottom: 30px;
        }

        h2 {
            font-size: 1.8rem;
            margin-top: 40px;
            margin-bottom: 15px;
            border-bottom: 2px solid #2b4a80;
            display: inline-block;
            padding-bottom: 5px;
        }

        section {
            background-color: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            margin-bottom: 35px;
        }

        ul {
            margin-left: 25px;
            list-style-type: disc;
        }

        /* Footer */
        .credit {
            background: rgb(13, 74, 204);
            color: white;
            padding: 15px 20px; /* plus compact */
            border-radius: 10px;
            text-align: center;
            font-size: 0.95rem;
        }

        .credit p {
            margin: 5px 0;
        }

        /* Email cliquable */
        .email-link {
            color: #fff;
            text-decoration: underline;
        }

        .email-link:hover {
            color: #ffdd57; /* couleur au survol */
        }

        strong {
            color: #2b4a80;
        }

        /* Responsive */
        @media (max-width: 600px) {
            main {
                padding: 0 15px;
            }

            h1 {
                font-size: 2rem;
            }

            h2 {
                font-size: 1.4rem;
            }
        }
    </style>
</head>

<body>
    <main>
        <h1>À propos de l’application Chorale Foi Parfaite</h1>

        <!-- Présentation générale -->
        <section>
            <h2>Présentation générale</h2>
            <p>
                <strong>Chorale Foi Parfaite</strong> est une
                <strong>Application complète de gestion de chorale</strong>,
                développée pour faciliter la coordination, la communication et
                la gestion des activités musicales et administratives.
            </p>
            <p>
                Elle centralise toutes les informations importantes :
                membres, événements, galeries photos, publications, et plus encore.
            </p>
        </section>

        <!-- Objectifs -->
        <section>
            <h2>Objectifs de l’application</h2>
            <ul>
                <li>Faciliter la gestion des membres, groupes vocaux et choristes.</li>
                <li>Améliorer la communication entre administrateurs et utilisateurs.</li>
                <li>Offrir un espace d’échange via une section de commentaires ouverte aux admins et aux utilisateurs inscrits.</li>
                <li>Présenter la chorale à travers des galeries, événements et publications.</li>
                <li>Préparer l’ajout futur d’abonnements, paiements et nouveaux services.</li>
            </ul>
        </section>

        <!-- Types d’utilisateurs -->
        <section>
            <h2>Types d’utilisateurs</h2>
            <ul>
                <li><strong>Visiteurs :</strong> consultent les informations publiques et peuvent commenter.</li>
                <li><strong>Utilisateurs inscrits :</strong> accèdent à plus de contenu (événements, galeries, publications, publicités).</li>
                <li>
                    <strong>Administrateurs :</strong> trois niveaux d’accès :
                    <ul>
                        <li><strong>Niveau 1 :</strong> gestion des utilisateurs et commentaires.</li>
                        <li><strong>Niveau 2 :</strong> gestion des événements, galeries et publications.</li>
                        <li><strong>Niveau 3 :</strong> supervision générale et statistiques.</li>
                    </ul>
                </li>
            </ul>
        </section>

        <!-- Fonctionnalités principales -->
        <section>
            <h2>Fonctionnalités principales</h2>
            <ul>
                <li>Gestion des utilisateurs et profils personnalisés.</li>
                <li>Page de commentaires publique et modérée.</li>
                <li>Module de gestion d’événements et galeries photos.</li>
                <li>Publications et publicités de la chorale.</li>
                <li>Tableau de bord statistique pour administrateurs.</li>
                <li>Mises à jour prévues : abonnements, paiements et factures.</li>
                <li>Page d'aide et guide d'utilisation pour une meilleur experience.</li>
            </ul>
        </section>

        <!-- Évolution -->
        <section>
            <h2>Évolution et mises à jour</h2>
            <p>
                L’application évolue continuellement, avec des
                <strong>mises à jour régulières</strong> pour améliorer la sécurité,
                les performances et introduire de nouvelles fonctionnalités selon les besoins.
            </p>
        </section>

        <!-- Conception et design -->
        <section>
            <h2>Conception et design</h2>
            <p>
                Développée et conçue par <strong>LOUFOUTOU GPA Élysée Sagesse</strong>,
                responsable du développement complet (analyse, conception, intégration et programmation).
            </p>
            <p>
                <strong>LOUZOLO PAMBOU Paolo Curtis</strong> a apporté ses idées créatives
                (logo, couleurs, pages Statistiques et Commentaires), intégrées par Élysée.
            </p>
        </section>

        <!-- Contact -->
        <section class="credit">
            <h2>Contact</h2>
            <p>
                📧 Gmail :
      <a href="https://mail.google.com/mail/?view=cm&to=sagesseloufoutou@gmail.com" target="_blank">
       sagesseloufoutou@gmail.com
        </a>
            </p>
            <p>© {{ date('Y') }} Chorale Foi Parfaite — Tous droits réservés.</p>
        </section>
    </main>
</body>
</html>
