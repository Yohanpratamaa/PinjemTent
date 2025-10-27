/**
 * User Management Debug Script
 * Membantu debugging masalah edit dan delete user
 */

// Debug Form Data saat Submit
function debugUserForm(formElement) {
    const formData = new FormData(formElement);
    console.group("🔍 User Form Debug");
    console.log("Form Element:", formElement);
    console.log("Form Action:", formElement.action);
    console.log("Form Method:", formElement.method);

    console.log("📋 Form Data:");
    for (let [key, value] of formData.entries()) {
        // Don't log sensitive data
        if (key.includes("password")) {
            console.log(`  ${key}: "[HIDDEN]" (string)`);
        } else {
            console.log(`  ${key}: "${value}" (${typeof value})`);
        }
    }

    // Validasi khusus untuk field yang sering bermasalah
    const problemFields = ["name", "email", "role"];
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
function debugUserUpdateForm(formElement) {
    const formData = new FormData(formElement);
    console.group("🔄 User UPDATE Form Debug");
    console.log("IMPORTANT: This is an UPDATE operation, not DELETE");
    console.log("Action: UPDATE USER");
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
        // Don't log sensitive data
        if (key.includes("password")) {
            console.log(`  ${key}: "[HIDDEN]" (string)`);
        } else {
            console.log(`  ${key}: "${value}" (${typeof value})`);
        }
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
function debugDeleteUser(userId, userName) {
    console.group("🗑️ Delete User Debug");
    console.log("IMPORTANT: This is a DELETE operation, not UPDATE");
    console.log("User ID:", userId);
    console.log("User Name:", userName);
    console.log("Timestamp:", new Date().toISOString());
    console.log("Action: DELETE USER (Permanent)");

    const confirmed = confirm(
        `⚠️ DELETE CONFIRMATION ⚠️\n\nAre you sure you want to PERMANENTLY DELETE user "${userName}"?\n\nThis action CANNOT be undone!\n\nClick OK to DELETE or Cancel to abort.`
    );
    console.log("User Confirmed Delete:", confirmed);
    console.groupEnd();

    if (confirmed) {
        console.warn("🗑️ DELETE CONFIRMED - User will be deleted!");
    } else {
        console.log("✅ DELETE CANCELLED - User will not be deleted");
    }

    return confirmed;
}

// Monitor AJAX Requests
function setupUserAjaxDebug() {
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
function checkUserPageIssues() {
    console.group("🔧 User Page Health Check");

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

// Email Validation Helper
function validateUserEmail(input) {
    const value = input.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const isValid = emailRegex.test(value);

    if (!isValid && value.length > 0) {
        input.style.borderColor = "#ef4444";
        input.style.boxShadow = "0 0 0 1px #ef4444";
        console.warn("❌ Invalid email format:", input.value);
    } else {
        input.style.borderColor = "";
        input.style.boxShadow = "";
        if (value.length > 0) {
            console.log("✅ Email format valid:", value);
        }
    }

    return isValid;
}

// Password Strength Helper
function validatePasswordStrength(input) {
    const value = input.value;
    if (value.length === 0) return true; // Optional field

    const hasMinLength = value.length >= 8;
    const hasUpperCase = /[A-Z]/.test(value);
    const hasLowerCase = /[a-z]/.test(value);
    const hasNumbers = /\d/.test(value);

    const strength = [
        hasMinLength,
        hasUpperCase,
        hasLowerCase,
        hasNumbers,
    ].filter(Boolean).length;

    if (strength < 2 && value.length > 0) {
        input.style.borderColor = "#ef4444";
        input.style.boxShadow = "0 0 0 1px #ef4444";
        console.warn("❌ Weak password");
    } else {
        input.style.borderColor = "";
        input.style.boxShadow = "";
        if (value.length > 0) {
            console.log("✅ Password strength adequate");
        }
    }

    return strength >= 2;
}

// Initialize Debug Features
document.addEventListener("DOMContentLoaded", function () {
    console.log("🚀 User Debug Script Loaded");

    // Setup AJAX monitoring
    setupUserAjaxDebug();

    // Run health check
    checkUserPageIssues();

    // Add form debugging to all forms
    document.querySelectorAll("form").forEach((form) => {
        form.addEventListener("submit", function (e) {
            console.log("📤 User Form Submit Event:", e);
            debugUserForm(this);
        });
    });

    // Add email validation
    document.querySelectorAll('input[name="email"]').forEach((input) => {
        input.addEventListener("blur", function () {
            validateUserEmail(this);
        });

        input.addEventListener("input", function () {
            // Real-time validation
            setTimeout(() => validateUserEmail(this), 300);
        });
    });

    // Add password validation
    document.querySelectorAll('input[name="password"]').forEach((input) => {
        input.addEventListener("blur", function () {
            validatePasswordStrength(this);
        });

        input.addEventListener("input", function () {
            // Real-time validation
            setTimeout(() => validatePasswordStrength(this), 300);
        });
    });

    // Enhanced delete confirmation
    document.querySelectorAll('form[action*="destroy"]').forEach((form) => {
        form.addEventListener("submit", function (e) {
            const userName = this.dataset.userName || "this user";
            const userId = this.dataset.userId || "unknown";

            if (!debugDeleteUser(userId, userName)) {
                e.preventDefault();
                return false;
            }
        });
    });

    console.log("✅ User Debug Features Initialized");
});

// Export functions for manual testing
window.userDebug = {
    debugUserForm,
    debugDeleteUser,
    validateUserEmail,
    validatePasswordStrength,
    checkUserPageIssues,
};
