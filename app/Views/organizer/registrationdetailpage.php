<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Registration Details</title>
    <link rel="stylesheet" href="/assets/css/admin/eventapproval.css">
    <link rel="stylesheet" href="/assets/css/pagination.css">
    <link rel="stylesheet" href="/assets/css/organizer/myevents.css">
</head>
<main>
    <section>
        <div class="back-reg" style="margin-bottom: 20px;">
            <a href="/organizer/eventregistrations" class="back-button">&larr; Back to Registrations</a>
        </div>
        <div class="detail-page">
            <h2>User Registrations for <?= esc($title) ?></h2>
            <p><strong>Event Date/Time: </strong> <?= date('d M Y h:i A', strtotime($start_datetime)) ?></p>
            <p><strong>Event Status: </strong><?= $start_datetime > date('Y-m-d H:i:s') ? "<span class='badge badge-upcoming'>Upcoming</span>" : 
            "<span class='badge badge-close'>Completed</span>" ?></p>
            
            <form action="" method="get" class="filters-container" style="margin-top: 20px;">
                <div class="filter-group start">
                    <div class="search-box">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="Search by name or email..." value="<?= esc($search ?? '') ?>">
                    </div>
                </div>
                <div class="filter-group end" style="align-items: center; gap: 10px;">
                    <select name="payment_status" class="filter-select">
                        <option value="">All Payments</option>
                        <option value="paid" <?= ($payment_status ?? '') === 'paid' ? 'selected' : '' ?>>Paid</option>
                        <option value="unpaid" <?= ($payment_status ?? '') === 'unpaid' ? 'selected' : '' ?>>Unpaid</option>
                    </select>

                    <select name="checkin_status" class="filter-select">
                        <option value="">All Check-in</option>
                        <option value="1" <?= ($checkin_status ?? '') === '1' ? 'selected' : '' ?>>Checked In</option>
                        <option value="0" <?= ($checkin_status ?? '') === '0' ? 'selected' : '' ?>>Not Checked In</option>
                    </select>

                    <a href="/organizer/eventregistrationdetails/<?= $eventId ?>" class="btn-reset-filters" style="color: #6c757d; text-decoration: none;" title="Reset Filters">
                        <i class="fas fa-undo"></i>
                    </a>

                    <a href="/organizer/eventregistrationdetails/<?= $eventId ?>/export<?= $search ? '?search='.esc($search) : '' ?>" class="btn btn-primary" id="export-btn">
                        <i class="fas fa-file-export"></i> Export CSV
                    </a>
                </div>
            </form>

            <div class="usersdetails" id="table-container">
                <?= $this->include('organizer/partials/registration_details_table') ?>
            </div>
        </div>
    </section>
</main>
<script src="/assets/js/organizer/filter_pagination.js"></script>
<script>
    // Update export link when any filter changes
    document.addEventListener('DOMContentLoaded', function() {
        const filtersForm = document.querySelector('.filters-container');
        const exportBtn = document.getElementById('export-btn');
        
        if (filtersForm && exportBtn) {
            const baseUrl = exportBtn.getAttribute('href').split('?')[0];

            function updateExportUrl() {
                const formData = new FormData(filtersForm);
                const params = new URLSearchParams();
                
                for (const [key, value] of formData.entries()) {
                    if (value) {
                         params.append(key, value);
                    }
                }
                
                const queryString = params.toString();
                exportBtn.setAttribute('href', baseUrl + (queryString ? '?' + queryString : ''));
            }

            // Listen to all inputs/selects in the form
            filtersForm.querySelectorAll('input, select').forEach(input => {
                input.addEventListener('input', updateExportUrl);
                input.addEventListener('change', updateExportUrl);
            });
            
            // Initial update
            updateExportUrl();
        }
    });
</script>
