FROM php:8.4-fpm

# Install PostgreSQL, Nginx, and required extensions
RUN apt-get update && apt-get install -y \
    libpq-dev \
    nginx \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy application files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Create startup script
RUN echo '#!/bin/bash\n\
PORT=${PORT:-8080}\n\
cat > /etc/nginx/sites-available/default <<EOF\n\
server {\n\
    listen $PORT;\n\
    root /var/www/html;\n\
    index index.php index.html;\n\
    location / {\n\
        try_files \\$uri \\$uri/ \\$uri.php \\$uri.php/ =404;\n\
    }\n\
    location ~ \\.php$ {\n\
        fastcgi_pass 127.0.0.1:9000;\n\
        fastcgi_index index.php;\n\
        fastcgi_param SCRIPT_FILENAME \\$document_root\\$fastcgi_script_name;\n\
        include fastcgi_params;\n\
    }\n\
}\n\
EOF\n\
php-fpm -D\n\
nginx -g "daemon off;"\n\
' > /start.sh && chmod +x /start.sh

# Expose port
EXPOSE 8080

# Start both PHP-FPM and Nginx
CMD ["/start.sh"]
