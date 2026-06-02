<?php
// dd($items);
?>

<!DOCTYPE html>

<html class="dark" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link rel="stylesheet" href="/css/tailwind.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Inter', sans-serif;
            scroll-behavior: smooth;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .reveal {
            opacity: 0;
            transition: all 0.8s ease-out;
        }

        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-up {
            transform: translateY(40px);
        }

        .btn-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-hover:hover {
            transform: scale(1.03);
            box-shadow: 0 0 20px rgba(0, 81, 213, 0.3);
        }

        .btn-hover:active {
            transform: scale(0.97);
        }

        .pricing-card-hover {
            transition: transform 0.4s ease, border-color 0.4s ease, box-shadow 0.4s ease;
        }

        .pricing-card-hover:hover {
            transform: translateY(-8px);
            border-color: rgba(0, 81, 213, 0.4);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: theme('colors.background');
        }

        ::-webkit-scrollbar-thumb {
            background: theme('colors.surface-container-highest');
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: theme('colors.outline');
        }

        /* Theme Toggle Transitions */
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }
    </style>
    <!-- Light Mode Overrides -->
    <style>
        .light body {
            --background: #f8f9fb;
            --on-background: #191c1e;
            --surface: #ffffff;
            --on-surface: #191c1e;
            --surface-container-low: #f3f4f6;
            --surface-container-high: #e7e8ea;
            --on-surface-variant: #45464c;
            --outline-variant: #c6c6cd;
            --primary: #00174b;
        }

        .light .bg-background {
            background-color: #f8f9fb;
        }

        .light .text-on-background {
            color: #191c1e;
        }

        .light .text-primary {
            color: #00174b;
        }

        .light .text-white {
            color: #00174b;
        }

        .light .bg-surface-container-low {
            background-color: #f3f4f6;
        }

        .light .bg-surface-container-high {
            background-color: #e7e8ea;
        }

        .light .border-outline-variant\/20 {
            border-color: rgba(0, 0, 0, 0.1);
        }

        .light .bg-background\/80 {
            background-color: rgba(248, 249, 251, 0.8);
        }

        .light .text-on-surface-variant {
            color: #45464c;
        }

        .light .bg-surface-container-lowest\/50 {
            background-color: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>

<body class="bg-background text-on-background min-h-screen flex flex-col selection:bg-secondary/30 transition-colors duration-300">
    <!-- TopNavBar -->
    <header class="bg-background/80 backdrop-blur-md docked full-width top-0 sticky z-50 border-b border-outline-variant/30">
        <nav class="flex justify-between items-center w-full px-6 py-4 max-w-7xl mx-auto">
            <div class="flex items-center gap-10">
                <span class="text-headline-md font-headline-md font-bold text-primary">Quantix</span>
                <div class="hidden md:flex items-center gap-8">
                    <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md text-body-md" href="#">Product</a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md text-body-md" href="#">Solutions</a>
                    <a class="text-secondary font-bold border-b-2 border-secondary pb-1 font-body-md text-body-md" href="#">Pricing</a>
                    <a class="text-on-surface-variant hover:text-primary transition-colors font-body-md text-body-md" href="#">Resources</a>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <!-- Theme Toggle Button -->
                <button aria-label="Toggle Theme" class="p-2 rounded-full hover:bg-surface-container-high transition-colors text-on-surface-variant" id="theme-toggle">
                    <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                    <span class="material-symbols-outlined hidden dark:block">light_mode</span>
                </button>
                <button class="px-5 py-2 text-on-surface-variant hover:text-secondary transition-colors font-label-md text-label-md btn-hover">Log In</button>
                <button class="px-6 py-2 bg-secondary text-on-secondary rounded-lg font-label-md text-label-md hover:bg-secondary/90 transition-all btn-hover">Get Started</button>
            </div>
        </nav>
    </header>
    <main class="flex-grow">
        <!-- Hero Section -->
        <section class="relative overflow-hidden pt-24 pb-16 px-6 reveal reveal-up active">
            <div class="max-w-7xl mx-auto text-center relative z-10">
                <h1 class="font-display text-display mb-6 tracking-tight text-white">
                    Des plans adaptés à votre croissance.<br />
                    <span class="text-secondary">Gérez votre stock avec précision.</span>
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto mb-12">
                    Simplifiez vos opérations logistiques avec une plateforme conçue pour la fiabilité et la visibilité en temps réel.
                </p>
                <!-- Pricing Toggle -->
                <div class="flex items-center justify-center gap-4 mb-16">
                    <span class="font-label-md text-label-md text-on-surface-variant">Mensuel</span>
                    <button class="w-14 h-7 bg-surface-container-highest rounded-full p-1 relative transition-colors border border-outline-variant/30 hover:border-secondary/50">
                        <div class="w-5 h-5 bg-secondary rounded-full absolute right-1 top-1 shadow-[0_0_10px_rgba(0,81,213,0.5)]"></div>
                    </button>
                    <span class="font-label-md text-label-md text-primary">Annuel</span>
                    <span class="bg-on-tertiary-container/10 text-on-tertiary-container px-3 py-1 rounded-full font-label-sm text-label-sm border border-on-tertiary-container/20">-20% d'économie</span>
                </div>
            </div>
            <!-- Subtle background pattern -->
            <div class="absolute inset-0 -z-0 opacity-20 pointer-events-none" id="parallax-bg">
                <div class="absolute top-0 left-1/2 -translate-x-1/2 w-[1200px] h-[600px] bg-gradient-to-b from-secondary/30 to-transparent blur-[120px]"></div>
            </div>
        </section>
        <!-- Pricing Cards -->
        <section class="px-6 pb-24 reveal reveal-up">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 items-stretch">
                <?php if (!empty($items) && is_array($items)): ?>
                    <?php foreach ($items as $index => $plan): ?>
                        <?php
                        // Parse features JSON
                        $features = [];
                        if (isset($plan->features)) {
                            $features = is_string($plan->features) ? json_decode($plan->features, true) : $plan->features;
                            $features = is_array($features) ? $features : [];
                        }

                        // Format price
                        $price = floatval($plan->price ?? 0);
                        $priceDisplay = $price == 0 ? 'Gratuit' : number_format($price, 2, ',', ' ') . '€';

                        // Format billing cycle
                        $billingDisplay = '';
                        if ($plan->billing_cycle === 'monthly') {
                            $billingDisplay = '/mois';
                        } elseif ($plan->billing_cycle === 'yearly') {
                            $billingDisplay = '/an';
                        }
                        ?>
                        <div class="bg-surface-container-low p-8 rounded-[20px] border border-outline-variant/20 flex flex-col pricing-card-hover group relative <?php echo $index === 1 ? 'md:scale-105 md:z-20 md:shadow-[0_20px_50px_rgba(0,0,0,0.5)] border-2 border-secondary bg-gradient-to-b from-surface-container-high to-background' : ''; ?>">
                            <?php if ($index === 1): ?>
                                <div class="absolute -top-4 left-1/2 -translate-x-1/2 bg-secondary text-on-secondary px-4 py-1 rounded-full font-label-sm text-label-sm uppercase tracking-wider font-bold shadow-lg">Plus Populaire</div>
                            <?php endif; ?>
                            <h3 class="font-headline-md text-headline-md mb-2 text-white"><?php echo htmlspecialchars($plan->name ?? 'Plan'); ?></h3>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-6"><?php echo htmlspecialchars($plan->description  ?? ''); ?></p>
                            <div class="flex items-baseline gap-1 mb-8">
                                <span class="font-display text-display text-white"><?php echo $priceDisplay; ?></span>
                                <?php if ($billingDisplay): ?>
                                    <span class="font-body-md text-body-md text-on-surface-variant"><?php echo $billingDisplay; ?></span>
                                <?php endif; ?>
                            </div>
                            <ul class="space-y-4 mb-10 flex-grow">
                                <li class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-on-tertiary-container">check_circle</span>
                                    <span class="font-body-md text-body-md<?php echo $index === 1 ? ' text-white' : ''; ?>"><?php echo $features['users_limit'] ?? $plan->users_limit ?? 1; ?> utilisateur<?php echo ($features['users_limit'] ?? $plan->users_limit ?? 1) > 1 ? 's' : ''; ?></span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-on-tertiary-container">check_circle</span>
                                    <span class="font-body-md text-body-md<?php echo $index === 1 ? ' text-white' : ''; ?>"><?php echo $features['warehouses_limit'] ?? $plan->warehouses_limit ?? 1; ?> entrepôt<?php echo ($features['warehouses_limit'] ?? $plan->warehouses_limit ?? 1) > 1 ? 's' : ''; ?></span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-on-tertiary-container">check_circle</span>
                                    <span class="font-body-md text-body-md<?php echo $index === 1 ? ' text-white' : ''; ?>">Jusqu'à <?php echo number_format($features['products_limit'] ?? $plan->products_limit ?? 100, 0, ',', ' '); ?> produits</span>
                                </li>
                                <?php
                                // Définir toutes les features avec leurs traductions
                                $allFeatures = [
                                    'stock_alerts' => 'Alertes de stock',
                                    'inventory_history' => 'Historique d\'inventaire',
                                    'reports' => 'Rapports détaillés',
                                    'barcode' => 'Gestion codes-barres',
                                    'exports' => 'Exports (CSV, PDF, Excel)',
                                    'multi_warehouse' => 'Multi-entrepôts',
                                    'custom_roles' => 'Rôles personnalisés',
                                    'dashboard_analytics' => 'Tableau de bord analytique',
                                    'multi_currency' => 'Multi-devises',
                                    'api_access' => 'Accès API complet',
                                    'invoice_management' => 'Gestion des factures',
                                    'purchase_management' => 'Gestion des achats',
                                    'sales_management' => 'Gestion des ventes',
                                    'priority_support' => 'Support prioritaire 24/7'
                                ];

                                // Séparer les features en deux groupes: enabled et disabled
                                $enabledFeatures = [];
                                $disabledFeatures = [];

                                foreach ($allFeatures as $key => $label) {
                                    if ($features[$key] ?? false) {
                                        $enabledFeatures[$key] = $label;
                                    } else {
                                        $disabledFeatures[$key] = $label;
                                    }
                                }

                                // Afficher d'abord les features activées
                                foreach ($enabledFeatures as $key => $label):
                                    $textColor = 'text-on-tertiary-container';
                                    $textClass = 'text-body-md';
                                    $icon = 'check_circle';
                                ?>
                                    <li class=" flex items-center gap-3">
                                        <span class="material-symbols-outlined <?php echo $textColor; ?>"><?php echo $icon; ?></span>
                                        <span class="font-body-md <?php echo $textClass; ?><?php echo $index === 1 ? ' text-white' : ''; ?>"><?php echo $label; ?></span>
                                    </li>
                                <?php endforeach; ?>

                                <?php
                                // Afficher ensuite les features désactivées
                                foreach ($disabledFeatures as $key => $label):
                                    $textColor = 'text-outline';
                                    $textClass = 'text-on-surface-variant';
                                    $icon = 'block';
                                ?>
                                    <li class="flex items-center gap-3">
                                        <span class="material-symbols-outlined <?php echo $textColor; ?>"><?php echo $icon; ?></span>
                                        <span class="font-body-md <?php echo $textClass; ?><?php echo $index === 1 ? ' text-white' : ''; ?>"><?php echo $label; ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <button class=" w-full py-3 <?php echo $index === 1 ? 'bg-secondary text-on-secondary hover:bg-secondary/90 shadow-[0_5px_15px_rgba(0,81,213,0.4)]' : 'border border-outline-variant text-on-surface hover:border-secondary hover:bg-secondary/5'; ?> rounded-[12px] font-label-md text-label-md transition-colors btn-hover">
                                Choisir <?php echo htmlspecialchars($plan->name ?? 'Plan'); ?>
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-span-3 text-center py-12">
                        <p class="text-on-surface-variant font-body-md text-body-md">Aucun plan disponible pour le moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <!-- Comparison Table -->
        <section class="bg-surface-container-low/50 py-24 px-6 reveal reveal-up">
            <div class="max-w-5xl mx-auto">
                <h2 class="font-headline-lg text-headline-lg text-center mb-16 text-white">Tableau de comparaison détaillé</h2>
                <div class="overflow-hidden rounded-[20px] border border-outline-variant/30 bg-surface-container-lowest/50 backdrop-blur-sm shadow-xl">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-outline-variant/30 bg-surface-container-high/30">
                                    <th class="p-6 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Fonctionnalités</th>
                                    <th class="p-6 font-label-md text-label-md text-white">Gratuit</th>
                                    <th class="p-6 font-label-md text-label-md text-secondary">Standard</th>
                                    <th class="p-6 font-label-md text-label-md text-white">Business</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-outline-variant/10">
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="p-6 font-body-md text-body-md text-on-surface">Accès API</td>
                                    <td class="p-6"><span class="material-symbols-outlined text-error/60">close</span></td>
                                    <td class="p-6 text-on-surface-variant font-body-md text-body-md">Lecture seule</td>
                                    <td class="p-6 text-secondary font-label-md text-label-md">Full Access</td>
                                </tr>
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="p-6 font-body-md text-body-md text-on-surface">Rapports personnalisés</td>
                                    <td class="p-6"><span class="material-symbols-outlined text-error/60">close</span></td>
                                    <td class="p-6 text-on-surface font-body-md text-body-md">Basique</td>
                                    <td class="p-6 text-on-surface font-body-md text-body-md">Avancé</td>
                                </tr>
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="p-6 font-body-md text-body-md text-on-surface">Permissions utilisateurs</td>
                                    <td class="p-6 text-on-surface-variant font-body-md text-body-md">Propriétaire</td>
                                    <td class="p-6 text-on-surface font-body-md text-body-md">Rôles prédéfinis</td>
                                    <td class="p-6 text-on-surface font-body-md text-body-md">SSO &amp; Granulaire</td>
                                </tr>
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="p-6 font-body-md text-body-md text-on-surface">Historique des données</td>
                                    <td class="p-6 text-on-surface-variant font-body-md text-body-md">7 jours</td>
                                    <td class="p-6 text-on-surface font-body-md text-body-md">90 jours</td>
                                    <td class="p-6 text-on-surface font-body-md text-body-md">Illimité</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- FAQ Section -->
        <section class="py-24 px-6 reveal reveal-up">
            <div class="max-w-3xl mx-auto">
                <h2 class="font-headline-lg text-headline-lg text-center mb-12 text-white">Questions Fréquentes</h2>
                <div class="space-y-4">
                    <div class="p-6 bg-surface-container-low rounded-[16px] border border-outline-variant/20 hover:border-secondary/40 transition-all cursor-pointer group">
                        <h4 class="font-label-md text-label-md mb-2 flex justify-between items-center text-white">
                            Puis-je changer de plan à tout moment ?
                            <span class="material-symbols-outlined group-hover:text-secondary transition-colors">expand_more</span>
                        </h4>
                        <p class="font-body-md text-body-md text-on-surface-variant">Absolument. Vous pouvez augmenter ou réduire votre abonnement directement depuis votre tableau de bord. Les ajustements de facturation sont calculés au prorata.</p>
                    </div>
                    <div class="p-6 bg-surface-container-low rounded-[16px] border border-outline-variant/20 hover:border-secondary/40 transition-all cursor-pointer group">
                        <h4 class="font-label-md text-label-md mb-2 flex justify-between items-center text-white">
                            Y a-t-il une période d'essai pour le plan Standard ?
                            <span class="material-symbols-outlined group-hover:text-secondary transition-colors">expand_more</span>
                        </h4>
                        <p class="font-body-md text-body-md text-on-surface-variant">Oui, nous proposons une période d'essai gratuite de 14 jours sur le plan Standard, sans carte bancaire requise pour commencer.</p>
                    </div>
                    <div class="p-6 bg-surface-container-low rounded-[16px] border border-outline-variant/20 hover:border-secondary/40 transition-all cursor-pointer group">
                        <h4 class="font-label-md text-label-md mb-2 flex justify-between items-center text-white">
                            Comment fonctionne le support Business ?
                            <span class="material-symbols-outlined group-hover:text-secondary transition-colors">expand_more</span>
                        </h4>
                        <p class="font-body-md text-body-md text-on-surface-variant">Les clients Business bénéficient d'une ligne prioritaire, d'un temps de réponse garanti en moins de 2h et d'un gestionnaire de compte dédié.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Final CTA -->
        <section class="py-24 px-6 reveal reveal-up">
            <div class="max-w-7xl mx-auto bg-gradient-to-br from-surface-container-high to-background rounded-[32px] p-12 md:p-24 text-center relative overflow-hidden border border-outline-variant/30">
                <div class="relative z-10">
                    <h2 class="font-display text-display text-white mb-6">Prêt à optimiser votre stock ?</h2>
                    <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 max-w-xl mx-auto">Rejoignez plus de 2 500 entreprises qui font confiance à Quantix pour leur logistique quotidienne.</p>
                    <div class="flex flex-col md:flex-row gap-6 justify-center">
                        <button class="px-10 py-4 bg-secondary text-on-secondary rounded-[14px] font-label-md text-label-md hover:shadow-[0_0_30px_rgba(0,81,213,0.5)] transition-all btn-hover">Essai gratuit de 14 jours</button>
                        <button class="px-10 py-4 border border-outline-variant text-white rounded-[14px] font-label-md text-label-md hover:bg-white/10 transition-all btn-hover">Parler à un expert</button>
                    </div>
                </div>
                <!-- Abstract background visual -->
                <div class="absolute inset-0 opacity-10 pointer-events-none mix-blend-overlay">
                    <img alt="Warehouse logistics visualization" class="w-full h-full object-cover scale-110" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDWpgUR8ivfdKYtpitU7XonIbRJtdqSCuXx1DAQ3K9cVqZswCucz4RdxXLF85CQQrq6IVDo-MXnVHL6DX7ta02K_Mbe4qhIXq4wdqW0UWMGqg5wdsDbbMiCNPd_2WFbAM1Zpa68l_W02_o3j9ts8iRJbt-rJsK8CUsCkdBEefJtp-uDTR8D7rIPMMpTFYI9MATnaMGsAZvsZlYigqhyAi7jjB3C0cBwtrwXuZXp9m6pAUYJzxDkX6N7mit4zuK0fcK_4fot77yAPD_m" />
                </div>
            </div>
        </section>
    </main>
    <!-- Footer -->
    <footer class="bg-background border-t border-outline-variant/30 mt-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full px-6 py-16 max-w-7xl mx-auto items-start">
            <div class="flex flex-col gap-6">
                <span class="text-headline-md font-headline-md font-bold text-white">Quantix</span>
                <p class="text-on-surface-variant font-body-md text-body-md max-w-sm">La plateforme d'inventaire nouvelle génération pour les entreprises qui exigent la précision.</p>
                <span class="text-on-surface-variant/60 font-label-sm text-label-sm mt-4">© 2024 Quantix Inventory Systems. All rights reserved.</span>
            </div>
            <div class="grid grid-cols-2 gap-8 md:justify-items-end">
                <div class="flex flex-col gap-4">
                    <span class="font-label-md text-label-md text-white mb-2 uppercase tracking-widest text-[11px] opacity-50">Legal</span>
                    <a class="text-on-surface-variant hover:text-secondary transition-colors font-body-md text-body-md" href="#">Privacy Policy</a>
                    <a class="text-on-surface-variant hover:text-secondary transition-colors font-body-md text-body-md" href="#">Terms of Service</a>
                </div>
                <div class="flex flex-col gap-4">
                    <span class="font-label-md text-label-md text-white mb-2 uppercase tracking-widest text-[11px] opacity-50">Connect</span>
                    <a class="text-on-surface-variant hover:text-secondary transition-colors font-body-md text-body-md" href="#">Security</a>
                    <a class="text-on-surface-variant hover:text-secondary transition-colors font-body-md text-body-md" href="#">Contact Sales</a>
                </div>
            </div>
        </div>
    </footer>
    <script>
        // Theme Toggling Logic
        const themeToggle = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;

        themeToggle.addEventListener('click', () => {
            htmlElement.classList.toggle('dark');
            htmlElement.classList.toggle('light');

            // Persist theme choice (optional but good practice)
            const isDark = htmlElement.classList.contains('dark');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });

        // Intersection Observer for Reveal animations
        const revealCallback = (entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        };

        const revealObserver = new IntersectionObserver(revealCallback, {
            threshold: 0.15
        });

        document.querySelectorAll('.reveal').forEach(el => {
            revealObserver.observe(el);
        });

        // Simple Parallax Effect on background
        window.addEventListener('scroll', () => {
            const scroll = window.pageYOffset;
            const parallaxBg = document.getElementById('parallax-bg');
            if (parallaxBg) {
                parallaxBg.style.transform = `translateY(${scroll * 0.2}px)`;
            }
        });

        // Check for saved theme preference
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'light') {
            htmlElement.classList.remove('dark');
            htmlElement.classList.add('light');
        }
    </script>
</body>

</html>
