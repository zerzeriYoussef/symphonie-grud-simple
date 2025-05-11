# Symfony Article Management System

A Symfony 7.2 application for managing articles and categories.

## Project Structure

- **Controllers**: Handles HTTP requests and responses
- **Entities**: Data models for Articles and Categories
- **Forms**: Form handling for data entry
- **Repositories**: Database access layer

## Requirements

- PHP 8.2 or higher
- Composer
- Docker (optional, for containerized development)

## Installation

### Option 1: Local Installation

1. Clone the repository
2. Install dependencies:
   ```
   cd tp6_symfony-main
   composer install
   ```
3. Configure your database in `.env`
4. Create the database:
   ```
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```
5. Start the development server:
   ```
   php bin/console server:start
   ```

### Option 2: Docker Installation

1. Start the Docker containers:
   ```
   docker-compose up -d
   ```
2. Access the application at http://localhost:8000

## Features

- Article management (create, read, update, delete)
- Category management
- Article categorization
- Article price range search (find articles with prices between two values)

## License

Proprietary - All rights reserved 