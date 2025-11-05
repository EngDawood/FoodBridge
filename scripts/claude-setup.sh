#!/bin/bash

# Claude Code Setup Script for FoodBridge Laravel Application
# This script runs automatically when starting a Claude Code session on the web

set -e  # Exit on error

echo "🚀 Starting FoodBridge environment setup..."

# Only run in remote (web) environments
# For local development, dependencies should be installed manually
if [ "$CLAUDE_CODE_REMOTE" != "true" ]; then
  echo "ℹ️  Skipping setup (running locally)"
  exit 0
fi

# Install PHP Composer dependencies
echo "📦 Installing Composer dependencies..."
if [ -f "composer.json" ]; then
  composer install --no-interaction --prefer-dist --optimize-autoloader
else
  echo "⚠️  composer.json not found, skipping Composer install"
fi

# Install Node.js dependencies
echo "📦 Installing npm dependencies..."
if [ -f "package.json" ]; then
  npm install --no-audit --no-fund
else
  echo "⚠️  package.json not found, skipping npm install"
fi

# Setup .env file if it doesn't exist
if [ ! -f ".env" ]; then
  if [ -f ".env.example" ]; then
    echo "📝 Creating .env file from .env.example..."
    cp .env.example .env

    # Generate application key
    echo "🔑 Generating application key..."
    php artisan key:generate --ansi
  else
    echo "⚠️  .env.example not found, skipping .env creation"
  fi
else
  echo "✅ .env file already exists"
fi

# Clear Laravel caches
echo "🧹 Clearing Laravel caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan view:clear || true
php artisan route:clear || true

echo "✅ FoodBridge environment setup completed successfully!"
exit 0
