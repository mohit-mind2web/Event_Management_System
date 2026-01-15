<?= $this->include('partials/userheader') ?>

<head>
    <link rel="stylesheet" href="/assets/css/user/events.css">
</head>

<main class="content-wrapper">
    <section>
        <h2>Upcoming Events</h2>
        
        <?php if (session()->getFlashdata('message')): ?>
            <div style="background:#d4edda; color:#155724; padding:10px; border-radius:4px; margin: 10px 20px;">
                <?= session()->getFlashdata('message') ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div style="background:#f8d7da; color:#721c24; padding:10px; border-radius:4px; margin: 10px 20px;">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <div class="container">
            <?php if (!empty($eventdetails)): ?>
                <div class="events-grid">
                    <?php foreach ($eventdetails as $events): ?>
                        <?php $startDate = strtotime($events['start_datetime']);
                        $endDate = strtotime($events['end_datetime']);
                        $startDay = date('d M Y', $startDate);
                        $endDay = date('d M Y', $endDate);
                        ?>
                        <div class="card">
                            <img src="/<?= esc($events['banner_image']) ?>" alt="<?= esc($events['title']) ?>">
                            <div class="event-body">
                                <h3><?= esc($events['title']) ?></h3>

                                <p><strong>Date:</strong>
                                    <?php if ($startDay == $endDay): ?>
                                        <?= $startDay ?>
                                    <?php else: ?>
                                        <?= $startDay . ' - ' . $endDay ?>
                                    <?php endif; ?>
                                </p>

                                <p><strong>Time:</strong> <?= date('g:i A', $startDate) . " to " . date('g:i A', $endDate) ?></p>
                                <p><strong>Location:</strong> <?= esc($events['location']) ?></p>
                                <div class="paid">
                                    <?php if ($events['is_paid']): ?>
                                        <span class="badge paid-badge">Paid: ₹<?= esc($events['price']) ?></span>
                                    <?php else: ?>
                                        <span class="badge free-badge">Free</span>
                                    <?php endif; ?>
                                </div>
                                <div class="event-actions">
                                    <a href="/user/events/view/<?= $events['id'] ?>" class="btn btn-outline-primary btn-sm">View Details</a>
                                    
                                    <?php 
                                    $userReg = $userRegistrations[$events['id']] ?? null;
                                    ?>

                                    <?php if ($userReg): ?>
                                        <?php if ($events['is_paid'] && $userReg['payment_status'] != 'paid'): ?>
                                            <a href="/user/events/register/<?= $events['id'] ?>" class="btn btn-warning btn-sm">Complete Payment !</a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-sm" disabled>Registered</button>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <a href="/user/events/register/<?= $events['id'] ?>" class="btn btn-primary btn-sm">Register Now</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p>No upcoming events available at the moment.</p>
            <?php endif; ?>
        </div>
    </section>
</main>