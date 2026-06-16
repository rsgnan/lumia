<div class="page active" id="page-dashboard">
    <div class="page-header">
        <div>
            <h1>Dashboard</h1>
            <p>Bem-vindo de volta, Renan Gonçalves 👋</p>
        </div>
    </div>
    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-icon blue">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="12" x1="1" x2="12" y2="23" />
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
                    <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <path d="M16 10a4 4 0 01-8 0" />
                </svg>
            </div>
            <div class="stat-value">1.482</div>
            <div class="stat-label">Pedidos</div>
            <div class="stat-change up">↑ +8,1 este mês</div>
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
                    <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z" />
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
                <span class="badge blue">2025</span>
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
                    <div class="legend-dot" style="background:#4f6ef7"></div>
                    <span style="flex:1">Eletrônicos</span><strong>44%</strong>
                </div>
                 <div class="legend-item">
                    <div class="legend-dot" style="background:#22c55e"></div>
                    <span style="flex:1">Moda</span><strong>25%</strong>
                </div>
                 <div class="legend-item">
                    <div class="legend-dot" style="background:#f97316"></div>
                    <span style="flex:1">Casa</span><strong>18%</strong>
                </div>
                 <div class="legend-item">
                    <div class="legend-dot" style="background:#7c3aed"></div>
                    <span style="flex:1">Outros</span><strong>13%</strong>
                </div>
            </div>
        </div>
    </div>
<div class="card">
    <div class="card-header">
        <span class="card-title">Últimas Vendas</span>
        <button class="btn btn-ghost btn-sm" onclick="showPage('vendas', document.querySelector('[onlick*=vendas]'))">Ver todas</button>
    </div>
    <table>
        <thead>
            <tr>
                <th>Pedido</th>
                <th>Cliente</th>
                <th>Produto</th>
                <th>Valor</th>
                <th>Status</th>
            </tr>
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
                <td><span class="badgeblue">Enviado</span></td>
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