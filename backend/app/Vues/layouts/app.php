<!DOCTYPE html>

<html class="light" lang="fr">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;family=JetBrains+Mono:wght@500&amp;display=swap" rel="stylesheet" />
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="<?= asset('css/tailwind.css') ?>" />
    <meta name="csrf-token" content="<?php echo csrf_token(); ?>">


    <!-- Scripts -->
    <script type="module">
        import bootstrap from "<?= asset('js/qtix/bootstrap.js') ?>";
    </script>
    <script>
        window.tailwind = window.tailwind || {};
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .hero-pattern {
            background-color: #f8f9ff;
            background-image: radial-gradient(#d3e4fe 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .dark .hero-pattern {
            background-color: #0b1c30;
            background-image: radial-gradient(#1e3a5f 1px, transparent 1px);
        }

        @keyframes bounce-slow {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-bounce-slow {
            animation: bounce-slow 4s ease-in-out infinite;
        }

        /* Custom transitions for theme switching */
        .theme-transition {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease, fill 0.3s ease;
        }
    </style>

    <!-- App Container (page content ira ici) -->
    <div id="app"></div>

    <!-- Notifications Container -->
    <div id="notifications"></div>

    <!-- Loading Container -->
    <div id="loading"></div>
</head>

<body class=" bg-surface-container-lowest dark:bg-inverse-surface text-on-surface dark:text-inverse-on-surface theme-transition">


</body>

</html>