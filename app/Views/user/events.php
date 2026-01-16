<?= $this->include('partials/userheader') ?>

<head>
    <link rel="stylesheet" href="/assets/css/user/events.css">
   
</head>

<main class="content-wrapper">
        <section>
        <div class="event-container">
            <h2>All Events</h2>
            
            <?php if (session()->getFlashdata('message')): ?>
                <div class="alert-message success">
                    <?= session()->getFlashdata('message') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert-message error">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Filter Section -->
            <div class="filters-container">
                <div class="filter-group start">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" id="eventSearch" placeholder="Search events, location..." autocomplete="off">
                    </div>
                </div>
                <div class="filter-group end">
                    <select id="priceFilter" class="filter-select">
                        <option value="">All Prices</option>
                        <option value="free">Free</option>
                        <option value="paid">Paid</option>
                    </select>
                    <select id="categoryFilter" class="filter-select">
                        <option value="">All Categories</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= esc($cat['id']) ?>"><?= esc($cat['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <select id="dateFilter" class="filter-select">
                        <option value="">Any Date</option>
                        <option value="today">Today</option>
                        <option value="tomorrow">Tomorrow</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                    </select>
                    <button id="resetFilters" class="btn-reset-filters" title="Reset Filters">
                        <i class="fas fa-undo"></i> Reset
                    </button>
                </div>
            </div>

            <div class="container" id="events-wrapper">
                <?= $this->include('user/partials/events_list') ?>
            </div>
        </div>
    </section>
</main>

<script src="/assets/js/user/events.js"></script>