<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Bensan Bakeshop</title>
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

        .image-preview {
            margin-top: 12px;
            text-align: center;
            padding: 20px;
            background: #fafbfc;
            border-radius: 16px;
            border: 1px dashed #e9ecef;
            display: none;
        }

        .preview-img {
            max-width: 150px;
            max-height: 150px;
            border-radius: 12px;
            object-fit: cover;
        }

        @media (max-width: 640px) {
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
                <h2><i class="fas fa-plus-circle" style="color: #28a745; margin-right: 8px;"></i> Add New Product</h2>
                <p>Create a new product for your bakeshop</p>
            </div>
            <div class="card-body">
                <form action="<?= base_url('/product/store') ?>" method="post" enctype="multipart/form-data">
                    <!-- Product Image -->
                    <div class="form-group">
                        <label><i class="fas fa-image"></i> Product Image</label>
                        <div class="file-input-wrapper">
                            <div class="file-input-custom" onclick="document.getElementById('imageInput').click()">
                                <span><i class="fas fa-cloud-upload-alt"></i> Choose product image</span>
                                <i class="fas fa-chevron-right"></i>
                            </div>
                            <input type="file" name="image" id="imageInput" accept="image/*" style="display: none;" onchange="previewImage(this)">
                        </div>
                        <div class="image-preview" id="imagePreview">
                            <img id="previewImg" class="preview-img" alt="Preview">
                        </div>
                        <small style="font-size: 0.7rem; color: #6c757d; margin-top: 6px; display: block;">
                            <i class="fas fa-info-circle"></i> Supported formats: JPG, PNG, GIF (Max: 2MB)
                        </small>
                    </div>

                    <!-- Category -->
                    <div class="form-group">
                        <label><i class="fas fa-tags"></i> Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Select Category --</option>
                            <?php if(isset($categories) && !empty($categories)): ?>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= $cat['name'] ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <!-- Product Name -->
                    <div class="form-group">
                        <label><i class="fas fa-box"></i> Product Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="Enter product name">
                    </div>

                    <!-- Price -->
                    <div class="form-group">
                        <label><i class="fas fa-tag"></i> Price (₱)</label>
                        <input type="number" step="0.01" name="price" class="form-control" required placeholder="0.00">
                    </div>

                    <!-- Stock -->
                    <div class="form-group">
                        <label><i class="fas fa-warehouse"></i> Stock Quantity</label>
                        <input type="number" name="stock" class="form-control" required placeholder="0">
                    </div>

                    <!-- Buttons -->
                    <div class="btn-group">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Save Product
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
            const previewDiv = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewDiv.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
                
                // Update button text
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