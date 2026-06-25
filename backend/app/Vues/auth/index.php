<!DOCTYPE html>

<html class="dark" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Quantix | Connexion</title>
    <link rel="stylesheet" href="<?= asset('/css/tailwind.css') ?>">
    <link rel="stylesheet" href="<?= asset('/css/loader.css') ?>">
    <link rel="stylesheet" href="<?= asset('/css/app.css') ?>">
    <link rel="icon" href="<?= asset('/images/quantix_logo.jpeg') ?>">
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
    </style>
</head>

<body class="bg-slate-950 font-display min-h-screen flex items-center justify-center p-4 bg-pattern">
    <div class="w-full max-w-md">
        <!-- Branding -->
        <div class="flex items-center justify-center gap-3 mb-10">
            <!-- Brand Logo -->
            <div class="flex items-center gap-2">
                <img alt="Quantix Logo" class="h-20 w-auto object-contain dark:brightness-200" style="border-radius: 100%;" src="<?= asset('images/quantix_logo.jpeg') ?>" />
            </div>
            <div class="flex flex-col">
                <span class="text-3xl font-bold text-white tracking-tight leading-none">QUATINX</span>
                <span class="text-[10px] uppercase tracking-[0.2em] text-white/40 font-semibold mt-1">Enterprise Solution</span>
            </div>
        </div>
        <div class="glass-effect p-8 rounded-2xl shadow-2xl border border-white/5">
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-white">Bienvenue</h2>
                <p class="text-white/50 text-sm mt-1">Connectez-vous pour accéder à votre espace</p>
            </div>
            <form action="" class="space-y-5" method="POST">
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-2" for="email">E-mail ou Utilisateur</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-white/30 text-[20px] group-focus-within:text-primary transition-colors">person</span>
                        </div>
                        <input class="block w-full pl-11 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/20 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition-all duration-200" id="email" name="email" placeholder="nom@entreprise.com" required="" type="text" />
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-2" for="password">Mot de passe</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-white/30 text-[20px] group-focus-within:text-primary transition-colors">lock</span>
                        </div>
                        <input class="block w-full pl-11 pr-12 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/20 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition-all duration-200" id="password" name="password" placeholder="••••••••" required="" type="password" />
                        <button class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-white/30 hover:text-primary transition-colors duration-200" id="togglePassword" type="button">
                            <span class="material-symbols-outlined text-[20px]" id="toggleIcon">visibility</span>
                        </button>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center cursor-pointer group">
                        <input class="rounded-md border-white/10 bg-white/5 text-primary focus:ring-primary/50 h-4 w-4 transition-all" type="checkbox" />
                        <span class="ml-2 text-white/50 group-hover:text-white/80 transition-colors">Se souvenir de moi</span>
                    </label>
                    <a class="text-primary/90 hover:text-primary transition-colors font-medium" href="#">Mot de passe oublié ?</a>
                </div>
                <button id="loginBtn" class="w-full py-3.5 px-3h h-16 bg-primary hover:bg-primary/90 text-midnight font-bold rounded-xl shadow-lg shadow-primary/10 transform active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 group" type="submit">
                    <span id="btnText">Se connecter</span>
                    <span id="btnLoader" class="material-symbols-outlined text-[20px] group-hover:translate-x-1 transition-transform ">login</span>
                </button>
                <p class=" text-sm mt-1 text-center " id="loginMessage"></p>
            </form>
            <!-- Social Login Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-white/10"></div>
                </div>
                <div class="relative flex justify-center text-xs uppercase">
                    <span class="bg-slate-900/50 backdrop-blur px-4 text-white/30 tracking-widest font-semibold">Ou continuer avec</span>
                </div>
            </div>
            <!-- Social Login Buttons -->
            <div class="space-y-3">
                <!-- Google -->
                <button class="w-full flex items-center justify-center gap-3 py-3 px-4 bg-gradient-to-r from-white/5 to-white/[0.02] border border-white/10 rounded-xl hover:border-white/20 hover:bg-white/10 hover:shadow-[0_0_20px_rgba(255,255,255,0.05)] transition-all duration-200 group" title="Connexion avec Google">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4" />
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853" />
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05" />
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335" />
                    </svg>
                    <span class="text-white/90 font-medium">Google</span>
                </button>
                <!-- Microsoft -->
                <button class="w-full flex items-center justify-center gap-3 py-3 px-4 bg-gradient-to-r from-white/5 to-white/[0.02] border border-white/10 rounded-xl hover:border-white/20 hover:bg-white/10 hover:shadow-[0_0_20px_rgba(255,255,255,0.05)] transition-all duration-200 group" title="Connexion avec Microsoft">
                    <svg class="w-5 h-5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <rect x="1" y="1" width="9" height="9" fill="#F25022" />
                        <rect x="14" y="1" width="9" height="9" fill="#7FBA00" />
                        <rect x="1" y="14" width="9" height="9" fill="#00A4EF" />
                        <rect x="14" y="14" width="9" height="9" fill="#FFB900" />
                    </svg>
                    <span class="text-white/90 font-medium">Microsoft</span>
                </button>
                <!-- Facebook -->
                <button class="w-full flex items-center justify-center gap-3 py-3 px-4 bg-gradient-to-r from-white/5 to-white/[0.02] border border-white/10 rounded-xl hover:border-[#1877F2]/30 hover:bg-[#1877F2]/5 hover:shadow-[0_0_20px_rgba(24,119,242,0.1)] transition-all duration-200 group" title="Connexion avec Facebook">
                    <svg class="w-5 h-5 group-hover:fill-[#1877F2] fill-white/80 transition-colors" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                    <span class="text-white/90 font-medium">Facebook</span>
                </button>
            </div>
            <div class="mt-8 pt-6 border-t border-white/5 text-center">
                <p class="text-white/40 text-sm">
                    Pas encore de compte ?
                    <a class="text-white/80 hover:text-primary transition-colors font-semibold ml-1" href="<?= route('register') ?>">Créer un profil</a>
                </p>
            </div>
        </div>
        <!-- Footer Info -->
        <div class="mt-10 flex justify-center gap-8">
            <div class="flex items-center gap-2.5">
                <span class="flex h-1.5 w-1.5 rounded-full bg-primary shadow-[0_0_8px_rgba(19,236,128,0.6)]"></span>
                <span class="text-[10px] uppercase tracking-widest text-white/30 font-bold">Système en ligne</span>
            </div>
            <div class="flex items-center gap-2.5">
                <span class="material-symbols-outlined text-[14px] text-white/30">verified_user</span>
                <span class="text-[10px] uppercase tracking-widest text-white/30 font-bold">Sécurité renforcée</span>
            </div>
        </div>
    </div>

    <script>
        // Password visibility toggle
        const togglePasswordBtn = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        togglePasswordBtn.addEventListener('click', function(e) {
            e.preventDefault();

            // Toggle input type
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = 'visibility_off';
                togglePasswordBtn.classList.add('text-primary');
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = 'visibility';
                togglePasswordBtn.classList.remove('text-primary');
            }
        });
    </script>
    <script type="module" src="<?= asset('js/qtix/bootstrap.js') ?>"></script>
    <script type="module" src="<?= asset('js/auth/login.js') ?>"></script>

</body>

</html>