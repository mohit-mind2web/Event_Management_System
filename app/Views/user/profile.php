<?= $this->include('partials/userheader') ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <!-- Reuse Organizer Profile CSS -->
    <link rel="stylesheet" href="/assets/css/organizer/profile.css">
</head>

<main>
    <section>
    <div class="profile-container">
        <div class="profile-header">
            <h2>My Profile</h2>
        </div>

        <?php if (session()->has('message')) : ?>
            <div class="alert alert-success">
                <?= session('message') ?>
            </div>
        <?php endif ?>

        <?php if (session()->has('error')) : ?>
            <div class="alert alert-danger">
                <?= session('error') ?>
            </div>
        <?php endif ?>

        <?php if (session()->has('errors')) : ?>
            <div class="alert alert-danger">
                <ul>
                <?php foreach (session('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php endif ?>

        <div class="profile-card">
            <div class="profile-card-header">
                <h3>Personal Information</h3>
                <button type="button" id="updateProfileBtn" class="btn-primary">Edit Profile</button>
            </div>
            <div class="profile-card-body">
                <div class="profile-info-group">
                    <div class="profile-info-label">Username</div>
                    <div class="profile-info-value"><?= esc($user->username) ?></div>
                </div>
                
                <div class="profile-info-group">
                    <div class="profile-info-label">Email Address</div>
                    <div class="profile-info-value"><?= esc($user->email) ?></div>
                </div>

                <div class="profile-info-group">
                    <div class="profile-info-label">Full Name</div>
                    <div class="profile-info-value"><?= esc($user->full_name) ?></div>
                </div>
            </div>
        </div>
    </div>
    </section>

    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Profile</h3>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('user/profile/update/' . $user->id) ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" class="form-control" value="<?= esc($user->username) ?>" readonly>
                        <small class="text-muted">Username cannot be changed.</small>
                    </div>

                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" id="email" class="form-control" value="<?= esc($user->email) ?>" readonly>
                        <small class="text-muted">Email address cannot be changed.</small>
                    </div>

                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" name="full_name" id="full_name" class="form-control" value="<?= esc($user->full_name) ?>" required>
                    </div>

                    <div class="form-group" style="text-align: right;">
                        <button type="submit" class="btn-primary" style="position: static;">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<!-- Reuse Organizer Profile JS -->
<script src="<?= base_url('assets/js/organizer/profile.js') ?>"></script>

<?= $this->include('partials/footer') ?>
