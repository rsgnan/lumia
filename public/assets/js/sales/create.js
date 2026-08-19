// BUSCA POR PRODUTO
const saleItems = [];
const searchInput = document.getElementById('searchInput');
const autocompleteResults = document.getElementById('autocompleteResults');

searchInput.addEventListener('input', function () {
    const search = this.value.trim().toLowerCase();

    autocompleteResults.innerHTML = '';

    if (search === '') {
        autocompleteResults.style.display = 'none';
        return;
    }

    const results = products.filter(function (product) {
        return product.name.toLowerCase().includes(search);
    });

    if (results.length === 0) {
        autocompleteResults.innerHTML = `
            <div class="autocomplete-empty">
                Nenhum produto encontrado.
            </div>
        `;

        autocompleteResults.style.display = 'block';
        return;
    }

    results.forEach(function (product) {

        const item = document.createElement('div');

        item.className = 'autocomplete-item';
        item.addEventListener('click', function () {
            addProduct(product);
        });

        item.innerHTML = `
            <div>
                <strong>${product.name}</strong>
                <small>Estoque: ${product.stock}</small>
            </div>
            <span>R$ ${Number(product.price).toFixed(2).replace('.', ',')}</span>
            `;

        autocompleteResults.appendChild(item);
    });

    autocompleteResults.style.display = 'block';
});

// ADICIONAR PRODUTO
function addProduct(product) {
    const existingItem = saleItems.find(function (item) {
        return item.id === product.id;
    });

    if (existingItem) {
        if (existingItem.quantity < existingItem.stock) {
            existingItem.quantity++;
        }
    } else {
        saleItems.push({
            id: product.id,
            name: product.name,
            price: Number(product.price),
            stock: product.stock,
            quantity: 1
        });
    }

    renderItems();
    updateSummary();

    searchInput.value = '';
    autocompleteResults.innerHTML = '';
    autocompleteResults.style.display = 'none';
}

// RENDERIZAR PRODUTO
function renderItems() {
    const itemsBody = document.getElementById('itemsBody');

    itemsBody.innerHTML = '';

    saleItems.forEach(function (item) {
        const subtotal = item.price * item.quantity;

        const row = document.createElement('tr');

        row.innerHTML = `
            <td>${item.name}</td>
            
            <td>
                <input 
                    type="number" 
                    value="${item.quantity}" 
                    min="1" 
                    max="${item.stock}"
                    class="item-quantity"
                >
            </td>
            
            <td>
                R$ ${item.price.toFixed(2).replace('.', ',')}
            </td>
            
            <td>
                R$ ${subtotal.toFixed(2).replace('.', ',')}
            </td>
            
            <td>
                <button type="button" class="btn-remove">
                    Remover
                </button>
            </td>
            `;

        itemsBody.appendChild(row);

        const quantityInput = row.querySelector('.item-quantity');

        quantityInput.addEventListener('change', function () {
            let quantity = parseInt(this.value);

            if (isNaN(quantity) || quantity < 1) {
                quantity = 1;
            }

            if (quantity > item.stock) {
                quantity = item.stock;
            }

            item.quantity = quantity;

            renderItems();
            updateSummary();
        });

        // REMOVER PRODUTO

        const removeButton = row.querySelector('.btn-remove');

        removeButton.addEventListener('click', function () {
            const index = saleItems.findIndex(function (saleItem) {
                return saleItem.id === item.id;
            });

            if (index !== -1) {
                saleItems.splice(index, 1);
            }

            renderItems();
            updateSummary();
        });

    });
}

// RESUMO DA VENDA
function updateSummary() {
    const sumDistinct = document.getElementById('sumDistinct');
    const sumQty = document.getElementById('sumQty');
    const sumSubtotal = document.getElementById('sumSubtotal');
    const sumTotal = document.getElementById('sumTotal');
    const discountAmount = document.getElementById('discountAmount');

    let totalQuantity = 0;
    let subtotal = 0;

    saleItems.forEach(function (item) {
        totalQuantity += item.quantity;
        subtotal += item.price * item.quantity;
    });

    const discount = Number(discountAmount.value) || 0;
    const total = Math.max(0, subtotal - discount);

    sumDistinct.textContent = saleItems.length;
    sumQty.textContent = totalQuantity;
    sumSubtotal.textContent = formatMoney(subtotal);
    sumTotal.textContent = formatMoney(total);
}

// FORMATAR DINHEIRO
function formatMoney(value) {
    return 'R$ ' + value.toFixed(2).replace('.', ',');
}

// DESCONTO
const discountAmount = document.getElementById('discountAmount');

discountAmount.addEventListener('input', function () {
    updateSummary();
});