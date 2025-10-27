# Flux UI Icon Reference Guide

## 🎯 Available Icons in Flux UI

Berikut adalah daftar icon yang tersedia dan telah diverifikasi bekerja dengan Flux UI:

### ✅ **Verified Working Icons:**

#### **Navigation & Actions**

```blade
<flux:icon.arrow-left class="size-4" />          <!-- Back/Previous -->
<flux:icon.arrow-right class="size-4" />         <!-- Forward/Next -->
<flux:icon.arrow-up class="size-4" />            <!-- Up -->
<flux:icon.arrow-down class="size-4" />          <!-- Down -->
<flux:icon.chevron-left class="size-4" />        <!-- Chevron Left -->
<flux:icon.chevron-right class="size-4" />       <!-- Chevron Right -->
<flux:icon.chevron-up class="size-4" />          <!-- Chevron Up -->
<flux:icon.chevron-down class="size-4" />        <!-- Chevron Down -->
```

#### **CRUD Operations**

```blade
<flux:icon.plus class="size-4" />                <!-- Create/Add -->
<flux:icon.pencil class="size-4" />              <!-- Edit -->
<flux:icon.trash class="size-4" />               <!-- Delete -->
<flux:icon.eye class="size-4" />                 <!-- View/Show -->
<flux:icon.check class="size-4" />               <!-- Confirm/Save -->
<flux:icon.x-mark class="size-4" />              <!-- Cancel/Close -->
```

#### **Status & Indicators**

```blade
<flux:icon.check-circle class="size-4" />        <!-- Success/Available -->
<flux:icon.clock class="size-4" />               <!-- Pending/Time -->
<flux:icon.exclamation-triangle class="size-4" /><!-- Warning -->
<flux:icon.information-circle class="size-4" />  <!-- Info -->
<flux:icon.light-bulb class="size-4" />          <!-- Tips/Ideas -->
```

#### **Content & Media**

```blade
<flux:icon.cube class="size-4" />                <!-- Items/Units -->
<flux:icon.document-text class="size-4" />       <!-- Documents -->
<flux:icon.photo class="size-4" />               <!-- Images -->
<flux:icon.chart-bar class="size-4" />           <!-- Statistics -->
<flux:icon.chart-pie class="size-4" />           <!-- Analytics -->
```

#### **User & Security**

```blade
<flux:icon.user class="size-4" />                <!-- User -->
<flux:icon.users class="size-4" />               <!-- Multiple Users -->
<flux:icon.lock-closed class="size-4" />         <!-- Secure -->
<flux:icon.lock-open class="size-4" />           <!-- Unlock -->
<flux:icon.shield-check class="size-4" />        <!-- Security -->
```

#### **External & Links**

```blade
<flux:icon.arrow-top-right-on-square class="size-4" />  <!-- External Link -->
<flux:icon.link class="size-4" />                       <!-- Link -->
<flux:icon.paper-clip class="size-4" />                 <!-- Attachment -->
```

### ❌ **Icons That DON'T Work:**

```blade
<!-- AVOID THESE - They will cause errors -->
<flux:icon.external-link class="size-4" />       <!-- ❌ NOT AVAILABLE -->
<flux:icon.open class="size-4" />                <!-- ❌ NOT AVAILABLE -->
<flux:icon.outside class="size-4" />             <!-- ❌ NOT AVAILABLE -->
```

## 🔧 **Icon Usage Patterns:**

### **Standard Sizes:**

```blade
<flux:icon.name class="size-3" />   <!-- Small (12px) -->
<flux:icon.name class="size-4" />   <!-- Default (16px) -->
<flux:icon.name class="size-5" />   <!-- Medium (20px) -->
<flux:icon.name class="size-6" />   <!-- Large (24px) -->
```

### **Button Icon Pattern (Fixed Layout):**

```blade
<!-- CORRECT - Use wrapper div -->
<flux:button type="submit" variant="primary">
    <div class="flex items-center gap-2">
        <flux:icon.check class="size-4" />
        <span>Save Changes</span>
    </div>
</flux:button>
```

### **Icon Color Classes:**

```blade
<!-- Inherit from parent -->
<flux:icon.check class="size-4" />

<!-- Custom colors -->
<flux:icon.check class="size-4 text-green-600 dark:text-green-400" />
<flux:icon.trash class="size-4 text-red-600 dark:text-red-400" />
<flux:icon.clock class="size-4 text-orange-600 dark:text-orange-400" />
```

## 🎨 **Common Use Cases:**

### **Admin Actions:**

```blade
<!-- View Details -->
<flux:icon.eye class="size-4" />

<!-- Edit Item -->
<flux:icon.pencil class="size-4" />

<!-- Delete Item -->
<flux:icon.trash class="size-4" />

<!-- Add New -->
<flux:icon.plus class="size-4" />

<!-- External View -->
<flux:icon.arrow-top-right-on-square class="size-4" />
```

### **Status Indicators:**

```blade
<!-- Available/Success -->
<flux:icon.check-circle class="size-4 text-green-600" />

<!-- Pending/In Progress -->
<flux:icon.clock class="size-4 text-orange-600" />

<!-- Warning/Alert -->
<flux:icon.exclamation-triangle class="size-4 text-yellow-600" />

<!-- Error/Problem -->
<flux:icon.x-circle class="size-4 text-red-600" />
```

### **Navigation:**

```blade
<!-- Back to List -->
<flux:icon.arrow-left class="size-4" />

<!-- Go to Details -->
<flux:icon.arrow-right class="size-4" />

<!-- Upload/Export -->
<flux:icon.arrow-up-tray class="size-4" />

<!-- Download/Import -->
<flux:icon.arrow-down-tray class="size-4" />
```

## 🚫 **Error Prevention:**

### **Before Using a New Icon:**

1. Check this reference list first
2. Test in a small component
3. Have fallback alternatives ready

### **Safe Alternatives:**

```blade
<!-- Instead of external-link, use: -->
<flux:icon.arrow-top-right-on-square class="size-4" />
<flux:icon.eye class="size-4" />
<flux:icon.link class="size-4" />

<!-- Instead of open, use: -->
<flux:icon.folder-open class="size-4" />
<flux:icon.eye class="size-4" />
```

## 🔄 **Migration Guide:**

### **Fixing Existing Errors:**

```bash
# Find problematic icons
grep -r "flux:icon.external-link" resources/views/
grep -r "flux:icon.open" resources/views/

# Replace with working alternatives
# external-link → arrow-top-right-on-square
# open → eye
```

---

_Keep this reference handy to avoid icon-related errors in Flux UI_ 🎯✨
