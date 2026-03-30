<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin – AFG Bank</title>
    @php
        $manifest = json_decode(file_get_contents(public_path('build/manifest.json')), true);
        $cssFile = $manifest['resources/css/app.css']['file'] ?? null;
    @endphp
    @if($cssFile)
        <link rel="stylesheet" href="{{ secure_asset('build/' . $cssFile) }}">
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <div class="w-full max-w-sm">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

            {{-- Logo + titre --}}
            <div class="px-8 pt-8 pb-6 text-center border-b border-gray-100">
                <img src="{{ asset('images/new_logo_afg.png') }}" alt="AFG Bank" class="h-12 mx-auto">
                <p class="text-gray-500 text-sm mt-3 font-medium">Espace Administration</p>
            </div>

            {{-- Formulaire --}}
            <div class="px-6 sm:px-8 py-7">
                <h1 class="text-lg font-bold text-gray-800 mb-5">Connexion</h1>

                @if($errors->has('password'))
                    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-5">
                        {{ $errors->first('password') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.login.post') }}">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Mot de passe</label>
                        <input
                            type="password"
                            name="password"
                            autofocus
                            class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#00A651] focus:border-transparent transition-all"
                            placeholder="••••••••"
                        >
                    </div>
                    <button
                        type="submit"
                        class="w-full bg-[#00A651] hover:bg-[#008c44] text-white font-semibold py-3 rounded-xl transition-colors text-sm"
                    >
                        Se connecter
                    </button>
                </form>
            </div>
        </div>
        <p class="text-center text-xs text-gray-400 mt-4">© {{ date('Y') }} AFG Bank – Atlantic Group</p>
    </div>
</body>
</html>
