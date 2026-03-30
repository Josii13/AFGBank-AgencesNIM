<?php

namespace App\Http\Controllers;

use App\Http\Requests\InscriptionRequest;
use App\Mail\LeadSubmitted;
use App\Models\Lead;
use App\Models\PageVisit;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InscriptionController extends Controller
{
    public function index(Request $request)
    {
        PageVisit::create([
            'page'       => '/inscription',
            'ip'         => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return view('inscription');
    }

    public function store(InscriptionRequest $request)
    {
        $lead = Lead::create($request->validated());

        $this->sendNotificationMail($lead);

        return response()->json(['success' => true]);
    }

    private function sendNotificationMail(Lead $lead): void
    {
        $settings = Setting::allKeyed();

        $mailTo = $settings['mail_to'] ?? null;

        if (empty($mailTo)) {
            return;
        }

        // Reconfigurer le mailer dynamiquement avec les paramètres sauvegardés
        config([
            'mail.mailers.smtp.host'       => $settings['smtp_host'] ?? '',
            'mail.mailers.smtp.port'       => $settings['smtp_port'] ?? 587,
            'mail.mailers.smtp.username'   => $settings['smtp_username'] ?? '',
            'mail.mailers.smtp.password'   => $settings['smtp_password'] ?? '',
            'mail.mailers.smtp.encryption' => $settings['smtp_encryption'] ?? 'tls',
            'mail.from.address'            => $settings['mail_from_address'] ?? '',
            'mail.from.name'               => $settings['mail_from_name'] ?? 'AFG Bank',
        ]);

        try {
            Mail::to($mailTo)->send(new LeadSubmitted($lead));
        } catch (\Exception $e) {
            // Ne pas bloquer la soumission si le mail échoue
            \Log::error('Erreur envoi mail lead: ' . $e->getMessage());
        }
    }
}
