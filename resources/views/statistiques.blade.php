<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Statistiques - Chorale</title>
<style>
/* ================== Base ================== */
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
body { background:#f4f6f8; color:#333; line-height:1.6; padding:20px; }
h1, h2, h3 { margin-bottom:15px; }
h1 { text-align:center; font-size:2.5rem; color:#2c3e50; margin-bottom:30px; }
h2 { color:#34495e; border-bottom:2px solid #3498db; padding-bottom:5px; }
h3 { color:#34495e; margin-top:20px; margin-bottom:10px; }
.container { max-width:900px; margin:0 auto; background:#fff; padding:25px 30px; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.1); }

/* ================== Listes ================== */
ul { list-style:none; margin-bottom:20px; }
ul li { background:#ecf0f1; margin-bottom:8px; padding:12px 15px; border-radius:8px; display:flex; justify-content:space-between; transition:0.3s; }
ul li:hover { background:#d0e6f7; }

/* ================== Pagination ================== */
.pagination { display:flex; justify-content:center; gap:8px; margin-top:20px; }
.pagination a, .pagination span { padding:8px 12px; border-radius:5px; border:1px solid #ccc; color:#007bff; text-decoration:none; transition:0.3s; }
.pagination a:hover { background:#007bff; color:#fff; }
.pagination span { background:#6c757d; color:#fff; border-color:#6c757d; }

/* ================== Sections ================== */
.section { margin-bottom:30px; }

@media(max-width:600px){
    body { padding:10px; }
    .container { padding:15px; }
    h1 { font-size:2rem; }
    ul li { flex-direction:column; align-items:flex-start; gap:5px; }
}
</style>
</head>
<body>

<div class="container">
    <h1>Statistiques des visiteurs et utilisateurs - Chorale</h1>

    <!-- ================== Visiteurs ================== -->
    <div class="section">
        <h2>Visiteurs</h2>
        <p>Total des visites : <strong>{{ $totalVisits }}</strong></p>
        <p>Visiteurs uniques : <strong>{{ $uniqueVisitors }}</strong></p>

        <h3>Pages les plus visitées :</h3>
        <ul>
            @foreach($visitsByPage as $visit)
                <li>
                    <span>{{ $visit->page_visited }}</span>
                    <span>{{ $visit->total }} visites</span>
                </li>
            @endforeach
        </ul>

        <!-- Pagination simple Visiteurs -->
        <div class="pagination">
            {{ $visitsByPage->links('pagination::simple-default') }}
        </div>
    </div>

    <!-- ================== Connexions utilisateurs ================== -->
    <div class="section">
        <h2>Connexions utilisateurs récentes</h2>
        <ul>
            @foreach($logins as $login)
                <li>
                    <span>{{ $login->name }}</span>
                    <span>Connecté le {{ $login->logged_in_at }}</span>
                </li>
            @endforeach
        </ul>

        <!-- Pagination simple Utilisateurs -->
        <div class="pagination">
            {{ $logins->links('pagination::simple-default') }}
        </div>
    </div>
</div>

</body>
</html>
