#!/bin/bash

echo "🚀 Setting up Basic PHP & MySQL environment..."

# Create necessary directories
mkdir -p /app/logs

# Set proper permissions (webdevops image uses 'application' user)
sudo chown -R application:application /app
sudo chmod -R 755 /app

echo "✅ Basic setup completed!"
echo "🌐 Your PHP & MySQL environment is ready!"
