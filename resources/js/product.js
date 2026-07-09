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
    const cards = document.querySelectorAll('#product-grid .product-card, #product-slider .product-card');

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
    document.querySelectorAll('#product-grid .product-card, #product-slider .product-card').forEach(card => {
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
        
        const stockCount = parseInt(product.stock[size]) || 0;
        
        if (stockCount === 0) {
            btn.className = 'size-btn rounded-xl border-[1.5px] border-[#e2e2e2] bg-[#f5f5f5] px-4 py-2 text-xs font-semibold text-[#a0a0a0] cursor-not-allowed [font-family:Poppins,sans-serif]';
            btn.disabled = true;
        } else {
            btn.className = 'size-btn rounded-xl border-[1.5px] border-[#DDD0C4] bg-[#FBF7F3] px-4 py-2 text-xs font-semibold text-[#7A5A43] transition-all duration-150 hover:border-[#B08B68] hover:bg-[#F0E4D8] [font-family:Poppins,sans-serif] cursor-pointer';
            btn.onclick = () => selectSize(btn, size);
        }
        
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

    // Hapus parameter 'show' dari URL jika ada
    if (window.history.replaceState) {
        const url = new URL(window.location.href);
        if (url.searchParams.has('show')) {
            url.searchParams.delete('show');
            window.history.replaceState({}, '', url.toString());
        }
    }

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
    if (document.getElementById('cart_stok_id')) {
        document.getElementById('cart_stok_id').value = currentProduct.stok_ids[selectedSize];
    }

    // Hapus parameter 'show' dari URL agar setelah reload modal tidak otomatis terbuka kembali
    if (window.history.replaceState) {
        const url = new URL(window.location.href);
        if (url.searchParams.has('show')) {
            url.searchParams.delete('show');
            window.history.replaceState({}, '', url.toString());
        }
    }

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
    const stokId = currentProduct.stok_ids ? currentProduct.stok_ids[selectedSize] : '';
    const url = `${checkoutUrl}?name=${encodeURIComponent(currentProduct.name)}&price=${price}&qty=${currentQty}&size=${encodeURIComponent(selectedSize)}&image=${encodeURIComponent(currentProduct.image)}&stok_id=${stokId}`;

    if (window.history.replaceState) {
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.delete('show');
        currentUrl.searchParams.delete('cart_update');
        window.history.replaceState({}, '', currentUrl.toString());
    }

    window.location.href = url;
}

function showSizeError() {
    document.getElementById('sizeError').classList.remove('hidden');
}

document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname.includes('/admin')) return;
    initCardAnimations();

    // Auto-open product modal if show param is present in URL
    const urlParams = new URLSearchParams(window.location.search);
    const showProduct = urlParams.get('show');
    if (showProduct) {
        const targetName = showProduct.toLowerCase();
        const cards = document.querySelectorAll('.product-card');
        const card = Array.from(cards).find(c => c.getAttribute('data-name') === targetName);
        if (card) {
            openModalFromElement(card);
        }
    }

    const sortButton = document.getElementById('sortButton');
    const sortMenu = document.getElementById('sortMenu');
    const sortLabel = document.getElementById('sortLabel');
    const sortOptions = document.querySelectorAll('.sort-option');

    if (sortButton && sortMenu) {
        // Toggle
        const sortArrow = document.getElementById('sortArrow');
        
        const observer = new MutationObserver((mutations) => {
            mutations.forEach((mutation) => {
                if (mutation.attributeName === 'class') {
                    if (sortMenu.classList.contains('hidden')) {
                        sortArrow?.classList.remove('rotate-180');
                    } else {
                        sortArrow?.classList.add('rotate-180');
                    }
                }
            });
        });
        observer.observe(sortMenu, { attributes: true });

        // Handle option click
        sortOptions.forEach(option => {
            option.addEventListener('click', function () {
                const sortValue = this.dataset.value;
                sortLabel.innerText = this.innerText;
                
                if (!sortMenu.classList.contains('hidden')) {
                    sortButton.click();
                }

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

                if (typeof window.resetPaginationAndShowPage1 === 'function') {
                    window.resetPaginationAndShowPage1();
                } else {
                    requestAnimationFrame(() => setTimeout(initCardAnimations, 30));
                }
            });
        });

        window.addEventListener('scroll', () => {
            if (!sortMenu.classList.contains('hidden')) {
                sortButton.click();
            }
        }, { passive: true });
    }

    document.getElementById('productModal')?.addEventListener('click', function (e) {
        if (e.target === this) closeModal();
    });

    window.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeModal();
    });

    window.setupProductPagination = function() {
        if (!document.getElementById('categoryTabsProd')) return;

        const grid = document.getElementById('product-grid');
        if (!grid) return;

        const cards = Array.from(grid.querySelectorAll('.product-card'));
        const itemsPerPage = 28;
        let currentPage = 1;

        const paginationContainer = document.getElementById('pagination-container');
        if (!paginationContainer) return;

        function showPage(page) {
            currentPage = page;
            const currentCards = Array.from(grid.querySelectorAll('.product-card'));
            
            let visibleCount = 0;
            currentCards.forEach((card, index) => {
                if (currentCards.length <= itemsPerPage) {
                    card.style.display = 'flex';
                    card.dataset.index = index;
                } else {
                    const isVisible = index >= (page - 1) * itemsPerPage && index < page * itemsPerPage;
                    if (isVisible) {
                        card.style.display = 'flex';
                        card.dataset.index = visibleCount;
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                }
            });

            resetProductCards();
            requestAnimationFrame(() => setTimeout(initCardAnimations, 30));

            renderPaginationControls(currentCards.length);
        }

        function renderPaginationControls(totalItems) {
            paginationContainer.innerHTML = '';

            const totalPages = Math.ceil(totalItems / itemsPerPage);
            if (totalPages <= 1) {
                paginationContainer.classList.add('hidden');
                return;
            }
            paginationContainer.classList.remove('hidden');

            // Pagination buttons
            const prevBtn = document.createElement('button');
            prevBtn.type = 'button';
            prevBtn.className = currentPage === 1 
                ? 'flex 8 w-8 cursor-not-allowed items-center justify-center rounded-lg border border-[#f0e7dd] text-[#d8c3af]'
                : 'flex h-8 w-8 items-center justify-center rounded-lg border border-[#f0e7dd] bg-white text-[#9a8575] transition-colors hover:bg-[#fbf8f5] hover:text-[#BFA28C] cursor-pointer';
            prevBtn.innerHTML = `
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M15 18l-6-6 6-6" />
                </svg>
            `;
            if (currentPage > 1) {
                prevBtn.onclick = () => {
                    showPage(currentPage - 1);
                    window.scrollTo({ top: grid.offsetTop - 100, behavior: 'smooth' });
                };
            } else {
                prevBtn.disabled = true;
            }
            paginationContainer.appendChild(prevBtn);

            // Active Page Button (Only the current page is shown)
            const pageBtn = document.createElement('button');
            pageBtn.type = 'button';
            pageBtn.innerText = currentPage;
            pageBtn.className = 'flex h-8 w-8 items-center justify-center rounded-lg bg-[#BFA28C] text-sm font-bold text-white shadow-sm';
            paginationContainer.appendChild(pageBtn);

            // Next button
            const nextBtn = document.createElement('button');
            nextBtn.type = 'button';
            nextBtn.className = currentPage === totalPages 
                ? 'flex h-8 w-8 cursor-not-allowed items-center justify-center rounded-lg border border-[#f0e7dd] text-[#d8c3af]'
                : 'flex h-8 w-8 items-center justify-center rounded-lg border border-[#f0e7dd] bg-white text-[#9a8575] transition-colors hover:bg-[#fbf8f5] hover:text-[#BFA28C] cursor-pointer';
            nextBtn.innerHTML = `
                <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 5l6 6-6 6" />
                </svg>
            `;
            if (currentPage < totalPages) {
                nextBtn.onclick = () => {
                    showPage(currentPage + 1);
                    window.scrollTo({ top: grid.offsetTop - 100, behavior: 'smooth' });
                };
            } else {
                nextBtn.disabled = true;
            }
            paginationContainer.appendChild(nextBtn);
        }

        window.resetPaginationAndShowPage1 = () => {
            showPage(1);
        };

        showPage(1);
    }

    window.setupProductPagination();
});

