<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Queries</title>
    <link rel="stylesheet" href="/assets/css/admin/eventapproval.css">
    <link rel="stylesheet" href="/assets/css/pagination.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<main>
    <section>
        <div class="table-container_wrapper">
            <h2>Contact Queries</h2>

            <?php if(session()->getFlashdata('message')):?>
                <div class="message">
                    <?= session()->getFlashdata('message') ?>
                </div>
            <?php endif;?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="error">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- Filters -->
            <form class="filters-container">
                 <input type="text" name="email" class="form-control" placeholder="Filter by Email" value="<?= esc($filters['email']) ?>" style="min-width: 300px;">
                
                <select name="status" class="filter-select">
                    <option value="">All Status</option>
                    <option value="pending" <?= ($filters['status'] == 'pending') ? 'selected' : '' ?>>Pending</option>
                    <option value="resolved" <?= ($filters['status'] == 'resolved') ? 'selected' : '' ?>>Resolved</option>
                </select>
                
                <button type="reset" class="btn-reset-filters">Reset</button>
            </form>

            <div class="table-container" id="table-container">
                 <?= $this->include('admin/partials/contact_queries_table') ?>
            </div>
        </div>
    </section>
</main>
<script src="/assets/js/admin/filter_pagination.js"></script>
