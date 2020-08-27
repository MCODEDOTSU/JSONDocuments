#INSTALLATION

## Requirements

- DB: MySQL 5.7 and above
- PHP: 7.2 and above

## Installation

- <code>cp .env.example .env</code>
- edit .env: **DB_CONNECTION**, **DB_HOST**, **DB_PORT**, **DB_DATABASE**, **DB_USERNAME**, **DB_PASSWORD**
- <code>composer update</code>
- <code>php artisan migrate</code>
- <code>php artisan key:generate</code>
- <code>php artisan storage:link</code>

## Permissions

<code>chmod -R 777 storage</code>

## TESTS

- <code>cp .env .env.testing</code>
- edit .env.testing: **DB_CONNECTION**, **DB_HOST**, **DB_PORT**, **DB_DATABASE**, **DB_USERNAME**, **DB_PASSWORD**
- <code>php artisan test</code>