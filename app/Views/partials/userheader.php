<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Event Managemnt System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="/assets/css/header.css" />
    <script src="/assets/js/header.js"></script>
</head>

<body>
    <header class="header">
        <div class="logo">
            <a href="/user/matches">
                <h1>Event<span>ease</span></h1>
            </a>
        </div>
        <div class="nav-items">
             <?php $current_page = $_SERVER['REQUEST_URI']; ?>
            <ul>
                <li><a href="/user/home" class="<?= $current_page == '/user/home' ? 'active' : '' ?>">Home</a></li>
                <li><a href="/user/events" class="<?= $current_page == '/user/events' ? 'active' : '' ?>"><i class="fas fa-heart"></i>Events</a></li>
                <li><a href="/user/registrations" class="<?= $current_page == '/user/registrations' ? 'active' : '' ?>"><i class="fas fa-calendar-check"></i>My Registrations</a></li>
                <li><a href="/user/payments" class="<?= $current_page == '/user/payments' ? 'active' : '' ?>"><i class="fas fa-credit-card"></i>Payments</a></li>
                <li><a href="/user/myprofile" class="<?= $current_page == '/user/myprofile' ? 'active' : '' ?>"><i class="fas fa-user"></i>Profile</a></li>
            </ul>
            </div>
        <div class="nav">
            <h2>Welcome <?= auth()->user()->full_name ?> !</h2>
            <i onclick="menu(event)" class="fas fa-bars menu-icon"></i>
            
            <div class="profile">
                <nav>
                        <ul>
                            <li><a href="/user/profileview?id">Your Profile</a></li>
                            <li> <a href="/user/profileedit">Edit Profile</a></li>
                            <li><a href="/user/contactsupport">Get Help</a></li>
                            <li><a href="/logout">Logout</a></li>
                        </ul>
                </nav>
            </div>
        </div>
    </header>
</body>
</html>
