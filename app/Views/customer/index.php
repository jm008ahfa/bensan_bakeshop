<!-- Hero Section -->
<div class="hero">
    <div class="container">
        <h1>Freshly Baked</h1>
        <p>Artisanal breads, pastries, and cakes made fresh daily with love.</p>
        <a href="<?= base_url('/customer/products') ?>" class="shop-btn">Shop Now →</a>
    </div>
</div>

<div class="container">
    <h2 style="font-size: 1.5rem; font-weight: 600; text-align: center; margin-bottom: 40px;">Shop by Category</h2>
    <div class="categories-grid">
        <?php if(isset($categories) && !empty($categories)): ?>
            <?php foreach($categories as $cat): ?>
            <a href="<?= base_url('/customer/products') ?>" class="category-card">
                <i class="fas fa-folder-open"></i>
                <span><?= $cat['name'] ?></span>
            </a>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="category-card">
                <i class="fas fa-bread-slice"></i>
                <span>Bread</span>
            </div>
            <div class="category-card">
                <i class="fas fa-cake"></i>
                <span>Pastry</span>
            </div>
            <div class="category-card">
                <i class="fas fa-birthday-cake"></i>
                <span>Cake</span>
            </div>
            <div class="category-card">
                <i class="fas fa-cupcake"></i>
                <span>Muffin</span>
            </div>
            <div class="category-card">
                <i class="fas fa-cookie"></i>
                <span>Cookie</span>
            </div>
            <div class="category-card">
                <i class="fas fa-star"></i>
                <span>Specialty</span>
            </div>
        <?php endif; ?>
    </div>
</div>