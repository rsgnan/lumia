<form method="POST" enctype="multipart/form-data">
    <div class="page-header">
        <div class="page-header-left">
            <a class="btn btn-ghost btn-icon" href="?route=products/index" title="Voltar para Produtos">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="19" y1="12" x2="5" y2="12" />
                    <polyline points="12 19 5 12 12 5" />
                </svg>
            </a>
            <div>
                <h1>Adicionar Produto</h1>
                <p>Preencha as informações para cadastrar um novo produto no catálogo</p>
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
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Informações Gerais</div>
                    <div class="card-subtitle">Nome, marca e categoria do produto</div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group full">
                        <label class="form-label">Nome do Produto</label>
                        <input class="form-input" type="text" name="name" value="<?php if (!empty($_POST['name'])) echo e($_POST['name']); ?>" placeholder="Ex: Saia de Malha com Bolso">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Categoria</label>
                        <select class="form-select" name="category_id">
                                <option value="">Categoria do Produto</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo e($category->id); ?>"<?php if (!empty($_POST['category_id']) && $category->id == $_POST['category_id']) echo e(" selected"); ?>>
                                <?php echo e($category->name); ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tag</label>
                        <input class="form-input" type="text" name="tag" value="<?php if (!empty($_POST['tag'])) echo e($_POST['tag']); ?>" placeholder="Ex: Rendada">
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-textarea" name="description" placeholder="Descreva o produto..."><?php if (!empty($_POST['description'])) echo e($_POST['description']); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Preço e Estoque</div>
                <div class="card-subtitle">Valores de venda e controle de inventário</div>
            </div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Preço (R$)</label>
                        <input class="form-input" type="number" name="price" value="<?php if (!empty($_POST['price'])) echo e($_POST['price']); ?>" placeholder="0,00">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Estoque</label>
                        <input class="form-input" type="number" name="stock" value="<?php if (!empty($_POST['stock'])) echo e($_POST['stock']); ?>" placeholder="0">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Imagem do Produto</div>
            </div>
            <div class="card-body">
                <label class="image-upload" for="product-image-input">
                    <img id="image-preview" 
                        src="<?php echo !empty($tempPhoto) ? 'uploads/tmp/' . e($tempPhoto) : ''; ?>"
                        alt="Pré-visualização"
                        style="<?php echo !empty($tempPhoto) ? '' : 'display:none;'; ?>">
                    <svg id="image-upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="<?php echo !empty($tempPhoto) ? 'display:none;' : ''; ?>">
                        <path d="M4 16l4.6-4.6a2 2 0 012.8 0L16 16" />
                        <path d="M14 14l1.6-1.6a2 2 0 012.8 0L20 14" />
                        <rect x="3" y="4" width="18" height="16" rx="2" />
                        <circle cx="8.5" cy="8.5" r="1.5" />
                    </svg>
                    <div class="image-upload-text" id="image-upload-text" style="<?php echo !empty($tempPhoto) ? 'display:none;' : ''; ?>">
                        <div class="image-upload-title">Clique para enviar uma imagem</div>
                        <div class="image-upload-hint">PNG ou JPG, até 5MB</div>
                    </div>
                    <input id="product-image-input" type="file" name="photo" accept="image/*" style="display:none">
                </label>
                <input type="hidden" name="temp_photo" value="<?php echo !empty($tempPhoto) ? e($tempPhoto) : ''; ?>">
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strole-width="2.5">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                Salvar Produto
            </button>
            <a class="btn btn-ghost" href="?route=products/index">Cancelar</a>
        </div>
    </div>
</form>