<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Statistiques - Chorale</title>

<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Segoe UI',sans-serif;}

body{
    background:#f4f7fa;
    padding:20px;
}

.container{
    max-width:1000px;
    margin:auto;
}

h1{
    text-align:center;
    margin-bottom:30px;
    color:#2c3e50;
}

.card{
    background:white;
    padding:25px;
    border-radius:15px;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
    margin-bottom:25px;
}

.card h2{
    margin-bottom:15px;
    color:#0044cc;
}

.stats{
    display:flex;
    gap:20px;
    margin-bottom:20px;
    flex-wrap:wrap;
}

.stat-box{
    flex:1;
    min-width:200px;
    background:#eaf3ff;
    padding:15px;
    border-radius:10px;
    text-align:center;
}

.stat-box strong{
    font-size:22px;
    display:block;
    margin-top:5px;
}

ul{
    list-style:none;
}

ul li{
    padding:12px;
    border-bottom:1px solid #eee;
    display:flex;
    justify-content:space-between;
    flex-wrap:wrap;
}

ul li:last-child{
    border-bottom:none;
}

.pagination{
    margin-top:15px;
}

@media(max-width:600px){
    ul li{
        flex-direction:column;
        gap:5px;
    }
}
</style>
</head>
<body>

<div class="container">

<h1>Statistiques - Chorale</h1>

<div class="card">
<h2>Visiteurs</h2>

<div class="stats">
<div class="stat-box">
Total des visites
<strong>{{ $totalVisits }}</strong>
</div>

<div class="stat-box">
Visiteurs uniques
<strong>{{ $uniqueVisitors }}</strong>
</div>
</div>

<h3>Pages les plus visitées</h3>
<ul>
@foreach($visitsByPage as $visit)
<li>
<span>{{ $visit->page_visited }}</span>
<span>{{ $visit->total }} visites</span>
</li>
@endforeach
</ul>

<div class="pagination">
{{ $visitsByPage->links('pagination::simple-default') }}
</div>
</div>

<div class="card">
<h2>Connexions récentes</h2>

<ul>
@foreach($logins as $login)
<li>
<span>{{ $login->name }}</span>
<span>{{ $login->logged_in_at }}</span>
</li>
@endforeach
</ul>

<div class="pagination">
{{ $logins->links('pagination::simple-default') }}
</div>

</div>

</div>

</body>
</html>
