<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Users Registration Details</title>
    <link rel="stylesheet" href="/assets/css/admin/eventapproval.css">
</head>
<main>
    <section>
        <div class="back-reg">
            <a href="/admin/eventregistrations" class="back-button">&larr; Back to Registrations</a>
        </div>
        <div class="detail-page">
            <h2>User Registrations for <?= esc($title) ?></h2>
            <p><strong>Event Date/Time : </strong> <?= esc($start_datetime) ?></p>
            <p><strong>Event Status : </strong><?= $start_datetime > date('Y-m-d H:i:s') ? "<span class='badge badge-upcoming'>Active</span>" : 
            "<span class='badge badge-close'>Closed</span>" ?></p>
            <div class="usersdetails">
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Payment Status</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(!empty($userregistrations)):?>
                            <?php foreach($userregistrations as $index=>$registrations):?>
                                <tr>
                                    <td><?= $index+1 ?></td>
                                    <td><?= esc($registrations['full_name']) ?></td>
                                    <td><?= esc($registrations['email']) ?></td>
                                    <td><?= esc($registrations['payment_status']) ?></td>
                                    <td><?= esc(date('Y-m-d H:i:s', strtotime($registrations['created_at']))) ?></td>
                                </tr>
                                <?php endforeach;?>
                                <?php else:?>
                                    <td colspan="5" style="text-align: center;">No Registrations Found</td></td>
                                    <?php endif;?>
                    </tbody>
                </table>
            </div>


        </div>
    </section>
</main>
