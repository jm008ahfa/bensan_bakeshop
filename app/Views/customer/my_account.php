<div style="max-width: 1200px; margin: 0 auto; padding: 40px 24px;">
    <h1 style="font-size: 1.8rem; font-weight: 600; margin-bottom: 8px;">My Account</h1>
    <p style="color: #6c757d; margin-bottom: 40px;">Manage your profile and order history</p>
    
    <div style="display: grid; grid-template-columns: 280px 1fr; gap: 32px;">
        
        <!-- Sidebar -->
        <div style="background: white; border-radius: 20px; border: 1px solid #eef2f7; height: fit-content;">
            <div style="padding: 24px; border-bottom: 1px solid #eef2f7; text-align: center;">
                <div style="width: 70px; height: 70px; background: #ff6b35; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <i class="fas fa-user" style="font-size: 32px; color: white;"></i>
                </div>
                <h3 style="font-size: 1rem;"><?= session()->get('customer_name') ?></h3>
                <p style="font-size: 0.75rem; color: #6c757d;"><?= session()->get('customer_email') ?></p>
            </div>
            <div style="padding: 8px 0;">
                <a href="<?= base_url('/customer/account') ?>" style="display: flex; align-items: center; gap: 12px; padding: 12px 24px; background: #fff5f0; color: #ff6b35; text-decoration: none; border-left: 3px solid #ff6b35;">
                    <i class="fas fa-user-circle"></i> My Profile
                </a>
                <a href="<?= base_url('/customer/dashboard') ?>" style="display: flex; align-items: center; gap: 12px; padding: 12px 24px; color: #4a5568; text-decoration: none;">
                    <i class="fas fa-shopping-bag"></i> My Orders
                </a>
                <a href="<?= base_url('/customer/logout') ?>" style="display: flex; align-items: center; gap: 12px; padding: 12px 24px; color: #dc3545; text-decoration: none; border-top: 1px solid #eef2f7; margin-top: 8px;">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div style="background: white; border-radius: 20px; border: 1px solid #eef2f7; padding: 32px;">
            <h2 style="font-size: 1.3rem; font-weight: 600; margin-bottom: 24px;">Profile Information</h2>
            
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
        
        if (data.success) {
            alert('Profile updated successfully!');
            location.reload();
        } else {
            alert(data.message);
        }
    } catch (error) {
        alert('Error updating profile');
    } finally {
        btn.innerHTML = originalText;
        btn.disabled = false;
    }
});
</script>