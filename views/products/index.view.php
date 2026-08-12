<!-- PRODUTOS -->
<div class="page active" id="page-produtos">
    <div class="page-header">
        <div>
            <h1>Produtos</h1>
            <p>587 produtos cadastrados</p>
        </div>
        <a href="?route=products/create" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Novo Produto
            </svg>
        </a>
    </div>
    <div class="tabs">
        <div class="tab active">Todos</div>
        <?php foreach ($categories as $category): ?>
            <div class="tab"><?php echo e($category->name); ?></div>
        <?php endforeach; ?>
    </div>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Estoque</th>
                    <th>Preço</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><strong><?php echo e($product->name); ?></strong></td>
                        <td><?php echo e($product->category_name); ?></td>
                        <td><?php echo e($product->stock); ?></td>
                        <td><?php echo e($product->price); ?></span>
                        <td>
                            <div class="actions">
                                <a href="?route=products/edit&id=<?php echo e($product->id); ?>" class="btn btn-ghost btn-sm">Editar</a>
                                <button class="btn btn-danger btn-sm">Remover</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>