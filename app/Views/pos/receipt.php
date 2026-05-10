<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Bensan Bakeshop</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            padding: 20px;
            max-width: 350px;
            margin: 0 auto;
            background: #f5f5f5;
        }
        .receipt {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 1px dashed #ccc;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h2 {
            margin: 0;
            color: #ff6b35;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .order-details {
            margin-bottom: 15px;
            font-size: 12px;
        }
        .items {
            border-top: 1px dashed #ccc;
            border-bottom: 1px dashed #ccc;
            padding: 10px 0;
            margin: 10px 0;
        }
        .item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 12px;
        }
        .total {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 16px;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 2px solid #333;
        }
        .footer {
            text-align: center;
            margin-top: 15px;
            font-size: 10px;
            color: #666;
        }
        .button {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            background: #ff6b35;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .button:hover {
            background: #e55a2b;
        }
        @media print {
            .no-print {
                display: none;
            }
            body {
                background: white;
                padding: 0;
            }
            .receipt {
                box-shadow: none;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h2>🥖 Bensan Bakeshop</h2>
            <p>Ordering System</p>
        </div>
        
        <div class="order-details">
            <p><strong>Order #:</strong> <?= $order['order_number'] ?></p>
            <p><strong>Date:</strong> <?= date('F d, Y h:i A', strtotime($order['order_date'])) ?></p>
            <p><strong>Customer:</strong> <?= $order['customer_name'] ?></p>
            <p><strong>Type:</strong> <?= ucfirst($order['order_type']) ?></p>
            <p><strong>Cashier:</strong> <?= $cashier ?></p>
        </div>
        
        <div class="items">
            <?php foreach($items as $item): ?>
            <div class="item">
                <span><?= $item['name'] ?> x <?= $item['quantity'] ?></span>
                <span>₱<?= number_format($item['price'] * $item['quantity'], 2) ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="total">
            <span>TOTAL:</span>
            <span>₱<?= number_format($order['total'], 2) ?></span>
        </div>
        
        <div class="footer">
            <p>Thank you for your purchase!</p>
            <p>Please come again</p>
        </div>
    </div>
    
    <button class="button no-print" onclick="window.print()">
        <i class="fas fa-print"></i> Print Receipt
    </button>
    <button class="button no-print" onclick="window.close()" style="background:#6c757d">
        Close
    </button>
</body>
</html>