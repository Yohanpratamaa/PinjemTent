#!/bin/bash

echo "🔄 Refreshing database and running comprehensive seeders..."
echo ""

# Fresh migrate and seed
php artisan migrate:fresh --seed

echo ""
echo "🎉 Database has been refreshed with comprehensive sample data!"
echo ""
echo "📷 Sample Images Created:"
echo "- All equipment images are generated as SVG placeholders"
echo "- Images are stored in public/images/units/"
echo "- Each image has a unique color and label"
echo ""
echo "🔐 Login Information:"
echo "Admin Panel: admin@example.com / password"
echo "User Account: test@example.com / password"
echo "Other test accounts: john@example.com, jane@example.com, etc. / password"
echo ""
echo "📊 Database Statistics:"
php artisan tinker --execute="
echo 'Categories: ' . App\Models\Kategori::count() . PHP_EOL;
echo 'Equipment/Units: ' . App\Models\Unit::count() . PHP_EOL;
echo 'Users: ' . App\Models\User::count() . PHP_EOL;
echo 'Rental Records: ' . App\Models\Peminjaman::count() . PHP_EOL;
echo 'Cart Items: ' . App\Models\Cart::count() . PHP_EOL;
echo 'Notifications: ' . App\Models\Notification::count() . PHP_EOL;
"
