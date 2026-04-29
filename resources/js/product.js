let currentQty = 1;
let currentStock = 0;
let selectedSize = null;
let currentProduct = null;

function requireBuyerLogin() {
    const isBuyer = document.body.dataset.isBuyer === 'true';

    if (!isBuyer) {
        window.location.href = document.body.dataset.loginUrl;
        return false;
    }

    return true;
}

function initCardAnimations() {
    const cards = document.querySelectorAll('#product-grid .product-card');

    cards.forEach(card => {
        card.classList.remove('card-visible');
        card.style.animationDelay = '';
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;

            const card = entry.target;
            const idx = parseInt(card.dataset.index) || 0;

            card.style.animationDelay = `${idx * 60}ms`;
            card.classList.add('card-visible');

            observer.unobserve(card);
        });
    }, {
        threshold: 0.05
    });

    cards.forEach(card => observer.observe(card));
}

function resetProductCards() {
    document.querySelectorAll('#product-grid .product-card').forEach(card => {
        card.classList.remove('card-visible');
        card.style.animation = 'none';
        card.offsetHeight;
        card.style.animation = '';
        card.style.animationDelay = '';
    });
}

function openModalFromElement(el) {
    openModal(JSON.parse(el.dataset.product));
}

function openModal(product) {
    currentProduct = product;
    selectedSize = null;
    currentQty = 1;
    currentStock = 0;

    document.getElementById('stockWarning').classList.add('hidden');
    document.getElementById('sizeError').classList.add('hidden');

    document.getElementById('modalName').innerText = product.name;
    document.getElementById('modalCategory').innerText = product.category;
    document.getElementById('modalImage').src = product.image;
    document.getElementById('modalDesc').innerText = product.desc;
    document.getElementById('modalPrice').innerText = 'Rp' + product.price;
    document.getElementById('modalStock').innerText = 'Pilih ukuran';
    document.getElementById('qtyValue').innerText = '1';

    const sizeContainer = document.getElementById('modalSizes');
    sizeContainer.innerHTML = '';

    product.sizes.forEach(size => {
        const btn = document.createElement('button');
        btn.type = 'button';
        btn.textContent = size;
        btn.className = 'size-btn rounded-xl border-[1.5px] border-[#DDD0C4] bg-[#FBF7F3] px-4 py-2 text-xs font-semibold text-[#7A5A43] transition-all duration-150 hover:border-[#B08B68] hover:bg-[#F0E4D8] [font-family:Poppins,sans-serif]';
        btn.onclick = () => selectSize(btn, size);
        sizeContainer.appendChild(btn);
    });

    const overlay = document.getElementById('productModal');
    const panel = document.getElementById('productModalPanel');

    overlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    requestAnimationFrame(() => {
        overlay.style.opacity = '1';
        panel.style.opacity = '1';
        panel.style.transform = 'translateY(0) scale(1)';
    });
}

function closeModal() {
    const overlay = document.getElementById('productModal');
    const panel = document.getElementById('productModalPanel');

    overlay.style.opacity = '0';
    panel.style.opacity = '0';
    panel.style.transform = 'translateY(18px) scale(0.98)';

    setTimeout(() => {
        overlay.style.display = 'none';
        document.body.style.overflow = '';
    }, 260);
}

function selectSize(element, size) {
    selectedSize = size;
    document.getElementById('sizeError').classList.add('hidden');

    document.querySelectorAll('.size-btn').forEach(btn => {
        btn.classList.remove('!bg-[#8B5E3C]', '!text-white', '!border-[#8B5E3C]');
    });

    element.classList.add('!bg-[#8B5E3C]', '!text-white', '!border-[#8B5E3C]');

    currentStock = parseInt(currentProduct.stock[size]) || 0;
    currentQty = 1;

    document.getElementById('qtyValue').innerText = '1';
    document.getElementById('modalStock').innerText = `${currentStock} pcs tersedia`;
    document.getElementById('stockWarning').classList.add('hidden');
}

