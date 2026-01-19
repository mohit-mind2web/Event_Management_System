<table class="table">
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
        <?php if (!empty($userregistrations)): ?>
            <?php $currentPage = $pager->getCurrentPage() ?: 1;
            $perPage = $pager->getPerPage() ?: 10;
            $start = ($currentPage - 1) * $perPage;
            ?>
            <?php foreach ($userregistrations as $index => $userrec): ?>
                <tr>
                    <td><?= $start + $index + 1 ?></td>
                    <td><?= esc($userrec['full_name']) ?></td>
                    <td><?= esc($userrec['email']) ?></td>
                    <td>
                        <span class="badge <?= $userrec['payment_status'] == 'paid' ? 'status-active' : 'status-pending' ?>">
                            <?= esc($userrec['payment_status']) ?>
                        </span>
                    </td>
                    <td>
                        <?php
                        // Smart Status Logic
                        $currentTime = date('Y-m-d H:i:s');
                        $startTime = isset($start_datetime) ? $start_datetime : date('Y-m-d H:i:s');
                        $endTime = isset($end_datetime) && $end_datetime ? $end_datetime : $startTime;

                        if ($userrec['check_in']) {
                            echo '<span class="badge badge-success" style="background-color: #28a745; color: white;">Checked In</span>';
                            echo '<br><small>' . date('h:i A', strtotime($userrec['checked_in_at'])) . '</small>';
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
                    <td><?= date('d M Y h:i A', strtotime($userrec['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" style="text-align:center;">No registrations found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<?= $pager->links('default', 'bootstrap') ?>