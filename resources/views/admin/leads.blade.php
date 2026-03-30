@extends('admin.layout')

@section('title', 'Demandes')

@section('content')

{{-- Filtres + Export --}}
<form method="GET" action="{{ route('admin.leads') }}" class="bg-white rounded-xl border border-gray-200 p-5 mb-6">
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="lg:col-span-2">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Rechercher par nom, email, téléphone…"
                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651] focus:border-transparent"
            >
        </div>
        <select name="statut" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651]">
            <option value="">Tous les statuts</option>
            <option value="nouveau" {{ request('statut') === 'nouveau' ? 'selected' : '' }}>Nouveau</option>
            <option value="en_cours" {{ request('statut') === 'en_cours' ? 'selected' : '' }}>En cours</option>
            <option value="traite" {{ request('statut') === 'traite' ? 'selected' : '' }}>Traité</option>
        </select>
        <select name="est_client" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651]">
            <option value="">Client ?</option>
            <option value="oui_reactiver" {{ request('est_client') === 'oui_reactiver' ? 'selected' : '' }}>Oui – réactivation</option>
            <option value="non" {{ request('est_client') === 'non' ? 'selected' : '' }}>Non</option>
        </select>
        <select name="souhaite_contact" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651]">
            <option value="">Contact ?</option>
            <option value="oui" {{ request('souhaite_contact') === 'oui' ? 'selected' : '' }}>Oui</option>
            <option value="non" {{ request('souhaite_contact') === 'non' ? 'selected' : '' }}>Non</option>
        </select>
    </div>
    <div class="flex items-center gap-3 mt-4">
        <button type="submit" class="bg-[#00A651] text-white text-sm font-medium px-5 py-2 rounded-lg hover:bg-[#008c44] transition-colors">
            Filtrer
        </button>
        <a href="{{ route('admin.leads') }}" class="text-sm text-gray-500 hover:text-gray-700">Réinitialiser</a>
        <div class="ml-auto">
            <a href="{{ route('admin.leads.export') }}?{{ http_build_query(request()->only('statut', 'est_client', 'souhaite_contact')) }}"
               class="inline-flex items-center gap-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Exporter CSV
            </a>
        </div>
    </div>
</form>

{{-- Tableau --}}
<div class="bg-white rounded-xl border border-gray-200">
    <div class="px-6 py-4 border-b border-gray-100">
        <p class="text-sm text-gray-500">{{ $leads->total() }} demande(s)</p>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">#</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Nom & Prénoms</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Téléphone</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Email</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Client AFG</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Contact</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Statut</th>
                    <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase">Date</th>
                    <th class="px-6 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($leads as $lead)
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-gray-400 text-xs">{{ $lead->id }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $lead->nom_prenoms }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $lead->telephone }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $lead->email }}</td>
                    <td class="px-6 py-4">
                        @if($lead->est_client === 'oui_reactiver')
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs bg-green-100 text-green-800">Oui – réactivation</span>
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
                    <td class="px-6 py-4 text-gray-400 text-xs whitespace-nowrap">{{ $lead->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.leads.show', $lead) }}" class="text-[#00A651] hover:underline text-xs font-medium">
                            Voir →
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-10 text-center text-gray-400">Aucune demande trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($leads->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
        {{ $leads->links() }}
    </div>
    @endif
</div>

@endsection
