/**
 * Unit Management Debug Script
 * Membantu debugging masalah edit dan delete unit
 */

// Debug Form Data saat Submit
function debugUnitForm(formElement) {
    const formData = new FormData(formElement);
    console.group("🔍 Unit Form Debug");
    console.log("Form Element:", formElement);
    console.log("Form Action:", formElement.action);
    console.log("Form Method:", formElement.method);

    console.log("📋 Form Data:");
    for (let [key, value] of formData.entries()) {
        console.log(`  ${key}: "${value}" (${typeof value})`);
    }

    // Validasi khusus untuk field yang sering bermasalah
    const problemFields = ["stok", "kode_unit", "nama_unit"];
    problemFields.forEach((field) => {
        const input = formElement.querySelector(`[name="${field}"]`);
        if (input) {
            console.log(`🔍 Field ${field}:`, {
                value: input.value,
                type: input.type,
                required: input.required,
                valid: input.checkValidity(),
                validationMessage: input.validationMessage,
            });
        }
    });

    console.groupEnd();
    return true; // Allow form submission
}

// Separate debug function for UPDATE form specifically
function debugUnitUpdateForm(formElement) {
    const formData = new FormData(formElement);
    console.group("🔄 Unit UPDATE Form Debug");
    console.log("Action: UPDATE UNIT");
    console.log("Form Element:", formElement);
    console.log("Form Action:", formElement.action);
    console.log("Form Method:", formElement.method);

    console.log("📋 UPDATE Form Data:");
    for (let [key, value] of formData.entries()) {
        console.log(`  ${key}: "${value}" (${typeof value})`);
    }

    console.groupEnd();
    return true; // Allow form submission
} // Debug Delete Action
function debugDeleteUnit(unitId, unitName) {
    console.group("🗑️ Delete Unit Debug");
    console.log("Unit ID:", unitId);
    console.log("Unit Name:", unitName);
    console.log("Timestamp:", new Date().toISOString());

    const confirmed = confirm(
        `Are you sure you want to delete unit "${unitName}"?\n\nThis action cannot be undone.`
    );
    console.log("User Confirmed:", confirmed);
    console.groupEnd();

    return confirmed;
}

// Monitor AJAX Requests
function setupAjaxDebug() {
    const originalFetch = window.fetch;
    window.fetch = function (...args) {
        console.log("🌐 AJAX Request:", args);
        return originalFetch
            .apply(this, args)
            .then((response) => {
                console.log("✅ AJAX Response:", response);
                return response;
            })
            .catch((error) => {
                console.error("❌ AJAX Error:", error);
                throw error;
            });
    };
}

// Check for Common Issues
function checkUnitPageIssues() {
    console.group("🔧 Unit Page Health Check");

    // Check for missing icons
    const fluxIcons = document.querySelectorAll('[class*="flux:icon"]');
    fluxIcons.forEach((icon) => {
        if (icon.innerHTML.trim() === "") {
            console.warn("⚠️ Empty icon found:", icon);
        }
    });

    // Check for form validation
    const forms = document.querySelectorAll("form");
    forms.forEach((form, index) => {
        console.log(`📝 Form ${index + 1}:`, {
            action: form.action,
            method: form.method,
            inputs: form.querySelectorAll("input, select, textarea").length,
            hasValidation: form.hasAttribute("novalidate") === false,
        });
    });

    // Check for console errors
    const originalError = console.error;
    console.error = function (...args) {
        console.log("🚨 Console Error Detected:", args);
        originalError.apply(console, args);
    };

    console.groupEnd();
}

// Stock Validation Helper
function validateStock(input, minValue = 1) {
    const value = parseInt(input.value);
    const isValid = !isNaN(value) && value >= minValue;

    if (!isValid) {
        input.style.borderColor = "#ef4444";
        input.style.boxShadow = "0 0 0 1px #ef4444";
        console.warn("❌ Invalid stock value:", input.value);
    } else {
        input.style.borderColor = "";
        input.style.boxShadow = "";
        console.log("✅ Stock value valid:", value);
    }

    return isValid;
}

// Initialize Debug Features
document.addEventListener("DOMContentLoaded", function () {
    console.log("🚀 Unit Debug Script Loaded");

    // Setup AJAX monitoring
    setupAjaxDebug();

    // Run health check
    checkUnitPageIssues();

    // Add form debugging to all forms
    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", function (e) {
            console.log("📤 Form Submit Event:", e);
            debugUnitForm(this);
        });
    });

    // Add stock validation to stock inputs
    document.querySelectorAll('input[name="stok"]').forEach((input) => {
        input.addEventListener("blur", function () {
            validateStock(this);
        });

        input.addEventListener("input", function () {
            // Real-time validation
            setTimeout(() => validateStock(this), 300);
        });
    });

    // Enhanced delete confirmation
    document.querySelectorAll('form[action*="destroy"]').forEach((form) => {
        form.addEventListener("submit", function (e) {
            const unitName = this.dataset.unitName || "this unit";
            const unitId = this.dataset.unitId || "unknown";

            if (!debugDeleteUnit(unitId, unitName)) {
                e.preventDefault();
                return false;
            }
        });
    });

    console.log("✅ Unit Debug Features Initialized");
});

// Export functions for manual testing
window.unitDebug = {
    debugUnitForm,
    debugDeleteUnit,
    validateStock,
    checkUnitPageIssues,
};