if (!window.location.pathname.includes('/admin')) {
    window.openModalFromElement = openModalFromElement;
    window.openModal = openModal;
    window.closeModal = closeModal;
    window.increaseQty = increaseQty;
    window.decreaseQty = decreaseQty;
    window.addToCart = addToCart;
    window.buyNow = buyNow;

    // digunakan oleh halaman cart saat mode Ubah Ukuran
    window.setModalQty = function(qty) {
        currentQty = Math.max(1, parseInt(qty) || 1);
        document.getElementById('qtyValue').innerText = currentQty;
    };
}

window.addEventListener('pageshow', function (event) {
    if (window.location.pathname.includes('/admin')) return;
    const historyTraversal = event.persisted ||
        (typeof window.performance != 'undefined' &&
         window.performance.navigation.type === 2);
    if (historyTraversal) {
        window.location.reload();
    }
});

// Live Search (Search-as-you-type)
document.addEventListener('DOMContentLoaded', () => {
    if (window.location.pathname.includes('/admin')) return;
    const isProductPage = window.location.pathname.endsWith('/product') || window.location.pathname.includes('/product');
    const searchInputs = document.querySelectorAll('input[name="search"]');

    // Focus on input and place cursor at the end on product page load
    if (isProductPage) {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('search')) {
            searchInputs.forEach(input => {
                input.focus();
                // Put cursor at the end of text
                const val = input.value;
                input.value = '';
                input.value = val;
            });
        }
    }

    let searchDebounceTimer;

    searchInputs.forEach(input => {
        // Prevent default form submission when pressing enter
        const form = input.closest('form');
        if (form) {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
            });
        }

        input.addEventListener('input', function() {
            const val = this.value;

            // Sync other search inputs
            searchInputs.forEach(other => {
                if (other !== input) other.value = val;
            });

            const currentIsProductPage = window.location.pathname.endsWith('/product') || window.location.pathname.includes('/product');

            if (!currentIsProductPage) {
                // If not on product page, redirect to product page with search term after debounce
                clearTimeout(searchDebounceTimer);
                searchDebounceTimer = setTimeout(() => {
                    const targetUrl = new URL('/product', window.location.origin);
                    targetUrl.searchParams.set('search', val);
                    window.location.href = targetUrl.toString();
                }, 400);
                return;
            }

            // If on product page, perform AJAX search
            clearTimeout(searchDebounceTimer);
            searchDebounceTimer = setTimeout(() => {
                const url = new URL(window.location.href);
                if (val.trim() === '') {
                    url.searchParams.delete('search');
                } else {
                    url.searchParams.set('search', val);
                }

                // Update the browser URL without reloading
                window.history.replaceState({}, '', url.toString());

                fetch(url.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Replace heading container
                    const newHeading = doc.getElementById('heading-container');
                    const oldHeading = document.getElementById('heading-container');
                    if (newHeading && oldHeading) {
                        oldHeading.innerHTML = newHeading.innerHTML;
                    }

                    // Replace category tabs container
                    const newTabs = doc.getElementById('category-tabs-container');
                    const oldTabs = document.getElementById('category-tabs-container');
                    if (newTabs && oldTabs) {
                        oldTabs.innerHTML = newTabs.innerHTML;
                    }

                    // Replace product list container
                    const newGrid = doc.getElementById('product-list-container');
                    const oldGrid = document.getElementById('product-list-container');
                    if (newGrid && oldGrid) {
                        oldGrid.innerHTML = newGrid.innerHTML;
                    }

                    // Re-initialize pagination controls and scroll arrow listeners
                    if (typeof window.setupProductPagination === 'function') {
                        window.setupProductPagination();
                    }
                    if (typeof window.initCategoryTabsArrows === 'function') {
                        window.initCategoryTabsArrows();
                    }
                })
                .catch(err => console.error('Error during live search:', err));
            }, 250);
        });
    });
});