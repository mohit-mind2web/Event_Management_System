<div class="sidebar">
        <?php
        $current_page = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        ?>
        <?php if (auth()->user()->inGroup('user')): ?>
            <ul>
                <li><a href="/user/matches" class="<?= $current_page == '/user/matches' ? 'active' : '' ?>"><i class="fas fa-heart"></i>My Matches</a></li>
                <?php if ($_SESSION['profile_complete'] != 1): ?>
                    <li><a href="/user/profilecreate" class="<?= $current_page == '/user/profilecreate' ? 'active' : '' ?>"><i class="fas fa-user-check"></i>Complete Profile</a></li>
                <?php endif; ?>
                <li><a href="/user/interests" class="<?= $current_page == '/user/interests' ? 'active' : '' ?>"><i class="fas fa-handshake"></i>Interests Received</a></li>
                <li><a href="/user/shortlists" class="<?= $current_page == '/user/shortlists' ? 'active' : '' ?>"><i class="fas fa-bookmark"></i>Shortlists Profiles</a></li>
                <li><a href="/user/chatinbox" class="<?= $current_page == '/user/chatinbox' ? 'active' : '' ?>"><i class="fas fa-comments"></i>Chat Inbox</a></li>
                <li><a href="/user/queries" class="<?= $current_page == '/user/queries' ? 'active' : '' ?>"><i class="fas fa-question-circle"></i>Your queries</a></li>
                <li><a href="/user/contactsupport" class="<?= $current_page == '/user/contactsupport' ? 'active' : '' ?>"><i class="fas fa-headset"></i>Help & Support</a></li>
                <li><a href="/logout"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        <?php endif; ?>
        <?php if (auth()->user()->inGroup('organizer')): ?>
            <ul>
                <li><a href="/organizer/dashboard" class="<?= $current_page == '/organizer/dashboard' ? 'active' : '' ?>"><i class="fas fa-chart-line"></i>Dashboard</a></li>
                <li><a href="/organizer/createevent" class="<?= $current_page == '/organizer/createevent' ? 'active' : '' ?>"><i class="fas fa-users-cog"></i>Create Events</a></li>
                <li><a href="/organizer/myevents" class="<?= $current_page == '/organizer/myevents' ? 'active' : '' ?>"><i class="fas fa-users-cog"></i>My Events</a></li>
                <li><a href="/organizer/eventregistrations" class="<?= $current_page == '/organizer/eventregistrations' ? 'active' : '' ?>"> <i class="fas fa-flag"></i>Event Registrations</a></li>
                <li><a href="/logout"> <i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        <?php endif; ?>

        <?php if (auth()->user()->inGroup('admin')): ?>
            <ul>
                <li><a href="/admin/dashboard" class="<?= $current_page == '/admin/dashboard' ? 'active' : '' ?>"><i class="fas fa-chart-line"></i>Dashboard</a></li>
                <li><a href="/admin/usermanage" class="<?= $current_page == '/admin/usermanage' ? 'active' : '' ?>"><i class="fas fa-users-cog"></i>Manage Users</a></li>
                <li><a href="/admin/managequeries" class="<?= $current_page == '/admin/managequeries' ? 'active' : '' ?>"> <i class="fas fa-envelope-open-text"></i>Event Approval</a></li>
                <li><a href="/admin/managereports" class="<?= $current_page == '/admin/manageevents' ? 'active' : '' ?>"> <i class="fas fa-flag"></i>Manage Events</a></li>
                <li><a href="/admin/managereports" class="<?= $current_page == '/admin/manageevents' ? 'active' : '' ?>"> <i class="fas fa-flag"></i>Manage Categories</a></li>
                <li><a href="/admin/managereports" class="<?= $current_page == '/admin/manageevents' ? 'active' : '' ?>"> <i class="fas fa-flag"></i>View Registration</a></li>
                <li><a href="/admin/managereports" class="<?= $current_page == '/admin/manageevents' ? 'active' : '' ?>"> <i class="fas fa-flag"></i>Payment Monitoring</a></li>
                <li><a href="/admin/activity-logs" class="<?= $current_page == '/admin/activity-logs' ? 'active' : '' ?>"><i class="fas fa-clipboard-list"></i>Activity Logs</a></li>
                <li><a href="/logout"> <i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
        <?php endif; ?>
    </div>
