<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ config('app.name') }} - Événements</title>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        h1 {
            text-align: center;
            font-size: 2.5rem;
            color: #0056b3;
            margin-top: 1.5rem;
        }

        .event-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
            max-width: 1400px;
            margin: auto;
        }

        .event-card {
            width: 100%;
            border-radius: 14px;
            overflow: hidden;
            background: white;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .event-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }

        .event-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            cursor: pointer;
            transition: transform 0.4s ease;
        }

        .event-card img:hover {
            transform: scale(1.07);
        }

        .event-info {
            padding: 1.5rem 1.5rem 2rem 1.5rem;
            display: flex;
            flex-direction: column;
        }

        .event-info h3 {
            margin: 0 0 0.5rem 0;
            font-size: 1.4rem;
            color: #0056b3;
        }

        .event-info p {
            color: #555;
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .badge {
            display: inline-block;
            padding: 0.25rem 0.7rem;
            font-size: 0.8rem;
            border-radius: 12px;
            background-color: #0078D4;
            color: white;
            margin-right: 0.3rem;
        }

        .badge.date { background-color: #28a745; }

        /* Boutons uniformes */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #0078D4;
            color: white;
            padding: 0.7rem 1.3rem;
            border-radius: 8px;
            font-size: 0.95rem;
            font-weight: 500;
            text-decoration: none;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
            cursor: pointer;
            border: none;
            width: 100px;
            text-align: center;
        }

        .btn:hover {
            background-color: #005fa3;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            padding-top: 60px;
            left: 0; top: 0;
            width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.85);
            overflow: auto;
        }

        .modal-content {
            margin: auto;
            display: block;
            max-width: 90%;
            max-height: 80vh;
            border-radius: 10px;
            box-shadow: 0 0 25px rgba(0,0,0,0.4);
        }

        .modal-caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 700px;
            text-align: center;
            color: #f1f1f1;
            padding: 10px 0;
            font-size: 1.1rem;
        }

        .modal-close {
            position: absolute;
            top: 20px;
            right: 35px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .modal-close:hover {
            color: #bbb;
        }

        /* Pagination */
        .pagination {
            text-align:center;
            margin:2rem 0;
        }
    </style>
</head>
<body>

<h1>🎶 Nos Événements</h1>

<div class="event-grid">
    @foreach($evenements as $event)
    <div class="event-card">
        <img
            src="{{ asset('storage/' . $event->image) }}"
            alt="{{ $event->titre }}"
            class="event-image"
            data-src="{{ asset('storage/' . $event->image) }}"
            data-title="{{ $event->titre }}"
        >
        <div class="event-info">
            <h3>{{ $event->titre }}</h3>
            <p>{{ Str::limit($event->description, 100) }}</p>
            <span class="badge">{{ $event->type }}</span>
            <span class="badge date">{{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}</span>

            <div style="margin-top: 1rem; display:flex; gap:5px;">
                <a href="{{ route('evenements.show', $event->id) }}" class="btn">Voir</a>
                <a href="{{ route('evenements.edit', $event->id) }}" class="btn">Modifier</a>
                <form action="{{ route('evenements.destroy', $event->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" onclick="return confirm('Voulez-vous vraiment supprimer cet événement ?')">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</div>

<!-- Modal pour image -->
<div id="imageModal" class="modal">
    <span class="modal-close">&times;</span>
    <img class="modal-content" id="modalImg" />
    <div class="modal-caption" id="caption"></div>
</div>

<script>
    const modal = document.getElementById('imageModal');
    const modalImg = document.getElementById('modalImg');
    const captionText = document.getElementById('caption');
    const closeBtn = document.getElementsByClassName('modal-close')[0];

    document.querySelectorAll('.event-image').forEach(img => {
        img.addEventListener('click', () => {
            modal.style.display = "block";
            modalImg.src = img.getAttribute('data-src');
            captionText.textContent = img.getAttribute('data-title');
        });
    });

    closeBtn.onclick = function() { modal.style.display = "none"; }
    modal.onclick = function(event) { if(event.target === modal) modal.style.display = "none"; }
</script>

<div class="pagination">
    {{ $evenements->links() }}
</div>

</body>
</html>
