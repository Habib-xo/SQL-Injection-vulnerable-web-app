# SQL Injection Demo Store 🛒⚠️

A deliberately vulnerable PHP + MySQL e-commerce demo, built to demonstrate **classic SQL Injection vulnerabilities** in an authentication flow and a product-lookup endpoint. Built for learning/educational purposes only.

> ⚠️ **Disclaimer:** This application is intentionally insecure. Do **not** deploy it on a public server or reuse this code in a real project. It exists solely to demonstrate how unsanitized user input leads to SQL Injection, and how it can be exploited.

## Stack

- PHP 8.2 (Apache) — `php:8.2-apache`
- MySQL — `mysql:latest`
- Docker + Docker Compose

## Project structure

```
.
├── Dockerfile
├── docker-compose.yml
├── init.sql
├── .gitignore
└── www/
    ├── check.php
    ├── db.php
    ├── login.php
    ├── logout.php
    ├── productpage.php
    ├── storepage.php
    └── style.css
```

## Getting started

1. Clone the repo:
   ```bash
   git clone https://github.com/Habib-xo/SQL-Injection-vulnerable-web-app.git
   cd SQL-Injection-vulnerable-web-app
   ```
2. Make sure all the PHP files are inside a `www/` folder at the project root (this folder is mounted into the container as the web root).
3. Start the containers:
   ```bash
   docker compose up --build
   ```
4. Open the app in your browser at:
   ```
   http://localhost:8080/login.php
   ```
   (there's no `index.php`, so you need to hit `login.php` directly)

## Default (seeded) credentials

| Email | Password |
|---|---|
| `bob@gmail.com` | `secret` |

These come from `init.sql`, loaded automatically into MySQL on first container start.

## Vulnerabilities demonstrated

### 1. SQL Injection in login (`login.php`)

The login query concatenates user input directly into the SQL string with no sanitization or prepared statements:

```php
$sql = "SELECT email,password FROM users where email='$email' and password='$password';";
```

This allows an attacker to bypass authentication entirely, for example by submitting as the email field:

```
' OR 1=1 #
```

with any password — the injected `OR 1=1` makes the `WHERE` clause always true, and `#` comments out the rest of the query, logging the attacker in as the first user in the table without knowing any real credentials.

### 2. SQL Injection in product lookup (`productpage.php`)

The `productId` query parameter is inserted directly into the query:

```php
$sql = "SELECT * FROM products WHERE product_id=$product";
```

Example payload via the URL:

```
productpage.php?productId=0 OR 1=1
```

This returns every row in the `products` table regardless of the actual `product_id`, and — since the query is unsanitized — could be extended (e.g. with `UNION SELECT`) to pull data out of other tables such as `users`.

## The fix 

Both queries should use **prepared statements with bound parameters** (e.g. `mysqli`/`PDO` prepared statements) instead of string concatenation, so user input is never treated as part of the SQL syntax.

