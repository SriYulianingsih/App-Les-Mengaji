<?= $this->extend('admin/layouts/main') ?>

<?= $this->section('content') ?>
<div class="container mx-auto p-6 max-w-7xl" x-data="{ activeTab: 'admin' }">
    
    <?php if (session()->getFlashdata('success')) : ?>
        <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-4 py-3.5 rounded-xl mb-6 shadow-sm flex items-start gap-3">
            <i class="fas fa-check-circle text-emerald-500 mt-0.5"></i>
            <div>
                <span class="text-sm font-bold">Berhasil!</span>
                <p class="text-xs text-emerald-700 mt-0.5"><?= session()->getFlashdata('success') ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="bg-rose-50 border-l-4 border-rose-500 text-rose-800 px-4 py-3.5 rounded-xl mb-6 shadow-sm flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-rose-500 mt-0.5"></i>
            <div>
                <span class="text-sm font-bold">Terjadi Kesalahan:</span>
                <ul class="text-xs mt-0.5 list-disc list-inside text-rose-700">
                    <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                        <li><?= esc($error) ?></li>
                    <?php endforeach ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Manajemen Akun</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola hak akses pengguna aplikasi untuk Admin, Guru, dan Orang Tua.</p>
        </div>
        
        <div>
            <a :href="'/admin/akun/create/' + activeTab" 
               class="inline-flex items-center gap-2 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-medium px-5 py-2.5 rounded-xl text-sm shadow-lg shadow-emerald-100 transition-all duration-200 transform hover:-translate-y-0.5">
                <i class="fas fa-plus-circle"></i>
                <span>Tambah Akun <span class="capitalize" x-text="activeTab"></span></span>
            </a>
        </div>
    </div>

    <div class="bg-white p-1.5 rounded-2xl shadow-sm border border-slate-100 flex space-x-1 mb-6 max-w-xl">
        
        <button @click="activeTab = 'admin'"
                :class="activeTab === 'admin' ? 'bg-gradient-to-r from-slate-700 to-slate-800 text-white shadow-md shadow-slate-200' : 'text-slate-500 hover:text-slate-700 hover:bg-slate-50'"
                class="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold transition-all duration-200">
            <i class="fas fa-user-shield text-base"></i>
            <span>Administrator</span>
        </button>

        <button @click="activeTab = 'guru'"
                :class="activeTab === 'guru' ? 'bg-gradient-to-r from-emerald-600 to-emerald-700 text-white shadow-md shadow-emerald-100' : 'text-slate-500 hover:text-emerald-600 hover:bg-slate-50'"
                class="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold transition-all duration-200">
            <i class="fas fa-chalkboard-teacher text-base"></i>
            <span>Guru</span>
        </button>

        <button @click="activeTab = 'orangtua'"
                :class="activeTab === 'orangtua' ? 'bg-gradient-to-r from-amber-500 to-amber-600 text-white shadow-md shadow-amber-100' : 'text-slate-500 hover:text-amber-600 hover:bg-slate-50'"
                class="flex-1 flex items-center justify-center gap-2 py-3 px-4 rounded-xl text-sm font-semibold transition-all duration-200">
            <i class="fas fa-users text-base"></i>
            <span>Orang Tua</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-4 rounded-xl border border-slate-100 flex items-center gap-4 hover:shadow-sm transition-all">
            <div class="w-12 h-12 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center text-xl"><i class="fas fa-user-shield"></i></div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Total Admin</p>
                <p class="text-xl font-bold text-slate-800"><?= count($adminUsers) ?> <span class="text-sm font-normal text-slate-400">Akun</span></p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-slate-100 flex items-center gap-4 hover:shadow-sm transition-all">
            <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl"><i class="fas fa-chalkboard-teacher"></i></div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Total Akun Guru</p>
                <p class="text-xl font-bold text-slate-800"><?= count($guruUsers) ?> <span class="text-sm font-normal text-slate-400">Akun</span></p>
            </div>
        </div>
        <div class="bg-white p-4 rounded-xl border border-slate-100 flex items-center gap-4 hover:shadow-sm transition-all">
            <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xl"><i class="fas fa-users"></i></div>
            <div>
                <p class="text-xs text-slate-500 font-medium">Total Akun Orang Tua</p>
                <p class="text-xl font-bold text-slate-800"><?= count($ortuUsers) ?> <span class="text-sm font-normal text-slate-400">Akun</span></p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        
        <div class="p-5 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative w-full md:w-80">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                <input type="text" placeholder="Cari username atau email..." 
                       class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:bg-white transition-all">
            </div>
        </div>

        <div class="overflow-x-auto">
            
            <div x-show="activeTab === 'admin'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50 text-slate-600 text-sm border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">User Akun</th>
                            <th class="px-6 py-4 font-semibold">Role</th>
                            <th class="px-6 py-4 font-semibold">Dibuat Pada</th>
                            <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        <?php if (empty($adminUsers)) : ?>
                            <tr><td colspan="4" class="text-center py-6 text-slate-500">Belum ada akun admin.</td></tr>
                        <?php else : ?>
                            <?php foreach ($adminUsers as $user) : ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold"><?= strtoupper(substr($user['username'], 0, 1)) ?></div>
                                            <div>
                                                <p class="font-bold text-slate-800"><?= esc($user['username']) ?></p>
                                                <p class="text-xs text-slate-400">ID Akun: #<?= $user['id'] ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">Admin</span></td>
                                    <td class="px-6 py-4 text-slate-500"><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="/admin/akun/edit/<?= $user['id'] ?>" class="w-8 h-8 rounded-lg text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 flex items-center justify-center transition-all" title="Edit Data"><i class="fas fa-edit"></i></a>
                                            <a href="/admin/akun/delete/<?= $user['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')" class="w-8 h-8 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-all" title="Hapus"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div x-show="activeTab === 'guru'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50 text-slate-600 text-sm border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">User Akun</th>
                            <th class="px-6 py-4 font-semibold">Nama Guru</th>
                            <th class="px-6 py-4 font-semibold">Dibuat Pada</th>
                            <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        <?php if (empty($guruUsers)) : ?>
                            <tr><td colspan="4" class="text-center py-6 text-slate-500">Belum ada akun guru.</td></tr>
                        <?php else : ?>
                            <?php foreach ($guruUsers as $user) : ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">G</div>
                                            <div>
                                                <p class="font-bold text-slate-800"><?= esc($user['username']) ?></p>
                                                <p class="text-xs text-slate-400">ID Akun: #<?= $user['id'] ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-slate-600 font-medium flex items-center gap-1.5">
                                            <i class="fas fa-link text-emerald-500 text-xs"></i> <?= esc($user['nama_lengkap']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500"><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="/admin/akun/edit/<?= $user['id'] ?>" class="w-8 h-8 rounded-lg text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 flex items-center justify-center transition-all" title="Edit Data"><i class="fas fa-edit"></i></a>
                                            <a href="/admin/akun/delete/<?= $user['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')" class="w-8 h-8 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-all" title="Hapus"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div x-show="activeTab === 'orangtua'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-y-4">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50 text-slate-600 text-sm border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-4 font-semibold">User Akun</th>
                            <th class="px-6 py-4 font-semibold">Nama Orang Tua</th>
                            <th class="px-6 py-4 font-semibold">Dibuat Pada</th>
                            <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        <?php if (empty($ortuUsers)) : ?>
                            <tr><td colspan="4" class="text-center py-6 text-slate-500">Belum ada akun orang tua.</td></tr>
                        <?php else : ?>
                            <?php foreach ($ortuUsers as $user) : ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center font-bold">O</div>
                                            <div>
                                                <p class="font-bold text-slate-800"><?= esc($user['username']) ?></p>
                                                <p class="text-xs text-slate-400">ID Akun: #<?= $user['id'] ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-slate-600 font-medium flex items-center gap-1.5">
                                            <i class="fas fa-link text-amber-500 text-xs"></i> <?= esc($user['nama_lengkap']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500"><?= date('d M Y', strtotime($user['created_at'])) ?></td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="/admin/akun/edit/<?= $user['id'] ?>" class="w-8 h-8 rounded-lg text-slate-500 hover:text-emerald-600 hover:bg-emerald-50 flex items-center justify-center transition-all" title="Edit Data"><i class="fas fa-edit"></i></a>
                                            <a href="/admin/akun/delete/<?= $user['id'] ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini?')" class="w-8 h-8 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 flex items-center justify-center transition-all" title="Hapus"><i class="fas fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
<?= $this->endSection() ?>