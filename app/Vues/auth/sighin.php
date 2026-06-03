<!DOCTYPE html>

<html class="dark" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Quatinx - Inscription Premium</title>
    <link rel="stylesheet" href="/css/tailwind.css">
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700;800&amp;family=Inter:wght@300;400;500;600;700&amp;family=Manrope:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    "body-md": ["Inter"],
    "label-sm": ["Inter"],
    "display-lg": ["Manrope", "Hanken Grotesk"],
    "display-lg-mobile": ["Manrope", "Hanken Grotesk"],
    "body-lg": ["Inter"]
    }
    },
    },
    }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 20;
        }

        .step-content {
            display: none;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .step-content.active {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        .input-focus-effect:focus {
            box-shadow: 0 0 0 3px rgba(19, 236, 128, 0.2);
            border-color: rgba(19, 236, 128, 0.5);
        }

        .plan-card.selected {
            border-color: #13ec80;
            background: rgba(19, 236, 128, 0.08);
            box-shadow: 0 0 25px rgba(19, 236, 128, 0.15);
        }

        .connection-line {
            background: linear-gradient(90deg, #494454 0%, #494454 100%);
        }

        .connection-line.active {
            background: linear-gradient(90deg, #13ec80 0%, #13ec80 100%);
        }
    </style>
</head>

<body class="bg-background text-on-background font-body-md min-h-screen flex flex-col selection:bg-primary/30 antialiased overflow-x-hidden">
    <!-- Header Navigation -->
    <nav class="bg-background/40 backdrop-blur-xl text-sm border-b border-white/5 flex justify-between items-center px-8 h-20 w-full fixed top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary/10 border border-primary/30 shadow-[0_0_15px_rgba(19,236,128,0.1)]">
                <span class="material-symbols-outlined text-primary text-2xl">deployed_code</span>
            </div>
            <div class="flex flex-col">
                <span class="text-xl font-bold text-white tracking-tight leading-none font-headline-md">QUATINX</span>
                <span class="text-[8px] uppercase tracking-[0.2em] text-white/40 font-semibold">Enterprise Solution</span>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <span class="text-on-surface-variant text-xs font-semibold tracking-widest uppercase opacity-70">Support</span>
            <button class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white/10 transition-all duration-300 group">
                <span class="material-symbols-outlined text-sm group-hover:scale-110 transition-transform">help</span>
            </button>
        </div>
    </nav>
    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center justify-start pt-40 pb-32 px-6 w-full relative z-10">
        <!-- Stepper Component -->
        <div class="w-full max-w-xl mb-24 relative">
            <div class="flex items-center justify-between relative">
                <!-- Progress Background Line -->
                <div class="absolute top-5 left-4 right-4 h-[1px] bg-white/10 -z-0"></div>
                <!-- Progress Active Line Overlay -->
                <div class="absolute top-5 left-4 h-[1px] bg-primary transition-all duration-500 -z-0" id="progress-line" style="width: 0%"></div>
                <!-- Step 1: INFOS -->
                <div class="relative z-10 flex flex-col items-center gap-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center ring-8 ring-background transition-all duration-500 bg-primary text-on-primary shadow-[0_0_15px_rgba(19,236,128,0.3)]" id="marker-1">
                        <span class="material-symbols-outlined text-base" id="icon-1">person</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-primary font-headline-md" id="label-1">Infos</span>
                </div>
                <!-- Step 2: FORFAIT -->
                <div class="relative z-10 flex flex-col items-center gap-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center ring-8 ring-background transition-all duration-500 bg-surface-container-highest text-on-surface-variant/40" id="marker-2">
                        <span class="material-symbols-outlined text-base" id="icon-2">payments</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-outline font-headline-md opacity-50" id="label-2">Forfait</span>
                </div>
                <!-- Step 3: FIN -->
                <div class="relative z-10 flex flex-col items-center gap-4">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center ring-8 ring-background transition-all duration-500 bg-surface-container-highest text-on-surface-variant/40" id="marker-3">
                        <span class="material-symbols-outlined text-base" id="icon-3">verified</span>
                    </div>
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-outline font-headline-md opacity-50" id="label-3">Fin</span>
                </div>
            </div>
        </div>
        <!-- Forms / Wizard Container -->
        <div class="w-full max-w-5xl mx-auto">
            <!-- Step 1 Content: INFOS -->
            <section class="step-content active" id="step-1">
                <div class="max-w-2xl mx-auto glass-card p-12 rounded-2xl shadow-[0_32px_64px_-12px_rgba(0,0,0,0.5)]">
                    <div class="mb-10">
                        <h2 class="text-3xl font-bold text-white mb-3 font-headline-md tracking-tight">Créez votre entreprise</h2>
                        <p class="text-white/50 text-sm font-body-md">Commençons par configurer votre profil et votre entreprise.</p>
                    </div>
                    <form class="space-y-8 info-form" id="info-form" onsubmit="event.preventDefault(); goToStep(2);">
                        <div class="space-y-4">
                            <h3 class="text-sm font-bold text-primary uppercase tracking-[0.2em]">Informations Entreprise</h3>
                            <div class="flex flex-col gap-2.5">
                                <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Nom de l'entreprise *</label>
                                <input type="text" name="company_name" id="company_name" class="bg-white/5 border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" placeholder="Entreprise SARL" required />
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="flex flex-col gap-2.5">
                                    <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Email entreprise</label>
                                    <input type="email" name="company_email" id="company_email" class="bg-white/5 border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" placeholder="contact@entreprise.com" />
                                </div>
                                <div class="flex flex-col gap-2.5">
                                    <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Téléphone</label>
                                    <input type="tel" name="company_phone" id="company_phone" class="bg-white/5 border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" placeholder="+33 1 23 45 67 89" />
                                </div>
                            </div>
                        </div>


                        <div class="pt-6">
                            <button class="w-full bg-primary text-midnight font-bold py-5 rounded-xl hover:bg-primary/90 active:scale-[0.99] transition-all flex items-center justify-center gap-3 text-sm tracking-widest uppercase shadow-lg shadow-primary/10" type="submit">
                                CONTINUER <span class="material-symbols-outlined text-lg">arrow_forward</span>
                            </button>
                        </div>
                    </form>
                </div>
            </section>
            <!-- Step 2 Content: FORFAIT -->
            <section class="step-content" id="step-2">
                <form class="info-form" onsubmit="event.preventDefault(); goToStep(3);">
                    <div class="max-w-2xl mx-auto glass-card p-12 rounded-2xl shadow-[0_32px_64px_-12px_rgba(0,0,0,0.5)]">

                        <div class="text-center mb-16">
                            <h2 class="text-4xl font-bold text-white mb-4 font-headline-md tracking-tight"> Informations de l'Administrateur</h2>
                            <p class="text-white/50 font-body-md max-w-lg mx-auto">Veuillez fournir les informations de l'administrateur de votre entreprise.</p>
                        </div>
                        <div class="pt-6 border-t border-white/5 space-y-4">
                            <h3 class="text-sm font-bold text-primary uppercase tracking-[0.2em]">Administrateur</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="flex flex-col gap-2.5">
                                    <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Prénom *</label>
                                    <input type="text" name="admin_first_name" id="admin_first_name" class="bg-white/5 border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" placeholder="Jean" required />
                                </div>
                                <div class="flex flex-col gap-2.5">
                                    <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Nom *</label>
                                    <input type="text" name="admin_last_name" id="admin_last_name" class="bg-white/5 border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" placeholder="Dupont" required />
                                </div>
                            </div>
                            <div class="flex flex-col gap-2.5">
                                <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Email professionnel *</label>
                                <input type="email" name="admin_email" id="admin_email" class="bg-white/5 border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" placeholder="jean@entreprise.com" required />
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="flex flex-col gap-2.5">
                                    <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Mot de passe *</label>
                                    <input type="password" name="admin_password" id="admin_password" class="bg-white/5 border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" placeholder="••••••••" required />
                                    <div class="text-[10px] text-white/40">Min. 8 caractères</div>
                                </div>
                                <div class="flex flex-col gap-2.5">
                                    <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Confirmer mot de passe *</label>
                                    <input type="password" name="admin_password_confirm" id="admin_password_confirm" class="bg-white/5 border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" placeholder="••••••••" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-center mt-20 gap-6">
                        <button class="px-10 py-4 rounded-xl border border-white/10 text-white/50 font-bold text-xs tracking-widest hover:bg-white/5 hover:text-white transition-all uppercase" onclick="goToStep(1)">
                            RETOUR
                        </button>
                        <button class="px-14 py-4 rounded-xl bg-primary text-midnight font-bold text-xs tracking-widest hover:bg-primary/90 active:scale-95 transition-all flex items-center gap-3 uppercase shadow-lg shadow-primary/20" type="submit">
                            SUIVANT <span class="material-symbols-outlined text-lg">arrow_forward</span>
                        </button>
                    </div>
                </form>
            </section>
            <!-- Step 3 Content: FIN -->
            <section class="step-content" id="step-3">
                <div class="flex flex-col items-center text-center py-16 px-12 glass-card rounded-3xl shadow-[0_32px_80px_-20px_rgba(0,0,0,0.6)] max-w-3xl mx-auto border border-white/5" id="mesage">
                    <!-- loading... -->
                    <div id="loading"></div>
                </div>
            </section>
        </div>
    </main>
    <!-- Refined Background Gradient Matching Login -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none -z-10 overflow-hidden bg-slate-950">
        <div class="absolute top-[-15%] right-[-10%] w-[70%] h-[70%] bg-primary/5 blur-[180px] rounded-full"></div>
        <div class="absolute bottom-[-20%] left-[-15%] w-[60%] h-[60%] bg-white/2 blur-[160px] rounded-full"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle at 50% 50%, #13ec80 0%, transparent 50%); background-size: cover;"></div>
    </div>

    <script src="<?= asset('js/auth/signin.js') ?>"></script>
    <!-- Refined Background Gradient Matching Login -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none -z-10 overflow-hidden bg-slate-950">
        <div class="absolute top-[-15%] right-[-10%] w-[70%] h-[70%] bg-primary/5 blur-[180px] rounded-full"></div>
        <div class="absolute bottom-[-20%] left-[-15%] w-[60%] h-[60%] bg-white/2 blur-[160px] rounded-full"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle at 50% 50%, #13ec80 0%, transparent 50%); background-size: cover;"></div>
    </div>
    <script>
        // Atmospheric mouse glow effect
        document.addEventListener('mousemove', (e) => {
            const x = e.clientX;
            const y = e.clientY;
            const glow = document.createElement('div');
            glow.style.position = 'fixed';
            glow.style.left = x + 'px';
            glow.style.top = y + 'px';
            glow.style.width = '1px';
            glow.style.height = '1px';
            glow.style.boxShadow = '0 0 120px 60px rgba(0, 165, 114, 0.05)';
            glow.style.borderRadius = '50%';
            glow.style.pointerEvents = 'none';
            glow.style.zIndex = '-1';
            document.body.appendChild(glow);

            setTimeout(() => {
                glow.remove();
            }, 600);
        });
    </script>
</body>

</html>