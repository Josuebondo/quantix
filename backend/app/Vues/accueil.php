<html class="dark" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Quantix | Gestion de Stock Intelligente de Nouvelle Génération</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&amp;family=Hanken+Grotesk:wght@600;700;800&amp;family=JetBrains+Mono:wght@500&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            "colors": {
                    "surface": "#051424",
                    "primary-fixed-dim": "#4edea3",
                    "primary-container": "#10b981",
                    "secondary-fixed-dim": "#d0bcff",
                    "surface-container": "#122131",
                    "on-primary-container": "#00422b",
                    "on-surface": "#d4e4fa",
                    "on-secondary-fixed-variant": "#5516be",
                    "on-tertiary-fixed-variant": "#842225",
                    "error": "#ffb4ab",
                    "surface-tint": "#4edea3",
                    "primary": "#4edea3",
                    "on-primary": "#003824",
                    "on-error": "#690005",
                    "inverse-surface": "#d4e4fa",
                    "surface-container-lowest": "#010f1f",
                    "error-container": "#93000a",
                    "secondary-container": "#571bc1",
                    "on-secondary": "#3c0091",
                    "tertiary-fixed-dim": "#ffb3af",
                    "background": "#051424",
                    "tertiary-fixed": "#ffdad7",
                    "outline": "#86948a",
                    "primary-fixed": "#6ffbbe",
                    "on-tertiary": "#650911",
                    "surface-container-low": "#0d1c2d",
                    "surface-container-highest": "#273647",
                    "tertiary": "#ffb3af",
                    "on-surface-variant": "#bbcabf",
                    "on-error-container": "#ffdad6",
                    "on-background": "#d4e4fa",
                    "on-tertiary-container": "#711419",
                    "secondary-fixed": "#e9ddff",
                    "outline-variant": "#3c4a42",
                    "on-primary-fixed": "#002113",
                    "surface-bright": "#2c3a4c",
                    "inverse-on-surface": "#233143",
                    "tertiary-container": "#fc7c78",
                    "surface-container-high": "#1c2b3c",
                    "secondary": "#d0bcff",
                    "inverse-primary": "#006c49",
                    "on-tertiary-fixed": "#410005",
                    "on-primary-fixed-variant": "#005236",
                    "surface-variant": "#273647",
                    "on-secondary-fixed": "#23005c",
                    "surface-dim": "#051424",
                    "on-secondary-container": "#c4abff"
            },
            "borderRadius": {
                    "DEFAULT": "0.25rem",
                    "lg": "0.5rem",
                    "xl": "0.75rem",
                    "full": "9999px"
            },
            "spacing": {
                    "unit": "4px",
                    "stack-lg": "64px",
                    "container-max": "1280px",
                    "stack-sm": "16px",
                    "stack-xl": "128px",
                    "margin-mobile": "20px",
                    "stack-md": "32px",
                    "gutter": "24px"
            },
            "fontFamily": {
                    "label-sm": ["JetBrains Mono"],
                    "headline-lg": ["Hanken Grotesk"],
                    "body-md": ["Inter"],
                    "headline-md": ["Hanken Grotesk"],
                    "display-xl": ["Hanken Grotesk"],
                    "body-lg": ["Inter"],
                    "display-xl-mobile": ["Hanken Grotesk"]
            },
            "fontSize": {
                    "label-sm": ["13px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500"}],
                    "headline-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "600"}],
                    "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                    "headline-md": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                    "display-xl": ["72px", {"lineHeight": "80px", "letterSpacing": "-0.04em", "fontWeight": "700"}],
                    "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                    "display-xl-mobile": ["40px", {"lineHeight": "48px", "letterSpacing": "-0.02em", "fontWeight": "700"}]
            }
          },
        },
      }
    </script>
