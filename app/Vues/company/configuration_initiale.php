<!DOCTYPE html>

<html class="dark" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
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

        /* Custom Toggle Switch Styles */
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 44px;
            height: 24px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #273647;
            transition: .4s;
            border-radius: 24px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 18px;
            width: 18px;
            left: 3px;
            bottom: 3px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.toggle-slider {
            background-color: #adc7ff;
        }

        input:checked+.toggle-slider:before {
            transform: translateX(20px);
            background-color: #002e68;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
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
            <div class="space-y-1" id="sidebar-nav-container">
                <!-- Step Templates generated via JS -->
            </div>
        </nav>
        <div class="p-6 border-t border-outline-variant/30">
            <div class="flex items-center gap-3 text-on-surface-variant transition-all duration-300" id="autosave-indicator" style="opacity: 0.6;">
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
                    <div class="space-y-10 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 01</span>
                            <h2 class="font-headline-lg text-4xl text-on-surface">Configuration du Workspace</h2>
                            <p class="font-body-lg text-on-surface-variant/80">Définissez l'identité globale et les paramètres régionaux de votre organisation.</p>
                        </header>
                        <div class="glass-card p-10 rounded-2xl space-y-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
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
                                        <option value="XAF">Franc CFA (FC)</option>
                                    </select>
                                </div>
                                <div class="space-y-3">
                                    <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Pays</label>
                                    <select class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none appearance-none cursor-pointer" data-state="country">
                                        <option value="FR">France</option>
                                        <option value="BE">Belgique</option>
                                        <option value="CA">Canada</option>
                                        <option value="CH">Suisse</option>
                                        <option value="SN">Sénégal</option>
                                    </select>
                                </div>
                                <div class="space-y-3">
                                    <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Fuseau Horaire</label>
                                    <select class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none appearance-none cursor-pointer" data-state="timezone">
                                        <option value="UTC+1">(UTC+01:00) Paris, Bruxelles, Madrid</option>
                                        <option value="UTC+0">(UTC+00:00) Casablanca, Londres</option>
                                        <option value="UTC-5">(UTC-05:00) New York, Montréal</option>
                                    </select>
                                </div>
                                <div class="space-y-3">
                                    <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Système d'unités</label>
                                    <select class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none appearance-none cursor-pointer" data-state="unitSystem">
                                        <option value="metric">Métrique (kg, m, l)</option>
                                        <option value="imperial">Impérial (lb, ft, gal)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="pt-8 border-t border-outline-variant/20 space-y-6">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">settings_suggest</span>
                                    <h3 class="font-headline-md text-lg text-on-surface">Paramètres de Stock &amp; Structure</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-3">
                                        <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Préfixe SKU par défaut</label>
                                        <input class="w-full bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none" data-state="skuPrefix" placeholder="ex: QTX-" type="text" value="QTX-" />
                                    </div>
                                    <div class="flex flex-col gap-6 justify-center">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium">Génération automatique SKU</span>
                                            <label class="toggle-switch">
                                                <input checked="" data-state="autoGenerateSku" type="checkbox" />
                                                <span class="toggle-slider"></span>
                                            </label>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium">Alertes de stock bas</span>
                                            <label class="toggle-switch">
                                                <input checked="" data-state="stockAlertEnabled" type="checkbox" />
                                                <span class="toggle-slider"></span>
                                            </label>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium">Autoriser stock négatif</span>
                                            <label class="toggle-switch">
                                                <input data-state="negativeStockAllowed" type="checkbox" />
                                                <span class="toggle-slider"></span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
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
                            <p class="font-body-lg text-on-surface-variant/80">Organisez vos produits par familles logiques.</p>
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
                                <div class="flex flex-wrap gap-3 min-h-[50px] p-6 bg-surface-container-lowest/30 rounded-2xl border border-dashed border-outline-variant/30" id="category-list"></div>
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
                        </div>
                    </div>
                </section>
                <!-- Step 5: Roles & Custom Creation -->
                <section class="transition-content hide" id="step-5">
                    <div class="space-y-10 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 05</span>
                            <h2 class="font-headline-lg text-4xl text-on-surface">Gestion des Rôles</h2>
                            <p class="font-body-lg text-on-surface-variant/80">Créez et personnalisez les profils d'accès pour votre équipe.</p>
                        </header>
                        <div class="glass-card p-10 rounded-2xl space-y-8">
                            <div class="space-y-4">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Créer un nouveau rôle personnalisé</label>
                                <div class="flex gap-3">
                                    <input class="flex-1 bg-surface-container/50 border border-outline-variant/50 rounded-xl p-4 text-on-surface focus:border-primary outline-none" id="role-input" placeholder="Taper le nom du rôle..." type="text" />
                                    <button class="bg-primary text-on-primary-container font-bold px-8 py-4 rounded-xl hover:brightness-110 active:scale-95 transition-all" onclick="addRoleFromInput()">Créer</button>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Rôles configurés</label>
                                <div class="flex flex-wrap gap-3" id="role-list-container">
                                    <!-- Generated Roles -->
                                </div>
                            </div>
                            <div class="space-y-4">
                                <label class="font-label-sm text-on-surface-variant uppercase tracking-wider text-[11px] font-bold">Suggestions rapides</label>
                                <div class="flex flex-wrap gap-3">
                                    <button class="px-5 py-2 rounded-full border border-outline-variant hover:border-primary hover:text-primary transition-all text-xs font-bold" onclick="addRole('Stockiste')">Stockiste</button>
                                    <button class="px-5 py-2 rounded-full border border-outline-variant hover:border-primary hover:text-primary transition-all text-xs font-bold" onclick="addRole('Caissier')">Caissier</button>
                                    <button class="px-5 py-2 rounded-full border border-outline-variant hover:border-primary hover:text-primary transition-all text-xs font-bold" onclick="addRole('Auditeur')">Auditeur</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Step 6: Permissions Matrix -->
                <section class="transition-content hide" id="step-6">
                    <div class="space-y-8 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 06</span>
                            <h2 class="font-headline-lg text-4xl text-on-surface">Matrice de Sécurité</h2>
                            <p class="font-body-lg text-on-surface-variant/80">Configurez finement les accès pour <span class="text-primary font-bold" id="current-role-display">...</span></p>
                        </header>
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
                                <tbody class="divide-y divide-outline-variant/20" id="permissions-body"></tbody>
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
                            <p class="font-body-lg text-on-surface-variant/80">Invitez votre équipe à rejoindre votre nouvel espace.</p>
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
                                        <!-- Populated via JS based on current roles -->
                                    </select>
                                </div>
                                <button class="bg-primary text-on-primary-container h-[56px] font-bold rounded-xl hover:brightness-110 active:scale-95 transition-all flex items-center justify-center gap-2" onclick="addInvitation()">
                                    <span class="material-symbols-outlined">person_add</span>
                                </button>
                            </div>
                            <div class="space-y-3" id="invitation-list"></div>
                        </div>
                    </div>
                </section>
                <!-- Step 8: Finalisation -->
                <section class="transition-content hide" id="step-8">
                    <div class="flex flex-col items-center justify-center min-h-[500px] text-center space-y-12 animate-slide-in">
                        <div class="relative rounded-full" id="final-loader">
                            <div class="w-40 h-40 border-4 border-primary/10 border-t-primary rounded-full animate-spin"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="material-symbols-outlined text-5xl text-primary animate-pulse">cloud_upload</span>
                            </div>
                        </div>
                        <div class="hide space-y-8" id="final-success">
                            <div class="w-32 h-32 bg-secondary/10 rounded-full flex items-center justify-center mx-auto border-2 border-secondary/30 scale-110">
                                <span class="material-symbols-outlined text-6xl text-secondary" style="font-variation-settings: 'FILL' 1;">verified</span>
                            </div>
                            <div class="space-y-3">
                                <h2 class="font-headline-lg text-4xl text-on-surface">Environnement Prêt</h2>
                                <p class="font-body-lg text-on-surface-variant/80 max-w-md mx-auto leading-relaxed">Votre écosystème Quatinx a été configuré avec succès.</p>
                            </div>
                            <button class="mt-8 bg-secondary text-on-secondary font-bold px-12 py-5 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-2xl shadow-secondary/20 text-lg">
                                Accéder au Dashboard
                            </button>
                        </div>
                        <div class="space-y-2" id="loader-status">
                            <p class="font-label-md text-primary tracking-[0.3em] font-bold uppercase" id="loader-text">DÉPLOIEMENT DU WORKSPACE...</p>
                            <p class="text-xs text-on-surface-variant opacity-50" id="loader-subtext">Synchronisation des serveurs régionaux</p>
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
        // Real backend data - passed from PHP controller
        const BACKEND_CURRENT_STEP = <?= json_encode($currentStep ?? 1) ?>;
        const BACKEND_WIZARD_STATE = <?= json_encode($wizardState ?? []) ?>;
    </script>
    <script src="<?= asset('js/company/config/config_initiale.js') ?>"></script>
</body>

</html>
