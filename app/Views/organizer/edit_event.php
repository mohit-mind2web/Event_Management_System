<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event</title>
    <link href="/assets/css/organizer/createevent.css" rel="stylesheet">
</head>
<main>
    <section class="create-event">

    <h3>Edit Event: <?= esc($event['title']) ?></h3>

    <div id="alertContainer"></div>

    <form method="post" id="editEventForm" data-update-url="<?= site_url('api/events/update/' . $event['id']) ?>" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <!-- Event Title -->
        <div>
            <label class="form-label">Event Title</label>
            <input type="text" name="title" class="form-control" value="<?= esc($event['title']) ?>" required>
        </div>

        <div>
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?= $category['id'] ?>" <?= ($category['id'] == $event['category_id']) ? 'selected' : '' ?>>
                        <?= esc($category['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="form-label">Subcategory</label>
            <select name="subcategory_id" class="form-select" data-selected="<?= $event['subcategory_id'] ?>">
                <option value="">Select Subcategory</option>
            </select>
        </div>

        <div>
            <label class="form-label">Event Description</label>
            <textarea name="description" class="form-control" rows="4" required><?= esc($event['description']) ?></textarea>
        </div>
        <div class="row">
            <div>
                <label class="form-label">Start Date & Time</label>
                <input type="datetime-local" name="start_datetime" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($event['start_datetime'])) ?>" required>
            </div>

            <div>
                <label class="form-label">End Date & Time</label>
                <input type="datetime-local" name="end_datetime" class="form-control" value="<?= date('Y-m-d\TH:i', strtotime($event['end_datetime'])) ?>" required>
            </div>
        </div>

        <div>
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="<?= esc($event['location']) ?>" required>
        </div>

        <!-- Capacity -->
        <div>
            <label class="form-label">Capacity</label>
            <input type="number" name="capacity" class="form-control" min="1" max="100000" value="<?= esc($event['capacity']) ?>" required>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_paid" value="1" id="is_paid" <?= $event['is_paid'] ? 'checked' : '' ?>>
            <label class="form-check-label" for="is_paid">
                Paid Event
            </label>
        </div>

        <div class="mb-3" id="priceField" style="display: <?= $event['is_paid'] ? 'grid' : 'none' ?>;">
            <label class="form-label">Price (₹)</label>
            <input type="number" step="0.01" name="price" class="form-control" min="0" max="1000000" value="<?= esc($event['price']) ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Event Banner Image (Leave empty to keep current)</label>
            <?php if(!empty($event['banner_image'])): ?>
                <div style="margin-bottom:10px;">
                    <img src="/<?= esc($event['banner_image']) ?>" height="100" style="border-radius:4px;">
                </div>
            <?php endif; ?>
            <input type="file" name="banner_image" class="form-control" accept="image/png, image/jpeg, image/jpg">
            <small class="text-muted">
                Allowed: JPG, JPEG, PNG (Max 2MB)
            </small>
        </div>
        <div class="btn">
            <button type="submit" class="btn btn-warning"> Update Event</button>
        </div>
    </form>
</section>
    <script src="<?= base_url('assets/js/organizer/edit_event.js') ?>"></script>

</main>
