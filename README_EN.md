# Symfony Docker Project

This project contains a Symfony application prepared for Docker deployment with PHP 8.3, MySQL, and PostgreSQL. The frontend is managed using Webpack Encore and Bootstrap.

## Requirements

- Docker
- Docker Compose (plugin for `docker compose`)
- Node.js and npm (required inside the PHP container for managing frontend dependencies and building assets)

## Host System Prerequisites

For seamless development and project execution on your host system (e.g., Ubuntu in WSL), the following tool versions are recommended:

-   **Operating System:** Ubuntu 22.04 LTS or newer (or another compatible Linux/macOS/Windows with WSL2).
-   **Docker:** Version 24.x.x or newer.
-   **Docker Compose:** Version v2.x.x or newer.
-   **Node.js:** Version 20.10.0 or newer (latest LTS version recommended). *This version is crucial for the correct functioning of `npm` commands, especially if you accidentally run them on the host, or for other projects.*
-   **npm:** Version 10.x.x or newer.

## Project Setup

After cloning the repository, follow these steps:

### 1. Build and Start Containers

This command builds Docker images (if it's the first time) and starts the containers in the background.
```bash
docker compose up -d --build
```

### 2. Install Composer Dependencies

Run Composer inside the PHP container to install all necessary libraries defined in `composer.lock`.
```bash
docker compose exec php composer install
```

### 3. Install Frontend Dependencies (Node.js)

After installing Composer dependencies, you need to install frontend dependencies (e.g., Bootstrap) using npm. **This command is executed inside the PHP container.**
```bash
docker compose exec php npm install
```

### 4. Build Frontend Assets (Webpack Encore)

Use Webpack Encore to build CSS and JavaScript files (including Bootstrap). **These commands are executed inside the PHP container.**

```bash
# For development (with watch mode, which automatically rebuilds on file changes).
# Run this command once at the beginning of your development session in a separate terminal and leave it running.
docker compose exec php npm run dev

# For production (optimized and minified files).
# Run this command once when preparing for deployment.
# docker compose exec php npm run build
```

### 5. Run Doctrine Migrations

If the database is empty or needs schema updates, run the migrations.
```bash
docker compose exec php php bin/console doctrine:migrations:migrate
```

### 6. Clear Symfony Cache

To be safe, clear the Symfony cache.
```bash
docker compose exec php php bin/console cache:clear
```

### 7. Start Symfony Web Server (Development Only)

Start the built-in Symfony web server inside the PHP container. The `--allow-all-ip` parameter is crucial for the server to be accessible from outside the container.
**Warning:** This built-in server is intended **only for development purposes** and is not suitable for a production environment. For production, you should use a robust web server like Nginx or Apache with PHP-FPM.
```bash
docker compose exec php symfony server:start --allow-all-ip
```

The application should now be accessible at **http://localhost:8000/en/mediaitem** (for English) or **http://localhost:8000/cs/mediaitem** (for Czech).

---

## Common Commands

### Start Containers
```bash
docker compose up -d
```

### Stop Containers
```bash
docker compose down
```
**Warning:** The `docker compose down -v` command will also remove database volumes, deleting all data in the database. If you wish to preserve data, use only `docker compose down` or `docker compose stop`/`start`.

### Run Commands in a Container

To run any command (e.g., `php bin/console`) inside the PHP container, use `docker compose exec php ...`:
```bash
# Example: Clear cache
docker compose exec php php bin/console cache:clear

# Example: Run migrations
docker compose exec php php bin/console doctrine:migrations:migrate

# Example: Build frontend assets
docker compose exec php npm run dev

# Example: Start Symfony web server
docker compose exec php symfony server:start --allow-all-ip
```
