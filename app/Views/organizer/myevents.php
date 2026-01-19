<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Events</title>
    <link href="/assets/css/organizer/myevents.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/pagination.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>

<main>
    <section class="my-events">
        <h2>My Events</h2>

        <form action="" method="get" class="filters-container">
            <div class="filter-group start">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" name="search" placeholder="Search events..." value="<?= esc($search) ?>">
                </div>
            </div>
            
            <div class="filter-group end">
                 <select name="status" class="filter-select" onchange="this.form.submit()">
                     <option value="">All Status</option>
                     <option value="1" <?= $status == '1' ? 'selected' : '' ?>>Approved</option>
                     <option value="0" <?= $status == '0' ? 'selected' : '' ?>>Pending</option>
                     <option value="2" <?= $status == '2' ? 'selected' : '' ?>>Rejected</option>
                 </select>
                 
                 <input type="text" name="date_range" class="filter-select datepicker-range" value="<?= esc($date_range ?? '') ?>" placeholder="Select Date Range">
                 
                 <a href="/organizer/myevents" class="btn-reset-filters"><i class="fas fa-undo"></i> Reset</a>
            </div>
        </form>

        <?php if (empty($events)): ?>
            <p>You haven't created any events yet.</p>
            <a href="/organizer/createevent" class="btn btn-primary">Create Your First Event</a>
        <?php else: ?>
            <div id="table-container">
                <?= $this->include('organizer/partials/myevents_table') ?>
            </div>
        <?php endif; ?>
    </section>
    </section>
</main>
<script src="/assets/js/organizer/filter_pagination.js"></script>