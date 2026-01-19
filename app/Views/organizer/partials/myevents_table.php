<table class="table">
    <thead>
        <tr>
            <th>S.No</th>
            <th>Event Title</th>
            <th>Date</th>
            <th>Location</th>
            <th>Capacity</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
         <?php if(!empty($events)):?>
                 <?php 
                        $currentPage = $pager->getCurrentPage() ?: 1;
                        $perPage = $pager->getPerPage() ?: 10;
                        $start = ($currentPage - 1) * $perPage;
                    ?>
        <?php foreach ($events as $index=> $event): ?>
            <tr>
                <td><?= $start+$index + 1 ?></td>
                <td>
                    <span><?= esc($event['title']) ?></span>
                    <?php if ($event['is_paid']): ?>
                        <span class="badge bg-success">(Paid)</span>
                    <?php endif; ?>
                </td>
                <td>
                    <?= date('M d, Y h:i A', strtotime($event['start_datetime'])) ?>
                </td>
                <td><?= esc($event['location']) ?></td>
                <td><?= esc($event['capacity']) ?></td>
                <td>
                    <?php
                    $statusLabel = 'Pending';
                    $statusClass = 'status-pending';
                    if ($event['status'] == 1) {
                        $statusLabel = 'Approved';
                        $statusClass = 'status-active';
                    } elseif ($event['status'] == 2) {
                        $statusLabel = 'Rejected';
                        $statusClass = 'status-inactive';
                    }
                    ?>
                    <span class="status-badge <?= $statusClass ?>">
                        <?= $statusLabel ?>
                    </span>
                </td>
                <td>
                    <a href="/organizer/events/view/<?= $event['id'] ?>" class="btn-view"> View </a>
                    <?php if ($event['status'] == 0 || $event['status'] == 2): ?>
                        <a href="/organizer/events/edit/<?= $event['id'] ?>"class="btn-edit"> Edit</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
   <?php else:?>
                <td colspan="9" style="text-align: center;">No events found.</td>
        <?php endif;?>
    </tbody>
</table>
    <?= $pager->links('default', 'bootstrap') ?>