function increaseQty() {
    if (!selectedSize) {
        showSizeError();
        return;
    }

    if (currentQty < currentStock) {
        document.getElementById('qtyValue').innerText = ++currentQty;
        document.getElementById('stockWarning').classList.add('hidden');
    } else {
        document.getElementById('stockWarning').classList.remove('hidden');
    }
}

function decreaseQty() {
    if (currentQty > 1) {
        document.getElementById('qtyValue').innerText = --currentQty;
        document.getElementById('stockWarning').classList.add('hidden');
    }
}

function addToCart() {
    if (!requireBuyerLogin()) return;

    if (!selectedSize) {
        showSizeError();
        return;
    }

    document.getElementById('cart_name').value = currentProduct.name;
    document.getElementById('cart_category').value = currentProduct.category;
    document.getElementById('cart_image').value = currentProduct.image;
    document.getElementById('cart_price').value = String(currentProduct.price).replace(/\./g, '');
    document.getElementById('cart_size').value = selectedSize;
    document.getElementById('cart_qty').value = currentQty;
    document.getElementById('cart_stock').value = currentProduct.stock[selectedSize];

    document.getElementById('cartForm').submit();
}

function buyNow() {
    if (!requireBuyerLogin()) return;

    if (!selectedSize) {
        showSizeError();
        return;
    }

    const checkoutUrl = document.body.dataset.checkoutUrl;
    const price = String(currentProduct.price).replace(/\./g, '');
    const url = `${checkoutUrl}?name=${encodeURIComponent(currentProduct.name)}&price=${price}&qty=${currentQty}&size=${encodeURIComponent(selectedSize)}&image=${encodeURIComponent(currentProduct.image)}`;

    window.location.href = url;
}

function showSizeError() {
    document.getElementById('sizeError').classList.remove('hidden');
}

document.addEventListener('DOMContentLoaded', () => {
    initCardAnimations();

    const sortButton = document.getElementById('sortButton');
    const sortMenu = document.getElementById('sortMenu');
    const sortLabel = document.getElementById('sortLabel');
    const sortOptions = document.querySelectorAll('.sort-option');

    if (sortButton && sortMenu) {
        sortButton.addEventListener('click', (e) => {
            e.stopPropagation();
            sortMenu.classList.toggle('hidden');
            sortButton.querySelector('svg').classList.toggle('rotate-180');
        });

        sortOptions.forEach(option => {
            option.addEventListener('click', function () {
                const sortValue = this.dataset.value;
                sortLabel.innerText = this.innerText;
                sortMenu.classList.add('hidden');
                sortButton.querySelector('svg').classList.remove('rotate-180');

                const grid = document.getElementById('product-grid');
                const cards = Array.from(grid.querySelectorAll('.product-card'));

                if (sortValue === 'price-asc') {
                    cards.sort((a, b) => +a.dataset.price - +b.dataset.price);
                } else if (sortValue === 'price-desc') {
                    cards.sort((a, b) => +b.dataset.price - +a.dataset.price);
                } else {
                    cards.sort((a, b) => +a.dataset.originalIndex - +b.dataset.originalIndex);
                }

                resetProductCards();

                cards.forEach((card, i) => {
                    card.dataset.index = i;
                    grid.appendChild(card);
                });

                requestAnimationFrame(() => setTimeout(initCardAnimations, 30));
            });
        });

        document.addEventListener('click', (e) => {
            if (!sortButton.contains(e.target)) {
                sortMenu.classList.add('hidden');
                sortButton.querySelector('svg').classList.remove('rotate-180');
            }
        });
    }

    document.getElementById('productModal')?.addEventListener('click', function (e) {
        if (e.target === this) closeModal();
    });

    window.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeModal();
    });
});

window.openModalFromElement = openModalFromElement;
window.closeModal = closeModal;
window.increaseQty = increaseQty;
window.decreaseQty = decreaseQty;
window.addToCart = addToCart;
window.buyNow = buyNow;