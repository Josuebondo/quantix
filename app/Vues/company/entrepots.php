<div class="flex-none px-4 md:px-6 py-4 border-b border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark transition-colors duration-200" id="main-header">
    <div class="flex items-center gap-1 md:gap-2 mb-3 text-xs md:text-sm overflow-x-auto whitespace-nowrap scrollbar-hide">
        <a class="text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary-400 transition-colors" href="#">Documents</a>
        <span class="material-symbols-outlined text-[16px] text-slate-400">chevron_right</span>
        <a class="text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-primary-400 transition-colors" href="#">Comptabilité</a>
        <span class="material-symbols-outlined text-[16px] text-slate-400">chevron_right</span>
        <span class="text-slate-900 dark:text-white font-medium">Factures 2023</span>
    </div>
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex-1">
            <h1 class="text-xl md:text-2xl font-bold text-slate-900 dark:text-white tracking-tight">Factures 2023</h1>
            <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1 line-clamp-1 md:line-clamp-none">Gérez et organisez vos documents comptables pour l'année fiscale en cours.</p>
        </div>
        <div class="flex items-center gap-2 md:gap-3 w-full md:w-auto">
            <button id="open-create-folder" class="flex-1 md:flex-none flex items-center justify-center gap-2 h-9 md:h-10 px-4 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-700/80 hover:text-primary dark:hover:text-white transition-colors">
                <span class="material-symbols-outlined text-[20px]">create_new_folder</span>
                <span class="">Dossier</span>
            </button>
            <button id="main-header-upload-btn" class="flex-1 md:flex-none flex items-center justify-center gap-2 h-9 md:h-10 px-4 rounded-lg bg-primary hover:bg-primary-dark text-white text-sm font-medium transition-colors shadow-sm shadow-blue-500/20 relative overflow-hidden">
                <span class="material-symbols-outlined text-[20px]">upload_file</span>
                <span>Téléverser</span>
                <input id="main-header-file-input" type="file" multiple class="absolute inset-0 opacity-0 cursor-pointer" />
            </button>
        </div>
    </div>
</div>
<div class="flex-none px-4 md:px-6 py-3 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4 bg-white/50 dark:bg-surface-dark/95 backdrop-blur-sm border-b border-border-light dark:border-border-dark z-10 sticky top-0">
    <div class="relative w-full md:w-96 group">
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <span class="material-symbols-outlined text-slate-400 dark:text-slate-500 text-[20px] group-focus-within:text-primary transition-colors">search</span>
        </div>
        <input class="block w-full pl-10 pr-3 py-2 border border-slate-200 dark:border-slate-700 rounded-lg leading-5 bg-white dark:bg-slate-800/50 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary dark:focus:border-primary sm:text-sm transition-all" placeholder="Rechercher..." type="text" />
    </div>
    <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-1 md:pb-0 scrollbar-hide">
        <button class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 border border-transparent hover:border-slate-300 dark:hover:border-slate-600 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors whitespace-nowrap">
            Type
            <span class="material-symbols-outlined text-[16px]">expand_more</span>
        </button>
        <button class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 border border-transparent hover:border-slate-300 dark:hover:border-slate-600 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors whitespace-nowrap">
            Date
            <span class="material-symbols-outlined text-[16px]">expand_more</span>
        </button>
        <button class="flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 dark:bg-slate-800 border border-transparent hover:border-slate-300 dark:hover:border-slate-600 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors whitespace-nowrap">
            Propriétaire
            <span class="material-symbols-outlined text-[16px]">expand_more</span>
        </button>
        <div class="hidden sm:block w-px h-6 bg-slate-200 dark:bg-slate-700 mx-1"></div>
        <div class="hidden sm:flex items-center gap-1">
            <button class="p-1.5 text-slate-400 dark:text-slate-500 hover:text-primary dark:hover:text-primary-400 transition-colors rounded-md hover:bg-slate-100 dark:hover:bg-slate-800">
                <span class="material-symbols-outlined text-[20px]">view_list</span>
            </button>
            <button class="p-1.5 text-primary dark:text-primary-400 bg-blue-50 dark:bg-blue-900/20 transition-colors rounded-md">
                <span class="material-symbols-outlined text-[20px]">grid_view</span>
            </button>
        </div>
    </div>
</div>