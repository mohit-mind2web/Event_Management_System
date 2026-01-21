<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Event Registrations</title>
    <link rel="stylesheet" href="/assets/css/admin/eventapproval.css">
      <link rel="stylesheet" href="/assets/css/pagination.css">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<main>
    <section>
        <h2>Event Registrations</h2>
        
        <form class="filters-container">
                <input type="text" name="title" placeholder="Search by Event Name..." value="<?= esc($title ?? '') ?>">
            <input type="text" name="date" class="datepicker-range filter-select" placeholder="Select Date Range" value="<?= esc($date ?? '') ?>">
            <button type="reset" class="btn-reset-filters">Reset</button>
        </form>

        <div class="event-registrations" id="table-container">
             <?= $this->include('admin/partials/eventregistration_table') ?>
        </div>
    </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="/assets/js/admin/filter_pagination.js"></script>
