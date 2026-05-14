<div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px;">
    
    <!-- Category Header -->
    <div style="text-align: center; margin-bottom: 40px;">
        <h1 style="font-size: 2rem; font-weight: 600; margin-bottom: 8px;"><?= $category['name'] ?></h1>
        <p style="color: #6c757d;"><?= $category['description'] ?? 'Browse our delicious selection' ?></p>
    </div>
    
    <!-- Products Grid -->
    <?php if(!empty($products)): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 30px;">
            <?php foreach($products as $product): ?>
            <div style="background: white; border-radius: 20px; overflow: hidden; border: 1px solid #eef2f7; transition: all 0.2s; cursor: pointer;" onclick="location.href='<?= base_url('/customer/productDetail/'.$product['id']) ?>'">
                <img src="<?= $product['image_url'] ?? base_url('assets/images/default-product.png') ?>" style="width: 100%; height: 200px; object-fit: cover;" alt="<?= $product['name'] ?>">
                <div style="padding: 20px;">
                    <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 8px;"><?= $product['name'] ?></h3>
                    <p style="color: #ff6b35; font-weight: 700; font-size: 1.1rem;">₱<?= number_format($product['price'], 2) ?></p>
                    <p style="font-size: 0.75rem; color: #6c757d; margin-top: 4px;">Stock: <?= $product['stock'] ?></p>
                    <button onclick="event.stopPropagation(); addToCart(<?= $product['id'] ?>, '<?= addslashes($product['name']) ?>', <?= $product['price'] ?>, <?= $product['stock'] ?>)" style="width: 100%; margin-top: 16px; padding: 10px; background: #1a1a2e; color: white; border: none; border-radius: 30px; cursor: pointer; font-weight: 500;">
                        Add to Cart
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 60px; background: white; border-radius: 20px; border: 1px solid #eef2f7;">
            <i class="fas fa-box-open" style="font-size: 48px; color: #dee2e6; margin-bottom: 16px;"></i>
            <p>No products found in this category.</p>
            <a href="<?= base_url('/customer/store') ?>" style="display: inline-block; margin-top: 16px; color: #ff6b35;">Continue Shopping →</a>
        </div>
    <?php endif; ?>
</div>

<style>
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
</style>