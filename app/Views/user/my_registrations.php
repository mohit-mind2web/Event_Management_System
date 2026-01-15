<?= $this->include('partials/userheader') ?>

<head>
    <link rel="stylesheet" href="/assets/css/user/myregistrations.css">
</head>

<main class="content-main">
    <section>
        <div class="registrations-container">
            <h2>My Registrations</h2>

            <?php if (session()->getFlashdata('message')): ?>
                <div style="background:#d4edda; color:#155724; padding:10px; border-radius:4px; margin-bottom:15px;">
                    <?= session()->getFlashdata('message') ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($registrations)): ?>
                <?php foreach ($registrations as $reg): ?>
                    <div class="registration-item">
                        <img src="/<?= esc($reg['event']['banner_image'] ?? 'assets/images/default-event.png') ?>" alt="Event" class="event-thumb">
                        <div class="reg-details">
                            <div class="reg-header">
                                <h3><?= esc($reg['event']['title'] ?? 'Event Deleted') ?></h3>
                                <?php if ($reg['payment_status'] === 'paid' || $reg['payment_status'] === 'free' && $reg['status'] === 'confirmed'): ?>
                                    <a href="/user/ticket/<?= esc($reg['id']) ?>" class="btn btn-outline-primary my-registrations">
                                        <i class="fas fa-ticket-alt"></i> View Ticket
                                    </a>
                                <?php endif; ?>
                            </div>
                            <div class="reg-description">
                                <p><strong>Date:</strong> <?= date('d M Y, h:i A', strtotime($reg['event']['start_datetime'])) ?><br></p>
                                <p><strong>Registered On:</strong> <?= date('d M Y', strtotime($reg['registration_date'])) ?><br></p>
                                <p><strong>Payment:</strong> <?= ucfirst($reg['payment_status']) ?><br></p>
                                <p><strong>Status:</strong> <span class="status-badge status-<?= $reg['status'] ?>"><?= ucfirst($reg['status']) ?></span></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>You haven't registered for any events yet.</p>
            <?php endif; ?>
        </div>
    </section>
</main>