<div class="table-responsive">
    <table class="table table-bordered" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Message</th>
                <th>Status</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($queries)): ?>
                <?php foreach ($queries as $query): ?>
                <tr>
                    <td><?= $query['id'] ?></td>
                    <td><?= esc($query['name']) ?></td>
                    <td><?= esc($query['email']) ?></td>
                    <td><?= esc($query['subject']) ?></td>
                    <td><?= esc(strlen($query['message']) > 50 ? substr($query['message'], 0, 50) . '...' : $query['message']) ?></td>
                    <td>
                        <?php if ($query['status'] == 0): ?>
                            <span class="badge bg-warning text-dark">Pending</span>
                        <?php else: ?>
                            <span class="badge bg-success">Resolved</span>
                        <?php endif; ?>
                    </td>
                    <td><?= date('d M Y, h:i A', strtotime($query['created_at'])) ?></td>
                    <td>
                        <a href="<?= base_url('admin/contact-queries/toggle-status/' . $query['id']) ?>" class="btn btn-sm btn-<?= ($query['status'] == 0) ? 'success' : 'warning' ?> ajax-action-btn">
                            <?= ($query['status'] == 0) ? 'Mark Resolved' : 'Mark Pending' ?>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="text-align: center;">No queries found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="row">
    <?= $pager->links('default', 'bootstrap') ?>
</div>
