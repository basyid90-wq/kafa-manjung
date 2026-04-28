#!/bin/bash
# ============================================================
# KAFA Manjung - VPS Setup Script (Ubuntu 22.04)
# Jalankan sebagai root: bash setup-vps.sh
# ============================================================

set -e
echo "============================================"
echo "  KAFA Manjung - VPS Auto Setup"
echo "============================================"

# --- 1. Update sistem ---
echo "[1/9] Updating system..."
apt update && apt upgrade -y

# --- 2. Install PHP 8.2 + extensions ---
echo "[2/9] Installing PHP 8.2..."
apt install -y software-properties-common
add-apt-repository ppa:ondrej/php -y
apt update
apt install -y php8.2-fpm php8.2-cli php8.2-mysql php8.2-mbstring \
    php8.2-xml php8.2-curl php8.2-zip php8.2-bcmath php8.2-gd \
    php8.2-intl php8.2-tokenizer php8.2-fileinfo unzip git curl

# --- 3. Install Nginx ---
echo "[3/9] Installing Nginx..."
apt install -y nginx

# --- 4. Install MySQL ---
echo "[4/9] Installing MySQL..."
apt install -y mysql-server

# Secure MySQL - set root password
mysql -e "ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'KafaSecure@2025!';"
mysql -u root -pKafaSecure@2025! -e "CREATE DATABASE IF NOT EXISTS kafa_manjung CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
mysql -u root -pKafaSecure@2025! -e "FLUSH PRIVILEGES;"

# --- 5. Install Composer ---
echo "[5/9] Installing Composer..."
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

# --- 6. Install Node.js 20 ---
echo "[6/9] Installing Node.js 20..."
curl -fsSL https://deb.nodesource.com/setup_20.x | bash -
apt install -y nodejs

# --- 7. Install Certbot (SSL) ---
echo "[7/9] Installing Certbot..."
apt install -y certbot python3-certbot-nginx

# --- 8. Clone repo ---
echo "[8/9] Cloning repository..."
mkdir -p /var/www/kafa-manjung
cd /var/www
git clone https://github.com/basyid90-wq/kafa-manjung.git kafa-manjung
cd /var/www/kafa-manjung

# Install PHP dependencies
composer install --optimize-autoloader --no-dev

# Install & build frontend assets
npm install
npm run build

# Setup storage
php artisan storage:link

# Set permissions
chown -R www-data:www-data /var/www/kafa-manjung
chmod -R 755 /var/www/kafa-manjung
chmod -R 775 /var/www/kafa-manjung/storage
chmod -R 775 /var/www/kafa-manjung/bootstrap/cache

# --- 9. Setup Nginx config ---
echo "[9/9] Configuring Nginx..."
cat > /etc/nginx/sites-available/kafa-manjung << 'NGINX_CONF'
server {
    listen 80;
    server_name ekafa.online www.ekafa.online;
    root /var/www/kafa-manjung/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    client_max_body_size 20M;
}
NGINX_CONF

# Enable site
ln -sf /etc/nginx/sites-available/kafa-manjung /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default
nginx -t && systemctl reload nginx

echo ""
echo "============================================"
echo "  Setup selesai! Langkah seterusnya:"
echo "  1. Upload fail .env ke /var/www/kafa-manjung/"
echo "  2. Jalankan: php artisan migrate:fresh --seed"
echo "  3. Jalankan: certbot --nginx -d ekafa.online -d www.ekafa.online"
echo "============================================"
