# HealthHub - Production Deployment Guide

## Prerequisites

Before deploying HealthHub to production, ensure you have:

- PHP 8.1 or higher
- Composer 2.x
- MySQL 8.0 or MariaDB 10.4+
- Redis (for caching and sessions)
- Web server (Apache/Nginx)
- SSL certificate
- Node.js 16+ and npm (for asset compilation)

## Deployment Steps

### 1. Server Setup

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install PHP and extensions
sudo apt install php8.1 php8.1-fpm php8.1-mysql php8.1-redis php8.1-gd php8.1-curl php8.1-mbstring php8.1-xml php8.1-zip php8.1-bcmath php8.1-intl

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Redis
sudo apt install redis-server
sudo systemctl enable redis-server

# Install MySQL
sudo apt install mysql-server
sudo mysql_secure_installation
```

### 2. Application Deployment

```bash
# Clone the repository
git clone https://github.com/your-repo/healthhub.git /var/www/healthhub
cd /var/www/healthhub

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node.js dependencies and build assets
npm install
npm run build

# Set up environment
cp .env.production .env
php artisan key:generate

# Configure database
mysql -u root -p
CREATE DATABASE healthhub_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'healthhub'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON healthhub_production.* TO 'healthhub'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --force

# Set up storage and permissions
php artisan storage:link
sudo chown -R www-data:www-data /var/www/healthhub
sudo chmod -R 755 /var/www/healthhub
sudo chmod -R 775 /var/www/healthhub/storage
sudo chmod -R 775 /var/www/healthhub/bootstrap/cache

# Optimize application
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

### 3. Web Server Configuration

#### Nginx Configuration

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name your-domain.com www.your-domain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    listen [::]:443 ssl http2;
    server_name your-domain.com www.your-domain.com;
    root /var/www/healthhub/public;

    index index.php;

    charset utf-8;

    # SSL Configuration
    ssl_certificate /path/to/your/certificate.crt;
    ssl_certificate_key /path/to/your/private.key;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-SHA384;
    ssl_prefer_server_ciphers off;

    # Security Headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;
    add_header Strict-Transport-Security "max-age=31536000; includeSubDomains" always;

    # Rate Limiting
    limit_req_zone $binary_remote_addr zone=login:10m rate=5r/m;
    limit_req_zone $binary_remote_addr zone=api:10m rate=60r/m;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }

    # Cache static files
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|pdf|txt|tar|woff|svg|ttf|eot|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
        access_log off;
    }

    # Apply rate limiting to login endpoints
    location /login {
        limit_req zone=login burst=5 nodelay;
        try_files $uri $uri/ /index.php?$query_string;
    }

    # Apply rate limiting to API endpoints
    location /api {
        limit_req zone=api burst=20 nodelay;
        try_files $uri $uri/ /index.php?$query_string;
    }
}
```

### 4. Process Management (Supervisor)

```bash
# Install Supervisor
sudo apt install supervisor

# Create configuration file
sudo nano /etc/supervisor/conf.d/healthhub.conf

```
[program:healthhub-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/healthhub/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/healthhub/storage/logs/worker.log
stopwaitsecs=3600

[program:healthhub-schedule]
process_name=%(program_name)s
command=/bin/bash -c 'while [ true ]; do php /var/www/healthhub/artisan schedule:run --verbose --no-interaction & sleep 60; done'
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/www/healthhub/storage/logs/schedule.log
```

```ini
[program:healthhub-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/healthhub/artisan queue:work redis --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/healthhub/storage/logs/worker.log
stopwaitsecs=3600

[program:healthhub-schedule]
process_name=%(program_name)s
command=/bin/bash -c 'while [ true ]; do php /var/www/healthhub/artisan schedule:run --verbose --no-interaction & sleep 60; done'
autostart=true
autorestart=true
user=www-data
redirect_stderr=true
stdout_logfile=/var/www/healthhub/storage/logs/schedule.log
```

```bash
# Start Supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start all
```

### 5. Monitoring and Logging

#### Log Rotation

```bash
sudo nano /etc/logrotate.d/healthhub
```

