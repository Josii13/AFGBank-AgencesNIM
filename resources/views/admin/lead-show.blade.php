@extends('admin.layout')

@section('title', 'Demande #' . $lead->id)

@section('content')

<div class="mb-5">
    <a href="{{ route('admin.leads') }}" class="text-sm text-gray-500 hover:text-[#00A651] flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Retour à la liste
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Infos lead --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="text-base font-semibold text-gray-800 mb-5">Informations du demandeur</h2>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Nom & Prénoms</p>
                <p class="text-sm font-medium text-gray-800">{{ $lead->nom_prenoms }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Téléphone</p>
                <p class="text-sm font-medium text-gray-800">{{ $lead->telephone }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Email</p>
                <p class="text-sm font-medium text-gray-800">{{ $lead->email }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Date de soumission</p>
                <p class="text-sm font-medium text-gray-800">{{ $lead->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Déjà client AFG Bank ?</p>
                @if($lead->est_client === 'oui_reactiver')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs bg-green-100 text-green-800 font-medium">Oui – souhaite réactiver</span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs bg-gray-100 text-gray-600 font-medium">Non</span>
                @endif
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Souhaite être contacté ?</p>
                @if($lead->souhaite_contact === 'oui')
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs bg-blue-100 text-blue-800 font-medium">Oui</span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs bg-gray-100 text-gray-600 font-medium">Non</span>
                @endif
            </div>
            @if($lead->numero_compte)
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">N° de compte</p>
                <p class="text-sm font-medium text-gray-800">{{ $lead->numero_compte }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Traitement --}}
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h2 class="text-base font-semibold text-gray-800 mb-5">Traitement</h2>
        <form method="POST" action="{{ route('admin.leads.status', $lead) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">Statut</label>
                <select name="statut" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651]">
                    <option value="nouveau" {{ $lead->statut === 'nouveau' ? 'selected' : '' }}>Nouveau</option>
                    <option value="en_cours" {{ $lead->statut === 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="traite" {{ $lead->statut === 'traite' ? 'selected' : '' }}>Traité</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">Notes internes</label>
                <textarea
                    name="notes"
                    rows="5"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651] resize-none"
                    placeholder="Ajouter une note…"
                >{{ $lead->notes }}</textarea>
            </div>
            <button type="submit" class="w-full bg-[#00A651] text-white text-sm font-semibold py-2.5 rounded-lg hover:bg-[#008c44] transition-colors">
                Enregistrer
            </button>
        </form>
    </div>
</div>

@endsection
