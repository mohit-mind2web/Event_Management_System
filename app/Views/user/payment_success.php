<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>
<head>
    <title>Payment Success - Event Management System</title>
    <link rel="stylesheet" href="/assets/css/user/paymentsuccess.css"> 
</head>
<main>
    <section>
<div class="content-wrapper">
        <div class="container-fluid container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-8">
                    <div class="card card-success card-outline">
                        <div class="card-body text-center success-payment">
                            <div class="mb-4">
                                <i class="fas fa-check-circle text-success" style="font-size: 5rem;"></i>
                            </div>
                            
                            <h2 class="mb-3">Payment Successful!</h2>
                            <p class="lead">Thank you for registering. Your payment has been processed successfully.</p>
                            
                            <div class="row justify-content-center mt-4">
                                <div class="col-md-8">
                                    <table class="table table-bordered text-left">
                                        <tr>
                                            <th>Transaction ID</th>
                                            <td><?= esc($transaction_id) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Amount Paid</th>
                                            <td>₹<?= esc($amount) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <td><?= esc($date) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td><span class="badge badge-success">Confirmed</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="mt-4 back-buttons">
                                <a href="/user/events" class="btn btn-primary event-list">
                                    <i class="fas fa-arrow-left"></i> Back to Events
                                </a>
                                <?php if(isset($registration_id) || isset($_GET['registration_id'])): 
                                    $regId = isset($registration_id) ? $registration_id : $_GET['registration_id'];
                                ?>
                                    <a href="/user/ticket/<?= esc($regId) ?>" class="btn btn-outline-primary my-registrations">
                                        <i class="fas fa-ticket-alt"></i> View Ticket
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
  </section>
</main>

