<!DOCTYPE html>
<html class="dark" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Quantix - Inscription Entreprise</title>
    <link rel="stylesheet" href="/css/tailwind.css">
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&family=Manrope:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 20;
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

        .loading-spinner {
            display: none;
        }

        .loading-spinner.active {
            display: inline-block;
        }

        .error-message {
            display: none;
            color: #ffb4ab;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .error-message.show {
            display: block;
        }

        .success-message {
            display: none;
            background: rgba(19, 236, 128, 0.1);
            border: 1px solid rgba(19, 236, 128, 0.3);
            color: #13ec80;
            padding: 1rem;
            border-radius: 0.75rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        .success-message.show {
            display: block;
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
                <span class="text-xl font-bold text-white tracking-tight leading-none font-headline-md">QUANTIX</span>
                <span class="text-[8px] uppercase tracking-[0.2em] text-white/40 font-semibold">Enterprise Solution</span>
            </div>
        </div>
        <div class="flex items-center gap-6">
            <a href="/login" class="text-on-surface-variant text-xs font-semibold tracking-widest uppercase opacity-70 hover:opacity-100 transition-opacity">Se connecter</a>
            <button class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center hover:bg-white/10 transition-all duration-300 group">
                <span class="material-symbols-outlined text-sm group-hover:scale-110 transition-transform">help</span>
            </button>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow flex flex-col items-center justify-start pt-32 pb-32 px-6 w-full relative z-10">
        <div class="w-full max-w-2xl mx-auto">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-white mb-4 font-headline-md tracking-tight">Créez votre compte entreprise</h1>
                <p class="text-white/50 font-body-md max-w-lg mx-auto">Inscrivez votre entreprise et commencez à utiliser Quantix dès aujourd'hui.</p>
            </div>

            <!-- Form Card -->
            <div class="glass-card p-12 rounded-2xl shadow-[0_32px_64px_-12px_rgba(0,0,0,0.5)]">
                <div class="success-message" id="success-message">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-lg">check_circle</span>
                        <span id="success-text">Inscription réussie! Redirection en cours...</span>
                    </div>
                </div>

                <form id="company-form" class="space-y-8">
                    <!-- Section 1: Infos Entreprise -->
                    <div>
                        <h3 class="text-sm font-bold text-primary uppercase tracking-[0.2em] mb-6">Informations Entreprise</h3>

                        <div class="space-y-5">
                            <div class="flex flex-col gap-2.5">
                                <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Nom de l'entreprise *</label>
                                <input type="text" name="company_name" id="company_name" placeholder="Entreprise SARL" required class="bg-white/5 border border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" />
                                <div class="error-message" id="error-company_name"></div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="flex flex-col gap-2.5">
                                    <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Email de l'entreprise</label>
                                    <input type="email" name="company_email" id="company_email" placeholder="contact@entreprise.com" class="bg-white/5 border border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" />
                                    <div class="error-message" id="error-company_email"></div>
                                </div>

                                <div class="flex flex-col gap-2.5">
                                    <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Téléphone</label>
                                    <input type="tel" name="company_phone" id="company_phone" placeholder="+33 1 23 45 67 89" class="bg-white/5 border border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" />
                                    <div class="error-message" id="error-company_phone"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Infos Administrateur -->
                    <div class="pt-6 border-t border-white/5">
                        <h3 class="text-sm font-bold text-primary uppercase tracking-[0.2em] mb-6">Administrateur</h3>

                        <div class="space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="flex flex-col gap-2.5">
                                    <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Prénom *</label>
                                    <input type="text" name="admin_first_name" id="admin_first_name" placeholder="Jean" required class="bg-white/5 border border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" />
                                    <div class="error-message" id="error-admin_first_name"></div>
                                </div>

                                <div class="flex flex-col gap-2.5">
                                    <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Nom *</label>
                                    <input type="text" name="admin_last_name" id="admin_last_name" placeholder="Dupont" required class="bg-white/5 border border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" />
                                    <div class="error-message" id="error-admin_last_name"></div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2.5">
                                <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Email professionnel *</label>
                                <input type="email" name="admin_email" id="admin_email" placeholder="jean.dupont@entreprise.com" required class="bg-white/5 border border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" />
                                <div class="error-message" id="error-admin_email"></div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div class="flex flex-col gap-2.5">
                                    <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Mot de passe *</label>
                                    <input type="password" name="admin_password" id="admin_password" placeholder="••••••••" required class="bg-white/5 border border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" />
                                    <div class="text-[10px] text-white/40 mt-1">Min. 8 caractères</div>
                                    <div class="error-message" id="error-admin_password"></div>
                                </div>

                                <div class="flex flex-col gap-2.5">
                                    <label class="text-[10px] font-bold text-white/40 uppercase tracking-[0.15em]">Confirmez le mot de passe *</label>
                                    <input type="password" name="admin_password_confirm" id="admin_password_confirm" placeholder="••••••••" required class="bg-white/5 border border-white/10 text-on-surface rounded-xl px-5 py-4 focus:ring-0 focus:outline-none input-focus-effect transition-all placeholder:text-white/10 text-sm font-body-md" />
                                    <div class="error-message" id="error-admin_password_confirm"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-6">
                        <button type="submit" class="w-full bg-primary text-midnight font-bold py-5 rounded-xl hover:bg-primary/90 active:scale-[0.99] transition-all flex items-center justify-center gap-3 text-sm tracking-widest uppercase shadow-lg shadow-primary/10 disabled:opacity-50 disabled:cursor-not-allowed" id="submit-btn">
                            <span id="submit-text">CRÉER MON COMPTE</span>
                            <span class="material-symbols-outlined text-lg loading-spinner" id="loading-spinner">progress_activity</span>
                        </button>
                    </div>

                    <!-- Terms -->
                    <div class="text-center text-[10px] text-white/40 leading-relaxed">
                        <p>En créant un compte, vous acceptez nos <a href="#" class="text-primary hover:underline">conditions d'utilisation</a> et notre <a href="#" class="text-primary hover:underline">politique de confidentialité</a>.</p>
                    </div>
                </form>

                <!-- Sign In Link -->
                <div class="mt-10 pt-8 border-t border-white/5 text-center">
                    <p class="text-white/60 text-sm">Vous avez déjà un compte? <a href="/login" class="text-primary font-bold hover:underline">Se connecter</a></p>
                </div>
            </div>
        </div>
    </main>

    <!-- Background Gradient -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none -z-10 overflow-hidden bg-slate-950">
        <div class="absolute top-[-15%] right-[-10%] w-[70%] h-[70%] bg-primary/5 blur-[180px] rounded-full"></div>
        <div class="absolute bottom-[-20%] left-[-15%] w-[60%] h-[60%] bg-white/2 blur-[160px] rounded-full"></div>
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: radial-gradient(circle at 50% 50%, #13ec80 0%, transparent 50%); background-size: cover;"></div>
    </div>

    <script>
        // Handle Form Submission
        document.getElementById('company-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(el => el.classList.remove('show'));

            const submitBtn = document.getElementById('submit-btn');
            const spinner = document.getElementById('loading-spinner');
            const successMsg = document.getElementById('success-message');

            // Hide success message
            successMsg.classList.remove('show');

            // Validate password match
            const password = document.getElementById('admin_password').value;
            const confirmPassword = document.getElementById('admin_password_confirm').value;

            if (password !== confirmPassword) {
                document.getElementById('error-admin_password_confirm').textContent = 'Les mots de passe ne correspondent pas';
                document.getElementById('error-admin_password_confirm').classList.add('show');
                return;
            }

            // Disable button and show spinner
            submitBtn.disabled = true;
            spinner.classList.add('active');

            // Prepare form data
            const formData = {
                company_name: document.getElementById('company_name').value,
                company_email: document.getElementById('company_email').value,
                company_phone: document.getElementById('company_phone').value,
                admin_first_name: document.getElementById('admin_first_name').value,
                admin_last_name: document.getElementById('admin_last_name').value,
                admin_email: document.getElementById('admin_email').value,
                admin_password: document.getElementById('admin_password').value
            };

            try {
                // Send request to backend
                const response = await fetch('/api/auth/register-company', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData)
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    // Handle validation errors
                    if (data.errors && typeof data.errors === 'object') {
                        for (const [field, message] of Object.entries(data.errors)) {
                            const errorEl = document.getElementById('error-' + field);
                            if (errorEl) {
                                errorEl.textContent = message;
                                errorEl.classList.add('show');
                            }
                        }
                    } else if (data.message) {
                        // Show general error
                        alert('Erreur: ' + data.message);
                    }
                    return;
                }

                // Success!
                successMsg.classList.add('show');
                document.getElementById('success-text').textContent = 'Inscription réussie! Redirection en cours...';

                // Store tokens
                if (data.data && data.data.tokens) {
                    localStorage.setItem('access_token', data.data.tokens.access_token);
                    localStorage.setItem('refresh_token', data.data.tokens.refresh_token);
                }

                // Redirect after 2 seconds
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 2000);

            } catch (error) {
                console.error('Error:', error);
                alert('Une erreur est survenue lors de la création du compte. Veuillez réessayer.');
            } finally {
                submitBtn.disabled = false;
                spinner.classList.remove('active');
            }
        });

        // Real-time password match validation
        document.getElementById('admin_password_confirm').addEventListener('change', function() {
            const password = document.getElementById('admin_password').value;
            const confirmPassword = this.value;
            const errorEl = document.getElementById('error-admin_password_confirm');

            if (password && confirmPassword && password !== confirmPassword) {
                errorEl.textContent = 'Les mots de passe ne correspondent pas';
                errorEl.classList.add('show');
            } else {
                errorEl.classList.remove('show');
            }
        });
    </script>
</body>

</html>
