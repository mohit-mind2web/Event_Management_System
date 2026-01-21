<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Event Registrations</title>
    <link rel="stylesheet" href="/assets/css/admin/eventapproval.css">
    <link rel="stylesheet" href="/assets/css/pagination.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<main>
    <section>
        <h2>Event Registrations</h2>
        <form action="" method="get" class="filters-container">
                    <input type="text" name="search" placeholder="Search events..." value="<?= esc($search) ?>">
                 <input type="text" name="date_range" class="filter-select datepicker-range" value="<?= esc($date_range ?? '') ?>" placeholder="Select Date Range">
                 <a href="/organizer/eventregistrations" class="btn-reset-filters"><i class="fas fa-undo"></i> Reset</a>
        </form>
        <div class="event-registrations" id="table-container">
            <?= $this->include('organizer/partials/eventregistration_table') ?>
        </div>
    </section>
    </section>
</main>
<script src="/assets/js/organizer/filter_pagination.js"></script>
