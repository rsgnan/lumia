<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumia - Painel Admistrativo</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="styles/styles.css" rel="stylesheet">
</head>

<body>

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="logo">
            <div class="logo-icon">LM</div>
            <div class="logo-text">Lumia<span>App</span></div>
        </div>
        <nav class="nav">
            <div class="nav-section">
                <div class="nav-label">Admin</div>
                <div class="nav-item active" onclick="showPage('dashboard', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                    Dashboard
                </div>
                <div class="nav-item" onclick="showPage('estatisticas', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points=" 22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                    Estatísticas
                </div>
            </div>
            <div class="nav-section">
                <div class="nav-label">Catálogo</div>
                <div class="nav-item" onclick="showPage('produtos', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
                    </svg>
                    Produtos
                </div>
                <div class="nav-item" onclick="showPage('marcas', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <path d="M8.56 2.75c4.37 6.03 6.02 9.42 8.03 17.72m2.54-15.38c-3.72 4.35-8.94 5.66-16.88 5.85m19.5 1.9c-3.5-.93-6.63-.82-8.94 0-2.58.92-5.01 2.86-7.44 6.32" />
                    </svg>
                    Marcas
                </div>
            </div>
            <div class="nav-section">
                <div class="nav-label">Comercial</div>
                <div class="nav-item" onclick="showPage('vendas', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <line x1="12" y1="1" x2="12" y2="23" />
                        <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                    </svg>
                    Vendas
                    <span class="nav-badge">12</span>
                </div>
                <div class="nav-item" onclick="showPage('clientes', this)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                    </svg>
                    Clientes
                </div>
            </div>
        </nav>
        <div class="sidebar-footer">
            <div class="avatar">RG</div>
            <div class="user-info">
                <div class="user-name">Renan Gonçalves</div>
                <div class="user-role">Admnistrador</div>
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
                <input type="text" placeholder="Pesquisar...">
            </div>
            <div class="topbar-btn">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" />
                </svg>
                <div class="notif-dot"></div>
            </div>
            <div class="user-dropdown-wrap">
                <div class="topbar-btn" id="user-btn" onclick="toggleUserDropdown(event)">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="8" r="4" />
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                    </svg>
                </div>
                <div class="user-dropdown" id="user-dropdown">
                    <div class="user-dropdown-header">
                        <div class="user-dropdown-name">Renan Gonçalves</div>
                        <div class="user-dropdown-role">Administrador</div>
                    </div>
                    <div class="user-dropdown-item">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                        Meu Perfil
                    </div>
                    <div class="user-dropdown-item logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4" />
                            <polyline points="16 17 21 12 16 7" />
                            <line x1="21" y1="12" x2="9" y2="12" />
                        </svg>
                        <a href="index.php?<?php echo http_build_query(['route' => 'admin/logout']); ?>">Sair</a>
                    </div>
                </div>
            </div>
        </header>
        <div class="content">
        <!-- the rendered view content from the controller -->
        <?= $contents ?? ''; ?>
        </div>
    </main>
<script>
    // USER DROPDOWN
        function toggleUserDropdown(event) {
            event.stopPropagation();
            document.getElementById('user-dropdown').classList.toggle('open');
        }
    // TABS
    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', () => {
            tab.closest('.tabs').querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        });
    });

    // BAR CHART
    const chart = document.getElementById('barChart');
        const labels = document.getElementById('barLabels');

        if (chart && labels) {
            const months = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
            const values = [62, 78, 55, 88, 72, 95, 84, 102, 91, 88, 75, 94];
            const max = Math.max(...values);
            months.forEach((m, i) => {
                const h = Math.round((values[i] / max) * 140);
                chart.innerHTML += `<div class="bar-wrap"><div class="bar" style="height:${h}px" title="R$ ${values[i]}k"></div></div>`;
                labels.innerHTML += `<div class="bar-wrap">${m}</div>`;
            });
        }
</script>
</body>

</html>