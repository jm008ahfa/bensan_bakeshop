<div class="container my-5">
    <h2 class="text-center mb-4"><?= $category['name'] ?></h2>
    <p class="text-center text-muted mb-4"><?= $category['description'] ?? 'Browse our delicious selection' ?></p>
    
    <div class="row">
        <?php if(!empty($products)): ?>
            <?php foreach($products as $p): ?>
            <div class="col-md-3 col-6 mb-4">
                <div class="card h-100" style="border: 1px solid #eef2f7; border-radius: 16px; overflow: hidden; transition: all 0.3s; cursor: pointer;" onclick="location.href='<?= base_url('/customer/productDetail/'.$p['id']) ?>'">
                    <img src="<?= $p['image_url'] ?? base_url('assets/images/default-product.png') ?>" class="card-img-top" style="height: 180px; object-fit: cover;" alt="<?= $p['name'] ?>">
                    <div class="card-body">
                        <h6 class="card-title" style="font-weight: 600; margin-bottom: 8px;"><?= $p['name'] ?></h6>
                        <p class="card-text text-primary fw-bold" style="color: #ff6b35 !important;">₱<?= number_format($p['price'], 2) ?></p>
                        <p class="card-text text-muted small">Stock: <?= $p['stock'] ?></p>
                        <button class="btn btn-sm w-100" style="background: #ff6b35; color: white; border: none; padding: 8px; border-radius: 8px; margin-top: 8px;" onclick="event.stopPropagation(); addToCart('<?= $p['id'] ?>', '<?= addslashes($p['name']) ?>', <?= $p['price'] ?>, <?= $p['stock'] ?>)">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p>No products found in this category.</p>
            </div>
        <?php endif; ?>
    </div>
</div>