<style>
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
            scroll-behavior: smooth;
        }
        .light {
            --bg-color: #ffffff;
            --text-color: #051424;
            --card-bg: rgba(245, 247, 250, 0.8);
            --border-color: rgba(0, 0, 0, 0.1);
        }
        .dark {
            --bg-color: #051424;
            --text-color: #d4e4fa;
            --card-bg: rgba(18, 33, 49, 0.4);
            --border-color: rgba(255, 255, 255, 0.08);
        }
        .glass-card {
            background: var(--card-bg);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid var(--border-color);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .glass-card:hover {
            border-color: #4edea3;
            transform: translateY(-4px);
        }
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1);
        }
        .reveal.active {
            opacity: 1;
            transform: translateY(0);
        }
        #mobile-menu {
            transform: translateX(100%);
            transition: transform 0.3s ease-in-out;
        }
        #mobile-menu.active {
            transform: translateX(0);
        }
        .badge {
            @apply px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase border;
        }
        #canvas-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            pointer-events: none;
        }
        #threejs-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            pointer-events: none;
        }
        .pricing-card.popular {
            border: 2px solid #4edea3;
            box-shadow: 0 0 40px rgba(78, 222, 163, 0.15);
        }
        .feature-grid-icon {
            @apply w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary transition-all duration-300 group-hover:scale-110 group-hover:bg-primary/20;
        }
    </style>
</head>
<body class="bg-background text-on-background font-body-md overflow-x-hidden">
<canvas id="canvas-bg"></canvas>
<!-- Top Navigation Bar -->
<header class="fixed top-0 w-full z-50 bg-surface/70 dark:bg-surface/70 backdrop-blur-xl border-b border-outline-variant/30 h-20 flex items-center">
<nav class="max-w-container-max mx-auto px-gutter w-full flex justify-between items-center">
<div class="flex items-center gap-10">
<a class="flex items-center gap-2" href="#">
<img alt="Quantix Logo" class="h-10 w-auto" src="https://lh3.googleusercontent.com/aida-public/AB6AXuByTgnshUXeLHiMfcs13K9-C_L_UZfZ0Qr28GMef71095Nmuoynkk5hioUIiR_P3MUGLumoFWVzFYpxYIt2Wk86aThwY5W9dWf61jqM-PX5KAE15C86AinWhFNd6B90dpzNeb8HptBJsC6kEcCDJ61eJnO--pwp-zgcwdhTdQKHbcAg9LdAwvUEhYNRCFzx7vqjD5llJvUiD7A2WuBsIVkyU6IHnZBYZm_cz3jamhq02R_rdZNX9ja4LkY9Vtfhp7_CV56Pkpco9tY"/>
<span class="font-headline-md text-headline-md font-bold text-on-surface">Quantix</span>
</a>
<div class="hidden lg:flex gap-8">
<a class="font-body-md text-body-md text-primary font-bold hover:text-primary transition-colors" href="#">Accueil</a>
<a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#features">Fonctionnalités</a>
<a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#pricing">Tarifs</a>
<a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors" href="#faq">Support</a>
</div>
</div>
<div class="flex items-center gap-3 md:gap-6">
<button class="p-2 rounded-full hover:bg-surface-container-high transition-colors" id="theme-toggle" title="Changer de thème">
<span class="material-symbols-outlined dark:hidden">dark_mode</span>
<span class="material-symbols-outlined hidden dark:block">light_mode</span>
</button>
<div class="hidden md:flex items-center gap-4">
<button class="font-body-md text-body-md text-on-surface-variant hover:text-on-surface transition-colors">Connexion</button>
<button class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-bold hover:brightness-110 active:scale-95 transition-all">Essai gratuit</button>
</div>
<button class="lg:hidden p-2 text-on-surface" id="menu-btn">
<span class="material-symbols-outlined text-3xl">menu</span>
</button>
</div>
</nav>
</header>
<!-- Mobile Navigation Menu -->
<div class="fixed inset-0 z-[60] bg-surface flex flex-col lg:hidden" id="mobile-menu">
<div class="flex justify-between items-center px-gutter h-20 border-b border-outline-variant/30">
<span class="font-headline-md font-bold text-on-surface">Menu</span>
<button class="p-2 text-on-surface" id="close-menu"><span class="material-symbols-outlined text-3xl">close</span></button>
</div>
<div class="flex flex-col p-8 gap-6 text-xl font-semibold">
<a class="text-primary" href="#">Accueil</a>
<a class="text-on-surface hover:text-primary" href="#features">Fonctionnalités</a>
<a class="text-on-surface hover:text-primary" href="#pricing">Tarifs</a>
<a class="text-on-surface hover:text-primary" href="#faq">Documentation</a>
<hr class="border-outline-variant/30"/>
<button class="text-left py-2 text-on-surface">Connexion</button>
<button class="bg-primary text-on-primary px-6 py-4 rounded-xl text-center">Commencer gratuitement</button>
</div>
</div>
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center pt-20 overflow-hidden">
<div id="threejs-container"></div>
<div class="max-w-container-max mx-auto px-gutter grid grid-cols-1 lg:grid-cols-2 gap-stack-lg relative z-10">
<div class="flex flex-col justify-center reveal active bg-surface/40 md:bg-none w-full lg:bg-transparent  p-6 md:p-10 lg:p-0 rounded-3xl">
<div class="flex flex-wrap gap-2 mb-6">
<span class="bg-primary/10 text-primary border border-primary/20 badge">IA-Propulsé</span>
<span class="bg-surface-container-highest text-on-surface-variant border border-outline-variant/30 badge">SaaS Platform</span>
<span class="bg-surface-container-highest text-on-surface-variant border border-outline-variant/30 badge">Natif Mobile</span>
</div>
<span class="font-label-sm text-label-sm text-primary uppercase tracking-widest mb-4">La logistique réinventée</span>
<h1 class="font-display-xl text-display-xl-mobile md:text-display-xl mb-8 leading-tight text-on-surface drop-shadow-sm">
                Gérez votre stock <span class="text-primary">intelligemment</span> avec Quantix
            </h1>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-xl mb-12">
                Une interface élégante pour des opérations complexes. Pilotez vos produits, entrepôts et équipes en temps réel avec une précision chirurgicale.
            </p>
