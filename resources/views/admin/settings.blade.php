@extends('admin.layout')

@section('title', 'Paramètres')

@section('content')

@if($errors->has('smtp'))
    <div class="mb-5 bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg px-4 py-3">
        {{ $errors->first('smtp') }}
    </div>
@endif

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Email de réception --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-semibold text-gray-800 mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#00A651]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Réception des demandes
            </h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">Email de réception <span class="text-red-500">*</span></label>
                    <input type="email" name="mail_to" value="{{ old('mail_to', $settings['mail_to'] ?? '') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651] @error('mail_to') border-red-400 @enderror"
                        placeholder="contact@afgbank.mg">
                    @error('mail_to')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">Nom expéditeur <span class="text-red-500">*</span></label>
                    <input type="text" name="mail_from_name" value="{{ old('mail_from_name', $settings['mail_from_name'] ?? 'AFG Bank') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651]"
                        placeholder="AFG Bank">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">Email expéditeur <span class="text-red-500">*</span></label>
                    <input type="email" name="mail_from_address" value="{{ old('mail_from_address', $settings['mail_from_address'] ?? '') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651] @error('mail_from_address') border-red-400 @enderror"
                        placeholder="noreply@afgbank.mg">
                    @error('mail_from_address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- SMTP --}}
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h2 class="text-base font-semibold text-gray-800 mb-5 flex items-center gap-2">
                <svg class="w-5 h-5 text-[#00A651]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/>
                </svg>
                Configuration SMTP
            </h2>
            <div class="space-y-4">
                <div class="grid grid-cols-3 gap-3">
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">Hôte SMTP <span class="text-red-500">*</span></label>
                        <input type="text" name="smtp_host" value="{{ old('smtp_host', $settings['smtp_host'] ?? '') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651]"
                            placeholder="smtp.example.com">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">Port <span class="text-red-500">*</span></label>
                        <input type="number" name="smtp_port" value="{{ old('smtp_port', $settings['smtp_port'] ?? '587') }}"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651]"
                            placeholder="587">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">Utilisateur SMTP</label>
                    <input type="text" name="smtp_username" value="{{ old('smtp_username', $settings['smtp_username'] ?? '') }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651]"
                        placeholder="user@example.com">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">Mot de passe SMTP</label>
                    <input type="password" name="smtp_password"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651]"
                        placeholder="Laisser vide pour conserver l'actuel">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1 uppercase tracking-wide">Chiffrement <span class="text-red-500">*</span></label>
                    <select name="smtp_encryption" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651]">
                        <option value="tls" {{ ($settings['smtp_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS</option>
                        <option value="ssl" {{ ($settings['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                        <option value="none" {{ ($settings['smtp_encryption'] ?? '') === 'none' ? 'selected' : '' }}>Aucun</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Actions --}}
    <div class="mt-6 flex items-center gap-4">
        <button type="submit" class="bg-[#00A651] text-white font-semibold px-6 py-2.5 rounded-lg hover:bg-[#008c44] transition-colors">
            Enregistrer les paramètres
        </button>
        <a href="{{ route('admin.settings.test') }}" onclick="return confirm('Envoyer un mail de test à l\'adresse configurée ?')"
           class="bg-white border border-gray-300 text-gray-700 font-medium px-5 py-2.5 rounded-lg hover:bg-gray-50 transition-colors text-sm">
            Tester l'envoi
        </a>
    </div>
</form>

@endsection
