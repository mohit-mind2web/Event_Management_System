<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>

<head>
    <title>Payment Failed </title>
    <style>
        .failed-container {
            text-align: center;
            padding: 50px 20px;
        }
        .icon-failed {
            color: #dc3545;
            font-size: 5rem;
            margin-bottom: 20px;
        }
        .btn-try-again {
            background-color: #ffc107;
            color: #212529;
            border: none;
            padding: 10px 20px;
            font-size: 1.1rem;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 10px;
        }
        .btn-try-again:hover {
            background-color: #e0a800;
            color: #212529;
        }
    </style>
</head>

<main>
    <section>
        <div class="content-wrapper">
            <div class="container-fluid container">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-8">
                        <div class="card card-danger card-outline">
                            <div class="card-body failed-container">
                                <div class="mb-4">
                                    <i class="fas fa-times-circle icon-failed"></i>
                                </div>
                                
                                <h2 class="mb-3">Payment Failed</h2>
                                <p class="lead">We were unable to process your payment. This could be due to a declined card or a cancellation.</p>
                                
                                <?php if (isset($error_message)): ?>
                                    <div class="alert alert-danger" style="display:inline-block; margin-top:10px;">
                                        <?= esc($error_message) ?>
                                    </div>
                                <?php endif; ?>

                                <div class="mt-4">
                                    <?php if (isset($event_id)): ?>
                                        <a href="/user/events/summary/<?= esc($event_id) ?>" class="btn btn-try-again">
                                            <i class="fas fa-redo"></i> Try Again
                                        </a>
                                    <?php endif; ?>
                                    
                                    <a href="/user/events" class="btn btn-outline-secondary">
                                        Back to Events
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
