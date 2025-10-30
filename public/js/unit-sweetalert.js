/* Unit Management SweetAlert Enhancement */

// Initialize SweetAlert when document is ready
document.addEventListener("DOMContentLoaded", function () {
    // Enhanced form validation for unit forms
    const unitForms = document.querySelectorAll('form[id*="unit"]');
    unitForms.forEach((form) => {
        form.addEventListener("submit", function (e) {
            if (!validateUnitFormEnhanced(this)) {
                e.preventDefault();
                return false;
            }
        });
    });

    // Add visual feedback for required fields
    const requiredFields = document.querySelectorAll(
        "input[required], select[required], textarea[required]"
    );
    requiredFields.forEach((field) => {
        field.addEventListener("blur", function () {
            if (!this.value.trim()) {
                this.classList.add("border-red-300", "focus:border-red-500");
                this.classList.remove("border-gray-300");
            } else {
                this.classList.remove("border-red-300", "focus:border-red-500");
                this.classList.add("border-gray-300");
            }
        });
    });
});

// Enhanced form validation function
function validateUnitFormEnhanced(form) {
    const requiredFields = form.querySelectorAll("[required]");
    const errors = [];

    requiredFields.forEach((field) => {
        if (!field.value.trim()) {
            errors.push(`${field.getAttribute("name")} is required`);
            field.classList.add("border-red-500");
        } else {
            field.classList.remove("border-red-500");
        }
    });

    // Specific validation for unit code (flexible format)
    const kodeUnit = form.querySelector('input[name="kode_unit"]');
    if (kodeUnit && kodeUnit.value) {
        const kodeValue = kodeUnit.value.trim();
        // More flexible pattern allowing uppercase letters, numbers, and hyphens
        const kodePattern = /^[A-Z0-9\-]{3,20}$/;
        if (!kodePattern.test(kodeValue)) {
            errors.push(
                "Unit code must be 3-20 characters (uppercase letters, numbers, and hyphens only)"
            );
            kodeUnit.classList.add("border-red-500");
        } else {
            kodeUnit.classList.remove("border-red-500");
        }
    }

    // Stock validation
    const stokField = form.querySelector('input[name="stok"]');
    if (stokField && stokField.value) {
        const stok = parseInt(stokField.value);
        if (stok < 0) {
            errors.push("Stock cannot be negative");
            stokField.classList.add("border-red-500");
        }
    }

    // Price validation
    const priceFields = form.querySelectorAll('input[name*="harga"]');
    priceFields.forEach((field) => {
        if (field.value && parseFloat(field.value) < 0) {
            errors.push(`${field.getAttribute("name")} cannot be negative`);
            field.classList.add("border-red-500");
        }
    });

    if (errors.length > 0) {
        Swal.fire({
            icon: "error",
            title: "Validation Error",
            html: `Please fix the following errors:<br><ul class="text-left mt-2">${errors
                .map((err) => `<li>• ${err}</li>`)
                .join("")}</ul>`,
            confirmButtonColor: "#ef4444",
        });
        return false;
    }

    return true;
}

// Confirmation for bulk operations
function confirmBulkDelete(selectedUnits) {
    if (selectedUnits.length === 0) {
        Swal.fire({
            icon: "warning",
            title: "No Units Selected",
            text: "Please select at least one unit to delete.",
            confirmButtonColor: "#f59e0b",
        });
        return false;
    }

    Swal.fire({
        title: `Delete ${selectedUnits.length} Units?`,
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ef4444",
        cancelButtonColor: "#6b7280",
        confirmButtonText: `Yes, Delete ${selectedUnits.length} Units!`,
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            // Process bulk delete
            selectedUnits.forEach((unitId) => {
                // Submit delete form for each unit
                const form = document.getElementById(
                    `delete-unit-form-${unitId}`
                );
                if (form) form.submit();
            });
        }
    });
}

// Unit import confirmation
function confirmUnitImport(fileInput) {
    const file = fileInput.files[0];
    if (!file) {
        Swal.fire({
            icon: "error",
            title: "No File Selected",
            text: "Please select a file to import.",
            confirmButtonColor: "#ef4444",
        });
        return false;
    }

    const allowedTypes = [".csv", ".xlsx", ".xls"];
    const fileExtension = "." + file.name.split(".").pop().toLowerCase();

    if (!allowedTypes.includes(fileExtension)) {
        Swal.fire({
            icon: "error",
            title: "Invalid File Type",
            text: "Please select a valid CSV or Excel file.",
            confirmButtonColor: "#ef4444",
        });
        return false;
    }

    Swal.fire({
        title: "Import Units?",
        html: `
            <div class="text-left">
                <p><strong>File:</strong> ${file.name}</p>
                <p><strong>Size:</strong> ${(file.size / 1024).toFixed(
                    2
                )} KB</p>
                <p class="text-sm text-gray-600 mt-2">This will import all units from the selected file.</p>
            </div>
        `,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#3b82f6",
        cancelButtonColor: "#6b7280",
        confirmButtonText: "Yes, Import!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit import form
            fileInput.closest("form").submit();
        }
    });
}

// Unit export confirmation
function confirmUnitExport(format) {
    Swal.fire({
        title: "Export Units?",
        text: `Export all units data in ${format.toUpperCase()} format?`,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#10b981",
        cancelButtonColor: "#6b7280",
        confirmButtonText: "Yes, Export!",
        cancelButtonText: "Cancel",
    }).then((result) => {
        if (result.isConfirmed) {
            // Trigger export download
            window.location.href = `/admin/units/export?format=${format}`;

            // Show success message
            Swal.fire({
                icon: "success",
                title: "Export Started!",
                text: "Your download will begin shortly.",
                showConfirmButton: false,
                timer: 2000,
                toast: true,
                position: "top-end",
            });
        }
    });
}

// Auto-save draft functionality
let autoSaveTimer;
function enableAutoSave(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    const inputs = form.querySelectorAll("input, select, textarea");
    inputs.forEach((input) => {
        input.addEventListener("input", function () {
            clearTimeout(autoSaveTimer);
            autoSaveTimer = setTimeout(() => {
                saveDraft(formId);
            }, 2000); // Save after 2 seconds of no typing
        });
    });
}

function saveDraft(formId) {
    const form = document.getElementById(formId);
    if (!form) return;

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    localStorage.setItem(`unit_draft_${formId}`, JSON.stringify(data));

    // Show subtle notification
    const toast = document.createElement("div");
    toast.className =
        "fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm";
    toast.textContent = "Draft saved";
    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 2000);
}

function loadDraft(formId) {
    const savedData = localStorage.getItem(`unit_draft_${formId}`);
    if (!savedData) return;

    const data = JSON.parse(savedData);
    const form = document.getElementById(formId);
    if (!form) return;

    Object.keys(data).forEach((key) => {
        const field = form.querySelector(`[name="${key}"]`);
        if (field) {
            field.value = data[key];
        }
    });

    Swal.fire({
        icon: "info",
        title: "Draft Found",
        text: "We found a saved draft. The form has been filled with your previous data.",
        showConfirmButton: false,
        timer: 3000,
        toast: true,
        position: "top-end",
    });
}

// Clear draft after successful submission
function clearDraft(formId) {
    localStorage.removeItem(`unit_draft_${formId}`);
}
