<!DOCTYPE html>
<html lang="id">
<head>
    <?= $this->include('orangtua/layouts/header') ?>
</head>

<body class="bg-slate-50 text-slate-700 antialiased font-sans" 
      x-data="{ sidebarOpen: false }" 
      :class="{ 'overflow-hidden': sidebarOpen }">

    <div class="min-h-screen flex flex-col">

        <div class="relative z-[130] sticky top-0">
            <?= $this->include('orangtua/layouts/navbar') ?>
        </div>

        <div class="flex flex-1 relative">

            <?= $this->include('orangtua/layouts/sidebar') ?>

            <div x-show="sidebarOpen" 
                 @click="sidebarOpen = false"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[115] lg:hidden">
            </div>

            <main class="flex-1 w-full min-w-0 p-4 md:p-6 lg:p-10 animate-fade-in lg:h-[calc(100vh-64px)] lg:overflow-y-auto bg-slate-50/50">
                <div class="max-w-7xl mx-auto">
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 rounded-2xl text-emerald-600 text-[10px] font-black uppercase italic animate-fade-in flex items-center shadow-sm">
                            <i class="fas fa-check-circle mr-2 text-sm"></i>
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?= $this->renderSection('content') ?>
                    
                    <div class="h-20 lg:hidden"></div>
                </div>
            </main>

        </div>

    </div>

    <style>
        /* Animasi masuk */
        .animate-fade-in {
            animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Scrollbar styling untuk Desktop */
        @media (min-width: 1024px) {
            main::-webkit-scrollbar { width: 5px; }
            main::-webkit-scrollbar-track { background: transparent; }
            main::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
            main::-webkit-scrollbar-thumb:hover { background: #6366f1; }
        }

        /* PERBAIKAN TOTAL UNTUK MOBILE */
        @media (max-width: 1023px) {
            html, body {
                overflow-x: hidden;
                height: auto !important;
                -webkit-overflow-scrolling: touch; /* Biar scroll smooth di iPhone */
            }
            .min-h-screen {
                height: auto !important;
            }
            main {
                overflow-y: visible !important;
                height: auto !important;
            }
        }
    </style>

</body>
</html>