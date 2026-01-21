<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Monitring</title>
      <link rel="stylesheet" href="/assets/css/admin/eventapproval.css">
        <link rel="stylesheet" href="/assets/css/pagination.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<main>
<section>
    <h2>Payment Monitoring</h2>
    
    <form class="filters-container">
             <input type="text" name="search" placeholder="Search by Trans ID, User, Event..." value="<?= esc($search ?? '') ?>">
        
        <select name="status" class="filter-select">
            <option value="">All Statuses</option>
            <option value="success" <?= (isset($status) && $status === 'success') ? 'selected' : '' ?>>Success</option>
            <option value="pending" <?= (isset($status) && $status === 'pending') ? 'selected' : '' ?>>Pending</option>
            <option value="failed" <?= (isset($status) && $status === 'failed') ? 'selected' : '' ?>>Failed</option>
        </select>
        <input type="text" name="date" class="datepicker-range filter-select" placeholder="Select Date Range" value="<?= esc($date ?? '') ?>">
        <button type="reset" class="btn-reset-filters">Reset</button>
    </form>

    <div class="payment-details" id="table-container">
        <?= $this->include('admin/partials/payments_table') ?>
    </div>

</section>
</main>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="/assets/js/admin/filter_pagination.js"></script>