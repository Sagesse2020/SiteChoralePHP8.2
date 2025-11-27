<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Galeries</title>

<style>
    /* ================== Base ================== */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f7fa;
        margin: 0;
        padding: 0;
        color: #333;
    }

    .container {
        width: 90%;
        max-width: 1200px;
        margin: 50px auto;
        padding: 30px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    h1 {
        text-align: center;
        color: #007bff;
        margin-bottom: 40px;
    }

    /* ================== Grille des galeries ================== */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }

    .gallery-card {
        background-color: #fff;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        transition: transform 0.2s;
        display: flex;
        flex-direction: column;
    }

    .gallery-card:hover {
        transform: scale(1.03);
    }

    .gallery-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        display: block;
        border-bottom: 1px solid #eee;
    }

    .card-body {
        padding: 10px;
        text-align: center;
    }

    .card-body h4 {
        margin: 0 0 5px 0;
        color: #333;
        font-size: 1rem;
    }

    .card-body p {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
    }

    .empty-message {
        text-align: center;
        font-size: 1.2rem;
        color: #d9534f;
        margin-top: 50px;
    }

</style>
</head>

<body>

<div class="container">

    <h1>Toutes les galeries</h1>

    @if($galeries->isEmpty())
        <p class="empty-message">Aucune image disponible au niveau des galeries.</p>
    @else
        <div class="gallery-grid">

            @foreach($galeries as $galerie)
                <div class="gallery-card">

                    <!-- Aperçu : première image de la galerie -->
                    @if($galerie->images->first())
                        <a href="{{ route('galeries.show', $galerie) }}">
                            <img src="{{ asset('storage/' . $galerie->images->first()->image) }}" alt="{{ $galerie->titre }}">
                        </a>
                    @endif

                    <!-- Informations sur la galerie -->
                    <div class="card-body">
                        <h4>{{ $galerie->titre }}</h4>
                        <p><strong>Date :</strong> {{ $galerie->evenement->date ?? 'Non spécifiée' }}</p>
                    </div>

                </div>
            @endforeach

        </div>

        <!-- Pagination -->
        <div style="margin-top:30px; text-align:center;">
            {{ $galeries->links() }}
        </div>
    @endif

</div>

</body>
</html>