<div class="flex flex-col sm:flex-row gap-4">
<button class="bg-primary text-on-primary px-8 py-4 rounded-xl font-bold shadow-lg shadow-primary/20 hover:brightness-110 active:scale-95 transition-all text-center">
                    Commencer gratuitement
                </button>
<button class="bg-surface-container-high dark:bg-surface-container-high text-on-surface px-8 py-4 rounded-xl font-bold border border-outline-variant/30 hover:bg-surface-container-highest transition-all flex items-center justify-center gap-2 active:scale-95">
<span class="material-symbols-outlined">play_circle</span>
                    Voir la démo
                </button>
</div>
</div>
<!-- Placeholder for desktop alignment -->
<div class="hidden lg:block"></div>
</div>
</section>
<!-- Stats Bar -->
<section class="py-16 bg-surface-container-lowest border-y border-outline-variant/10 relative z-10">
<div class="max-w-container-max mx-auto px-gutter grid grid-cols-2 md:grid-cols-4 gap-8">
<div class="text-center reveal">
<div class="font-headline-lg text-headline-lg text-primary mb-1 counter" data-target="10000">0</div>
<div class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Produits gérés</div>
</div>
<div class="text-center reveal" style="transition-delay: 100ms;">
<div class="font-headline-lg text-headline-lg text-primary mb-1 counter" data-target="500">0</div>
<div class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Entreprises</div>
</div>
<div class="text-center reveal" style="transition-delay: 200ms;">
<div class="font-headline-lg text-headline-lg text-primary mb-1">99.9%</div>
<div class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Disponibilité</div>
</div>
<div class="text-center reveal" style="transition-delay: 300ms;">
<div class="font-headline-lg text-headline-lg text-primary mb-1">24/7</div>
<div class="font-label-sm text-label-sm text-on-surface-variant uppercase tracking-wider">Support expert</div>
</div>
</div>
</section>
<!-- Full Features Grid -->
<section class="py-stack-xl relative z-10" id="features">
<div class="max-w-container-max mx-auto px-gutter">
<div class="text-center mb-20 reveal">
<h2 class="font-headline-lg text-headline-lg mb-6 text-on-surface">Un écosystème complet de modules</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant max-w-2xl mx-auto">
                Tout ce dont vous avez besoin pour passer d'une gestion artisanale à une logistique de classe mondiale.
            </p>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
