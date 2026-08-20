<!-- VENDAS -->
<div class="page active" id="page-vendas">
    <div class="page-header">
        <div>
            <h1>Vendas</h1>
            <p><?php echo e(count($sales)); ?> vendas registradas</p>
        </div>
        <a href="?route=sales/create" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Novo Venda
            </svg>
        </a>
    </div>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Clientee</th>
                    <th>Itens</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($sales)): ?>
                    <tr>
                        <td coldspan="7" style="text-align:center; color:var(--muted); padding:40px 18px; ">
                            Nenhuma venda registrada ainda
                    </tr>
                <?php endif; ?>
                <?php foreach ($sales as $sale): ?>
                    <tr>
                        <td><strong><?php echo e($sale->customer_name); ?></strong></td>
                        <td><?php echo e($sale->items_quantity); ?> <?php echo $sale->items_quantity == 1 ? 'item' : 'itens'; ?></td>
                        <td><strong>R$ <?php echo e(number_format((float) $sale->total_amount, 2, ',', '.')); ?></strong></td>
                        <td>
                            <?php if ($sale->status === 'pending'): ?>
                                <span class="badge yellow">Pendente</span>
                            <?php elseif ($sale->status === 'completed'): ?>
                                <span class="badge green">Concluída</span>
                            <?php else: ?>
                                <span class="badge red">Cancelada</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo e(date('d/m/Y H:i', strtotime($sale->created_at))); ?></td>
                        <td>
                            <div class="actions">
                                <a href="?route=sales/edit&id=<?php echo e($sale->id); ?>" class="btn btn-ghost btn-sm">Editar</a>
                                <?php if ($sale->status === 'pending'): ?>
                                    <form method="POST" action="index.php?route=sales/cancel&id=<?php echo e($sale->id); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-danger">
                                            Cancelar
                                        </button>
                                    </form>
                                <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>