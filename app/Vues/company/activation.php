<!DOCTYPE html>

<html class="dark" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Quatinx - Activation Réussie</title>
    <link rel="stylesheet" href="/css/tailwind.css">
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <!-- Google Fonts: Hanken Grotesk -->
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&amp;display=swap" rel="stylesheet" />

    }],
    "body-lg": ["18px", {
    "lineHeight": "28px",
    "fontWeight": "400"
    }],
    "headline-lg-mobile": ["28px", {
    "lineHeight": "36px",
    "fontWeight": "600"
    }]
    }
    },
    },
    }
    </script>
    <style>
        body {
            font-family: 'Hanken Grotesk', sans-serif;
            background-color: #051424;
            background-image: radial-gradient(circle at 2px 2px, #122131 1px, transparent 0);
            background-size: 40px 40px;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        @keyframes check-bounce {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            70% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .animate-check {
            animation: check-bounce 0.8s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        .glass-card {
            background: rgba(18, 33, 49, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(139, 144, 160, 0.15);
        }

        .btn-hover-effect {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-hover-effect:active {
            transform: scale(0.97);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center p-gutter-mobile md:p-gutter-desktop text-on-background">
    <!-- Main Content -->
    <main class="w-full max-w-[540px] flex-grow flex flex-col items-center justify-center">
        <!-- Logo Section for Visual Harmony -->
        <div class="mb-gutter-desktop">
            <img alt="Quatinx Logo" class="h-12 w-auto object-contain opacity-90" src="https://lh3.googleusercontent.com/aida-public/AB6AXuATUcku_1M5WA7ShpAB1ocpicZ1t6Tx5fxQUGW1XNXkxJRgn24xFPUEhLcSsnWCTXUDmoegPAwnQP9cleMl9zpVHuMbj-jo2TCN2KUMuo2gvQxwMaAZ3pLtuqKsCJdjgnMAFjr0uV_0RECLFIate4gszLOdAjXrT7o5ofwiKm4dbrnfBGovmrv974lKrbLnQiQ7uTPIsSb5Scpeus8lDZMF1eIncxB_rlyXh7nlsNos_PGTgfepsRtlIeDS1dmAoFie1g2d7gA8H3Q" />
        </div>
        <!-- Animated Emerald Icon -->
        <div class="mb-gutter-desktop relative">
            <div class="w-28 h-28 rounded-full bg-secondary-container/10 border border-secondary/20 flex items-center justify-center animate-check shadow-[0_0_40px_rgba(0,165,114,0.1)]">
                <?php if (($status ?? '') === 'error'): ?>
                    <span class="material-symbols-outlined text-[64px] text-red-500">
                        error
                    </span>

                <?php elseif (($status ?? '') === 'warning'): ?>
                    <span class="material-symbols-outlined text-[64px] text-yellow-500">
                        warning
                    </span>

                <?php else: ?>
                    <span class="material-symbols-outlined text-[64px] text-secondary">
                        check_circle
                    </span>
                <?php endif; ?>
            </div>
            <!-- Subtle atmospheric glow -->
            <div class="absolute -inset-8 bg-secondary-container/5 rounded-full blur-3xl -z-10"></div>
        </div>
        <!-- Success Content Card -->
        <div class="glass-card w-full rounded-xl p-8 md:p-10 text-center shadow-2xl">
            <h1 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface mb-6">
                <?= htmlspecialchars($title ?? 'Activation réussie') ?>
            </h1>
            <p class="font-body-md text-body-md text-on-surface-variant mb-10 leading-relaxed max-w-[400px] mx-auto">
                <?= htmlspecialchars($message ?? '') ?>
            </p>
            <!-- Primary Action Button -->
            <?php if (($status ?? '') === 'error'): ?>

                <button onclick="window.location.href='/login'"
                    class="w-full py-4 px-8 bg-red-500 text-white rounded-lg">
                    Retour à la connexion
                </button>

            <?php elseif (($status ?? '') === 'warning'): ?>

                <button onclick="window.location.href='/login'"
                    class="w-full py-4 px-8 bg-yellow-500 text-black rounded-lg">
                    Se connecter
                </button>

            <?php else: ?>

                <button id="startBtn"
                    class="w-full py-4 px-8 bg-secondary-container text-on-secondary-container rounded-lg">
                    Lancer la configuration
                </button>

            <?php endif; ?>
            <!-- Secondary Info -->
            <div class="mt-10 pt-8 border-t border-outline-variant/20">
                <div class="flex items-center justify-center gap-4">
                    <div class="flex -space-x-2">
                        <img alt="User" class="w-7 h-7 rounded-full border-2 border-surface-container" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBO-tzaUakrbHXt53gCDLKpQhQ0FkSlaLyRWPtlPuE5IF6U3RJl6FwpqGY3li1IdEGFVX_r-9eubbDhphCwb_hKSJRDzwS207Rui92i6B7NOWJqMRf5sBN_qtYVPghO4ty0BioihIeNE58mU72R-i5LTIsznDGzE8kaQ4G9HQPWIGSTSiYRzy5qQ2JwL_pnuTyUsohZJvSuQuj6F25IePc_AbSCZbc7cbdIuMR_6KOkJxHVEczX3yHQhT5nRCIcPKZTbgUI1b8RBRM" />
                        <img alt="Admin" class="w-7 h-7 rounded-full border-2 border-surface-container" src="https://lh3.googleusercontent.com/aida-public/AB6AXuASNiOhctgDcCo9iw8WhDT_vaK5DrymS4kBs3j7UI5v04ol0IneDUt6cEO9y_DXOdLB4l1r3WPCftVuDdXN0VUnhghXWRwUSOCVOPHqFj2W9kYj6r2kZWr0BtUFQTjvya3vQNyMJjNfpbIIK1LCQNRkhwiZo8A_NfpcnQRUX3CTH11N5JktAjx533VOTo5dxP7If0ZZgNEwSvUUW00iqzC4PHCbeDYM9FHEFim5BYNs_G99MPi263tUXKL38nxGBJxD5wd_OEnbT2g" />
                    </div>
                    <span class="font-body-md text-sm text-on-surface-variant italic">
                        Rejoignez plus de 200 entreprises leaders
                    </span>
                </div>
            </div>
        </div>
        <!-- Help Link -->
        <p class="mt-8 font-body-md text-sm text-on-surface-variant">
            Besoin d'aide ? <a class="text-primary font-semibold hover:underline decoration-primary/30 underline-offset-4" href="#">Consulter la documentation</a>
        </p>
    </main>
    <!-- Professional Footer -->
    <footer class="w-full max-w-[1440px] px-margin-mobile md:px-margin-desktop py-8 mt-auto flex flex-col md:flex-row items-center justify-between gap-6 border-t border-outline-variant/10 bg-surface/50 backdrop-blur-sm">
        <div class="flex items-center gap-3 opacity-80 hover:opacity-100 transition-opacity">
            <span class="material-symbols-outlined text-secondary text-[22px]">inventory_2</span>
            <span class="font-body-md text-sm text-on-surface font-medium">Quatinx Inc. - Solution de gestion intelligente</span>
        </div>
        <div class="flex flex-col md:flex-row items-center gap-gutter-desktop">
            <span class="font-label-sm text-xs text-on-surface-variant/70">© 2024 Tous droits réservés</span>
            <nav class="flex gap-gutter-mobile">
                <a class="font-label-sm text-xs text-on-surface-variant hover:text-secondary transition-colors" href="#">Confidentialité</a>
                <a class="font-label-sm text-xs text-on-surface-variant hover:text-secondary transition-colors" href="#">Support technique</a>
            </nav>
        </div>
    </footer>
    <!-- Interactive Feedback -->
    <script>
        const btn = document.querySelector('button');
        btn.addEventListener('click', () => {
            const originalText = btn.innerHTML;
            btn.innerHTML = `<span class="material-symbols-outlined animate-spin text-[20px]">progress_activity</span> Initialisation...`;
            btn.disabled = true;
            btn.classList.add('opacity-80', 'cursor-not-allowed');

            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                btn.classList.remove('opacity-80', 'cursor-not-allowed');
                window.location.href = '/dashboard'; // Redirection à la page de configuration après l'animation
            }, 1800);
        });

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