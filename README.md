## Dev deploy

```bash

# Clone repo
git clone https://github.com/bazylys/abz-test-case

# Go to folder
cd abz-test-case

# Configure settings file
cp .env.example .env
mcedit .env

# Install dependencies
docker run --rm \
-v "$(pwd)":/opt \
-w /opt \
laravelsail/php81-composer:latest \
composer install

# Start docker 
vendor/bin/sail up
## [Swap to new term] ##

# Install dependencies
vendor/bin/sail npm install

# Build Front
vendor/bin/sail npm run dev
## [Swap to new term] ##

# Migrate db & generate key
vendor/bin/sail artisan migrate --seed
vendor/bin/sail artisan key:generate
vendor/bin/sail artisan queue:work
```

