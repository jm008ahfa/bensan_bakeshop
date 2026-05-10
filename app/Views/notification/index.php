<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4><i class="fas fa-bell"></i> Notifications</h4>
        <a href="<?= base_url('/notifications/markAllRead') ?>" class="btn btn-sm btn-primary">
            <i class="fas fa-check-double"></i> Mark All as Read
        </a>
    </div>
    <div class="card-body">
        <?php if(!empty($notifications)): ?>
            <div class="list-group">
                <?php foreach($notifications as $notif): ?>
                <div class="list-group-item <?= $notif['is_read'] ? '' : 'list-group-item-warning' ?>" style="border-left: 3px solid <?= $notif['type'] == 'rider_assigned' ? '#28a745' : '#ff6b35' ?>;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <?php if($notif['type'] == 'rider_assigned'): ?>
                                <i class="fas fa-motorcycle text-success"></i>
                            <?php else: ?>
                                <i class="fas fa-bell text-primary"></i>
                            <?php endif; ?>
                            <strong><?= $notif['message'] ?></strong>
                        </div>
                        <div>
                            <small class="text-muted"><?= date('M d, h:i A', strtotime($notif['created_at'])) ?></small>
                            <?php if(!$notif['is_read']): ?>
                                <a href="<?= base_url('/notifications/markRead/'.$notif['id']) ?>" class="btn btn-sm btn-link">Mark Read</a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if($notif['order_number']): ?>
                    <div class="mt-2">
                        <a href="<?= base_url('/order-confirmation/view/'.$notif['order_id']) ?>" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-eye"></i> View Order #<?= $notif['order_number'] ?>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="text-center p-5">
                <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                <p>No notifications yet</p>
            </div>
        <?php endif; ?>
    </div>
</div>