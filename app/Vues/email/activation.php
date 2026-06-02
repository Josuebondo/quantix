<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bienvenue sur Quantix</title>
</head>

<body style="margin:0;padding:0;background:#f3f6fb;font-family:Arial,sans-serif;">

    <div style="max-width:640px;margin:0 auto;background:#ffffff;border-radius:12px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,0.05);">

        <!-- HEADER -->
        <div style="padding:26px 30px;text-align:center;background:#0a0f1c;">

            <!-- LOGO -->
            <div style="margin-bottom:10px;">
                <img src="<?= htmlspecialchars($logo_url) ?>"
                    alt="Quantix"
                    style="width:42px;height:42px;border-radius:10px;">
            </div>

            <h1 style="margin:0;font-size:20px;color:#ffffff;letter-spacing:1px;">
                Quantix
            </h1>

            <p style="margin:6px 0 0;font-size:13px;color:#9aa4b2;">
                Inventory & Business Management
            </p>
        </div>

        <!-- HERO -->
        <div style="padding:30px;text-align:center;">

            <h2 style="margin:0;font-size:22px;color:#111827;">
                Bienvenue <?= htmlspecialchars($admin_name ?? 'à bord') ?>
            </h2>

            <p style="margin-top:10px;font-size:14px;color:#6b7280;line-height:1.6;">
                Votre espace Quantix est prêt. Complétez les étapes ci-dessous pour commencer.
            </p>

        </div>

        <!-- PROGRESS -->
        <div style="padding:0 30px 20px;">

            <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:14px;margin-bottom:10px;">
                <span style="color:#22c55e;font-weight:bold;">✓</span> Compte créé
            </div>

            <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:14px;margin-bottom:10px;">
                <span style="color:#f59e0b;font-weight:bold;">2</span> Configuration entreprise
            </div>

            <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:14px;margin-bottom:10px;">
                <span style="color:#3b82f6;font-weight:bold;">3</span> Choix abonnement
            </div>

            <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:14px;margin-bottom:10px;">
                <span style="color:#6b7280;font-weight:bold;">4</span> Entrepôts
            </div>

            <div style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;padding:14px;">
                <span style="color:#6b7280;font-weight:bold;">5</span> Produits
            </div>

        </div>

        <!-- INFO BOX -->
        <div style="margin:25px 30px;padding:16px;background:#0b1220;color:#ffffff;border-radius:10px;">
            <strong>Important :</strong>
            Le choix de votre abonnement débloque toutes les fonctionnalités (entrepôts, produits, utilisateurs).
        </div>

        <!-- CTA -->
        <div style="text-align:center;padding:10px 30px 30px;">

            <a href="<?= htmlspecialchars($activationLink ?? '') ?>"
                style="display:block;background:#2563eb;color:#ffffff;
                  text-decoration:none;padding:14px;border-radius:10px;
                  font-weight:bold;margin-bottom:10px;">
                Activer mon compte
            </a>

            <?php if (isset($pricingLink)): ?>
                <a href="<?= htmlspecialchars($pricingLink) ?>"
                    style="display:block;background:#111827;color:#ffffff;
                  text-decoration:none;padding:14px;border-radius:10px;
                  font-weight:bold;">
                    Voir les abonnements
                </a>
            <?php endif; ?>

        </div>


        <!-- FOOTER -->
        <div style="background:#f9fafb;padding:25px;text-align:center;border-top:1px solid #e5e7eb;">

            <p style="margin:0 0 15px;font-size:13px;color:#6b7280;">
                ⏳ Ce lien d'activation expirera dans <strong>24 heures</strong>.
            </p>

            <p style="margin:0 0 10px;font-size:13px;color:#6b7280;">
                Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet email en toute sécurité.
            </p>

            <p style="margin:0 0 15px;font-size:13px;color:#6b7280;">
                © <?= date('Y') ?> Quantix — Tous droits réservés
            </p>

            <div style="font-size:12px;">
                <a href="#" style="color:#2563eb;text-decoration:none;margin:0 8px;">
                    Politique de confidentialité
                </a>

                <a href="#" style="color:#2563eb;text-decoration:none;margin:0 8px;">
                    Conditions d'utilisation
                </a>

                <a href="mailto:support@quantix.com" style="color:#2563eb;text-decoration:none;margin:0 8px;">
                    Support
                </a>
            </div>

        </div>

    </div>

</body>

</html>