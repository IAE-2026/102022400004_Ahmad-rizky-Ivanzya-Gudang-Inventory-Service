#!/bin/sh
set -e

# Copy env template if .env does not exist
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
fi

# Load DB_CONNECTION from environment or parse from .env
if [ -f .env ]; then
    if [ -z "$DB_CONNECTION" ]; then
        DB_CONNECTION=$(grep -E "^DB_CONNECTION=" .env | cut -d'=' -f2 | tr -d '\r' | tr -d '"' | tr -d "'")
    fi
fi

if [ -z "$DB_CONNECTION" ]; then
    DB_CONNECTION="sqlite"
fi

echo "Detected database connection: $DB_CONNECTION"

if [ "$DB_CONNECTION" = "mysql" ]; then
    echo "MySQL connection detected. Waiting for database to be ready..."
    php -r '
    $connected = false;
    for ($i = 0; $i < 30; $i++) {
        try {
            $host = getenv("DB_HOST") ?: "db";
            $port = getenv("DB_PORT") ?: "3306";
            $dbname = getenv("DB_DATABASE") ?: "db_inventory";
            $username = getenv("DB_USERNAME") ?: "root";
            $password = getenv("DB_PASSWORD") ?: "secret";
            $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
            $connected = true;
            break;
        } catch (Exception $e) {
            echo "Waiting for database connection ($host:$port)... " . $e->getMessage() . "\n";
            sleep(2);
        }
    }
    if (!$connected) {
        echo "Could not connect to database\n";
        exit(1);
    }
    echo "Database connection successful!\n";
    '
elif [ "$DB_CONNECTION" = "sqlite" ]; then
    echo "SQLite connection detected. Ensuring database.sqlite exists..."
    touch database/database.sqlite
    chmod 777 database/database.sqlite || true
    chown -R www-data:www-data database/ || true
fi

# Ensure storage directories exist and are writable
mkdir -p storage/framework/sessions \
         storage/framework/views \
         storage/framework/cache/data \
         bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Ensure APP_KEY is set
APP_KEY=$(grep -E "^APP_KEY=" .env | cut -d'=' -f2 | tr -d '\r')
if [ -z "$APP_KEY" ]; then
    echo "Generating application encryption key..."
    php artisan key:generate --force
fi

# Run migrations and seeders
echo "Running migrations..."
php artisan migrate --force

echo "Running seeders..."
php artisan db:seed --force

# Generate Swagger UI docs
echo "Generating Swagger documentation..."
php artisan l5-swagger:generate

# Clear Laravel cache (ignore errors if cache store is not yet available)
echo "Clearing application cache..."
php artisan cache:clear || true
php artisan config:clear || true
php artisan route:clear || true

echo "Starting Apache..."
exec "$@"
