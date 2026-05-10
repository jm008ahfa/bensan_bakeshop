<style>
    .product-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 8px;
    }
    .table img {
        width: 50px;
        height: 50px;
        border-radius: 8px;
    }
</style>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4><i class="fas fa-box"></i> Product List</h4>
        <a href="<?= base_url('/product/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Product
        </a>
    </div>
    <div class="card-body">
        <?php if(isset($products) && !empty($products)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($products as $product): ?>
                        <tr>
                            <td><?= $product['id'] ?></td>
                            <td>
                                <?php if(isset($product['image_url'])): ?>
                                    <img src="<?= $product['image_url'] ?>" class="product-image" alt="<?= $product['name'] ?>">
                                <?php else: ?>
                                    <img src="<?= base_url('assets/images/default-product.png') ?>" class="product-image" alt="Default">
                                <?php endif; ?>
                            </td>
                            <td><strong><?= $product['name'] ?></strong></td>
                            <td>₱<?= number_format($product['price'], 2) ?></td>
                            <td>
                                <?php if($product['stock'] <= 0): ?>
                                    <span class="badge bg-danger"><?= $product['stock'] ?></span>
                                <?php elseif($product['stock'] < 20): ?>
                                    <span class="badge bg-warning"><?= $product['stock'] ?></span>
                                <?php else: ?>
                                    <span class="badge bg-success"><?= $product['stock'] ?></span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if($product['stock'] <= 0): ?>
                                    <span class="badge bg-danger">Out of Stock</span>
                                <?php elseif($product['stock'] < 20): ?>
                                    <span class="badge bg-warning">Low Stock</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Available</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('/product/edit/'.$product['id']) ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?= base_url('/product/delete/'.$product['id']) ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Delete this product?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No products found. 
                <a href="<?= base_url('/product/create') ?>">Click here to add your first product</a>
            </div>
        <?php endif; ?>
    </div>
</div>