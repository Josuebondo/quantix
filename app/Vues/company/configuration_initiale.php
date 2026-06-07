<!DOCTYPE html>

<html class="dark" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">
    <title>Quatinx Onboarding | Global Inventory Management</title>
    <link rel="stylesheet" href="/css/tailwind.css">
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <style>
        body {
            font-family: "Manrope", sans-serif;
        }

        .glass-effect {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .bg-pattern {
            background-image: radial-gradient(circle at 50% 50%, rgba(19, 236, 128, 0.03) 0%, transparent 50%),
                linear-gradient(rgba(2, 6, 23, 0.95), rgba(2, 6, 23, 0.98));
            background-size: cover;
            background-position: center;
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
            background-color: #161b26;
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
            background-color: #ffffff;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.toggle-slider {
            background-color: #0066ff;
        }

        input:checked+.toggle-slider:before {
            transform: translateX(20px);
            background-color: #001849;
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

        /* Enhanced Select Styling */
        select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%239CA3AF' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            padding-right: 2.5rem;
        }

        select:hover {
            border-color: #0066ff !important;
            background-color: rgba(255, 255, 255, 0.08) !important;
        }

        select:focus {
            border-color: #0066ff !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1) !important;
        }

        select option {
            background-color: #0f172a;
            color: #ffffff;
            padding: 8px;
        }

        select option:hover {
            background-color: #0066ff;
            color: #ffffff;
        }

        select option:checked {
            background: linear-gradient(#0066ff, #0052cc);
            background-color: #0066ff;
        }

        /* Sidebar Navigation Items Styling */
        .nav-item {
            transition: all 0.3s ease;
            position: relative;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.08);
        }

        .nav-item.active {
            background: rgba(0, 102, 255, 0.2);
            border-left: 3px solid #0066ff;
            padding-left: calc(1rem - 3px);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, #0066ff, rgba(0, 102, 255, 0.5));
            border-radius: 0 2px 2px 0;
        }

        /* Enhanced Input Styling */
        input[type="text"],
        input[type="email"],
        textarea {
            transition: all 0.3s ease;
        }

        input[type="text"]:hover,
        input[type="email"]:hover,
        textarea:hover {
            border-color: rgba(255, 255, 255, 0.2) !important;
            background-color: rgba(255, 255, 255, 0.08) !important;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        textarea:focus {
            border-color: #0066ff !important;
            background-color: rgba(255, 255, 255, 0.1) !important;
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1) !important;
        }

        /* Enhanced Button Styling */
        button.bg-primary {
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 102, 255, 0.2);
        }

        button.bg-primary:hover {
            box-shadow: 0 8px 25px rgba(0, 102, 255, 0.3);
            transform: translateY(-2px);
        }

        button.bg-primary:active {
            transform: translateY(0);
        }
    </style>
</head>

