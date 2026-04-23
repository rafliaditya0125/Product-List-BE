# Product List Backend API

![PHP](https://img.shields.io/badge/PHP-7.4%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

A lightweight RESTful API built with Vanilla PHP for user authentication and product management. This project demonstrates basic CRUD operations and authentication principles without heavy frameworks.

## 🚀 Features

- **User Authentication**: Secure registration and login using PHP's `password_hash`.
- **Product Management**: Full CRUD (Create, Read, Update, Delete) for products.
- **CLI Tool**: Custom `api` script for handling database migrations and starting the development server.
- **Environment Support**: Configuration managed via `.env` file.
- **Cross-Origin Ready**: Optimized for mobile (Android/iOS) and web client connections.

## 🔗 Frontend Repository

This Backend API is designed to work with the following Frontend application:
- **Product List FE**: [https://github.com/rafliaditya0125/Product-List-FE.git](https://github.com/rafliaditya0125/Product-List-FE.git)

## 📂 Project Structure

```text
Product-List-BE/
├── api                 # CLI entry point (serve, migrate)
├── config/             # Database configuration
├── database/           # SQL migrations
├── public/             # Web entry point (index.php)
├── src/                # Core logic
│   ├── Controllers/    # Request handlers
│   └── Models/         # Database interactions
├── storage/            # Temporary/Uploaded files
└── .env.example        # Environment template
```

## 🛠️ Installation

### 1. Prerequisites
- PHP 7.4 or higher
- MySQL or MariaDB

### 2. Clone the Repository
```bash
git clone https://github.com/rafliaditya0125/Product-List-BE.git
cd Product-List-BE
```

### 3. Environment Configuration
Copy `.env.example` to `.env` and update your database credentials:
```bash
cp .env.example .env
```
Edit `.env`:
```ini
DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=login_api
DB_USER=root
DB_PASS=yourpassword
BASE_URL=http://localhost:8000
```

### 4. Database Setup
The API script will automatically create the database if it doesn't exist. Simply run:
```bash
php api migrate
```

If you need to reset the database (drop and recreate all tables), use:
```bash
php api migrate:fresh
```

## 🏃 Running the API

Start the development server:
```bash
php api serve
```
The API will be available at `http://localhost:8000`.

## 🛰️ API Endpoints

### Authentication
| Method | Endpoint | Description |
| :--- | :--- | :--- |
| `POST` | `/api/register` | Register a new user |
| `POST` | `/api/login` | Authenticate and login |

### Products
| Method | Endpoint | Format | Description |
| :--- | :--- | :--- | :--- |
| `GET` | `/api/products` | - | Get all products |
| `POST` | `/api/products` | `multipart/form-data` | Create a new product (with image) |
| `POST` | `/api/products/update` | `multipart/form-data` | Update existing product |
| `POST` | `/api/products/delete` | `JSON` / `POST` | Delete a product |

> **Note**: For `store` and `update`, please use `multipart/form-data` to handle image uploads. For `delete`, you can use either JSON body or POST field for the `id`.

## 📝 Usage Example

### Create Product (Multipart Form)
- **Field**: `name` (string)
- **Field**: `category` (string)
- **Field**: `stock` (integer)
- **Field**: `price` (integer)
- **File**: `image` (binary)

### Authentication (JSON)
**Request:**
```http
POST /api/login HTTP/1.1
Content-Type: application/json

{
    "username": "rafli",
    "password": "password123"
}
```

**Response:**
```json
{
    "message": "Login successful",
    "user": {
        "username": "rafli"
    }
}
```

## 📜 License
Distribute under the MIT License. See `LICENSE` for more information.
