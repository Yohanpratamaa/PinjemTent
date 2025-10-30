# Local Development Helper Commands
# Add these to your shell profile (.bashrc, .zshrc, etc.)

# Composer aliases for this project
alias composer-dev="composer install --optimize-autoloader --ignore-platform-reqs"
alias composer-prod="composer install --no-dev --optimize-autoloader --ignore-platform-reqs"
alias composer-fresh="rm -f composer.lock && composer install --ignore-platform-reqs"

# Laravel development commands
alias art="php artisan"
alias migrate-fresh="php artisan migrate:fresh --seed"
alias serve="php artisan serve"

# Combined development setup
alias dev-setup="composer-dev && npm install && npm run build && php artisan key:generate && php artisan migrate:fresh --seed"

# Production build
alias prod-build="composer-prod && npm ci --only=production && npm run build"