```
/var/www/healthhub/storage/logs/*.log {
    daily
    missingok
    rotate 14
    compress
    notifempty
    create 0640 www-data www-data
    sharedscripts
    postrotate
        /usr/bin/supervisorctl restart healthhub-worker:*
    endscript
}
```

#### Health Check Script

```bash
#!/bin/bash
# /var/www/healthhub/scripts/health-check.sh

# Check if application is responding
HTTP_STATUS=$(curl -o /dev/null -s -w "%{http_code}\n" https://your-domain.com)

if [ $HTTP_STATUS -eq 200 ]; then
    echo "Application is healthy"
    exit 0
else
    echo "Application health check failed with status: $HTTP_STATUS"
    # Restart services if needed
    sudo systemctl restart php8.1-fpm
    sudo supervisorctl restart all
    exit 1
fi
```

### 6. Database Backup

```bash
#!/bin/bash
# /var/www/healthhub/scripts/backup.sh

DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/healthhub"
DB_NAME="healthhub_production"
DB_USER="healthhub"
DB_PASS="your_secure_password"

# Create backup directory
mkdir -p $BACKUP_DIR

# Database backup
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/database_$DATE.sql.gz

# File backup
tar -czf $BACKUP_DIR/files_$DATE.tar.gz -C /var/www/healthhub storage public/storage

# Clean old backups (keep last 7 days)
find $BACKUP_DIR -name "*.gz" -type f -mtime +7 -delete

echo "Backup completed: $DATE"
```

Add to crontab:
```bash
0 2 * * * /var/www/healthhub/scripts/backup.sh >> /var/log/healthhub-backup.log 2>&1
```

### 7. SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Obtain certificate
sudo certbot --nginx -d your-domain.com -d www.your-domain.com

# Auto-renewal
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

### 8. Performance Optimization

#### PHP-FPM Configuration

```bash
sudo nano /etc/php/8.1/fpm/pool.d/www.conf
```

```ini
; Pool settings
pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
pm.process_idle_timeout = 10s
pm.max_requests = 500

; PHP settings
php_admin_value[memory_limit] = 256M
php_admin_value[upload_max_filesize] = 10M
php_admin_value[post_max_size] = 10M
php_admin_value[max_execution_time] = 60
```

#### Redis Configuration

```bash
sudo nano /etc/redis/redis.conf
```

```
maxmemory 256mb
maxmemory-policy allkeys-lru
save 900 1
save 300 10
save 60 10000
```

### 9. Security Hardening

```bash
# Firewall setup
sudo ufw allow ssh
sudo ufw allow 'Nginx Full'
sudo ufw enable

# Fail2ban for additional security
sudo apt install fail2ban
sudo cp /etc/fail2ban/jail.conf /etc/fail2ban/jail.local

# Hide server information
echo "server_tokens off;" >> /etc/nginx/nginx.conf
```

### 10. Monitoring Setup

Consider implementing:
- Application monitoring (New Relic, DataDog)
- Server monitoring (Prometheus + Grafana)
- Log aggregation (ELK Stack)
- Uptime monitoring (Pingdom, UptimeRobot)

## Post-Deployment Checklist

- [ ] Application loads correctly
- [ ] Database connections work
- [ ] File uploads function
- [ ] Email sending works
- [ ] SSL certificate is valid
- [ ] All forms submit properly
- [ ] Admin panel is accessible
- [ ] Backup scripts are running
- [ ] Monitoring is configured
- [ ] Performance is acceptable
- [ ] Security headers are present

## Maintenance

- Regular security updates
- Database maintenance
- Log monitoring
- Performance monitoring
- Backup verification
- SSL certificate renewal

## Troubleshooting

### Common Issues

1. **500 Internal Server Error**
   - Check Laravel logs: `tail -f /var/www/healthhub/storage/logs/laravel.log`
   - Check nginx error log: `tail -f /var/log/nginx/error.log`

2. **Database Connection Issues**
   - Verify credentials in `.env`
   - Check MySQL service status

3. **File Permission Issues**
   - Reset permissions: `sudo chown -R www-data:www-data /var/www/healthhub`

4. **Cache Issues**
   - Clear all caches: `php artisan optimize:clear`

For additional support, refer to the Laravel documentation or contact the development team.