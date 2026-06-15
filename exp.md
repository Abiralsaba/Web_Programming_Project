# MAMA-KHALU Architecture & Workflow Guide

This document provides an in-depth, detailed look into how the MAMA-KHALU application is structured, how the frontend and backend communicate, how the database is connected, and how the core logic (like the Exam system) functions end-to-end.

---

## 1. System Overview

The application follows a traditional **Client-Server Architecture** using standard PHP and MySQL. 

- **Frontend (Client)**: HTML, CSS, and some JavaScript. This is what the user sees and interacts with in their browser.
- **Backend (Server)**: PHP scripts running on your Apache web server (XAMPP). These scripts process data, handle logic, and speak to the database.
- **Database**: A MySQL database (running on XAMPP) that permanently stores information like users, jobs, exam scores, and applications.

---

## 2. Database Connection

### How it was created
The database was created using a standard SQL script (`schema.sql`). When you run this script in phpMyAdmin or the MySQL command line, it executes commands like `CREATE DATABASE mamakhalu;` and builds out the tables (e.g., `users`, `jobs`, `applications`, `exam_results`) defining the exact columns and data types (like text, integers, dates).

### How it connects to the Backend
To allow the PHP files to talk to the MySQL database, we created a single "bridge" file located at `php with db class/db.php`. 

```php
// db.php
$host = "localhost";
$user = "root";       // Default XAMPP MySQL user
$pass = "";           // Default XAMPP MySQL password (blank)
$db = "mamakhalu";    // The name of our database

// This line creates the actual connection using PHP's built-in MySQLi library
$conn = new mysqli($host, $user, $pass, $db);
```

**How it's used:** Every PHP file that needs database access simply includes `require 'php with db class/db.php';` at the very top. This imports the `$conn` object, giving the file instant access to query the database.

---

## 3. How Frontend and Backend Transfer Data

The frontend and backend primarily communicate via **HTTP Requests**, specifically `GET` and `POST` methods.

> [!TIP]
> **GET Requests:** Used to *request* data from the server. Data is visible in the URL (e.g., `job-detail.php?id=5`).
> **POST Requests:** Used to *send* secure data to the server (like passwords or form submissions). Data is hidden in the HTTP body.

### Example: User Registration
1. **Frontend**: The user fills out the HTML form in `register.php` and clicks "Create Account".
2. **Transfer**: The browser bundles the form data (first name, email, password) and sends an HTTP `POST` request to the server.
3. **Backend Logic**: 
   - PHP receives this data using the global `$_POST` array (e.g., `$_POST['email']`).
   - PHP takes the password and securely scrambles it using `password_hash()`.
   - PHP uses the `$conn` object to write an SQL `INSERT` statement, saving the new user into the MySQL database.
4. **Response**: PHP responds to the browser with a command to redirect (`header("Location: login.php")`), sending the user back to the frontend login page.

---

## 4. Keeping State (How Login Works)

HTTP is "stateless," meaning the server immediately forgets who you are after loading a page. To keep a user logged in, we use **PHP Sessions**.

When a user successfully logs in, PHP creates a secure, temporary file on the server and gives the user's browser a cookie with a unique ID linking to that file.
```php
// Storing data in the session
$_SESSION['user_id'] = $user_id_from_db;
```
Now, on every protected page (like `dashboard.php` or `apply.php`), we run `session_start()`. PHP checks the browser's cookie, finds the session, and verifies if `$_SESSION['user_id']` exists. If it doesn't, it violently kicks the user back to `login.php`.

---

## 5. Full Workflow Example: The Exam System

Here is a detailed, step-by-step breakdown of how the exam system transfers data from the user's click all the way to the database.

### Step A: Triggering the Exam
- The user is on `job-detail.php?id=1` (Frontend). They click the "Take Assessment" link. 
- The link directs them to `exam.php?id=1` (a `GET` request).

### Step B: The Backend Preparation (`exam.php`)
- **Session Check**: The PHP server checks if the user is logged in.
- **Data Fetch**: PHP reads `$_GET['id']` to know the user wants the exam for Job #1. It asks the database, "What is the title for Job ID 1?"
- **Rendering**: PHP loads an array of questions specifically mapped to Job #1. It mixes this PHP data directly into the HTML to render the questions cleanly on the user's screen.

### Step C: Taking the Exam
- The user sees standard HTML radio buttons. They select their answers.
- They click "Submit Exam", sending a `POST` request back to `exam.php`.

### Step D: Backend Processing (The Logic)
When `exam.php` receives the `POST` request, the magic happens:
```php
$score = 0;
// PHP loops through the expected questions
foreach ($questions as $index => $q) {
    // It checks if the user's submitted answer (from $_POST) matches the correct answer
    if (isset($_POST["q_$index"]) && $_POST["q_$index"] == $q['correct']) {
        $score++;
    }
}
// Calculates percentage
$percentage = ($score / count($questions)) * 100;

// Logic: Did they pass?
$passed = $percentage >= 80 ? 1 : 0;
```

### Step E: Database Insertion
PHP immediately saves this exact result into the database using an SQL `INSERT` statement:
```sql
INSERT INTO exam_results (user_id, job_id, score, passed) VALUES (15, 1, 100, 1)
```
*Meaning: User #15 took the exam for Job #1, scored 100%, and passed (True/1).*

### Step F: The Hand-off
PHP temporarily stores the score in the session (`$_SESSION['last_exam_score'] = 100`) and redirects the user to `exam-result.php`. 
- `exam-result.php` reads the score from the session. Since it's a pass, it displays "Congratulations!" and provides a link to `apply.php?id=1`.

### Step G: Final Verification (`apply.php`)
When the user arrives at `apply.php`, they try to upload their resume. Before PHP allows the file upload, it acts as a bouncer:
```php
// PHP asks the database: "Did this specific user actually pass the exam for this specific job?"
SELECT score FROM exam_results WHERE user_id = $user_id AND job_id = $job_id AND passed = 1
```
- If the database returns 0 rows (they didn't pass or skipped the exam), PHP blocks the application.
- If the database confirms the pass, PHP accepts the resume upload, links the verified score to the application, and saves the final application into the `applications` table for the Admin to review.
