<?= $this->include('partials/userheader') ?>

<head>
    <link rel="stylesheet" href="/assets/css/user/events.css"> <!-- Reusing filter styles -->
    <link rel="stylesheet" href="/assets/css/user/myregistrations.css">
</head>

<main class="content-main">
    <section>
        <div class="registrations-container">
            <h2>My Registrations</h2>

            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert-message success">
                    <?= session()->getFlashdata('message') ?>
                </div>
            <?php endif; ?>

            <!-- Filter Section -->
            <div class="filters-container">
                <div class="filter-group start">
                    <!-- Placeholder or Search if needed, for now just spacing -->
                </div>
                <div class="filter-group end">
                    <select id="statusFilter" class="filter-select">
                        <option value="">All Status</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="pending">Pending</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <select id="paymentFilter" class="filter-select">
                        <option value="">All Payments</option>
                        <option value="paid">Paid</option>
                        <option value="free">Free</option>
                    </select>
                    <button id="resetFilters" class="btn-reset-filters" title="Reset Filters">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </div>

            <div id="registrations-wrapper">
                <?= $this->include('user/partials/registrations_list') ?>
            </div>
        </div>
    </section>
</main>

<script src="/assets/js/user/my_registrations.js"></script>