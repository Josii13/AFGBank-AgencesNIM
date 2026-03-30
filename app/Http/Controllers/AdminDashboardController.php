<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\PageVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalVisits   = PageVisit::count();
        $todayVisits   = PageVisit::whereDate('created_at', today())->count();
        $totalLeads    = Lead::count();
        $newLeads      = Lead::where('statut', 'nouveau')->count();

        // Visites par jour sur les 14 derniers jours
        $visitsByDay = PageVisit::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(13))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $chartLabels = [];
        $chartData   = [];
        for ($i = 13; $i >= 0; $i--) {
            $date          = now()->subDays($i)->format('Y-m-d');
            $chartLabels[] = now()->subDays($i)->format('d/m');
            $chartData[]   = $visitsByDay[$date]->count ?? 0;
        }

        // Leads par statut
        $leadsByStatut = Lead::select('statut', DB::raw('COUNT(*) as count'))
            ->groupBy('statut')
            ->pluck('count', 'statut')
            ->toArray();

        $recentLeads = Lead::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalVisits', 'todayVisits', 'totalLeads', 'newLeads',
            'chartLabels', 'chartData', 'leadsByStatut', 'recentLeads'
        ));
    }

    public function leads(Request $request)
    {
        $query = Lead::latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('est_client')) {
            $query->where('est_client', $request->est_client);
        }
        if ($request->filled('souhaite_contact')) {
            $query->where('souhaite_contact', $request->souhaite_contact);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom_prenoms', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telephone', 'like', "%{$search}%");
            });
        }

        $leads = $query->paginate(20)->withQueryString();

        return view('admin.leads', compact('leads'));
    }

    public function showLead(Lead $lead)
    {
        return view('admin.lead-show', compact('lead'));
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $request->validate(['statut' => ['required', 'in:nouveau,en_cours,traite']]);

        $lead->update([
            'statut' => $request->statut,
            'notes'  => $request->notes,
        ]);

        return back()->with('success', 'Statut mis à jour.');
    }

    public function exportCsv(Request $request)
    {
        $query = Lead::latest();

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        $leads = $query->get();

        $filename = 'leads-afg-' . now()->format('Y-m-d') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($leads) {
            $file = fopen('php://output', 'w');
            // BOM UTF-8 pour Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['ID', 'Nom & Prénoms', 'Téléphone', 'Email', 'Client AFG', 'N° Compte', 'Souhaite contact', 'Statut', 'Date'], ';');

            foreach ($leads as $lead) {
                fputcsv($file, [
                    $lead->id,
                    $lead->nom_prenoms,
                    $lead->telephone,
                    $lead->email,
                    $lead->est_client_label,
                    $lead->numero_compte ?? '',
                    $lead->souhaite_contact === 'oui' ? 'Oui' : 'Non',
                    $lead->statut_label,
                    $lead->created_at->format('d/m/Y H:i'),
                ], ';');
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
