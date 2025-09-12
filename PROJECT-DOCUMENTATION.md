# Alliance Girls High School - Exam Application System

## Git & GitHub Exercise Implementation
**Student:** Omar Fatuma Liban  
**ID:** 192641  
**Course:** IAP 

This project implements a complete user registration and management system with email validation and welcome notifications as specified in the Git & GitHub exercise requirements.

## 🚀 Quick Start

### 1. Setup Database
```bash
# Navigate to project directory
cd c:\Apache24\htdocs\IAP
# Create your database and tables manually using the provided SQL in this documentation.
```

### 2. Configure Email (Optional)
Edit `mail.php` and update SMTP settings with your email credentials:
```php
$this->mail->Username = 'your-email@domain.com';
$this->mail->Password = 'your-app-password';
```

### 3. Access Application
- **Signup:** http://localhost/IAP/index.php
- **Login:** http://localhost/IAP/signin.php
- **Dashboard:** http://localhost/IAP/dashboard.php (after login)

## 📋 Exercise Requirements Completed

### Part I (4 Marks) - Email Validation & Welcome Notifications ✅

#### Features Implemented:
- ✅ **Email Address Validation**
  - Format validation using PHP `filter_var()`
  - Domain existence checking using DNS lookup
  - Duplicate email prevention
  
- ✅ **Welcome Email System**
  - Customized greeting with user's entered name
  - Professional HTML email template (matches exercise screenshot)
  - Verification link functionality
  - Error handling for failed deliveries

### Part II (4 Marks) - Numbered User List ✅

#### Features Implemented:
- ✅ **User Registration Storage**
  - MySQL database with secure password hashing
  - User data persistence across sessions
  
- ✅ **Numbered User Display**
  - Sequential numbering (1, 2, 3, etc.)
  - User details: username, email, registration date
  - Verification status indicators
  - Total user count display

## 🏗️ Project Structure

```
IAP/
├── 📄 index.php              # Main signup page
├── 📄 signin.php             # User login page  
├── 📄 dashboard.php          # User dashboard with numbered list
├── 📄 mail.php               # Email handling & validation class
├── 📄 database.php           # Database operations class
├── 📄 logout.php             # Session management
├── 📄 conf.php               # Application configuration
├── 📄 ClassAutoLoad.php      # Class autoloader
├── 📄 git-workflow.md        # Git workflow documentation
├── 📁 Forms/
│   └── forms.php             # Enhanced form handling
├── 📁 Layouts/
│   └── layouts.php           # Responsive page layouts
├── 📁 Global/
│   └── classes.php           # Utility classes
└── 📁 plugins/
  └── PHPMailer/            # Email library
```

## 🔧 Technical Implementation

### Database Schema
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    verified BOOLEAN DEFAULT FALSE
);
```

### Email Validation Process
1. **Format Check:** Validates email syntax using `filter_var()`
2. **Domain Check:** Verifies domain exists using DNS `checkdnsrr()`
3. **Duplicate Check:** Ensures email not already registered
4. **Welcome Email:** Sends customized greeting on successful registration

### User List Features
- **Automatic Numbering:** Users displayed in registration order (1, 2, 3...)
- **User Details:** Shows username, email, registration timestamp
- **Status Tracking:** Visual indicators for verification status
- **Responsive Design:** Works on desktop and mobile devices

## 🧪 Testing Guide

### 1. Email Validation Testing
```bash
# Test invalid formats
test@invalid-domain-xyz123.com
invalid-email-format
user@

# Test valid formats  
user@gmail.com
test@example.org
```

### 2. Registration Flow Testing
1. Visit signup page: `http://localhost/IAP/`
2. Register with valid email address
3. Check email inbox for welcome message
4. Click verification link in email
5. Login and view dashboard

### 3. User List Verification
1. Register multiple test users
2. Login to dashboard
3. Verify numbered list displays correctly
4. Check user count accuracy

## 📧 Email Template Preview

The welcome email matches the exercise requirements:

```
Subject: Welcome to ICS 2.2! Account Verification Required

Hello [Username],

You requested an account on ICS 2.2

In order to use this account you need to Click Here to complete 
the registration process.

Regards,
Systems Admin
ICS 2.2
```

## 🔐 Security Features

- **Password Hashing:** Uses PHP `password_hash()` with default algorithm
- **SQL Injection Protection:** PDO prepared statements
- **Input Sanitization:** `htmlspecialchars()` for output
- **Session Management:** Secure session handling for authentication
- **Email Validation:** Multi-layer validation prevents invalid registrations

## 🌐 Git Workflow Commands

```bash
# Initialize and commit all changes
git init
git add .
git commit -m "Implement email validation and welcome notification system

- Add email validation with DNS checking  
- Implement welcome email with customized greeting
- Create numbered user list display
- Add user authentication and session management
- Integrate PHPMailer for email delivery
- Create verification system for user accounts"

# Push to GitHub repository
git remote add origin https://github.com/FatumaLiban2/IAP.git
git branch -M main
git push -u origin main
```

## 📊 Exercise Deliverables Status

| Requirement | Status | Implementation |
|------------|--------|----------------|
| Email validation | ✅ Complete | Multi-layer validation (format + DNS) |
| Welcome email with greeting | ✅ Complete | Customized with user's name |
| Numbered user list | ✅ Complete | Sequential numbering in dashboard |
| Database storage | ✅ Complete | MySQL with user management |
| Git workflow documentation | ✅ Complete | Comprehensive git-workflow.md |
| Remote repository | ✅ Ready | GitHub integration configured |

## 🔍 Troubleshooting

### Email Not Sending
1. Update SMTP credentials in `mail.php`
2. Enable "Less secure app access" or use App Passwords
3. Check firewall/antivirus blocking SMTP connections

### Database Connection Issues  
1. Ensure MySQL server is running
2. Verify credentials in `conf.php`
3. Create your database and tables manually using the provided SQL in this documentation

### User List Not Displaying
1. Ensure users are registered in database
2. Check database table exists: `SHOW TABLES;`
3. Verify session is active for dashboard access

## 📞 Support

For technical support or questions about the implementation:
- **Admin Email:** admin@icsccommunity.com
- **Project Repository:** https://github.com/FatumaLiban2/IAP

---

*This implementation fulfills all requirements of the Git & GitHub Exercise with comprehensive email validation, welcome notifications, and numbered user listing functionality.*
