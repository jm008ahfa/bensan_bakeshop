<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Bensan Bakeshop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f5f7fa;
            color: #1a1a2e;
        }

        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 24px;
        }

        /* Card Style */
        .card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            overflow: hidden;
        }

        .card-header {
            padding: 24px 32px;
            border-bottom: 1px solid #eef2f7;
        }

        .card-header h2 {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        .card-header p {
            font-size: 0.85rem;
            color: #6c757d;
            margin-top: 6px;
        }

        .card-body {
            padding: 32px;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #1a1a2e;
        }

        .form-group label i {
            color: #ff6b35;
            margin-right: 6px;
            width: 18px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            font-size: 0.9rem;
            font-family: 'Inter', sans-serif;
            border: 1.5px solid #e9ecef;
            border-radius: 12px;
            transition: all 0.2s;
            background: #fafbfc;
        }

        .form-control:focus {
            outline: none;
            border-color: #ff6b35;
            background: white;
            box-shadow: 0 0 0 3px rgba(255,107,53,0.1);
        }

        select.form-control {
            cursor: pointer;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Image Preview */
        .image-preview {
            margin-top: 12px;
            text-align: center;
            padding: 20px;
            background: #fafbfc;
            border-radius: 16px;
            border: 1px dashed #e9ecef;
        }

        .current-image {
            max-width: 200px;
            max-height: 200px;
            border-radius: 16px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .image-label {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 8px;
        }

        /* File Input Styling */
        .file-input-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        .file-input-wrapper input[type="file"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-custom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: #fafbfc;
            border: 1.5px dashed #e9ecef;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .file-input-custom:hover {
            border-color: #ff6b35;
            background: #fff5f0;
        }

        .file-input-custom span {
            color: #6c757d;
            font-size: 0.85rem;
        }

        .file-input-custom i {
            color: #ff6b35;
        }

        /* Button Styles */
        .btn-group {
            display: flex;
            gap: 12px;
            margin-top: 32px;
        }

        .btn {
            padding: 12px 24px;
            font-size: 0.9rem;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: #ff6b35;
            color: white;
        }

        .btn-primary:hover {
            background: #e55a2b;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #e9ecef;
            color: #4a5568;
        }

        .btn-secondary:hover {
            background: #dee2e6;
        }

        /* Alert Messages */
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 0.85rem;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .alert-danger {
            background: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        .alert i {
            margin-right: 8px;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .container {
                margin: 20px auto;
            }
            .card-header {
                padding: 20px;
            }
            .card-body {
                padding: 20px;
            }
            .btn-group {
                flex-direction: column;
            }
            .btn {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2><i class="fas fa-edit" style="color: #ff6b35; margin-right: 8px;"></i> Edit Product</h2>
                <p>Update product information and details</p>
            </div>
            <div class="card-body">
                <!-- Flash Messages -->
                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle"></i> <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                
                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle"></i> <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('/product/update/'.$product['id']) ?>" method="post" enctype="multipart/form-data">
                    <!-- Current Image -->
                    <div class="form-group">
                        <label><i class="fas fa-image"></i> Current Image</label>
                        <div class="image-preview">
                            <?php if(isset($product['image_url']) && $product['image_url']): ?>
                                <img src="<?= $product['image_url'] ?>" class="current-image" alt="<?= $product['name'] ?>">
                            <?php else: ?>
                                <img src="<?= base_url('assets/images/default-product.png') ?>" class="current-image" alt="Default Product">
                            <?php endif; ?>
                            <div class="image-label">
                                <i class="fas fa-info-circle"></i> Current product image
                            </div>
                        </div>
                    </div>

                    <!-- Change Image -->
                    <div class="form-group">
                        <label><i class="fas fa-upload"></i> Change Image</label>
                        <div class="file-input-wrapper">
                            <div class="file-input-custom" onclick="document.getElementById('imageInput').click()">
                                <span><i class="fas fa-cloud-upload-alt"></i> Choose new image</span>
                                <i class="fas fa-chevron-right"></i>
                            </div>
                            <input type="file" name="image" id="imageInput" class="form-control" accept="image/*" style="display: none;" onchange="previewImage(this)">
                        </div>
                        <small style="font-size: 0.7rem; color: #6c757d; margin-top: 6px; display: block;">
                            <i class="fas fa-info-circle"></i> Leave empty to keep current image. Max size: 2MB (JPG, PNG, GIF)
                        </small>
                    </div>

                    <!-- Category -->
                    <div class="form-group">
                        <label><i class="fas fa-tags"></i> Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Select Category --</option>
                            <?php if(isset($categories) && !empty($categories)): ?>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>" <?= ($product['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                        <?= $cat['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Product Name -->
                    <div class="form-group">
                        <label><i class="fas fa-box"></i> Product Name</label>
                        <input type="text" name="name" class="form-control" value="<?= $product['name'] ?>" required placeholder="Enter product name">
                    </div>

                    <!-- Price -->
                    <div class="form-group">
                        <label><i class="fas fa-tag"></i> Price (₱)</label>
                        <input type="number" step="0.01" name="price" class="form-control" value="<?= $product['price'] ?>" required placeholder="0.00">
                    </div>

                    <!-- Stock -->
                    <div class="form-group">
                        <label><i class="fas fa-warehouse"></i> Stock Quantity</label>
                        <input type="number" name="stock" class="form-control" value="<?= $product['stock'] ?>" required placeholder="0">
                    </div>

                    <!-- Buttons -->
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Product
                        </button>
                        <a href="<?= base_url('/products') ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.querySelector('.current-image');
                    if (preview) {
                        preview.src = e.target.result;
                    }
                }
                reader.readAsDataURL(input.files[0]);
                
                // Update the custom file input text
                const fileName = input.files[0].name;
                const customSpan = document.querySelector('.file-input-custom span');
                if (customSpan) {
                    customSpan.innerHTML = `<i class="fas fa-check-circle"></i> ${fileName}`;
                }
            }
        }
    </script>
</body>
</html>