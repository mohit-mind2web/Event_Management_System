<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Event</title>
    <link href="/assets/css/organizer/createevent.css" rel="stylesheet">
</head>
<main>
    <section class="create-event">

    <h3>Create Event</h3>

    <div id="alertContainer"></div>

    <form method="post" id="createEventForm" data-create-url="<?= site_url('api/events') ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Event Title -->
        <div>
            <label class="form-label">Event Title</label>
            <input type="text" name="title" class="form-control" value="<?= old('title') ?>" required>
        </div>

        <div>
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">Select Category</option>
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>"><?= esc($category['name']) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <!-- Subcategory -->
        <div>
            <label class="form-label">Subcategory</label>
            <select name="subcategory_id" class="form-select">
                <option value="">Select Subcategory</option>
            </select>
        </div>

        <div>
            <label class="form-label">Event Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <!-- Start & End Datetime -->
        <div class="row">
            <div>
                <label class="form-label">Start Date & Time</label>
                <input type="datetime-local" name="start_datetime" class="form-control" required>
            </div>

            <div>
                <label class="form-label">End Date & Time</label>
                <input type="datetime-local" name="end_datetime" class="form-control" required>
            </div>
        </div>

        <!-- Location -->
        <div>
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" required>
        </div>

        <!-- Capacity -->
        <div>
            <label class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" min="1" max="100000" required>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_paid" value="1" id="is_paid" >
            <label class="form-check-label" for="is_paid">
                Paid Event
            </label>
        </div>

        <div class="mb-3" id="priceField" style="display:none;">
            <label class="form-label">Price (₹)</label>
            <input type="number" step="0.01" name="price" class="form-control" min="0" max="1000000" step="0.01" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Event Banner Image</label>
            <input type="file" name="banner_image" class="form-control"  accept="image/png, image/jpeg, image/jpg" required>
            <small class="text-muted">
                Allowed: JPG, JPEG, PNG (Max 2MB)
            </small>
        </div>
        <div class="btn">
<button type="submit" class="btn btn-primary"> Create Event</button>
        </div>
    </form>
</section>
    <script src="<?= base_url('assets/js/organizer/create_event.js') ?>"></script>

</main>
