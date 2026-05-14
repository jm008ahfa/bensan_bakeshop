<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4><i class="fas fa-tags"></i> Categories</h4>
        <a href="<?= base_url('/category/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add Category
        </a>
    </div>
    <div class="card-body">
        <?php if(isset($categories) && !empty($categories)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
                            <th>Description</th>
                            <th>Products</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($categories as $cat): ?>
                        <tr>
                            <td><?= $cat['id'] ?></td>
                            <td>
                                <i class="fas fa-folder-open text-warning"></i>
                                <strong><?= $cat['name'] ?></strong>
                             </div>
                            <tr>
                            <td><?= $cat['description'] ?? 'No description' ?></td>
                            <td>
                                <span class="badge bg-info"><?= $cat['product_count'] ?? 0 ?> products</span>
                             </div>
                            <tr>
                            <td>
                                <a href="<?= base_url('/category/edit/'.$cat['id']) ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="<?= base_url('/category/delete/'.$cat['id']) ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Delete this category?')">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                             </div>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No categories found.
                <a href="<?= base_url('/category/create') ?>">Click here to add your first category</a>
            </div>
        <?php endif; ?>
    </div>
</div>