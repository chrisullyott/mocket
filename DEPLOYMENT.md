# LEMP setup on Amazon Linux 2 AMI

https://aws.amazon.com/amazon-linux-2/

## Install packages

(Or: $ sudo su root)

```
$ sudo yum update -y
$ sudo yum install git
$ sudo amazon-linux-extras install nginx1.12 -y
$ sudo amazon-linux-extras install php7.4 -y
```

## Install PHP extensions required for Laravel

Check installed modules with:
```
$ php -m
```

Install missing ones:
```
$ sudo yum install php-bcmath
$ sudo yum install php-mbstring
$ sudo yum install php-xml
```

## Configure nginx

$ sudo nano /etc/nginx/conf.d/default.conf

```
server {
    listen 80;
    server_name _;
    
    index index.php index.html;
    root /var/www/src/public;
    
    error_log  /var/log/nginx/error.log;
    access_log /var/log/nginx/access.log;
    
    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        try_files $uri =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass php-fpm;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }

    error_page 404 /index.php;
}

```

## Configure PHP-FPM

(Find file with: $ sudo find / -name "www.conf")

```
listen = /var/run/php-fpm/php-fpm.sock
listen.owner = nginx
listen.group = nginx
listen.mode = 0664
user = nginx
group = nginx
```

## Install Composer

```
$ sudo su root
$ php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
$ mkdir -p /ec2-user/.composer
$ chmod -R ugo+rw /ec2-user/.composer
```

## Add services to the boot sequence

```
$ sudo chkconfig nginx on
$ sudo chkconfig php-fpm on
```

## Start nginx and PHP-FPM services

```
$ sudo service nginx start
$ sudo service php-fpm start
```

## Define environment variables

In a file `/var/www/.env`, define Laravel's environment variables (see `.env.example`).

## Install application

```
#!/bin/bash

REPO="https://github.com/chrisullyott/mocket.git"
WWW="/var/www";
DIR="src";

echo "Starting installation";

cd $WWW;

# Setup Git for sparse checkout
if [ ! -d ".git" ]; then
  git init;
  git remote add origin -f $REPO;
  git config core.sparseCheckout true;
  echo $DIR >> ".git/info/sparse-checkout";
fi

# Pull from repository
git pull origin master;

# Copy environment variables
if [ -a ".env" ]; then
  cp ".env" "${WWW}/${DIR}/.env";
fi

# Run Composer
cd "${WWW}/${DIR}";
composer install;

# Apply permissions on all files
chown -R nginx:nginx "${WWW}/${DIR}";

echo "Finished installation.";
```


## Resources

- [Install PHP and NGINX on Amazon Linux AMI](https://gist.github.com/nrollr/56e933e6040820aae84f82621be16670)
- [Amazon Linux AMI Install Linux, nginx, MySQL, PHP (LEMP)
](https://www.cyberciti.biz/faq/amazon-linux-ami-install-linux-nginx-mysql-php-lemp/)

