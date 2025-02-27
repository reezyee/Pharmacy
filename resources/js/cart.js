document.addEventListener('DOMContentLoaded', function() {
    // Cart popup elements
    const cartPopup = document.getElementById('cart-popup');

    // Function to update cart count in navbar
    function updateCartCount(count) {
        const cartCountElements = document.querySelectorAll('#cart-count');
        cartCountElements.forEach(element => {
            element.innerText = count;
        });
    }

    // Get CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Function to handle add to cart clicks
    function handleAddToCart(event) {
        const button = event.currentTarget;
        const obatId = button.getAttribute('data-obat-id');
        const obatNama = button.getAttribute('data-obat-nama') || 'Obat';

        // Send AJAX request to add item to cart
        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                obat_id: obatId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update button text with cart count
                button.innerHTML = `Ditambahkan (${data.cart_count})`;
                button.classList.add('bg-green-500');

                // Update cart counts
                updateCartCount(data.cart_count);

                // Show popup animation
                if (cartPopup) {
                    cartPopup.innerText = `${obatNama} berhasil ditambahkan!`;
                    cartPopup.classList.remove('hidden');

                    // Trigger animation
                    setTimeout(() => {
                        cartPopup.classList.add('opacity-100');
                    }, 10);

                    // Hide popup after 2 seconds
                    setTimeout(() => {
                        cartPopup.classList.remove('opacity-100');
                        setTimeout(() => {
                            cartPopup.classList.add('hidden');
                        }, 300);
                    }, 2000);
                }

                // Update cart modal if it's open
                updateCartModal();
            }
        })
        .catch(error => {
            console.error('Error adding item to cart:', error);
        });
    }

    // Add event listeners to all add to cart buttons dynamically
    function setupAddToCartButtons() {
        document.querySelectorAll('.add-to-cart').forEach(button => {
            // Remove existing listeners to prevent duplicates
            button.removeEventListener('click', handleAddToCart);
            // Add the event listener
            button.addEventListener('click', handleAddToCart);
        });
    }

    // Initial setup
    setupAddToCartButtons();

    // Setup event delegation for dynamically added buttons
    document.addEventListener('click', function(event) {
        if (event.target.closest('.add-to-cart')) {
            const button = event.target.closest('.add-to-cart');
            if (!button.hasAttribute('data-listener')) {
                button.setAttribute('data-listener', 'true');
                handleAddToCart({ currentTarget: button });
            }
        }
    });

    // Function to update cart modal contents
    function updateCartModal() {
        const cartModal = document.getElementById('static-modal');
        if (cartModal && !cartModal.classList.contains('hidden')) {
            fetch('/cart')
                .then(response => response.json())
                .then(data => {
                    const cartItems = document.querySelector('#static-modal .p-4.md\\:p-5.space-y-4');
                    if (cartItems) {
                        // Clear existing content
                        cartItems.innerHTML = '';

                        if (Object.keys(data).length === 0) {
                            cartItems.innerHTML =
                                `<div class="flex justify-center">
                                <p class="text-center text-gray-500">Keranjang Anda kosong</p>
                                    <a href="/shop" class="btn-primary mt-4">Belanja Obat</a>                                
                                `;
                        } else {
                            // Create cart items list
                            const itemsList = document.createElement('div');
                            itemsList.className = 'space-y-4';

                            Object.values(data).forEach(item => {
                                const itemElement = document.createElement('div');
                                itemElement.className =
                                    'flex justify-between items-center border-b pb-3';
                                itemElement.innerHTML = `
                                <div class="flex items-center gap-3">
                                    <img src="${item.foto ? '/storage/' + item.foto : '/api/placeholder/50/50'}" 
                                         class="w-12 h-12 object-cover rounded" alt="${item.nama}">
                                    <div>
                                        <p class="font-medium">${item.nama}</p>
                                        <p class="text-sm text-gray-500">Rp${item.harga.toLocaleString()} × ${item.quantity}</p>
                                    </div>
                                </div>
                                <button class="remove-cart-item text-red-500 hover:text-red-700" data-obat-id="${item.id}">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            `;
                                itemsList.appendChild(itemElement);
                            });

                            // Calculate total
                            const total = Object.values(data).reduce((sum, item) => sum + (item.harga *
                                item.quantity), 0);

                            // Add total and checkout button
                            const totalElement = document.createElement('div');
                            totalElement.className = 'flex justify-between items-center pt-4 font-bold';
                            totalElement.innerHTML = `
                            <span>Total:</span>
                            <span>Rp${total.toLocaleString()}</span>
                        `;

                            // Add all elements to cart items
                            cartItems.appendChild(itemsList);
                            cartItems.appendChild(totalElement);

                            // Add event listeners to remove buttons
                            itemsList.querySelectorAll('.remove-cart-item').forEach(button => {
                                button.addEventListener('click', function() {
                                    const obatId = this.getAttribute('data-obat-id');
                                    removeCartItem(obatId);
                                });
                            });
                        }
                    }
                })
                .catch(error => {
                    console.error('Error fetching cart data:', error);
                });
        }
    }

    // Function to remove item from cart
    function removeCartItem(obatId) {
        fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    obat_id: obatId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update cart count in navbar
                    updateCartCount(data.cart_count);

                    // Update cart modal
                    updateCartModal();

                    // Show popup notification
                    if (cartPopup) {
                        cartPopup.innerText = 'Item berhasil dihapus dari keranjang!';
                        cartPopup.classList.remove('hidden');
                        setTimeout(() => {
                            cartPopup.classList.add('opacity-100');
                        }, 10);

                        setTimeout(() => {
                            cartPopup.classList.remove('opacity-100');
                            setTimeout(() => {
                                cartPopup.classList.add('hidden');
                            }, 300);
                        }, 2000);
                    }
                }
            })
            .catch(error => {
                console.error('Error removing item from cart:', error);
            });
    }

    // Add event listener to cart icon to load cart modal contents
    const cartToggleButtons = document.querySelectorAll('[data-modal-target="static-modal"]');
    cartToggleButtons.forEach(button => {
        button.addEventListener('click', updateCartModal);
    });

    // Observe DOM changes to handle dynamically added elements
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                setupAddToCartButtons();
            }
        });
    });

    // Start observing the document with the configured parameters
    observer.observe(document.body, { childList: true, subtree: true });
});