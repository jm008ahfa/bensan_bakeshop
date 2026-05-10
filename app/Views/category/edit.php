<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-edit"></i> Edit Category</h4>
    </div>
    <div class="card-body">
        <form action="<?= base_url('/category/update/'.$category['id']) ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Category Name</label>
                <input type="text" name="name" class="form-control" value="<?= $category['name'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?= $category['description'] ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Category
            </button>
            <a href="<?= base_url('/categories') ?>" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
            </a>
        </form>
    </div>
</div>