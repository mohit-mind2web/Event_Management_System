<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Events</title>
    <link href="/assets/css/organizer/myevents.css" rel="stylesheet">
</head>

<main>
    <section class="my-events">
        <h2>My Events</h2>

        <?php if (empty($events)): ?>
            <p>You haven't created any events yet.</p>
            <a href="/organizer/createevent" class="btn btn-primary">Create Your First Event</a>
        <?php else: ?>
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
                    <?php foreach ($events as $index=> $event): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
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
                </tbody>
            </table>
        <?php endif; ?>
    </section>
</main>