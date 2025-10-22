<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'pseudo',
        'contenu',
        'user_id',
        'parent_id', // Pour les réponses de commentaires
    ];

    /**
     * 🔁 Relation vers l’auteur du commentaire (si connecté)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 🔁 Relation vers le parent (si c’est une réponse à un autre commentaire)
     */
    public function parent()
    {
        return $this->belongsTo(Commentaire::class, 'parent_id');
    }

    /**
     * 🔁 Relation vers les réponses associées à ce commentaire
     */
    public function reponses()
    {
        return $this->hasMany(Commentaire::class, 'parent_id');
    }
}
