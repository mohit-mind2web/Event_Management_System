<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>

<head>
    <link rel="stylesheet" href="/assets/css/admin/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<main class="content-wrapper">
    <section>
        <div class="cards">
            <div class="card">
                <div class="icon bg-green">
                    <i class="fa-solid fa-calendar-check text-green"></i>
                </div>
                <div class="detail">
                    <h3>Total Events</h3>
                    <p><?= esc($stats['totalevents']) ?></p>
                </div>
            </div>
            <div class="card">
                <div class="icon bg-blue">
                    <i class="fa-solid fa-user-check text-blue"></i>
                </div>
                <div class="detail">
                    <h3>Total Registrations</h3>
                    <p><?= esc($stats['totalregistrations']) ?></p>
                </div>
            </div>
            <div class="card">
                <div class="icon bg-orange">
                    <i class="fa-solid fa-wallet text-orange"></i>
                </div>
                <div class="detail">
                    <h3>Total Revenue</h3>
                    <p>₹<?= esc(number_format($stats['totalrevenue'], 2)) ?></p>
                </div>
            </div>
            <div class="card">
                <div class="icon bg-purple">
                    <i class="fa-solid fa-users text-purple"></i>
                </div>
                <div class="detail">
                    <h3>Total Users</h3>
                    <p><?= $users['totalusers'] ?></p>
                </div>
            </div>
            <div class="card">
                <div class="icon bg-cyan">
                    <i class="fa-solid fa-user-clock text-cyan"></i>
                </div>
                <div class="detail">
                    <h3>Active Users</h3>
                    <p><?= $users['activeusers'] ?></p>
                </div>
            </div>
            <div class="card">
                <div class="icon bg-brown">
                    <i class="fa-solid fa-user-tie text-brown"></i>
                </div>
                <div class="detail ">
                    <h3>Total Organizers</h3>
                    <p><?= $users['totalorganizers'] ?></p>
                </div>
            </div>
        </div>

        <div class="charts">
            <div class="chart">
                <h3>Event Approval Status</h3>
                <div id="eventStatusChart"></div>
            </div>
            <div class="chart">
                 <h3>Event Registrations Trend (Last 7 days)</h3>
                <div id="registrationsChart"></div>
            </div>
            <div class="chart">
                <h3>Monthly Payment Revenue</h3>
                <div id="paymentsChart"></div>
            </div>
        </div>
    </section>
</main>
<script>
    window.eventstatusdata = {
        approved: <?= $events['approved'] ?>,
        pending: <?= $events['pending'] ?>,
        rejected: <?= $events['rejected'] ?>
    }
   window.paymentChartData = {
    months: <?= json_encode(array_map(fn($p) => date('M', mktime(0,0,0,$p['month'],1)),   $payments)) ?>,
    totals: <?= json_encode(array_column($payments, 'totalamount')) ?>
};

window.registrationChartData = {
    dates: <?= json_encode(array_column($registrations, 'date')) ?>,
    totals: <?= json_encode(array_column($registrations, 'total')) ?>
};
</script>
<script src="/assets/js/admin/dashboardchart.js"></script>