<body class="flex text-white flex-col md:flex-row h-screen overflow-hidden bg-slate-950 font-display min-h-screen bg-pattern">
    <!-- Sidebar Stepper (responsive: horizontal top bar on mobile, vertical on md+ screens) -->
    <aside class="w-full md:w-80 md:h-screen bg-gradient-to-b from-slate-800/60 via-slate-900/70 to-slate-950/80 border-b md:border-b-0 md:border-r border-white/10 flex flex-row md:flex-col sticky top-0 md:sticky z-40 shadow-2xl backdrop-blur-xl">

        <!-- Logo -->
        <div class="p-4 md:p-8 border-b border-white/10 shrink-0">
            <div class="flex items-center gap-3 group">
                <div class="w-10 h-10 bg-gradient-to-br from-primary to-primary/60 rounded-xl flex items-center justify-center border border-primary/40 shadow-lg shadow-primary/20 transition-all duration-300 group-hover:shadow-primary/40">
                    <span class="material-symbols-outlined text-white text-2xl">inventory_2</span>
                </div>

                <div>
                    <h1 class="text-xl font-bold text-white leading-tight">
                        Quatinx
                    </h1>

                    <p class="text-[10px] text-white/60 tracking-[0.2em] uppercase font-semibold">
                        Enterprise Cloud
                    </p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-hidden">
            <div
                id="sidebar-nav-container"
                class="flex flex-row md:flex-col gap-2 overflow-x-auto md:overflow-y-auto no-scrollbar px-3 py-3 md:px-4 md:py-4">

                <!-- Step 01 -->
                <div class="group flex items-center gap-4 p-3 rounded-xl bg-primary/15 border border-primary/20 text-white min-w-[90px] md:min-w-0 md:w-full shrink-0 cursor-pointer transition-all duration-300 hover:bg-primary/20">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center border border-primary/30 bg-primary/20 text-primary">
                        <span class="material-symbols-outlined text-[18px]">corporate_fare</span>
                    </div>

                    <div class="hidden md:flex flex-col">
                        <span class="text-[10px] font-bold tracking-widest uppercase opacity-50">
                            01
                        </span>
                        <span class="text-sm">Workspace</span>
                    </div>
                </div>

                <!-- Step 02 -->
                <div class="group flex items-center gap-4 p-3 rounded-xl bg-white/5 text-white/80 min-w-[90px] md:min-w-0 md:w-full shrink-0 cursor-pointer transition-all duration-300 hover:bg-white/10">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center border border-white/10 bg-white/10">
                        <span class="material-symbols-outlined text-[18px]">warehouse</span>
                    </div>

                    <div class="hidden md:flex flex-col">
                        <span class="text-[10px] font-bold tracking-widest uppercase opacity-40">
                            02
                        </span>
                        <span class="text-sm">Sites</span>
                    </div>
                </div>

                <!-- Step 03 -->
                <div class="group flex items-center gap-4 p-3 rounded-xl bg-white/5 text-white/80 min-w-[90px] md:min-w-0 md:w-full shrink-0 cursor-pointer transition-all duration-300 hover:bg-white/10">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center border border-white/10 bg-white/10">
                        <span class="material-symbols-outlined text-[18px]">category</span>
                    </div>

                    <div class="hidden md:flex flex-col">
                        <span class="text-[10px] font-bold tracking-widest uppercase opacity-40">
                            03
                        </span>
                        <span class="text-sm">Catégories</span>
                    </div>
                </div>

                <!-- Step 04 -->
                <div class="group flex items-center gap-4 p-3 rounded-xl bg-white/5 text-white/80 min-w-[90px] md:min-w-0 md:w-full shrink-0 cursor-pointer transition-all duration-300 hover:bg-white/10">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center border border-white/10 bg-white/10">
                        <span class="material-symbols-outlined text-[18px]">inventory</span>
                    </div>

                    <div class="hidden md:flex flex-col">
                        <span class="text-[10px] font-bold tracking-widest uppercase opacity-40">
                            04
                        </span>
                        <span class="text-sm">Produits</span>
                    </div>
                </div>

                <!-- Step 05 -->
                <div class="group flex items-center gap-4 p-3 rounded-xl bg-white/5 text-white/80 min-w-[90px] md:min-w-0 md:w-full shrink-0 cursor-pointer transition-all duration-300 hover:bg-white/10">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center border border-white/10 bg-white/10">
                        <span class="material-symbols-outlined text-[18px]">badge</span>
                    </div>

                    <div class="hidden md:flex flex-col">
                        <span class="text-[10px] font-bold tracking-widest uppercase opacity-40">
                            05
                        </span>
                        <span class="text-sm">Rôles</span>
                    </div>
                </div>

                <!-- Step 06 -->
                <div class="group flex items-center gap-4 p-3 rounded-xl bg-white/5 text-white/80 min-w-[90px] md:min-w-0 md:w-full shrink-0 cursor-pointer transition-all duration-300 hover:bg-white/10">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center border border-white/10 bg-white/10">
                        <span class="material-symbols-outlined text-[18px]">policy</span>
                    </div>

                    <div class="hidden md:flex flex-col">
                        <span class="text-[10px] font-bold tracking-widest uppercase opacity-40">
                            06
                        </span>
                        <span class="text-sm">Permissions</span>
                    </div>
                </div>

                <!-- Step 07 -->
                <div class="group flex items-center gap-4 p-3 rounded-xl bg-white/5 text-white/80 min-w-[90px] md:min-w-0 md:w-full shrink-0 cursor-pointer transition-all duration-300 hover:bg-white/10">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center border border-white/10 bg-white/10">
                        <span class="material-symbols-outlined text-[18px]">group_add</span>
                    </div>

                    <div class="hidden md:flex flex-col">
                        <span class="text-[10px] font-bold tracking-widest uppercase opacity-40">
                            07
                        </span>
                        <span class="text-sm">Utilisateurs</span>
                    </div>
                </div>

                <!-- Step 08 -->
                <div class="group flex items-center gap-4 p-3 rounded-xl bg-white/5 text-white/80 min-w-[90px] md:min-w-0 md:w-full shrink-0 cursor-pointer transition-all duration-300 hover:bg-white/10">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center border border-white/10 bg-white/10">
                        <span class="material-symbols-outlined text-[18px]">task_alt</span>
                    </div>

                    <div class="hidden md:flex flex-col">
                        <span class="text-[10px] font-bold tracking-widest uppercase opacity-40">
                            08
                        </span>
                        <span class="text-sm">Finalisation</span>
                    </div>
                </div>

            </div>
        </nav>

        <!-- Autosave -->
        <div class="hidden md:block p-6 h-16 border-t border-white/10 bg-white/5 shrink-0">
            <div id="autosave-indicator" class="flex items-center gap-3 text-white/70">
                <span id="sync-icon" class="material-symbols-outlined text-sm">
                    cloud_done
                </span>

                <span id="sync-text" class="text-xs font-medium uppercase tracking-widest">
                    Système prêt
                </span>
            </div>
        </div>

    </aside>
    <!-- Main Content -->
    <main class="flex-1 flex flex-col relative overflow-hidden bg-slate-950">
        <div class="absolute top-0 w-full h-32 bg-gradient-to-b from-slate-950/80 to-transparent z-10 pointer-events-none"></div>
        <div class="flex-1 overflow-y-auto px-6 md:px-12 py-24 z-0 no-scrollbar" id="content-container">
            <div class="max-w-4xl mx-auto">
                <!-- Step 1: Workspace -->
                <section class="transition-content" id="step-1">
                    <div class="space-y-10 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 01</span>
                            <h2 class="text-4xl text-white">Configuration du Workspace</h2>
                            <p class="text-white/50">Définissez l'identité globale et les paramètres régionaux de votre organisation.</p>
                        </header>
                        <div class="bg-white/5 border border-white/10 backdrop-blur-xl p-10 rounded-2xl space-y-10">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="md:col-span-2 space-y-3">
                                    <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Nom de l'organisation</label>
                                    <input class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white focus:border-primary focus:ring-2 focus:ring-primary/30 focus:bg-white/10 outline-none transition-all" data-state="workspaceName" placeholder="ex: Quatinx Global Ltd" type="text" />
                                </div>
                                <div class="space-y-3">
                                    <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Devise par défaut</label>
                                    <select class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white hover:border-white/20 hover:bg-white/10 focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none appearance-none cursor-pointer transition-all" data-state="currency">
                                        <option value="EUR">Euro (€)</option>
                                        <option value="USD">US Dollar ($)</option>
                                        <option value="GBP">British Pound (£)</option>
                                        <option value="XAF">Franc CFA (FC)</option>
                                    </select>
                                </div>
                                <div class="space-y-3">
                                    <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Pays</label>
                                    <select class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white hover:border-white/20 hover:bg-white/10 focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none appearance-none cursor-pointer transition-all" data-state="country">
                                        <option value="FR">France</option>
                                        <option value="BE">Belgique</option>
                                        <option value="CA">Canada</option>
                                        <option value="CH">Suisse</option>
                                        <option value="SN">Sénégal</option>
                                    </select>
                                </div>
                                <div class="space-y-3">
                                    <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Fuseau Horaire</label>
                                    <select class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white hover:border-white/20 hover:bg-white/10 focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none appearance-none cursor-pointer transition-all" data-state="timezone">
                                        <option value="UTC+1">(UTC+01:00) Paris, Bruxelles, Madrid</option>
                                        <option value="UTC+0">(UTC+00:00) Casablanca, Londres</option>
                                        <option value="UTC-5">(UTC-05:00) New York, Montréal</option>
                                    </select>
                                </div>
                                <div class="space-y-3">
                                    <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Système d'unités</label>
                                    <select class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white hover:border-white/20 hover:bg-white/10 focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none appearance-none cursor-pointer transition-all" data-state="unitSystem">
                                        <option value="metric">Métrique (kg, m, l)</option>
                                        <option value="imperial">Impérial (lb, ft, gal)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="pt-8 border-t border-white/10 space-y-6">
                                <div class="flex items-center gap-3">
                                    <span class="material-symbols-outlined text-primary">settings_suggest</span>
                                    <h3 class="text-lg text-white">Paramètres de Stock &amp; Structure</h3>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-3">
                                        <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Préfixe SKU par défaut</label>
                                        <input class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white focus:border-primary outline-none" data-state="skuPrefix" placeholder="ex: QTX-" type="text" value="QTX-" />
                                    </div>
                                    <div class="flex flex-col gap-6 justify-center">
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-white/70">Génération automatique SKU</span>
                                            <label class="toggle-switch">
                                                <input checked="" data-state="autoGenerateSku" type="checkbox" />
                                                <span class="toggle-slider"></span>
                                            </label>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-white/70">Alertes de stock bas</span>
                                            <label class="toggle-switch">
                                                <input checked="" data-state="stockAlertEnabled" type="checkbox" />
                                                <span class="toggle-slider"></span>
                                            </label>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-white/70">Autoriser stock négatif</span>
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
                <section class="transition-content hidden" id="step-2">
                    <div class="space-y-8 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 02</span>
                            <h2 class="text-4xl text-white">Initialisation des Sites</h2>
                            <p class="text-white/50">Configurez vos points logistiques et de distribution.</p>
                        </header>
                        <div class="bg-white/5 border border-white/10 backdrop-blur-xl p-10 rounded-2xl space-y-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-3">
                                    <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Nom du site</label>
                                    <input class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none" data-state="siteName" placeholder="ex: Hub Logistique Paris" type="text" />
                                </div>
                                <div class="space-y-3">
                                    <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Type de site</label>
                                    <select class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white hover:border-white/20 hover:bg-white/10 focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none appearance-none cursor-pointer transition-all" data-state="siteType">
                                        <option value="depot">Dépôt (Stockage)</option>
                                        <option value="point_de_vente">Point de vente (Retail)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Adresse physique</label>
                                <textarea class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none" data-state="siteAddress" placeholder="123 Rue de l'Innovation, 75001 Paris" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Step 3: Catégories -->
                <section class="transition-content hidden" id="step-3">
                    <div class="space-y-8 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 03</span>
                            <h2 class="text-4xl text-white">Segmentation de l'Inventaire</h2>
                            <p class="text-white/50">Organisez vos produits par familles logiques.</p>
                        </header>
                        <div class="bg-white/5 border border-white/10 backdrop-blur-xl p-10 rounded-2xl space-y-10">
                            <div class="space-y-4">
                                <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Ajouter une catégorie</label>
                                <div class="flex gap-3">
                                    <input class="flex-1 bg-white/5 border border-white/10 rounded-xl p-4 text-white focus:border-primary outline-none" id="cat-input" placeholder="ex: Hardware, Logiciels..." type="text" />
                                    <button class="bg-primary text-midnight font-bold px-3 py-2 md:px-8 md:py-4 rounded-xl hover:bg-primary/90 active:scale-95 transition-all flex items-center justify-center md:justify-start gap-2" onclick="addCategoryFromInput()">
                                        <span class="material-symbols-outlined text-lg">add</span>
                                        <span class="hidden md:inline">Ajouter</span>
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Vos catégories</label>
                                <div class="flex flex-wrap gap-3 min-h-[50px] p-6 bg-white/5 rounded-2xl border border-dashed border-white/10" id="category-list"></div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Step 4: Produits -->
                <section class="transition-content hidden" id="step-4">
                    <div class="space-y-8 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 04</span>
                            <h2 class="text-4xl text-white">Référencement Produit</h2>
                            <p class="text-white/50">Commencez par enregistrer votre premier article pilote.</p>
                        </header>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-white/5 border border-white/10 backdrop-blur-xl p-10 rounded-2xl">
                            <div class="md:col-span-2 space-y-3">
                                <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Nom du produit</label>
                                <input class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white focus:border-primary outline-none" data-state="productName" id="prod-name" placeholder="ex: Workstation Z-8000" type="text" />
                            </div>
                            <div class="space-y-3">
                                <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">SKU Unique</label>
                                <div class="relative flex items-center">
                                    <input class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-primary font-mono text-sm outline-none" data-state="productSku" id="prod-sku" placeholder="SKU-AUTO-GEN" readonly="" type="text" />
                                    <button class="absolute right-2 px-3 py-2 bg-primary/10 text-primary rounded-lg text-xs font-bold hover:bg-primary/20 transition-all flex items-center gap-1" onclick="generateSKU()">
                                        <span class="material-symbols-outlined text-[14px]">auto_awesome</span> Générer
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Catégorie</label>
                                <select class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white hover:border-white/20 hover:bg-white/10 focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none appearance-none cursor-pointer transition-all" data-state="productCategory" id="prod-category">
                                    <option value="">Choisir...</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Step 5: Roles & Custom Creation -->
                <section class="transition-content hidden" id="step-5">
                    <div class="space-y-10 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 05</span>
                            <h2 class="text-4xl text-white">Gestion des Rôles</h2>
                            <p class="text-white/50">Créez et personnalisez les profils d'accès pour votre équipe.</p>
                        </header>
                        <div class="bg-white/5 border border-white/10 backdrop-blur-xl p-10 rounded-2xl space-y-8">
                            <div class="space-y-4">
                                <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Créer un nouveau rôle personnalisé</label>
                                <div class="flex gap-3">
                                    <input class="flex-1 bg-white/5 border border-white/10 rounded-xl p-4 text-white focus:border-primary outline-none" id="role-input" placeholder="Taper le nom du rôle..." type="text" />
                                    <button class="bg-primary text-midnight font-bold px-3 py-2 md:px-8 md:py-4 rounded-xl hover:bg-primary/90 active:scale-95 transition-all flex items-center justify-center md:justify-start gap-2" onclick="addRoleFromInput()">
                                        <span class="material-symbols-outlined text-lg">add</span>
                                        <span class="hidden md:inline">Créer</span>
                                    </button>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Rôles configurés</label>
                                <div class="flex flex-wrap gap-3" id="role-list-container">
                                    <!-- Generated Roles -->
                                </div>
                            </div>
                            <div class="space-y-4">
                                <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Suggestions rapides</label>
                                <div class="flex flex-wrap gap-3">
                                    <button class="px-5 py-2 rounded-full border border-white/10 hover:border-primary hover:text-primary transition-all text-xs font-bold text-white/70" onclick="addRole('Stockiste')">Stockiste</button>
                                    <button class="px-5 py-2 rounded-full border border-white/10 hover:border-primary hover:text-primary transition-all text-xs font-bold text-white/70" onclick="addRole('Caissier')">Caissier</button>
                                    <button class="px-5 py-2 rounded-full border border-white/10 hover:border-primary hover:text-primary transition-all text-xs font-bold text-white/70" onclick="addRole('Auditeur')">Auditeur</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Step 6: Permissions Matrix -->
                <section class="transition-content hidden" id="step-6">
                    <div class="space-y-8 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 06</span>
                            <h2 class="text-4xl text-white">Matrice de Sécurité</h2>
                            <p class="text-white/50">Configurez finement les accès pour <span class="text-primary font-bold" id="current-role-display">...</span></p>
                        </header>
                        <div class="hidden flex items-center justify-center p-10 gap-4 bg-white/5 border border-white/10 backdrop-blur-xl rounded-2xl" id="permissions-loader">
                            <div class="w-12 h-12 border-4 border-primary/20 border-t-primary rounded-full animate-spin"></div>
                            <span class="text-sm uppercase tracking-widest font-bold text-primary">Chargement des permissions...</span>
                        </div>
                        <div class="bg-white/5 border border-white/10 backdrop-blur-xl rounded-2xl overflow-hidden shadow-lg shadow-black/10" id="permissions-table-container">
                            <div class="overflow-x-auto">
                                <table class="min-w-[720px] w-full text-left text-white/90">
                                    <thead class="bg-white/10 text-white/70" id="permissions-head"></thead>
                                    <tbody class="divide-y divide-white/10 bg-white/5/10" id="permissions-body"></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="mt-4 hidden" id="permissions-extra-container"></div>
                    </div>
                </section>
                <!-- Step 7: Invitations -->
                <section class="transition-content hidden" id="step-7">
                    <div class="space-y-8 animate-slide-in">
                        <header class="space-y-3">
                            <span class="inline-block px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold tracking-widest uppercase">Étape 07</span>
                            <h2 class="text-4xl text-white">Collaborateurs</h2>
                            <p class="text-white/50">Invitez votre équipe à rejoindre votre nouvel espace.</p>
                        </header>
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 bg-white/5 border border-white/10 backdrop-blur-xl p-8 rounded-2xl items-end">
                                <div class="md:col-span-2 space-y-3">
                                    <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Email du collaborateur</label>
                                    <input class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white outline-none" id="invite-email" placeholder="nom@entreprise.com" type="email" />
                                </div>
                                <div class="md:col-span-2 space-y-3">
                                    <label class="text-white/50 uppercase tracking-wider text-[11px] font-bold">Rôle assigné</label>
                                    <select class="w-full bg-white/5 border border-white/10 rounded-xl p-4 text-white hover:border-white/20 hover:bg-white/10 focus:border-primary focus:ring-2 focus:ring-primary/30 outline-none appearance-none cursor-pointer transition-all" id="invite-role">
                                        <!-- Populated via JS based on current roles -->
                                    </select>
                                </div>
                                <button class="bg-primary text-midnight h-[56px] font-bold rounded-xl hover:bg-primary/90 active:scale-95 transition-all flex items-center justify-center gap-2" onclick="addInvitation()">
                                    <span class="material-symbols-outlined">person_add</span>
                                </button>
                            </div>
                            <div class="space-y-3" id="invitation-list"></div>
                        </div>
                    </div>
                </section>
                <!-- Step 8: Finalisation -->
                <section class="transition-content hidden" id="step-8">
                    <div class="flex flex-col items-center justify-center min-h-[500px] text-center space-y-12 animate-slide-in">
                        <div class="relative rounded-full" id="final-loader">
                            <div class="w-40 h-40 border-4 border-primary/10 border-t-primary rounded-full animate-spin"></div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="material-symbols-outlined text-5xl text-primary animate-pulse">cloud_upload</span>
                            </div>
                        </div>
                        <div class="hidden space-y-8" id="final-success">
                            <div class="w-32 h-32 bg-secondary/10 rounded-full flex items-center justify-center mx-auto border-2 border-secondary/30 scale-110">
                                <span class="material-symbols-outlined text-6xl text-secondary" style="font-variation-settings: 'FILL' 1;">verified</span>
                            </div>
                            <div class="space-y-3">
                                <h2 class="text-4xl text-white">Environnement Prêt</h2>
                                <p class="text-white/50 max-w-md mx-auto leading-relaxed">Votre écosystème Quatinx a été configuré avec succès.</p>
                            </div>
                            <button class="mt-8 bg-secondary text-on-secondary font-bold px-12 py-5 rounded-2xl hover:brightness-110 active:scale-95 transition-all shadow-2xl shadow-secondary/20 text-lg">
                                Accéder au Dashboard
                            </button>
                        </div>
                        <div class="space-y-2" id="loader-status">
                            <p class="text-primary tracking-[0.3em] font-bold uppercase" id="loader-text">DÉPLOIEMENT DU WORKSPACE...</p>
                            <p class="text-xs text-white/50 opacity-50" id="loader-subtext">Synchronisation des serveurs régionaux</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <!-- Footer Action Bar -->
        <footer class="h-16 px-12 bg-white/5 backdrop-blur-md border-t border-white/10 flex items-center justify-between z-20">
            <button class="hidden flex items-center gap-3 font-bold text-white/50 hover:text-white transition-all group" id="btn-prev">
                <span class="material-symbols-outlined group-hover:-translate-x-1 transition-transform">arrow_back</span>
                <span class="hidden sd:inline">Retour</span>
            </button>
            <div class="flex-1"></div>
            <div class="flex items-center gap-6">
                <div class="text-xs font-bold tracking-widest text-white/50 hidden md:block" id="step-counter">
                    ÉTAPE <span class="text-white" id="current-step-num">1</span> / 8
                </div>
                <button class="bg-primary text-midnight font-bold px-3 py-2 md:px-12 md:py-4 rounded-xl hover:bg-primary/90 active:scale-95 transition-all flex items-center gap-3 shadow-xl shadow-primary/10" id="btn-next">
                    <span class="material-symbols-outlined">arrow_forward</span>
                    <span class="hidden md:inline">Continuer</span>
                </button>
            </div>
        </footer>
    </main>

    <script>
        // Real backend data - passed from PHP controller
        const BACKEND_CURRENT_STEP = <?= json_encode($currentStep ?? 1) ?>;
        const BACKEND_WIZARD_STATE = <?= json_encode($wizardState ?? []) ?>;
        const SESSION_WIZARD_ID = <?= json_encode($sessionId ?? null) ?>;
    </script>
    <script src="<?= asset('js/company/config/config_initiale.js') ?>"></script>
</body>

</html>