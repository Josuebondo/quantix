<?php

// dd($name);
?>
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
                <h2 class="text-xl font-semibold text-white">Bienvenue <span class="font-bold text-primary italic text-uppercases"><?= e($name ?? '') ?></span></h2>
                <p class="text-white/50 text-sm mt-1">Unitialisez votre mot de passe pour accéder à votre espace</p>
            </div>
            <form action="" class="space-y-5" method="POST">

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
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-2" for="comfirm-password">Comfirmer mot de passe</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-white/30 text-[20px] group-focus-within:text-primary transition-colors">lock</span>
                        </div>
                        <input class="block w-full pl-11 pr-12 py-3 bg-white/5 border border-white/10 rounded-xl text-white placeholder-white/20 focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary/50 transition-all duration-200" id="comfirm-password" name="comfirm-password" placeholder="••••••••" required="" type="password" />
                        <button class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-white/30 hover:text-primary transition-colors duration-200" id="togglecomfirm-password" type="button">
                            <span class="material-symbols-outlined text-[20px]" id="togglecomfirmIcon">visibility</span>
                        </button>
                    </div>
                    <input type="hidden" name="token" id="token" value="<?= e($token ?? '') ?>">
                </div>
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center cursor-pointer group">
                    </label>
                    <a class="text-primary/90 hover:text-primary transition-colors font-medium" href="#">Generer un mot de passe fort </a>
                </div>
                <button id="loginBtn" class="w-full py-3.5 px-3h h-16 bg-primary hover:bg-primary/90 text-midnight font-bold rounded-xl shadow-lg shadow-primary/10 transform active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2 group" type="submit">
                    <span id="btnText">Se connecter</span>
                </button>
                <div id="btnLoader" class="w-full  h-16 ">
                </div>
                <p class=" text-sm mt-1 text-center " id="loginMessage">
                </p>
            </form>

            <!-- Social Login Buttons -->

            <div class="mt-8 pt-6 border-t border-white/5 text-center hidden">
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
        const togglecomfirm = document.getElementById('togglecomfirm-password');
        const comfirmInput = document.getElementById('comfirm-password');
        const comfirmIcon = document.getElementById('togglecomfirmIcon');

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
        togglecomfirm.addEventListener('click', function(e) {
            e.preventDefault();

            // Toggle input type
            if (comfirmInput.type === 'password') {
                comfirmInput.type = 'text';
                comfirmIcon.textContent = 'visibility_off';
                togglecomfirm.classList.add('text-primary');
            } else {
                comfirmInput.type = 'password';
                comfirmIcon.textContent = 'visibility';
                togglecomfirm.classList.remove('text-primary');
            }
        });
    </script>
    <script type="module" src="<?= asset('js/qtix/bootstrap.js') ?>"></script>
    <script type="module" src="<?= asset('js/teams/activate.js') ?>"></script>

</body>

</html>