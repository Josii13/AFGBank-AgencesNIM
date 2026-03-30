<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::allKeyed();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'mail_to'           => ['required', 'email'],
            'mail_from_address' => ['required', 'email'],
            'mail_from_name'    => ['required', 'string', 'max:100'],
            'smtp_host'         => ['required', 'string', 'max:255'],
            'smtp_port'         => ['required', 'integer', 'min:1', 'max:65535'],
            'smtp_username'     => ['nullable', 'string', 'max:255'],
            'smtp_password'     => ['nullable', 'string', 'max:255'],
            'smtp_encryption'   => ['required', 'in:tls,ssl,none'],
        ]);

        $keys = ['mail_to', 'mail_from_address', 'mail_from_name', 'smtp_host', 'smtp_port', 'smtp_username', 'smtp_encryption'];

        foreach ($keys as $key) {
            Setting::set($key, $request->input($key));
        }

        // Mot de passe : ne pas écraser si vide
        if ($request->filled('smtp_password')) {
            Setting::set('smtp_password', $request->smtp_password);
        }

        return back()->with('success', 'Paramètres enregistrés avec succès.');
    }

    public function testMail(Request $request)
    {
        $settings = Setting::allKeyed();

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
            \Mail::raw('Test de configuration SMTP – AFG Bank Admin.', function ($msg) use ($settings) {
                $msg->to($settings['mail_to'])->subject('Test SMTP – AFG Bank');
            });
            return back()->with('success', 'Mail de test envoyé à ' . $settings['mail_to']);
        } catch (\Exception $e) {
            return back()->withErrors(['smtp' => 'Erreur : ' . $e->getMessage()]);
        }
    }
}
