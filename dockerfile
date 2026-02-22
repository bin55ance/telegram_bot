FROM php:8.2-cli

# Copy all files into container
WORKDIR /app
COPY . .

# Install mysqli extension for database
RUN docker-php-ext-install mysqli

# Run PHP built-in server
CMD ["php", "-S", "0.0.0.0:10000", "bot.php"]
