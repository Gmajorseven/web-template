# web-template

A modern teacher management system built with PHP and MySQL, featuring a clean interface for managing teacher records with full CRUD operations.

## Features

- 📋 **View Teachers** - Display all teacher records in a formatted table
- ➕ **Add Teachers** - Add new teacher information to the database
- ✏️ **Edit Teachers** - Update existing teacher records
- 🗑️ **Delete Teachers** - Remove teacher records from the system
- 🎨 **Modern UI** - Beautiful, responsive design with smooth animations
- 🐳 **Docker Ready** - Easy deployment with Docker containers

## Prerequisites

- PHP 8.4+ with PDO and MySQL extensions
- MySQL 5.7+ or MariaDB
- Docker & Docker Compose (optional, for containerized deployment)
- Web server (Apache/Nginx) or PHP built-in server

## Installation

### Option 1: Using Docker (Recommended)

1. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd web-template
   ```

2. **Start Docker containers**
   ```bash
   docker-compose up -d
   ```
   This will start:
   - MySQL server on port 3306
   - phpMyAdmin on http://localhost:8080

3. **Import the database**
   ```bash
   docker exec -i mysql_db mysql -u root -prootpassword < database.sql
   ```

4. **Start PHP development server**
   ```bash
   php -S localhost:8000
   ```

5. **Access the application**
   - Open http://localhost:8000 in your browser
   - phpMyAdmin: http://localhost:8080

### Option 2: Local Installation

1. **Install PHP and extensions**
   
   On Fedora/RHEL:
   ```bash
   sudo dnf install php php-pdo php-mysqlnd -y
   ```
   
   On Ubuntu/Debian:
   ```bash
   sudo apt install php php-pdo php-mysql -y
   ```

2. **Install MySQL**
   ```bash
   sudo dnf install mysql-server -y
   sudo systemctl start mysqld
   sudo systemctl enable mysqld
   ```

3. **Clone the repository**
   ```bash
   git clone <your-repo-url>
   cd web-template
   ```

4. **Import database**
   ```bash
   mysql -u root -p < database.sql
   ```

5. **Configure database connection**
   Edit `db_connect.php` and update credentials:
   ```php
   $host = '127.0.0.1';
   $port = '3306';
   $dbname = 'DB_teacher';
   $username = 'root';
   $password = 'your_password';
   ```

6. **Start PHP server**
   ```bash
   php -S localhost:8000
   ```

7. **Access the application**
   Open http://localhost:8000 in your browser

## Database Structure

The application uses a `Teachers` table with the following schema:

```sql
CREATE TABLE Teachers (
  teacher_id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  surname VARCHAR(50) NOT NULL,
  room VARCHAR(10),
  mobile VARCHAR(15) UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE
);
```

## Project Structure

```
web-template/
├── index.html          # Main page with navigation
├── page1.php           # View teachers
├── page2.php           # Add teacher
├── page3.php           # Edit teacher
├── page4.php           # Delete teacher
├── db_connect.php      # Database connection
├── database.sql        # Database schema and sample data
├── welcome.html        # Welcome page
└── README.md           # This file
```

## Usage

1. **View All Teachers**: Click "Link 1: แสดงข้อมูล" to see all teacher records
2. **Add New Teacher**: Click "Link 2: เพิ่มข้อมูล" and fill in the form
3. **Edit Teacher**: Click "Link 3: แก้ไขข้อมูล" to modify existing records
4. **Delete Teacher**: Click "Link 4: ลบข้อมูล" to remove teachers

## Docker Configuration

If using Docker, the default configuration is:

- **MySQL Container**: `mysql_db`
  - Port: 3306
  - Root password: `rootpassword`
  - Database: `DB_teacher`

- **phpMyAdmin Container**: `phpmyadmin`
  - Port: 8080
  - Access: http://localhost:8080

## Troubleshooting

### Connection Error: "No such file or directory"
- Use `127.0.0.1` instead of `localhost` in `db_connect.php`
- Ensure MySQL is running: `docker ps` or `systemctl status mysqld`

### PDO Extension Not Found
```bash
# Fedora/RHEL
sudo dnf install php-pdo php-mysqlnd

# Ubuntu/Debian
sudo apt install php-pdo php-mysql
```

### Database Not Found
Import the database schema:
```bash
mysql -u root -p < database.sql
```

## Technologies Used

- **Frontend**: HTML5, CSS3 (Modern Grid Layout)
- **Backend**: PHP 8.4
- **Database**: MySQL 8.0
- **Containerization**: Docker & Docker Compose
- **Database Management**: phpMyAdmin

## License

MIT License

## Contributing

Feel free to submit issues and enhancement requests!
