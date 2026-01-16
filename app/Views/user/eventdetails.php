<?= $this->include('partials/userheader') ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details</title>
    <link href="/assets/css/user/eventdetails.css" rel="stylesheet">
</head>

<main>
    <section class="event-details-container">
        <div class="banner-container">
            <?php if (!empty($event['banner_image'])): ?>
                <img src="/<?= esc($event['banner_image']) ?>" alt="Event Banner" class="banner-image">
            <?php else: ?>
                <div class="nobanner">
                    No Banner Image
                </div>
            <?php endif; ?>
            <div class="description-box">
                <h3>Description</h3>
                <p><?= esc($event['description']) ?></p>
            </div>
            <div class="tag">
                <div>
                    <h3>Tags:</h3>
                    <p><?= esc($event['category_name']) ?> </p>
                </div>
            </div>
        </div>

        <section class="event-detail">
            <div class="register-now">
                <a href="/user/events/register/<?= $event['id'] ?>" class="btn-edit">Register Now</a>
            </div>
            <div class="event-details">
                <h2>Event Detail</h2>
                <ul>
                    <li>
                        <strong>Category:</strong>
                        <span><?= esc($event['category_name']) ?></span>
                    </li>

                    <li>
                        <strong>Subcategory:</strong>
                        <span><?= esc($event['subcategory_name'] ?? 'N/A') ?></span>
                    </li>

                    <li>
                        <strong>Location:</strong>
                        <span><?= esc($event['location']) ?></span>
                    </li>

                    <li>
                        <strong>Start Date:</strong>
                        <span><?= date('M d, Y h:i A', strtotime($event['start_datetime'])) ?></span>
                    </li>

                    <li>
                        <strong>End Date:</strong>
                        <span><?= date('M d, Y h:i A', strtotime($event['end_datetime'])) ?></span>
                    </li>

                    <li>
                        <strong>Capacity:</strong>
                        <span><?= esc($event['capacity']) ?> People</span>
                    </li>
                    <li>
                        <strong>Price:</strong>
                        <span><?= esc($event['price'] ?? 'Free') ?></span>
                    </li>
                </ul>
                <div class="direction">
                    <a href="">Get Direction</a>
                </div>
            </div>

        </section>
    </section>
</main>