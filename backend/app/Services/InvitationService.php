<?php

namespace App\Services;

use App\Modeles\company;
use App\Modeles\Invitation;
use App\Modeles\User_role;
use App\Modeles\users;
use App\Services\MailService;
use Bmvc\BAuth\Support\Password;
use Firebase\JWT\JWT;

class InvitationService
{

    public function createInvitation(array $state, company $company): array
    {
        try {

            // 🟢 1. VALIDATION
            if (empty($state['email']) || empty($state['role_id'])) {
                throw new \Exception("Email et rôle sont obligatoires");
            }

            $email = strtolower(trim($state['email']));

            // 🟢 2. CHECK ROLE
            $role = \App\Modeles\Role::ou('id', '=', $state['role_id'])
                ->et('company_id', '=', $company->id)
                ->premier();

            if (!$role) {

                return [
                    "success" => false,
                    'message' => "Rôle invalide",
                    'errors' => ['Role' => 'Rôle invalide']
                ];;
            }

            // 🟢 3. CHECK USER EXISTING
            $existingUser = users::ou('email', '=', $email)
                ->et('company_id', '=', $company->id)
                ->premier();

            if ($existingUser) {

                return [
                    "success" => false,
                    'message' => "Un utilisateur existe déjà avec cet email",
                    'errors' => ['email' => ['Un utilisateur existe déjà avec cet email']]
                ];
            }

            // 🟢 4. CHECK INVITATION EXISTANTE
            $existingInvitation = Invitation::ou('email', '=', $email)
                ->et('company_id', '=', $company->id)
                ->et('status', '=', 'pending')
                ->premier();

            if ($existingInvitation) {

                return [
                    "success" => false,
                    'message' => "Une invitation est déjà en attente pour cet email",
                    'errors' => [
                        'email' => ['Une invitation est déjà en attente pour cet email']
                    ]
                ];
            }

            // 🟢 5. GENERATE TOKEN SECURISÉ
            $jwt = auth()->getTokenProvider();
            $payload = [
                'name' => $state['name'],
                'warehouse' => $state['warehouse'],
                'role_id' => $role->id,
                'company_id' => $company->id,
            ];
            $token = $jwt->generate($payload,  60 * 60 * 24 * 7);

            // 🟢 6. CREATE INVITATION
            $invitation = \App\Modeles\Invitation::creer([
                'company_id' => $company->id,
                'role_id' => $role->id,
                'warehouse' => $state['warehouse'],
                'name' => $state['name'],
                'email' => $email,
                'token' => $token,
                'status' => 'pending',
                'expires_at' => date('Y-m-d H:i:s', strtotime('+7 days')),
                'invited_by' => auth()->userId() ?? null
            ]);

            if (!$invitation) {
                throw new \Exception("Erreur lors de la création de l'invitation");
            }

            // 🟢 7. BUILD LINK
            $link = env('URL_APPLICATION') . "/accept-invitation?token=" . $token;

            // 🟢 8. SEND EMAIL (simple version)
            $this->sendInvitationEmail($email, $state['name'], $company->name, $role->name, $link);

            // 🟢 9. RETURN RESPONSE CLEAN
            return [
                'success' => true,
                'message' => 'Invitation envoyée avec succès',
                'data' => [
                    'invitation_id' => $invitation->id,
                    'email' => $email,
                    'role' => $role->name,
                    'expires_at' => $invitation->expires_at
                ]
            ];
        } catch (\Exception $e) {

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
    private function sendInvitationEmail(string $email, string $name, string $companyName, string $roleName, string $link)
    {
        // version simple BMVC
        // version HTML professionnelle
        $m = new MailService();

        $subject = "Invitation à rejoindre $companyName";
        $currentYear = date('Y');
        $message = <<<HTML
                        <!DOCTYPE html>
                        <html lang="fr">
                        <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>Invitation Quantix</title>
                        </head>
                        <body style="margin:0;padding:0;background:#f8fafc;font-family:Arial,Helvetica,sans-serif;">

                        <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:40px 20px;">
                        <tr>
                        <td align="center">

                        <table width="600" cellpadding="0" cellspacing="0"
                            style="background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,.08);">

                            <!-- Header -->
                            <tr>
                                <td style="background:#2563eb;padding:30px;text-align:center;">
                                    <h1 style="margin:0;color:#ffffff;font-size:28px;">
                                        Quantix
                                    </h1>
                                    <p style="margin:8px 0 0;color:#dbeafe;">
                                        Gestion intelligente des stocks
                                    </p>
                                </td>
                            </tr>

                            <!-- Content -->
                            <tr>
                                <td style="padding:40px;">
                                    <h2 style="margin-top:0;color:#1e293b;">
                                        Bonjour {$name},
                                    </h2>

                                    <p style="color:#475569;font-size:16px;line-height:1.7;">
                                        Vous avez été invité à rejoindre l'entreprise
                                        <strong>{$companyName}</strong>
                                        sur Quantix.
                                    </p>

                                    <p style="color:#475569;font-size:16px;line-height:1.7;">
                                        Votre rôle sera :
                                    </p>

                                    <div style="
                                        background:#eff6ff;
                                        border:1px solid #bfdbfe;
                                        border-radius:10px;
                                        padding:16px;
                                        text-align:center;
                                        margin:24px 0;
                                    ">
                                        <strong style="color:#1d4ed8;font-size:18px;">
                                            {$roleName}
                                        </strong>
                                    </div>

                                    <p style="color:#475569;font-size:16px;line-height:1.7;">
                                        Cliquez sur le bouton ci-dessous pour accepter cette invitation :
                                    </p>

                                    <div style="text-align:center;margin:35px 0;">
                                        <a href="{$link}"
                                        style="
                                                background:#2563eb;
                                                color:#ffffff;
                                                text-decoration:none;
                                                padding:14px 30px;
                                                border-radius:10px;
                                                display:inline-block;
                                                font-weight:bold;
                                                font-size:16px;
                                        ">
                                            Accepter l'invitation
                                        </a>
                                    </div>

                                    <p style="color:#64748b;font-size:14px;">
                                        Cette invitation expirera dans <strong>7 jours</strong>.
                                    </p>

                                    <p style="color:#64748b;font-size:14px;">
                                        Si le bouton ne fonctionne pas, copiez ce lien dans votre navigateur :
                                    </p>

                                    <p style="word-break:break-all;font-size:13px;color:#2563eb;">
                                        {$link}
                                    </p>
                                </td>
                            </tr>

                            <!-- Footer -->
                            <tr>
                                <td style="
                                    background:#f8fafc;
                                    padding:24px;
                                    text-align:center;
                                    border-top:1px solid #e2e8f0;
                                ">
                                    <p style="margin:0;color:#64748b;font-size:13px;">
                                         © {$currentYear} {$companyName}
                                    </p>

                                    <p style="margin-top:8px;color:#94a3b8;font-size:12px;">
                                        Cet email a été envoyé automatiquement par Quantix.
                                    </p>
                                </td>
                            </tr>

                        </table>

                        </td>
                        </tr>
                        </table>

                        </body>
                        </html>
                        HTML;

        $m->send($email, $subject, $message, true);
    }
    public function acceptInvitation(string $token, array $data): array
    {
        try {

            // 🟢 1. GET INVITATION
            $invitation = \App\Modeles\Invitation::ou('token', '=', $token)
                ->premier();

            if (!$invitation) {

                return [
                    'success' => false,
                    'message' => "Invitation invalide"
                ];
            }

            if ($invitation->status !== 'pending') {

                return [
                    'success' => false,
                    'message' => "Invitation déjà utilisée"
                ];
            }

            if (strtotime($invitation->expires_at) < time()) {
                return [
                    'success' => false,
                    'message' => "Invitation expirée"
                ];
            }
            $exist = users::ou('email', '=', $invitation->email)->premier();
            if ($exist) {
                // $invitation->status = 'pending';
                // $invitation->expires_at = date('Y-m-d H:i:s');
                // $invitation->sauvegarder();
                return [
                    'success' => false,
                    'message' => " Utilisateur existe déjà avec cet email"
                ];
            }
            // 🟢 2. CHECK EMAIL MATCH
            // if (strtolower($invitation->email) !== strtolower($data['email'])) {
            //     throw new \Exception("Email incorrect");
            // }
            $name = explode(' ', $data['name']);
            $prenom = $name[0] ?? '';
            $nom = $name[1] ?? '';

            // 🟢 3. CREATE USER
            $user = users::creer([
                'company_id' => $invitation->company_id,
                'first_name' => $prenom,
                'last_name' => $nom,
                'email' => $invitation->email,
                'password' => Password::hash($data['password']),
                'activation_status' => 'activated',
                'is_activated' => 1,
                'activated_at' => now(),
                'status' => 1
            ]);

            // 🟢 4. ASSIGN ROLE
            User_role::creer([
                'user_id' => $user->id,
                'role_id' => $invitation->role_id
            ]);

            // 🟢 5. UPDATE INVITATION
            $invitation->status = 'accepted';
            $invitation->accepted_at = now();
            $invitation->sauvegarder();

            return [
                'success' => true,
                'message' => 'Compte créé avec succès',
                'user_id' => $user->id,
                'email' => $user->email
            ];
        } catch (\Exception $e) {

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
