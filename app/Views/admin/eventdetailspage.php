<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details - Admin Approval</title>
    <link href="/assets/css/organizer/eventdetails.css" rel="stylesheet">
</head>

<main class="content-main">
    <section class="event-details-container">
        
        <div class="back" style="margin-bottom: 20px;">
             <a href="/admin/event-approval" style="text-decoration: none; color: #333;">&larr; Back to Requests</a>
        </div>

        <div class="banner-container">
        <?php if(!empty($event['banner_image'])): ?>
            <img src="/<?= esc($event['banner_image']) ?>" alt="Event Banner" class="banner-image">
        <?php else: ?>
            <div class="nobanner">
                No Banner Image
            </div>
        <?php endif; ?>
        </div>
        
    <section class="event-head">
        <div class="event-header">
            <div class="free">
                <h2><?= esc($event['title']) ?></h2>
                <span class="status-badge <?= ($event['status'] == 1) ? 'status-active' : (($event['status'] == 2) ? 'status-inactive' : 'status-pending') ?>">
                    <?= ($event['status'] == 1) ? 'Approved' : (($event['status'] == 2) ? 'Rejected' : 'Approval Pending') ?>
                </span>
                <?php if($event['is_paid']): ?>
                    <span style="background-color: #e8f1ff;color:#084298;" class="badge bg-success ms-2">Paid: ₹<?= esc($event['price']) ?></span>
                <?php else: ?>
                    <span class="badge bg-secondary ms-2">Free</span>
                <?php endif; ?>
            </div>
            <div>
             <?php if ($event['status'] == 0 && empty($readonly)): ?>
                 <a href="/admin/event-details/approve/<?= $event['id'] ?>" class="btn-approve" onclick="return confirm('Are you sure you want to approve this event?')">Approve Event</a>
               <a href="/admin/event-details/reject/<?= $event['id'] ?>" class="btn-reject" onclick="return confirm('Do you really want to reject this event?')">Reject Event</a>
            <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="event-detail">
        <h2>Event Details</h2>
        <ul>
            <li><strong>Category:</strong> <?= esc($event['category_name']) ?></li>
            <li><strong>Subcategory:</strong> <?= esc($event['subcategory_name'] ?? 'N/A') ?></li>
            <li><strong>Location:</strong> <?= esc($event['location']) ?></li>
            <li><strong>Start Date:</strong> <?= date('M d, Y h:i A', strtotime($event['start_datetime'])) ?></li>
            <li><strong>End Date:</strong> <?= date('M d, Y h:i A', strtotime($event['end_datetime'])) ?></li>
            <li><strong>Capacity:</strong> <?= esc($event['capacity']) ?> People</li>
            <li><strong>Price:</strong> <?= esc($event['price'] ?? 'Free') ?></li>
            <li><strong>Organizer ID:</strong> <?= esc($event['organizer_id']) ?></li>
        </ul>
    </section>

    <section class="event-description">
        <div class="description-box">
            <h3>Description</h3>
            <p><?= esc($event['description']) ?></p>
        </div>
    </section>

    </section>
</main>
