<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? 'Dashboard Admin || App Les Mengaji' ?></title>

<link rel="icon" type="image/png" href="<?= base_url('images/logo.png') ?>">

<!-- ✅ Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- ✅ CONFIG HARUS SETELAH CDN -->
<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                slate: {
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0f172a',
                },
                sky: {
                    50: '#f0f9ff',
                    100: '#e0f2fe',
                    200: '#bae6fd',
                    300: '#7dd3fc',
                    400: '#38bdf8',
                    500: '#0ea5e9',
                    600: '#0284c7',
                    700: '#0369a1',
                    800: '#075985',
                    900: '#0c4a6e',
                }
            }
        }
    }
}
</script>

<!-- Alpine JS -->
<script src="//unpkg.com/alpinejs" defer></script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { 
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        .shadow-soft { 
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03); 
        }
        .shadow-hover:hover {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
            transform: translateY(-2px);
        }
        .border-light { border-color: rgba(226, 232, 240, 0.5); }
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }
        .chart-grid {
            background-image: 
                linear-gradient(to right, rgba(226, 232, 240, 0.3) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(226, 232, 240, 0.3) 1px, transparent 1px);
            background-size: 20px 20px;
        }
        .progress-bar {
            transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .stat-card:hover .stat-icon {
            transform: scale(1.1) rotate(5deg);
        }
        .notification-badge {
            animation: pulse-slow 2s infinite;
        }
    </style>