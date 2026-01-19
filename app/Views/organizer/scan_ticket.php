<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>
<main>
    <section>
<link rel="stylesheet" href="/assets/css/organizer/scanticket.css">

<div class="content-wrapper">
    <div class="content-header current-page" data-page="scan-ticket">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6 scan">
            <h1 class="m-0 text-dark">Scan Event Ticket</h1>
          </div>
        </div>
      </div>
    </div>

    <section class="contentscan">
      <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h3 class="card-title-scan text-center m-0">Align QR Code within the frame</h3>
                    </div>
                    <div class="card-body text-center p-4">
                         <div id="reader"></div>
                         <div id="result-message" class="mt-3" style="display:none;"></div>
                         <button id="reset-scan" class="btn btn-secondary mt-3" style="display:none;"><i class="fas fa-redo"></i> Scan Another</button>
                    </div>
                </div>
                <div class="text-center mt-3 text-muted">
                    <small>Ensure good lighting for best results.</small>
                </div>
            </div>
        </div>
      </div>
    </section>
</div>
</section>
</main>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="/assets/js/organizer/scanticket.js"></script>


