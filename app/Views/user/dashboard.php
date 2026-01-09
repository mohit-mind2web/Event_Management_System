<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>

<main class="content-wrapper">
    <div class="container mt-4">
        <h1>Welcome, <?= auth()->user()->full_name ?>!</h1>
        <p>This is your User dashboard.</p>
        <div class="alert alert-success">
            You are logged in as a standard user.
        </div>
    </div>
</main>
</body>
</html>
