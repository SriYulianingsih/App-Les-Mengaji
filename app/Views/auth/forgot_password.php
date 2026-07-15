<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Sistem Mengaji</title>
    <link rel="icon" type="image/png" href="<?= base_url('images/logo.png') ?>">
    <link rel="stylesheet" href="<?= base_url('src/output.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        /* Animasi background blob */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</head>
<body class="bg-emerald-50 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute top-10 left-10 w-72 h-72 bg-emerald-200 rounded-full mix-blend-multiply filter blur-3xl opacity-60 animate-blob"></div>
    <div class="absolute bottom-10 right-10 w-96 h-96 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>

    <div class="w-full max-w-md z-10">
        <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-2xl shadow-emerald-950/10 border border-white/20 p-6 md:p-8">
            
            <div class="text-center mb-6">
                <div class="mx-auto w-16 h-16 bg-gradient-to-tr from-emerald-500 to-teal-400 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-500/30 mb-4 transform hover:rotate-6 transition-transform duration-300">
                    <i data-lucide="shield-question" class="w-8 h-8 text-white"></i>
                </div>
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight mb-1">Reset Password</h2>
                <p class="text-sm text-slate-600">Buat password baru untuk akun Anda</p>
            </div>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-xl flex items-center gap-3">
                    <i data-lucide="alert-triangle" class="w-5 h-5 text-red-500 flex-shrink-0"></i>
                    <p class="text-xs text-red-700 font-semibold"><?= session()->getFlashdata('error') ?></p>
                </div>
            <?php endif; ?>

            <?php $errors = session()->getFlashdata('errors'); ?>

            <form action="/forgot-password/process" method="post" class="space-y-4">

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-800 block ml-1">Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <i data-lucide="user" class="w-5 h-5"></i>
                        </div>
                        <input type="text" name="username" value="<?= old('username') ?>" placeholder="Username Anda"
                               class="w-full pl-11 pr-4 py-3 bg-slate-50 border <?= isset($errors['username']) ? 'border-red-300 focus:ring-red-500/20 focus:border-red-500' : 'border-slate-200 focus:ring-emerald-500/20 focus:border-emerald-500' ?> rounded-xl outline-none focus:ring-4 transition-all duration-200 text-slate-900 placeholder-slate-400 font-medium text-sm">
                    </div>
                    <?php if(isset($errors['username'])): ?>
                        <div class="flex items-center gap-1.5 mt-1 ml-1">
                            <i data-lucide="x-circle" class="w-4 h-4 text-red-500"></i>
                            <small class="text-xs text-red-600 font-semibold"><?= $errors['username'] ?></small>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-800 block ml-1">Password Baru</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <i data-lucide="lock" class="w-5 h-5"></i>
                        </div>
                        <input type="password" id="newPassword" name="password" placeholder="••••••••"
                               class="w-full pl-11 pr-11 py-3 bg-slate-50 border <?= isset($errors['password']) ? 'border-red-300 focus:ring-red-500/20 focus:border-red-500' : 'border-slate-200 focus:ring-emerald-500/20 focus:border-emerald-500' ?> rounded-xl outline-none focus:ring-4 transition-all duration-200 text-slate-900 placeholder-slate-400 text-sm">
                        
                        <button type="button" onclick="toggleVisibility('newPassword', 'eyeIcon1')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-emerald-600 transition-colors">
                            <i data-lucide="eye" id="eyeIcon1" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <?php if(isset($errors['password'])): ?>
                        <div class="flex items-center gap-1.5 mt-1 ml-1">
                            <i data-lucide="x-circle" class="w-4 h-4 text-red-500"></i>
                            <small class="text-xs text-red-600 font-semibold"><?= $errors['password'] ?></small>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-800 block ml-1">Konfirmasi Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <i data-lucide="lock-keyhole" class="w-5 h-5"></i>
                        </div>
                        <input type="password" id="confirmPassword" name="confirm_password" placeholder="••••••••"
                               class="w-full pl-11 pr-11 py-3 bg-slate-50 border <?= isset($errors['confirm_password']) ? 'border-red-300 focus:ring-red-500/20 focus:border-red-500' : 'border-slate-200 focus:ring-emerald-500/20 focus:border-emerald-500' ?> rounded-xl outline-none focus:ring-4 transition-all duration-200 text-slate-900 placeholder-slate-400 text-sm">
                        
                        <button type="button" onclick="toggleVisibility('confirmPassword', 'eyeIcon2')" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-emerald-600 transition-colors">
                            <i data-lucide="eye" id="eyeIcon2" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <?php if(isset($errors['confirm_password'])): ?>
                        <div class="flex items-center gap-1.5 mt-1 ml-1">
                            <i data-lucide="x-circle" class="w-4 h-4 text-red-500"></i>
                            <small class="text-xs text-red-600 font-semibold"><?= $errors['confirm_password'] ?></small>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" 
                        class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg shadow-emerald-600/20 hover:shadow-emerald-600/30 transform hover:-translate-y-0.5 transition-all duration-200 focus:outline-none focus:ring-4 focus:ring-emerald-500/50 text-sm">
                    Reset Password
                </button>

                <div class="text-center pt-2">
                    <a href="<?= base_url('login') ?>" class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                        Kembali ke Halaman Login
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Fungsi interaktif show/hide password (support multi-input)
        function toggleVisibility(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.setAttribute('data-lucide', 'eye-off');
            } else {
                passwordInput.type = 'password';
                eyeIcon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }
    </script>
</body>
</html>