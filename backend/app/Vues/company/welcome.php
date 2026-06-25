<!DOCTYPE html>

<html class="dark" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Quatinx | Erreur d'activation</title>
    <link rel="stylesheet" href="/css/tailwind.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&amp;family=Hanken+Grotesk:wght@600;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <style>
        .glass-panel {
            background: rgba(29, 32, 34, 0.6);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .grid-bg {
            background-image: radial-gradient(circle at 2px 2px, rgba(255, 255, 255, 0.03) 1px, transparent 0);
            background-size: 40px 40px;
        }

        .emerald-glow {
            box-shadow: 0 0 40px -10px rgba(16, 185, 129, 0.2);
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }

        .fade-transition {
            transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
        }

        .hidden-state {
            display: none;
            opacity: 0;
            transform: translateY(10px);
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-custom {
            animation: spin 1s linear infinite;
        }
    </style>
</head>

<body class="bg-background text-on-background font-body-md min-h-screen flex flex-col items-center justify-between selection:bg-primary/30">
    <!-- Subtle Background Elements -->
    <div class="fixed inset-0 grid-bg pointer-events-none z-0"></div>
    <div class="fixed top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/5 blur-[120px] rounded-full pointer-events-none"></div>
    <!-- Header / Logo -->
    <header class="w-full z-10 py-12 px-margin-desktop max-w-container-max-width mx-auto flex justify-center">
        <div class="flex items-center gap-2 group cursor-pointer transition-transform duration-300 hover:scale-105">
            <img src="<?= asset('images/quantix_logo.jpeg') ?>" alt="Quantix Logo" class="w-10 h-10 rounded-full object-cover border-2 border-primary group-hover:border-primary/80 transition-colors duration-300" />
            <span class="font-headline-md text-headline-md font-bold text-primary tracking-tight">Quatinx</span>
        </div>
    </header>
    <!-- Main Content Area -->
    <main class="relative z-10 flex-1 flex flex-col items-center justify-center w-full px-margin-mobile">
        <div class="max-w-[560px] w-full glass-panel p-8 md:p-12 rounded-xl text-center emerald-glow">
            <!-- Error State (Initial) -->
            <div class="fade-transition" id="error-state">
                <!-- Error Icon Visual -->
                <div class="mb-8 relative inline-block">
                    <div class="absolute inset-0 bg-primary/20 blur-2xl rounded-full scale-150 animate-pulse"></div>
                    <div class="relative w-20 h-20 bg-surface-container-high rounded-full flex items-center justify-center border border-white/10 mx-auto">
                        <span class="material-symbols-outlined text-primary text-4xl" style="font-variation-settings: 'FILL' 0, 'wght' 200;">link_off</span>
                    </div>
                </div>
                <!-- Typography Content -->
                <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-6 tracking-tight">
                    Lien d'activation expiré
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 leading-relaxed max-w-md mx-auto">
                    Oups ! Il semble que votre lien d'activation n'est plus valide ou a déjà été utilisé. Pour des raisons de sécurité, ces liens expirent après 24 heures.
                </p>
                <!-- Actions -->
                <div class="flex flex-col items-center">
                    <!-- 1. INITIAL BUTTON -->
                    <div class="w-full" id="initial-action-container">
                        <button class="w-full px-10 py-4 bg-primary text-on-primary-fixed font-semibold rounded-lg transition-all duration-300 hover:brightness-110 hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] active:scale-95 flex items-center justify-center gap-3" id="request-link-btn">
                            <span id="btn-text-request">Demander un nouveau lien</span>
                            <span class="hidden material-symbols-outlined animate-spin-custom" id="loader-request">progress_activity</span>
                        </button>
                    </div>
                    <!-- 2. EMAIL INPUT (Hidden initially) -->
                    <form class="w-full space-y-6 hidden-state" id="activation-form">
                        <div class="w-full text-left">
                            <label class="block font-label-sm text-label-sm text-on-surface-variant mb-2 ml-1" for="admin-email">Email de l'administrateur</label>
                            <input class="w-full bg-surface-container-high border border-white/10 rounded-lg px-4 py-3 text-on-surface placeholder:text-on-surface-variant/40 focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary/50 transition-all duration-300" id="admin-email" name="email" placeholder="admin@entreprise.com" required="" type="email" />
                        </div>
                        <button class="w-full px-10 py-4 bg-primary text-on-primary-fixed font-semibold rounded-lg transition-all duration-300 hover:brightness-110 hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] active:scale-95 flex items-center justify-center gap-3" id="submit-activation-btn" type="submit">
                            <span id="btn-text-submit">Envoyer le lien d'activation</span>
                            <span class="hidden material-symbols-outlined animate-spin-custom" id="loader-submit">progress_activity</span>
                        </button>
                    </form>
                    <div class="flex flex-col md:flex-row items-center gap-6 mt-10">
                        <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors flex items-center gap-2" href="#">
                            <span class="material-symbols-outlined text-[18px]">support_agent</span>
                            Contacter le support
                        </a>
                        <span class="hidden md:block w-1 h-1 bg-surface-variant rounded-full"></span>
                        <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-primary transition-colors flex items-center gap-2" href="#">
                            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                            Retour à la connexion
                        </a>
                    </div>
                </div>
            </div>
            <!-- Success State (Hidden by default) -->
            <div class="hidden-state fade-transition" id="success-state">
                <!-- Success Icon Visual -->
                <div class="mb-8 relative inline-block">
                    <div class="absolute inset-0 bg-primary/20 blur-2xl rounded-full scale-150"></div>
                    <div class="relative w-20 h-20 bg-surface-container-high rounded-full flex items-center justify-center border border-white/10 mx-auto">
                        <span class="material-symbols-outlined text-primary text-5xl" style="font-variation-settings: 'FILL' 1, 'wght' 400;">check_circle</span>
                    </div>
                </div>
                <!-- Typography Content -->
                <h1 class="font-display-lg-mobile md:font-display-lg text-display-lg-mobile md:text-display-lg text-on-surface mb-6 tracking-tight">
                    Lien envoyé !
                </h1>
                <p class="font-body-lg text-body-lg text-on-surface-variant mb-10 leading-relaxed max-w-md mx-auto">
                    Un nouveau lien d'activation a été envoyé à votre adresse email. Pensez à vérifier vos courriers indésirables si vous ne le recevez pas d'ici quelques minutes.
                </p>
                <!-- Actions -->
                <div class="w-full">
                    <a class="block w-full px-10 py-4 bg-primary text-on-primary-fixed text-center font-semibold rounded-lg transition-all duration-300 hover:brightness-110 hover:shadow-[0_0_20px_rgba(16,185,129,0.4)] active:scale-95" href="#">
                        Retour à la connexion
                    </a>
                </div>
            </div>
        </div>
        <!-- Visual Decoration (Asymmetric context) -->
        <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-primary/5 blur-[80px] rounded-full pointer-events-none"></div>
    </main>
    <!-- Footer -->
    <footer class="w-full z-10 py-12 border-t border-white/5 bg-surface-container-lowest/50 backdrop-blur-sm mt-12">
        <div class="max-w-container-max-width mx-auto px-margin-desktop flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="text-on-surface-variant font-body-md text-[14px]">
                © 2024 Quatinx Inc. All rights reserved.
            </div>
            <div class="flex items-center gap-8">
                <a class="font-body-md text-[14px] text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="font-body-md text-[14px] text-on-surface-variant hover:text-primary transition-colors" href="#">Terms of Service</a>
                <a class="font-body-md text-[14px] text-on-surface-variant hover:text-primary transition-colors" href="#">Security</a>
                <a class="font-body-md text-[14px] text-on-surface-variant hover:text-primary transition-colors" href="#">Contact</a>
            </div>
        </div>
    </footer>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const initialActionContainer = document.getElementById('initial-action-container');
            const requestLinkBtn = document.getElementById('request-link-btn');
            const btnTextRequest = document.getElementById('btn-text-request');
            const loaderRequest = document.getElementById('loader-request');

            const form = document.getElementById('activation-form');
            const submitBtn = document.getElementById('submit-activation-btn');
            const btnTextSubmit = document.getElementById('btn-text-submit');
            const loaderSubmit = document.getElementById('loader-submit');

            const errorState = document.getElementById('error-state');
            const successState = document.getElementById('success-state');

            // 1 & 2: Transition from Initial Button to Input
            requestLinkBtn.addEventListener('click', () => {
                // Show loader on initial button
                btnTextRequest.classList.add('hidden');
                loaderRequest.classList.remove('hidden');
                requestLinkBtn.disabled = true;

                setTimeout(() => {
                    // Hide initial button container
                    initialActionContainer.classList.add('hidden');

                    // Show form
                    form.classList.remove('hidden-state');
                    form.classList.remove('hidden');
                    form.classList.add('flex', 'flex-col');

                    // Trigger reflow for transition
                    void form.offsetWidth;
                    form.style.opacity = '1';
                    form.style.transform = 'translateY(0)';
                }, 1000); // 1 second loader
            });

            // 3 & 4: Submission State to Success State
            form.addEventListener('submit', (e) => {
                e.preventDefault();

                // Show loader on submit button
                btnTextSubmit.classList.add('hidden');
                loaderSubmit.classList.remove('hidden');
                submitBtn.disabled = true;

                setTimeout(() => {
                    // Transition to success state
                    errorState.style.opacity = '0';
                    errorState.style.transform = 'translateY(-10px)';

                    setTimeout(() => {
                        errorState.classList.add('hidden-state');
                        successState.classList.remove('hidden-state');

                        // Trigger reflow
                        void successState.offsetWidth;

                        successState.style.display = 'block';
                        successState.style.opacity = '1';
                        successState.style.transform = 'translateY(0)';
                    }, 300);
                }, 1500); // 1.5 seconds loader
            });

            // Mouse interaction for button glow
            const buttons = document.querySelectorAll('button');
            buttons.forEach(btn => {
                btn.addEventListener('mousemove', (e) => {
                    const rect = btn.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    btn.style.setProperty('--x', `${x}px`);
                    btn.style.setProperty('--y', `${y}px`);
                });
            });
        });
    </script>
</body>

</html>