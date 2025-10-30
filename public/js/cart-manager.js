/**
 * Cart Manager - Global cart functionality
 * Manages cart count updates and real-time synchronization
 */

class CartManager {
    constructor() {
        this.updateInterval = null;
        this.isUpdating = false;
        this.lastCount = 0;
        this.cartRoute = null;

        this.init();
    }

    init() {
        // Set cart route from meta tag if available
        const cartRouteMeta = document.querySelector(
            'meta[name="cart-count-route"]'
        );
        if (cartRouteMeta) {
            this.cartRoute = cartRouteMeta.content;
        }

        // Initial cart count update
        this.updateCartCount();

        // Set up event listeners
        this.setupEventListeners();

        // Start periodic updates (every 5 seconds)
        this.startPeriodicUpdates();
    }

    setupEventListeners() {
        // Listen for form submissions
        document.addEventListener("submit", (e) => {
            if (this.isCartRelatedForm(e.target)) {
                setTimeout(() => this.updateCartCount(), 500);
            }
        });

        // Listen for button clicks
        document.addEventListener("click", (e) => {
            if (this.isCartRelatedButton(e.target)) {
                setTimeout(() => this.updateCartCount(), 500);
            }
        });

        // Listen for custom events
        document.addEventListener("cartUpdated", () => {
            this.updateCartCount();
        });

        // Livewire events
        document.addEventListener("livewire:init", () => {
            if (window.Livewire) {
                Livewire.on("cartUpdated", () => this.updateCartCount());
                Livewire.on("itemAddedToCart", () => this.updateCartCount());
                Livewire.on("itemRemovedFromCart", () =>
                    this.updateCartCount()
                );
            }
        });

        // Clean up on page unload
        window.addEventListener("beforeunload", () => {
            this.stopPeriodicUpdates();
        });

        // Page visibility change (pause updates when tab is hidden)
        document.addEventListener("visibilitychange", () => {
            if (document.hidden) {
                this.stopPeriodicUpdates();
            } else {
                this.startPeriodicUpdates();
                this.updateCartCount(); // Immediate update when tab becomes visible
            }
        });
    }

    isCartRelatedForm(form) {
        return (
            form.querySelector('input[name*="cart"]') ||
            form.querySelector('input[name*="add_to_cart"]') ||
            form.classList.contains("cart-form") ||
            form.dataset.cartForm === "true"
        );
    }

    isCartRelatedButton(element) {
        const button = element.closest("button");
        if (!button) return false;

        const text = button.textContent?.toLowerCase() || "";
        return (
            text.includes("tambah ke keranjang") ||
            text.includes("add to cart") ||
            text.includes("tambah") ||
            button.classList.contains("add-to-cart") ||
            button.classList.contains("cart-btn") ||
            button.dataset.action === "add-to-cart" ||
            button.dataset.cartAction
        );
    }

    startPeriodicUpdates() {
        if (this.updateInterval) return;

        this.updateInterval = setInterval(() => {
            this.updateCartCount();
        }, 5000); // Check every 5 seconds
    }

    stopPeriodicUpdates() {
        if (this.updateInterval) {
            clearInterval(this.updateInterval);
            this.updateInterval = null;
        }
    }

    async updateCartCount() {
        if (this.isUpdating || !this.cartRoute) return;

        this.isUpdating = true;

        try {
            const response = await fetch(this.cartRoute);
            const data = await response.json();

            if (data.count !== undefined) {
                this.updateCartBadge(data.count);
                this.lastCount = data.count;
            }
        } catch (error) {
            console.error("Error updating cart count:", error);
        } finally {
            this.isUpdating = false;
        }
    }

    updateCartBadge(count) {
        const cartBadge = document.getElementById("cartBadge");
        if (!cartBadge) return;

        const currentCount = parseInt(cartBadge.textContent) || 0;
        cartBadge.textContent = count;

        if (count > 0) {
            cartBadge.style.display = "flex";

            // Add animation if count increased
            if (count > currentCount) {
                this.animateCartBadge(cartBadge);
            }
        } else {
            cartBadge.style.display = "none";
        }
    }

    animateCartBadge(badge) {
        badge.style.animation = "none";
        badge.offsetHeight; // Trigger reflow
        badge.style.animation = "pulse 0.5s ease-in-out";

        // Add bounce effect
        setTimeout(() => {
            badge.style.transform = "scale(1.2)";
            setTimeout(() => {
                badge.style.transform = "scale(1)";
            }, 150);
        }, 100);
    }

    // Public methods
    forceUpdate() {
        this.updateCartCount();
    }

    triggerCartEvent() {
        document.dispatchEvent(new CustomEvent("cartUpdated"));
    }
}

// Global functions for backward compatibility
window.updateCartCount = function () {
    if (window.cartManager) {
        window.cartManager.forceUpdate();
    }
};

window.triggerCartUpdate = function () {
    if (window.cartManager) {
        window.cartManager.triggerCartEvent();
    }
};

// Initialize when DOM is ready
if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", () => {
        window.cartManager = new CartManager();
    });
} else {
    window.cartManager = new CartManager();
}
