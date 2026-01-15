<?= $this->include('partials/userheader') ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All transactions</title>
      <link rel="stylesheet" href="/assets/css/user/transaction.css">
</head>
<main>
    <section>
        <h2>Payment History</h2>
        <div class="payment-history">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Event Name</th>
                        <th>Amount (₹)</th>
                        <th>Transaction ID</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($transactions)):?>
                            <?php foreach($transactions as $index=>$transaction):?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($transaction['event_title']) ?></td>
                                    <td>₹<?= esc(number_format($transaction['amount'], 2)) ?></td>
                                    <td><?= esc($transaction['transaction_id']) ?></td>
                                    <td><?= esc($transaction['payment_method'] ?? 'N/A') ?></td>
                                    <td><?php
                                $statusLabel = 'Pending';
                                $statusClass = 'status-pending';
                                if ($transaction['status'] === 'success') {
                                    $statusLabel = 'Success';
                                    $statusClass = 'status-success';
                                } elseif ($transaction['status'] === 'failed') {
                                    $statusLabel = 'Failed';
                                    $statusClass = 'status-failed';
                                }
                                ?><span class="status-badge <?= $statusClass ?>"><?= $statusLabel ?></span></td>
                                    <td><?= esc($transaction['created_at']) ?></td>
                                    <td><?php if($transaction['status'] === 'success'): ?>
                                        <?php if(!empty($transaction['receipt_url'])): ?>
                                            <a href="<?= esc($transaction['receipt_url']) ?>" target="_blank" class="btn-view-receipt">View Receipt</a>
                                        <?php else: ?>
                                            <span>No Receipt</span>
                                        <?php endif; ?>
                                        <?php else: ?>
                                            <a href="user/events/register<?= esc($transaction['event_id']) ?>" class="btn-retry-payment">Retry Payment</a>
                                        <?php endif;?>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        <?php else:?>
                                <td colspan="8">No transactions found.</td>
                        <?php endif;?>
                    </tbody>
            </table>
        </div>
    </section>
</main>
