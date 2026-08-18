<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumia - Painel Administrativo</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="assets/css/admin.css" rel="stylesheet">
    <link href="assets/css/sale.css" rel="stylesheet">
</head>

<body>
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="logo">
            <div class="logo-icon">LM</div>
            <div class="logo-text">Lumia</div>
        </div>
        <nav class="nav">
            <div class="nav-section">
                <div class="nav-label">Principal</div>
                <a href="?route=dashboard/index" class="nav-item <?php if (isset($_GET['route']) && $_GET['route'] == 'dashboard/index') echo e('active'); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                    Dashboard
                </a>
                <a href="?route=graphs/index" class="nav-item <?php if (isset($_GET['route']) && $_GET['route'] == 'graphs/index') echo e('active'); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                    Estatísticas
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-label">Catálogo</div>
                <a href="?route=products/index" class="nav-item <?php if (isset($_GET['route']) && $_GET['route'] == 'products/index') echo e('active'); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 8v13H3V8" />
                        <path d="M1 3h22v5H1z" />
                        <line x1="10" y1="12" x2="14" y2="12" />
                    </svg>
                    Produtos
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-label">Comercial</div>
                <a href="?route=sales/index" class="nav-item <?php if (isset($_GET['route']) && $_GET['route'] == 'sales/index') echo e('active'); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23" />
                        <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                    </svg>
                    Vendas
                    <span class="nav-badge">12</span>
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-label">Administração</div>
                <a href="?route=users/index" class="nav-item <?php if (isset($_GET['route']) && $_GET['route'] == 'users/index"') echo e('active'); ?>">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4">
                    </svg>
                    Usuários
                </a>
            </div>
        </nav>
        <div class="sidebar-footer">
            <div class="avatar">RG</div>
            <div class="user-info">
                <div class="user-name">Renan Gonçalves</div>
                <div class="user-role">Administrador</div>
            </div>
        </div>
    </aside>

    <!-- MAIN -->
    <main class="main">
        <header class="topbar">
            <div class="search-box">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input type="text" placeholder="Pesquisar por produto...">
            </div>
            <div class="topbar-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" />
                </svg>
                <div class="notif-dot"></div>
            </div>
            <div class="topbar-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                </svg>
            </div>
        </header>

        <div class="content">
            <!-- CONTENT -->
            <?php echo $contents; ?>
        </div>
        <!-- /CONTENT   -->
    </main>
</body>
<script>
    // PREVIEW IMAGE
    const productImageInput = document.getElementById('product-image-input');
    if (productImageInput) {
        productImageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('image-preview');
            const icon = document.getElementById('image-upload-icon');
            const text = document.getElementById('image-upload-text');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    preview.src = ev.target.result;
                    preview.style.display = 'block';
                    icon.style.display = 'none';
                    text.style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
                icon.style.display = '';
                text.style.display = '';
            }
        });
    }
    // BAR CHART
    const months = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    const values = [62, 78, 55, 88, 72, 95, 84, 102, 91, 88, 75, 94];
    const max = Math.max(...values);
    const chart = document.getElementById('barChart');
    const labels = document.getElementById('barLabels');
    if (chart && labels) {
        months.forEach((m, i) => {
            const h = Math.round((values[i] / max) * 140);
            chart.innerHTML += `<div class="bar-wrap"><div class="bar" style="height:${h}px" title="R$ ${values[i]}k"></div></div>`;
            labels.innerHTML += `<div class="bar-wrap">${m}</div>`;
        });
    }
</script>

</html>