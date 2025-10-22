<?php

namespace App\Traits;

use App\Models\Visit;

trait LogsVisits
{
    /**
     * Enregistre une visite pour une page donnée
     *
     * @param string $page Nom de la page visitée
     */
    public function logVisit(string $page)
    {
        Visit::create([
            'ip_address' => request()->ip(),
            'page_visited' => $page,
        ]);
    }
}
