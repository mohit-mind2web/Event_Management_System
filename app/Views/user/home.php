<?= $this->include('partials/userheader') ?>
    <link rel="stylesheet" href="/assets/css/user/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<main>
    <!-- Hero Section -->
    <section class="user-home-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Discover & Manage Events <br><span>Like Never Before</span></h1>
            <p>Your one-stop destination for seamless event planning and registration. Join us to experience the future of event management.</p>
            <div class="hero-buttons">
                 <a href="/user/events" class="btn-hero primary">Browse All Events</a>
                 <a href="/user/registrations" class="btn-hero secondary">My Registrations</a>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section class="upcoming-events-section">
        <div class="container-custom">
            <h2 class="section-title">Upcoming Events</h2>
            <div class="events-grid">
                <?php if (!empty($upcomingEvents)): ?>
                    <?php foreach ($upcomingEvents as $event): ?>
                        <div class="event-card">
                            <div class="event-image">
                                <img src="/<?= esc($event['banner_image']) ?>" alt="<?= esc($event['title']) ?>">
                                <div class="event-date">
                                    <span class="day"><?= date('d', strtotime($event['start_datetime'])) ?></span>
                                    <span class="month"><?= date('M', strtotime($event['start_datetime'])) ?></span>
                                </div>
                            </div>
                            <div class="event-details">
                                <h3><?= esc($event['title']) ?></h3>
                                <p class="location"><i class="fas fa-map-marker-alt"></i> <?= esc($event['location']) ?></p>
                                <a href="/user/events/view/<?= $event['id'] ?>" class="btn-event">View Details</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-events">No upcoming events found.</p>
                <?php endif; ?>
            </div>
            <div class="view-all-container">
                 <a href="/user/events" class="btn-view-all">View All Events</a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="why-choose-us">
        <div class="container-full">
             <div class="section-header">
                <h2>Why Choose <span class="highlight">Us</span></h2>
                <div class="icon-brand"><i class="fas fa-map-marker-alt"></i> Event<small>ease</small></div>
            </div>
            
            <div class="features-grid">
                <div class="feature-box">
                    <div class="icon-circle">01</div>
                    <h3>MULTIPLE EVENTS</h3>
                    <p>Access a wide variety of events from different categories all in one place. Seamless browsing experience guaranteed.</p>
                </div>
                <div class="feature-box">
                    <div class="icon-circle">02</div>
                    <h3>EVENT MANAGEMENT</h3>
                    <p>Organizers can easily manage events, track registrations, and handle ticketing with our robust tools.</p>
                </div>
                 <div class="feature-box">
                     <div class="icon-circle">03</div>
                    <h3>CREDIT CARD PAYMENT</h3>
                    <p>Secure and fast payment processing for all paid events with Stripe. We support major credit cards and gateways.</p>
                </div>
                 <div class="feature-box">
                     <div class="icon-circle">04</div>
                    <h3>VENUE MANAGEMENT</h3>
                    <p>Find events by venue and get detailed location information to ensure you never miss a beat.</p>
                </div>
                 <div class="feature-box">
                     <div class="icon-circle">05</div>
                    <h3>FREE REGISTRATION</h3>
                    <p>Easy registration process for free events. Just one click and you are attending!</p>
                </div>
                 <div class="feature-box">
                     <div class="icon-circle">06</div>
                    <h3>EASY TO USE</h3>
                    <p>User-friendly interface designed for everyone. Navigate with ease and find what you need quickly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="news-section">
        <div class="container-custom">
            <h2 class="section-title">Blogs</h2>
            <div class="news-grid">
                <div class="news-card">
                    <div class="news-image placeholder-bg"></div>
                    <div class="news-content">
                        <span class="date">Jan 15, 2026</span>
                        <h3>New Features Released</h3>
                        <p>We have updated our platform with exciting new features for organizers...</p>
                        <a href="#" class="read-more">Read More</a>
                    </div>
                </div>
                <div class="news-card">
                    <div class="news-image placeholder-bg"></div>
                    <div class="news-content">
                         <span class="date">Jan 10, 2026</span>
                        <h3>Top Events of the Year</h3>
                        <p>Check out the most popular events that happened this year and what's coming next...</p>
                         <a href="#" class="read-more">Read More</a>
                    </div>
                </div>
                 <div class="news-card">
                    <div class="news-image placeholder-bg"></div>
                    <div class="news-content">
                         <span class="date">Jan 05, 2026</span>
                        <h3>PartnerShip Announcement</h3>
                        <p>We are proud to announce our new partnership with major venue providers...</p>
                         <a href="#" class="read-more">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Events Section -->
    <section class="about-section">
        <div class="container-full">
            <div class="about-content">
                <h2>About <span class="highlight">Events</span></h2>
                
                <div class="about-image-container">
                    <!-- Placeholder for the uploaded image or generic one -->
                     <img src="/assets/images/about-events.png" alt="About Events" class="about-img">
                     <p>
                    From intimate workshops to large-scale conferences, our platform brings people together. 
                    We believe in the power of connection and the impact of shared experiences. 
                    Whether you are an attendee looking for inspiration or an organizer creating memories, 
                    we provide the tools and space to make it happen.
                </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section class="partners-section">
        <div class="container-custom">
            <h2 class="section-title">Our Partners</h2>
            <div class="partners-logos">
                <div class="partner-logo">
                    <img src="/assets/images/ey.png" alt="Partner Logo">
                </div>
                <div class="partner-logo">
                    <img src="/assets/images/kpmg.png" alt="Partner Logo">
                </div>
                <div class="partner-logo">
                    <img src="/assets/images/zoho.png" alt="Partner Logo">
                </div>
                <div class="partner-logo">
                    <img src="/assets/images/google.png" alt="Partner Logo">
                </div>
                <div class="partner-logo">
                    <img src="/assets/images/ey.png" alt="Partner Logo">
                </div>
            </div>
        </div>
    </section>

</main>
<?= $this->include('partials/footer') ?>