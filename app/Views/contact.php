<?= $this->include('partials/userheader') ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/contact.css">
    <title>Contact Us</title>
</head>

<main class="content-wrapper">
    <section>
        <div class="contact-section">
        <h2>Contact Us</h2>
        <p>If you have any questions or issues, please fill out the form below.</p>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
               <p><?= session()->getFlashdata('success') ?></p> 
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('errors')): ?>
            <div class="alert alert-danger">
                <ul>
                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                    <li><?= esc($error) ?></li>
                <?php endforeach ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="/contact/submit" method="post" class="contact-form">
            <?= csrf_field() ?>
            <label for="name">Full Name</label><br>
            <input type="text" name="name" id="name" placeholder="Enter your full name" required><br>
            <label for="email">Email Address</label><br>
            <input type="email" name="email" id="email" placeholder="Enter your email" required><br>
            <label for="subject">Query Type</label><br>
            <select name="subject" id="subject" required>
                <option value="">-- Select Query Type --</option>
                <option value="event">Event Related</option>
                <option value="registration">Registration Issue</option>
                <option value="payment">Payment Issue</option>
                <option value="organizer">Organizer Support</option>
                <option value="technical">Technical Issue</option>
                <option value="other">Other</option>
            </select><br>
            <label for="message">Message</label><br>
            <textarea name="message" id="message" rows="5" placeholder="Write your query here" required></textarea><br>
            <div class="btn">
            <button type="submit" class="btn-submit"> Submit Query</button>
            </div>
        </form>
        </div>
    </section>
</main>
<?= $this->include('partials/footer') ?>