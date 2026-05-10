<div style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <div style="background: white; border-radius: 20px; padding: 30px; border: 1px solid #eef2f7;">
        <h2 style="margin-bottom: 24px;">My Profile</h2>
        
        <div id="profileMessage" style="display: none; padding: 12px; border-radius: 12px; margin-bottom: 20px;"></div>
        
        <form id="profileForm">
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">Full Name</label>
                <input type="text" id="name" value="<?= session()->get('customer_name') ?>" 
                       style="width: 100%; padding: 12px; border: 1px solid #eef2f7; border-radius: 12px;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">Email Address</label>
                <input type="email" value="<?= session()->get('customer_email') ?>" disabled
                       style="width: 100%; padding: 12px; border: 1px solid #eef2f7; border-radius: 12px; background: #f8f9fa;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">Phone Number</label>
                <input type="tel" id="phone" value="<?= session()->get('customer_phone') ?>"
                       style="width: 100%; padding: 12px; border: 1px solid #eef2f7; border-radius: 12px;">
            </div>
            
            <div style="margin-bottom: 20px;">
                <label style="display: block; font-weight: 600; margin-bottom: 8px;">Delivery Address</label>
                <textarea id="address" rows="3" style="width: 100%; padding: 12px; border: 1px solid #eef2f7; border-radius: 12px;"><?= session()->get('customer_address') ?></textarea>
            </div>
            
            <button type="submit" style="padding: 12px 30px; background: #ff6b35; color: white; border: none; border-radius: 30px; cursor: pointer; font-weight: 600;">
                Save Changes
            </button>
        </form>
    </div>
</div>

<script>
document.getElementById('profileForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const btn = this.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
    btn.disabled = true;
    
    try {
        const response = await fetch('<?= base_url("/customer/update-profile") ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({
                'name': document.getElementById('name').value,
                'phone': document.getElementById('phone').value,
                'address': document.getElementById('address').value
            })
        });
        
        const data = await response.json();
        
        const messageDiv = document.getElementById('profileMessage');
        if (data.success) {
            messageDiv.style.display = 'block';
            messageDiv.style.background = '#e8f5e9';
            messageDiv.style.color = '#2e7d32';
            messageDiv.style.border = '1px solid #c8e6c9';
            messageDiv.innerHTML = '<i class="fas fa-check-circle"></i> ' + data.message;
            
            setTimeout(() => {
                messageDiv.style.display = 'none';
            }, 3000);
        } else {
            messageDiv.style.display = 'block';
            messageDiv.style.background = '#ffebee';
            messageDiv.style.color = '#c62828';
            messageDiv.style.border = '1px solid #ffcdd2';
            messageDiv.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + data.message;
        }
    } catch (error) {
        console.error(error);
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
});
</script>