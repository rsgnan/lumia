<!-- Breadcrumb -->
 <div class="breadcrumb">
    <a href="index.php?route=brands/index">Marcas</a>
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokewidth="2.5">
        <polyline points="9 18 15 12 9 6" />
    </svg>
    <span>Adicionar Marca</span>
 </div>

 <!-- Page header -->
  <div class="page-header">
    <div>
        <h1>Adicionar Marca</h1>
        <p>Preencha os dados abaixo para cadastrar uma nova marca</p>
    </div>
    <a href="index.php?route=brands/index" class="btn btn-ghost">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="19" y1="12" x2="5" y2="12" />
            <polyline points="12 19 5 12 12 5" />
        </svg>
        Voltar
    </a>
  </div>

  <!-- Form card -->
   <div class="card">
    <div class="card-header">
        <div class="card-header-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20.50 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z" />
                <circle cx="7" cy="7" r="1.5" fill="currentColor" strone="none" />
            </svg>
        </div>
        <span class="card-title">Dados da Marca</span>
    </div>
    <div class="card-body">
        <form action="index.php?route=brands/strore" method="POST">
            <div class="form-grid">
                <div class="form-group full">
                    <label class="form-label">Nome da Marca</label>
                    <input class="form-input" type="text" name="name" placeholder="Ex: Corteco" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Categoria</label>
                    <select class="form-select" name="category">
                        <option value="">Selecione...</option>
                        <option value="Moto Peças">Motos Peças</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Website</label>
                    <input class="form-input" type="url" name="website" placeholder="http://www.corteco.com.br">
                </div>
                <div class="form-group full">
                    <label class="form-label">Descrição</label>
                    <textarea class="form-textarea" name="description" placeholder="Sobre a marca..."></textarea>
                    <span class="form-hint">Breve descrição da marca. Máximo 500 caracteres.</span>
                </div>
                <hr class="form-divider">
                <div class="upload-area" onclick="document.getElementById('logo-input').click()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4" />
                        <polyline points="17 8 12 3 7 8" />
                        <line x1="12" y1="3" x2="12" y2="15" />
                    </svg>
                    <p>Clique para enviar o logotipo da marca</p>
                    <span>PNG, JPG OU SVG - máx. 2MB
                    <input id="logo-input" type="file" name="logo" accept="image/*" style="display:none">
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    Salvar Marca
                </button>
                <a href="index.php?route=brands/index" class="btn btn-ghost">Cancelar</a>
            </div>
        </form>
    </div>
   </div>