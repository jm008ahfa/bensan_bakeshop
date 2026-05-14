<!-- Hero Section -->
<div class="hero" style="background: linear-gradient(135deg, #ff6b35, #ff8c42); color: white; padding: 80px 0; text-align: center; margin-bottom: 40px; border-radius: 16px;">
    <div class="container">
        <h1 style="font-size: 3rem; font-weight: 700; margin-bottom: 16px;">Freshly Baked</h1>
        <p style="font-size: 1.1rem; opacity: 0.9; margin-bottom: 32px;">Artisanal breads, pastries, and cakes made fresh daily with love.</p>
        <a href="<?= base_url('/customer/products') ?>" class="shop-btn" style="background: white; color: #ff6b35; padding: 12px 32px; border-radius: 40px; text-decoration: none; font-weight: 600; display: inline-block;">Shop Now →</a>
    </div>
</div>

<div class="container">
    <!-- Shop by Category -->
    <h2 style="font-size: 1.5rem; font-weight: 600; text-align: center; margin-bottom: 40px;">Shop by Category</h2>
    <div class="categories-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 20px; margin-bottom: 60px;">
        <?php if(isset($categories) && !empty($categories)): ?>
            <?php foreach($categories as $cat): ?>
            <a href="<?= base_url('/customer/category/' . $cat['id']) ?>" class="category-card" style="background: white; border: 1px solid #eef2f7; border-radius: 16px; padding: 24px; text-align: center; text-decoration: none; transition: all 0.2s; display: block;">
                <i class="fas fa-folder-open" style="font-size: 2rem; color: #ff6b35; margin-bottom: 12px; display: block;"></i>
                <span style="color: #1a1a2e; font-weight: 500;"><?= $cat['name'] ?></span>
            </a>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Default categories if no categories in database -->
            <a href="<?= base_url('/customer/products') ?>" class="category-card" style="background: white; border: 1px solid #eef2f7; border-radius: 16px; padding: 24px; text-align: center; text-decoration: none;">
                <i class="fas fa-bread-slice" style="font-size: 2rem; color: #ff6b35; margin-bottom: 12px; display: block;"></i>
                <span>Bread</span>
            </a>
            <a href="<?= base_url('/customer/products') ?>" class="category-card" style="background: white; border: 1px solid #eef2f7; border-radius: 16px; padding: 24px; text-align: center; text-decoration: none;">
                <i class="fas fa-cake" style="font-size: 2rem; color: #ff6b35; margin-bottom: 12px; display: block;"></i>
                <span>Pastry</span>
            </a>
            <a href="<?= base_url('/customer/products') ?>" class="category-card" style="background: white; border: 1px solid #eef2f7; border-radius: 16px; padding: 24px; text-align: center; text-decoration: none;">
                <i class="fas fa-birthday-cake" style="font-size: 2rem; color: #ff6b35; margin-bottom: 12px; display: block;"></i>
                <span>Cake</span>
            </a>
            <a href="<?= base_url('/customer/products') ?>" class="category-card" style="background: white; border: 1px solid #eef2f7; border-radius: 16px; padding: 24px; text-align: center; text-decoration: none;">
                <i class="fas fa-cupcake" style="font-size: 2rem; color: #ff6b35; margin-bottom: 12px; display: block;"></i>
                <span>Muffin</span>
            </a>
            <a href="<?= base_url('/customer/products') ?>" class="category-card" style="background: white; border: 1px solid #eef2f7; border-radius: 16px; padding: 24px; text-align: center; text-decoration: none;">
                <i class="fas fa-cookie" style="font-size: 2rem; color: #ff6b35; margin-bottom: 12px; display: block;"></i>
                <span>Cookie</span>
            </a>
            <a href="<?= base_url('/customer/products') ?>" class="category-card" style="background: white; border: 1px solid #eef2f7; border-radius: 16px; padding: 24px; text-align: center; text-decoration: none;">
                <i class="fas fa-star" style="font-size: 2rem; color: #ff6b35; margin-bottom: 12px; display: block;"></i>
                <span>Specialty</span>
            </a>
        <?php endif; ?>
    </div>
</div>

<style>
.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    border-color: #ff6b35;
}
</style>