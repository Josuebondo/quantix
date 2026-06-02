<!DOCTYPE html>

<html class="dark" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Quatinx Onboarding | Global Inventory Management</title>
    <link rel="stylesheet" href="/css/tailwind.css">
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: 'Hanken Grotesk', sans-serif;
            background-color: #051424;
            color: #d4e4fa;
        }

        .glass-card {
            background: rgba(18, 33, 49, 0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .step-active {
            color: #adc7ff;
            background: rgba(74, 142, 255, 0.1);
            border-left: 3px solid #adc7ff;
        }

        .step-completed {
            color: #00e676;
        }

        .transition-content {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-glow:focus {
            box-shadow: 0 0 0 3px rgba(173, 199, 255, 0.15);
        }

        .hide {
            display: none;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-slide-in {
            animation: slideIn 0.5s ease-out forwards;
        }
    </style>
</head>

<body class="flex flex-col md:flex-row h-screen overflow-hidden bg-background">
    <!-- Sidebar Stepper -->
    <aside class="w-full md:w-80 bg-surface-container-lowest border-r border-outline-variant flex flex-col z-40 sticky top-0 h-full">
        <div class="p-8 flex flex-col gap-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center border border-primary/20">
                    <span class="material-symbols-outlined text-primary text-2xl">inventory_2</span>
                </div>
                <div>
                    <h1 class="font-headline-md text-xl font-bold text-primary leading-tight">Quatinx</h1>
                    <p class="text-[10px] font-label-sm text-on-surface-variant tracking-[0.2em] uppercase opacity-70">Enterprise Cloud</p>
                </div>
            </div>
        </div>
        <nav class="flex-1 px-4 py-2 space-y-2 overflow-y-auto no-scrollbar">
            <!-- Steps generated via JS -->
            <div class="space-y-1" id="sidebar-nav-container">
                <!-- Step Templates -->
            </div>
        </nav>
        <div class="p-6 border-t border-outline-variant/30">
            <div class="flex items-center gap-3 text-on-surface-variant opacity-60 transition-all duration-300" id="autosave-indicator">
                <span class="material-symbols-outlined text-sm" id="sync-icon">cloud_done</span>
                <span class="text-xs font-medium uppercase tracking-widest" id="sync-text">Système prêt</span>
            </div>
        </div>
    </aside>
    <!-- Main Content -->
    <main class="flex-1 flex flex-col relative overflow-hidden bg-surface-dim">
        <div class="absolute top-0 w-full h-32 bg-gradient-to-b from-background/80 to-transparent z-10 pointer-events-none"></div>
        <div class="flex-1 overflow-y-auto px-6 md:px-12 py-24 z-0 no-scrollbar" id="content-container">
            <div class="max-w-4xl mx-auto">
                <!-- Step 1: Workspace -->
                <section class="transition-content" id="step-1">
                    <div class="space-y-8 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 01</span>
                            <h2 class="font-headline-lg text-4xl text-on-surface">Configuration du Workspace</h2>
                            <p class="font-body-lg text-on-surface-variant/80">Définissez l'identité globale et les paramètres régionaux de votre organisation.</p>
                        </header>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 glass-card p-10 rounded-2xl">
                            <div class="md:col-span-2 space-y-3">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Nom de l'organisation</label>
                                <input class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary focus:bg-surface-container outline-none input-glow transition-all" data-state="workspaceName" placeholder="ex: Quatinx Global Ltd" type="text" />
                            </div>
                            <div class="space-y-3">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Devise par défaut</label>
                                <select class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none appearance-none cursor-pointer" data-state="currency">
                                    <option value="EUR">Euro (€)</option>
                                    <option value="USD">US Dollar ($)</option>
                                    <option value="GBP">British Pound (£)</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Langue du système</label>
                                <select class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none appearance-none cursor-pointer" data-state="language">
                                    <option value="fr">Français</option>
                                    <option value="en">English</option>
                                    <option value="de">Deutsch</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Step 2: Sites -->
                <section class="transition-content hide" id="step-2">
                    <div class="space-y-8 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 02</span>
                            <h2 class="font-headline-lg text-4xl text-on-surface">Initialisation des Sites</h2>
                            <p class="font-body-lg text-on-surface-variant/80">Configurez vos points logistiques et de distribution.</p>
                        </header>
                        <div class="glass-card p-10 rounded-2xl space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Nom du site</label>
                                    <input class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none input-glow" data-state="siteName" placeholder="ex: Hub Logistique Paris" type="text" />
                                </div>
                                <div class="space-y-3">
                                    <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Type de site</label>
                                    <select class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none appearance-none" data-state="siteType">
                                        <option value="depot">Dépôt (Stockage)</option>
                                        <option value="point_de_vente">Point de vente (Retail)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Adresse physique</label>
                                <textarea class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none input-glow" data-state="siteAddress" placeholder="123 Rue de l'Innovation, 75001 Paris" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Step 3: Catégories -->
                <section class="transition-content hide" id="step-3">
                    <div class="space-y-8 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 03</span>
                            <h2 class="font-headline-lg text-4xl text-on-surface">Segmentation de l'Inventaire</h2>
                            <p class="font-body-lg text-on-surface-variant/80">Organisez vos produits par familles logiques pour une meilleure analyse.</p>
                        </header>
                        <div class="glass-card p-10 rounded-2xl space-y-10">
                            <div class="space-y-4">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Ajouter une catégorie</label>
                                <div class="flex gap-3">
                                    <input class="flex-1 bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none" id="cat-input" placeholder="ex: Hardware, Logiciels..." type="text" />
                                    <button class="bg-primary text-on-primary-container font-bold px-8 py-4 rounded-xl hover:brightness-110 active:scale-95 transition-all" onclick="addCategoryFromInput()">Ajouter</button>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Vos catégories</label>
                                <div class="flex flex-wrap gap-3 min-h-[50px] p-6 bg-surface-container-lowest/30 rounded-2xl border border-dashed border-outline-variant/30" id="category-list">
                                    <!-- Tags will appear here -->
                                </div>
                            </div>
                            <div class="space-y-4">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Suggestions sectorielles</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <button class="text-left px-5 py-4 rounded-xl bg-surface-container/30 border border-outline-variant/30 hover:border-primary/50 transition-all text-sm group" onclick="addCategory('Électronique: Composants')">
                                        <span class="text-on-surface-variant group-hover:text-primary">Électronique: Composants</span>
                                    </button>
                                    <button class="text-left px-5 py-4 rounded-xl bg-surface-container/30 border border-outline-variant/30 hover:border-primary/50 transition-all text-sm group" onclick="addCategory('Électronique: Accessoires')">
                                        <span class="text-on-surface-variant group-hover:text-primary">Électronique: Accessoires</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Step 4: Produits -->
                <section class="transition-content hide" id="step-4">
                    <div class="space-y-8 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 04</span>
                            <h2 class="font-headline-lg text-4xl text-on-surface">Référencement Produit</h2>
                            <p class="font-body-lg text-on-surface-variant/80">Commencez par enregistrer votre premier article pilote.</p>
                        </header>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 glass-card p-10 rounded-2xl">
                            <div class="md:col-span-2 space-y-3">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Nom du produit</label>
                                <input class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none" data-state="productName" id="prod-name" placeholder="ex: Workstation Z-8000" type="text" />
                            </div>
                            <div class="space-y-3">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">SKU Unique</label>
                                <div class="relative flex items-center">
                                    <input class="w-full bg-surface-container-low border border-outline-variant/50 rounded-xl p-4 text-primary font-mono text-sm outline-none" data-state="productSku" id="prod-sku" placeholder="SKU-AUTO-GEN" readonly="" type="text" />
                                    <button class="absolute right-2 px-3 py-2 bg-primary/10 text-primary rounded-lg text-xs font-bold hover:bg-primary/20 transition-all flex items-center gap-1" onclick="generateSKU()">
                                        <span class="material-symbols-outlined text-[14px]">auto_awesome</span> Générer
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Catégorie</label>
                                <select class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none appearance-none" data-state="productCategory" id="prod-category">
                                    <option value="">Choisir...</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Prix Unitaire</label>
                                <div class="relative">
                                    <input class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none" data-state="productPrice" placeholder="0.00" type="number" />
                                    <span class="absolute right-4 top-4 text-on-surface-variant opacity-50">€</span>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Stock Initial</label>
                                <input class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none" data-state="productStock" type="number" value="0" />
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Step 5: Rôles -->
                <section class="transition-content hide" id="step-5">
                    <div class="space-y-8 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 05</span>
                            <h2 class="font-headline-lg text-4xl text-on-surface">Structure de l'Équipe</h2>
                            <p class="font-body-lg text-on-surface-variant/80">Définissez les hiérarchies de responsabilité pour vos futurs utilisateurs.</p>
                        </header>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="role-card glass-card p-8 rounded-2xl border-2 border-transparent cursor-pointer flex flex-col items-center text-center space-y-4 hover:scale-[1.02] transition-all" id="role-admin" onclick="selectRole('Admin')">
                                <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-4xl" style="font-variation-settings: 'FILL' 1;">admin_panel_settings</span>
                                </div>
                                <h3 class="font-headline-md text-xl">Administrateur</h3>
                                <p class="text-xs font-body-md text-on-surface-variant leading-relaxed">Contrôle total sur l'ensemble du système et des paramètres financiers.</p>
                            </div>
                            <div class="role-card glass-card p-8 rounded-2xl border-2 border-transparent cursor-pointer flex flex-col items-center text-center space-y-4 hover:scale-[1.02] transition-all" id="role-manager" onclick="selectRole('Manager')">
                                <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined text-4xl">manage_accounts</span>
                                </div>
                                <h3 class="font-headline-md text-xl">Manager</h3>
                                <p class="text-xs font-body-md text-on-surface-variant leading-relaxed">Gestion opérationnelle des stocks, sites et accès basiques.</p>
                            </div>
                            <div class="role-card glass-card p-8 rounded-2xl border-2 border-transparent cursor-pointer flex flex-col items-center text-center space-y-4 hover:scale-[1.02] transition-all" id="role-employee" onclick="selectRole('Employee')">
                                <div class="w-16 h-16 bg-tertiary/10 rounded-full flex items-center justify-center text-tertiary">
                                    <span class="material-symbols-outlined text-4xl">person</span>
                                </div>
                                <h3 class="font-headline-md text-xl">Opérateur</h3>
                                <p class="text-xs font-body-md text-on-surface-variant leading-relaxed">Saisie des mouvements de stock et consultation simple.</p>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Step 6: Permissions -->
                <section class="transition-content hide" id="step-6">
                    <div class="space-y-8 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 06</span>
                            <h2 class="font-headline-lg text-4xl text-on-surface">Matrice de Sécurité</h2>
                            <p class="font-body-lg text-on-surface-variant/80">Configurez finement les accès pour le rôle <span class="text-primary font-bold" id="current-role-display">...</span></p>
                        </header>
                        <div class="hide flex flex-col items-center justify-center p-20 space-y-4" id="permissions-loader">
                            <div class="w-12 h-12 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
                            <span class="text-xs font-bold tracking-widest text-primary">CHARGEMENT DES DROITS...</span>
                        </div>
                        <div class="glass-card rounded-2xl overflow-hidden" id="permissions-table-container">
                            <table class="w-full text-left">
                                <thead class="bg-surface-container-high/50">
                                    <tr>
                                        <th class="p-5 font-label-sm text-on-surface-variant uppercase tracking-wider text-[10px] font-bold">Module</th>
                                        <th class="p-5 font-label-sm text-on-surface-variant uppercase tracking-wider text-[10px] font-bold text-center">Voir</th>
                                        <th class="p-5 font-label-sm text-on-surface-variant uppercase tracking-wider text-[10px] font-bold text-center">Ajouter</th>
                                        <th class="p-5 font-label-sm text-on-surface-variant uppercase tracking-wider text-[10px] font-bold text-center">Éditer</th>
                                        <th class="p-5 font-label-sm text-on-surface-variant uppercase tracking-wider text-[10px] font-bold text-center">Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-outline-variant/20" id="permissions-body">
                                    <!-- Generated via JS -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
                <!-- Step 7: Invitations -->
                <section class="transition-content hide" id="step-7">
                    <div class="space-y-8 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 07</span>
                            <h2 class="font-headline-lg text-4xl text-on-surface">Collaborateurs</h2>
                            <p class="font-body-lg text-on-surface-variant/80">Invitez votre équipe à rejoindre votre nouvel espace de travail.</p>
                        </header>
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 glass-card p-8 rounded-2xl items-end">
                                <div class="md:col-span-2 space-y-3">
                                    <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Email du collaborateur</label>
                                    <input class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface outline-none" id="invite-email" placeholder="nom@entreprise.com" type="email" />
                                </div>
                                <div class="md:col-span-2 space-y-3">
                                    <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Rôle assigné</label>
                                    <select class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none" id="invite-role">
                                        <option value="Manager">Manager</option>
                                        <option value="Employee">Opérateur</option>
                                        <option value="Admin">Administrateur</option>
                                    </select>
                                </div>
                                <button class="bg-primary text-on-primary-container h-[56px] font-bold rounded-xl hover:brightness-110 active:scale-95 transition-all flex items-center justify-center gap-2" onclick="addInvitation()">
                                    <span class="material-symbols-outlined">person_add</span>
                                </button>
                            </div>
                            <div class="space-y-3" id="invitation-list">
                                <!-- Invitations list -->
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Step 8: Finalisation -->
                <section class="transition-content hide" id="step-8">
                    <div class="flex flex-col items-center justify-center min-h-[500px] text-center space-y-12 animate-slide-in">
                        <div class="relative" id="final-loader">
                            <div class="w-40 h-40 border-4 border-primary/10 border-t-primary rounded-full animate-spin"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="material-symbols-outlined text-5xl text-primary animate-pulse">cloud_upload</span>
                            </div>
                        </div>
                        <div class="hide space-y-8" id="final-success">
                            <div class="w-32 h-32 bg-secondary/10 rounded-full flex items-center justify-center mx-auto border-2 border-secondary/30 scale-110 transition-transform duration-1000">
                                <span class="material-symbols-outlined text-6xl text-secondary" style="font-variation-settings: 'FILL' 1;">verified</span>
                            </div>
                            <div class="space-y-3">
                                <h2 class="font-headline-lg text-4xl text-on-surface">Environnement Prêt</h2>
                                <p class="font-body-lg text-on-surface-variant/80 max-w-md mx-auto leading-relaxed">Votre écosystème Quatinx a été configuré avec succès. Vos données sont sécurisées et répliquées.</p>
                            </div>
                            <button class="mt-8 bg-secondary text-on-secondary font-bold px-12 py-5 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-2xl shadow-secondary/20 text-lg">
                                Accéder au Dashboard
                            </button>
                        </div>
                        <div class="space-y-2" id="loader-status">
                            <p class="font-label-md text-primary tracking-[0.3em] font-bold uppercase" id="loader-text">DÉPLOIEMENT DU WORKSPACE...</p>
                            <p class="text-xs text-on-surface-variant opacity-50" id="loader-subtext">Synchronisation des bases de données régionales</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- Footer Action Bar -->
        <footer class="h-28 px-12 bg-surface-container-low/80 backdrop-blur-md border-t border-outline-variant/30 flex items-center justify-between z-20">
            <button class="hidden flex items-center gap-3 font-bold text-on-surface-variant hover:text-on-surface transition-all group" id="btn-prev">
                <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back</span>
                <span>Retour</span>
            </button>
            <div class="flex-1"></div>
            <div class="flex items-center gap-6">
                <div class="text-xs font-bold tracking-widest text-on-surface-variant/50 hidden md:block" id="step-counter">
                    ÉTAPE <span class="text-on-surface" id="current-step-num">1</span> / 8
                </div>
                <button class="bg-primary text-on-primary-container font-bold px-12 py-4 rounded-xl hover:brightness-110 active:scale-95 transition-all flex items-center gap-3 shadow-xl shadow-primary/10" id="btn-next">
                    <span>Continuer</span>
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </div>
        </footer>
    </main>
    <script>
        /**
         * STATE MANAGEMENT
         */
        const state = {
            currentStep: 1,
            totalSteps: 8,
            workspaceName: '',
            currency: 'USD',
            language: 'fr',
            siteName: 'Dépôt Central',
            siteType: 'depot',
            siteAddress: '',
            categories: ['Electronics: Components', 'Electronics: Accessories'],
            productName: '',
            productSku: '',
            productCategory: '',
            productPrice: 0,
            productStock: 0,
            selectedRole: 'Admin',
            permissions: [],
            invitations: []
        };

        const stepInfo = [{
                name: 'Workspace',
                icon: 'corporate_fare'
            },
            {
                name: 'Sites',
                icon: 'warehouse'
            },
            {
                name: 'Catégories',
                icon: 'category'
            },
            {
                name: 'Produits',
                icon: 'inventory'
            },
            {
                name: 'Rôles',
                icon: 'badge'
            },
            {
                name: 'Permissions',
                icon: 'policy'
            },
            {
                name: 'Utilisateurs',
                icon: 'group_add'
            },
            {
                name: 'Finalisation',
                icon: 'task_alt'
            }
        ];

        /**
         * UTILS & BACKEND SIMULATION
         */
        async function simulateApiCall(endpoint, data) {
            console.log(`[API] Request to: ${endpoint}`, data);
            const delay = 300 + Math.random() * 200;
            return new Promise(resolve => setTimeout(() => resolve({
                status: 'success',
                timestamp: Date.now()
            }), delay));
        }

        async function triggerAutoSave() {
            const indicator = document.getElementById('autosave-indicator');
            const icon = document.getElementById('sync-icon');
            const text = document.getElementById('sync-text');

            indicator.classList.remove('opacity-60');
            indicator.classList.add('opacity-100', 'text-secondary');
            icon.innerText = 'sync';
            icon.classList.add('animate-spin');
            text.innerText = 'Sauvegarde...';

            await simulateApiCall('/autosave', state);

            setTimeout(() => {
                indicator.classList.remove('text-secondary');
                indicator.classList.add('opacity-60');
                icon.innerText = 'cloud_done';
                icon.classList.remove('animate-spin');
                text.innerText = 'Sauvegarde auto';
            }, 1000);
        }

        /**
         * DOM ELEMENTS & INIT
         */
        const sidebarNav = document.getElementById('sidebar-nav-container');
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');
        const currentStepNum = document.getElementById('current-step-num');

        function init() {
            renderSidebar();
            updateUI();

            // Form field listeners for auto-state update
            document.querySelectorAll('[data-state]').forEach(input => {
                input.addEventListener('input', (e) => {
                    const key = e.target.getAttribute('data-state');
                    state[key] = e.target.value;
                    triggerAutoSave();
                });
            });

            // Smart Defaults
            if (!state.workspaceName) state.workspaceName = "Nouveau Workspace";
        }

        function renderSidebar() {
            sidebarNav.innerHTML = '';
            stepInfo.forEach((step, index) => {
                const stepNum = index + 1;
                const stepDiv = document.createElement('div');
                stepDiv.id = `step-nav-${stepNum}`;
                stepDiv.className = `group flex items-center gap-4 p-4 rounded-xl cursor-default transition-all duration-300`;

                const isCompleted = stepNum < state.currentStep;
                const isActive = stepNum === state.currentStep;

                stepDiv.innerHTML = `
                <div class="flex-shrink-0 w-8 h-8 rounded-lg flex items-center justify-center border transition-colors ${isActive ? 'bg-primary border-primary text-on-primary' : (isCompleted ? 'bg-secondary/10 border-secondary text-secondary' : 'bg-surface-container/50 border-outline-variant/30 text-on-surface-variant')}">
                    <span class="material-symbols-outlined text-[18px]">${isCompleted ? 'check' : step.icon}</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-[10px] font-bold tracking-widest uppercase opacity-40 leading-none mb-1">0${stepNum}</span>
                    <span class="font-label-md text-sm ${isActive ? 'text-on-surface font-bold' : 'text-on-surface-variant'}">${step.name}</span>
                </div>
            `;
                if (isActive) stepDiv.classList.add('bg-surface-container-high/50', 'shadow-sm');
                sidebarNav.appendChild(stepDiv);
            });
        }

        /**
         * WORKFLOW LOGIC
         */
        function updateUI() {
            // Step Management
            for (let i = 1; i <= state.totalSteps; i++) {
                const section = document.getElementById(`step-${i}`);
                if (i === state.currentStep) {
                    section.classList.remove('hide');
                } else {
                    section.classList.add('hide');
                }
            }

            // Navigation update
            renderSidebar();
            currentStepNum.innerText = state.currentStep;

            // Button state
            if (state.currentStep === 1) btnPrev.classList.add('hidden');
            else btnPrev.classList.remove('hidden');

            if (state.currentStep === state.totalSteps) {
                btnNext.classList.add('hidden');
                btnPrev.classList.add('hidden');
                document.getElementById('step-counter').classList.add('hidden');
                runFinalSequence();
            } else {
                btnNext.classList.remove('hidden');
            }

            // Context Specific Loads
            if (state.currentStep === 4) populateCategorySelect();
            if (state.currentStep === 6) loadPermissions();
        }

        /**
         * STEP 3: CATEGORIES
         */
        function renderCategories() {
            const container = document.getElementById('category-list');
            container.innerHTML = '';
            state.categories.forEach(cat => {
                const tag = document.createElement('span');
                tag.className = 'px-4 py-2 bg-primary/10 border border-primary/20 rounded-xl text-primary text-sm flex items-center gap-2 animate-slide-in';
                tag.innerHTML = `${cat} <button onclick="removeCategory('${cat}')" class="material-symbols-outlined text-xs hover:text-on-surface">close</button>`;
                container.appendChild(tag);
            });
        }

        function addCategory(name) {
            if (name && !state.categories.includes(name)) {
                state.categories.push(name);
                renderCategories();
                triggerAutoSave();
            }
        }

        function addCategoryFromInput() {
            const input = document.getElementById('cat-input');
            addCategory(input.value);
            input.value = '';
        }

        function removeCategory(name) {
            state.categories = state.categories.filter(c => c !== name);
            renderCategories();
            triggerAutoSave();
        }

        document.getElementById('cat-input')?.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') addCategoryFromInput();
        });

        /**
         * STEP 4: PRODUCTS & SKU
         */
        function populateCategorySelect() {
            const select = document.getElementById('prod-category');
            select.innerHTML = '<option value="">Choisir...</option>';
            state.categories.forEach(cat => {
                const opt = document.createElement('option');
                opt.value = cat;
                opt.textContent = cat;
                select.appendChild(opt);
            });
        }

        async function generateSKU() {
            const name = document.getElementById('prod-name').value || 'PROD';
            const cat = document.getElementById('prod-category').value || 'GEN';

            document.getElementById('prod-sku').value = "CHARGEMENT...";
            await simulateApiCall('/generate-sku', {
                name,
                cat
            });

            const randomStr = Math.random().toString(36).substring(2, 6).toUpperCase();
            const prefix = name.substring(0, 3).toUpperCase();
            const catCode = cat.substring(0, 2).toUpperCase();
            const sku = `${catCode}-${prefix}-${randomStr}`;

            document.getElementById('prod-sku').value = sku;
            state.productSku = sku;
            triggerAutoSave();
        }

        /**
         * STEP 6: PERMISSIONS
         */
        function selectRole(role) {
            state.selectedRole = role;
            document.querySelectorAll('.role-card').forEach(c => c.classList.remove('border-primary', 'bg-primary/5'));
            document.getElementById(`role-${role.toLowerCase()}`).classList.add('border-primary', 'bg-primary/5');
            triggerAutoSave();
        }

        async function loadPermissions() {
            const body = document.getElementById('permissions-body');
            const loader = document.getElementById('permissions-loader');
            const table = document.getElementById('permissions-table-container');
            const roleDisplay = document.getElementById('current-role-display');

            roleDisplay.innerText = state.selectedRole;
            table.classList.add('opacity-30');
            loader.classList.remove('hide');

            await simulateApiCall('/get-permissions', {
                role: state.selectedRole
            });

            const modules = ['Inventaire', 'Sites', 'Commandes', 'Analytics', 'Réglages'];
            body.innerHTML = '';

            modules.forEach(mod => {
                const tr = document.createElement('tr');
                const isFull = state.selectedRole === 'Admin';
                const isEmployee = state.selectedRole === 'Employee' && (mod === 'Analytics' || mod === 'Réglages');

                tr.innerHTML = `
                <td class="p-5 font-medium text-sm">${mod}</td>
                <td class="p-5 text-center"><input type="checkbox" ${isFull || !isEmployee ? 'checked' : ''} class="w-5 h-5 rounded bg-surface-container border-outline-variant text-primary focus:ring-primary"></td>
                <td class="p-5 text-center"><input type="checkbox" ${isFull ? 'checked' : ''} class="w-5 h-5 rounded bg-surface-container border-outline-variant text-primary focus:ring-primary"></td>
                <td class="p-5 text-center"><input type="checkbox" ${isFull ? 'checked' : ''} class="w-5 h-5 rounded bg-surface-container border-outline-variant text-primary focus:ring-primary"></td>
                <td class="p-5 text-center"><input type="checkbox" ${isFull ? 'checked' : ''} class="w-5 h-5 rounded bg-surface-container border-outline-variant text-primary focus:ring-primary"></td>
            `;
                body.appendChild(tr);
            });

            loader.classList.add('hide');
            table.classList.remove('opacity-30');
        }

        /**
         * STEP 7: INVITATIONS
         */
        function addInvitation() {
            const email = document.getElementById('invite-email').value;
            const role = document.getElementById('invite-role').value;
            if (email) {
                state.invitations.push({
                    email,
                    role
                });
                renderInvitations();
                document.getElementById('invite-email').value = '';
                triggerAutoSave();
            }
        }

        function renderInvitations() {
            const list = document.getElementById('invitation-list');
            list.innerHTML = '';
            state.invitations.forEach((inv, index) => {
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between p-5 bg-surface-container/30 border border-outline-variant/30 rounded-xl animate-slide-in';
                item.innerHTML = `
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-surface-container rounded-full flex items-center justify-center font-bold text-xs">${inv.email.charAt(0).toUpperCase()}</div>
                    <div>
                        <p class="text-sm font-bold">${inv.email}</p>
                        <p class="text-[10px] text-on-surface-variant font-medium uppercase tracking-widest">${inv.role}</p>
                    </div>
                </div>
                <button onclick="removeInvite(${index})" class="text-on-surface-variant hover:text-error transition-colors">
                    <span class="material-symbols-outlined">delete</span>
                </button>
            `;
                list.appendChild(item);
            });
        }

        function removeInvite(idx) {
            state.invitations.splice(idx, 1);
            renderInvitations();
            triggerAutoSave();
        }

        /**
         * STEP 8: FINAL
         */
        function runFinalSequence() {
            const finalLoader = document.getElementById('final-loader');
            const loaderStatus = document.getElementById('loader-status');
            const loaderText = document.getElementById('loader-text');
            const loaderSub = document.getElementById('loader-subtext');
            const success = document.getElementById('final-success');

            const updates = [{
                    text: "DÉPLOIEMENT DU WORKSPACE...",
                    sub: "Création de l'infrastructure cloud"
                },
                {
                    text: "CHIFFREMENT DES DONNÉES...",
                    sub: "Standard AES-256 en cours"
                },
                {
                    text: "SYNCHRONISATION TERMINÉE",
                    sub: "Prêt pour le lancement"
                }
            ];

            let currentUpdate = 0;
            const interval = setInterval(() => {
                if (currentUpdate < updates.length) {
                    loaderText.innerText = updates[currentUpdate].text;
                    loaderSub.innerText = updates[currentUpdate].sub;
                    currentUpdate++;
                } else {
                    clearInterval(interval);
                    finalLoader.classList.add('hide');
                    loaderStatus.classList.add('hide');
                    success.classList.remove('hide');
                }
            }, 1500);
        }

        /**
         * GLOBAL EVENT LISTENERS
         */
        btnNext.addEventListener('click', () => {
            if (state.currentStep < state.totalSteps) {
                state.currentStep++;
                updateUI();
            }
        });

        btnPrev.addEventListener('click', () => {
            if (state.currentStep > 1) {
                state.currentStep--;
                updateUI();
            }
        });

        // Start App
        init();
        renderCategories();
    </script>
</body>

</html>
