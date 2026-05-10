<div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px;">
    <h1 style="font-size: 2rem; font-weight: 600; text-align: center; margin-bottom: 8px;">All Products</h1>
    <p style="text-align: center; color: #6c757d; margin-bottom: 40px;">Freshly baked goods made with quality ingredients</p>
    
    <!-- Category Filter -->
    <div style="display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; margin-bottom: 48px;">
        <button onclick="filterProducts('all')" class="filter-btn active" style="padding: 8px 20px; border: 1px solid #eef2f7; background: #1a1a2e; color: white; border-radius: 30px; cursor: pointer;">All</button>
        <?php foreach($categories as $cat): ?>
        <button onclick="filterProducts(<?= $cat['id'] ?>)" class="filter-btn" data-cat="<?= $cat['id'] ?>" style="padding: 8px 20px; border: 1px solid #eef2f7; background: white; border-radius: 30px; cursor: pointer;"><?= $cat['name'] ?></button>
        <?php endforeach; ?>
    </div>
    
    <!-- Products Grid -->
    <div id="productsGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 30px;">
        <?php foreach($products as $p): ?>
        <div class="product-card" data-cat="<?= $p['category_id'] ?? '' ?>" style="background: white; border-radius: 20px; overflow: hidden; border: 1px solid #eef2f7; transition: all 0.2s;">
            <div onclick="location.href='<?= base_url('/customer/productDetail/'.$p['id']) ?>'" style="cursor: pointer;">
                <img src="<?= $p['image_url'] ?? base_url('assets/images/default-product.png') ?>" style="width: 100%; height: 200px; object-fit: cover;">
                <div style="padding: 20px;">
                    <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 8px;"><?= $p['name'] ?></h3>
                    <p style="color: #ff6b35; font-weight: 700; font-size: 1.1rem;">₱<?= number_format($p['price'], 2) ?></p>
                    <p style="font-size: 0.75rem; color: #6c757d;">Stock: <?= $p['stock'] ?></p>
                </div>
            </div>
            <div style="padding: 0 20px 20px 20px;">
                <button onclick="addToCart(<?= $p['id'] ?>, '<?= addslashes($p['name']) ?>', <?= $p['price'] ?>, <?= $p['stock'] ?>)" style="width: 100%; padding: 10px; background: #1a1a2e; color: white; border: none; border-radius: 30px; cursor: pointer; font-weight: 500;">Add to Cart</button>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.filter-btn.active { background: #1a1a2e !important; color: white !important; }
.product-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
</style>

<script>
function filterProducts(catId) {
    const cards = document.querySelectorAll('.product-card');
    cards.forEach(card => { card.style.display = (catId === 'all' || card.dataset.cat == catId) ? '' : 'none'; });
    document.querySelectorAll('.filter-btn').forEach(btn => { btn.classList.remove('active'); btn.style.background = 'white'; btn.style.color = '#1a1a2e'; });
    event.target.classList.add('active'); event.target.style.background = '#1a1a2e'; event.target.style.color = 'white';
}
</script>