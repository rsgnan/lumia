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
        <div class="sale-layout">
            <!-- ÁREA PRINCIPAL -->
            <div class="sale-main">
                <div class="autocomplete">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7" />
                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                    </svg>
                    <input type="text" id="searchInput" placeholder="Buscar produto pelo nome..." autocomplete="off">
                    <div class="autocomplete-results" id="autocompleteResults">
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <div>
                            <div class="card-title">
                                Itens adicionados
                            </div>

                            <div class="card-subtitle">
                                Os produtos adicionados à venda aparecerão aqui.
                            </div>
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
                        <tbody id="itemsBody">
                            <tr>
                                <td colspan="5" style="text-align: center; color: var(--muted);">
                                    Nenhum produto adicionado.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        <!-- RESUMO -->
        <div class="summary">
            <h2>Resumo da venda</h2>

            <div class="field">
                <label class="form-label" for="customerName">
                    Nome do Cliente
                </label>
                <input class="form-input" type="text" id="customerName" name="customer_name" placeholder="Ex: Maria da Silva">
            </div>

            <div class="field">
                <label class="form-label" for="discountAmount">
                    Desconto (R$)
                </label>
                <input class="form-input" type="number" id="discountAmount" name="discount_amount" min="0" step="0.01" value="0">
            </div>

            <div class="field">
                <label class="form-label" for="statusSelect">
                    Status
                </label>
                <select class="form-select" id="statusSelect" name="status">
                    <option value="pending" selected>Pendente</option>
                    <option value="complete">Concluída</option>
                    <option value="cancelled">Cancelada</option>
                </select>
            </div>

            <div class="summary-divider"></div>

            <div class="summary-row">
                <span>Itens distintos</span>
                <span id="sumDistinct">0</span>
            </div>

            <div class="summary-row">
                <span>Quantidade total</span>
                <span id="sumQty">0</span>
            </div>

            <div class="summary-row">
                <span>Subtotal</span>
                <span id="sumSubtotal">R$ 0,00</span>
            </div>

            <div class="summary-row">
                <span>Total</span>
                <span id="sumTotal">R$ 0,00</span>
            </div>

            <button type="submit" class="btn-finalize">
                Finalizar venda
            </button>
            <input type="hidden" name="items" id="saleItems">
        </div>
    </div>
    </div>
</form>
<script>
const products = <?php echo json_encode($products); ?>;
</script>
<script src="assets/js/sales/create.js"></script>