<?php
// dd('Welcome view loaded', $user, $company['name']);

/**
 * TEMPLATE: Welcome Page
 * Path: app/Vues/company/welcome.php
 * 
 * Shown after account activation
 * Displays congratulations message with CTA to start wizard
 */
?>

<!DOCTYPE html>
<html class="dark" lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
    <title>Bienvenue - Quantix</title>
    <link rel="stylesheet" href="/css/tailwind.css">
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Hanken Grotesk', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .glass-effect {
            background: rgba(13, 28, 45, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(173, 199, 255, 0.1);
        }

        .bg-gradient-mesh {
            background: linear-gradient(135deg, #051424 0%, #0d1c2d 50%, #051424 100%);
            position: relative;
        }

        .bg-gradient-mesh::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(74, 142, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(173, 199, 255, 0.08) 0%, transparent 50%);
            pointer-events: none;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>

<body class="bg-gradient-mesh text-on-surface antialiased min-h-screen flex items-center justify-center overflow-x-hidden">

    <div class="min-h-screen flex items-center justify-center px-4 py-12 w-full relative z-10">
        <div class="w-full max-w-4xl">

            <!-- Logo & Header -->
            <div class="text-center mb-16 animate-fade-in-up">
                <div class="inline-block bg-primary/10 border border-primary/30 rounded-2xl p-4 mb-6 shadow-lg shadow-primary/10">
                    <span class="material-symbols-outlined text-4xl text-primary">deployed_code</span>
                </div>
                <h1 class="text-5xl md:text-6xl font-bold text-white tracking-tight mb-2">Quantix</h1>
                <p class="text-on-surface-variant text-lg">Gestion Globale des Stocks</p>
            </div>

            <!-- Main Content Grid -->
            <div class="grid md:grid-cols-2 gap-8 lg:gap-12">

                <!-- Left: Welcome Message -->
                <div class="space-y-8 animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div>
                        <p class="text-primary font-semibold text-sm uppercase tracking-[0.15em] mb-2">Bienvenue à bord!</p>
                        <h2 class="text-4xl md:text-5xl font-bold text-white">
                            Prêt à commencer?
                        </h2>
                    </div>

                    <p class="text-on-surface-variant text-lg leading-relaxed max-w-md">
                        Votre compte a été créé et activé avec succès. Configurons maintenant votre workspace Quantix en quelques étapes simples.
                    </p>

                    <!-- Checklist -->
                    <div class="space-y-4 pt-4">
                        <div class="flex items-start gap-4 group">
                            <div class="flex-shrink-0 w-8 h-8 bg-primary/20 border border-primary/40 rounded-full flex items-center justify-center mt-0.5 group-hover:bg-primary/30 transition-colors">
                                <span class="material-symbols-outlined text-base text-primary">check_circle</span>
                            </div>
                            <div>
                                <p class="text-white font-semibold text-base">Configuration du workspace</p>
                                <p class="text-on-surface-variant text-sm mt-1">Nom, devise, fuseau horaire</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 group">
                            <div class="flex-shrink-0 w-8 h-8 bg-primary/20 border border-primary/40 rounded-full flex items-center justify-center mt-0.5 group-hover:bg-primary/30 transition-colors">
                                <span class="material-symbols-outlined text-base text-primary">check_circle</span>
                            </div>
                            <div>
                                <p class="text-white font-semibold text-base">Création du site</p>
                                <p class="text-on-surface-variant text-sm mt-1">Point de vente ou entrepôt</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 group">
                            <div class="flex-shrink-0 w-8 h-8 bg-primary/20 border border-primary/40 rounded-full flex items-center justify-center mt-0.5 group-hover:bg-primary/30 transition-colors">
                                <span class="material-symbols-outlined text-base text-primary">check_circle</span>
                            </div>
                            <div>
                                <p class="text-white font-semibold text-base">Invitation d'équipe</p>
                                <p class="text-on-surface-variant text-sm mt-1">Ajouter des collaborateurs</p>
                            </div>
                        </div>
                    </div>

                    <!-- Time Estimate -->
                    <div class="glass-effect p-4 rounded-xl border border-primary/20">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-2xl text-primary">schedule</span>
                            <div>
                                <p class="text-primary text-sm font-semibold">Durée estimée</p>
                                <p class="text-on-surface-variant text-xs">5 à 10 minutes</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: User Info & CTA -->
                <div class="space-y-8 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <!-- User Card -->
                    <div class="glass-effect rounded-2xl border border-primary/10 p-8 space-y-6">
                        <div>
                            <p class="text-on-surface-variant text-xs uppercase tracking-[0.15em] font-semibold mb-2">Vos informations</p>
                            <div class="w-12 h-12 rounded-full bg-primary/20 border border-primary/40 flex items-center justify-center">
                                <span class="material-symbols-outlined text-2xl text-primary">account_circle</span>
                            </div>
                        </div>

                        <div class="space-y-4 border-t border-primary/10 pt-4">
                            <div>
                                <p class="text-on-surface-variant text-xs uppercase tracking-wider mb-1 font-semibold">Nom complet</p>
                                <p class="text-white font-semibold text-lg">
                                    <?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>
                                </p>
                            </div>

                            <div>
                                <p class="text-on-surface-variant text-xs uppercase tracking-wider mb-1 font-semibold">Email</p>
                                <p class="text-white font-semibold text-lg break-all">
                                    <?php echo htmlspecialchars($user['email']); ?>
                                </p>
                            </div>

                            <div>
                                <p class="text-on-surface-variant text-xs uppercase tracking-wider mb-1 font-semibold">Entreprise</p>
                                <p class="text-white font-semibold text-lg">
                                    <?php echo htmlspecialchars($company['name']); ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Button -->
                    <button
                        id="startWizardBtn"
                        class="w-full bg-primary hover:bg-primary-dark text-on-surface font-bold py-4 px-6 rounded-xl transition-all duration-300 flex items-center justify-center gap-3 group shadow-lg shadow-primary/30 hover:shadow-xl hover:shadow-primary/40 active:scale-95">
                        <span class="text-lg">Commencer la configuration</span>
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </button>

                    <!-- Loading State (hidden by default) -->
                    <div id="loadingState" class="hidden">
                        <div class="glass-effect rounded-xl border border-primary/10 p-8 text-center space-y-4">
                            <div class="flex justify-center">
                                <span class="material-symbols-outlined text-5xl text-primary animate-spin">autorenew</span>
                            </div>
                            <p class="text-on-surface-variant">Initialisation du wizard...</p>
                        </div>
                    </div>

                    <!-- Error State (hidden by default) -->
                    <div id="errorState" class="hidden">
                        <div class="bg-red-900/20 border border-red-700/40 rounded-xl p-6 space-y-3">
                            <div class="flex items-start gap-3">
                                <span class="material-symbols-outlined text-2xl text-red-400 flex-shrink-0">error</span>
                                <p class="text-red-300 text-sm" id="errorMessage"></p>
                            </div>
                            <button
                                onclick="resetWizardButton()"
                                class="text-red-400 hover:text-red-300 text-sm font-semibold flex items-center gap-1 group">
                                <span class="material-symbols-outlined text-base group-hover:-translate-x-1 transition-transform">arrow_back</span>
                                Réessayer
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

        document.getElementById('startWizardBtn').addEventListener('click', initializeWizard);

        async function initializeWizard() {
            try {
                // Show loading state
                document.getElementById('startWizardBtn').classList.add('hidden');
                document.getElementById('loadingState').classList.remove('hidden');
                document.getElementById('errorState').classList.add('hidden');

                // Call wizard init endpoint
                const response = await fetch('/api/wizard/init', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': csrfToken
                    }
                });

                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }

                const result = await response.json();

                if (!result.success || !result.data?.sessionId) {
                    throw new Error(result.message || 'Failed to initialize wizard');
                }

                // Redirect to wizard with session ID
                const sessionId = result.data.sessionId;
                window.location.href = `/workspace/setup?session=${encodeURIComponent(sessionId)}`;

            } catch (error) {
                console.error('[WIZARD INIT ERROR]', error);

                // Show error state
                document.getElementById('startWizardBtn').classList.remove('hidden');
                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('errorState').classList.remove('hidden');
                document.getElementById('errorMessage').textContent = error.message || 'Erreur lors de l\'initialisation du wizard';
            }
        }

        function resetWizardButton() {
            document.getElementById('startWizardBtn').classList.remove('hidden');
            document.getElementById('errorState').classList.add('hidden');
        }
    </script>

</body>

</html>