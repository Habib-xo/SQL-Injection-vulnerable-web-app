```markdown
# Vulnerable Web Application Lab (SQL Injection & Auth Bypass)

An intentionally vulnerable web application built with PHP, MySQL, and Docker for educational purposes and hands-on security testing. The lab demonstrates authentication bypass and in-band SQL injection vulnerabilities.

---

## Tech Stack
* **Backend:** PHP (Native)
* **Database:** MySQL
* **Containerization:** Docker & Docker Compose
* **Styling:** CSS

---

## Vulnerabilities Demonstrated

### 1. Authentication Bypass (SQL Injection)
* **File:** `login.php`
* **Vulnerability:** Direct string concatenation of user inputs in the SQL query without sanitation or parameterization.
* **Vulnerable Query:**
  ```sql
  SELECT email, password FROM users WHERE email='$email' AND password='$password';

```

* **Sample Payload:**
```text
admin@gmail.com' OR 1=1 #

```


* **Impact:** Allows an attacker to bypass the login mechanism and access the application without valid credentials.

### 2. Numeric SQL Injection (UNION-based & Error-based)

* **File:** `productpage.php`
* **Parameter:** `productId` (GET parameter)
* **Vulnerable Query:**
```sql
SELECT * FROM products WHERE product_id=$product

```


* **Sample Exploitation:**
* **Error Discovery:** `productpage.php?productId=1'` triggers database error messages.
* **UNION Extraction:** `productpage.php?productId=-1 UNION SELECT 1, email, password, 4 FROM users` extracts sensitive user credentials.



---

## Getting Started

### Prerequisites

* Docker & Docker Compose installed.

### Setup and Run

1. Clone the repository:
```bash
git clone <YOUR-REPO-URL>
cd <REPO-FOLDER>

```


2. Start the containers:
```bash
docker compose up -d --build

```


3. Access the application in your browser:
```text
http://localhost:8080

```



---

## Remediation

To secure the application against SQL Injection, all dynamic queries must use **Prepared Statements (Parameterized Queries)** with PDO or MySQLi:

```php
$stmt =$conn->prepare("SELECT email, password FROM users WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $password);$stmt->execute();

```

---

## Disclaimer

This project is designed for educational and defensive testing purposes only. Do not deploy this code in production environments.

```

```