<!-- Feature Cards -->
<div class="glass-card p-6 rounded-2xl group reveal">
<div class="flex justify-between items-start mb-6">
<div class="feature-grid-icon"><span class="material-symbols-outlined">inventory_2</span></div>
<span class="badge bg-primary/10 text-primary border-primary/20">Web</span>
</div>
<h3 class="font-bold text-lg mb-2 text-on-surface">Produits</h3>
<p class="text-sm text-on-surface-variant">Catalogue dynamique, variantes et codes-barres haute définition.</p>
</div>
<div class="glass-card p-6 rounded-2xl group reveal" style="transition-delay: 100ms;">
<div class="flex justify-between items-start mb-6">
<div class="feature-grid-icon"><span class="material-symbols-outlined">warehouse</span></div>
<span class="badge bg-secondary/10 text-secondary border-secondary/20">Web</span>
</div>
<h3 class="font-bold text-lg mb-2 text-on-surface">Entrepôts</h3>
<p class="text-sm text-on-surface-variant">Multi-sites avec cartographie 3D des zones de stockage.</p>
</div>
<div class="glass-card p-6 rounded-2xl group reveal" style="transition-delay: 200ms;">
<div class="flex justify-between items-start mb-6">
<div class="feature-grid-icon"><span class="material-symbols-outlined">login</span></div>
<span class="badge bg-primary/10 text-primary border-primary/20">Mobile</span>
</div>
<h3 class="font-bold text-lg mb-2 text-on-surface">Entrées</h3>
<p class="text-sm text-on-surface-variant">Réception fournisseur et contrôle qualité par scan mobile.</p>
</div>
<div class="glass-card p-6 rounded-2xl group reveal" style="transition-delay: 300ms;">
<div class="flex justify-between items-start mb-6">
<div class="feature-grid-icon"><span class="material-symbols-outlined">logout</span></div>
<span class="badge bg-primary/10 text-primary border-primary/20">Mobile</span>
</div>
<h3 class="font-bold text-lg mb-2 text-on-surface">Sorties</h3>
<p class="text-sm text-on-surface-variant">Expéditions et retours clients avec étiquetage automatisé.</p>
</div>
<div class="glass-card p-6 rounded-2xl group reveal" style="transition-delay: 400ms;">
<div class="flex justify-between items-start mb-6">
<div class="feature-grid-icon"><span class="material-symbols-outlined">swap_horiz</span></div>
<span class="badge bg-tertiary/10 text-tertiary border-tertiary/20">Desktop</span>
</div>
<h3 class="font-bold text-lg mb-2 text-on-surface">Transferts</h3>
<p class="text-sm text-on-surface-variant">Mouvements de stock inter-sites fluides et tracés.</p>
</div>
<div class="glass-card p-6 rounded-2xl group reveal">
<div class="feature-grid-icon mb-6"><span class="material-symbols-outlined">dashboard</span></div>
<h3 class="font-bold text-lg mb-2 text-on-surface">Dashboard</h3>
<p class="text-sm text-on-surface-variant">Analytics temps réel et KPIs personnalisés par rôle.</p>
</div>
<div class="glass-card p-6 rounded-2xl group reveal" style="transition-delay: 100ms;">
<div class="feature-grid-icon mb-6"><span class="material-symbols-outlined">description</span></div>
<h3 class="font-bold text-lg mb-2 text-on-surface">Rapports</h3>
<p class="text-sm text-on-surface-variant">Exports automatisés et audits d'inventaire intelligents.</p>
</div>
<div class="glass-card p-6 rounded-2xl group reveal" style="transition-delay: 200ms;">
<div class="feature-grid-icon mb-6"><span class="material-symbols-outlined">group</span></div>
<h3 class="font-bold text-lg mb-2 text-on-surface">Utilisateurs</h3>
<p class="text-sm text-on-surface-variant">Collaboration d'équipe centralisée avec chat intégré.</p>
</div>
<div class="glass-card p-6 rounded-2xl group reveal" style="transition-delay: 300ms;">
<div class="feature-grid-icon mb-6"><span class="material-symbols-outlined">admin_panel_settings</span></div>
<h3 class="font-bold text-lg mb-2 text-on-surface">Permissions</h3>
<p class="text-sm text-on-surface-variant">Rôles RBAC ultra-granulaires pour une sécurité maximale.</p>
</div>
<div class="glass-card p-6 rounded-2xl group reveal" style="transition-delay: 400ms;">
<div class="feature-grid-icon mb-6"><span class="material-symbols-outlined">corporate_fare</span></div>
<h3 class="font-bold text-lg mb-2 text-on-surface">Multi-sociétés</h3>
<p class="text-sm text-on-surface-variant">Gérez plusieurs entités juridiques sous un seul compte.</p>
</div>
</div>
</div>
</section>
<!-- App Showcase Section -->
<section class="py-stack-xl bg-surface-container-low/30 overflow-hidden relative z-10">
<div class="max-w-container-max mx-auto px-gutter reveal">
<div class="text-center mb-16">
<h2 class="font-headline-lg text-headline-lg mb-6 text-on-surface">L'interface la plus intuitive du marché</h2>
<p class="text-on-surface-variant font-body-lg">Pensée pour le web et optimisée pour le terrain.</p>
</div>
<div class="relative">
<!-- Main Mockup -->
<div class="rounded-3xl border border-outline-variant/30 shadow-2xl overflow-hidden glass-card p-2">
<img alt="Dashboard Quantix" class="w-full h-auto rounded-2xl" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDHXldasqN6leGl8q6LTCcIl3PlRUvx2FEu1-kjB5JIXDWJxGPQWS0r7RXlkcDgM0EZJrrplGKlxWxBtXPKlR5kUzXdJVB-sbGefsrXa5v7_dBdpVsLvDpVb3ZnZI25nYBs-Tw1FsWswGkWAvZxlXH4lZWkSM0EA5DY51z0Now1L0njeXmm1JmiVD6aJMzAZDSDOxc41OmTkZX8bOZDyLZord0g4INwy5j-f-sHYOkgbowdqqL1JYSpxo0qKbaKt26xXiAnB0EYFr0"/>
</div>
<!-- Floating Mobile Mockup -->
<div class="absolute -bottom-12 -right-12 w-64 md:w-80 hidden md:block rounded-[2.5rem] border-8 border-surface-container-highest shadow-2xl overflow-hidden translate-y-6 hover:translate-y-0 transition-transform duration-700 bg-surface">
<img alt="Quantix Mobile App" class="w-full h-auto" src="https://lh3.googleusercontent.com/aida-public/AB6AXuClwV-iciRZBwGLTbtDHp1Jb9H0TWUZczhtwHGrAas42VBtQO-Iz94rR4NeG0225Cevr12Ce5nMufWHsPr8XHoIShyb1V7dbylg2rQAltrxXoxMw72HdwHp5RUucVIoVvjLOr7O_3H1KMjXIJbpxbqeOz4D3n0pyYWHscZ19dVFlMZIN_k9In47Lv_6nTY6Z9qlVTE79LuCMNtag4HG8X4vnOM1tZB-xb2uTd33IJwXFJiZ_-CUjjrIAu09vxLFm61pwzTtW5_7yKs"/>
</div>
</div>
</div>
</section>
<!-- Timeline Section: How it Works -->
<section class="py-stack-xl relative z-10">
<div class="max-w-container-max mx-auto px-gutter">
<h2 class="font-headline-lg text-headline-lg text-center mb-20 reveal text-on-surface">Lancez-vous en 4 étapes</h2>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 relative">
<div class="absolute top-[32px] left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-outline-variant/30 to-transparent hidden lg:block"></div>
<div class="relative z-10 flex flex-col items-center text-center reveal">
<div class="w-16 h-16 rounded-full bg-surface-container border-2 border-primary flex items-center justify-center font-headline-md text-primary mb-8 shadow-lg shadow-primary/20">1</div>
<h4 class="font-bold text-xl mb-3 text-on-surface">Compte</h4>
<p class="text-on-surface-variant">Créez votre profil administrateur et configurez votre identité sécurisée.</p>
</div>
<div class="relative z-10 flex flex-col items-center text-center reveal" style="transition-delay: 100ms;">
<div class="w-16 h-16 rounded-full bg-surface-container border-2 border-primary flex items-center justify-center font-headline-md text-primary mb-8 shadow-lg shadow-primary/20">2</div>
<h4 class="font-bold text-xl mb-3 text-on-surface">Entreprise</h4>
<p class="text-on-surface-variant">Définissez la structure de votre société et invitez vos collaborateurs.</p>
</div>
<div class="relative z-10 flex flex-col items-center text-center reveal" style="transition-delay: 200ms;">
<div class="w-16 h-16 rounded-full bg-surface-container border-2 border-primary flex items-center justify-center font-headline-md text-primary mb-8 shadow-lg shadow-primary/20">3</div>
<h4 class="font-bold text-xl mb-3 text-on-surface">Entrepôts</h4>
<p class="text-on-surface-variant">Cartographiez vos zones de stockage physiques pour une précision totale.</p>
</div>
<div class="relative z-10 flex flex-col items-center text-center reveal" style="transition-delay: 300ms;">
<div class="w-16 h-16 rounded-full bg-surface-container border-2 border-primary flex items-center justify-center font-headline-md text-primary mb-8 shadow-lg shadow-primary/20">4</div>
<h4 class="font-bold text-xl mb-3 text-on-surface">Gestion</h4>
<p class="text-on-surface-variant">Commencez à piloter vos stocks et générez vos premiers rapports.</p>
</div>
</div>
</div>
</section>
<!-- Pricing Section -->
<section class="py-stack-xl bg-surface-container-lowest/50 relative z-10" id="pricing">
<div class="max-w-container-max mx-auto px-gutter">
<div class="text-center mb-20 reveal">
<h2 class="font-headline-lg text-headline-lg mb-6 text-on-surface">Un tarif pour chaque échelle</h2>
<p class="font-body-lg text-body-lg text-on-surface-variant">Faites évoluer votre logistique sans friction.</p>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
<!-- Free -->
<div class="glass-card p-10 rounded-3xl flex flex-col reveal">
<div class="font-label-sm text-on-surface-variant uppercase mb-4 tracking-widest">Essentiel</div>
<div class="flex items-baseline gap-1 mb-8">
<span class="font-headline-lg text-headline-lg text-on-surface">0$</span>
<span class="text-on-surface-variant">/mois</span>
</div>
<ul class="space-y-4 mb-12 flex-grow text-sm text-on-surface-variant">
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> 1 Entrepôt</li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> 100 Produits</li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> 2 Utilisateurs</li>
</ul>
<button class="w-full py-4 rounded-xl border border-outline-variant/30 hover:bg-surface-container-highest transition-all font-bold text-on-surface">Commencer gratuit</button>
</div>
<!-- Pro -->
<div class="glass-card p-10 rounded-3xl pricing-card popular flex flex-col relative overflow-hidden reveal" style="transition-delay: 100ms;">
<div class="absolute top-0 right-0 bg-primary text-on-primary px-4 py-1.5 text-[10px] font-bold rounded-bl-lg tracking-widest">POPULAIRE</div>
<div class="font-label-sm text-primary uppercase mb-4 font-bold tracking-widest">Professionnel</div>
<div class="flex items-baseline gap-1 mb-8">
<span class="font-headline-lg text-headline-lg text-on-surface">49$</span>
<span class="text-on-surface-variant">/mois</span>
</div>
<ul class="space-y-4 mb-12 flex-grow text-sm text-on-surface-variant">
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> Entrepôts illimités</li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> Produits illimités</li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> IA de stock bas</li>
</ul>
<button class="w-full py-4 rounded-xl bg-primary text-on-primary font-bold shadow-lg shadow-primary/20 hover:brightness-110 active:scale-95 transition-all">Démarrer Pro</button>
</div>
<!-- Business -->
<div class="glass-card p-10 rounded-3xl flex flex-col reveal" style="transition-delay: 200ms;">
<div class="font-label-sm text-on-surface-variant uppercase mb-4 tracking-widest">Entreprise</div>
<div class="flex items-baseline gap-1 mb-8">
<span class="text-2xl font-bold text-on-surface">Sur devis</span>
</div>
<ul class="space-y-4 mb-12 flex-grow text-sm text-on-surface-variant">
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> Multi-filiales</li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> API personnalisée</li>
<li class="flex items-center gap-3"><span class="material-symbols-outlined text-primary text-xl">check_circle</span> SLA garanti 99.99%</li>
</ul>
<button class="w-full py-4 rounded-xl border border-outline-variant/30 hover:bg-surface-container-highest transition-all font-bold text-on-surface">Contacter Sales</button>
</div>
</div>
</div>
</section>
<!-- Footer -->
<footer class="py-20 bg-surface-container-lowest border-t border-outline-variant/30 relative z-10">
<div class="max-w-container-max mx-auto px-gutter grid grid-cols-1 md:grid-cols-4 gap-12">
<div class="col-span-1 md:col-span-2">
<a class="flex items-center gap-2 mb-6" href="#">
<img alt="Quantix Logo" class="h-8 w-auto" src="https://lh3.googleusercontent.com/aida-public/AB6AXuByTgnshUXeLHiMfcs13K9-C_L_UZfZ0Qr28GMef71095Nmuoynkk5hioUIiR_P3MUGLumoFWVzFYpxYIt2Wk86aThwY5W9dWf61jqM-PX5KAE15C86AinWhFNd6B90dpzNeb8HptBJsC6kEcCDJ61eJnO--pwp-zgcwdhTdQKHbcAg9LdAwvUEhYNRCFzx7vqjD5llJvUiD7A2WuBsIVkyU6IHnZBYZm_cz3jamhq02R_rdZNX9ja4LkY9Vtfhp7_CV56Pkpco9tY"/>
<span class="font-headline-md text-2xl font-bold text-on-surface">Quantix</span>
</a>
<p class="text-on-surface-variant max-w-sm mb-8">La plateforme de gestion de stock intelligente pour les entreprises tournées vers l'avenir. Optimisez, suivez, évoluez.</p>
<div class="flex gap-4">
<a class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors" href="#"><span class="material-symbols-outlined">share</span></a>
<a class="w-10 h-10 rounded-full glass-card flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors" href="#"><span class="material-symbols-outlined">public</span></a>
</div>
</div>
<div>
<h5 class="font-bold mb-6 text-on-surface">Produit</h5>
<ul class="space-y-4 text-on-surface-variant">
<li><a class="hover:text-primary transition-colors" href="#">Fonctionnalités</a></li>
<li><a class="hover:text-primary transition-colors" href="#">Intégrations</a></li>
<li><a class="hover:text-primary transition-colors" href="#">API</a></li>
</ul>
</div>
<div>
<h5 class="font-bold mb-6 text-on-surface">Société</h5>
<ul class="space-y-4 text-on-surface-variant">
<li><a class="hover:text-primary transition-colors" href="#">À propos</a></li>
<li><a class="hover:text-primary transition-colors" href="#">Blog</a></li>
<li><a class="hover:text-primary transition-colors" href="#">Contact</a></li>
</ul>
</div>
</div>
<div class="max-w-container-max mx-auto px-gutter mt-20 pt-8 border-t border-outline-variant/10 text-center text-on-surface-variant text-sm">
        © 2024 Quantix SaaS. Tous droits réservés.
    </div>
</footer>
<script>
    // Theme Toggle Logic
    const themeToggle = document.getElementById('theme-toggle');
    const htmlElement = document.documentElement;
    
    themeToggle.addEventListener('click', () => {
        htmlElement.classList.toggle('dark');
        localStorage.setItem('theme', htmlElement.classList.contains('dark') ? 'dark' : 'light');
    });

    // Mobile Menu Logic
    const menuBtn = document.getElementById('menu-btn');
    const closeMenu = document.getElementById('close-menu');
    const mobileMenu = document.getElementById('mobile-menu');

    menuBtn.addEventListener('click', () => mobileMenu.classList.add('active'));
    closeMenu.addEventListener('click', () => mobileMenu.classList.remove('active'));

    // Reveal on Scroll Logic
    const observerOptions = {
        threshold: 0.1
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
                if (entry.target.classList.contains('counter')) {
                    startCounter(entry.target);
                }
            }
        });
    }, observerOptions);

    document.querySelectorAll('.reveal').forEach(el => observer.observe(el));
    document.querySelectorAll('.counter').forEach(el => observer.observe(el));

    function startCounter(el) {
        const target = parseInt(el.getAttribute('data-target'));
        const duration = 2000;
        const start = 0;
        const startTime = performance.now();

        function update(currentTime) {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const current = Math.floor(progress * (target - start) + start);
            el.innerText = '+' + current.toLocaleString();
            if (progress < 1) {
                requestAnimationFrame(update);
            }
        }
        requestAnimationFrame(update);
    }

    // --- Shader Background (ANIMATION_116) ---
    const canvas = document.getElementById('canvas-bg');
    const gl = canvas.getContext('webgl');

    const vertexShaderSource = `
        attribute vec2 a_position;
        varying vec2 v_texCoord;
        void main() {
            v_texCoord = a_position * 0.5 + 0.5;
            gl_Position = vec4(a_position, 0.0, 1.0);
        }
    `;

    const fragmentShaderSource = `
        precision highp float;
        uniform float u_time;
        uniform vec2 u_resolution;
        varying vec2 v_texCoord;

        void main() {
            vec2 uv = v_texCoord;
            float t = u_time * 0.2;
            
            float noise = sin(uv.x * 3.0 + t) * cos(uv.y * 3.0 - t) * 0.1;
            
            vec3 color1 = vec3(0.003, 0.047, 0.09); // #010f1f
            vec3 color2 = vec3(0.06, 0.72, 0.51);   // #10b981
            
            vec3 finalColor = mix(color1, color2 * 0.2, uv.y + noise);
            
            vec2 glowPos = vec2(0.5 + sin(t*0.5)*0.2, 0.5 + cos(t*0.3)*0.2);
            float glow = (1.0 - distance(uv, glowPos)) * 0.4;
            finalColor += color2 * glow * 0.3;
            
            gl_FragColor = vec4(finalColor, 1.0);
        }
    `;

    function createShader(gl, type, source) {
        const shader = gl.createShader(type);
        gl.shaderSource(shader, source);
        gl.compileShader(shader);
        return shader;
    }

    const program = gl.createProgram();
    gl.attachShader(program, createShader(gl, gl.VERTEX_SHADER, vertexShaderSource));
    gl.attachShader(program, createShader(gl, gl.FRAGMENT_SHADER, fragmentShaderSource));
    gl.linkProgram(program);
    gl.useProgram(program);

    const positionBuffer = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, positionBuffer);
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1, -1, 1, -1, -1, 1, 1, 1]), gl.STATIC_DRAW);

    const positionLocation = gl.getAttribLocation(program, "a_position");
    gl.enableVertexAttribArray(positionLocation);
    gl.vertexAttribPointer(positionLocation, 2, gl.FLOAT, false, 0, 0);

    const timeLocation = gl.getUniformLocation(program, "u_time");
    const resLocation = gl.getUniformLocation(program, "u_resolution");

    function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        gl.viewport(0, 0, canvas.width, canvas.height);
    }
    window.addEventListener('resize', resizeCanvas);
    resizeCanvas();

    function renderShader(time) {
        gl.uniform1f(timeLocation, time * 0.001);
        gl.uniform2f(resLocation, canvas.width, canvas.height);
        gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4);
        requestAnimationFrame(renderShader);
    }
    requestAnimationFrame(renderShader);

    // --- Hero 3D (ANIMATION_115) ---
    const container = document.getElementById('threejs-container');
    const width = container.clientWidth || window.innerWidth;
    const height = container.clientHeight || window.innerHeight;

    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });

    renderer.setSize(width, height);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    container.appendChild(renderer.domElement);

    const group = new THREE.Group();
    scene.add(group);

    const geometry = new THREE.BoxGeometry(1, 1, 1);
    const material = new THREE.MeshPhongMaterial({ 
        color: 0x10b981, 
        shininess: 100,
        transparent: true,
        opacity: 0.7,
        emissive: 0x065f46,
        emissiveIntensity: 0.2
    });

    const isMobile = window.innerWidth < 768;
    const count = isMobile ? 15 : 30;

    for(let i = 0; i < count; i++) {
        const mesh = new THREE.Mesh(geometry, material);
        mesh.position.set(
            (Math.random() - 0.5) * (isMobile ? 6 : 10),
            (Math.random() - 0.5) * (isMobile ? 8 : 10),
            (Math.random() - 0.5) * 5
        );
        mesh.rotation.set(Math.random() * Math.PI, Math.random() * Math.PI, 0);
        mesh.scale.setScalar(Math.random() * 0.5 + 0.2);
        group.add(mesh);
    }

    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
    scene.add(ambientLight);

    const pointLight = new THREE.PointLight(0x4edea3, 1.5);
    pointLight.position.set(5, 5, 5);
    scene.add(pointLight);

    camera.position.z = isMobile ? 8 : 7;

    function animateThree() {
        requestAnimationFrame(animateThree);
        group.rotation.y += 0.001;
        group.rotation.x += 0.0005;
        
        group.children.forEach((child, i) => {
            child.position.y += Math.sin(Date.now() * 0.001 + i) * 0.002;
            child.rotation.z += 0.005;
        });
        
        renderer.render(scene, camera);
    }

    window.addEventListener('resize', () => {
        const w = container.clientWidth || window.innerWidth;
        const h = container.clientHeight || window.innerHeight;
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
        renderer.setSize(w, h);
    });

    animateThree();
</script>
</body></html>