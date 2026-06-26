<!DOCTYPE html>

<html class="light" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/css/tailwind.css">
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .obsidian-flux {
            background: radial-gradient(circle at top left, #18181b, #09090b);
        }

        .step-content {
            display: none;
        }

        .step-content.active {
            display: flex;
        }
    </style>
</head>

<body class="obsidian-flux text-zinc-100 min-h-screen flex flex-col antialiased">
    <header class="bg-zinc-950 dark:bg-zinc-950 text-sans antialiased text-sm shadow-sm border-b border-zinc-800 dark:border-zinc-800 flex justify-between items-center px-6 h-16 w-full max-w-full">
        <div class="text-lg font-bold tracking-tight text-zinc-100 dark:text-zinc-100">Zdrive</div>
        <nav class="hidden md:flex items-center gap-8 h-full" id="stepper">
            <div class="step-nav cursor-pointer transition-opacity flex flex-col items-center" data-step="1">
                <span class="text-violet-400 border-b-2 border-violet-500 pb-4 mt-1">Upload</span>
            </div>
            <div class="step-nav cursor-pointer transition-opacity flex flex-col items-center" data-step="2">
                <span class="text-zinc-400 pb-4 mt-1 hover:text-zinc-200 transition-colors">Configuration</span>
            </div>
            <div class="step-nav cursor-pointer transition-opacity flex flex-col items-center" data-step="3">
                <span class="text-zinc-400 pb-4 mt-1 hover:text-zinc-200 transition-colors">Preview</span>
            </div>
            <div class="step-nav cursor-pointer transition-opacity flex flex-col items-center" data-step="4">
                <span class="text-zinc-400 pb-4 mt-1 hover:text-zinc-200 transition-colors">Import</span>
            </div>
        </nav>
        <div class="flex items-center gap-4">
            <span class="material-symbols-outlined text-zinc-400 cursor-pointer" data-icon="help_outline">help_outline</span>
            <span class="material-symbols-outlined text-zinc-400 cursor-pointer" data-icon="close">close</span>
        </div>
    </header>
    <main class="flex-1 flex items-center justify-center p-4 md:p-8 overflow-hidden">
        <div class="w-full max-w-6xl bg-zinc-900/50 border border-zinc-800 rounded-xl shadow-2xl backdrop-blur-xl flex flex-col h-[819px]">
            <!-- STEP 1: UPLOAD -->
            <div class="step-content active flex-1 flex-col items-center justify-center p-10" id="step-1">
                <div class="max-w-xl w-full text-center">
                    <div class="group border-2 border-dashed border-zinc-700 hover:border-violet-500 bg-zinc-950/20 rounded-2xl p-16 transition-all cursor-pointer" id="upload-zone">
                        <span class="material-symbols-outlined text-6xl text-zinc-600 group-hover:text-violet-400 mb-4 transition-colors" data-icon="cloud_upload">cloud_upload</span>
                        <h3 class="text-xl font-bold mb-2">Glissez votre fichier ici</h3>
                        <p class="text-zinc-500 text-sm">Ou cliquez pour parcourir vos dossiers (CSV, XLSX)</p>
                        <div class="hidden mt-6 flex items-center justify-center gap-3 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-lg" id="file-ready">
                            <span class="material-symbols-outlined text-emerald-500" data-icon="check_circle">check_circle</span>
                            <div class="text-left">
                                <div class="text-xs font-bold text-emerald-400">inventory_q4_final.csv</div>
                                <div class="text-[10px] text-emerald-400/70 uppercase">Fichier prêt • 2.4 MB</div>
                            </div>
                        </div>
                        <input type="file" id="fileInput" class="hidden" accept=".xlsx,.csv">
                    </div>
                </div>
            </div>
            <!-- STEP 2: CONFIGURATION & MAPPING -->
            <div class="step-content flex-1 overflow-y-auto p-6 md:p-10 flex-col" id="step-2">
                <div class="grid grid-cols-12 gap-6 h-full">
                    <!-- Config Card -->
                    <div class="col-span-12 md:col-span-4 flex flex-col gap-6">
                        <div class="bg-zinc-950/40 border border-zinc-800/50 p-6 rounded-xl space-y-6">
                            <h3 class="text-xs uppercase tracking-widest text-zinc-500 font-bold">Cible de destination</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-semibold text-zinc-400 mb-1.5">Entrepôt Cible</label>
                                    <select class="w-full bg-zinc-900 border-zinc-800 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500">
                                        <option>Data Warehouse Principal</option>
                                        <option>Archive Froide S3</option>
                                        <option>PostgreSQL Production</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-zinc-400 mb-1.5">Table Cible</label>
                                    <select class="w-full bg-zinc-900 border-zinc-800 text-sm rounded-lg focus:ring-violet-500 focus:border-violet-500">
                                        <option>dim_products</option>
                                        <option>stg_inventory</option>
                                        <option>fact_sales</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-zinc-950/40 border border-zinc-800/50 p-6 rounded-xl">
                            <h3 class="text-xs uppercase tracking-widest text-zinc-500 font-bold mb-4">Statut de l'analyse</h3>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-zinc-400">Total lignes</span>
                                    <span class="text-xl font-bold">120</span>
                                </div>
                                <div class="w-full h-2 bg-zinc-800 rounded-full overflow-hidden flex">
                                    <div class="h-full bg-emerald-500" style="width: 91.6%"></div>
                                    <div class="h-full bg-rose-500" style="width: 8.4%"></div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-emerald-500/10 border border-emerald-500/20 p-3 rounded-lg text-center">
                                        <div class="text-emerald-500 font-bold text-lg">110</div>
                                        <div class="text-[10px] uppercase text-emerald-400/70 font-semibold">Valides</div>
                                    </div>
                                    <div class="bg-rose-500/10 border border-rose-500/20 p-3 rounded-lg text-center">
                                        <div class="text-rose-500 font-bold text-lg">10</div>
                                        <div class="text-[10px] uppercase text-rose-400/70 font-semibold">Erreurs</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Mapping Table Card -->
                    <div class="col-span-12 md:col-span-8 bg-zinc-950/40 border border-zinc-800/50 rounded-xl overflow-hidden flex flex-col">
                        <div class="p-6 border-b border-zinc-800/50 flex justify-between items-center bg-zinc-900/20">
                            <div>
                                <h2 class="text-lg font-bold">Mapping intelligent</h2>
                                <p class="text-xs text-zinc-500 mt-1">Liez vos colonnes de fichier aux champs de destination.</p>
                            </div>
                            <span class="px-3 py-1 bg-violet-500/10 border border-violet-500/30 text-violet-400 text-[10px] font-bold rounded-full uppercase tracking-tighter">Auto-mappé (90%)</span>
                        </div>
                        <div class="flex-1 overflow-y-auto">
                            <table class="w-full text-left border-collapse">
                                <thead class="bg-zinc-900/50 sticky top-0 z-10">
                                    <tr>
                                        <th class="px-6 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Champ Destination</th>
                                        <th class="px-6 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-widest text-center">Liaison</th>
                                        <th class="px-6 py-3 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">Colonne Source</th>
                                    </tr>
                                </thead>
                                <tbody id="mapping-body" class="divide-y divide-zinc-800/50">
                                    <tr class="hover:bg-zinc-800/20 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-violet-500"></span>
                                                <span class="text-sm font-semibold text-zinc-200">Nom Produit</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="material-symbols-outlined text-zinc-600 text-sm" data-icon="sync_alt">sync_alt</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <select class="bg-zinc-900 border-zinc-800 text-xs rounded-lg w-full focus:ring-violet-500 focus:border-violet-500">
                                                <option>Nom</option>
                                                <option>Product_Title</option>
                                                <option>item_name</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-zinc-800/20 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-violet-500"></span>
                                                <span class="text-sm font-semibold text-zinc-200">SKU</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="material-symbols-outlined text-zinc-600 text-sm" data-icon="sync_alt">sync_alt</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <select class="bg-zinc-900 border-zinc-800 text-xs rounded-lg w-full focus:ring-violet-500 focus:border-violet-500">
                                                <option>SKU</option>
                                                <option>ID</option>
                                                <option>Code_Article</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-zinc-800/20 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2">
                                                <span class="w-2 h-2 rounded-full bg-zinc-600"></span>
                                                <span class="text-sm font-semibold text-zinc-400">Prix unitaire</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="material-symbols-outlined text-zinc-600 text-sm" data-icon="sync_alt">sync_alt</span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <select class="bg-zinc-900 border-zinc-800 text-xs rounded-lg w-full focus:ring-violet-500 focus:border-violet-500">
                                                <option value="">Sélectionner une colonne...</option>
                                                <option>Price</option>
                                                <option>Tarif_HT</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- STEP 3: PREVIEW -->
            <div class="step-content flex-1 overflow-y-auto p-6 md:p-10 flex-col" id="step-3">
                <div class="col-span-12 bg-zinc-950/40 border border-zinc-800/50 rounded-xl overflow-hidden p-6 h-full flex flex-col">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold">Aperçu des données finales</h3>
                        <div class="flex gap-2">
                            <button class="px-3 py-1.5 text-[10px] font-bold bg-rose-500/20 text-rose-400 rounded-lg border border-rose-500/30">Voir Erreurs (10)</button>
                            <button class="px-3 py-1.5 text-[10px] font-bold bg-zinc-800 text-zinc-400 rounded-lg">Tout afficher</button>
                        </div>
                    </div>
                    <div class="flex-1 border border-zinc-800 rounded-lg overflow-hidden bg-zinc-900/30">
                        <table class="w-full text-xs text-left">
                            <thead id="preview-head" class="bg-zinc-950 text-zinc-500 uppercase"></thead>

                            <tbody id="preview-body" class="divide-y divide-zinc-800">
                                <!-- dynamique -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- STEP 4: LOADING / SUCCESS -->
            <div class="step-content flex-1 flex-col items-center justify-center p-10" id="step-4">
                <div class="flex flex-col items-center gap-6" id="loading-state">
                    <div class="relative w-20 h-20">
                        <div class="absolute inset-0 border-4 border-violet-500/20 rounded-full"></div>
                        <div class="absolute inset-0 border-4 border-t-violet-500 rounded-full animate-spin"></div>
                    </div>
                    <div class="text-center">
                        <h3 class="text-xl font-bold">Importation en cours...</h3>
                        <p class="text-zinc-500 text-sm mt-1">Nous traitons vos données sécurisées.</p>
                    </div>
                </div>
                <div class="hidden flex flex-col items-center gap-6" id="success-state">
                    <div class="w-24 h-24 bg-emerald-500/20 rounded-full flex items-center justify-center border-4 border-emerald-500/40">
                        <span class="material-symbols-outlined text-emerald-400 text-5xl" data-icon="done_all">done_all</span>
                    </div>
                    <div class="text-center">
                        <h3 class="text-3xl font-bold">Succès !</h3>
                        <p class="text-zinc-400 text-lg mt-2">110 produits ont été importés avec succès.</p>
                    </div>
                    <button class="mt-4 px-8 py-3 bg-zinc-800 text-white rounded-lg font-bold hover:bg-zinc-700 transition-colors" onclick="location.reload()">Retour à l'accueil</button>
                </div>
            </div>
        </div>
    </main>
    <footer class="fixed bottom-0 left-0 w-full z-50 flex justify-between items-center px-8 py-4 bg-zinc-900/80 backdrop-blur-md border-t border-zinc-800 shadow-lg transition-transform duration-300" id="footer-actions">
        <button class="bg-zinc-800 text-zinc-400 rounded-lg px-6 py-2 flex items-center gap-2 font-sans font-semibold text-xs uppercase tracking-widest hover:brightness-110 transition-all opacity-50 cursor-not-allowed" id="btn-prev">
            <span class="material-symbols-outlined" data-icon="arrow_back">arrow_back</span>
            Précédent
        </button>
        <div class="flex items-center gap-4">
            <button class="text-zinc-500 hover:text-zinc-300 transition-colors text-xs font-bold uppercase tracking-widest" onclick="location.reload()">Annuler</button>
            <button class="bg-violet-600 text-white rounded-lg px-6 py-2 flex items-center gap-2 font-sans font-semibold text-xs uppercase tracking-widest hover:brightness-110 transition-all active:scale-95 duration-150" id="btn-next">
                <span id="next-text">Suivant</span>
                <span class="material-symbols-outlined" data-icon="arrow_forward" id="next-icon">arrow_forward</span>
            </button>
        </div>
    </footer>
    <script src="<?= asset('js/import/app.js') ?>"></script>

    </script>
</body>

</html>
