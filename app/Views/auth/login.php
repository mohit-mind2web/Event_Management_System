   <?= $this->include('partials/header') ?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Event Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4">Login</h2>

                        <?php if (session('error') !== null) : ?>
                            <div class="alert alert-danger" role="alert"><?= session('error') ?></div>
                        <?php elseif (session('errors') !== null) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?php if (is_array(session('errors'))) : ?>
                                    <?php foreach (session('errors') as $error) : ?>
                                        <?= $error ?>
                                        <br>
                                    <?php endforeach ?>
                                <?php else : ?>
                                    <?= session('errors') ?>
                                <?php endif ?>
                            </div>
                        <?php endif ?>

                        <?php if (session('message') !== null) : ?>
                        <div class="alert alert-success" role="alert"><?= session('message') ?></div>
                        <?php endif ?>

                        <form action="<?= url_to('login') ?>" method="post">
                            <?= csrf_field() ?>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" inputmode="email" autocomplete="email" placeholder="Enter your email" value="<?= old('email') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" inputmode="text" autocomplete="current-password" placeholder="Enter Password" required>
                            </div>
                            <?php if (setting('Auth.sessionConfig')['allowRemembering']): ?>
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php if (old('remember')): ?> checked <?php endif ?>>
                                <label class="form-check-label" for="remember">
                                    Remember me
                                </label>
                            </div>
                            <?php endif; ?>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                            <p class="text-center mt-3">
                                Don't have an account? <a href="<?= url_to('register') ?>">Register</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <?= $this->include('partials/footer') ?>

