# Quote Shipping API

This is a Symfony 6 application for managing shipping quotes.

## Prerequisites

Before you begin, ensure you have the following installed on your machine:

*   **PHP 8.1** or higher
*   **Composer**
*   **Docker** and **Docker Compose** (for the PostgreSQL database)
*   **Symfony CLI** (optional, but recommended)

## Installation & Configuration

### 1. Start the Database (PostgreSQL)

This project uses Docker Compose to run a PostgreSQL database. The configuration matches the default `DATABASE_URL` in the `.env` file.

To start the database container:

```bash
docker compose up -d
```

This will start a PostgreSQL instance exposing port **5416**.

*   **DB Name:** `shipping_api_db`
*   **User:** `shipping_api_user`
*   **Password:** `shipping_api_password`

### 2. Install Project Dependencies

Install the PHP dependencies using Composer:

```bash
composer install
```

### 3. Setup the Database

Once the Docker container is running and dependencies are installed, run the migrations to create the database schema:

```bash
php bin/console doctrine:migrations:migrate
```

Run fixtures to populate the database with test data:

```bash
php bin/console doctrine:fixtures:load
```

## Running the Application

You can start the local development server using the Symfony CLI or the built-in PHP server.

**Using Symfony CLI:**

```bash
symfony server:start
```

**Using PHP built-in server:**

```bash
php -S localhost:8000 -t public
```

The API will be available at `http://localhost:8000`.

## Testing Endpoints

### Generate Token

You can generate a token encrypting user email (user@example.com) and password (password):

```bash
base64_encode('user@example.com:password')
```

### Quote Endpoint

You can test the quote endpoint using `curl` or Postman and replacing the `TOKEN-IN-BASE64` with the token generated in the previous step.

**Endpoint:** `POST /api/quote`

**Example Request:**

```bash
curl -X POST http://localhost:8000/api/quote \
  -H "Content-Type: application/json" \
  -H "X-AUTH-TOKEN: TOKEN-IN-BASE64" \
  -d '{
    "originZipcode": "10001",
    "destinationZipcode": "90210"
  }'
```

**Expected Response:**

```json
{
  "origin": "10001",
  "destination": "90210",
  "results": [
     ...
  ]
}
```

## Observations

Any comment or suggestion is welcome to my email: erik.rmh@gmail.com

