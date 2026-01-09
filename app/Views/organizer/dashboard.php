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
                    <p>4000</p>
                </div>
            </div>
            <div class="card">
                <div class="icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                 <div class="detail">
                    <h3>Approved Events</h3>
                    <p>4000</p>
                </div>
            </div>
            <div class="card">
                <div class="icon">
                    <i class="fa-solid fa-clock"></i>
                </div>
                <div class="detail">
                    <h3>Pending Events</h3>
                    <p>4000</p>
                </div>
            </div>
            
             <div class="card">
                 <div class="icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                 <div class="detail">
                    <h3>Total Registrations</h3>
                    <p>4000</p>
                </div>
            </div>
        </div>

        <div class="events">
            <div class="recent-events">
                <div class="all">
                    <h3>Recent Events</h3>
                    <a class="see" href="">View Events</a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Event Name</th>
                            <th>Event Date</th>
                            <th>Status</th>
                            <th>Capacity</th>
                            <th>Registrations Count</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Ai & Ml conference</td>
                            <td>15 jan 2026</td>
                            <td>pending</td>
                            <td>200</td>
                            <td>50</td>
                            <td>
                                <a class="view" href="">View</a>
                                  <a class="edit" href="">Edit</a>
                        </td>
                        </tr>
                    </tbody>
                </table>

            </div>
            <div class="upcoming-events">
                <div class="all">
                   <h3>Upcoming Events</h3>
                    <a class="see" href="">Create Event</a>
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
                        <tr>
                            <td>1</td>
                            <td>Ai & Ml conference</td>
                            <td>15 jan 2026</td>
                            <td>pending</td>
                            <td><a class="view" href="">View Details</a></td>
                        </tr>
                    </tbody>
                </table>
                
            </div>
        </div>
        </section>
</main>

