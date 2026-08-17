<form method="POST">
    <?php echo csrf_field(); ?>
    <div class="page-header">
        <div class="page-header-left">
            <a class="btn btn-ghost btn-icon" href="?route=sales/index" title="Voltar para Vendas">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="19" y1="12" x2="5" y2="12" />
                    <polyline points="12 19 5 12 12 5" />
                </svg>
            </a>
            <div>
                <h1>Nova Venda</h1>
                <p>Busque e adicione produtos - o resumo é montado ao lado</p>
            </div>
        </div>
    </div>
    <div class="form-panel">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10" />
                    <line x1="12" y1="8" x2="12" y2="12" />
                    <line x1="12" y1="16" x2="12.01" y2="16" />
                </svg>
                <ul class="alert-list">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="sale-layout">
            <div class="sale-main">
                <div class="autocomplete">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input type="text" id="searchInput" placeholder="Buscar produto pelo nome." autocomplete="off">
                    <div class="autocomplete-results" id="acResulds">
                        <!-- RESULTADOS -->
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">Itens adicionados</div>
                            <div class="card-subtitle">Ajuste quantidade e valor unitário conforme necessário</div>
                        </div>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Qtd.</th>
                                <th>Valor unitário</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="itemsBody"></tbody>
                    </table>
                </div>
            </div>

            <div class="summary">
                <h2>Resumo da venda</h2>
                <div class="field">
                    <label class="form-label">Nome do Cliente</label>
                    <input class="form-input" type="text" id="customerName" name="customer_name" placeholder="Ex: Maria da Silva" value="<?php echo e($customerName); ?>">
                </div>
                <div class="field">
                    <label class="form-label">Desconto (R$)</label>
                    <input class="form-input" type="text" id="discountAmount" name="discount_amount" min="0" step="0.01" value="<?php echo e($discountAmount); ?>">
                </div>
                <div class="field">
                    <label class="form-label">Status</label>
                    <select class="form-select" id="statusSelect" name="status">
                        <option value="completed" <?php echo $status === 'completed' ? 'selected' : ''; ?>>Concluída</option>
                        <option value="cancelled" <?php echo $status === 'cancelled' ? 'selected' : ''; ?>>Cancelada</option>
                    </select>
                </div>

                <div class="summary-divider"></div>

                <div class="summary-row"><span>Itens distintos</span><span id="sumDistinct">0</span></div>
                <div class="summary-row"><span>Quantidade total</span><span id="sumQty">0</span></div>
                <div class="summary-row"><span>Subtotal</span><span id="sumSubtotal">R$ 0,00</span></div>

                <div class="summary-total"><span>Total</span><span id="sumTotal">R$ 0,00</span></div>
            
                <div id="itemsInputs"></div>
                <button type="submit" class="btn-finalize" id="btnFinalize" disabled>Finalizar venda</button>
            </div>
        </div>
</form>