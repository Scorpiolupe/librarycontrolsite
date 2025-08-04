# 📚 Library Control Site

This project is a **web-based library management system**. Users can view, borrow, and return books. The admin panel allows for book and user management.

## 🚀 Features

* 📖 View book list
* 👤 User registration and login
* 🗕️ Borrow and return books
* 🔐 Admin login
* 🛠️ Add, delete, and edit books (Admin Panel)

## 🧰 Technologies Used

* PHP (with SQLSRV driver)
* HTML / CSS / JavaScript
* Microsoft SQL Server
* Bootstrap

## 🛠️ Installation Steps

1. Clone this repository:

   ```bash
   git clone https://github.com/Scorpiolupe/librarycontrolsite.git
   ```

2. Move the project files to your web server's root directory:
   Example: `C:\xampp\htdocs\librarycontrolsite`

3. Install the [Microsoft Drivers for PHP for SQL Server](https://learn.microsoft.com/en-us/sql/connect/php/download-drivers-php-sql-server) and make sure to enable the driver in your `php.ini` file:

   ```
   extension=php_sqlsrv.dll
   ```

4. Using SQL Server Management Studio, create a database named `library` and import the `.sql` script that contains the necessary tables.

5. Configure the SQLSRV connection settings in `config.php` (or your connection file) like this:

   ```php
   $serverName = "localhost";
   $connectionOptions = array(
       "Database" => "library",
       "Uid" => "your_username",
       "PWD" => "your_password"
   );

   $conn = sqlsrv_connect($serverName, $connectionOptions);

   if (!$conn) {
       die(print_r(sqlsrv_errors(), true));
   }
   ```

6. Open the project in your browser:

   ```
   http://localhost/librarycontrolsite
   ```

## 🔐 Default Login Credentials

**Admin:**

* Username: `admin`
* Password: `admin123`

**User:**

* You can register a new user through the system.
