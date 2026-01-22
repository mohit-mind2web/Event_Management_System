<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Event Managemnt System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="/assets/css/userheader.css" />
    <link rel="stylesheet" href="/assets/css/background.css">
    <script src="/assets/js/header.js"></script>
</head>

<body>
    <header>
        <div class="header">
            <div class="logo">
                <a href="/user/home">
                    <h1>Event<span>ease</span></h1>
                </a>
            </div>
            <div class="nav-items">
                <?php $current_page = $_SERVER['REQUEST_URI']; ?>
                <ul>
                    <li><a href="/user/home" class="<?= $current_page == '/user/home' ? 'active' : '' ?>"><i class="fa fa-home"></i>Home</a></li>
                    <li><a href="/user/events" class="<?= $current_page == '/user/events' ? 'active' : '' ?>"><i class="fas fa-heart"></i>Events</a></li>
                    <?php if (auth()->loggedIn()): ?>
                        <li><a href="/user/registrations" class="<?= $current_page == '/user/registrations' ? 'active' : '' ?>"><i class="fas fa-calendar-check"></i>My Registrations</a></li>
                        <li><a href="/user/payments" class="<?= $current_page == '/user/payments' ? 'active' : '' ?>"><i class="fas fa-credit-card"></i>Payments</a></li>
                    <?php endif; ?>
                    <li><a href="/contact" class="<?= $current_page == '/contact' ? 'active' : '' ?>"><i class="fas fa-envelope"></i>Contact Support</a></li>
                </ul>
            </div>
            <div class="nav">
                <?php if (auth()->loggedIn()): ?>
                    <h2>Welcome <?= auth()->user()->full_name ?> !</h2>
                    <i onclick="menu(event)" class="fas fa-bars menu-icon"></i>

                    <div class="profile">
                        <nav>
                            <ul>
                                <li><a href="/user/profile/<?= auth()->user()->id ?>">Your Profile</a></li>
                                <li><a href="/contact">Get Help</a></li>
                                <li><a href="/logout">Logout</a></li>
                            </ul>
                        </nav>
                    </div>
                <?php else: ?>
                    <a href="/login" class="btn-login" style="margin-right: 10px; color: white;">Login</a>
                    <a href="/register" class="btn-register" style="color: white;">Register</a>
                <?php endif; ?>
            </div>
        </div>
        </div>

        <?php
        $current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $pageTitle = '';
        $breadcrumbLink = '';
        $parentBreadcrumb = null;

        if (strpos($current_path, '/user/home') !== false) {
            $pageTitle = 'User Dashboard';
            $breadcrumbLink = '/user/home';
        } elseif (strpos($current_path, '/user/events/view/') !== false) {
            $pageTitle = isset($event['title']) ? $event['title'] : 'Event Details';
            $breadcrumbLink = '#';
            $parentBreadcrumb = [
                'title' => 'All Events',
                'link' => '/user/events'
            ];
        } elseif (strpos($current_path, '/user/events/summary') !== false) {
            $pageTitle = 'Event Registration';
            $breadcrumbLink = $current_page;
            $parentBreadcrumb = [
                'title' => 'All Events',
                'link' => '/user/events'
            ];
        } elseif (strpos($current_path, '/user/payment/cancel') !== false) {
            $pageTitle = 'Payment Failed';
            $breadcrumbLink = $current_page;
        } elseif (strpos($current_path, 'payment/success') !== false) {
            $pageTitle = 'Payment Success';
            $breadcrumbLink = $current_page;
        } elseif (strpos($current_path, '/user/events') !== false) {
            $pageTitle = 'All Events';
            $breadcrumbLink = '/user/events';
        } elseif (strpos($current_path, '/user/registrations') !== false) {
            $pageTitle = 'My Registrations';
            $breadcrumbLink = '/user/registrations';
        } elseif (strpos($current_path, '/user/payments') !== false) {
            $pageTitle = 'Payment History';
            $breadcrumbLink = '/user/payments';
        } elseif (strpos($current_path, '/contact') !== false) {
            $pageTitle = 'Contact Us';
            $breadcrumbLink = '/contact';
        } elseif (strpos($current_path, '/user/profile') !== false) {
            $pageTitle = 'User Profile';
            $breadcrumbLink = '/user/profile';
        } 

        if (empty($pageTitle)) {
            if (strpos($current_path, 'payment/success') !== false) {
                 $pageTitle = 'Payment Success';
            } else {
                 $pageTitle = 'Event Ease'; // Generic Fallback
            }
            $breadcrumbLink = '#';
        }
        ?>

        <?php if (strpos($current_path, '/user/home') === false && strpos($current_path, '/contact') === false): ?>
            <div class="bg-image">
                <div class="bg-color"> </div>
                <div class="bg-container">
                    <h2 class="bg-title"><?= strtoupper($pageTitle) ?></h2>
                </div>
                <div class="bg-container">
                    <div class="row1">
                        <ul>
                            <li><a href="/user/home">Home > </a></li>
                            <?php if ($parentBreadcrumb): ?>
                                <li><a href="<?= $parentBreadcrumb['link'] ?>"><?= $parentBreadcrumb['title'] ?> > </a></li>
                            <?php endif; ?>
                            <li><a href="<?= $breadcrumbLink ?>" class="active"><?= $pageTitle ?></a></li>
                        </ul>
                    </div>
                </div>

            </div>
        <?php endif; ?>
    </header>
    <