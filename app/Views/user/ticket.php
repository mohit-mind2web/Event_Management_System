
<head>
    <title>Event Ticket - <?= esc($event['title']) ?></title>
   <link rel="stylesheet" href="/assets/css/user/ticket.css">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="ticket-container card">
                        <div class="ticket-header">
                            <div class="ticket-title"><?= esc($event['title']) ?></div>
                            <div>Event Ticket</div>
                        </div>
                        
                        <div class="row ticket-info">
                             <div class="col-md-6">
                                <p><span class="ticket-label">Attendee:</span> <?= esc($user->full_name) ?></p>
                                <p><span class="ticket-label">Email:</span> <?= esc($user->email) ?></p>
                                <p><span class="ticket-label">Registration ID:</span> <?= esc($registration['id']) ?></p>
                                <p><span class="ticket-label">Status:</span> <span class="badge badge-success"><?= strtoupper($registration['payment_status']) ?></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><span class="ticket-label">Date:</span> 
                                    <?php 
                                        $start = strtotime($event['start_datetime']);
                                        echo date('l, d M Y', $start);
                                    ?>
                                </p>
                                <p><span class="ticket-label">Time:</span> <?= date('h:i A', $start) ?></p>
                                <p><span class="ticket-label">Location:</span> <?= esc($event['location']) ?></p>
                            </div>
                           
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <small class="text-muted">Please present this ticket at the event entrance.</small>
                            </div>
                        </div>
                    </div>

                    <div class="text-center print-btn no-print mb-4">
                        <button onclick="window.print()" class="btn btn-primary btn-lg">
                            <i class="fas fa-print"></i> Print Ticket
                        </button>
                        <a href="/user/registrations" class="btn btn-default btn-lg ml-2">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
</div>

