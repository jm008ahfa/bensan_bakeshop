<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number"><?= $readyCount ?? 0 ?></div>
        <div class="stat-label">Ready for Pickup</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $assignedCount ?? 0 ?></div>
        <div class="stat-label">My Deliveries</div>
    </div>
    <div class="stat-card">
        <div class="stat-number"><?= $completedCount ?? 0 ?></div>
        <div class="stat-label">Completed</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4><i class="fas fa-info-circle"></i> Quick Guide</h4>
    </div>
    <div class="card-body">
        <p>Welcome to the Rider Portal!</p>
        <ul style="margin-top: 10px; padding-left: 20px;">
            <li>📋 <strong>Ready for Pickup</strong> - Orders waiting for you to accept</li>
            <li>🚚 <strong>My Deliveries</strong> - Orders you have accepted</li>
            <li>✅ <strong>Completed</strong> - Successfully delivered orders</li>
        </ul>
    </div>
</div>