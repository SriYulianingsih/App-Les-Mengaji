<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->include('admin/layouts/header') ?>
</head>

<body class="bg-slate-50 text-slate-700" x-data="{ openSantri: true, openGuru: false, sidebarOpen: false }">

<div class="min-h-screen flex flex-col">

    <?= $this->include('admin/layouts/navbar') ?>

    <div class="flex flex-1 relative">

        <?= $this->include('admin/layouts/sidebar') ?>

        <main class="flex-1 p-6 animate-fade-in">
            <?= $this->renderSection('content') ?>
        </main>

    </div>

    <?= $this->include('admin/layouts/footer') ?>

</div>

</body>
</html>