<form method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <div class="page-header">
        <div class="page-header-left">
            <a class="btn btn-ghost btn-icon" href="?route=products/index" title="Voltar para Produtos">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <line x1="19" y1="12" x2="5" y2="12" />
                    <polyline points="12 19 5 12 12 5" />
                </svg>
            </a>
            <div>
                <h1>Editar Produto</h1>
                <p>Preencha as informações para editar o produto</p>
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
                        <input class="form-input" type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                        <input class="form-input" type="text" name="name" value="<?php echo e($_POST['name'] ?? $product->name); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Categoria</label>
                        <select class="form-select" name="category_id">
                            <option value="">Categoria do Produto</option>
                            <?php $selectedCategory = $_POST['category_id'] ?? $product->category_id; ?>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo e($category->id); ?>" <?php echo $category->id == $selectedCategory ? 'selected' : ''; ?>>
                                    <?php echo e($category->name); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tag</label>
                        <input class="form-input" type="text" name="tag" value="<?php echo e($_POST['tag'] ?? $product->tag); ?>">
                    </div>
                    <div class="form-group full">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-textarea" name="description"><?php echo e($_POST['description'] ?? $product->description); ?></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div>
                    <div class="card-title">Preço e Estoque</div>
                    <div class="card-subtitle">Valores de venda e controle de inventário</div>
                </div>
            </div>
            <div class="card-body">
                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Preço (R$)</label>
                        <input class="form-input" type="number" name="price" step="0.01" value="<?php echo e($_POST['price'] ?? $product->price); ?>">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Estoque</label>
                        <input class="form-input" type="number" name="stock" step="1" value="<?php echo e($_POST['stock'] ?? $product->stock); ?>">
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="card-title">Imagem do Produto</div>
            </div>
            <div class="card-body">
                <?php
                // Prioriza a foto temporária, caso não haja, cai para a foto já salva do produto.
                $hasPreview = !empty($tempPhoto) || !empty($product->photo);
                $previewSrc = '';

                if (!empty($tempPhoto)) {
                    $previewSrc = 'uploads/tmp/' . $tempPhoto;
                } else if (!empty($product->photo)) {
                    $previewSrc = 'uploads/products/' . $product->photo;
                }
                ?>
                <label class="image-upload" for="product-image-input">
                    <img id="image-preview" class="image-preview"
                        src="<?php echo e($previewSrc); ?>"
                        alt="Pré-visualização"
                        style="<?php echo $hasPreview ? '' : 'display:none;'; ?>">
                    <svg id="image-upload-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="<?php echo $hasPreview ? 'display:none;' : ''; ?>">
                        <path d="M4 16l4.6-4.6a2 2 0 012.8 0L16 16" />
                        <path d="M14 14l1.6-1.6a2 2 0 012.8 0L20 14" />
                        <rect x="3" y="4" width="18" height="16" rx="2" />
                        <circle cx="8.5" cy="8.5" r="1.5" />
                    </svg>
                    <div class="image-upload-text" id="image-upload-text" style="<?php echo $hasPreview ? 'display:none;' : ''; ?>">
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
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <polyline points="20 6 9 17 4 12" />
                </svg>
                Salvar Produto
            </button>
            <a class="btn btn-ghost" href="?route=products/index">Cancelar</a>
        </div>
    </div>
</form>