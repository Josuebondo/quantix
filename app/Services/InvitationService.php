<?php

namespace App\Services;

use App\Modeles\company;
use App\Modeles\Invitation;
use App\Modeles\User_role;
use App\Modeles\users;
use App\Services\MailService;
use Bmvc\BAuth\Support\Password;

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
            $token = bin2hex(random_bytes(32));

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
            $link = "https://app.quantix.com/accept-invitation?token=" . $token;

            // 🟢 8. SEND EMAIL (simple version)
            // $this->sendInvitationEmail($email, $state['name'], $company->name, $role->name, $link);

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
        $m = new MailService();
        $m->send(
            $email,
            "Invitation à rejoindre $companyName",
            "
        Bonjour $name,

        Vous avez été invité à rejoindre $companyName en tant que $roleName.

        Cliquez ici pour accepter l'invitation :
        $link

        Ce lien expire dans 7 jours.

        Cordialement,
        L'équipe $companyName
        "
        );
    }
    public function acceptInvitation(string $token, array $data): array
    {
        try {

            // 🟢 1. GET INVITATION
            $invitation = \App\Modeles\Invitation::ou('token', '=', $token)
                ->premier();

            if (!$invitation) {
                throw new \Exception("Invitation invalide");
            }

            if ($invitation->status !== 'pending') {
                throw new \Exception("Invitation déjà utilisée");
            }

            if (strtotime($invitation->expires_at) < time()) {
                throw new \Exception("Invitation expirée");
            }

            // 🟢 2. CHECK EMAIL MATCH
            if (strtolower($invitation->email) !== strtolower($data['email'])) {
                throw new \Exception("Email incorrect");
            }

            // 🟢 3. CREATE USER
            $user = users::creer([
                'company_id' => $invitation->company_id,
                'email' => $invitation->email,
                'password' => Password::hash($data['password']),
                'status' => 1
            ]);

            // 🟢 4. ASSIGN ROLE
            User_role::creer([
                'user_id' => $user->id,
                'role_id' => $invitation->role_id
            ]);

            // 🟢 5. UPDATE INVITATION
            \App\Modeles\Invitation::modifier($invitation->id, [
                'status' => 'accepted',
                'accepted_at' => date('Y-m-d H:i:s')
            ]);

            return [
                'success' => true,
                'message' => 'Compte créé avec succès',
                'user_id' => $user->id
            ];
        } catch (\Exception $e) {

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
