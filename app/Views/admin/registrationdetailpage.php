<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Users Registration Details</title>
      <link rel="stylesheet" href="/assets/css/admin/eventapproval.css">
        <link rel="stylesheet" href="/assets/css/pagination.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script> 
</head>
<main>
    <section>
        <div class="back-reg">
            <a href="/admin/eventregistrations" class="back-button">&larr; Back to Registrations</a>
        </div>
        <div class="detail-page">
            <h2>User Registrations for <?= esc($title) ?></h2>
            <p><strong>Event Date/Time : </strong> <?= esc($start_datetime) ?></p>
            <p><strong>Event Status : </strong><?= $start_datetime > date('Y-m-d H:i:s') ? "<span class='badge badge-upcoming'>Active</span>" : 
            "<span class='badge badge-close'>Closed</span>" ?></p>
            
            <form class="filters-container">
                        <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="<?= esc($search ?? '') ?>">
                     <button type="reset" class="btn-reset-filters">Reset</button>
                <div class="filter-group end">
                    <a href="<?= current_url() ?>/export<?= $search ? '?search='.esc($search) : '' ?>" class="btn btn-success" onclick="this.href = window.location.pathname + '/export' + window.location.search; return true;">
                        <i class="fas fa-file-export"></i> Export CSV
                    </a>
                </div>
            </form>

            <div class="usersdetails" id="table-container" style="margin-top: 20px;">
                <?= $this->include('admin/partials/registration_details_table') ?>
            </div>
        </div>
    </section>
</main>
<script src="/assets/js/admin/filter_pagination.js"></script>
