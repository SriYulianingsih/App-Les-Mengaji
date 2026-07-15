<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= $title ?? 'Dashboard Guru || Cahaya Hidayah Qurani' ?></title>

<link rel="icon" type="image/png" href="<?= base_url('images/logo.png') ?>">

<script src="https://cdn.tailwindcss.com"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
tailwind.config = {
    theme: {
        extend: {
            colors: {
                slate: {
                    50: '#f8fafc', 100: '#f1f5f9', 200: '#e2e8f0', 300: '#cbd5e1',
                    400: '#94a3b8', 500: '#64748b', 600: '#475569', 700: '#334155',
                    800: '#1e293b', 900: '#0f172a',
                },
                emerald: {
                    50: '#ecfdf5', 100: '#d1fae5', 200: '#a7f3d0', 300: '#6ee7b7',
                    400: '#34d399', 500: '#10b981', 600: '#059669', 700: '#047857',
                    800: '#065f46', 900: '#064e3b',
                },
                teal: {
                    50: '#f0fdfa', 100: '#ccfbf1', 200: '#99f6e4', 300: '#5eead4',
                    400: '#2dd4bf', 500: '#14b8a6', 600: '#0d9488', 700: '#0f766e',
                    800: '#115e59', 900: '#134e4a',
                }
            },
            boxShadow: {
                'premium': '0 10px 30px -5px rgba(0, 0, 0, 0.04), 0 6px 10px -6px rgba(0, 0, 0, 0.02)',
                'emerald-glow': '0 10px 15px -3px rgba(16, 185, 129, 0.2), 0 4px 6px -4px rgba(16, 185, 129, 0.1)',
            }
        }
    }
}
</script>

<script src="//unpkg.com/alpinejs" defer></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
    
    body { 
        font-family: 'Inter', sans-serif;
        -webkit-font-smoothing: antialiased;
        letter-spacing: -0.01em;
    }

    [x-cloak] { display: none !important; }

    /* Glass Effect Premium */
    .glass-effect {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    /* Border & Shadow Soft */
    .border-light { border-color: rgba(226, 232, 240, 0.8); }
    
    .shadow-soft { 
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01); 
    }

    /* Sidebar Active Indicator */
    .nav-active {
        position: relative;
        background: #ecfdf5; 
        color: #059669; 
        font-weight: 700;
    }
    .nav-active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 25%;
        height: 50%;
        width: 4px;
        background: #10b981;
        border-radius: 0 4px 4px 0;
    }

    /* Card & Stats */
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
    }

    /* Smooth Scrollbar */
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #f8fafc; }
    ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Pop-up Error / Jadwal Kosong (Bahasanya lebih halus)
    <?php if (session()->getFlashdata('error_popup')) : ?>
        Swal.fire({
            icon: 'info',
            title: 'INFO JADWAL',
            text: '<?= session()->getFlashdata('error_popup') ?>',
            confirmButtonColor: '#059669',
            confirmButtonText: 'SYUKRON, SAYA MENGERTI', // Ganti jadi Syukron
            background: '#ffffff',
            customClass: {
                popup: 'rounded-[2.5rem] p-4',
                title: 'text-xl font-black text-slate-800 tracking-tight mt-4',
                htmlContainer: 'text-[11px] font-bold text-slate-400 uppercase tracking-widest leading-loose',
                confirmButton: 'rounded-xl px-10 py-3 text-[10px] font-black uppercase tracking-[0.2em] shadow-lg shadow-emerald-100 mb-4'
            }
        });
    <?php endif; ?>

    // 2. Pop-up Success (Bahasanya lebih berkah)
    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: 'success',
            title: 'ALHAMDULILLAH', // Lebih islami
            text: '<?= session()->getFlashdata('success') ?>',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#ffffff',
            customClass: {
                popup: 'rounded-[2.5rem]',
                title: 'text-xl font-black text-emerald-600 tracking-tight'
            }
        });
    <?php endif; ?>
    
    // 3. Pop-up Error Biasa
    <?php if (session()->getFlashdata('error')) : ?>
        Swal.fire({
            icon: 'error',
            title: 'AFWAN, ADA KENDALA', // Ganti Afwan
            text: '<?= session()->getFlashdata('error') ?>',
            confirmButtonColor: '#e11d48',
            confirmButtonText: 'KEMBALI',
            customClass: {
                popup: 'rounded-[2.5rem]'
            }
        });
    <?php endif; ?>
});
</script>