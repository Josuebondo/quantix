<section class="px-4 py-8 sm:px-8">
    <!-- Page Header -->
    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4 mb-8">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-primary dark:text-primary-fixed mb-2">Administration</p>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-on-surface dark:text-inverse-on-surface mb-2">Teams</h1>
            <p class="font-body-md text-body-md text-on-surface-variant dark:text-surface-variant">Gérez les utilisateurs, invitations et rôles de votre entreprise.</p>
        </div>
        <button class="h-11 px-6 bg-primary hover:bg-primary-container dark:bg-primary-fixed dark:hover:bg-primary-fixed/90 text-on-primary dark:text-on-primary-fixed rounded-xl font-semibold text-sm flex items-center justify-center gap-2 transition-colors shadow-lg shadow-primary/20 dark:shadow-primary/10" id="btnInviteUser" @click="openInvitationModal()">
            <span class="material-symbols-outlined text-base">add</span> Inviter un utilisateur
        </button>
    </div>
    <!-- Tabs -->
    <div class="flex border-b border-outline-variant dark:border-outline mb-8 space-x-4 sm:space-x-8 overflow-x-auto scrollbar-hide" id="tabsContainer">
        <button class="tab-btn pb-3 flex items-center gap-2 whitespace-nowrap border-b-2 transition-colors" :class="activeTab === 'users' ? 'text-primary dark:text-primary-fixed font-bold border-primary dark:border-primary-fixed' : 'text-on-surface-variant dark:text-surface-variant border-transparent hover:text-primary dark:hover:text-primary-fixed'" @click="selectTab('users')">
            <span class="material-symbols-outlined">group</span> Utilisateurs
        </button>
        <button class="tab-btn pb-3 flex items-center gap-2 whitespace-nowrap border-b-2 transition-colors" :class="activeTab === 'invitations' ? 'text-primary dark:text-primary-fixed font-bold border-primary dark:border-primary-fixed' : 'text-on-surface-variant dark:text-surface-variant border-transparent hover:text-primary dark:hover:text-primary-fixed'" @click="selectTab('invitations')">
            <span class="material-symbols-outlined">mail</span> Invitations
        </button>
        <button class="tab-btn pb-3 flex items-center gap-2 whitespace-nowrap border-b-2 transition-colors" :class="activeTab === 'roles' ? 'text-primary dark:text-primary-fixed font-bold border-primary dark:border-primary-fixed' : 'text-on-surface-variant dark:text-surface-variant border-transparent hover:text-primary dark:hover:text-primary-fixed'" @click="selectTab('roles')">
            <span class="material-symbols-outlined">shield_person</span> Rôles &amp; Permissions
        </button>
    </div>
    <!-- Tab Content: Users -->
    <div class="tab-pane" x-show="activeTab === 'users'" x-transition>
        <!-- KPI Cards - Responsive Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mb-8">
            <div class="bg-surface-container-lowest dark:bg-inverse-surface border border-outline-variant dark:border-outline rounded-2xl p-6 shadow-sm flex items-center gap-4 transition-colors">
                <div class="w-12 h-12 rounded-full bg-primary-fixed flex items-center justify-center text-primary shrink-0">
                    <span class="material-symbols-outlined text-2xl">group</span>
                </div>
                <div>
                    <div class="font-body-sm text-body-sm text-on-surface-variant dark:text-surface-variant mb-1">Utilisateurs actifs</div>
                    <div class="text-3xl font-bold text-on-surface dark:text-inverse-on-surface">12</div>
                    <div class="font-body-sm text-body-sm text-[#22C55E] flex items-center gap-1 mt-1"><span class="material-symbols-outlined text-[14px]">trending_up</span> +2 ce mois-ci</div>
                </div>
            </div>
            <div class="bg-surface-container-lowest dark:bg-inverse-surface border border-outline-variant dark:border-outline rounded-2xl p-6 shadow-sm flex items-center gap-4 transition-colors">
                <div class="w-12 h-12 rounded-full bg-[#FFF7ED] dark:bg-[#431407] flex items-center justify-center text-[#EA580C] dark:text-[#FDBA74] shrink-0">
                    <span class="material-symbols-outlined text-2xl">mail</span>
                </div>
                <div>
                    <div class="font-body-sm text-body-sm text-on-surface-variant dark:text-surface-variant mb-1">Invitations en attente</div>
                    <div class="text-3xl font-bold text-on-surface dark:text-inverse-on-surface">4</div>
                    <div class="font-body-sm text-body-sm text-error flex items-center gap-1 mt-1"><span class="material-symbols-outlined text-[14px]">trending_down</span> -1 ce mois-ci</div>
                </div>
            </div>
            <div class="bg-surface-container-lowest dark:bg-inverse-surface border border-outline-variant dark:border-outline rounded-2xl p-6 shadow-sm flex items-center gap-4 transition-colors">
                <div class="w-12 h-12 rounded-full bg-[#F0FDF4] dark:bg-[#052E16] flex items-center justify-center text-[#16A34A] dark:text-[#86EFAC] shrink-0">
                    <span class="material-symbols-outlined text-2xl">verified_user</span>
                </div>
                <div>
                    <div class="font-body-sm text-body-sm text-on-surface-variant dark:text-surface-variant mb-1">Rôles définis</div>
                    <div class="text-3xl font-bold text-on-surface dark:text-inverse-on-surface">5</div>
                    <div class="font-body-sm text-body-sm text-on-surface-variant dark:text-surface-variant mt-1">Aucun changement</div>
                </div>
            </div>
            <div class="bg-surface-container-lowest dark:bg-inverse-surface border border-outline-variant dark:border-outline rounded-2xl p-6 shadow-sm flex items-center gap-4 transition-colors">
                <div class="w-12 h-12 rounded-full bg-[#FAF5FF] dark:bg-[#3B0764] flex items-center justify-center text-[#9333EA] dark:text-[#D8B4FE] shrink-0">
                    <span class="material-symbols-outlined text-2xl">person</span>
                </div>
                <div>
                    <div class="font-body-sm text-body-sm text-on-surface-variant dark:text-surface-variant mb-1">Total utilisateurs</div>
                    <div class="text-3xl font-bold text-on-surface dark:text-inverse-on-surface">16</div>
                    <div class="font-body-sm text-body-sm text-[#22C55E] flex items-center gap-1 mt-1"><span class="material-symbols-outlined text-[14px]">trending_up</span> +3 ce mois-ci</div>
                </div>
            </div>
        </div>
        <!-- Filters & Actions -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-6">
            <div class="flex flex-wrap items-center gap-3">
                <div class="relative w-full sm:w-64">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input class="w-full h-11 pl-10 pr-3 rounded-xl border border-outline-variant dark:border-outline bg-surface-container-lowest dark:bg-inverse-surface text-body-md focus:border-primary focus:ring-1 focus:ring-primary transition-colors text-on-surface dark:text-inverse-on-surface" placeholder="Rechercher un utilisateur..." type="text" />
                </div>
                <div class="relative w-full sm:w-auto">
                    <select class="w-full h-11 pl-3 pr-8 rounded-xl border border-outline-variant dark:border-outline bg-surface-container-lowest dark:bg-inverse-surface text-on-surface dark:text-inverse-on-surface text-body-md appearance-none focus:border-primary focus:ring-1 focus:ring-primary min-w-[120px] transition-colors">
                        <option>Rôle: Tous</option>
                    </select>
                    <span class="material-symbols-outlined absolute right-2 top-1/2 -translate-y-1/2 pointer-events-none text-outline">expand_more</span>
                </div>
                <button class="h-11 px-4 border border-outline-variant dark:border-outline rounded-xl bg-surface-container-lowest dark:bg-inverse-surface text-on-surface dark:text-inverse-on-surface flex items-center gap-2 hover:bg-surface-container-low dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors text-body-md">
                    <span class="material-symbols-outlined text-sm">tune</span> Filtres
                </button>
            </div>
            <div class="flex items-center gap-2">
                <button class="h-11 flex-1 sm:flex-none px-4 border border-outline-variant dark:border-outline rounded-xl bg-surface-container-lowest dark:bg-inverse-surface text-on-surface dark:text-inverse-on-surface flex items-center justify-center gap-2 hover:bg-surface-container-low dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors text-body-md">
                    <span class="material-symbols-outlined text-sm">download</span> Exporter
                </button>
                <div class="flex border border-outline-variant dark:border-outline rounded-xl bg-surface-container-lowest dark:bg-inverse-surface overflow-hidden h-11 transition-colors">
                    <button class="px-3 bg-surface-variant dark:bg-outline text-on-surface dark:text-inverse-on-surface flex items-center justify-center border-r border-outline-variant dark:border-outline"><span class="material-symbols-outlined text-sm">grid_view</span></button>
                    <button class="px-3 text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-low dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed flex items-center justify-center"><span class="material-symbols-outlined text-sm">format_list_bulleted</span></button>
                </div>
            </div>
        </div>
        <!-- Table Container - Scrollable -->
        <div class="bg-surface-container-lowest dark:bg-inverse-surface border border-outline-variant dark:border-outline rounded-2xl shadow-sm overflow-x-auto transition-colors">
            <table class="w-full text-left text-body-md whitespace-nowrap min-w-[900px]">
                <thead class="bg-surface-container-low dark:bg-surface-dark border-b border-outline-variant dark:border-outline text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-surface-variant">
                    <tr>
                        <th class="py-4 px-6 font-semibold">UTILISATEUR</th>
                        <th class="py-4 px-6 font-semibold">RÔLE</th>
                        <th class="py-4 px-6 font-semibold">SITE / ENTREPÔT</th>
                        <th class="py-4 px-6 font-semibold">STATUT</th>
                        <th class="py-4 px-6 font-semibold">DERNIÈRE CONNEXION</th>
                        <th class="py-4 px-6 font-semibold">AJOUTÉ LE</th>
                        <th class="py-4 px-6 font-semibold text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant dark:divide-outline">
                    <!-- Row 1 -->
                    <tr class="hover:bg-surface-container-low dark:hover:bg-surface-variant/20 transition-colors group">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <img alt="John Owner" class="w-10 h-10 rounded-full object-cover shrink-0" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDjfq48RrZIj-zBN5CcqBHzKB0_vfOFQMvVofWPBDvrPP5gas4Qqu6d5nidIUBL7qVmeHEyP2CqDckqVAajqu24LzapZX9gJAMrzsaQ2_hBeAKFdz2Ha_6Q4xI0-BJcIsq6TI382aLASORX5h9ELo6g2B9v7zC9oQXTf1Jf_0QcgGKX0jAsEdZJVwPSFKtUZVoVGumjQwhF-vuEw2t8iMhO8f3X57FbKGaWnKYNNAZeBw4A_PB0sYEfnPgOx9RPCnSuFRkgtGl_g_Wv" />
                                <div>
                                    <div class="text-sm font-bold text-on-surface dark:text-inverse-on-surface flex items-center gap-2">John Owner <span class="bg-primary-fixed text-primary px-2 py-0.5 rounded text-xs font-medium">Vous</span></div>
                                    <div class="text-on-surface-variant dark:text-surface-variant text-sm">owner@acme.cd</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-primary-fixed text-primary">Owner</span>
                        </td>
                        <td class="py-4 px-6 text-on-surface dark:text-inverse-on-surface">Tous les entrepôts</td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-[#DCFCE7] dark:bg-[#052E16] text-[#16A34A] dark:text-[#86EFAC]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A] dark:bg-[#86EFAC]"></span> Actif
                            </span>
                        </td>
                        <td class="py-4 px-6 text-on-surface-variant dark:text-surface-variant">Aujourd'hui, 09:42</td>
                        <td class="py-4 px-6 text-on-surface-variant dark:text-surface-variant">10/06/2026</td>
                        <td class="py-4 px-6 text-right relative">
                            <button class="p-2 hover:bg-surface-container-high dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed rounded-full text-on-surface-variant dark:text-surface-variant transition-colors action-btn" data-menu="menu-1">
                                <span class="material-symbols-outlined pointer-events-none">more_vert</span>
                            </button>
                            <div class="absolute right-8 top-10 w-48 bg-surface-container-lowest dark:bg-inverse-surface border border-outline-variant dark:border-outline rounded-xl shadow-lg py-2 z-10 hidden transition-colors action-menu" id="menu-1">
                                <button class="w-full text-left px-4 py-2 text-body-md text-on-surface dark:text-inverse-on-surface hover:bg-surface-container-low dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">visibility</span> Voir le profil
                                </button>
                                <button class="w-full text-left px-4 py-2 text-body-md text-on-surface dark:text-inverse-on-surface hover:bg-surface-container-low dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">edit</span> Modifier
                                </button>
                                <div class="h-px bg-outline-variant dark:bg-outline my-1"></div>
                                <button class="w-full text-left px-4 py-2 text-body-md text-error hover:bg-error-container/50 dark:hover:bg-error-container/20 hover:text-danger dark:hover:text-red-300 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">person_off</span> Désactiver
                                </button>
                            </div>
                        </td>
                    </tr>
                    <!-- Row 2 -->
                    <tr class="hover:bg-surface-container-low dark:hover:bg-surface-variant/20 transition-colors group">
                        <td class="py-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-[#DBEAFE] dark:bg-[#1E3A8A] text-[#1E3A8A] dark:text-[#DBEAFE] flex items-center justify-center font-bold text-sm shrink-0">MK</div>
                                <div>
                                    <div class="text-sm font-bold text-on-surface dark:text-inverse-on-surface">Marie Kayembe</div>
                                    <div class="text-on-surface-variant dark:text-surface-variant text-sm">marie@acme.cd</div>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#E0E7FF] dark:bg-[#312E81] text-[#4338CA] dark:text-[#A5B4FC]">Admin</span>
                        </td>
                        <td class="py-4 px-6 text-on-surface dark:text-inverse-on-surface">Entrepôt Central</td>
                        <td class="py-4 px-6">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-[#DCFCE7] dark:bg-[#052E16] text-[#16A34A] dark:text-[#86EFAC]">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#16A34A] dark:bg-[#86EFAC]"></span> Actif
                            </span>
                        </td>
                        <td class="py-4 px-6 text-on-surface-variant dark:text-surface-variant">Hier, 16:20</td>
                        <td class="py-4 px-6 text-on-surface-variant dark:text-surface-variant">12/06/2026</td>
                        <td class="py-4 px-6 text-right relative">
                            <button class="p-2 hover:bg-surface-container-high dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed rounded-full text-on-surface-variant dark:text-surface-variant transition-colors action-btn" data-menu="menu-2">
                                <span class="material-symbols-outlined pointer-events-none">more_vert</span>
                            </button>
                            <div class="absolute right-8 top-10 w-48 bg-surface-container-lowest dark:bg-inverse-surface border border-outline-variant dark:border-outline rounded-xl shadow-lg py-2 z-10 hidden transition-colors action-menu" id="menu-2">
                                <button class="w-full text-left px-4 py-2 text-body-md text-on-surface dark:text-inverse-on-surface hover:bg-surface-container-low dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">visibility</span> Voir le profil
                                </button>
                                <button class="w-full text-left px-4 py-2 text-body-md text-on-surface dark:text-inverse-on-surface hover:bg-surface-container-low dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">edit</span> Modifier
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-outline-variant dark:border-outline flex flex-wrap items-center justify-between gap-4">
                <span class="text-body-sm text-on-surface-variant dark:text-surface-variant">Affichage de 1 à 2 sur 12 utilisateurs</span>
                <div class="flex items-center gap-2">
                    <button class="w-8 h-8 rounded border border-outline-variant dark:border-outline flex items-center justify-center text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-low dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed disabled:opacity-50"><span class="material-symbols-outlined text-sm">chevron_left</span></button>
                    <button class="w-8 h-8 rounded bg-primary text-on-primary flex items-center justify-center text-sm font-medium">1</button>
                    <button class="w-8 h-8 rounded border border-outline-variant dark:border-outline flex items-center justify-center text-on-surface dark:text-inverse-on-surface hover:bg-surface-container-low dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed text-sm font-medium">2</button>
                    <button class="w-8 h-8 rounded border border-outline-variant dark:border-outline flex items-center justify-center text-on-surface-variant dark:text-surface-variant hover:bg-surface-container-low dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed"><span class="material-symbols-outlined text-sm">chevron_right</span></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Tab Content: Invitations -->
    <div class="tab-pane" id="tab-invitations" x-show="activeTab === 'invitations'" x-transition>
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <div class="relative w-full sm:w-64">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                <input class="w-full h-11 pl-10 pr-3 rounded-xl border border-outline-variant dark:border-outline bg-surface-container-lowest dark:bg-inverse-surface text-body-md focus:border-primary focus:ring-1 focus:ring-primary transition-colors text-on-surface dark:text-inverse-on-surface" placeholder="Rechercher une invitation..." type="text" />
            </div>
            <button @click="$store.modal.open('invite-user')" class="w-full sm:w-auto h-11 px-4 border border-outline-variant dark:border-outline rounded-xl bg-surface-container-lowest dark:bg-inverse-surface text-on-surface dark:text-inverse-on-surface flex items-center justify-center gap-2 hover:bg-surface-container-low dark:hover:bg-surface-variant hover:text-primary dark:hover:text-primary-fixed transition-colors text-body-md open-invitation-modal">
                <span class="material-symbols-outlined text-sm">send</span> Nouvelle invitation
            </button>
        </div>
        <div class="bg-surface-container-lowest dark:bg-inverse-surface border border-outline-variant dark:border-outline rounded-2xl shadow-sm overflow-x-auto transition-colors">
            <table class="w-full text-left text-body-md whitespace-nowrap min-w-[800px]">
                <thead class="bg-surface-container-low dark:bg-surface-dark border-b border-outline-variant dark:border-outline text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-surface-variant">
                    <tr>
                        <th class="py-4 px-6 font-semibold">EMAIL</th>
                        <th class="py-4 px-6 font-semibold">RÔLE</th>
                        <th class="py-4 px-6 font-semibold">STATUT</th>
                        <th class="py-4 px-6 font-semibold">ENVOYÉ LE</th>
                        <th class="py-4 px-6 font-semibold">EXPIRE LE</th>
                        <th class="py-4 px-6 font-semibold text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant dark:divide-outline">
                    <tr class="hover:bg-surface-container-low dark:hover:bg-surface-variant/20 transition-colors group">
                        <td class="py-4 px-6 text-on-surface dark:text-inverse-on-surface font-medium">nouveau.dev@acme.cd</td>
                        <td class="py-4 px-6"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-surface-variant dark:bg-outline text-on-surface-variant dark:text-surface-variant">Développeur</span></td>
                        <td class="py-4 px-6"><span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-[#FEF9C3] dark:bg-[#713F12] text-[#A16207] dark:text-[#FEF08A]"><span class="w-1.5 h-1.5 rounded-full bg-[#A16207] dark:bg-[#FEF08A]"></span> En attente</span></td>
                        <td class="py-4 px-6 text-on-surface-variant dark:text-surface-variant">15/10/2023</td>
                        <td class="py-4 px-6 text-on-surface-variant dark:text-surface-variant">22/10/2023</td>
                        <td class="py-4 px-6 text-right">
                            <button class="text-primary dark:text-primary-fixed hover:text-primary-container dark:hover:text-primary-fixed-dim text-sm font-medium mr-3">Renvoyer</button>
                            <button class="text-error hover:text-danger dark:hover:text-red-300 text-sm font-medium">Annuler</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Tab Content: Roles & Permissions -->
    <div class="tab-pane" id="tab-roles" x-show="activeTab === 'roles'" x-transition>
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-6">
            <div class="relative w-full sm:w-64">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                <input class="w-full h-11 pl-10 pr-3 rounded-xl border border-outline-variant dark:border-outline bg-surface-container-lowest dark:bg-inverse-surface text-body-md focus:border-primary focus:ring-1 focus:ring-primary transition-colors text-on-surface dark:text-inverse-on-surface" placeholder="Rechercher un rôle..." type="text" />
            </div>
            <button class="w-full sm:w-auto h-11 px-4 bg-primary-container text-on-primary rounded-xl text-sm font-bold flex items-center justify-center gap-2 hover:bg-primary hover:text-on-primary transition-colors" id="btnCreateRole" @click="openRoleModal()">
                <span class="material-symbols-outlined text-sm">add</span> Créer un rôle
            </button>
        </div>
        <div class="bg-surface-container-lowest dark:bg-inverse-surface border border-outline-variant dark:border-outline rounded-2xl shadow-sm overflow-x-auto transition-colors">
            <table class="w-full text-left text-body-md whitespace-nowrap min-w-[800px]">
                <thead class="bg-surface-container-low dark:bg-surface-dark border-b border-outline-variant dark:border-outline text-xs font-bold uppercase tracking-wider text-on-surface-variant dark:text-surface-variant">
                    <tr>
                        <th class="py-4 px-6 font-semibold">NOM DU RÔLE</th>
                        <th class="py-4 px-6 font-semibold">DESCRIPTION</th>
                        <th class="py-4 px-6 font-semibold">UTILISATEURS</th>
                        <th class="py-4 px-6 font-semibold text-right">ACTIONS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant dark:divide-outline">
                    <tr class="hover:bg-surface-container-low dark:hover:bg-surface-variant/20 transition-colors group">
                        <td class="py-4 px-6"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-primary-fixed text-primary">Owner</span></td>
                        <td class="py-4 px-6 text-on-surface-variant dark:text-surface-variant">Accès total au système</td>
                        <td class="py-4 px-6 text-on-surface dark:text-inverse-on-surface">1</td>
                        <td class="py-4 px-6 text-right">
                            <button class="p-2 text-outline rounded-full transition-colors opacity-50 cursor-not-allowed" disabled=""><span class="material-symbols-outlined text-sm">edit</span></button>
                        </td>
                    </tr>
                    <tr class="hover:bg-surface-container-low dark:hover:bg-surface-variant/20 transition-colors group">
                        <td class="py-4 px-6"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-[#E0E7FF] dark:bg-[#312E81] text-[#4338CA] dark:text-[#A5B4FC]">Admin</span></td>
                        <td class="py-4 px-6 text-on-surface-variant dark:text-surface-variant">Gestion administrative complète</td>
                        <td class="py-4 px-6 text-on-surface dark:text-inverse-on-surface">3</td>
                        <td class="py-4 px-6 text-right">
                            <button class="p-2 text-outline hover:text-primary dark:hover:text-primary-fixed rounded-full transition-colors"><span class="material-symbols-outlined text-sm">edit</span></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal invitation -->
    <!-- Invitation utilisateur -->


</section>