<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $galerie->titre }}</title>

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

    /* ================== Grille des images ================== */
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
        display: flex;
        flex-direction: column;
        transition: transform 0.2s;
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

    .card-body p {
        margin: 5px 0;
        color: #666;
        font-size: 0.95rem;
    }

</style>
</head>

<body>

<div class="container">

    <!-- Titre de la galerie -->
    <h1>{{ $galerie->titre }}</h1>

    <!-- Grille contenant toutes les images de la galerie -->
    <div class="gallery-grid">

        @foreach($galerie->images as $image)
            <div class="gallery-card">

                <!-- Image -->
                <img src="{{ asset('storage/' . $image->image) }}" alt="Image galerie">

                <!-- Description optionnelle -->
                @if($image->description)
                    <div class="card-body">
                        <p>{{ $image->description }}</p>
                    </div>
                @endif

            </div>
        @endforeach

    </div>

</div>

</body>
</html>
