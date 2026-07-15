<footer class="bg-white/80 backdrop-blur-md border-t border-slate-200/50 py-8 px-8 mt-auto transition-all duration-300">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">

        <div class="flex items-center space-x-4 group">
            <div class="relative">
                <div class="w-10 h-10 rounded-xl overflow-hidden shadow-lg shadow-slate-200 group-hover:shadow-sky-100 ring-2 ring-white transition-all duration-500 group-hover:scale-110 group-hover:-rotate-3">
                    <img src="<?= base_url('images/logo.png') ?>" 
                         alt="Logo" 
                         class="w-full h-full object-cover">
                </div>
                <div class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-sky-400 rounded-full border-2 border-white animate-bounce"></div>
            </div>

            <div class="flex flex-col">
                <p class="text-[13px] font-black text-slate-800 tracking-tight leading-none group-hover:text-sky-600 transition-colors">
                    &copy; 2026 Cahaya Hidayah Qurani
                </p>
            </div>
        </div>

        <div class="flex items-center space-x-6">
            <div class="hidden sm:flex items-center space-x-2 bg-slate-50 px-3 py-1.5 rounded-full border border-slate-100 shadow-inner">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">System Online</span>
            </div>
        </div>

    </div>
</footer>