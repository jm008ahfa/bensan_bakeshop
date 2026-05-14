<style>
    .delivery-container { max-width: 600px; margin: 0 auto; }
    .form-card { background: white; border-radius: 20px; border: 1px solid #eef2f7; overflow: hidden; }
    .form-header { background: #28a745; color: white; padding: 20px; }
    .form-body { padding: 24px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-weight: 600; margin-bottom: 8px; }
    .form-control { width: 100%; padding: 12px; border: 1px solid #eef2f7; border-radius: 12px; font-family: inherit; }
    textarea.form-control { resize: vertical; min-height: 100px; }
    .photo-preview { margin-top: 10px; max-width: 200px; display: none; }
    .photo-preview img { width: 100%; border-radius: 12px; border: 1px solid #eef2f7; }
    .btn-submit { width: 100%; padding: 14px; background: #28a745; color: white; border: none; border-radius: 12px; font-weight: 600; cursor: pointer; }
    .order-info { background: #f8f9fa; padding: 15px; border-radius: 12px; margin-bottom: 20px; }
</style>

<div class="delivery-container">
    <div class="form-card">
        <div class="form-header">
            <h3><i class="fas fa-check-circle"></i> Confirm Delivery</h3>
            <p>Please confirm that you have delivered the order</p>
        </div>
        <div class="form-body">
            
            <div class="order-info">
                <p><strong><i class="fas fa-receipt"></i> Order #:</strong> <?= $order['order_number'] ?></p>
                <p><strong><i class="fas fa-user"></i> Customer:</strong> <?= $order['customer_name'] ?></p>
                <p><strong><i class="fas fa-phone"></i> Phone:</strong> <?= $order['customer_phone'] ?? 'N/A' ?></p>
                <p><strong><i class="fas fa-map-marker-alt"></i> Address:</strong> <?= $order['delivery_address'] ?></p>
                <p><strong><i class="fas fa-tag"></i> Total:</strong> ₱<?= number_format($order['total'], 2) ?></p>
            </div>
            
            <div class="order-info">
                <strong><i class="fas fa-box"></i> Items Delivered:</strong>
                <?php foreach($items as $item): ?>
                <p style="margin-top: 5px;">• <?= $item['product_name'] ?> x <?= $item['quantity'] ?></p>
                <?php endforeach; ?>
            </div>
            
            <form id="deliveryForm">
                <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                
                <div class="form-group">
                    <label><i class="fas fa-camera"></i> Delivery Photo (Optional)</label>
                    <input type="file" name="delivery_photo" class="form-control" accept="image/*" id="deliveryPhoto" onchange="previewPhoto(this)">
                    <div class="photo-preview" id="photoPreview">
                        <img id="previewImg" src="">
                    </div>
                </div>
                
                <div class="form-group">
                    <label><i class="fas fa-pen"></i> Delivery Notes</label>
                    <textarea name="delivery_notes" class="form-control" placeholder="Any notes about the delivery (e.g., handed to customer, left at doorstep, etc.)"></textarea>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-check-circle"></i> Confirm Delivery
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function previewPhoto(input) {
    const preview = document.getElementById('photoPreview');
    const previewImg = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(input.files[0]);
    }
}

document.getElementById('deliveryForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
    
    const formData = new FormData();
    formData.append('order_id', document.querySelector('input[name="order_id"]').value);
    formData.append('delivery_notes', document.querySelector('textarea[name="delivery_notes"]').value);
    
    const photoFile = document.querySelector('input[name="delivery_photo"]').files[0];
    if (photoFile) {
        formData.append('delivery_photo', photoFile);
    }
    
    try {
        const response = await fetch('<?= base_url("/rider/processDelivery") ?>', {
            method: 'POST',
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            alert('Delivery confirmed successfully!');
            window.location.href = '<?= base_url("/rider/completed") ?>';
        } else {
            alert(data.message);
        }
    } catch (error) {
        alert('Error confirming delivery');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    }
});
</script>