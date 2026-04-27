# ──────────────────────────────────────────────
# Stage 1 — Build Vite / frontend assets
# ──────────────────────────────────────────────
FROM node:20-alpine AS assets
WORKDIR /app

COPY package*.json ./
RUN npm ci --silent

COPY resources/ ./resources/
COPY vite.config.js ./
COPY public/ ./public/

RUN npm run build

# ──────────────────────────────────────────────
# Stage 2 — PHP runtime
# ──────────────────────────────────────────────
FROM php:8.3-cli AS runtime
WORKDIR /app

# System dependencies + PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
        git curl zip unzip \
        libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application source
COPY . .

# Copy built frontend assets from stage 1
COPY --from=assets /app/public/build ./public/build

# Install PHP dependencies (production only)
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress

# Storage permissions
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views \
    bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY start.sh /start.sh
RUN chmod +x /start.sh

EXPOSE 8080
CMD ["/start.sh"]
