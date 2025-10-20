#!/usr/bin/env bash
set -euo pipefail

# run.sh - start the project with Docker Compose (works with both 'docker compose' and 'docker-compose')
# Usage: ./run.sh [port]
# Examples:
#   ./run.sh            # uses $HOST_HTTP_PORT or default 8080
#   ./run.sh 3000       # maps host port 3000 -> container 80
#   HOST_HTTP_PORT=3000 ./run.sh

cd "$(dirname "$0")"
# Accept optional first arg as host port
if [ "$#" -ge 1 ] && [ -n "${1:-}" ]; then
  HOST_HTTP_PORT="$1"
fi

# Default to 8080 when not provided
: "${HOST_HTTP_PORT:=8080}"
export HOST_HTTP_PORT
echo "Using host HTTP port: ${HOST_HTTP_PORT}"

if command -v docker >/dev/null 2>&1; then
  if docker compose version >/dev/null 2>&1; then
    echo "Using 'docker compose' to start services..."
    docker compose up -d --build
    exit 0
  fi
fi

if command -v docker-compose >/dev/null 2>&1; then
  echo "Using 'docker-compose' to start services..."
  docker-compose up -d --build
  exit 0
fi

cat <<EOF
Error: neither 'docker compose' nor 'docker-compose' is available on this system.
Please install Docker and Docker Compose, or run the compose command manually:

  docker compose up -d --build

or

  docker-compose up -d --build

Run this script from the repository root (/var/www/html).
EOF
exit 2
