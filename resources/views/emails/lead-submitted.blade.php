<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nouvelle demande AFG Bank</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .header { background: #00A651; padding: 30px; text-align: center; }
        .header img { height: 50px; }
        .header h1 { color: #fff; margin: 12px 0 0; font-size: 20px; }
        .body { padding: 30px; }
        .body h2 { color: #00A651; font-size: 16px; margin-bottom: 20px; }
        .field { margin-bottom: 16px; border-bottom: 1px solid #f0f0f0; padding-bottom: 12px; }
        .field:last-child { border-bottom: none; }
        .label { font-size: 11px; text-transform: uppercase; color: #999; letter-spacing: 0.5px; margin-bottom: 4px; }
        .value { font-size: 15px; color: #222; font-weight: 500; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-green { background: #d1fae5; color: #065f46; }
        .badge-blue { background: #dbeafe; color: #1e40af; }
        .footer { background: #f9f9f9; padding: 16px 30px; text-align: center; font-size: 12px; color: #999; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('images/new_logo_afg.png') }}" alt="AFG Bank">
            <h1>Nouvelle demande de contact</h1>
        </div>
        <div class="body">
            <h2>Informations du demandeur</h2>

            <div class="field">
                <div class="label">Nom & Prénoms</div>
                <div class="value">{{ $lead->nom_prenoms }}</div>
            </div>

            <div class="field">
                <div class="label">Téléphone</div>
                <div class="value">{{ $lead->telephone }}</div>
            </div>

            <div class="field">
                <div class="label">Email</div>
                <div class="value">{{ $lead->email }}</div>
            </div>

            <div class="field">
                <div class="label">Déjà client AFG Bank ?</div>
                <div class="value">
                    @if($lead->est_client === 'oui_reactiver')
                        <span class="badge badge-green">Oui – souhaite réactiver son compte</span>
                    @else
                        <span class="badge badge-blue">Non</span>
                    @endif
                </div>
            </div>

            @if($lead->numero_compte)
            <div class="field">
                <div class="label">N° de compte</div>
                <div class="value">{{ $lead->numero_compte }}</div>
            </div>
            @endif

            <div class="field">
                <div class="label">Souhaite être contacté par un conseiller ?</div>
                <div class="value">
                    @if($lead->souhaite_contact === 'oui')
                        <span class="badge badge-green">Oui</span>
                    @else
                        <span class="badge" style="background:#fee2e2;color:#991b1b;">Non</span>
                    @endif
                </div>
            </div>

            <div class="field">
                <div class="label">Date de soumission</div>
                <div class="value">{{ $lead->created_at->format('d/m/Y à H:i') }}</div>
            </div>
        </div>
        <div class="footer">
            © {{ date('Y') }} AFG Bank – Atlantic Group &nbsp;|&nbsp; Ce mail a été généré automatiquement.
        </div>
    </div>
</body>
</html>
