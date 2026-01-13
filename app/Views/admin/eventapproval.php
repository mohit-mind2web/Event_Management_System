<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>

<head>
    <link rel="stylesheet" href="/assets/css/admin/eventapproval.css">
</head>

<main>
    <div class="table-container">
        <h2>Event Approval Requests</h2>
        
        <?php if (session()->getFlashdata('message')): ?>
            <div class="message">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>
        
         <?php if (session()->getFlashdata('error')): ?>
            <div class="error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

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
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $index => $event): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= esc($event['title']) ?></td>
                        <td><?= esc($event['organizer_id']) ?></td> 
                        <td><?= date('d M Y', strtotime($event['start_datetime'])) ?></td>
                        <td><?= esc($event['location']) ?></td>
                        <td><?= $event['is_paid'] ? 'Paid' : 'Free' ?></td>
                        <td><span class="badge badge-pending">Pending</span></td>
                        <td>
                            <a href="/admin/event-details/<?= $event['id'] ?>" class="btn" style="background-color: #007bff; color: white;">View Details</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align:center;">No Recent event requests found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>
