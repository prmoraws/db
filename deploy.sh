#!/bin/bash

echo "🔄 Limpando views, config e cache..."
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear 

echo "⚙️ Otimizando aplicação..."
php artisan optimize

echo "📦 Executando build do frontend com npm..."
npm run build
composer run dev

echo "✅ Processo concluído."
