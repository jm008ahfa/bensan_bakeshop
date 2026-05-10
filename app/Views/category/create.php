<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-plus"></i> Add New Category</h4>
    </div>
    <div class="card-body">
        <form action="<?= base_url('/category/store') ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" required placeholder="e.g., Bread, Pastry, Cake">
            </div>
            <div class="mb-3">
                <label class="form-label">Description (Optional)</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Describe this category"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Save Category
            </button>
            <a href="<?= base_url('/categories') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </form>
    </div>
</div>