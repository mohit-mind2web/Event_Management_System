<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>

<head>
    <link rel="stylesheet" href="/assets/css/admin/eventapproval.css">
      <link rel="stylesheet" href="/assets/css/pagination.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<main>
    <section>
    <div class="table-container_wrapper"> 
        <h2>Event Approval Requests</h2>
        
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
                <input type="text" name="title" placeholder="Search by Event Name..." value="<?= esc($title ?? '') ?>">
            
            <input type="text" name="date" class="datepicker-range filter-select" placeholder="Select Date Range" value="<?= esc($date ?? '') ?>" style="min-width: 200px;">

            <button type="reset" class="btn-reset-filters">Reset</button>
        </form>

        <div class="table-container" id="table-container">
            <?= $this->include('admin/partials/eventapproval_table') ?>
        </div>
    </div>
    </section>
</main>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="/assets/js/admin/filter_pagination.js"></script>
