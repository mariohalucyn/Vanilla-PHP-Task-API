<p align="center"><a href="https://www.php.net/" target="_blank"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/27/PHP-logo.svg/1920px-PHP-logo.svg.png" width="400" alt="PHP Logo"></a></p>

## Overview
**lightweight and minimalistic RESTful API** built with **pure PHP**, designed for managing to-do lists efficiently. It follows **REST principles**, requires **no frameworks**, and provides endpoints for **creating, reading, updating, and deleting tasks**.

## Features
- Pure PHP with no dependencies
- CRUD operations for tasks
- RESTful API design
- Easy to set up and extend

## Installation

1. **Clone the repository:**
   ```sh
   git clone https://github.com/yourusername/vanilla-php-task-api.git
   cd vanilla-php-task-api
   ```
2. **Set up the database:**
    - Run docker container with MySQL database `docker-compose.yml` included
    - Update `.env` with your database credentials.

3. **Start a local PHP server:**
   ```sh
   php -S localhost:8000
   ```

4. **Test the API:**
   Use Postman, cURL, or any REST client to interact with the API.

## Configuration
Update `.env` to match your database settings:
```dotenv
DB_HOST=127.0.0.1
DB_USER=myuser
DB_PASSWORD=mypassword
DB_NAME=mydatabase
```

## Contributions
Feel free to fork, submit issues, or contribute! PRs are welcome. 😊
