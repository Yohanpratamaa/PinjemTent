/**
 * Script debug untuk form create user
 * Memastikan form create user berfungsi dengan baik
 */

console.log("🧪 User Create Debug Script Loaded");

// Function untuk debug form create user
function debugUserCreateForm() {
    console.log("\n=== USER CREATE FORM DEBUG ===");

    const form = document.querySelector('form[action*="users"]');
    if (!form) {
        console.log("❌ Create form not found");
        return;
    }

    console.log("✅ Create form found");
    console.log("Form action:", form.action);
    console.log("Form method:", form.method);

    // Check all required fields
    const requiredFields = [
        "name",
        "email",
        "password",
        "password_confirmation",
        "role",
    ];

    requiredFields.forEach((fieldName) => {
        const field = form.querySelector(
            `input[name="${fieldName}"], select[name="${fieldName}"]`
        );
        if (field) {
            console.log(`✅ Field "${fieldName}" found:`, {
                type: field.type,
                required: field.required,
                value: field.value || "(empty)",
            });
        } else {
            console.log(`❌ Field "${fieldName}" NOT found`);
        }
    });

    // Check optional fields
    const optionalFields = ["phone", "email_verified", "send_welcome_email"];
    optionalFields.forEach((fieldName) => {
        const field = form.querySelector(`input[name="${fieldName}"]`);
        if (field) {
            console.log(`📝 Optional field "${fieldName}" found:`, {
                type: field.type,
                checked: field.checked,
                value: field.value || "(empty)",
            });
        }
    });

    // Check CSRF token
    const csrfToken = form.querySelector('input[name="_token"]');
    if (csrfToken) {
        console.log("✅ CSRF token found");
    } else {
        console.log("❌ CSRF token NOT found");
    }
}

// Function untuk validate form sebelum submit
function validateCreateForm() {
    console.log("\n=== VALIDATING CREATE FORM ===");

    const form = document.querySelector('form[action*="users"]');
    if (!form) return false;

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    console.log("Form data to submit:", data);

    // Basic validation
    const errors = [];

    if (!data.name || data.name.trim().length === 0) {
        errors.push("Name is required");
    }

    if (!data.email || !data.email.includes("@")) {
        errors.push("Valid email is required");
    }

    if (!data.password || data.password.length < 8) {
        errors.push("Password must be at least 8 characters");
    }

    if (data.password !== data.password_confirmation) {
        errors.push("Password confirmation does not match");
    }

    if (!data.role || !["admin", "user"].includes(data.role)) {
        errors.push("Valid role is required");
    }

    if (errors.length > 0) {
        console.log("❌ Validation errors:", errors);
        return false;
    }

    console.log("✅ Form validation passed");
    return true;
}

// Function untuk simulate form submission
function simulateCreateUser() {
    console.log("\n=== SIMULATING USER CREATE ===");

    const form = document.querySelector('form[action*="users"]');
    if (!form) {
        console.log("❌ Form not found");
        return;
    }

    // Fill form with test data
    const testData = {
        name: "Test User " + Date.now(),
        email: "test" + Date.now() + "@example.com",
        phone: "08123456789",
        password: "password123",
        password_confirmation: "password123",
        role: "user",
    };

    Object.entries(testData).forEach(([fieldName, value]) => {
        const field = form.querySelector(
            `input[name="${fieldName}"], select[name="${fieldName}"]`
        );
        if (field) {
            field.value = value;
            console.log(`✅ Set ${fieldName} = ${value}`);
        }
    });

    console.log("🎯 Test data filled. Click submit to test create user.");

    // Validate before submit
    if (validateCreateForm()) {
        console.log("✅ Ready to submit");
    } else {
        console.log("❌ Form has validation errors");
    }
}

// Function untuk handle form submission dan debug
function setupCreateFormDebug() {
    const form = document.querySelector('form[action*="users"]');
    if (!form) return;

    form.addEventListener("submit", function (e) {
        console.log("\n=== FORM SUBMISSION DEBUG ===");
        console.log("Form being submitted...");

        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());

        console.log("Submitted data:", data);

        // Don't prevent submission, let it go through
        console.log("✅ Form submitted successfully");
    });

    console.log("✅ Form submission debug setup complete");
}

// Function untuk test semua aspek create user
function runCreateUserTests() {
    console.log("🚀 Running Create User Tests...");

    debugUserCreateForm();
    setupCreateFormDebug();

    console.log("\n=== TEST SUMMARY ===");
    console.log("✅ Use simulateCreateUser() to fill form with test data");
    console.log("✅ Use validateCreateForm() to validate current form data");
    console.log("✅ Form submission is being monitored");
    console.log(
        "\n📝 To test: Fill form manually or call simulateCreateUser(), then click Submit"
    );
}

// Auto-run pada page load
document.addEventListener("DOMContentLoaded", function () {
    // Cek apakah ini halaman create user
    if (window.location.href.includes("/admin/users/create")) {
        console.log("📍 On user create page, running tests...");
        setTimeout(runCreateUserTests, 500);
    }
});

// Export functions untuk manual testing
window.userCreateDebug = {
    runCreateUserTests,
    debugUserCreateForm,
    validateCreateForm,
    simulateCreateUser,
    setupCreateFormDebug,
};

console.log("📚 User Create Debug functions available: window.userCreateDebug");
