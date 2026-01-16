<?= $this->include('partials/userheader') ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All transactions</title>
      <link rel="stylesheet" href="/assets/css/user/transaction.css">
      <link rel="stylesheet" href="/assets/css/user/events.css"> <!-- Reusing filter styles -->
</head>
<main>
    <section>
        <div class="payment-container">
        <h2>Payment History</h2>

        <!-- Filter Section -->
        <div class="filters-container">
            <div class="filter-group start">
                <!-- Placeholder -->
            </div>
            <div class="filter-group end">
                <select id="statusFilter" class="filter-select">
                    <option value="">All Status</option>
                    <option value="success">Success</option>
                    <option value="failed">Failed</option>
                    <option value="pending">Pending</option>
                </select>
                <select id="dateFilter" class="filter-select">
                    <option value="">All Dates</option>
                    <option value="week">This Week</option>
                    <option value="month">This Month</option>
                </select>
                <button id="resetFilters" class="btn-reset-filters" title="Reset Filters">
                        <i class="fas fa-undo"></i> Reset
                    </button>
            </div>
        </div>

        <div id="transactions-wrapper">
            <?= $this->include('user/partials/transactions_list') ?>
        </div>
        </div>
    </section>
</main>
<script src="/assets/js/user/transactions.js"></script>
