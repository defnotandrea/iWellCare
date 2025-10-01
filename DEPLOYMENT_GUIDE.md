# iWellCare Deployment Guide

## VPS Hosting Setup (Recommended)

### 1. Server Preparation

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install nginx mysql-server php8.1-fpm php8.1-mysql php8.1-xml php8.1-mbstring php8.1-curl php8.1-zip php8.1-gd php8.1-bcmath unzip git composer -y

# Install Node.js and NPM
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
```

### 2. Database Setup

```bash
# Secure MySQL installation
sudo mysql_secure_installation

# Create database and user
sudo mysql -u root -p
```

```sql
CREATE DATABASE iwellcare;
CREATE USER 'iwellcare_user'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON iwellcare.* TO 'iwellcare_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

### 3. Application Deployment

```bash
# Clone repository
cd /var/www
sudo git clone https://github.com/your-repo/iwellcare.git
sudo chown -R www-data:www-data iwellcare
cd iwellcare

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install
npm run build

# Environment setup
cp env.example .env
sudo nano .env
```

**Configure .env file:**
```env
APP_NAME="iWellCare Healthcare System"
APP_ENV=production
APP_KEY=base64:your_generated_key
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=iwellcare
DB_USERNAME=iwellcare_user
DB_PASSWORD=your_secure_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

```bash
# Generate application key
php artisan key:generate

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --force

# Set up storage
php artisan storage:link

# Set proper permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### 4. Nginx Configuration

Create `/etc/nginx/sites-available/iwellcare`:

```nginx
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/iwellcare/public;

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
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

```bash
# Enable site
sudo ln -s /etc/nginx/sites-available/iwellcare /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

### 5. SSL Certificate (Let's Encrypt)

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Obtain SSL certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal
sudo crontab -e
# Add: 0 12 * * * /usr/bin/certbot renew --quiet
```

### 6. Security Hardening

```bash
# Configure firewall
sudo ufw allow 'Nginx Full'
sudo ufw allow OpenSSH
sudo ufw enable

# Set up fail2ban
sudo apt install fail2ban
sudo systemctl enable fail2ban
```

### 7. Performance Optimization

```bash
# Configure OPcache
sudo nano /etc/php/8.1/fpm/conf.d/10-opcache.ini
```

Add:
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=2
opcache.fast_shutdown=1
```

```bash
# Restart PHP-FPM
sudo systemctl restart php8.1-fpm

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 8. Automated Backups

Create `/root/backup.sh`:

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups"
DB_NAME="iwellcare"
APP_DIR="/var/www/iwellcare"

# Database backup
mysqldump -u iwellcare_user -p'your_password' $DB_NAME > $BACKUP_DIR/db_backup_$DATE.sql

# Application backup
tar -czf $BACKUP_DIR/app_backup_$DATE.tar.gz $APP_DIR

# Keep only last 7 days of backups
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
```

```bash
chmod +x /root/backup.sh
# Add to crontab: 0 2 * * * /root/backup.sh
```

## Cloud Hosting Options

### **3. Platform as a Service (PaaS)**

**Recommended Providers:**
- **Heroku** - Easy deployment, good for development
- **Railway** - Simple deployment, good performance
- **Render** - Free tier available, easy setup

**Heroku Setup:**
```bash
# Install Heroku CLI
curl https://cli-assets.heroku.com/install.sh | sh

# Login and create app
heroku login
heroku create your-iwellcare-app

# Add MySQL addon
heroku addons:create jawsdb:kitefin

# Deploy
git push heroku main

# Run migrations
heroku run php artisan migrate --force
heroku run php artisan db:seed --force
```

### **4. Container Deployment (Docker)**

Create `Dockerfile`:

```dockerfile
FROM php:8.1-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# Set permissions
RUN chown -R www-data:www-data /var/www

EXPOSE 9000
CMD ["php-fpm"]
```

Create `docker-compose.yml`:

```yaml
version: '3'
services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: iwellcare_app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - ./:/var/www
    networks:
      - iwellcare

  nginx:
    image: nginx:alpine
    container_name: iwellcare_nginx
    restart: unless-stopped
    ports:
      - "80:80"
    volumes:
      - ./:/var/www
      - ./docker/nginx/conf.d:/etc/nginx/conf.d
    networks:
      - iwellcare

  db:
    image: mysql:8.0
    container_name: iwellcare_db
    restart: unless-stopped
    environment:
      MYSQL_DATABASE: iwellcare
      MYSQL_ROOT_PASSWORD: your_root_password
      MYSQL_PASSWORD: your_password
      MYSQL_USER: iwellcare_user
    volumes:
      - dbdata:/var/lib/mysql
    networks:
      - iwellcare

networks:
  iwellcare:
    driver: bridge

volumes:
  dbdata:
```

## Environment-Specific Configurations

### **Production Environment**

1. **Security Settings:**
   - Set `APP_DEBUG=false`
   - Use strong database passwords
   - Enable HTTPS only
   - Configure proper file permissions

2. **Performance:**
   - Enable OPcache
   - Use Redis for caching (optional)
   - Configure CDN for static assets
   - Set up monitoring (New Relic, DataDog)

3. **Monitoring:**
   - Set up log monitoring
   - Configure error reporting
   - Monitor server resources
   - Set up uptime monitoring

### **Staging Environment**

- Mirror production setup
- Use separate database
- Enable debugging for testing
- Set up automated testing

## Post-Deployment Checklist

- [ ] SSL certificate installed
- [ ] Database migrations completed
- [ ] File permissions set correctly
- [ ] Storage link created
- [ ] Cache cleared and optimized
- [ ] Email configuration tested
- [ ] Backup system configured
- [ ] Monitoring set up
- [ ] Security headers configured
- [ ] Performance optimized

## Troubleshooting Common Issues

### **500 Internal Server Error**
- Check file permissions
- Verify .env configuration
- Check PHP error logs
- Ensure storage directory is writable

### **Database Connection Issues**
- Verify database credentials
- Check MySQL service status
- Ensure database exists
- Test connection manually

### **Performance Issues**
- Enable OPcache
- Optimize database queries
- Use Redis for caching
- Configure CDN

## Cost Estimates

### **Monthly Costs:**
- **Shared Hosting**: $5-15/month
- **VPS Hosting**: $5-20/month
- **Cloud Hosting**: $10-50/month
- **Managed Hosting**: $20-100/month

### **Additional Costs:**
- Domain name: $10-15/year
- SSL certificate: Free (Let's Encrypt)
- Backup storage: $5-20/month
- Monitoring: $10-50/month

## Support and Maintenance

### **Regular Maintenance Tasks:**
- Weekly security updates
- Monthly backup verification
- Quarterly performance review
- Annual SSL certificate renewal

### **Monitoring Tools:**
- Uptime monitoring (UptimeRobot)
- Error tracking (Sentry)
- Performance monitoring (New Relic)
- Security scanning (Sucuri)

This deployment guide provides comprehensive instructions for hosting your iWellCare healthcare system across different hosting environments. Choose the option that best fits your budget, technical expertise, and requirements. 