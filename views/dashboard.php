<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lumia - Painel Administrativo</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="../styles/admin.css" rel="stylesheet">
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
                <a href="dashboard.php" class="nav-item active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="7" height="7" rx="1" />
                        <rect x="14" y="3" width="7" height="7" rx="1" />
                        <rect x="3" y="14" width="7" height="7" rx="1" />
                        <rect x="14" y="14" width="7" height="7" rx="1" />
                    </svg>
                    Dashboard
                </a>
                <a href="graphs.php" class="nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12" />
                    </svg>
                    Estatísticas
                </a>
            </div>
            <div class="nav-section">
                <div class="nav-label">Catálogo</div>
                <a href="products.php" class="nav-item">
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
                <a href="sales.php" class="nav-item">
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
                <a href="sales.php" class="nav-item">
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
            <span class="topbar-title" id="topbar-title">Dashboard</span>
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
            

            <!-- DASHBOARD -->
            <div class="page active" id="page-dashboard">
                <div class="page-header">
                    <div>
                        <h1>Dashboard</h1>
                        <p>Bem-vindo de volta, Renan 👋</p>
                    </div>
                </div>

                <div class="stats-grid">
                    <div class="stat-card blue">
                        <div class="stat-icon blue">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <line x1="12" y1="1" x2="12" y2="23" />
                                <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6" />
                            </svg>
                        </div>
                        <div class="stat-value">R$ 94.280</div>
                        <div class="stat-label">Receita Total</div>
                        <div class="stat-change up">↑ +12,4% este mês</div>
                    </div>
                    <div class="stat-card green">
                        <div class="stat-icon green">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="9" cy="21" r="1" />
                                <circle cx="20" cy="21" r="1" />
                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6G6" />
                            </svg>
                        </div>
                        <div class="stat-value">1.482</div>
                        <div class="stat-label">Pedidos</div>
                        <div class="stat-change up">↑ +8,1% este mês</div>
                    </div>
                    <div class="stat-card orange">
                        <div class="stat-icon orange">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75" />
                            </svg>
                        </div>
                        <div class="stat-value">3.241</div>
                        <div class="stat-label">Clientes</div>
                        <div class="stat-change up">↑ +5,3% este mês</div>
                    </div>
                    <div class="stat-card purple">
                        <div class="stat-icon purple">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 8v13H3V8" />
                                <path d="M1 3h22v5H1z" />
                                <line x1="10" y1="12" x2="14" y2="12" />
                            </svg>
                        </div>
                        <div class="stat-value">587</div>
                        <div class="stat-label">Produtos Ativos</div>
                        <div class="stat-change down">↓ -2 este mês</div>
                    </div>
                </div>
                <div class="chart-grid">
                    <div class="card">
                        <div class="card-header">
                            <span class="card-title">Receita Mensal</span>
                            <span class="badge blue">2026</span>
                        </div>
                        <div class="mini-chart" id="barChart"></div>
                        <div class="chart-months" id="barLabels"></div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <span class="card-title">Categorias</span>
                        </div>
                        <div class="donut-wrap">
                            <svg class="donut" width="120" height="120" viewBox="0 0 120 120">
                                <circle cx="60" cy="60" r="50" fill="none" stroke="#1e2230" stroke-width="18" />
                                <circle cx="60" cy="60" r="50" fill="none" stroke="#4f6ef7" stroke-width="18" stroke-dasharray="138 176" stroke-dashoffset="0" />
                                <circle cx="60" cy="60" r="50" fill="none" stroke="#22c55e" stroke-width="18" stroke-dasharray="80 234" stroke-dashoffset="-138" />
                                <circle cx="60" cy="60" r="50" fill="none" stroke="#f97316" stroke-width="18" stroke-dasharray="55 259" stroke-dashoffset="-218" />
                                <circle cx="60" cy="60" r="50" fill="none" stroke="#7c3aed" stroke-width="18" stroke-dasharray="41 273" stroke-dashoffset="-273" />
                            </svg>
                        </div>
                        <div class="donut-legends">
                            <div class="legend-item">
                                <div class="legend-dot" style="background: #4f6ef7"></div>
                                <span style="flex:1">Eletrônicos</span>
                                <strong>44%</strong>
                            </div>
                            <div class="legend-item">
                                <div class="legend-dot" style="background: #22c55e"></div>
                                <span style="flex:1">Moda</span>
                                <strong>25%</strong>
                            </div>
                            <div class="legend-item">
                                <div class="legend-dot" style="background: #f97316"></div>
                                <span style="flex:1">Casa</span>
                                <strong>18%</strong>
                            </div>
                            <div class="legend-item">
                                <div class="legend-dot" style="background: #7c3aed"></div>
                                <span style="flex:1">Outros</span>
                                <strong>13%</strong>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Últimas Vendas</span>
                        <button class="btn btn-ghost btn-sm">Ver todas</button>
                    </div>
                    <table>
                        <thead>
                            <th>Pedido</th>
                            <th>Cliente</th>
                            <th>Produto</th>
                            <th>Valor</th>
                            <th>Status</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>#4821</td>
                                <td>Ana Costa</td>
                                <td>iPhone 15 Pro</td>
                                <td>R$ 6.999</td>
                                <td><span class="badge green">Entregue</span></td>
                            </tr>
                            <tr>
                                <td>#4820</td>
                                <td>Carlos Lima</td>
                                <td>Samsung Galaxy S24</td>
                                <td>R$ 4.499</td>
                                <td><span class="badge blue">Enviado</span></td>
                            </tr>
                            <tr>
                                <td>#4819</td>
                                <td>Mariana Silva</td>
                                <td>MacBook Air M3</td>
                                <td>R$ 12.490</td>
                                <td><span class="badge orange">Processando</span></td>
                            </tr>
                            <tr>
                                <td>#4818</td>
                                <td>Pedro Rocha</td>
                                <td>AirPods Pro</td>
                                <td>R$ 1.899</td>
                                <td><span class="badge green">Entregue</span></td>
                            </tr>
                            <tr>
                                <td>#4817</td>
                                <td>Luísa Ferreira</td>
                                <td>PS5 Slim</td>
                                <td>R$ 3.799</td>
                                <td><span class="badge red">Cancelado</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <!-- /content   -->
    </main>
</body>
<script>
    // BAR CHART
    const months = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
    const values = [62, 78, 55, 88, 72, 95, 84, 102, 91, 88, 75, 94];
    const max = Math.max(...values);
    const chart = document.getElementById('barChart');
    const labels = document.getElementById('barLabels');
    months.forEach((m, i) => {
        const h = Math.round((values[i] / max) * 140);
        chart.innerHTML += `<div class="bar-wrap"><div class="bar" style="height:${h}px" title="R$ ${values[i]}k"></div></div>`;
        labels.innerHTML += `<div class="bar-wrap">${m}</div>`;
    });
</script>

</html>