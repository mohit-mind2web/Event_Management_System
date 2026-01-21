<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($users)):?>
            <?php 
                $currentPage = $pager->getCurrentPage() ?? 1;
                $perPage = $pager->getPerPage() ?? 10;
                $start = ($currentPage - 1) * $perPage;
            ?>
            <?php foreach($users as $index=>$user):?>
                <tr>
                    <td><?= $start + $index + 1 ?></td>
                    <td><?= esc($user->full_name) ?></td>
                    <td><?= esc($user->email) ?></td>
                    <td><?= esc($user->role) ?></td>
                    <td><?= date('d M Y', strtotime($user->created_at)) ?></td>
                    <td>
                        <?php if($user->active): ?>
                            <span class="badge badge-success" style="background-color: #28a745; color: white;">Active</span>
                        <?php else: ?>
                            <span class="badge badge-danger" style="background-color: #dc3545; color: white;">Blocked</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if($user->active): ?>
                            <a href="/admin/manage-users/toggle-status/<?= $user->id ?>" class="btn ajax-action-btn" data-action="toggle-status" data-id="<?= $user->id ?>" style="background-color: #dc3545; color: white;     padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 12px;">Block</a>
                        <?php else: ?>
                            <a href="/admin/manage-users/toggle-status/<?= $user->id ?>" class="btn ajax-action-btn" data-action="toggle-status" data-id="<?= $user->id ?>" style="background-color: #28a745; color: white;     padding: 5px 10px; border-radius: 4px; text-decoration: none; font-size: 12px;">Unblock</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach;?>
        <?php else:?>
            <tr>
                <td colspan="6" style="text-align: center;">No Users Found</td>
            </tr>
        <?php endif;?>
    </tbody>
</table>
<div class="row">
    <?= $pager->links('default', 'bootstrap') ?>
</div>
