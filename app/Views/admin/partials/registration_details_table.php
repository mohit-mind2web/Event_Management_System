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
                            // status logic
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
