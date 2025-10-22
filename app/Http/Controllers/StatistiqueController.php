<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visit;
use App\Models\User; // si tu veux récupérer les utilisateurs
use App\Models\LoginTemp; // si tu as ce modèle pour logins_temp

class StatistiqueController extends Controller
{
    public function index()
    {
        // Total des visites
        $totalVisits = Visit::count();

        // Visiteurs uniques
        $uniqueVisitors = Visit::distinct('ip_address')->count('ip_address');

        // Visites par page avec pagination simple
        $visitsByPage = Visit::select('page_visited', DB::raw('count(*) as total'))
            ->groupBy('page_visited')
            ->orderByDesc('total')
            ->paginate(10); // pagination simple dans la vue

        // Dernières connexions utilisateurs avec pagination simple
        $logins = DB::table('logins_temp')
            ->join('users', 'logins_temp.user_id', '=', 'users.id')
            ->select('users.name', 'logins_temp.logged_in_at')
            ->orderByDesc('logged_in_at')
            ->paginate(10);

        return view('statistiques', compact('totalVisits', 'uniqueVisitors', 'visitsByPage', 'logins'));
    }
}
