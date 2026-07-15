<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->include('guru/layouts/header') ?>
</head>

<body class="bg-slate-50 text-slate-700 antialiased" x-data="{ sidebarOpen: false }">

<div class="min-h-screen flex flex-col">

    <?= $this->include('guru/layouts/navbar') ?>

    <div class="flex flex-1 relative">

        <?= $this->include('guru/layouts/sidebar') ?>

        <main class="flex-1 w-full min-w-0 p-6 animate-fade-in">
            <?= $this->renderSection('content') ?>
        </main>

    </div>

    <div class="w-full">
        <?= $this->include('guru/layouts/footer') ?>
    </div>

</div>

</body>
</html>