<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Event Name</th>
            <th>Event Date</th>
            <th>Capacity</th>
            <th>Total Registrations</th>
            <th>Confirmed</th>
            <th>Pending</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($registrations)):?>
                    <?php 
                        $currentPage = $pager->getCurrentPage() ?: 1;
                        $perPage = $pager->getPerPage() ?: 10;
                        $start = ($currentPage - 1) * $perPage;
                    ?>
            <?php foreach($registrations as $index=>$registration):?>
                <tr>
                    <td><?= $start+$index + 1 ?></td>
                    <td><?= esc($registration['title']) ?></td>
                    <td><?= date('d M Y', strtotime($registration['start_datetime'])) ?></td>
                    <td><?= esc($registration['capacity']) ?></td>
                    <td><?= esc($registration['total_registrations']) ?></td>
                    <td><?= esc($registration['confirmed_registrations']) ?></td>
                    <td><?= esc($registration['pending_registrations']) ?></td>
                    <td>
                        <?php if($registration['start_datetime'] > date('Y-m-d H:i:s')): ?>
                            <span class="badge badge-upcoming">Upcoming</span>
                        <?php else: ?>
                            <span class="badge badge-completed">Completed</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="/organizer/eventregistrationdetails/<?= $registration['id'] ?>" class="btn-view-details">View Details</a>
                    </td>
                </tr>
            <?php endforeach;?>
            <?php else:?>
                <td colspan="9" style="text-align: center;">No event registrations found.</td>
        <?php endif;?>
    </tbody>
</table>
<div class="row">
    <?= $pager->links('default', 'bootstrap') ?>
</div>
