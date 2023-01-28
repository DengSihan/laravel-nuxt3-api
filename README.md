# The API of Nuxt3 SSR Example with Authorization

The web app is [here](https://github.com/DengSihan/laravel-nuxt3-web).
Online demo is [here](https://laravel-nuxt3.ruti.page/).

## Features
- Auth via Laravel Sanctum
- Laravel Socialite (github)
- 100% test coverage

## Installation
    
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

## Deploy

Don't forget to add the Nuxt3 Front-end Server IPs to `TRUSTED_PROXIES` in `.env`

Nginx config
```nginx
# before (Laravel default configs)
location / {
    try_files $uri $uri/ /index.php?$query_string;
}

# after
proxy_set_header X-Forwarded-For-Nuxt $remote_addr;
location ~* ^/(api|broadcasting|storage)/ {
    try_files $uri $uri/ /index.php?$query_string;
}
location / {
    proxy_pass http://127.0.0.1:3000; # Nuxt3 Front-end Server
}
```







