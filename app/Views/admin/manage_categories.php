<?= $this->include('partials/header') ?>
<?= $this->include('partials/sidebar') ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories</title>
    <link href="/assets/css/admin/managecategory.css" rel="stylesheet"> 
    <link href="/assets/css/admin/eventapproval.css" rel="stylesheet"> 
</head>

<main class="content-main">
    <section>
    <div class="container">
        <h2>Manage Categories</h2>

        <?php if (session()->getFlashdata('message')): ?>
            <div class="message"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="error"><?= session()->getFlashdata('error') ?></div>
        <?php endif; ?>

        <!-- Add Main Category -->
        <form action="/admin/manage-categories/store" method="post" class="add-category-form">
            <input type="text" name="name" placeholder="Enter new category name" required>
            <button type="submit" class="btn-primary">Add Category</button>
        </form>

        <!-- List Categories -->
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <div class="category-card">
                    <div class="category-header">
                        <h3><?= esc($category['name']) ?></h3>
                        <a href="/admin/manage-categories/delete/<?= $category['id'] ?>" class="btn-danger" onclick="return confirm('Delete this category and all its subcategories?')">Delete Category</a>
                    </div>
                    
                    <ul class="subcategory-list">
                        <?php if (!empty($category['subcategories'])): ?>
                            <?php foreach ($category['subcategories'] as $sub): ?>
                                <li class="subcategory-item">
                                    <span><?= esc($sub['name']) ?></span>
                                    <a href="/admin/manage-categories/delete-subcategory/<?= $sub['id'] ?>" class="text-danger" style="font-size: 12px; color: #dc3545; text-decoration: none;" onclick="return confirm('Delete this subcategory?')">&times; Remove</a>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li style="color: #777; font-size: 14px; font-style: italic;">No subcategories</li>
                        <?php endif; ?>
                    </ul>

                    <!-- Add Subcategory -->
                    <form action="/admin/manage-categories/store-subcategory" method="post" class="add-subcategory">
                        <input type="hidden" name="category_id" value="<?= $category['id'] ?>">
                        <input type="text" name="name" placeholder="Add subcategory..." required>
                        <button type="submit" class="btn-primary btn-sm">Add</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No categories found.</p>
        <?php endif; ?>
    </div>
    </section>
</main>
