<style type="text/css">
.nav-sidebar .nav-link {
    position: relative;
    transition: background 0.2s ease;
}

/* Orange left bar */
.nav-sidebar .nav-link::before {
    content: "";
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 4px;
    background: orange;
    border-radius: 0 3px 3px 0;

    transform: scaleY(0);
    transform-origin: top;
    transition: transform 0.25s ease;
}

/* Show orange bar on hover & active */
.nav-sidebar .nav-link.active::before,
.nav-sidebar .nav-link:hover::before {
    transform: scaleY(1);
}

/* SUPER LIGHT GRADIENT */
.nav-sidebar .nav-link:hover,
.nav-sidebar .nav-link.active {
    background: linear-gradient(
        to right,
        rgba(255, 165, 0, 0.05),   /* extremely light orange */
        rgba(255, 165, 0, 0.01)    /* almost invisible */
    ) !important;
    box-shadow: none !important;
}

/* Submenu items same gradient */
.nav-treeview .nav-link:hover,
.nav-treeview .nav-link.active {
    background: linear-gradient(
        to right,
        rgba(255, 165, 0, 0.05),
        rgba(255, 165, 0, 0.01)
    ) !important;
    box-shadow: none !important;
}

/* Sidebar links text and icons in dark mode */
body.dark-mode .main-sidebar .nav-link {
    color: #fff !important;
}

body.dark-mode .main-sidebar .nav-link p {
    color: #fff !important;
}

body.dark-mode .main-sidebar .nav-icon {
    color: #fff !important;
}

/* Active or hovered link */
body.dark-mode .main-sidebar .nav-link.active,
body.dark-mode .main-sidebar .nav-link:hover {
    background-color: rgba(255, 255, 255, 0.1) !important; /* slightly lighter bg on hover/active */
}

</style>


<div class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/dashboard') ?>">📊 Dashboard</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/products') ?>">🥖 Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/orders') ?>">📦 Orders</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('/order/create') ?>">➕ New Order</a>
            </li>
        </ul>
    </div>
</div>
</aside>