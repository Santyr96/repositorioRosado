#!/bin/bash

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

