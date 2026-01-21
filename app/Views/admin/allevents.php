<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>
<head>
     <link rel="stylesheet" href="/assets/css/admin/eventapproval.css">
       <link rel="stylesheet" href="/assets/css/pagination.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<main class="content-wrapper">
    <section>
    <div class="content-header">
        <h2>All Events</h2>
    </div>
        
    <?php if (session()->getFlashdata('message')): ?>
        <div class="message">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>
    
        <?php if (session()->getFlashdata('error')): ?>
        <div class="error">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form class="filters-container">
        <input type="text" name="title" placeholder="Search by Event Title..." value="<?= esc($title ?? '') ?>">
        
        <select name="status">
            <option value="">All Statuses</option>
            <option value="0" <?= (isset($status) && $status === '0') ? 'selected' : '' ?>>Pending</option>
            <option value="1" <?= (isset($status) && $status === '1') ? 'selected' : '' ?>>Approved</option>
            <option value="2" <?= (isset($status) && $status === '2') ? 'selected' : '' ?>>Rejected</option>
        </select>
        
        <input type="text" name="date" class="datepicker-range" placeholder="Select Date Range" value="<?= esc($date ?? '') ?>">

        <button type="reset" class="btn-reset-filters">Reset</button>
    </form>

    <div class="table-container" id="table-container">
        <?= $this->include('admin/partials/events_table') ?>
    </div>
    
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="/assets/js/admin/filter_pagination.js"></script>
