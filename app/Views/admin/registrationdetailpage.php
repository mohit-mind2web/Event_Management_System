<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Users Registration Details</title>
    <link rel="stylesheet" href="/assets/css/admin/eventapproval.css">
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
            <div class="filters-container" style="margin-top: 20px; display: flex; justify-content: flex-start;">
                <div class="filter-group start">
                    <form action="" method="get" style="display: flex; gap: 10px;">
                        <div class="search-box">
                            <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="<?= esc($search ?? '') ?>" style="width: 300px;">
                        </div>
                        <button type="submit" class="btn btn-primary">Search</button>
                        <?php if(!empty($search)): ?>
                            <a href="?" class="btn btn-secondary">Reset</a>
                        <?php endif; ?>
                    </form>
                </div>
                <div class="filter-group end" style="margin-left: auto;">
                    <a href="<?= current_url() ?>/export<?= $search ? '?search='.esc($search) : '' ?>" class="btn btn-success">
                        <i class="fas fa-file-export"></i> Export CSV
                    </a>
                </div>
            </div>

            <div class="usersdetails" style="margin-top: 20px;">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Payment Status</th>
                            <th>Check In Status</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($userregistrations)):?>
                             <?php  $currentPage = $pager->getCurrentPage() ?: 1;
                                    $perPage = $pager->getPerPage() ?: 20;
                                    $start = ($currentPage - 1) * $perPage;
                                ?>
                            <?php foreach($userregistrations as $index=>$registrations):?>
                                <tr>
                                    <td><?= $start+$index+1 ?></td>
                                    <td><?= esc($registrations['full_name']) ?></td>
                                    <td><?= esc($registrations['email']) ?></td>
                                    <td><?= esc($registrations['payment_status']) ?></td>
                                    <td>
                                        <?php 
                                            // Smart Status Logic
                                            $currentTime = date('Y-m-d H:i:s');
                                            $startTime = isset($start_datetime) ? $start_datetime : date('Y-m-d H:i:s');
                                            $endTime = isset($end_datetime) && $end_datetime ? $end_datetime : $startTime; 

                                            if ($registrations['check_in']) {
                                                echo '<span class="badge badge-success" style="background-color: #28a745; color: white;">Checked In</span>';
                                                echo '<br><small>' . date('h:i A', strtotime($registrations['checked_in_at'])) . '</small>';
                                            } elseif ($currentTime < $startTime) {
                                                 echo '<span class="badge badge-info" style="background-color: #17a2b8; color: white;">Upcoming</span>';
                                                 echo '<br><small style="font-size: 10px;">Check-in not started</small>';
                                            } elseif ($currentTime > $endTime) {
                                                echo '<span class="badge badge-danger" style="background-color: #dc3545; color: white;">Absent</span>';
                                            } else {
                                                echo '<span class="badge badge-secondary" style="background-color: #6c757d; color: white;">Not Checked In</span>';
                                            }
                                        ?>
                                    </td>
                                    <td><?= esc(date('Y-m-d H:i:s', strtotime($registrations['created_at']))) ?></td>
                                </tr>
                                <?php endforeach;?>
                                <?php else:?>
                                    <tr><td colspan="6" style="text-align: center;">No Registrations Found</td></tr>
                                    <?php endif;?>
                    </tbody>
                </table>
                 <div class="d-flex justify-content-center" style="margin-top: 20px;">
                    <?= $pager->links('default', 'bootstrap') ?>
                </div>
            </div>


        </div>
    </section>
</main>
