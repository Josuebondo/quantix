<!DOCTYPE html>
<html class="dark" lang="fr">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Quantix - Gestion d'Équipe</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "inverse-primary": "#6d3bd7",
                        "on-surface-variant": "#cbc3d7",
                        "outline": "#958ea0",
                        "surface-container-lowest": "#0b0f10",
                        "on-error": "#690005",
                        "on-secondary-container": "#adb4ce",
                        "on-background": "#e0e3e5",
                        "on-tertiary-fixed-variant": "#2f2ebe",
                        "surface-bright": "#363a3b",
                        "inverse-surface": "#e0e3e5",
                        "surface": "#101415",
                        "surface-container": "#1d2022",
                        "on-tertiary-fixed": "#07006c",
                        "inverse-on-surface": "#2d3133",
                        "on-primary-fixed": "#23005c",
                        "on-primary-container": "#340080",
                        "surface-container-high": "#272a2c",
                        "outline-variant": "#494454",
                        "secondary-fixed-dim": "#bec6e0",
                        "secondary-container": "#3f465c",
                        "secondary": "#bec6e0",
                        "on-surface": "#e0e3e5",
                        "primary-fixed": "#e9ddff",
                        "on-tertiary": "#1000a9",
                        "on-secondary-fixed": "#131b2e",
                        "on-secondary": "#283044",
                        "on-error-container": "#ffdad6",
                        "secondary-fixed": "#dae2fd",
                        "primary-container": "#a078ff",
                        "on-primary": "#3c0091",
                        "tertiary-fixed": "#e1e0ff",
                        "surface-tint": "#d0bcff",
                        "primary": "#d0bcff",
                        "error-container": "#93000a",
                        "background": "#101415",
                        "tertiary": "#c0c1ff",
                        "surface-container-highest": "#323537",
                        "surface-variant": "#323537",
                        "on-primary-fixed-variant": "#5516be",
                        "error": "#ffb4ab",
                        "tertiary-fixed-dim": "#c0c1ff",
                        "surface-container-low": "#191c1e",
                        "primary-fixed-dim": "#d0bcff",
                        "tertiary-container": "#8083ff",
                        "on-tertiary-container": "#0d0096",
                        "surface-dim": "#101415",
                        "on-secondary-fixed-variant": "#3f465c",
                        "accent-emerald": "#10b981"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "container-max-width": "1280px",
                        "base": "8px",
                        "margin-desktop": "40px",
                        "margin-mobile": "16px",
                        "gutter": "24px"
                    },
                    "fontFamily": {
                        "headline-md": ["Hanken Grotesk"],
                        "display-lg-mobile": ["Hanken Grotesk"],
                        "label-sm": ["Inter"],
                        "display-lg": ["Hanken Grotesk"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"]
                    },
                    "fontSize": {
                        "headline-md": ["24px", {
                            "lineHeight": "32px",
                            "fontWeight": "600"
                        }],
                        "display-lg-mobile": ["36px", {
                            "lineHeight": "44px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "label-sm": ["13px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.05em",
                            "fontWeight": "600"
                        }],
                        "display-lg": ["48px", {
                            "lineHeight": "56px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }],
                        "body-lg": ["18px", {
                            "lineHeight": "28px",
                            "fontWeight": "400"
                        }],
                        "body-md": ["16px", {
                            "lineHeight": "24px",
                            "fontWeight": "400"
                        }]
                    }
                }
            }
        }
    </script>
    <style>
        .glass-card {
            background: rgba(29, 32, 34, 0.4);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(73, 68, 84, 0.3);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            border-color: rgba(208, 188, 255, 0.4);
            background: rgba(29, 32, 34, 0.6);
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .tab-active {
            color: var(--tw-color-primary);
            border-bottom: 2px solid #d0bcff;
        }

        .modal-backdrop {
            background: rgba(16, 20, 21, 0.85);
            backdrop-filter: blur(8px);
        }

        .sidebar-active {
            background: rgba(208, 188, 255, 0.1);
            color: #d0bcff;
            border-radius: 0.75rem;
            font-weight: 700;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #101415;
        }

        ::-webkit-scrollbar-thumb {
            background: #323537;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #494454;
        }
    </style>
</head>

<body class="bg-background text-on-background font-body-md min-h-screen flex overflow-hidden">
    <!-- Sidebar (Midnight Executive) -->
    <aside class="hidden md:flex flex-col h-screen w-64 fixed left-0 top-0 bg-surface-container-low border-r border-outline-variant py-gutter px-4 z-50">
        <div class="flex items-center gap-3 px-2 mb-10">
            <img alt="Quatinx Logo" class="w-10 h-10 object-contain rounded-lg" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCb7abgrw7rkcfSHmPbxTFFO2YMlOzmrVy7n8wGaih8nCEu8OrB9Smi2rjzewzj_rLT4ULFsITt4SWg9yrVLkYRfHS3VR777ctZotPm6B3zjpDOSfbuwXgVNi8boe09T-XJBBjS-w83HC5GaGxAALu4kJpX0LBl6y1k9zX9t_z-wTA1ReoWWqlxtCU6axo1M3xuGrSkQX78HtZfjiDVJ_p0nXMDgS-hfjwXS1JHUluHlRZ_WN7Q-a-c45ugG93koOvqWvHn4d_KE-k">
            <div class="flex flex-col">
                <span class="font-headline-md text-headline-md text-primary leading-tight">Quatinx</span>
                <span class="text-[10px] uppercase tracking-widest text-on-surface-variant font-bold">Enterprise SaaS</span>
            </div>
        </div>
        <nav class="flex-1 space-y-1">
            <p class="text-[10px] font-bold text-outline uppercase tracking-widest px-4 mb-2">Main Menu</p>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-xl transition-all" href="#">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-medium">Tableau de bord</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-xl transition-all" href="#">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="font-medium">Produits</span>
            </a>
            <p class="text-[10px] font-bold text-outline uppercase tracking-widest px-4 mt-8 mb-2">Administration</p>
            <a class="flex items-center gap-3 px-4 py-3 sidebar-active transition-all" href="#">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">groups</span>
                <span class="font-medium">Teams</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-xl transition-all" href="#">
                <span class="material-symbols-outlined">settings</span>
                <span class="font-medium">Paramètres</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:bg-surface-container-high rounded-xl transition-all" href="#">
                <span class="material-symbols-outlined">subscriptions</span>
                <span class="font-medium">Abonnement</span>
            </a>
        </nav>
        <div class="mt-auto pt-6 border-t border-outline-variant">
            <div class="bg-surface-container p-4 rounded-xl mb-4">
                <div class="flex justify-between text-xs mb-1">
                    <span class="text-on-surface-variant">Plan Entreprise</span>
                    <span class="text-primary font-bold">89%</span>
                </div>
                <div class="w-full bg-surface-container-highest h-1.5 rounded-full overflow-hidden">
                    <div class="bg-primary h-full w-[89%]"></div>
                </div>
                <p class="text-[10px] text-outline mt-2 italic">Expire le 10/12/2026</p>
            </div>
            <a class="flex items-center gap-3 px-4 py-3 text-on-surface-variant hover:text-primary transition-all" href="#">
                <span class="material-symbols-outlined">contact_support</span>
                <span class="font-medium">Aide &amp; Support</span>
            </a>
        </div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 md:ml-64 min-h-screen flex flex-col overflow-y-auto">
        <!-- Header -->
        <header class="h-16 flex items-center justify-between px-margin-desktop bg-background/80 backdrop-blur-md sticky top-0 z-40 border-b border-outline-variant/30">
            <div class="flex items-center bg-surface-container px-4 py-2 rounded-full w-96 border border-outline-variant/20">
                <span class="material-symbols-outlined text-outline text-xl">search</span>
                <input class="bg-transparent border-none focus:ring-0 text-sm text-on-surface w-full ml-2" placeholder="Rechercher..." type="text">
            </div>
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 flex items-center justify-center rounded-full bg-surface-container border border-outline-variant/20 relative">
                    <span class="material-symbols-outlined text-on-surface-variant">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full"></span>
                </button>
                <div class="flex items-center gap-3 ml-2 border-l border-outline-variant/30 pl-6">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-on-surface">John Owner</p>
                        <p class="text-[10px] text-outline">Administrateur</p>
                    </div>
                    <img alt="User Profile" class="w-10 h-10 rounded-full border-2 border-primary" data-alt="A professional headshot of a middle-aged businessman with a warm, confident expression. He is wearing a dark navy suit and has neatly groomed dark hair and a short beard. The background is a soft, blurred corporate office setting with cool blue tones and subtle light reflections that align with a premium executive SaaS interface." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDjfGPs76U9timm8vh_9T00YHamwiMALveDiwUtTqROc6MVzYC_A9ITJRBf_bHvt-lfmWr-auNS1bX2v6Vi_xvGFI2FwH8d8zhk5atBzNI99SYE0dpLwKIt93C7Qqt1vs2aEMsK1GZsOKh-3PA3bJFoJXJWGvx9Fz2bSTL97tsAb59hpfJ2Y769fVou0n_Fo5WZhBbeUd7B-p7VWImmbWgXVATgs3-H2qg1ffu9vmS5ZA6clOX2Z2Tahzicmm2dhQp9dz6wSR2w2Pw">
                </div>
            </div>
        </header>
        <div class="p-margin-desktop max-w-container-max-width mx-auto w-full">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
                <div>
                    <h1 class="font-display-lg text-display-lg text-on-surface tracking-tight mb-2">Teams</h1>
                    <p class="text-on-surface-variant max-w-xl">Gérez les membres de votre organisation, contrôlez les invitations en attente et définissez des permissions granulaires pour chaque rôle.</p>
                </div>
                <button class="bg-accent-emerald hover:brightness-110 text-background px-6 py-3 rounded-xl font-bold flex items-center gap-2 shadow-lg shadow-accent-emerald/20 transition-all active:scale-95" onclick="toggleModal('invite-modal')">
                    <span class="material-symbols-outlined">person_add</span>
                    Inviter un utilisateur
                </button>
            </div>
            <!-- Navigation Tabs -->
            <div class="flex border-b border-outline-variant/30 mb-8 overflow-x-auto">
                <button class="px-8 py-4 font-headline-md text-sm tracking-wide tab-active transition-all flex items-center gap-2" id="tab-utilisateurs" onclick="switchTab('utilisateurs')">
                    <span class="material-symbols-outlined text-lg">group</span>
                    Utilisateurs
                </button>
                <button class="px-8 py-4 font-headline-md text-sm tracking-wide text-on-surface-variant hover:text-on-surface transition-all flex items-center gap-2" id="tab-invitations" onclick="switchTab('invitations')">
                    <span class="material-symbols-outlined text-lg">mail</span>
                    Invitations
                    <span class="bg-surface-container-highest px-2 py-0.5 rounded-full text-[10px] font-bold">4</span>
                </button>
                <button class="px-8 py-4 font-headline-md text-sm tracking-wide text-on-surface-variant hover:text-on-surface transition-all flex items-center gap-2" id="tab-roles" onclick="switchTab('roles')">
                    <span class="material-symbols-outlined text-lg">security</span>
                    Rôles &amp; Permissions
                </button>
            </div>
            <!-- Tab Content: Utilisateurs -->
            <section class="tab-pane block" id="content-utilisateurs">
                <!-- Dashboard stats -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div class="glass-card p-5 rounded-2xl">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined">how_to_reg</span>
                            </div>
                            <div>
                                <p class="text-xs text-outline font-bold uppercase tracking-wider">Actifs</p>
                                <p class="text-2xl font-display-lg text-on-surface">12</p>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card p-5 rounded-2xl">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-accent-emerald/10 flex items-center justify-center text-accent-emerald">
                                <span class="material-symbols-outlined">schedule_send</span>
                            </div>
                            <div>
                                <p class="text-xs text-outline font-bold uppercase tracking-wider">Invitations</p>
                                <p class="text-2xl font-display-lg text-on-surface">4</p>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card p-5 rounded-2xl">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary">
                                <span class="material-symbols-outlined">shield_person</span>
                            </div>
                            <div>
                                <p class="text-xs text-outline font-bold uppercase tracking-wider">Rôles</p>
                                <p class="text-2xl font-display-lg text-on-surface">5</p>
                            </div>
                        </div>
                    </div>
                    <div class="glass-card p-5 rounded-2xl">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-on-tertiary-container/10 flex items-center justify-center text-tertiary">
                                <span class="material-symbols-outlined">group_add</span>
                            </div>
                            <div>
                                <p class="text-xs text-outline font-bold uppercase tracking-wider">Total</p>
                                <p class="text-2xl font-display-lg text-on-surface">16</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Table Controls -->
                <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-lg">search</span>
                            <input class="bg-surface-container border-outline-variant/30 focus:border-primary rounded-xl pl-10 text-sm py-2.5 w-64 ring-0 focus:ring-0" placeholder="Filtrer par nom..." type="text">
                        </div>
                        <select class="bg-surface-container border-outline-variant/30 rounded-xl text-sm py-2.5 ring-0 focus:ring-0 focus:border-primary">
                            <option>Tous les rôles</option>
                            <option>Administrateur</option>
                            <option>Employé</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2">
                        <button class="bg-surface-container-high border border-outline-variant/30 p-2.5 rounded-xl text-on-surface-variant hover:text-on-surface transition-all">
                            <span class="material-symbols-outlined">filter_list</span>
                        </button>
                        <button class="bg-surface-container-high border border-outline-variant/30 p-2.5 rounded-xl text-on-surface-variant hover:text-on-surface transition-all">
                            <span class="material-symbols-outlined">file_download</span>
                        </button>
                    </div>
                </div>
                <!-- Table -->
                <div class="glass-card rounded-2xl overflow-hidden border border-outline-variant/20">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-surface-container-high/50 border-b border-outline-variant/30">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-outline uppercase tracking-widest">Utilisateur</th>
                                <th class="px-6 py-4 text-xs font-bold text-outline uppercase tracking-widest">Rôle</th>
                                <th class="px-6 py-4 text-xs font-bold text-outline uppercase tracking-widest">Statut</th>
                                <th class="px-6 py-4 text-xs font-bold text-outline uppercase tracking-widest">Dernière Connexion</th>
                                <th class="px-6 py-4 text-xs font-bold text-outline uppercase tracking-widest text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10">
                            <!-- User Row 1 -->
                            <tr class="hover:bg-primary/5 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <img alt="John" class="w-10 h-10 rounded-full object-cover border border-primary/20" data-alt="Close-up of a smiling male executive with short dark hair and a groomed beard, wearing a professional dark suit against a soft-focus office background. The lighting is crisp and modern, matching a high-end corporate dashboard theme with deep midnight blues and subtle violet highlights." src="https://lh3.googleusercontent.com/aida-public/AB6AXuCAEPqC9n7HUu4YvCb2_4X9ASJ7LcUP_txrmBXDE-5d3az6mR9BrFPfTPST-vOHZYrT-MAZDq_zlGD6ZhHnSOrUXOeSMzTG7q4JJidZixYtE7AzU3Dp1o3dnmovnsuYPBpjRk-h3ibW9hnagbMiuhoaAo_WAQJ0wl9af5gAX2fg8JiKJGBz1NW6329Pqx2Intv9tSTw24YNjGofZ7lFxNPftDdjYZEnhab3BfDv2MjBXX9XbXLFGH_2mDscyeindfbHk3iXkjx0nPk">
                                        <div>
                                            <p class="font-bold text-on-surface text-sm flex items-center gap-2">
                                                John Owner
                                                <span class="bg-primary/10 text-primary text-[10px] px-1.5 py-0.5 rounded font-bold uppercase tracking-tighter">Vous</span>
                                            </p>
                                            <p class="text-xs text-outline">john.owner@quantix.ai</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-on-surface-variant">Administrateur</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="flex items-center gap-2 text-xs font-bold text-accent-emerald bg-accent-emerald/10 w-fit px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-accent-emerald"></span>
                                        Actif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-outline">Aujourd'hui, 11:42</td>
                                <td class="px-6 py-4 text-right">
                                    <button class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">more_vert</button>
                                </td>
                            </tr>
                            <!-- User Row 2 -->
                            <tr class="hover:bg-primary/5 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-tertiary-container/30 flex items-center justify-center text-tertiary font-bold">MK</div>
                                        <div>
                                            <p class="font-bold text-on-surface text-sm">Marie Kayembe</p>
                                            <p class="text-xs text-outline">marie.k@quantix.ai</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">Magasinier</td>
                                <td class="px-6 py-4">
                                    <span class="flex items-center gap-2 text-xs font-bold text-accent-emerald bg-accent-emerald/10 w-fit px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-accent-emerald"></span>
                                        Actif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-outline">Hier, 16:20</td>
                                <td class="px-6 py-4 text-right">
                                    <button class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">more_vert</button>
                                </td>
                            </tr>
                            <!-- User Row 3 -->
                            <tr class="hover:bg-primary/5 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-surface-container-highest flex items-center justify-center text-outline font-bold">KB</div>
                                        <div>
                                            <p class="font-bold text-on-surface text-sm">Kevin Bakala</p>
                                            <p class="text-xs text-outline">kbakala@quantix.ai</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">Comptable</td>
                                <td class="px-6 py-4">
                                    <span class="flex items-center gap-2 text-xs font-bold text-error bg-error/10 w-fit px-2 py-1 rounded-full">
                                        <span class="w-1.5 h-1.5 rounded-full bg-error animate-pulse"></span>
                                        Inactif
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-outline">02/06/2026, 10:05</td>
                                <td class="px-6 py-4 text-right relative group/menu">
                                    <button class="material-symbols-outlined text-outline group-hover:text-primary transition-colors">more_vert</button>
                                    <!-- Context Menu Simulation -->
                                    <div class="hidden group-hover/menu:block absolute right-0 top-full mt-1 w-48 bg-surface-container-highest border border-outline-variant/40 rounded-xl shadow-2xl z-50 overflow-hidden text-left py-1">
                                        <button class="w-full px-4 py-2 text-xs flex items-center gap-2 hover:bg-primary/20 text-on-surface transition-colors">
                                            <span class="material-symbols-outlined text-sm">visibility</span> Voir profil
                                        </button>
                                        <button class="w-full px-4 py-2 text-xs flex items-center gap-2 hover:bg-primary/20 text-on-surface transition-colors">
                                            <span class="material-symbols-outlined text-sm">edit</span> Modifier
                                        </button>
                                        <button class="w-full px-4 py-2 text-xs flex items-center gap-2 hover:bg-error/20 text-error transition-colors" onclick="toggleModal('deactivate-modal')">
                                            <span class="material-symbols-outlined text-sm">block</span> Désactiver
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
            <!-- Tab Content: Invitations -->
            <section class="tab-pane hidden" id="content-invitations">
                <div class="glass-card rounded-2xl overflow-hidden border border-outline-variant/20">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-surface-container-high/50 border-b border-outline-variant/30">
                            <tr>
                                <th class="px-6 py-4 text-xs font-bold text-outline uppercase tracking-widest">Email</th>
                                <th class="px-6 py-4 text-xs font-bold text-outline uppercase tracking-widest">Rôle Assigné</th>
                                <th class="px-6 py-4 text-xs font-bold text-outline uppercase tracking-widest">Envoyé le</th>
                                <th class="px-6 py-4 text-xs font-bold text-outline uppercase tracking-widest text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10">
                            <tr>
                                <td class="px-6 py-4 text-sm text-on-surface">p.ndombe@acme.cd</td>
                                <td class="px-6 py-4 text-sm text-on-surface-variant">Chef d'équipe</td>
                                <td class="px-6 py-4 text-sm text-outline">Hier, 14:30</td>
                                <td class="px-6 py-4 text-right flex justify-end gap-2">
                                    <button class="text-primary hover:underline text-xs font-bold">Renvoyer</button>
                                    <button class="text-error hover:underline text-xs font-bold ml-4">Annuler</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
            <!-- Tab Content: Rôles -->
            <section class="tab-pane hidden" id="content-roles">
                <div class="flex justify-end mb-4">
                    <button class="text-xs font-bold flex items-center gap-1 text-primary bg-primary/10 px-4 py-2 rounded-lg border border-primary/20 hover:bg-primary/20 transition-all" onclick="toggleModal('role-modal')">
                        <span class="material-symbols-outlined text-sm">add_circle</span> Nouveau rôle
                    </button>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="glass-card p-6 rounded-2xl border-t-2 border-t-primary">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="font-headline-md text-on-surface">Administrateur</h3>
                            <span class="bg-primary/20 text-primary text-[10px] px-2 py-0.5 rounded-full font-bold">Système</span>
                        </div>
                        <p class="text-xs text-outline mb-6">Accès complet à toutes les fonctionnalités et paramètres du système.</p>
                        <div class="flex items-center gap-2 mb-6">
                            <span class="material-symbols-outlined text-sm text-primary">groups</span>
                            <span class="text-xs text-on-surface-variant">2 Utilisateurs</span>
                        </div>
                        <button class="w-full py-2.5 text-xs font-bold text-primary border border-primary/30 rounded-xl hover:bg-primary/10 transition-colors">Modifier les permissions</button>
                    </div>
                    <!-- Role Card 2 -->
                    <div class="glass-card p-6 rounded-2xl">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="font-headline-md text-on-surface">Analyste</h3>
                        </div>
                        <p class="text-xs text-outline mb-6">Peut consulter les rapports et tableaux de bord mais ne peut rien modifier.</p>
                        <div class="flex items-center gap-2 mb-6">
                            <span class="material-symbols-outlined text-sm text-outline">groups</span>
                            <span class="text-xs text-on-surface-variant">5 Utilisateurs</span>
                        </div>
                        <button class="w-full py-2.5 text-xs font-bold text-outline border border-outline-variant/30 rounded-xl hover:bg-surface-container-highest transition-colors">Modifier les permissions</button>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <!-- Modal: Inviter un utilisateur -->
    <div class="fixed inset-0 z-[100] modal-backdrop flex items-center justify-center p-4" id="invite-modal">
        <div class="bg-surface-container-low border border-outline-variant/40 rounded-3xl w-full max-w-lg shadow-2xl overflow-hidden transform transition-all animate-in fade-in zoom-in duration-300">
            <div class="p-8">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-headline-md font-headline-md text-on-surface">Inviter un nouveau collaborateur</h2>
                    <button class="material-symbols-outlined text-outline hover:text-on-surface" onclick="toggleModal('invite-modal')">close</button>
                </div>
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-outline uppercase tracking-wider">Nom complet</label>
                        <input class="w-full bg-surface-container border-outline-variant/30 rounded-xl py-3 px-4 focus:ring-0 focus:border-primary text-on-surface" placeholder="ex: Alice Lukau" type="text">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-outline uppercase tracking-wider">Adresse email professionnel</label>
                        <input class="w-full bg-surface-container border-outline-variant/30 rounded-xl py-3 px-4 focus:ring-0 focus:border-primary text-on-surface" placeholder="alice.l@quantix.ai" type="email">
                    </div>
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-outline uppercase tracking-wider">Rôle organisationnel</label>
                        <select class="w-full bg-surface-container border-outline-variant/30 rounded-xl py-3 px-4 focus:ring-0 focus:border-primary text-on-surface">
                            <option>Sélectionner un rôle...</option>
                            <option>Administrateur</option>
                            <option>Manager</option>
                            <option>Employé</option>
                            <option>Analyste</option>
                        </select>
                    </div>
                </div>
                <div class="flex items-center gap-4 mt-10">
                    <button class="flex-1 py-3 border border-outline-variant/40 rounded-xl font-bold text-outline hover:bg-surface-container-high transition-colors" onclick="toggleModal('invite-modal')">Annuler</button>
                    <button class="flex-1 py-3 bg-primary text-on-primary rounded-xl font-bold hover:brightness-110 shadow-lg shadow-primary/20 transition-all">Envoyer l'invitation</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal: Confirmation désactivation -->
    <div class="hidden fixed inset-0 z-[100] modal-backdrop flex items-center justify-center p-4" id="deactivate-modal">
        <div class="bg-surface-container-low border border-outline-variant/40 rounded-3xl w-full max-w-md shadow-2xl overflow-hidden p-8">
            <div class="w-16 h-16 bg-error/10 text-error rounded-2xl flex items-center justify-center mb-6 mx-auto">
                <span class="material-symbols-outlined text-4xl">warning</span>
            </div>
            <h2 class="text-xl font-headline-md text-on-surface text-center mb-2">Désactiver l'utilisateur ?</h2>
            <p class="text-on-surface-variant text-center text-sm mb-8">Cette action empêchera l'utilisateur de se connecter à la plateforme. Ses données seront conservées mais son accès sera révoqué immédiatement.</p>
            <div class="flex flex-col gap-3">
                <button class="w-full py-3 bg-error text-on-error rounded-xl font-bold hover:brightness-110 shadow-lg shadow-error/20 transition-all">Confirmer la désactivation</button>
                <button class="w-full py-3 border border-outline-variant/40 rounded-xl font-bold text-outline hover:bg-surface-container-high transition-colors" onclick="toggleModal('deactivate-modal')">Garder l'utilisateur</button>
            </div>
        </div>
    </div>
    <!-- Modal: Rôles & Permissions Granulaires -->
    <div class="hidden fixed inset-0 z-[100] modal-backdrop flex items-center justify-center p-4" id="role-modal">
        <div class="bg-surface-container-low border border-outline-variant/40 rounded-3xl w-full max-w-2xl h-[80vh] flex flex-col shadow-2xl overflow-hidden">
            <div class="p-8 border-b border-outline-variant/20 flex justify-between items-center bg-surface-container/30">
                <div>
                    <h2 class="text-headline-md font-headline-md text-on-surface">Configuration du rôle</h2>
                    <p class="text-xs text-outline mt-1">Définissez les accès précis pour ce nouveau profil</p>
                </div>
                <button class="material-symbols-outlined text-outline hover:text-on-surface" onclick="toggleModal('role-modal')">close</button>
            </div>
            <div class="flex-1 overflow-y-auto p-8 space-y-8">
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 glass-card rounded-2xl">
                        <div>
                            <p class="font-bold text-on-surface">Gestion des stocks</p>
                            <p class="text-xs text-outline">Peut modifier les quantités et ajouter des SKU</p>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input checked="" class="sr-only peer" type="checkbox">
                            <div class="w-11 h-6 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 glass-card rounded-2xl">
                        <div>
                            <p class="font-bold text-on-surface">Rapports Financiers</p>
                            <p class="text-xs text-outline">Accès aux marges et analyses de coûts</p>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input class="sr-only peer" type="checkbox">
                            <div class="w-11 h-6 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 glass-card rounded-2xl">
                        <div>
                            <p class="font-bold text-on-surface">Suppression de données</p>
                            <p class="text-xs text-outline">Droit d'archivage et de suppression définitive</p>
                        </div>
                        <div class="relative inline-flex items-center cursor-pointer">
                            <input class="sr-only peer" type="checkbox">
                            <div class="w-11 h-6 bg-surface-container-highest peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-8 border-t border-outline-variant/20 bg-surface-container/30 flex justify-end gap-4">
                <button class="px-6 py-2.5 border border-outline-variant/40 rounded-xl font-bold text-outline hover:bg-surface-container-high transition-colors" onclick="toggleModal('role-modal')">Fermer</button>
                <button class="px-8 py-2.5 bg-primary text-on-primary rounded-xl font-bold hover:brightness-110 shadow-lg shadow-primary/20 transition-all">Enregistrer le rôle</button>
            </div>
        </div>
    </div>
    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        function switchTab(tabName) {
            // Update Tab UI
            const tabs = ['utilisateurs', 'invitations', 'roles'];
            tabs.forEach(t => {
                const tabBtn = document.getElementById(`tab-${t}`);
                const tabContent = document.getElementById(`content-${t}`);

                if (t === tabName) {
                    tabBtn.classList.add('tab-active');
                    tabBtn.classList.remove('text-on-surface-variant');
                    tabContent.classList.remove('hidden');
                    tabContent.classList.add('block');
                } else {
                    tabBtn.classList.remove('tab-active');
                    tabBtn.classList.add('text-on-surface-variant');
                    tabContent.classList.add('hidden');
                    tabContent.classList.remove('block');
                }
            });
        }

        // Close modals on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                document.querySelectorAll('.modal-backdrop').forEach(m => m.classList.add('hidden'));
            }
        });
    </script>


</body>

</html>