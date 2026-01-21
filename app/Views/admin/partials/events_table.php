<table>
    <thead>
        <tr>
            <th>S.No</th>
            <th>Event Title</th>
            <th>Organizer ID</th>
            <th>Date</th>
            <th>Location</th>
            <th>Paid / Free</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($eventsdata)): ?>
            <?php 
                $currentPage = $pager->getCurrentPage() ?? 1;
                $perPage = $pager->getPerPage() ?? 10;
                $start = ($currentPage - 1) * $perPage;
            ?>
            <?php foreach ($eventsdata as $index => $event): ?>
            <tr>
                <td><?= $start + $index + 1 ?></td>
                <td><?= esc($event['title']) ?></td>
                <td><?= esc($event['organizer_id']) ?></td> 
                <td><?= date('d M Y', strtotime($event['start_datetime'])) ?></td>
                <td><?= esc($event['location']) ?></td>
                <td><?= $event['is_paid'] ? 'Paid' : 'Free' ?></td>
                <td>
                    <?php if ($event['status'] == 0): ?>
                        <span class="badge badge-pending">Pending</span>
                    <?php elseif ($event['status'] == 1): ?>
                        <span class="badge badge-approved">Approved</span>
                    <?php else: ?>
                        <span class="badge badge-rejected">Rejected</span>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="/admin/event-details/<?= $event['id'] ?>?readonly=1" class="btn" style="background-color: #007bff; color: white;">View Details</a>
                </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" style="text-align:center;">No Events found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<div class="row">
    <?= $pager->links('default', 'bootstrap') ?>
</div>
