/**
 * Kategori Management Debug Script
 * Membantu debugging masalah edit dan delete kategori
 */

// Debug Form Data saat Submit
function debugKategoriForm(formElement) {
    const formData = new FormData(formElement);
    console.group("🔍 Kategori Form Debug");
    console.log("Form Element:", formElement);
    console.log("Form Action:", formElement.action);
    console.log("Form Method:", formElement.method);

    console.log("📋 Form Data:");
    for (let [key, value] of formData.entries()) {
        console.log(`  ${key}: "${value}" (${typeof value})`);
    }

    // Validasi khusus untuk field yang sering bermasalah
    const problemFields = ["nama_kategori", "deskripsi"];
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
function debugKategoriUpdateForm(formElement) {
    const formData = new FormData(formElement);
    console.group("🔄 Kategori UPDATE Form Debug");
    console.log("IMPORTANT: This is an UPDATE operation, not DELETE");
    console.log("Action: UPDATE KATEGORI");
    console.log("Form Element:", formElement);
    console.log("Form Action:", formElement.action);
    console.log("Form Method:", formElement.method);

    // Check for PUT method
    const methodInput = formElement.querySelector('input[name="_method"]');
    if (methodInput) {
        console.log("✅ Method Override Found:", methodInput.value);
    } else {
        console.warn("⚠️ No _method input found - this might be a problem!");
    }

    console.log("📋 UPDATE Form Data:");
    for (let [key, value] of formData.entries()) {
        console.log(`  ${key}: "${value}" (${typeof value})`);
    }

    // Validate this is actually update form
    if (formElement.action.includes("destroy")) {
        console.error("🚨 CRITICAL ERROR: Update form has DELETE action!");
        alert(
            "ERROR: Update form is pointing to delete route! Please check the code."
        );
        return false;
    }

    console.log("✅ UPDATE form validation passed");
    console.groupEnd();
    return true; // Allow form submission
}

// Debug Delete Action
function debugDeleteKategori(kategoriId, kategoriName) {
    console.group("🗑️ Delete Kategori Debug");
    console.log("IMPORTANT: This is a DELETE operation, not UPDATE");
    console.log("Kategori ID:", kategoriId);
    console.log("Kategori Name:", kategoriName);
    console.log("Timestamp:", new Date().toISOString());
    console.log("Action: DELETE KATEGORI (Permanent)");

    const confirmed = confirm(
        `⚠️ DELETE CONFIRMATION ⚠️\n\nAre you sure you want to PERMANENTLY DELETE category "${kategoriName}"?\n\nThis action CANNOT be undone!\n\nClick OK to DELETE or Cancel to abort.`
    );
    console.log("User Confirmed Delete:", confirmed);
    console.groupEnd();

    if (confirmed) {
        console.warn("🗑️ DELETE CONFIRMED - Kategori will be deleted!");
    } else {
        console.log("✅ DELETE CANCELLED - Kategori will not be deleted");
    }

    return confirmed;
}

// Monitor AJAX Requests
function setupKategoriAjaxDebug() {
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
function checkKategoriPageIssues() {
    console.group("🔧 Kategori Page Health Check");

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

// Name Validation Helper
function validateKategoriName(input, minLength = 1) {
    const value = input.value.trim();
    const isValid = value.length >= minLength;

    if (!isValid) {
        input.style.borderColor = "#ef4444";
        input.style.boxShadow = "0 0 0 1px #ef4444";
        console.warn("❌ Invalid kategori name:", input.value);
    } else {
        input.style.borderColor = "";
        input.style.boxShadow = "";
        console.log("✅ Kategori name valid:", value);
    }

    return isValid;
}

// Initialize Debug Features
document.addEventListener("DOMContentLoaded", function () {
    console.log("🚀 Kategori Debug Script Loaded");

    // Setup AJAX monitoring
    setupKategoriAjaxDebug();

    // Run health check
    checkKategoriPageIssues();

    // Add form debugging to all forms
    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", function (e) {
            console.log("📤 Kategori Form Submit Event:", e);
            debugKategoriForm(this);
        });
    });

    // Add name validation to kategori name inputs
    document
        .querySelectorAll('input[name="nama_kategori"]')
        .forEach((input) => {
            input.addEventListener("blur", function () {
                validateKategoriName(this);
            });

            input.addEventListener("input", function () {
                // Real-time validation
                setTimeout(() => validateKategoriName(this), 300);
            });
        });

    // Enhanced delete confirmation
    document.querySelectorAll('form[action*="destroy"]').forEach((form) => {
        form.addEventListener("submit", function (e) {
            const kategoriName = this.dataset.kategoriName || "this category";
            const kategoriId = this.dataset.kategoriId || "unknown";

            if (!debugDeleteKategori(kategoriId, kategoriName)) {
                e.preventDefault();
                return false;
            }
        });
    });

    console.log("✅ Kategori Debug Features Initialized");
});

// Export functions for manual testing
window.kategoriDebug = {
    debugKategoriForm,
    debugDeleteKategori,
    validateKategoriName,
    checkKategoriPageIssues,
};
