   <?php \Core\Vue::extends('layouts.principale') ?>
   <?php \Core\Vue::debut_section('head') ?>

   <?php \Core\Vue::fin_section('head') ?>
   <?php \Core\Vue::debut_section('contenu') ?>

   <main class="relative overflow-hidden hero-pattern min-h-[85vh] flex items-center theme-transition">
       <!-- Floating Decorative Elements -->
       <div class="absolute top-20 -left-20 w-96 h-96 bg-primary-container opacity-10 rounded-full blur-3xl"></div>
       <div class="absolute bottom-10 -right-20 w-[500px] h-[500px] bg-tertiary-container opacity-10 rounded-full blur-3xl"></div>
       <div class="max-w-container-max mx-auto px-gutter grid grid-cols-1 lg:grid-cols-12 gap-gutter items-center relative z-10">
           <!-- Text Content -->
           <div class="lg:col-span-7 flex flex-col gap-6">
               <div class="inline-flex items-center gap-2 px-3 py-1 bg-surface-container-high dark:bg-inverse-surface rounded-full border border-outline-variant dark:border-on-surface-variant/30 w-fit">
                   <span class="flex h-2 w-2 rounded-full bg-primary dark:bg-primary-fixed"></span>
                   <span class="text-label-mono font-label-mono text-on-surface-variant dark:text-surface-variant uppercase tracking-wider">Enterprise Ready v4.0</span>
               </div>
               <h1 class="font-display-lg text-display-lg text-on-surface dark:text-surface-bright tracking-tight leading-tight">
                   Maîtrisez votre stock, <br />
                   <span class="text-primary dark:text-primary-fixed">partout, tout le temps.</span>
               </h1>
               <p class="text-body-md font-body-md text-on-surface-variant dark:text-surface-variant max-w-2xl">
                   Optimisez la visibilité de vos actifs à travers plusieurs sites et entités. Notre plateforme centralisée transforme la complexité logistique en efficacité opérationnelle pour les entreprises multi-sociétés.
               </p>
               <div class="flex flex-col sm:flex-row items-center gap-4 pt-4">
                   <button class="w-full sm:w-auto px-8 py-4 bg-primary dark:bg-primary-fixed dark:text-on-primary-fixed rounded-xl font-semibold text-body-md hover:shadow-xl transition-all flex items-center justify-center gap-2 group active:scale-95">
                       Démarrer l'essai gratuit
                       <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                   </button>
                   <button class="w-full sm:w-auto px-8 py-4 border border-outline dark:border-outline-variant text-primary dark:text-primary-fixed rounded-xl font-semibold text-body-md hover:bg-surface-container-low dark:hover:bg-on-surface-variant/10 transition-all active:scale-95">
                       Voir la démo
                   </button>
               </div>
               <!-- Trust Badges -->
               <div class="pt-8 flex flex-col gap-4">
                   <p class="text-label-mono font-label-mono text-outline dark:text-surface-variant uppercase tracking-widest">Utilisé par les leaders de l'industrie</p>
                   <div class="flex flex-wrap items-center gap-8 grayscale opacity-60 dark:opacity-40">
                       <div class="font-title-md text-on-surface-variant dark:text-surface-bright tracking-tighter">GLOBAL LOGISTICS</div>
                       <div class="font-title-md text-on-surface-variant dark:text-surface-bright tracking-tighter">CORP-WAREHOUSE</div>
                       <div class="font-title-md text-on-surface-variant dark:text-surface-bright tracking-tighter">SUPPLY.AI</div>
                   </div>
               </div>
           </div>
           <!-- Hero Visual (Bento-style Card) -->
           <div class="lg:col-span-5 relative">
               <div class="bg-surface-container-lowest dark:bg-inverse-surface border border-outline-variant dark:border-on-surface-variant/30 rounded-xl shadow-2xl p-6 relative overflow-hidden group theme-transition">
                   <!-- Dashboard Mockup Header -->
                   <div class="flex items-center justify-between mb-8 border-b border-surface-variant dark:border-on-surface-variant/20 pb-4">
                       <div class="flex gap-2">
                           <div class="w-3 h-3 rounded-full bg-error/20"></div>
                           <div class="w-3 h-3 rounded-full bg-primary-container/20"></div>
                           <div class="w-3 h-3 rounded-full bg-surface-variant"></div>
                       </div>
                       <div class="text-label-mono font-label-mono text-outline dark:text-surface-variant">Real-time Analytics</div>
                   </div>
                   <div class="grid grid-cols-2 gap-4">
                       <div class="col-span-2 h-40 rounded-xl bg-surface-container-low dark:bg-on-surface/40 overflow-hidden relative">
                           <img alt="Professional warehouse logistics" class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-700" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCk-X9hbfxdFKxIpi2ApuYeRt9CgqkS4ytAe09V3_LLKLqS49VYQUOMM67o7McBxDY6ZHAVcmTdg6ZDQgRuiWWdZoLJoDBN_VCgA5t2zlO-WndiOXSA_ouKFyfJXb9orr3AKebXB9YTh1pBQ57GIhl0XmAVzivV5A8VHrDThX-ZGNqtqhtfPjeUlcZUdqQ3GoFFMe735wOJyLpw3aCBWCRysOwW_MiTy-c9EKycq5wi7EE9L8L7fjq0djl7-arM5O-P_trYCIRzH3QZ" />
                           <div class="absolute inset-0 bg-gradient-to-t from-primary/40 to-transparent"></div>
                           <div class="absolute bottom-4 left-4 text-on-primary">
                               <p class="text-body-sm font-medium">Global Inventory</p>
                               <p class="text-title-md">98.4% Accuracy</p>
                           </div>
                       </div>
                       <div class="h-24 rounded-xl border border-outline-variant dark:border-on-surface-variant/30 p-4 flex flex-col justify-between">
                           <span class="material-symbols-outlined text-primary dark:text-primary-fixed" style="font-variation-settings: 'FILL' 1;">trending_up</span>
                           <div>
                               <p class="text-[10px] text-outline dark:text-surface-variant uppercase font-bold">Optimisation</p>
                               <p class="text-title-md text-primary dark:text-primary-fixed">+12%</p>
                           </div>
                       </div>
                       <div class="h-24 rounded-xl bg-primary-container dark:bg-primary-fixed p-4 flex flex-col justify-between">
                           <span class="material-symbols-outlined text-on-primary dark:text-on-primary-fixed" style="font-variation-settings: 'FILL' 1;">hub</span>
                           <div>
                               <p class="text-[10px] text-on-primary-container dark:text-on-primary-fixed-variant uppercase font-bold">Nodes Connected</p>
                               <p class="text-title-md text-on-primary dark:text-on-primary-fixed">245</p>
                           </div>
                       </div>
                   </div>
                   <!-- Overlaying Detail Card -->
                   <div class="absolute -bottom-4 -right-4 bg-surface-bright dark:bg-surface-container-high border border-outline-variant dark:border-on-surface-variant/40 shadow-xl p-4 rounded-xl max-w-[180px] animate-bounce-slow theme-transition">
                       <div class="flex items-center gap-2 mb-1">
                           <span class="material-symbols-outlined text-primary dark:text-primary-fixed text-sm">check_circle</span>
                           <span class="text-body-sm font-bold text-on-surface dark:text-surface-bright">In Sync</span>
                       </div>
                       <p class="text-[11px] text-on-surface-variant dark:text-surface-variant leading-tight">All 14 warehouses updated 2s ago.</p>
                   </div>
               </div>
           </div>
       </div>
   </main>
   <?php \Core\Vue::fin_section('contenu') ?>
