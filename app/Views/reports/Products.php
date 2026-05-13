<div class="row">
    <!-- Top Selling Products -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h4><i class="fas fa-crown text-warning"></i> Top Selling Products</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Units Sold</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($topProducts ?? [] as $product): ?>
                            <tr>
                                <td><strong><?= $product['name'] ?></strong></td>
                                <td>₱<?= number_format($product['price'], 2) ?></td>
                                <td><?= $product['total_sold'] ?> units</td>
                                <td class="text-success">₱<?= number_format($product['total_revenue'], 2) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($topProducts)): ?>
                            <tr><td colspan="4" class="text-center">No data available</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Low Stock Alert -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-warning">
                <h4><i class="fas fa-exclamation-triangle"></i> Low Stock Alert</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Product</th>
                                <th>Current Stock</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($lowStock ?? [] as $product): ?>
                            <tr class="table-warning">
                                <td><?= $product['name'] ?></td>
                                <td><?= $product['stock'] ?> units</td>
                                <td>₱<?= number_format($product['price'], 2) ?></td>
                                <td><a href="<?= base_url('/product/edit/'.$product['id']) ?>" class="btn btn-sm btn-primary">Restock</a></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php if(empty($lowStock) && empty($outOfStock)): ?>
                            <tr><td colspan="4" class="text-center text-success">All products have sufficient stock!</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if(!empty($outOfStock)): ?>
                <div class="mt-3">
                    <h5>Out of Stock</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr><th>Product</th><th>Price</th><th>Action</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach($outOfStock as $product): ?>
                                <tr class="table-danger">
                                    <td><?= $product['name'] ?></td>
                                    <td>₱<?= number_format($product['price'], 2) ?></td>
                                    <td><a href="<?= base_url('/product/edit/'.$product['id']) ?>" class="btn btn-sm btn-primary">Restock</a></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>