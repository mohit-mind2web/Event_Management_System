<div class="sidebar">
        <?php
        $current_page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        ?>
        <?php if (auth()->user()->inGroup('user')): ?>
            <ul>
                <li><a href="/user/events" class="<?= $current_page == '/user/events' ? 'active' : '' ?>"><i class="fas fa-heart"></i>Events</a></li>
                <li><a href="/user/registrations" class="<?= $current_page == '/user/registrations' ? 'active' : '' ?>"><i class="fas fa-calendar-check"></i>My Registrations</a></li>
                <li><a href="/user/payments" class="<?= $current_page == '/user/payments' ? 'active' : '' ?>"><i class="fas fa-credit-card"></i>Payments</a></li>
                <li><a href="/user/myprofile" class="<?= $current_page == '/user/myprofile' ? 'active' : '' ?>"><i class="fas fa-user"></i>My Profile</a></li>
                <li><a href="/logout"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        <?php endif; ?>
        
        <?php if (auth()->user()->inGroup('organizer')): ?>
            <ul>
                <li><a href="/organizer/dashboard" class="<?= $current_page == '/organizer/dashboard' ? 'active' : '' ?>"><i class="fas fa-chart-line"></i>Dashboard</a></li>
                <li><a href="/organizer/createevent" class="<?= $current_page == '/organizer/createevent' ? 'active' : '' ?>"><i class="fas fa-users-cog"></i>Create Events</a></li>
                <li><a href="/organizer/myevents" class="<?= $current_page == '/organizer/myevents' ? 'active' : '' ?>"><i class="fas fa-users-cog"></i>My Events</a></li>
                <li><a href="/organizer/eventregistrations" class="<?= $current_page == '/organizer/eventregistrations' ? 'active' : '' ?>"> <i class="fas fa-flag"></i>Event Registrations</a></li>
                <li><a href="/organizer/scan-ticket" class="<?= $current_page == '/organizer/scan-ticket' ? 'active' : '' ?>"> <i class="fas fa-qrcode"></i>Scan Ticket</a></li>
                <li><a href="/logout"> <i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        <?php endif; ?>

        <?php if (auth()->user()->inGroup('admin')): ?>
            <ul>
                <li><a href="/admin/dashboard" class="<?= $current_page == '/admin/dashboard' ? 'active' : '' ?>"><i class="fas fa-chart-line"></i>Dashboard</a></li>
                <li><a href="/admin/event-approval" class="<?= $current_page == '/admin/event-approval' ? 'active' : '' ?>"> <i class="fas fa-clipboard-check"></i>Event Approval</a></li>
                <li><a href="/admin/allevents" class="<?= $current_page == '/admin/allevents' ? 'active' : '' ?>"> <i class="fas fa-calendar-days"></i>All Events</a></li>
                <li><a href="/admin/manage-categories" class="<?= $current_page == '/admin/manage-categories' ? 'active' : '' ?>"> <i class="fas fa-layer-group"></i> Categories</a></li>
                <li><a href="/admin/eventregistrations" class="<?= $current_page == '/admin/eventregistrations' ? 'active' : '' ?>">  <i class="fas fa-users"></i>View Registrations</a></li>
                <li><a href="/admin/paymentmonitoring" class="<?= $current_page == '/admin/paymentmonitoring' ? 'active' : '' ?>">  <i class="fas fa-credit-card"></i>Payment Monitoring</a></li>
                <li><a href="/admin/manage-users" class="<?= $current_page == '/admin/manage-users' ? 'active' : '' ?>">   <i class="fas fa-users-cog"></i>Manage Users</a></li>
                <li><a href="/admin/contact-queries" class="<?= $current_page == '/admin/contact-queries' ? 'active' : '' ?>">   <i class="fas fa-envelope"></i>Contact Queries</a></li>
                <li><a href="/logout"> <i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        <?php endif; ?>
    </div>
