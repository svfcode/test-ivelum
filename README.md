# ivelum

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