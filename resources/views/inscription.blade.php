<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rejoignez AFG Bank – Inscription</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Instrument Sans', sans-serif; }
        .afg-green { color: #00A651; }
        .afg-red { color: #E30613; }
        .bg-afg-green { background-color: #00A651; }
        .bg-afg-red { background-color: #E30613; }
        .border-afg-green { border-color: #00A651; }

        /* Input focus */
        .form-input:focus {
            outline: none;
            border-color: #00A651;
            box-shadow: 0 0 0 3px rgba(0, 166, 81, 0.12);
        }

        /* Radio card */
        .radio-card input[type="radio"]:checked + label {
            border-color: #00A651;
            background-color: #f0fdf4;
        }

        /* Modal animation */
        #modal.show { opacity: 1; pointer-events: all; }
        #modal.show .modal-box { transform: scale(1); opacity: 1; }
        #modal { opacity: 0; pointer-events: none; transition: opacity 0.2s; }
        #modal .modal-box { transform: scale(0.95); opacity: 0; transition: transform 0.25s ease, opacity 0.25s ease; }

        /* Spinner */
        .spinner {
            width: 20px; height: 20px;
            border: 2px solid rgba(255,255,255,0.4);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            display: none;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    {{-- Header --}}
    <header class="bg-white shadow-sm sticky top-0 z-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center">
            <img src="{{ asset('images/new_logo_afg.png') }}" alt="AFG Bank" class="h-10 sm:h-12">
        </div>
    </header>

    {{-- Formulaire --}}
    <section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-0 py-10 sm:py-14">
        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Rejoignez AFG Bank</h1>
            <p class="mt-2 text-gray-500 text-sm sm:text-base">
                Remplissez ce formulaire et un conseiller vous contactera pour vous accompagner dans vos démarches.
            </p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 sm:p-10">
            <h2 class="text-base font-semibold text-gray-700 mb-6 pb-4 border-b border-gray-100">Vos informations</h2>

            <div id="form-error" class="hidden mb-5 bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3"></div>

            <form id="inscriptionForm" novalidate>
                @csrf

                {{-- Nom & Téléphone côte à côte sur sm+ --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                    <div>
                        <label for="nom_prenoms" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Nom & Prénoms <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="nom_prenoms"
                            name="nom_prenoms"
                            autocomplete="name"
                            placeholder="Ex : Rakoto Jean"
                            class="form-input w-full border border-gray-300 rounded-xl px-4 py-3 text-sm transition-all"
                        >
                        <p class="field-error hidden text-red-500 text-xs mt-1"></p>
                    </div>
                    <div>
                        <label for="telephone" class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Téléphone <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="tel"
                            id="telephone"
                            name="telephone"
                            autocomplete="tel"
                            placeholder="Ex : +261 34 00 000 00"
                            class="form-input w-full border border-gray-300 rounded-xl px-4 py-3 text-sm transition-all"
                        >
                        <p class="field-error hidden text-red-500 text-xs mt-1"></p>
                    </div>
                </div>

                {{-- Email --}}
                <div class="mb-5">
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Adresse email <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        autocomplete="email"
                        placeholder="Ex : rakoto@email.com"
                        class="form-input w-full border border-gray-300 rounded-xl px-4 py-3 text-sm transition-all"
                    >
                    <p class="field-error hidden text-red-500 text-xs mt-1"></p>
                </div>

                {{-- Êtes-vous déjà client ? --}}
                <div class="mb-5">
                    <p class="text-sm font-semibold text-gray-700 mb-2.5">
                        Êtes-vous déjà client AFG Bank ? <span class="text-red-500">*</span>
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div class="radio-card">
                            <input type="radio" id="client_oui" name="est_client" value="oui_reactiver" class="sr-only">
                            <label for="client_oui" class="block border-2 border-gray-200 rounded-xl px-4 py-3.5 cursor-pointer transition-all hover:border-green-300">
                                <span class="block text-sm font-semibold text-gray-800">Oui</span>
                                <span class="block text-xs text-gray-500 mt-0.5">et je souhaite réactiver mon compte</span>
                            </label>
                        </div>
                        <div class="radio-card">
                            <input type="radio" id="client_non" name="est_client" value="non" class="sr-only">
                            <label for="client_non" class="block border-2 border-gray-200 rounded-xl px-4 py-3.5 cursor-pointer transition-all hover:border-green-300">
                                <span class="block text-sm font-semibold text-gray-800">Non</span>
                                <span class="block text-xs text-gray-500 mt-0.5">je ne suis pas encore client</span>
                            </label>
                        </div>
                    </div>
                    <p class="field-error-client hidden text-red-500 text-xs mt-1"></p>
                </div>

                {{-- N° de compte (conditionnel) --}}
                <div id="compte-field" class="mb-5 hidden">
                    <label for="numero_compte" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        N° de compte <span class="text-gray-400 font-normal">(optionnel)</span>
                    </label>
                    <input
                        type="text"
                        id="numero_compte"
                        name="numero_compte"
                        placeholder="Ex : 001-123456789"
                        class="form-input w-full border border-gray-300 rounded-xl px-4 py-3 text-sm transition-all"
                    >
                </div>

                {{-- Souhaite être contacté ? --}}
                <div class="mb-7">
                    <p class="text-sm font-semibold text-gray-700 mb-2.5">
                        Souhaitez-vous être contacté par un conseiller ? <span class="text-red-500">*</span>
                    </p>
                    <div class="grid grid-cols-2 gap-3">
                        <div class="radio-card">
                            <input type="radio" id="contact_oui" name="souhaite_contact" value="oui" class="sr-only">
                            <label for="contact_oui" class="block border-2 border-gray-200 rounded-xl px-4 py-3 cursor-pointer transition-all hover:border-green-300 text-center">
                                <span class="text-sm font-semibold text-gray-800">Oui</span>
                            </label>
                        </div>
                        <div class="radio-card">
                            <input type="radio" id="contact_non" name="souhaite_contact" value="non" class="sr-only">
                            <label for="contact_non" class="block border-2 border-gray-200 rounded-xl px-4 py-3 cursor-pointer transition-all hover:border-green-300 text-center">
                                <span class="text-sm font-semibold text-gray-800">Non</span>
                            </label>
                        </div>
                    </div>
                    <p class="field-error-contact hidden text-red-500 text-xs mt-1"></p>
                </div>

                {{-- Submit --}}
                <button
                    type="submit"
                    id="submitBtn"
                    class="w-full bg-afg-green hover:bg-green-700 text-white font-bold py-4 rounded-xl text-base transition-colors flex items-center justify-center gap-3"
                >
                    <span id="btnText">Envoyer ma demande</span>
                    <span class="spinner" id="btnSpinner"></span>
                </button>
            </form>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="text-center py-6 text-sm text-gray-400">
        © {{ date('Y') }} AFG Bank – Atlantic Group
    </footer>

    {{-- Modal de confirmation --}}
    <div id="modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4" role="dialog" aria-modal="true">
        <div class="modal-box bg-white rounded-2xl shadow-xl max-w-md w-full p-8 text-center">
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-5">
                <svg class="w-8 h-8 text-[#00A651]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Demande envoyée !</h3>
            <p class="text-gray-500 text-sm mb-6">
                Merci pour votre intérêt. Notre équipe prendra contact avec vous dans les plus brefs délais.
            </p>
            <button
                onclick="closeModal()"
                class="w-full bg-afg-green hover:bg-green-700 text-white font-semibold py-3 rounded-xl transition-colors"
            >
                Fermer
            </button>
        </div>
    </div>

    <script>
        // Affichage conditionnel du champ N° de compte
        document.querySelectorAll('input[name="est_client"]').forEach(radio => {
            radio.addEventListener('change', function () {
                const compteField = document.getElementById('compte-field');
                compteField.classList.toggle('hidden', this.value !== 'oui_reactiver');
            });
        });

        // Soumission du formulaire
        document.getElementById('inscriptionForm').addEventListener('submit', async function (e) {
            e.preventDefault();
            clearErrors();

            if (!validateForm()) return;

            const btn     = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const spinner = document.getElementById('btnSpinner');

            btn.disabled      = true;
            btnText.textContent = 'Envoi en cours…';
            spinner.style.display = 'block';

            const formData = new FormData(this);

            try {
                const res = await fetch('/inscription', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData,
                });

                if (res.ok) {
                    showModal();
                    this.reset();
                    document.getElementById('compte-field').classList.add('hidden');
                    // Reset radio card styles
                    document.querySelectorAll('.radio-card label').forEach(l => {
                        l.classList.remove('border-[#00A651]', 'bg-[#f0fdf4]');
                    });
                } else {
                    const data = await res.json();
                    if (data.errors) {
                        displayServerErrors(data.errors);
                    } else {
                        showGlobalError('Une erreur est survenue. Veuillez réessayer.');
                    }
                }
            } catch (err) {
                showGlobalError('Erreur de connexion. Veuillez vérifier votre connexion internet.');
            } finally {
                btn.disabled = false;
                btnText.textContent = 'Envoyer ma demande';
                spinner.style.display = 'none';
            }
        });

        function validateForm() {
            let valid = true;

            const nom = document.getElementById('nom_prenoms');
            if (!nom.value.trim()) {
                showFieldError(nom, 'Ce champ est obligatoire.');
                valid = false;
            }

            const tel = document.getElementById('telephone');
            if (!tel.value.trim()) {
                showFieldError(tel, 'Ce champ est obligatoire.');
                valid = false;
            }

            const email = document.getElementById('email');
            if (!email.value.trim()) {
                showFieldError(email, 'Ce champ est obligatoire.');
                valid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                showFieldError(email, 'Adresse email invalide.');
                valid = false;
            }

            if (!document.querySelector('input[name="est_client"]:checked')) {
                document.querySelector('.field-error-client').textContent = 'Veuillez sélectionner une option.';
                document.querySelector('.field-error-client').classList.remove('hidden');
                valid = false;
            }

            if (!document.querySelector('input[name="souhaite_contact"]:checked')) {
                document.querySelector('.field-error-contact').textContent = 'Veuillez sélectionner une option.';
                document.querySelector('.field-error-contact').classList.remove('hidden');
                valid = false;
            }

            return valid;
        }

        function showFieldError(input, msg) {
            input.classList.add('border-red-400');
            const err = input.nextElementSibling;
            if (err && err.classList.contains('field-error')) {
                err.textContent = msg;
                err.classList.remove('hidden');
            }
        }

        function clearErrors() {
            document.querySelectorAll('.field-error, .field-error-client, .field-error-contact').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });
            document.querySelectorAll('.form-input').forEach(el => el.classList.remove('border-red-400'));
            document.getElementById('form-error').classList.add('hidden');
        }

        function showGlobalError(msg) {
            const el = document.getElementById('form-error');
            el.textContent = msg;
            el.classList.remove('hidden');
        }

        function displayServerErrors(errors) {
            const map = {
                nom_prenoms:      document.getElementById('nom_prenoms'),
                telephone:        document.getElementById('telephone'),
                email:            document.getElementById('email'),
            };
            Object.entries(errors).forEach(([field, msgs]) => {
                if (map[field]) showFieldError(map[field], msgs[0]);
            });
        }

        function showModal() {
            document.getElementById('modal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('modal').classList.remove('show');
        }

        // Fermer modal en cliquant dehors
        document.getElementById('modal').addEventListener('click', function (e) {
            if (e.target === this) closeModal();
        });
    </script>
</body>
</html>
