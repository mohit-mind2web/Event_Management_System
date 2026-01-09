<!doctype html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex flex-column h-100 bg-light">
    <?= $this->include('partials/header') ?>

    <div class="d-flex">
        <?= $this->include('partials/sidebar') ?>
        <main class="flex-grow-1 p-4 bg-light" style="min-height: 100vh;">
            <?= $this->renderSection('content') ?>
        </main>
    </div>

    <!-- Footer -->
    <?= $this->include('partials/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
