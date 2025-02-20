document.addEventListener("DOMContentLoaded", function () {
    // Get CSRF token and common elements
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const cartModal = document.getElementById("static-modal");
    const clearCartButton = document.getElementById("clear-cart-button");
    const checkoutButton = document.getElementById("checkout-button");

    // Initialize cart functionality
    initializeCart();

    // Setup modal event listener if modal exists
    if (cartModal) {
        const modalToggle = document.querySelector(
            '[data-modal-toggle="static-modal"]'
        );
        modalToggle.addEventListener("click", loadCartContents);
    }

    function initializeCart() {
        fetch("/cart/count")
            .then((response) => response.json())
            .then((data) => {
                updateCartCount(data.count);
                if (data.items && data.items.length > 0) {
                    data.items.forEach((item) => {
                        showQuantityControls(item.obat_id, item.quantity);
                    });
                }
            });

        setupEventListeners();
    }

    function setupEventListeners() {
        document
            .querySelectorAll('[id^="tambah-keranjang-"]')
            .forEach((button) =>
                button.addEventListener("click", handleAddToCart)
            );

        document.querySelectorAll('[id^="tambah-"]').forEach((button) => {
            if (!button.id.includes("keranjang")) {
                button.addEventListener("click", handleIncreaseQuantity);
            }
        });

        document
            .querySelectorAll('[id^="kurangi-"]')
            .forEach((button) =>
                button.addEventListener("click", handleDecreaseQuantity)
            );

        document.querySelectorAll('[id^="quantity-"]').forEach((input) => {
            input.addEventListener("input", handleManualQuantityChange);
            input.addEventListener("blur", handleManualQuantityChange);
            input.removeAttribute("readonly");
        });

        if (clearCartButton) {
            clearCartButton.addEventListener("click", handleClearCart);
        }
        if (checkoutButton) {
            checkoutButton.addEventListener("click", handleCheckout);
        }
    }

    // Cart Item Management Functions
    async function handleAddToCart(event) {
        const button = event.currentTarget;
        const obatId = button.dataset.id;
        const stockLimit = parseInt(button.dataset.stock) || 1;

        try {
            const response = await fetch("/cart/add", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({ obat_id: obatId }),
            });

            const data = await response.json();

            if (data.success) {
                if (data.quantity > stockLimit) {
                    showPopup("Jumlah melebihi stok yang tersedia!", "error");
                    return;
                }

                showQuantityControls(obatId, data.quantity || 1);
                showPopup("Berhasil menambahkan ke keranjang!", "success");
                updateCartCount(data.cartCount);
            } else {
                showPopup(
                    data.message || "Gagal menambahkan ke keranjang!",
                    "error"
                );
            }
        } catch (error) {
            console.error("Error adding to cart:", error);
            showPopup(
                "Terjadi kesalahan saat menambahkan ke keranjang!",
                "error"
            );
        }
    }

    function showPopup(message, type = "success") {
        const popup = document.getElementById("cart-popup");

        // Set warna berdasarkan tipe
        popup.classList.remove("bg-green-500", "bg-red-500");
        popup.classList.add(type === "success" ? "bg-green-500" : "bg-red-500");

        // Tampilkan pesan
        popup.textContent = message;
        popup.classList.remove("hidden", "opacity-0");
        popup.classList.add("opacity-100");

        // Hilangkan setelah 3 detik
        setTimeout(() => {
            popup.classList.remove("opacity-100");
            popup.classList.add("opacity-0");
            setTimeout(() => popup.classList.add("hidden"), 300);
        }, 3000);
    }

    async function handleManualQuantityChange(event) {
        const input = event.target;
        const obatId = input.id.replace("quantity-", "");
        const stockLimit = parseInt(input.getAttribute("max")) || 0;
        let newQuantity = parseInt(input.value);

        // Validate input
        if (isNaN(newQuantity) || newQuantity < 1) {
            newQuantity = 1;
            input.value = newQuantity;
            showCartPopup("Jumlah minimal 1 unit");
        } else if (newQuantity > stockLimit) {
            newQuantity = stockLimit;
            input.value = newQuantity;
            showCartPopup(`Maksimal pembelian ${stockLimit} unit`);
        }

        // Only update if the value has actually changed
        if (newQuantity !== parseInt(input.defaultValue)) {
            await updateCartQuantity(obatId, newQuantity);
            input.defaultValue = newQuantity.toString();
        }
    }

    async function handleIncreaseQuantity(event) {
        const button = event.currentTarget;
        const obatId = button.id.replace("tambah-", "");
        const quantityInput = document.querySelector(`#quantity-${obatId}`);
        const stockLimit = parseInt(quantityInput.getAttribute("max")) || 0;
        const currentQuantity = parseInt(quantityInput.value);

        if (currentQuantity >= stockLimit) {
            showCartPopup(`Maksimal pembelian ${stockLimit} unit`);
            return;
        }

        const newQuantity = currentQuantity + 1;
        await updateCartQuantity(obatId, newQuantity);
    }

    async function handleDecreaseQuantity(event) {
        const button = event.currentTarget;
        const obatId = button.id.replace("kurangi-", "");
        const quantityInput = document.querySelector(`#quantity-${obatId}`);
        const currentQuantity = parseInt(quantityInput.value);

        if (currentQuantity <= 1) {
            await removeFromCart(obatId);
            hideQuantityControls(obatId);
            return;
        }

        const newQuantity = currentQuantity - 1;
        await updateCartQuantity(obatId, newQuantity);
    }

    async function updateCartQuantity(obatId, quantity) {
        try {
            const response = await fetch("/cart/update", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({ obat_id: obatId, quantity: quantity }),
            });

            const data = await response.json();

            if (data.success) {
                const quantityInput = document.querySelector(
                    `#quantity-${obatId}`
                );
                quantityInput.value = quantity;
                quantityInput.defaultValue = quantity.toString();
                updateCartCount(data.cartCount);

                if (
                    data.totalPrice !== undefined &&
                    document.querySelector("#total-price")
                ) {
                    document.querySelector("#total-price").textContent =
                        formatCurrency(data.totalPrice);
                }

                // Refresh cart contents if in cart page
                if (window.location.pathname.includes("/cart")) {
                    loadCartContents();
                }
            }
        } catch (error) {
            console.error("Error updating cart:", error);
            showCartPopup("Gagal mengubah jumlah");
        }
    }

    async function removeFromCart(obatId) {
        try {
            const response = await fetch("/cart/remove", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({ obat_id: obatId }),
            });

            const data = await response.json();

            if (data.success) {
                hideQuantityControls(obatId);
                updateCartCount(data.cartCount);

                // Update total harga jika ada
                if (data.totalPrice !== undefined) {
                    const totalPriceElement =
                        document.querySelector("#total-price");
                    if (totalPriceElement) {
                        totalPriceElement.textContent = formatCurrency(
                            data.totalPrice
                        );
                    }
                }

                // Jika di halaman /cart dan keranjang kosong, reload halaman
                if (
                    window.location.pathname.includes("/cart") &&
                    data.cartCount === 0
                ) {
                    window.location.reload();
                }

                showPopup("Item berhasil dihapus!", "success");
            } else {
                showPopup("Gagal menghapus item!", "error");
            }
        } catch (error) {
            console.error("Error removing from cart:", error);
            showPopup("Terjadi kesalahan saat menghapus item!", "error");
        }
    }

    function showPopup(message, type = "success") {
        const popup = document.getElementById("cart-popup");

        // Set warna berdasarkan tipe
        if (type === "success") {
            popup.classList.add("bg-green-500");
            popup.classList.remove("bg-red-500");
        } else {
            popup.classList.add("bg-red-500");
            popup.classList.remove("bg-green-500");
        }

        // Tampilkan pesan
        popup.textContent = message;
        popup.classList.remove("hidden", "opacity-0");
        popup.classList.add("opacity-100");

        // Hilangkan setelah 3 detik
        setTimeout(() => {
            popup.classList.remove("opacity-100");
            popup.classList.add("opacity-0");
            setTimeout(() => popup.classList.add("hidden"), 300);
        }, 3000);
    }

    // Modal Functions
    async function loadCartContents() {
        const modalBody = cartModal.querySelector(".p-4.md\\:p-5.space-y-4");
        const cartTotal = document.getElementById("cart-total");

        // Placeholder loading UI agar lebih smooth
        modalBody.innerHTML = `
            <div class="text-center text-gray-500 animate-pulse">
                <p>Loading cart contents...</p>
            </div>
        `;

        const controller = new AbortController();
        const timeout = setTimeout(() => controller.abort(), 5000); // Timeout fetch setelah 5 detik

        try {
            const response = await Promise.race([
                fetch("/cart/contents", { signal: controller.signal }),
                new Promise((_, reject) =>
                    setTimeout(
                        () => reject(new Error("Timeout fetching cart")),
                        5000
                    )
                ),
            ]);
            clearTimeout(timeout);

            const data = await response.json();

            if (!data.items || Object.keys(data.items).length === 0) {
                modalBody.innerHTML = `
                    <div class="text-center text-gray-500">
                        <p>Keranjang belanja Anda kosong</p>
                    </div>
                `;
                cartTotal.textContent = "Rp0";
                return;
            }

            modalBody.innerHTML = generateCartHTML(data.items);
            cartTotal.textContent = `Rp${formatNumber(data.totalPrice)}`;

            // Tambahkan event listener dengan requestIdleCallback (lebih efisien)
            requestIdleCallback(() => setupModalEventListeners(modalBody));
        } catch (error) {
            console.error("Error loading cart contents:", error);
            modalBody.innerHTML = `
                <div class="text-center text-red-500">
                    <p>Error loading cart. Please try again.</p>
                </div>
            `;
        }
    }

    function generateCartHTML(items) {
        let cartHtml = '<div class="space-y-4">';
        for (const [id, item] of Object.entries(items)) {
            cartHtml += `
                <div class="flex items-center space-x-4 py-3 border-b">
                     <img src="/storage/${
                         item.image
                     }" width="150px" height="150px" class="object-cover rounded" alt="${
                item.name
            }">
                    <div class="flex-1">
                        <h3 class="font-medium">${item.name}</h3>
                        <p class="text-gray-600">Rp${formatNumber(
                            item.price
                        )}</p>
                        <div class="flex items-center space-x-2 mt-2">
                            <button class="cart-decrease px-2 py-1 bg-gray-200 rounded" data-id="${id}">-</button>
                                <input type="number" value="${item.quantity}" 
                                    class="w-16 text-center border rounded" 
                                    id="modal-quantity-${id}"
                                    data-stock="${item.stock}"
                                    min="1"
                                    max="${item.stock}">
                            <button class="cart-increase px-2 py-1 bg-gray-200 rounded" data-id="${id}">+</button>
                        </div>
                    </div>
                    <button  class="cart-remove text-red-500 rounded-full text-2xl font-bold" data-id="${id}">×</button>
                </div>
            `;
        }
        return cartHtml + "</div>";
    }

    function setupModalEventListeners(modalBody) {
        modalBody.querySelectorAll(".cart-decrease").forEach((btn) => {
            btn.addEventListener("click", handleModalDecreaseQuantity);
        });

        modalBody.querySelectorAll(".cart-increase").forEach((btn) => {
            btn.addEventListener("click", handleModalIncreaseQuantity);
        });

        modalBody.querySelectorAll(".cart-remove").forEach((btn) => {
            btn.addEventListener("click", handleModalRemoveItem);
        });

        modalBody.querySelectorAll("input[type=number]").forEach((input) => {
            input.addEventListener("change", handleModalQuantityChange);
        });
    }

    async function handleModalIncreaseQuantity(e) {
        const id = e.currentTarget.dataset.id;
        const quantityInput = document.getElementById(`modal-quantity-${id}`);
        const stockLimit = parseInt(quantityInput.dataset.stock);
        const currentQuantity = parseInt(quantityInput.value);

        if (currentQuantity >= stockLimit) {
            showCartPopup(`Maksimal pembelian ${stockLimit} unit`);
            return;
        }

        const newQuantity = currentQuantity + 1;
        await updateCartQuantity(id, newQuantity);
        loadCartContents();
    }

    async function handleModalDecreaseQuantity(e) {
        const id = e.currentTarget.dataset.id;
        const quantityInput = document.getElementById(`modal-quantity-${id}`);
        const newQuantity = parseInt(quantityInput.value) - 1;

        if (newQuantity > 0) {
            await updateCartQuantity(id, newQuantity);
        } else {
            await removeFromCart(id);
        }
        loadCartContents();
    }

    async function handleModalRemoveItem(e) {
        const id = e.currentTarget.dataset.id;
        await removeFromCart(id);
        loadCartContents();
    }

    async function handleModalQuantityChange(e) {
        const input = e.target;
        const id = input.id.replace("modal-quantity-", "");
        const stockLimit = parseInt(input.dataset.stock);
        let newQuantity = parseInt(input.value);

        if (isNaN(newQuantity) || newQuantity < 1) {
            newQuantity = 1;
            showCartPopup("Jumlah minimal 1 unit");
        } else if (newQuantity > stockLimit) {
            newQuantity = stockLimit;
            showCartPopup(`Maksimal pembelian ${stockLimit} unit`);
        }

        input.value = newQuantity;
        await updateCartQuantity(id, newQuantity);
        loadCartContents();
    }

    // Cart Management Functions
    async function handleClearCart() {
        try {
            const response = await fetch("/cart/clear", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
            });

            const data = await response.json();

            if (data.success) {
                // Sembunyikan semua kontrol jumlah di katalog
                document
                    .querySelectorAll('[id^="quantity-controls-"]')
                    .forEach((control) => {
                        const obatId = control.id.replace(
                            "quantity-controls-",
                            ""
                        );
                        hideQuantityControls(obatId);
                    });

                // Update jumlah keranjang jadi 0 & reload isi keranjang
                updateCartCount(0);
                loadCartContents();

                showPopup("Keranjang berhasil dikosongkan!", "success");
            } else {
                showPopup(
                    data.message || "Gagal mengosongkan keranjang!",
                    "error"
                );
            }
        } catch (error) {
            console.error("Error clearing cart:", error);
            showPopup(
                "Terjadi kesalahan saat mengosongkan keranjang!",
                "error"
            );
        }
    }

    function showPopup(message, type = "success") {
        const popup = document.getElementById("cart-popup");

        // Set warna berdasarkan tipe
        popup.classList.remove("bg-green-500", "bg-red-500");
        popup.classList.add(type === "success" ? "bg-green-500" : "bg-red-500");

        // Tampilkan pesan
        popup.textContent = message;
        popup.classList.remove("hidden", "opacity-0");
        popup.classList.add("opacity-100");

        // Hilangkan setelah 3 detik
        setTimeout(() => {
            popup.classList.remove("opacity-100");
            popup.classList.add("opacity-0");
            setTimeout(() => popup.classList.add("hidden"), 300);
        }, 3000);
    }

    async function handleCheckout() {
        try {
            // Cek apakah ini di halaman checkout atau di modal keranjang
            const isCheckoutPage =
                window.location.pathname.includes("/checkout");

            if (isCheckoutPage) {
                // Di halaman checkout, ambil data form
                const pharmacyId = document.querySelector(
                    '[name="pharmacy_id"]'
                )?.value;
                const paymentMethod = document.querySelector(
                    '[name="payment_method"]:checked'
                )?.value;
                const notes = document.querySelector('[name="notes"]')?.value;

                if (!pharmacyId || !paymentMethod) {
                    showPopup("Mohon lengkapi data checkout!", "error");
                    return;
                }

                const response = await fetch("/checkout/process", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({
                        pharmacy_id: pharmacyId,
                        payment_method: paymentMethod,
                        notes: notes,
                    }),
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || "Checkout failed");
                }

                if (data.success && data.redirect) {
                    showPopup("Checkout berhasil! Mengarahkan...", "success");
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 2000);
                }
            } else {
                // Di modal keranjang, redirect ke halaman checkout
                const response = await fetch("/checkout", {
                    method: "GET",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                    },
                });

                // Jika response adalah redirect ke login
                if (response.redirected) {
                    window.location.href = `/login?redirect=${encodeURIComponent(
                        window.location.href
                    )}`;
                    return;
                }

                // Jika berhasil, redirect ke halaman checkout
                window.location.href = "/checkout";
            }
        } catch (error) {
            console.error("Error during checkout:", error);
            showPopup(
                error.message || "Terjadi kesalahan saat checkout!",
                "error"
            );
        }
    }

    // Ubah event listener checkout button
    if (checkoutButton) {
        checkoutButton.addEventListener("click", function (e) {
            e.preventDefault(); // Prevent default form submission
            handleCheckout();
        });
    }

    function showPopup(message, type = "success") {
        const popup = document.getElementById("cart-popup");

        // Set warna berdasarkan tipe
        if (type === "success") {
            popup.classList.add("bg-green-500");
            popup.classList.remove("bg-red-500");
        } else {
            popup.classList.add("bg-red-500");
            popup.classList.remove("bg-green-500");
        }

        // Tampilkan pesan
        popup.textContent = message;
        popup.classList.remove("hidden", "opacity-0");
        popup.classList.add("opacity-100");

        // Hilangkan setelah 3 detik
        setTimeout(() => {
            popup.classList.remove("opacity-100");
            popup.classList.add("opacity-0");
            setTimeout(() => popup.classList.add("hidden"), 300);
        }, 3000);
    }

    // UI Helper Functions
    function showQuantityControls(obatId, quantity) {
        const addButton = document.querySelector(`#tambah-keranjang-${obatId}`);
        const quantityControls = document.querySelector(
            `#quantity-controls-${obatId}`
        );
        const quantityInput = document.querySelector(`#quantity-${obatId}`);

        if (addButton && quantityControls && quantityInput) {
            addButton.classList.add("hidden");
            quantityControls.classList.remove("hidden");
            quantityInput.value = quantity;
            quantityInput.removeAttribute("readonly");
        }
    }

    function hideQuantityControls(obatId) {
        const addButton = document.querySelector(`#tambah-keranjang-${obatId}`);
        const quantityControls = document.querySelector(
            `#quantity-controls-${obatId}`
        );
        const quantityInput = document.querySelector(`#quantity-${obatId}`);

        if (addButton && quantityControls) {
            addButton.classList.remove("hidden");
            quantityControls.classList.add("hidden");
            if (quantityInput) {
                quantityInput.value = 1;
            }
        }
    }

    function updateCartCount(count) {
        const cartCountElement = document.querySelector("#cart-count");
        if (cartCountElement) {
            cartCountElement.textContent = count || "0";
        }
    }

    function showCartPopup(message) {
        const popup = document.getElementById("cart-popup");
        if (popup) {
            popup.textContent = message;
            popup.classList.remove("hidden");
            popup.classList.add("opacity-100");

            setTimeout(() => {
                popup.classList.remove("opacity-100");
                popup.classList.add("opacity-0");
                setTimeout(() => {
                    popup.classList.add("hidden");
                }, 300);
            }, 2000);
        }
    }

    // Formatting Functions
    function formatCurrency(amount) {
        return new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 0,
        }).format(amount);
    }

    function formatNumber(number) {
        return new Intl.NumberFormat("id-ID").format(number);
    }
});
