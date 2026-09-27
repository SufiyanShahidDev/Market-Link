# MarketLink

MarketLink is a farmer-to-customer marketplace web application built with a custom PHP MVC architecture. It connects local farmers with customers, allowing customers to browse and pre-order fresh produce for pickup, while farmers manage their listings and orders, and admins moderate the entire platform.

---

## Table of Contents

- [Features](#features)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [Installation Guide](#installation-guide)
- [Demo Credentials](#demo-credentials)
- [Clean URLs & Routing](#clean-urls--routing)
- [Repository](#repository)

---

## Features

- **Customer** – Browse products/markets/farmers, add to cart, place pre-orders, track order status, leave reviews, manage favorites and profile.
- **Farmer** – Manage product listings (with moderation), track and update incoming orders, respond to reviews, manage schedule and profile.
- **Admin** – Approve/suspend farmers, moderate products and reviews, manage markets and categories, send role-based notifications, and generate/download sales reports.
- Role-based authentication and access control (Admin / Farmer / Customer).
- Clean, human-readable URLs with legacy `.php` URL support.

---

## Technology Stack

| Layer        | Technology |
|--------------|------------|
| **Frontend** | HTML5, CSS3, JavaScript (ES6+), Bootstrap (latest) |
| **Backend**  | PHP 8.2 / 8.4 / latest — custom MVC architecture |
| **Database** | MySQL |

---

## Project Structure

```
MarketLink/
├── app/
│   ├── Controllers/        # Public, Farmer, Admin controllers
│   │   └── Actions/        # Form/action handlers (POST endpoints)
│   ├── Models/              # Category, Market, Order, Product, User
│   ├── Support/             # Bootstrap, router, auth, db, config, helpers
│   └── Views/
│       ├── admin/
│       ├── farmer/
│       ├── public/
│       └── layouts/
├── assets/                  # css, js, img
├── Database/
│   └── marketlink.sql       # Full schema + demo seed data
├── routes/
│   └── web.php               # Route definitions
├── uploads/                  # User-uploaded product/profile images
├── index.php                 # Front controller
└── .htaccess                 # URL rewriting
```

---

## Installation Guide

### Prerequisites

- [XAMPP](https://www.apachefriends.org/) (or WAMP/MAMP/LAMP) with **PHP 8.2+**
- MySQL / MariaDB
- A web browser

### Step-by-Step Setup

1. **Get the project**
   ```bash
   git clone https://github.com/SufiyanShahidDev/Market-Link.git
   ```
   Or download and extract the ZIP file.

2. **Place the project in your server's document root**
   Copy the `MarketLink` folder into:
   ```
   C:\xampp\htdocs\MarketLink        (Windows)
   /Applications/XAMPP/htdocs/MarketLink   (macOS)
   /opt/lampp/htdocs/MarketLink       (Linux)
   ```

3. **Start Apache and MySQL**
   Open the XAMPP Control Panel and start both **Apache** and **MySQL**.

4. **Create the database**
   - Open [phpMyAdmin](http://localhost/phpmyadmin).
   - Create a new database named `marketlink` (or import directly, which auto-creates it).
   - Import the file `Database/marketlink.sql`.

5. **Configure database credentials**
   Open `app/Support/config.php` and confirm/update the following to match your MySQL setup:
   ```php
   const DB_HOST = 'localhost';
   const DB_NAME = 'marketlink';
   const DB_USER = 'root';
   const DB_PASS = '';
   ```

6. **Set folder permissions**
   Ensure the `uploads/` directory is writable by the web server (required for product/profile image uploads).

7. **Launch the application**
   Open your browser and go to:
   ```
   http://localhost/MarketLink/
   ```

8. **Log in**
   Use any of the [demo credentials](#demo-credentials) below to explore the Admin, Farmer, and Customer roles.

---

## Demo Credentials

| Role        | Email                      | Password       |
|-------------|-----------------------------|----------------|
| Admin       | admin@example.com          | Admin@123      |
| Farmer      | farmer@example.com         | Farmer@123     |
| Farmer 2    | farmer2@example.com        | Farmer@123     |
| Customer    | customer@example.com       | Customer@123   |
| Customer 2  | customer2@example.com      | Customer@123   |

> These accounts are pre-seeded in `Database/marketlink.sql` for demo and testing purposes.

---

## Clean URLs & Routing

The application uses a front controller (`index.php`) with routes defined in `routes/web.php`, and `.htaccess` rewrites all requests through the MVC router.

Examples of clean URLs: `/home`, `/products`, `/markets`, `/farmers`, `/login`, `/register`, `/cart`, `/orders`, `/admin/reports`, `/farmer/orders`.

Legacy `.php` URLs (e.g. `/products.php`) remain supported for backward compatibility.

---

## Repository

GitHub: [https://github.com/SufiyanShahidDev/Market-Link](https://github.com/SufiyanShahidDev/Market-Link)

---

## License

This project is provided as-is for educational and demonstration purposes.
