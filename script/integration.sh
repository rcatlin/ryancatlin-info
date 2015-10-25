#!/usr/bin/env bash

# Start PHP Server
echo "Starting local PHP Server..."
php -S localhost:8000 -t app& &> /dev/null

# Get PID of PHP Server
PHP_PID=$!

echo "Started local PHP server with Process ID: " + $PHP_PID

# Run Test Suite
echo "Running Test Suite..."
vendor/bin/phpunit test/Integration --colors --debug --verbose
echo "Test Suite Finished."

# Kill PHP Server
echo "Stopping PHP Server..."
kill $PHP_PID
echo "Stopped PHP Server."

echo "Done."
