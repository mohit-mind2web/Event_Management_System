<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Event Managemnt System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="/assets/css/header.css" />
    <script src="/assets/js/tabs.js"></script>
</head>

<body>
    <header class="header">
        <div class="logo">
            <a href="/user/matches">
                <h1>Event<span>ease</span></h1>
            </a>
        </div>
        <div class="nav">
            <?php if (auth()->loggedIn()): ?>
            <h2>Welcome <?= auth()->user()->full_name ?> !</h2>
            <i onclick="menu(event)" class="fas fa-bars menu-icon"></i>
            
            <div class="profile">
                <nav>
                    <?php if (auth()->user()->inGroup('user')): ?>
                        <ul>
                            <li><a href="/user/profileview?id=<?= $_SESSION['user_id'] ?>">Your Profile</a></li>
                            <li> <a href="/user/profileedit">Edit Profile</a></li>
                            <li><a href="/user/contactsupport">Get Help</a></li>
                            <li><a href="/logout">Logout</a></li>
                        </ul>
                    <?php else: ?>
                        <ul>
                            <li><a href="/admin/managequeries">View Queries</a></li>
                            <li><a href="/logout">Logout</a></li>
                        </ul>
                    <?php endif; ?>

                </nav>
            </div>
            <?php else:?>
                <a class="auth" href="/login">Login</a>
                <a class="auth" href="/register">Register</a>
                <?php endif;?>
        </div>
    </header>
</body>
</html>
