<!DOCTYPE html>

<html class="dark" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Quatinx | Tableau de bord de supervision</title>
    <link rel="stylesheet" href="/css/tailwind.css">
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    "text-light": "#f6f6f8",
    "text-dark": "#e0e0e0",


    },
    fontFamily: {
    "display": ["Manrope"]
    },
    borderRadius: {
    "DEFAULT": "0.25rem",
    "lg": "0.5rem",
    "xl": "0.75rem",
    "full": "9999px"
    },
    },
    },
    }
    </script>
    <style>
        body {
            font-family: 'Hanken Grotesk', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .fill-icon {
            font-variation-settings: 'FILL' 1;
        }

        .glass-effect {
            background: rgba(5, 20, 36, 0.7);
            backdrop-filter: blur(12px);
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-background text-on-surface min-h-screen">
    <!-- TopAppBar (Mobile) -->
    <header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-margin-mobile md:px-margin-desktop h-16 bg-surface border-b border-outline-variant/10 md:hidden">
        <div class="flex items-center gap-sm">
            <img alt="Quatinx Logo" class="h-8 w-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuATUcku_1M5WA7ShpAB1ocpicZ1t6Tx5fxQUGW1XNXkxJRgn24xFPUEhLcSsnWCTXUDmoegPAwnQP9cleMl9zpVHuMbj-jo2TCN2KUMuo2gvQxwMaAZ3pLtuqKsCJdjgnMAFjr0uV_0RECLFIate4gszLOdAjXrT7o5ofwiKm4dbrnfBGovmrv974lKrbLnQiQ7uTPIsSb5Scpeus8lDZMF1eIncxB_rlyXh7nlsNos_PGTgfepsRtlIeDS1dmAoFie1g2d7gA8H3Q" />
        </div>
        <div class="flex items-center gap-md">
            <button class="text-on-surface-variant hover:bg-surface-container-high transition-colors p-sm rounded-full">
                <span class="material-symbols-outlined" data-icon="help">help</span>
            </button>
            <div class="w-8 h-8 rounded-full bg-secondary-container flex items-center justify-center overflow-hidden">
                <img alt="User profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCbiN31cIJIwFi0HG2BCYAa5ESBvlOEVmv8zthlEaeENRSGgsbpWrHH7ZStzK5hQdD_PKZ8zir90RW9a-HsXNkI3ye928i9CS9PaBoHYgdjW1aVPELRsTT2DOHWmd8TC_WvDIkBpVkrbQlE3-bIUpYgG0KC62UzExRuI_oaZFLcF1ApH4Xqq9rRMLrBSqxSHUbkXPHMqEQT27SUruU8GuCa4c3MAZhkoxWbWA7UEpOZdCnjo0mQs43Zl-C0soA910Hanrt2N6ZTAhw" />
            </div>
        </div>
    </header>
    <div class="flex min-h-screen">
        <!-- SideNavBar (Desktop Only) -->
        <aside class="hidden md:flex flex-col h-screen w-64 fixed left-0 top-0 bg-surface-container border-r border-outline-variant/10 p-md z-50">
            <div class="flex items-center gap-sm px-sm py-md">
                <img alt="Quatinx Logo" class="h-10 w-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuATUcku_1M5WA7ShpAB1ocpicZ1t6Tx5fxQUGW1XNXkxJRgn24xFPUEhLcSsnWCTXUDmoegPAwnQP9cleMl9zpVHuMbj-jo2TCN2KUMuo2gvQxwMaAZ3pLtuqKsCJdjgnMAFjr0uV_0RECLFIate4gszLOdAjXrT7o5ofwiKm4dbrnfBGovmrv974lKrbLnQiQ7uTPIsSb5Scpeus8lDZMF1eIncxB_rlyXh7nlsNos_PGTgfepsRtlIeDS1dmAoFie1g2d7gA8H3Q" />
                <div class="flex flex-col">
                    <span class="font-headline-md text-headline-md font-bold text-secondary">Quatinx</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">Enterprise ERP</span>
                </div>
            </div>
            <div class="mt-xl space-y-unit">
                <a class="flex items-center gap-md px-md py-sm bg-primary-container text-on-primary-container rounded-lg font-label-md transition-all active:translate-x-1" href="#">
                    <span class="material-symbols-outlined fill-icon" data-icon="dashboard" style="font-variation-settings: 'FILL' 1;">dashboard</span>
                    <span>Tableau de bord</span>
                </a>
                <a class="flex items-center gap-md px-md py-sm text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest rounded-lg transition-all active:translate-x-1 font-label-md" href="#">
                    <span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
                    <span>Inventaire</span>
                </a>
                <a class="flex items-center gap-md px-md py-sm text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest rounded-lg transition-all active:translate-x-1 font-label-md" href="#">
                    <span class="material-symbols-outlined" data-icon="warehouse">warehouse</span>
                    <span>Entrepôts</span>
                </a>
                <a class="flex items-center gap-md px-md py-sm text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest rounded-lg transition-all active:translate-x-1 font-label-md" href="#">
                    <span class="material-symbols-outlined" data-icon="group">group</span>
                    <span>Équipe</span>
                </a>
                <a class="flex items-center gap-md px-md py-sm text-on-surface-variant hover:text-on-surface hover:bg-surface-container-highest rounded-lg transition-all active:translate-x-1 font-label-md" href="#">
                    <span class="material-symbols-outlined" data-icon="settings">settings</span>
                    <span>Paramètres</span>
                </a>
            </div>
            <div class="mt-auto p-sm">
                <button class="w-full bg-secondary text-on-secondary py-sm rounded-lg font-label-md flex items-center justify-center gap-xs hover:opacity-90 active:scale-95 duration-100">
                    <span class="material-symbols-outlined text-[18px]" data-icon="add">add</span>
                    Nouveau Produit
                </button>
            </div>
        </aside>
        <!-- Main Content Area -->
        <main class="flex-1 md:ml-64 pb-24 md:pb-lg">
            <!-- Content Header (Desktop) -->
            <header class="hidden md:flex h-16 border-b border-outline-variant/10 items-center justify-between px-margin-desktop bg-surface sticky top-0 z-40">
                <div class="flex items-center gap-md flex-1">
                    <div class="relative w-96">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-on-surface-variant text-[20px]" data-icon="search">search</span>
                        <input class="pl-10 pr-md py-xs border border-outline-variant/20 rounded-lg text-body-sm focus:border-secondary focus:ring-1 focus:ring-secondary outline-none transition-all w-full bg-surface-container-low text-on-surface" placeholder="Recherche globale..." type="text" />
                    </div>
                </div>
                <div class="flex items-center gap-md">
                    <button class="px-md py-xs text-secondary font-label-md hover:bg-surface-container-high rounded-lg transition-colors">Passer en Premium</button>
                    <button class="material-symbols-outlined text-on-surface-variant hover:bg-surface-container-high p-sm rounded-full transition-colors" data-icon="help">help</button>
                    <button class="material-symbols-outlined text-on-surface-variant hover:bg-surface-container-high p-sm rounded-full transition-colors" data-icon="notifications">notifications</button>
                    <div class="w-8 h-8 rounded-full bg-surface-container-highest flex items-center justify-center overflow-hidden border border-outline-variant/20">
                        <img alt="User profile" class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCbiN31cIJIwFi0HG2BCYAa5ESBvlOEVmv8zthlEaeENRSGgsbpWrHH7ZStzK5hQdD_PKZ8zir90RW9a-HsXNkI3ye928i9CS9PaBoHYgdjW1aVPELRsTT2DOHWmd8TC_WvDIkBpVkrbQlE3-bIUpYgG0KC62UzExRuI_oaZFLcF1ApH4Xqq9rRMLrBSqxSHUbkXPHMqEQT27SUruU8GuCa4c3MAZhkoxWbWA7UEpOZdCnjo0mQs43Zl-C0soA910Hanrt2N6ZTAhw" />
                    </div>
                </div>
            </header>
            <div class="px-margin-mobile md:px-margin-desktop mt-20 md:mt-xl max-w-[1200px] mx-auto">
                <!-- Welcome Section -->
                <section class="mb-2xl">
                    <div class="flex flex-col md:flex-row md:items-end justify-between gap-xl">
                        <div>
                            <span class="font-label-sm text-label-sm text-secondary uppercase tracking-[0.2em] font-bold">Optimisez votre logistique</span>
                            <h2 class="font-headline-xl-mobile md:font-headline-xl text-on-surface mt-xs">Bienvenue sur votre supervision, Julien</h2>
                            <p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mt-sm">Votre infrastructure est prête. Finalisez la configuration pour activer le monitoring en temps réel et l'automatisation des flux.</p>
                        </div>
                        <!-- Onboarding Checklist Widget -->
                        <div class="bg-surface-container-low border border-outline-variant/10 rounded-xl p-lg min-w-[320px] shadow-sm">
                            <div class="flex justify-between items-center mb-sm">
                                <span class="font-label-md text-label-md text-on-surface font-semibold">Configuration du compte</span>
                                <span class="font-label-sm text-label-sm text-secondary">75% complété</span>
                            </div>
                            <div class="w-full bg-surface-container-highest h-2 rounded-full mb-lg overflow-hidden">
                                <div class="bg-secondary h-full w-3/4 rounded-full"></div>
                            </div>
                            <ul class="space-y-md">
                                <li class="flex items-center gap-sm text-body-sm text-on-surface/60">
                                    <span class="material-symbols-outlined text-[18px] text-secondary fill-icon" data-icon="check_circle">check_circle</span>
                                    <span>Identité vérifiée</span>
                                </li>
                                <li class="flex items-center gap-sm text-body-sm text-on-surface">
                                    <span class="material-symbols-outlined text-[18px] text-secondary" data-icon="radio_button_unchecked">radio_button_unchecked</span>
                                    <span>Complétez votre profil</span>
                                </li>
                                <li class="flex items-center gap-sm text-body-sm text-on-surface">
                                    <span class="material-symbols-outlined text-[18px] text-secondary" data-icon="radio_button_unchecked">radio_button_unchecked</span>
                                    <span>Importer votre premier fichier CSV</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </section>
                <!-- Quick Action Cards Grid -->
                <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-md mb-2xl">
                    <button class="group flex flex-col p-lg bg-surface-container border border-outline-variant/10 rounded-xl text-left hover:border-secondary/40 hover:bg-surface-container-high transition-all duration-300 hover:shadow-lg hover:shadow-secondary/5 active:scale-95">
                        <div class="w-12 h-12 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary mb-md group-hover:bg-secondary group-hover:text-on-secondary transition-all duration-300">
                            <span class="material-symbols-outlined text-[28px]" data-icon="add_box">add_box</span>
                        </div>
                        <h3 class="font-label-md text-label-md text-on-surface mb-xs font-semibold">Ajouter un produit</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Intégration manuelle ou import sériel.</p>
                    </button>
                    <button class="group flex flex-col p-lg bg-surface-container border border-outline-variant/10 rounded-xl text-left hover:border-secondary/40 hover:bg-surface-container-high transition-all duration-300 hover:shadow-lg hover:shadow-secondary/5 active:scale-95">
                        <div class="w-12 h-12 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary mb-md group-hover:bg-secondary group-hover:text-on-secondary transition-all duration-300">
                            <span class="material-symbols-outlined text-[28px]" data-icon="warehouse">warehouse</span>
                        </div>
                        <h3 class="font-label-md text-label-md text-on-surface mb-xs font-semibold">Configurer un entrepôt</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Définissez vos zones de stockage.</p>
                    </button>
                    <button class="group flex flex-col p-lg bg-surface-container border border-outline-variant/10 rounded-xl text-left hover:border-secondary/40 hover:bg-surface-container-high transition-all duration-300 hover:shadow-lg hover:shadow-secondary/5 active:scale-95">
                        <div class="w-12 h-12 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary mb-md group-hover:bg-secondary group-hover:text-on-secondary transition-all duration-300">
                            <span class="material-symbols-outlined text-[28px]" data-icon="analytics">analytics</span>
                        </div>
                        <h3 class="font-label-md text-label-md text-on-surface mb-xs font-semibold">Générer un rapport</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Analyses décisionnelles mensuelles.</p>
                    </button>
                    <button class="group flex flex-col p-lg bg-surface-container border border-outline-variant/10 rounded-xl text-left hover:border-secondary/40 hover:bg-surface-container-high transition-all duration-300 hover:shadow-lg hover:shadow-secondary/5 active:scale-95">
                        <div class="w-12 h-12 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary mb-md group-hover:bg-secondary group-hover:text-on-secondary transition-all duration-300">
                            <span class="material-symbols-outlined text-[28px]" data-icon="person_add">person_add</span>
                        </div>
                        <h3 class="font-label-md text-label-md text-on-surface mb-xs font-semibold">Inviter un collaborateur</h3>
                        <p class="font-body-sm text-body-sm text-on-surface-variant">Gérez les accès et permissions équipe.</p>
                    </button>
                </section>
                <!-- Bento Grid Empty State Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-lg">
                    <!-- Main Chart Empty State -->
                    <div class="lg:col-span-2 bg-surface-container-lowest border border-outline-variant/10 rounded-2xl p-xl flex flex-col items-center justify-center min-h-[450px] text-center relative overflow-hidden group">
                        <!-- Background Glows -->
                        <div class="absolute inset-0 opacity-10 pointer-events-none">
                            <div class="absolute -top-24 -left-24 w-64 h-64 bg-primary rounded-full blur-[100px]"></div>
                            <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-secondary rounded-full blur-[120px]"></div>
                        </div>
                        <div class="relative z-10 w-full max-w-md">
                            <div class="mb-xl">
                                <div class="w-full h-40 mx-auto relative flex items-end justify-between px-md">
                                    <!-- Faux Chart Graphic -->
                                    <div class="absolute inset-0 flex items-end justify-between px-md opacity-20">
                                        <div class="w-[12%] bg-outline-variant h-[20%] rounded-t-sm"></div>
                                        <div class="w-[12%] bg-outline-variant h-[45%] rounded-t-sm"></div>
                                        <div class="w-[12%] bg-outline-variant h-[30%] rounded-t-sm"></div>
                                        <div class="w-[12%] bg-outline-variant h-[60%] rounded-t-sm"></div>
                                        <div class="w-[12%] bg-outline-variant h-[40%] rounded-t-sm"></div>
                                        <div class="w-[12%] bg-outline-variant h-[80%] rounded-t-sm"></div>
                                    </div>
                                    <svg class="w-full h-full text-secondary/30" viewbox="0 0 100 50">
                                        <path d="M0,45 Q15,40 30,42 T60,25 T100,5" fill="none" stroke="currentColor" stroke-dasharray="4 2" stroke-width="2.5"></path>
                                        <circle class="animate-pulse" cx="100" cy="5" fill="currentColor" r="3"></circle>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="font-headline-md text-headline-md text-on-surface mb-sm">Flux d'activité des ventes</h3>
                            <p class="font-body-md text-body-md text-on-surface-variant mb-xl">Connectez vos canaux de distribution ou vos points de vente pour visualiser vos performances en temps réel.</p>
                            <button class="bg-secondary text-on-secondary font-label-md px-xl py-3 rounded-xl hover:brightness-110 hover:shadow-xl hover:shadow-secondary/20 transition-all font-bold">
                                Connecter une source de données
                            </button>
                        </div>
                    </div>
                    <!-- Side Widgets Stack -->
                    <div class="flex flex-col gap-lg">
                        <div class="bg-surface-container border border-outline-variant/10 rounded-2xl p-lg">
                            <h4 class="font-label-md text-label-md text-on-surface mb-lg font-semibold flex items-center justify-between">
                                Entrepôts récents
                                <span class="material-symbols-outlined text-on-surface-variant text-sm">more_horiz</span>
                            </h4>
                            <div class="space-y-lg">
                                <div class="flex items-center gap-md">
                                    <div class="w-10 h-10 rounded-lg bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[20px]" data-icon="location_on">location_on</span>
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <div class="h-2 bg-surface-container-highest rounded-full w-3/4"></div>
                                        <div class="h-3 bg-surface-container-highest rounded-full w-full overflow-hidden relative">
                                            <div class="h-full w-1/3 bg-secondary/40 animate-pulse"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-md opacity-50">
                                    <div class="w-10 h-10 rounded-lg bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[20px]" data-icon="location_on">location_on</span>
                                    </div>
                                    <div class="flex-1 space-y-2">
                                        <div class="h-2 bg-surface-container-highest rounded-full w-1/2"></div>
                                        <div class="h-3 bg-surface-container-highest rounded-full w-full"></div>
                                    </div>
                                </div>
                            </div>
                            <button class="mt-xl w-full text-secondary font-label-sm text-label-sm hover:underline flex items-center justify-center gap-xs font-bold border border-secondary/20 py-2 rounded-lg hover:bg-secondary/5 transition-colors">
                                Configurer les lieux
                                <span class="material-symbols-outlined text-[16px]" data-icon="arrow_forward">arrow_forward</span>
                            </button>
                        </div>
                        <div class="bg-secondary/5 border border-secondary/10 rounded-2xl p-lg relative group overflow-hidden">
                            <div class="relative z-10">
                                <span class="material-symbols-outlined text-secondary mb-sm" data-icon="tips_and_updates">tips_and_updates</span>
                                <h4 class="font-label-md text-label-md text-on-surface mb-xs font-bold">Conseil d'expert</h4>
                                <p class="font-body-sm text-body-sm text-on-surface-variant">Centralisez vos flux logistiques via l'API pour réduire les erreurs de saisie de 98%.</p>
                            </div>
                            <div class="absolute -right-4 -bottom-4 opacity-5 group-hover:opacity-10 transition-opacity">
                                <span class="material-symbols-outlined text-[80px]" data-icon="hub">hub</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <!-- BottomNavBar (Mobile Only) -->
    <nav class="fixed bottom-0 left-0 w-full z-50 flex justify-around items-center h-20 pb-safe bg-surface border-t border-outline-variant/10 shadow-lg md:hidden">
        <a class="flex flex-col items-center justify-center text-secondary font-bold active:scale-90 transition-transform" href="#">
            <span class="material-symbols-outlined fill-icon" data-icon="home_app_logo" style="font-variation-settings: 'FILL' 1;">home_app_logo</span>
            <span class="font-label-sm text-label-sm">Home</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant active:scale-90 transition-transform" href="#">
            <span class="material-symbols-outlined" data-icon="inventory_2">inventory_2</span>
            <span class="font-label-sm text-label-sm">Stock</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant active:scale-90 transition-transform" href="#">
            <span class="material-symbols-outlined" data-icon="location_on">location_on</span>
            <span class="font-label-sm text-label-sm">Lieux</span>
        </a>
        <a class="flex flex-col items-center justify-center text-on-surface-variant active:scale-90 transition-transform" href="#">
            <span class="material-symbols-outlined" data-icon="groups">groups</span>
            <span class="font-label-sm text-label-sm">Équipe</span>
        </a>
    </nav>
    <!-- Contextual FAB -->
    <button class="fixed bottom-24 right-margin-mobile md:bottom-lg md:right-margin-desktop bg-secondary text-on-secondary w-14 h-14 rounded-full shadow-2xl flex items-center justify-center hover:scale-110 hover:rotate-90 active:scale-95 transition-all z-40 group">
        <span class="material-symbols-outlined text-[28px]" data-icon="add">add</span>
        <span class="absolute right-full mr-4 bg-on-background text-surface px-md py-xs rounded-lg text-label-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none shadow-xl">Ajouter un produit</span>
    </button>
    <script>
        document.querySelectorAll('a, button').forEach(el => {
            el.addEventListener('click', (e) => {
                if (el.getAttribute('href') === '#') e.preventDefault();
            });
        });

        const header = document.querySelector('header');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 10) {
                header.classList.add('shadow-xl', 'bg-surface/90', 'backdrop-blur-md');
            } else {
                header.classList.remove('shadow-xl', 'bg-surface/90', 'backdrop-blur-md');
            }
        });
    </script>
</body>

</html>