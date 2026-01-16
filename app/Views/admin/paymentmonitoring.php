<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <link rel="stylesheet" href="/assets/css/admin/eventapproval.css">
</head>
<main>
<section>
    <h2>Payment Monitoring</h2>
    <div class="payment-details">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Transaction Id</th>
                    <th>User</th>
                    <th>Event</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Payment Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($payments)):?>
                    <?php foreach($payments as $a=>$payment):?>
                        <tr>
                            <td><?= $a+1 ?></td>
                            <td><?= $payment['transaction_id'] ?></td>
                            <td><?= esc($payment['name']) ?></td>
                            <td><?= esc($payment['titlename']) ?></td>
                            <td>₹<?= number_format($payment['amount']) ?></td>
                           <td><?= esc($payment['payment_method'] ?? 'N/A') ?></td>
                            <td>
                                 <?php
                                $statusLabel = 'Pending';
                                $statusClass = 'status-pending';
                                if ($payment['status'] === 'success') {
                                    $statusLabel = 'Success';
                                    $statusClass = 'status-success';
                                } elseif ($payment['status'] === 'failed') {
                                    $statusLabel = 'Failed';
                                    $statusClass = 'status-failed';
                                }
                                ?><span class="status-badge <?= $statusClass ?>"><?= $statusLabel ?></span>
                            </td>
                            <td><?= $payment['payment_date'] ?></td>
                            <td>
                                <?php if($payment['status'] === 'success'): ?>
                                        <?php if(!empty($payment['receipt_url'])): ?>
                                            <a href="<?= esc($payment['receipt_url']) ?>" target="_blank" class="btn-view-receipt">View Receipt</a>
                                        <?php else: ?>
                                            <span>No Receipt</span>
                                            <?php endif; ?>
                                        <?php endif;?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        <?php else:?>
                            <td colspan="9" style="text-align: center;">No Payments Found</td>
                        <?php endif;?>
            </tbody>
        </table>

    </div>

</section>
</main>