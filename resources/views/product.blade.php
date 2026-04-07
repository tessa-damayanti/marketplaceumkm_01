<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Velora</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f7f2eb] min-h-screen">

    <section class="max-w-7xl mx-auto px-6 py-10">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-[#5c4432]">Produk Velora</h1>
            <p class="mt-3 text-[#8b6f58]">Pilih kategori, lalu klik produk untuk melihat detail lengkap.</p>
        </div>

        <!-- Kategori -->
        <div class="flex flex-wrap justify-center gap-4 mb-10">
            <button onclick="showCategory('kemeja')" id="btn-kemeja"
                class="category-btn bg-[#a78d78] text-white px-6 py-3 rounded-full font-semibold shadow">
                Kemeja
            </button>
            <button onclick="showCategory('gaun')" id="btn-gaun"
                class="category-btn bg-white text-[#7a5a43] px-6 py-3 rounded-full font-semibold shadow">
                Gaun
            </button>
            <button onclick="showCategory('cardigan')" id="btn-cardigan"
                class="category-btn bg-white text-[#7a5a43] px-6 py-3 rounded-full font-semibold shadow">
                Cardigan
            </button>
            <button onclick="showCategory('rok')" id="btn-rok"
                class="category-btn bg-white text-[#7a5a43] px-6 py-3 rounded-full font-semibold shadow">
                Rok
            </button>
        </div>

        <!-- Grid Produk -->
        <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8"></div>
    </section>

    <!-- Modal Detail Produk -->
    <div id="productModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50 px-4">
        <div class="bg-white rounded-3xl max-w-5xl w-full overflow-hidden shadow-2xl relative">
            <button onclick="closeModal()" class="absolute top-4 right-5 text-3xl text-gray-500 hover:text-black z-10">
                &times;
            </button>

            <div class="grid md:grid-cols-2">
                <div class="bg-[#f4ede5] p-6 flex items-center justify-center">
                    <img id="modalImage" src="" alt="Produk" class="w-full max-h-[500px] object-cover rounded-2xl">
                </div>

                <div class="p-8">
                    <p id="modalCategory" class="text-xs font-semibold tracking-[3px] text-[#b08b68] uppercase mb-2"></p>
                    <h2 id="modalName" class="text-3xl font-bold text-[#5c4432] mb-3"></h2>
                    <p id="modalPrice" class="text-3xl font-bold text-[#7a5a43] mb-5"></p>

                    <div class="mb-5">
                        <h3 class="font-semibold text-[#5c4432] mb-2">Deskripsi Produk</h3>
                        <p id="modalDesc" class="text-[#7b6858] leading-7"></p>
                    </div>

                    <div class="mb-5">
                        <h3 class="font-semibold text-[#5c4432] mb-2">Size</h3>
                        <div id="modalSizes" class="flex flex-wrap gap-3"></div>
                    </div>

                    <div class="mb-5">
                        <h3 class="font-semibold text-[#5c4432] mb-2">Stok</h3>
                        <p id="modalStock" class="text-[#7b6858]"></p>
                    </div>

                    <div class="mb-6">
                        <h3 class="font-semibold text-[#5c4432] mb-2">Jumlah</h3>
                        <div class="flex items-center gap-3">
                            <button onclick="decreaseQty()" class="w-11 h-11 rounded-xl bg-[#e9ddd0] text-xl font-bold text-[#5c4432] hover:bg-[#dccab5]">-</button>
                            <span id="qtyValue" class="text-xl font-semibold text-[#5c4432] w-10 text-center">1</span>
                            <button onclick="increaseQty()" class="w-11 h-11 rounded-xl bg-[#e9ddd0] text-xl font-bold text-[#5c4432] hover:bg-[#dccab5]">+</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <button onclick="addToCart()"
                            class="bg-[#a78d78] hover:bg-[#8f7561] text-white py-3 rounded-2xl font-semibold transition">
                            Tambah ke Keranjang
                        </button>
                        <button onclick="buyNow()"
                            class="bg-[#5c4432] hover:bg-[#4b3728] text-white py-3 rounded-2xl font-semibold transition">
                            Beli Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const products = {
            kemeja: [
                {
                    name: 'Kemeja Stripe',
                    category: 'Kemeja',
                    image: 'https://i.pinimg.com/1200x/b1/cc/2f/b1cc2fb9a73cb56f46e167b47d4febbf.jpg',
                    desc: 'Kemeja wanita bermotif garis dengan desain rapi dan sederhana. Terbuat dari bahan katun ringan yang nyaman dipakai untuk aktivitas sehari-hari seperti kuliah maupun bekerja.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 10,
                    price: '100.000'
                },
                {
                    name: 'Kemeja Putih Basic',
                    category: 'Kemeja',
                    image: 'https://i.pinimg.com/1200x/5e/a1/60/5ea160d8d804b678e9f839e1021c89fc.jpg',
                    desc: 'Kemeja polos dengan desain minimalis dan tampilan elegan. Menggunakan bahan katun halus yang nyaman dan mudah dipadukan untuk kegiatan formal maupun semi formal.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 14,
                    price: '110.000'
                },
                {
                    name: 'Kemeja Linen Pita',
                    category: 'Kemeja',
                    image: 'https://i.pinimg.com/1200x/fa/37/44/fa3744102139679f39713c145c3d22f1.jpg',
                    desc: 'Kemeja berbahan linen ringan dengan desain feminin dan detail pita di bagian leher. Nyaman digunakan untuk tampilan santai yang tetap rapi dan elegan.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 9,
                    price: '145.000'
                },
                {
                    name: 'Kemeja Slim Fit',
                    category: 'Kemeja',
                    image: 'https://i.pinimg.com/736x/b3/3f/b9/b33fb97104fe57a9b2c093f6e0b857ec.jpg',
                    desc: 'Kemeja dengan potongan modern yang mengikuti bentuk tubuh. Menggunakan bahan katun stretch yang nyaman dan cocok untuk tampilan formal maupun semi formal.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 7,
                    price: '152.000'
                }
            ],
            gaun: [
                {
                    name: 'Gaun Biru Wrap',
                    category: 'Gaun',
                    image: 'https://i.pinimg.com/736x/99/55/47/9955473e19a196b4eaa1533b10922b6a.jpg',
                    desc: 'Dress midi wanita dengan model wrap dan pita di pinggang yang memberikan kesan ramping dan elegan. Terbuat dari bahan katun ringan dan nyaman.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 8,
                    price: '170.000'
                },
                {
                    name: 'Gaun Ivory',
                    category: 'Gaun',
                    image: 'https://i.pinimg.com/1200x/11/59/c1/1159c13c68d7581c8253d1fdb5b77e99.jpg',
                    desc: 'Dress wanita dengan desain polos dan kancing depan yang memberikan tampilan rapi dan bersih. Menggunakan bahan katun halus yang nyaman untuk aktivitas sehari-hari.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 5,
                    price: '185.000'
                },
                {
                    name: 'Gaun Floral',
                    category: 'Gaun',
                    image: 'https://img.fantaskycdn.com/6bdf5a35272dcc4348d5b0a5594b3d78_1024x.jpeg',
                    desc: 'Dress midi wanita dengan motif floral yang memberikan tampilan feminin dan segar. Menggunakan bahan chiffon ringan yang nyaman dipakai untuk aktivitas santai.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 11,
                    price: '155.000'
                },
                {
                    name: 'Gaun Midi Biru',
                    category: 'Gaun',
                    image: 'https://i.pinimg.com/1200x/b7/71/41/b7714197aa110db547613c08e9bf5edb.jpg',
                    desc: 'Dress wanita dengan desain minimalis ala Korean style yang memberikan tampilan manis dan rapi. Terbuat dari bahan katun ringan yang nyaman digunakan sehari-hari.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 8,
                    price: '147.000'
                }
            ],
            cardigan: [
                {
                    name: 'Cardigan Knit Cream',
                    category: 'Cardigan',
                    image: 'https://i.pinimg.com/1200x/06/d9/af/06d9af1a9fa1a2e6f85bda67ddc5b30c.jpg',
                    desc: 'Cardigan rajut warna cream dengan detail tali di bagian depan yang memberikan tampilan simpel dan manis. Terbuat dari bahan knit lembut dan hangat.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 8,
                    price: '90.000'
                },
                {
                    name: 'Cardigan Rajut Pink',
                    category: 'Cardigan',
                    image: 'https://i.pinimg.com/1200x/46/91/61/4691615a5685cfc9785a8dc6ce04a0e5.jpg',
                    desc: 'Cardigan rajut dengan tekstur cable knit yang lembut dan warna pink yang feminin. Menggunakan bahan rajut hangat yang nyaman untuk tampilan kasual sehari-hari.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 10,
                    price: '112.000'
                },
                {
                    name: 'Cardigan Pita Biru',
                    category: 'Cardigan',
                    image: 'https://i.pinimg.com/736x/f1/a3/c8/f1a3c8625b037c52d0afa86c65c54715.jpg',
                    desc: 'Cardigan dengan detail renda dan pita yang memberikan tampilan feminin dan elegan. Terbuat dari bahan knit ringan yang nyaman digunakan untuk aktivitas santai.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 12,
                    price: '95.000'
                },
                {
                    name: 'Cardigan Floral',
                    category: 'Cardigan',
                    image: 'https://i.pinimg.com/1200x/11/d7/51/11d751ea4f28b895cca8f7acdb0ffcc7.jpg',
                    desc: 'Cardigan bermotif floral dengan desain ringan dan tampilan feminin. Menggunakan bahan knit halus dan memberikan tampilan santai yang tetap menarik dan feminin.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 9,
                    price: '118.000'
                }
            ],
            rok: [
                {
                    name: 'Rok Midi A-line',
                    category: 'Rok',
                    image: 'https://i.pinimg.com/736x/9e/af/46/9eaf465a3d23d2c7ca0faa9f232ad980.jpg',
                    desc: 'Rok midi dengan potongan A-line yang sederhana dan rapi. Terbuat dari bahan katun ringan yang nyaman digunakan untuk aktivitas sehari-hari.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 12,
                    price: '100.000'
                },
                {
                    name: 'Rok Ruffle Layer Pink',
                    category: 'Rok',
                    image: 'https://i.pinimg.com/1200x/51/77/97/517797ca83ffd194e823cf35b7cf861c.jpg',
                    desc: 'Rok bertingkat dengan detail ruffle yang memberikan tampilan feminin dan menarik. Menggunakan bahan chiffon ringan yang nyaman.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 7,
                    price: '120.000'
                },
                {
                    name: 'Rok Pita Biru',
                    category: 'Rok',
                    image: 'https://i.pinimg.com/736x/ff/b9/06/ffb9065c829ab35740b27c4f962300bf.jpg',
                    desc: 'Rok panjang dengan detail pita kecil yang memberikan tampilan manis dan feminin dan terbuat dari bahan katun ringan yang nyaman.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 9,
                    price: '115.000'
                },
                {
                    name: 'Rok Denim',
                    category: 'Rok',
                    image: 'https://i.pinimg.com/736x/1a/66/22/1a66221e9292bb9a8c2e7d4fd618db5d.jpg',
                    desc: 'Rok berbahan denim dengan model wrap dan detail kancing di bagian depan. Memberikan tampilan kasual yang tetap rapi dan nyaman.',
                    sizes: ['S', 'M', 'L', 'XL'],
                    stock: 6,
                    price: '132.000'
                }
            ]
        };

        let currentQty = 1;
        let currentStock = 1;
        let selectedSize = null;
        let currentProduct = null;

        function renderProducts(category) {
            const grid = document.getElementById('product-grid');
            const categoryProducts = products[category];

            grid.innerHTML = '';

            categoryProducts.forEach(product => {
                grid.innerHTML += `
                    <div class="bg-white rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition duration-300">
                        <img src="${product.image}" alt="${product.name}" class="w-full h-80 object-cover">
                        <div class="p-5">
                            <p class="text-xs font-semibold tracking-[3px] text-[#b08b68] uppercase mb-2">${product.category}</p>
                            <h2 class="text-2xl font-semibold text-[#5c4432] mb-2">${product.name}</h2>
                            <p class="text-[#7b6858] text-sm leading-7 mb-4">${product.desc}</p>
                            <p class="text-3xl font-bold text-[#7a5a43] mb-4">Rp${product.price}</p>
                            <button
                                onclick='openModal(${JSON.stringify(product)})'
                                class="w-full bg-[#a78d78] hover:bg-[#8f7561] text-white font-medium py-3 rounded-xl transition">
                                Lihat Detail
                            </button>
                        </div>
                    </div>
                `;
            });

            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.classList.remove('bg-[#a78d78]', 'text-white');
                btn.classList.add('bg-white', 'text-[#7a5a43]');
            });

            const activeBtn = document.getElementById(`btn-${category}`);
            activeBtn.classList.remove('bg-white', 'text-[#7a5a43]');
            activeBtn.classList.add('bg-[#a78d78]', 'text-white');
        }

        function openModal(product) {
            currentProduct = product;
            document.getElementById('modalName').innerText = product.name;
            document.getElementById('modalCategory').innerText = product.category;
            document.getElementById('modalImage').src = product.image;
            document.getElementById('modalDesc').innerText = product.desc;
            document.getElementById('modalPrice').innerText = 'Rp' + product.price;
            document.getElementById('modalStock').innerText = product.stock + ' pcs tersedia';

            const sizesContainer = document.getElementById('modalSizes');
            sizesContainer.innerHTML = '';

            selectedSize = null;

            product.sizes.forEach(size => {
                sizesContainer.innerHTML += `
                    <button 
                        type="button"
                        onclick="selectSize(this, '${size}')"
                        class="size-btn px-5 py-3 border border-[#d8c3af] rounded-2xl text-[#6d5644] bg-[#fbf7f2] text-2xl transition hover:bg-[#efe3d5] hover:border-[#b08b68]">
                        ${size}
                    </button>
                `;
            });

            currentQty = 1;
            currentStock = parseInt(product.stock);
            document.getElementById('qtyValue').innerText = currentQty;

            const modal = document.getElementById('productModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function selectSize(element, size) {
            selectedSize = size;

            document.querySelectorAll('.size-btn').forEach(btn => {
                btn.classList.remove(
                    'bg-[#a78d78]',
                    'text-white',
                    'border-[#a78d78]'
                );
                btn.classList.add(
                    'bg-[#fbf7f2]',
                    'text-[#6d5644]',
                    'border-[#d8c3af]'
                );
            });

            element.classList.remove(
                'bg-[#fbf7f2]',
                'text-[#6d5644]',
                'border-[#d8c3af]'
            );
            element.classList.add(
                'bg-[#a78d78]',
                'text-white',
                'border-[#a78d78]'
            );
        }

        function closeModal() {
            const modal = document.getElementById('productModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function increaseQty() {
            if (currentQty < currentStock) {
                currentQty++;
                document.getElementById('qtyValue').innerText = currentQty;
            }
        }

        function decreaseQty() {
            if (currentQty > 1) {
                currentQty--;
                document.getElementById('qtyValue').innerText = currentQty;
            }
        }

        function addToCart() {
            if (!selectedSize) {
                alert('Silakan pilih size terlebih dahulu.');
                return;
            }

            alert(
                `Produk "${currentProduct.name}" berhasil ditambahkan ke keranjang.\nSize: ${selectedSize}\nJumlah: ${currentQty}`
            );
        }

        function buyNow() {
            if (!selectedSize) {
                alert('Silakan pilih size terlebih dahulu.');
                return;
            }

            alert(
                `Anda memilih beli sekarang.\nProduk: ${currentProduct.name}\nSize: ${selectedSize}\nJumlah: ${currentQty}`
            );
        }

        function showCategory(category) {
            renderProducts(category);
        }

        // default tampil kemeja
        renderProducts('kemeja');
    </script>

</body>

</html>