<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>

<head>
 <link rel="stylesheet" href="/assets/css/user/paymentpage.css">
</head>

<main class="content-wrapper">
    <section>
    <div class="payment-container">
        <div class="order-summary">
            <h2>Complete Your Registration</h2>
            <p><strong>Event:</strong> <?= esc($event['title']) ?></p>
            <p><strong>Date:</strong> <?= date('d M Y', strtotime($event['start_datetime'])) ?></p>
            <p><strong>Location:</strong> <?= esc($event['location']) ?></p>
            
            <div class="amount-row">
                <span>Total Amount:</span>
                <span>₹<?= number_format($event['price'], 2) ?></span>
            </div>
        </div>

        <form action="/user/events/process-payment" method="post">
            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
            <input type="hidden" name="amount" value="<?= $event['price'] ?>">

            <button type="submit" class="btn-pay">Pay ₹<?= number_format($event['price'], 2) ?> & Register</button>
        </form>
    </div>
    </section>
</main>
