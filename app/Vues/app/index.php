<!DOCTYPE html>
<html lang="fr">

<head>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
    <title>Quantix | App workspaces</title>
    <link rel="stylesheet" href="/css/tailwind.css">
    <link rel="stylesheet" href="/css/loader.css">
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700;800&amp;family=Inter:wght@400;600;700&amp;family=Manrope:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />


    <style>
        body {
            font-family: 'Manrope', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        .theme-shell {
            background-image:
                radial-gradient(circle at top left, rgba(0, 80, 203, 0.10), transparent 32rem),
                linear-gradient(180deg, #f8f9ff 0%, #eff4ff 100%);
        }

        .dark .theme-shell {
            background-image:
                radial-gradient(circle at top left, rgba(179, 197, 255, 0.10), transparent 34rem),
                linear-gradient(180deg, #0b0e14 0%, #161b26 100%);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #3b82f6;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 20;
        }

        .movement-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 0.75rem;
        }

        .document-grid {
            display: grid;
            grid-template-columns: repeat(1, minmax(0, 1fr));
            gap: 0.70rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .spin {
            animation: spin 1s linear infinite;
        }


        @media (min-width: 640px) {
            .movement-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .movement-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (min-width: 1536px) {
            .movement-grid {
                grid-template-columns: repeat(5, minmax(0, 1fr));
            }
        }

        @media (min-width: 640px) {
            .document-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (min-width: 1024px) {
            .document-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }

        @media (min-width: 1536px) {
            .document-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }
        }
    </style>
    <script>
        (function() {
            const savedMode = localStorage.getItem('darkMode');
            const savedTheme = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = savedMode ? savedMode === 'true' : (savedTheme ? savedTheme === 'dark' : prefersDark);
            document.documentElement.classList.toggle('dark', isDark);
        })();
    </script>
</head>

<body x-data="{
    isDark: document.documentElement.classList.contains('dark'),
    sidebarOpen: false,
    activeTab: 'users',

    init() {
        this.updateDarkMode();
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
            if (!localStorage.getItem('darkMode') && !localStorage.getItem('theme')) {
                this.isDark = event.matches;
                this.updateDarkMode();
            }
        });
    },

    toggleDarkMode() {
        this.isDark = !this.isDark;
        this.updateDarkMode();
        localStorage.setItem('darkMode', this.isDark);
        localStorage.setItem('theme', this.isDark ? 'dark' : 'light');
    },

    updateDarkMode() {
        document.documentElement.classList.toggle('dark', this.isDark);
    },

    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
        document.body.style.overflow = this.sidebarOpen ? 'hidden' : '';
    },

    closeSidebar() {
        this.sidebarOpen = false;
        document.body.style.overflow = '';
    },

    selectTab(tabName) {
        this.activeTab = tabName;
    },

    openInvitationModal() {
        this.activeTab = 'invitations';
    },

    openRoleModal() {
        this.activeTab = 'roles';
    },

    get darkModeIcon() {
        return this.isDark ? 'light_mode' : 'dark_mode';
    }
}" class="font-display bg-background-light text-on-surface dark:bg-background-dark dark:text-inverse-on-surface overflow-hidden">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar for Desktop -->
        <!-- Mobile Sidebar Overlay -->
        <div class="fixed inset-0 bg-on-surface/45 dark:bg-black/60 z-40 lg:hidden" id="sidebar-overlay" @click="closeSidebar()" x-show="sidebarOpen" x-transition x-cloak></div>
        <!-- SideNavBar -->
        <aside class="w-[280px] h-screen fixed lg:static left-0 top-0 bg-surface/95 dark:bg-surface-dark/95 border-r border-outline-variant dark:border-border-dark flex flex-col py-6 z-50 transition-transform duration-300 -translate-x-full lg:translate-x-0 backdrop-blur-xl" id="sidebar" :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen }" @keydown.escape="closeSidebar()">
            <div class="px-6 mb-8 flex items-center justify-between">
                <div class="flex items-center gap-3 text-2xl font-extrabold tracking-tight text-primary dark:text-primary-fixed">
                    <!-- Brand Logo -->
                    <div class="flex items-center gap-2 h-20 rounded-full ">
                        <img alt="Quantix Logo" class="h-20 w-10 object-contain dark:brightness-200" style="border-radius: 100%;" src="<?= asset('images/quantix_logo.jpeg') ?>" />
                    </div>
                    Quantix
                </div>
                <button class="lg:hidden text-on-surface-variant dark:text-surface-variant" id="close-sidebar" @click="closeSidebar()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="px-4 mb-6">
                <div class="flex items-center gap-3 p-3 rounded-xl border border-outline-variant dark:border-outline bg-surface-container-lowest dark:bg-surface-variant/10 transition-colors duration-200">
                    <div class="w-10 h-10 rounded-lg bg-primary-container text-on-primary flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined">domain</span>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <div class="text-sm font-bold text-on-surface dark:text-inverse-on-surface truncate">ACME SARL</div>
                        <div class="text-xs text-on-surface-variant dark:text-surface-variant truncate">Plan Entreprise</div>
                    </div>
                    <span class="material-symbols-outlined text-on-surface-variant dark:text-surface-variant">expand_more</span>
                </div>
            </div>
            <nav class="flex-1 overflow-y-auto px-2 space-y-1" id="sidebar-nav">
                <a class="nav-item flex items-center gap-3 text-on-surface-variant dark:text-surface-variant font-body-md px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed rounded-lg transition-colors duration-200" href="#">
                    <span class="material-symbols-outlined">dashboard</span> Tableau de bord
                </a>
                <a class="nav-item flex items-center gap-3 text-on-surface-variant dark:text-surface-variant font-body-md px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed rounded-lg transition-colors duration-200" href="#">
                    <span class="material-symbols-outlined">warehouse</span> Entrepôts
                </a>
                <a class="nav-item flex items-center gap-3 text-on-surface-variant dark:text-surface-variant font-body-md px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed rounded-lg transition-colors duration-200" href="#">
                    <span class="material-symbols-outlined">inventory_2</span> Produits
                </a>
                <a class="nav-item flex items-center gap-3 text-on-surface-variant dark:text-surface-variant font-body-md px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed rounded-lg transition-colors duration-200" href="#">
                    <span class="material-symbols-outlined">inventory</span> Stock
                </a>
                <a class="nav-item flex items-center gap-3 text-on-surface-variant dark:text-surface-variant font-body-md px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed rounded-lg transition-colors duration-200" href="#">
                    <span class="material-symbols-outlined">swap_horiz</span> Mouvements
                </a>
                <a class="nav-item flex items-center gap-3 text-on-surface-variant dark:text-surface-variant font-body-md px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed rounded-lg transition-colors duration-200" href="#">
                    <span class="material-symbols-outlined">shopping_cart</span> Achats
                </a>
                <a class="nav-item flex items-center gap-3 text-on-surface-variant dark:text-surface-variant font-body-md px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed rounded-lg transition-colors duration-200 mb-4" href="#">
                    <span class="material-symbols-outlined">analytics</span> Rapports
                </a>
                <div class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-surface-variant">ADMINISTRATION</div>
                <a class="nav-item flex items-center gap-3 bg-primary dark:bg-primary-container text-on-primary dark:text-on-primary-container rounded-lg font-body-md px-4 py-3 mx-2 transition-all active-nav" href="#">
                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">group</span> Teams
                </a>
                <a class="nav-item flex items-center gap-3 text-on-surface-variant dark:text-surface-variant font-body-md px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed rounded-lg transition-colors duration-200" href="#">
                    <span class="material-symbols-outlined">settings</span> Paramètres
                </a>
                <a class="nav-item flex items-center gap-3 text-on-surface-variant dark:text-surface-variant font-body-md px-4 py-3 mx-2 hover:bg-surface-container-high dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed rounded-lg transition-colors duration-200" href="#">
                    <span class="material-symbols-outlined">payments</span> Abonnement
                </a>
            </nav>

        </aside>
        <div class="flex-1 flex flex-col min-w-0 h-screen overflow-hidden">
            <header class="shrink-0 h-20 w-full z-40 bg-surface/80 dark:bg-surface-dark/80 backdrop-blur-xl border-b border-outline-variant dark:border-border-dark flex justify-between items-center px-4 sm:px-6 transition-colors duration-200">
                <div class="flex items-center gap-4 flex-1">
                    <button class="lg:hidden w-10 h-10 flex items-center justify-center text-on-surface-variant dark:text-surface-variant" id="open-sidebar" @click="toggleSidebar()">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div class="flex-1 max-w-xl hidden md:block">
                        <div class="relative flex items-center w-full h-11 rounded-xl bg-surface-container-lowest dark:bg-inverse-surface border border-outline-variant dark:border-outline focus-within:border-primary/50 focus-within:ring-2 focus-within:ring-primary/30 transition-all">
                            <span class="material-symbols-outlined text-on-surface-variant dark:text-surface-variant ml-3 text-lg">search</span>
                            <input class="w-full bg-transparent border-none focus:ring-0 text-sm text-on-surface dark:text-inverse-on-surface px-3 placeholder:text-on-surface-variant/60 dark:placeholder:text-surface-variant/60" placeholder="Rechercher..." type="text" />
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:gap-4">
                    <button class="w-10 h-10 rounded-full bg-primary/10 text-primary dark:text-primary-fixed flex items-center justify-center hover:bg-primary/20 transition-colors">
                        <span class="material-symbols-outlined">add</span>
                    </button>
                    <div class="flex items-center gap-1 sm:gap-2 border-l border-outline-variant dark:border-border-dark pl-2 sm:pl-4 ml-1 sm:ml-2">
                        <button class="relative p-2 text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors">
                            <span class="material-symbols-outlined">notifications</span>
                            <span class="absolute top-1 right-1 w-4 h-4 bg-primary dark:bg-primary-fixed text-on-primary dark:text-on-primary-fixed text-[10px] font-bold flex items-center justify-center rounded-full border-2 border-surface dark:border-surface-dark">3</span>
                        </button>
                        <button class="p-2 text-on-surface-variant dark:text-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors" id="darkModeToggle" @click="toggleDarkMode()" aria-label="Changer le theme">
                            <span class="material-symbols-outlined" id="darkModeIcon" x-text="darkModeIcon"></span>
                        </button>
                    </div>
                    <div class="flex items-center gap-3 ml-2 cursor-pointer hover:bg-surface-container-low dark:hover:bg-surface-variant/30 p-1.5 rounded-lg transition-colors">
                        <img alt="John Owner Profile" class="w-8 h-8 sm:w-9 sm:h-9 rounded-full object-cover border border-outline-variant dark:border-outline" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA_qpKMJP9VPm_iHhLpfCWjxLioMWEAvJ9SSVj0R8w_K9x7Mgtb3uGvR351uAuFFd6Q22aQpTtxiXkIhH39A75s-K-Gp6NWpNvY5Of8ygiJw_RYbLdpHi2kIg9jzT0XdSwmOpHi9Xm_-SptkRmOtH_E2Kgz5swOCiY0V_t-TU_Nd-x6aFgiDNoaZV0igce_BqPNuczYEGB_81swAW9OY3XpnavFGPdLqexdpqH10u4WpNAvg5L3UqPGnHHQdjB2nyrTFcYuqWvWq8cz" />
                        <div class="hidden lg:block text-sm">
                            <div class="text-sm font-bold text-on-surface dark:text-inverse-on-surface">John Owner</div>
                            <div class="text-xs text-on-surface-variant dark:text-surface-variant">Owner</div>
                        </div>
                        <span class="material-symbols-outlined text-on-surface-variant dark:text-surface-variant hidden sm:block">expand_more</span>
                    </div>
                </div>
            </header>
            <main class="theme-shell flex-1 flex flex-col min-w-0 overflow-y-auto custom-scrollbar" id="app">
                <!-- TopAppBar -->


            </main>
            <div id="loader-container" class="relative top-0 w-full h-full flex items-center justify-center">
            </div>
        </div>
        <script type="module" src="<?= asset('js/qtix/bootstrap.js') ?>"></script>
        <script type="module">
            Qtix.iniLoading('loader-container');
            Qtix.startLoading();
            Qtix.registerRoute("company/teams", {

            });
            await Qtix.navigate("/company/teams");
        </script>


        <div id="toast-container" class="fixed bottom-6 left-1/2 -translate-x-1/2 flex flex-col gap-3 items-center"></div>
</body>

</html>