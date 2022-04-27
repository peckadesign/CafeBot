FROM registry.peckadesign.com/peckadesign/php:7.4-dev

COPY . .

RUN composer install
