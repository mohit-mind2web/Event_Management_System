   <?= $this->include('partials/header') ?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Register - Event Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card p-4">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Register</h3>

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

                    <form action="<?= url_to('register') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" inputmode="email" autocomplete="email" placeholder="Enter your email address" value="<?= old('email') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" value="<?= old('username') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="full_name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter your full name" value="<?= old('full_name') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="group" class="form-label">I am a...</label>
                            <select class="form-select" id="group" name="group" required>
                                <option value="user" <?= old('group') === 'user' ? 'selected' : '' ?>>User (Attendee)</option>
                                <option value="organizer" <?= old('group') === 'organizer' ? 'selected' : '' ?>>Event Organizer</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" inputmode="text" autocomplete="new-password" placeholder="Password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password_confirm" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirm" name="password_confirm" inputmode="text" autocomplete="new-password" placeholder="Confirm Password" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-block">Register</button>
                        </div>

                        <div class="text-center mt-3">
                            <p>Already have an account? <a href="<?= url_to('login') ?>">Login</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <?= $this->include('partials/footer') ?>

