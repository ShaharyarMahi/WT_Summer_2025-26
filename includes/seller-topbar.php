<?php
// $store must be passed from the controller
$storeName = $store["store_name"] ?? "Store";
$words = preg_split('/\s+/', trim($storeName));
$initials = strtoupper(substr($words[0] ?? '', 0, 1) . substr($words[1] ?? '', 0, 1));
?>
<div class="seller-topbar">
    <div></div>
    <div class="seller-topbar-actions">
        <button class="icon-btn" aria-label="Notifications">
            🔔 <span class="notif-badge">3</span>
        </button>
        <div class="store-view-dropdown">🏬 Store View ▾</div>
        <div class="seller-user">
            <div class="seller-avatar"><?php echo htmlspecialchars($initials); ?></div>
            <span><?php echo htmlspecialchars($storeName); ?> ▾</span>
        </div>
    </div>
</div>