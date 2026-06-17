<div class="page active" id="page-marcas">
    <div class="page-header">
        <div>
            <h1>Marcas</h1>
            <p>42 marcas cadastradas</p>
        </div>
        <button class="btn btn-primary" onclick="openModal('modal-marca')">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            Nova Marca
        </button>
    </div>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Foto</th>
                    <th>Produtos</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($brands as $brand): ?>
                <tr>
                    <td><strong><?php echo e($brand->id); ?></strong></td>
                    <td><?php echo e($brand->name); ?></td>
                    <td><?php if(!empty($brand->photo)) echo e($brand->photo); ?></td>
                    <td>84</td>
                    <td>
                        <div class="actions">
                            <button class="btn btn-ghost btn-sm">Editar</button>
                            <button class="btn btn-danger btn-sm">Remover</button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>