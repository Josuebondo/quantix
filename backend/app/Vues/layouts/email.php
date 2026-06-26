<!DOCTYPE html>

<html class="light" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Bienvenue chez Quantix</title>
    <link rel="stylesheet" href="/css/tailwind.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
    </head>

<body class="bg-background font-body-md text-on-surface">
    <div class="w-full max-w-[600px] mx-auto bg-surface-container-lowest min-h-screen">
        <!-- Header Section -->
        <header class="flex flex-col items-center justify-center py-8 px-inset-padding w-full max-w-[600px] mx-auto bg-surface-container-lowest">
            <h1 class="text-headline-md font-headline-md font-bold tracking-tight text-primary">Quantix</h1>
            <p class="text-label-sm font-label-sm text-on-surface-variant mt-1">Gestion intelligente de stock et d'entreprise</p>
        </header>
        <!-- Main Content -->
        <main class="px-inset-padding pb-section-gap">
            <!-- Welcome Section -->
            <section class="mb-section-gap text-center">
                <div class="mb-6 rounded-xl overflow-hidden shadow-sm border border-primary/10">
                    <img class="w-full h-48 object-cover" data-alt="A clean and professional digital dashboard representing business intelligence, featuring sleek line charts and inventory metrics." src="https://lh3.googleusercontent.com/aida-public/AB6AXuC37GEEMqU2wNQ6Wae0Kv1Oa8JuArgdx191ve64JAF-60cHS3aeBGh13vLM5YAij-UXoR1P_vU-vCl1Z6Px1e0Lh95Zx5pXNoZEquyM-vbKH_0iGqqrCIuHPjH6_kDf9eRfJx-UXKNac-2TFc7_yYX42ksDzL2OFeHaKERGKizN5QTcHJUcMxclDk-bL6sg2LXc2F0Ya45eXvjnfMG2WlNBGUhLITE4knoG475w3on2j4XEXsuzOLNIfRHRJlxMDxW7JkPqQsZ-dvQ0" />
                </div>
                <h2 class="text-headline-lg font-headline-lg text-primary mb-stack-gap">Bonjour {{admin_name}}, Bienvenue sur Quantix</h2>
                <p class="text-body-lg font-body-lg text-on-surface-variant">
                    Votre environnement de gestion est prêt. Suivez ce parcours guidé pour configurer votre espace de travail de manière optimale.
                </p>
            </section>
            <!-- Steps Section -->
            <section class="mb-section-gap">
                <h3 class="text-label-md font-bold text-primary mb-4 px-1 uppercase tracking-wider">Votre parcours de configuration</h3>
                <div class="grid grid-cols-1 gap-inline-gap">
                    <!-- Step 1 -->
                    <div class="flex items-start gap-stack-gap p-inset-padding bg-surface-container-low rounded-xl border border-outline/10 hover:border-secondary/20 transition-colors">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-secondary/10 text-secondary flex items-center justify-center">
                            <span class="material-symbols-outlined">person_check</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-label-md text-primary mb-1">Activation du compte</h4>
                            <p class="text-body-md font-body-md text-on-surface-variant">Confirmez votre identité pour sécuriser l'accès à vos données.</p>
                        </div>
                    </div>
                    <!-- Step 2 -->
                    <div class="flex items-start gap-stack-gap p-inset-padding bg-surface-container-low rounded-xl border border-outline/10 hover:border-secondary/20 transition-colors">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-secondary/10 text-secondary flex items-center justify-center">
                            <span class="material-symbols-outlined">business</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-label-md text-primary mb-1">Configuration de l'entreprise</h4>
                            <p class="text-body-md font-body-md text-on-surface-variant">Renseignez vos informations légales et paramètres opérationnels.</p>
                        </div>
                    </div>
                    <!-- Step 3 -->
                    <div class="flex items-start gap-stack-gap p-inset-padding bg-surface-container-low rounded-xl border border-outline/10 hover:border-secondary/20 transition-colors">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-secondary/10 text-secondary flex items-center justify-center">
                            <span class="material-symbols-outlined">subscriptions</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-label-md text-primary mb-1">Choix de l'abonnement</h4>
                            <p class="text-body-md font-body-md text-on-surface-variant mb-2">Déterminez votre capacité :</p>
                            <ul class="text-label-sm text-on-surface-variant space-y-1 ml-4 list-disc">
                                <li>Nombre d'utilisateurs</li>
                                <li>Entrepôts</li>
                                <li>Accès aux fonctionnalités avancées</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Step 4 -->
                    <div class="flex items-start gap-stack-gap p-inset-padding bg-surface-container-low rounded-xl border border-outline/10 hover:border-secondary/20 transition-colors">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-secondary/10 text-secondary flex items-center justify-center">
                            <span class="material-symbols-outlined">warehouse</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-label-md text-primary mb-1">Gestion des entrepôts</h4>
                            <p class="text-body-md font-body-md text-on-surface-variant">Structurez vos zones de stockage selon vos flux logistiques.</p>
                        </div>
                    </div>
                    <!-- Step 5 -->
                    <div class="flex items-start gap-stack-gap p-inset-padding bg-surface-container-low rounded-xl border border-outline/10 hover:border-secondary/20 transition-colors">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-secondary/10 text-secondary flex items-center justify-center">
                            <span class="material-symbols-outlined">inventory_2</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-label-md text-primary mb-1">Catalogue produits</h4>
                            <p class="text-body-md font-body-md text-on-surface-variant">Importez vos articles pour initier le suivi des stocks en temps réel.</p>
                        </div>
                    </div>
                    <!-- Step 6 -->
                    <div class="flex items-start gap-stack-gap p-inset-padding bg-surface-container-low rounded-xl border border-outline/10 hover:border-secondary/20 transition-colors">
                        <div class="flex-shrink-0 w-10 h-10 rounded-full bg-secondary/10 text-secondary flex items-center justify-center">
                            <span class="material-symbols-outlined">group_add</span>
                        </div>
                        <div>
                            <h4 class="font-bold text-label-md text-primary mb-1">Collaboration</h4>
                            <p class="text-body-md font-body-md text-on-surface-variant">Invitez vos collaborateurs et définissez leurs rôles d'accès.</p>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Tip Box -->
            <section class="mb-section-gap p-6 bg-tertiary-container text-tertiary-fixed rounded-xl flex items-start gap-3 border border-tertiary-fixed/20 shadow-inner">
                <span class="material-symbols-outlined mt-0.5">lightbulb</span>
                <p class="text-label-md leading-relaxed">
                    <span class="font-bold">Conseil :</span> La sélection de votre abonnement est l'étape clé pour débloquer l'intégralité des fonctionnalités de configuration.
                </p>
            </section>
            <!-- Actions Section -->
            <section class="flex flex-col gap-inline-gap items-center mb-section-gap">
                <button class="w-full py-4 bg-secondary text-on-secondary rounded-lg font-bold text-label-md shadow-sm hover:opacity-90 transition-all active:scale-[0.98]">
                    Configurer mon entreprise
                </button>
                <button class="w-full py-4 border border-secondary text-secondary rounded-lg font-bold text-label-md hover:bg-secondary/5 transition-all active:scale-[0.98]">
                    Voir les abonnements
                </button>
            </section>
            <!-- Sign-off & Security -->
            <section class="text-center">
                <p class="text-body-md text-on-surface-variant mb-6 italic">Merci de votre confiance. L'équipe Quantix.</p>
                <div class="p-6 bg-surface-container-high rounded-lg">
                    <div class="flex justify-center mb-2">
                        <span class="material-symbols-outlined text-outline">shield</span>
                    </div>
                    <p class="text-label-sm font-label-sm text-outline">
                        Si vous n'êtes pas à l'origine de cette inscription, veuillez ignorer cet email ou contacter notre support si vous pensez qu'il s'agit d'une erreur.
                    </p>
                </div>
            </section>
        </main>
        <!-- Footer Section -->
        <footer class="flex flex-col items-center justify-center p-8 w-full max-w-[600px] mx-auto text-center gap-stack-gap bg-surface-container-low border-t border-outline/10 rounded-b-xl">
            <div class="text-label-md font-label-md font-bold text-outline">Quantix</div>
            <p class="text-label-sm font-label-sm text-outline px-4">
                © 2024 Quantix Inventory Systems. All rights reserved. This email was sent to you as part of your onboarding process.
            </p>
            <div class="flex gap-4">
                <a class="text-outline text-label-sm font-label-sm hover:text-secondary underline transition-colors" href="#">Privacy Policy</a>
                <a class="text-outline text-label-sm font-label-sm hover:text-secondary underline transition-colors" href="#">Terms of Service</a>
                <a class="text-outline text-label-sm font-label-sm hover:text-secondary underline transition-colors" href="#">Unsubscribe</a>
            </div>
        </footer>
    </div>
</body>

</html>
