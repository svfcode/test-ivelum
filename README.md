# ivelum

## Simple review (if already installed composer and php)
0) Prepare composer
```bash
composer install
```

1) For start run local server with default php tool
```bash
php -S localhost:8080
```

2) Go to browser on http://localhost:8080

3) For run test
```bash
./vendor/bin/phpunit tests
```

## Review with docker
1) Start docker
```bash
docker-compose up -d --build
```

1.1) Prepare composer
```bash
docker exec svfcode_test-php composer install
```

2) Go to browser on http://localhost:8080

3) Test
```bash
docker exec svfcode_test-php ./vendor/bin/phpunit tests
```