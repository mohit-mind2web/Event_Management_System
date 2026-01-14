<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>
<head>
    <title>Registration Summary - Event Management System</title>
    <link rel="stylesheet" href="/assets/css/user/registrationsummary.css">
</head>
<main>
    <section>
<div class="content-wrapper">
        <div class="container-fluid container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Registration Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info note">
                                <h5> Note!</h5>
                                Please review the event details below before confirming your registration.
                            </div>

                            <table class="table table-bordered">
                                <tr>
                                    <th>Event Name</th>
                                    <td><?= esc($event['title']) ?></td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>
                                        <?php 
                                            $start = strtotime($event['start_datetime']);
                                            echo date('d M Y, h:i A', $start);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Location</th>
                                    <td><?= esc($event['location']) ?></td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td class="text-success" style="font-size: 1.2em; font-weight: bold;">
                                        <?php if ($event['is_paid']): ?>
                                            ₹<?= esc($event['price']) ?>
                                        <?php else: ?>
                                            Free
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            </table>

                            <div class=" text-center">
                                <?php if ($event['is_paid']): ?>
                                    <form action="/user/payment/checkout" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="event_id" value="<?= esc($event['id']) ?>">
                                        <div>
                                        <a href="/user/events" class="btn btn-default cancel">Cancel</a>
                                        <button type="submit" class="btn btn-success btn-lg confirm">
                                            <i class="fas fa-credit-card"></i> Pay & Register
                                        </button>
                                        </div>
                                    </form>
                                <?php else: ?>
                                    <form action="/user/events/confirm" method="post">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="event_id" value="<?= esc($event['id']) ?>">
                                        <div>
                                        <a href="/user/events" class="btn btn-default cancel">Cancel</a>
                                        <button type="submit" class="confirm">
                                            <i class="fas fa-check-circle"></i> Confirm Registration
                                        </button>
                                        </div>
                                    </form>
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
