@extends('admin.layout')

@section('title', 'Tableau de bord')

@push('head')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@section('content')

{{-- Statistiques --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
    <div class="bg-white rounded-xl border border-gray-200 px-6 py-5">
        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Visites totales</p>
        <p class="text-3xl font-bold text-gray-800">{{ number_format($totalVisits) }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 px-6 py-5">
        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Visites aujourd'hui</p>
        <p class="text-3xl font-bold text-[#00A651]">{{ $todayVisits }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 px-6 py-5">
        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Demandes totales</p>
        <p class="text-3xl font-bold text-gray-800">{{ $totalLeads }}</p>
    </div>
    <div class="bg-white rounded-xl border border-gray-200 px-6 py-5">
        <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Nouvelles demandes</p>
        <p class="text-3xl font-bold text-blue-600">{{ $newLeads }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Graphique visites --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-4">Visites – 14 derniers jours</h2>
        <canvas id="visitsChart" height="80"></canvas>
    </div>

    {{-- Demandes par statut --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-4">Demandes par statut</h2>
        @php
            $statutColors = ['nouveau' => 'bg-blue-100 text-blue-800', 'en_cours' => 'bg-yellow-100 text-yellow-800', 'traite' => 'bg-green-100 text-green-800'];
            $statutLabels = ['nouveau' => 'Nouveau', 'en_cours' => 'En cours', 'traite' => 'Traité'];
        @endphp
        @forelse($leadsByStatut as $statut => $count)
            <div class="flex items-center justify-between mb-3">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statutColors[$statut] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $statutLabels[$statut] ?? $statut }}
                </span>
                <span class="text-lg font-bold text-gray-800">{{ $count }}</span>
            </div>
        @empty
            <p class="text-sm text-gray-400">Aucune demande pour l'instant.</p>
        @endforelse

        @if($totalLeads > 0)
            <div class="mt-4 pt-4 border-t border-gray-100">
                <a href="{{ route('admin.leads') }}" class="text-sm text-[#00A651] hover:underline font-medium">
                    Voir toutes les demandes →
                </a>
            </div>
        @endif
    </div>
</div>

{{-- Dernières demandes --}}
<div class="bg-white rounded-xl border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h2 class="text-sm font-semibold text-gray-700">Dernières demandes</h2>
        <a href="{{ route('admin.leads') }}" class="text-xs text-[#00A651] hover:underline">Voir tout</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nom</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Téléphone</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Client</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Contact</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($recentLeads as $lead)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-800">
                        <a href="{{ route('admin.leads.show', $lead) }}" class="hover:text-[#00A651]">{{ $lead->nom_prenoms }}</a>
                    </td>
                    <td class="px-6 py-4 text-gray-600">{{ $lead->telephone }}</td>
                    <td class="px-6 py-4">
                        @if($lead->est_client === 'oui_reactiver')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-800">Oui</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-600">Non</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($lead->souhaite_contact === 'oui')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-blue-100 text-blue-800">Oui</span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-gray-100 text-gray-600">Non</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $lead->statut_color }}">
                            {{ $lead->statut_label }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-xs">{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">Aucune demande pour l'instant.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('scripts')
<script>
const ctx = document.getElementById('visitsChart').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($chartLabels) !!},
        datasets: [{
            label: 'Visites',
            data: {!! json_encode($chartData) !!},
            borderColor: '#00A651',
            backgroundColor: 'rgba(0, 166, 81, 0.08)',
            borderWidth: 2,
            pointBackgroundColor: '#00A651',
            pointRadius: 4,
            tension: 0.4,
            fill: true,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: '#f3f4f6' } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush
