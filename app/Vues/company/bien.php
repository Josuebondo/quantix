<!DOCTYPE html>

<html class="dark" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Quatinx - Bienvenue à bord</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;600;700;800&amp;family=Inter:wght@400;600;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary": "#00e676", // Override per user request for Emerald Green
                        "on-tertiary-fixed": "#07006c",
                        "secondary-fixed-dim": "#bec6e0",
                        "background": "#0b0f10", // Deeper midnight
                        "secondary": "#bec6e0",
                        "on-secondary": "#283044",
                        "surface-bright": "#363a3b",
                        "tertiary-fixed-dim": "#c0c1ff",
                        "surface-container": "#1d2022",
                        "primary-container": "#00e676",
                        "inverse-surface": "#e0e3e5",
                        "inverse-on-surface": "#2d3133",
                        "on-error-container": "#ffdad6",
                        "inverse-primary": "#00c853",
                        "outline": "#494454",
                        "on-secondary-container": "#adb4ce",
                        "primary-fixed": "#e9ddff",
                        "surface-variant": "#1a1e20",
                        "on-primary": "#00391c",
                        "on-surface": "#e0e3e5",
                        "error-container": "#93000a",
                        "secondary-fixed": "#dae2fd",
                        "on-background": "#e0e3e5",
                        "on-tertiary-container": "#0d0096",
                        "surface-dim": "#0b0f10",
                        "on-primary-fixed-variant": "#00522a",
                        "tertiary-fixed": "#e1e0ff",
                        "surface-container-highest": "#323537",
                        "error": "#ffb4ab",
                        "secondary-container": "#3f465c",
                        "on-secondary-fixed-variant": "#3f465c",
                        "on-primary-container": "#00391c",
                        "on-error": "#690005",
                        "on-surface-variant": "#cbc3d7",
                        "surface-container-low": "#111416",
                        "surface": "#0b0f10",
                        "surface-tint": "#00e676",
                        "surface-container-high": "#1e2224",
                        "on-primary-fixed": "#00210e",
                        "primary-fixed-dim": "#00e676",
                        "tertiary-container": "#8083ff",
                        "on-secondary-fixed": "#131b2e",
                        "tertiary": "#c0c1ff",
                        "surface-container-lowest": "#060809",
                        "on-tertiary-fixed-variant": "#2f2ebe",
                        "on-tertiary": "#1000a9",
                        "outline-variant": "#2d3133"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "gutter": "24px",
                        "container-max-width": "1280px",
                        "base": "8px",
                        "margin-desktop": "40px",
                        "margin-mobile": "16px"
                    },
                    "fontFamily": {
                        "display-lg": ["Hanken Grotesk"],
                        "headline-md": ["Hanken Grotesk"],
                        "body-md": ["Inter"],
                        "label-sm": ["Inter"],
                        "body-lg": ["Inter"]
                    },
                    "fontSize": {
                        "display-lg": ["48px", {
                            "lineHeight": "56px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "800"
                        }],
                        "headline-md": ["24px", {
                            "lineHeight": "32px",
                            "fontWeight": "600"
                        }],
                        "body-md": ["16px", {
                            "lineHeight": "24px",
                            "fontWeight": "400"
                        }],
                        "label-sm": ["13px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.05em",
                            "fontWeight": "600"
                        }],
                        "body-lg": ["18px", {
                            "lineHeight": "28px",
                            "fontWeight": "400"
                        }]
                    }
                },
            },
        }
    </script>
    <style>
        body {
            background-color: #0b0f10;
            color: #e0e3e5;
            -webkit-font-smoothing: antialiased;
        }

        .glass-card {
            background: rgba(29, 32, 34, 0.4);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .emerald-glow {
            box-shadow: 0 0 20px rgba(0, 230, 118, 0.15);
        }

        .step-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .step-transition:hover {
            transform: translateX(8px);
            border-color: rgba(0, 230, 118, 0.3);
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }

        .fill-icon {
            font-variation-settings: 'FILL' 1;
        }
    </style>
</head>

<body class="font-body-md overflow-x-hidden">
    <!-- Atmospheric Background Elements -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-primary/10 rounded-full blur-[120px]"></div>
        <div class="absolute top-[60%] -right-[5%] w-[30%] h-[30%] bg-primary/5 rounded-full blur-[100px]"></div>
    </div>
    <!-- Top Navigation Anchor -->
    <header class="w-full h-20 flex justify-center items-center px-margin-desktop sticky top-0 z-50">
        <div class="w-full max-w-container-max-width flex justify-between items-center">
            <div class="flex items-center gap-3">
                <img alt="Quatinx Logo" class="h-10 w-auto" data-alt="A sleek, professional company logo for Quatinx featuring an abstract geometric 'Q' mark combined with three-dimensional box icons. The color scheme is a premium gradient of deep sapphire blue and vibrant azure. The logo conveys high-speed logistics and sophisticated inventory management through clean lines and a modern, corporate aesthetic against a white background." src="https://lh3.googleusercontent.com/aida-public/AB6AXuD41d90lUx5aT7azQyB5sAKmQ0o-EiFdmQm2IP3Chc7yhlSV5KkWrw4vCWFqQJhK5-d3ygdc8xBVCc271Y_zIY68EQQoJhM4owN4ff7LFiyqt-X3HQBggTvv4npb-Za6YEPqBr4_rlZ4ey12H5UvGPQlBjqi4ReVEkQ_p8SQQ3c21OroMEWMyU_wEA0nYsca7HBfrSnNihk08wtDnrtQmvuzwoqBcCRde0laE9LbKq1sFpA33S7qBaU3sVqVC0sXpMdZOe84tpzh9w" />
                <span class="font-headline-md text-headline-md text-on-surface tracking-tight">Quatinx</span>
            </div>
            <div class="flex items-center gap-4">
                <button class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-colors">help</button>
                <button class="material-symbols-outlined text-on-surface-variant hover:text-primary transition-colors">settings</button>
            </div>
        </div>
    </header>
    <main class="min-h-screen flex flex-col items-center justify-center px-4 py-12 relative">
        <div class="max-w-[720px] w-full text-center space-y-12">
            <!-- Hero Section -->
            <section class="space-y-6 animate-in fade-in slide-in-from-bottom-4 duration-1000">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-surface-container-high border border-outline-variant text-primary font-label-sm uppercase tracking-widest mb-4">
                    <span class="w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    Système Prêt
                </div>
                <h1 class="font-display-lg text-display-lg text-on-surface leading-none">Bienvenue à bord !</h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant max-w-[540px] mx-auto">
                    Commençons par configurer votre espace de travail <span class="text-on-surface font-semibold">Quatinx</span> pour l'adapter à vos besoins opérationnels spécifiques.
                </p>
            </section>
            <!-- Configuration Steps -->
            <div class="space-y-4 text-left">
                <!-- Step 1 -->
                <div class="glass-card p-6 rounded-xl flex items-center justify-between step-transition group cursor-pointer">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-xl bg-surface-container-highest flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                            <span class="material-symbols-outlined text-2xl fill-icon">work</span>
                        </div>
                        <div>
                            <h3 class="font-headline-md text-body-lg text-on-surface">Workspace</h3>
                            <p class="text-label-sm text-on-surface-variant">Devise, langue et paramètres régionaux.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-label-sm text-on-surface-variant bg-surface-container px-3 py-1 rounded-full border border-outline-variant group-hover:border-primary/50 transition-colors">Prêt à configurer</span>
                        <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary">chevron_right</span>
                    </div>
                </div>
                <!-- Step 2 -->
                <div class="glass-card p-6 rounded-xl flex items-center justify-between step-transition group cursor-pointer">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-xl bg-surface-container-highest flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                            <span class="material-symbols-outlined text-2xl fill-icon">language</span>
                        </div>
                        <div>
                            <h3 class="font-headline-md text-body-lg text-on-surface">Sites</h3>
                            <p class="text-label-sm text-on-surface-variant">Créez votre premier Entrepôt ou Point de Vente.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-label-sm text-on-surface-variant bg-surface-container px-3 py-1 rounded-full border border-outline-variant group-hover:border-primary/50 transition-colors">Prêt à configurer</span>
                        <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary">chevron_right</span>
                    </div>
                </div>
                <!-- Step 3 -->
                <div class="glass-card p-6 rounded-xl flex items-center justify-between step-transition group cursor-pointer">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-xl bg-surface-container-highest flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                            <span class="material-symbols-outlined text-2xl fill-icon">category</span>
                        </div>
                        <div>
                            <h3 class="font-headline-md text-body-lg text-on-surface">Structure d'Inventaire</h3>
                            <p class="text-label-sm text-on-surface-variant">Catégories et produits initiaux.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-label-sm text-on-surface-variant bg-surface-container px-3 py-1 rounded-full border border-outline-variant group-hover:border-primary/50 transition-colors">Prêt à configurer</span>
                        <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary">chevron_right</span>
                    </div>
                </div>
                <!-- Step 4 -->
                <div class="glass-card p-6 rounded-xl flex items-center justify-between step-transition group cursor-pointer">
                    <div class="flex items-center gap-5">
                        <div class="w-12 h-12 rounded-xl bg-surface-container-highest flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-on-primary transition-colors">
                            <span class="material-symbols-outlined text-2xl fill-icon">group</span>
                        </div>
                        <div>
                            <h3 class="font-headline-md text-body-lg text-on-surface">Équipe</h3>
                            <p class="text-label-sm text-on-surface-variant">Rôles et invitations collaborateurs.</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-label-sm text-on-surface-variant bg-surface-container px-3 py-1 rounded-full border border-outline-variant group-hover:border-primary/50 transition-colors">Prêt à configurer</span>
                        <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary">chevron_right</span>
                    </div>
                </div>
            </div>
            <!-- CTA Section -->
            <div class="pt-8 space-y-6">
                <button class="w-full py-5 px-8 rounded-xl bg-primary text-on-primary font-bold text-body-lg emerald-glow hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                    Commencer la configuration
                    <span class="material-symbols-outlined font-bold">arrow_forward</span>
                </button>
                <div class="flex items-center justify-center gap-2 text-on-surface-variant">
                    <span class="material-symbols-outlined text-lg">schedule</span>
                    <span class="font-label-sm">Installation estimée : 4 minutes</span>
                </div>
            </div>
        </div>
    </main>
    <!-- Visual Footer Accent -->
    <footer class="w-full py-8 border-t border-outline-variant/30 mt-auto">
        <div class="max-w-container-max-width mx-auto px-margin-desktop flex flex-col md:flex-row justify-between items-center gap-4 text-on-surface-variant font-label-sm">
            <p>© 2024 Quatinx Enterprise. Tous droits réservés.</p>
            <div class="flex gap-8">
                <a class="hover:text-primary transition-colors" href="#">Confidentialité</a>
                <a class="hover:text-primary transition-colors" href="#">Support Technique</a>
                <a class="hover:text-primary transition-colors" href="#">Documentation</a>
            </div>
        </div>
    </footer>
    <!-- Inline Interaction Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.step-transition');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.6s cubic-bezier(0.2, 0.8, 0.2, 1)';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, 200 + (index * 150));
            });
        });
    </script>
</body>

</html>