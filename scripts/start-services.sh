#!/bin/bash

echo "🔄 Starting Basic PHP & MySQL services..."

# Function to wait for a service
wait_for_service() {
    local service_name=$1
    local port=$2
    local max_attempts=20
    local attempt=1
    
    echo "⏳ Waiting for $service_name..."
    
    while [ $attempt -le $max_attempts ]; do
        if nc -z localhost $port 2>/dev/null; then
            echo "✅ $service_name is ready!"
            return 0
        fi
        
        echo "   Attempt $attempt/$max_attempts..."
        sleep 2
        ((attempt++))
    done
    
    echo "❌ $service_name failed to start"
    return 1
}

# Start services
echo "🐳 Starting services..."
cd /var/www/html
docker-compose up -d

# Wait for services
wait_for_service "MySQL" 3306
wait_for_service "Web Server" 80
wait_for_service "phpMyAdmin" 8080

echo ""
echo "📊 Service Status:"
echo "==================="

# Check services
if nc -z localhost 3306 2>/dev/null; then
    echo "✅ MySQL: Running on port 3306"
else
    echo "❌ MySQL: Not responding"
fi

if nc -z localhost 80 2>/dev/null; then
    echo "✅ Web Server: Running on port 80"
else
    echo "❌ Web Server: Not responding"
fi

if nc -z localhost 8080 2>/dev/null; then
    echo "✅ phpMyAdmin: Running on port 8080"
else
    echo "❌ phpMyAdmin: Not responding"
fi

echo ""
echo "🎉 Basic PHP & MySQL environment is ready!"
echo "🌐 Access your application through the forwarded ports"
echo "🗃️ Access phpMyAdmin at port 8080"
