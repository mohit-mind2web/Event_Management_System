<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>
<head>
    <link rel="stylesheet" href="/assets/css/organizer/dashboard.css"> 
</head>

<main class="content-wrapper">
        <section>
             <h2 class="head">View Summary</h2>
             
        <div class="row">
            <div class="card">
                 <div class="icon">
                    <i class="fa-solid fa-list-check"></i>
                </div>
                <div class="detail">
                    <h3>Total Events Created</h3>
                    <p><?= esc($totalEvents) ?></p>
                </div>
            </div>
            <div class="card">
                <div class="icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                 <div class="detail">
                    <h3>Approved Events</h3>
                    <p><?= esc($approvedEvents) ?></p>
                </div>
            </div>
            <div class="card">
                <div class="icon">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="detail">
                    <h3>Pending Events</h3>
                    <p><?= esc($pendingEvents) ?></p>
                </div>
            </div>
            
             <div class="card">
                 <div class="icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                 <div class="detail">
                    <h3>Total Registrations</h3>
                    <p><?= esc($totalRegistrations) ?></p>
                </div>
            </div>
        </div>

        <div class="events">
            <div class="recent-events">
                <div class="all">
                    <h3>Recent Events</h3>
                    <a class="see" href="/organizer/myevents">View All Events</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Event Name</th>
                            <th>Event Date</th>
                            <th>Status</th>
                            <th>Registrations Count</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($recentEvents)): ?>
                            <?php foreach ($recentEvents as $index => $event): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($event['title']) ?></td>
                                    <td><?= date('d M Y', strtotime($event['start_datetime'])) ?></td>
                                    <td>
                                        <?php
                                            if ($event['status'] == 2) {
                                                 echo '<span style="color: red;">Rejected</span>';
                                            } elseif (strtotime($event['end_datetime']) < time()) {
                                                 echo '<span style="color: green;">Completed</span>';
                                            } else {
                                                 if ($event['status'] == 1) {
                                                    echo '<span style="color: green;">Approved</span>';
                                                } elseif ($event['status'] == 0) {
                                                    echo '<span style="color: orange;">Pending</span>';
                                                } else {
                                                    echo '<span style="color: red;">Inactive</span>';
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>0</td>
                                    <td>
                                        <a class="view" href="/organizer/events/view/<?= $event['id'] ?>">View</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td class="noevent" colspan="6">No recent events found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

            </div>
            <div class="upcoming-events">
                <div class="all">
                   <h3>Upcoming Events</h3>
                    <a class="see" href="/organizer/createevent">Create Event</a>
                </div>
                   <table>
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Event Name</th>
                            <th>Event Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($upcomingEvents)): ?>
                            <?php foreach ($upcomingEvents as $index => $event): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td><?= esc($event['title']) ?></td>
                                    <td><?= date('d M Y', strtotime($event['start_datetime'])) ?></td>
                                    <td>
                                        <?php
                                            if ($event['status'] == 1) {
                                                echo '<span style="color: green;">Approved</span>';
                                            } elseif ($event['status'] == 0) {
                                                echo '<span style="color: orange;">Pending</span>';
                                            } else {
                                                echo '<span style="color: red;">Inactive</span>';
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <a class="view" href="/organizer/events/view/<?= $event['id'] ?>">View</a>
                                        <a class="edit" href="/organizer/events/edit/<?= $event['id'] ?>">Edit</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">No upcoming events found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                
            </div>
        </div>
        </section>
</main>

