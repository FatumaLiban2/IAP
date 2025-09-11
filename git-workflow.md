# Git & GitHub Exercise Workflow

## Project: Alliance Girls High School - Exam Application System

### Part I Implementation: Email Validation and Welcome Notifications

#### Files Created/Modified:
1. **mail.php** - Email handling and validation class
   - Validates email addresses using filter_var() and DNS checks
   - Sends customized welcome emails with verification links
   - Uses PHPMailer for SMTP email delivery

2. **database.php** - Database management class
   - Handles user registration and storage
   - Provides numbered user listing functionality
   - Manages user authentication

3. **Forms/forms.php** - Enhanced form handling
   - Added email validation on signup
   - Integrated welcome email sending
   - Added user authentication for login
   - Added numbered user list display method

4. **dashboard.php** - User dashboard
   - Displays logged-in user information
   - Shows numbered list of registered users
   - Provides logout functionality

5. **verify.php** - Email verification landing page
   - Handles email verification links
   - Provides user feedback on verification

6. **logout.php** - Session management
   - Handles user logout securely

#### Features Implemented:

##### Email Validation:
- Format validation using PHP filter_var()
- Domain existence checking using DNS lookup
- Duplicate email prevention

##### Welcome Email System:
- Customized greeting with user's name
- HTML and plain text versions
- Professional email template matching the screenshot design
- Verification link for account activation
- Error handling for failed email delivery

##### User Management:
- Secure password hashing
- Session-based authentication
- User registration with validation
- Prevention of duplicate usernames/emails

### Part II Implementation: Numbered User List

#### User Display Features:
- Sequential numbering of users (1, 2, 3, etc.)
- User details including username, email, and registration date
- Verification status indicators
- Total user count
- Responsive formatting

#### Database Structure:
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

### Git Workflow Commands:

```bash
# Initialize repository (if not already done)
git init

# Add all project files
git add .

# Commit the initial implementation
git commit -m "Implement email validation and welcome notification system

- Add email validation with DNS checking
- Implement welcome email with customized greeting
- Create numbered user list display
- Add user authentication and session management
- Integrate PHPMailer for email delivery
- Create verification system for user accounts"

# Create and switch to feature branch
git checkout -b feature/email-system

# Add any additional changes
git add .
git commit -m "Refine email templates and user interface"

# Switch back to main branch
git checkout main

# Merge feature branch
git merge feature/email-system

# Add remote repository (replace with actual GitHub repo URL)
git remote add origin https://github.com/FatumaLiban2/IAP.git

# Push to remote repository
git push -u origin main

# Push feature branch as well
git push origin feature/email-system
```

### Testing Instructions:

1. **Email Validation Testing:**
   - Try registering with invalid email formats
   - Test with non-existent domains
   - Verify proper error messages display

2. **Welcome Email Testing:**
   - Complete a registration with valid email
   - Check email inbox for welcome message
   - Verify email content matches requirements
   - Test verification link functionality

3. **User List Testing:**
   - Register multiple users
   - Access dashboard to view numbered list
   - Verify correct numbering and user information

### Project Structure:
```
IAP/
├── index.php (signup page)
├── signin.php (login page)
├── dashboard.php (user dashboard with numbered list)
├── mail.php (email handling class)
├── database.php (database operations)
├── verify.php (email verification)
├── logout.php (session management)
├── conf.php (configuration)
├── ClassAutoLoad.php (autoloader)
├── Forms/forms.php (enhanced form handling)
├── Layouts/layouts.php (improved layouts)
├── Global/classes.php (utility classes)
└── plugins/PHPMailer/ (email library)
```

### Deliverables Completed:

✅ **Part I (4 Marks):**
- Email address validation implemented
- Welcome email notification system created
- Customized greeting in email based on user input

✅ **Part II (4 Marks):**
- Numbered list of registered users implemented
- Users stored and retrieved from database
- Display accessible via dashboard

✅ **Additional Requirements:**
- Git workflow documented
- All changes committed to repository
- Professional code structure and documentation
- Error handling and security measures implemented

### Technical Implementation Details:

- **Email Validation:** Multi-level validation including format and domain verification
- **Database:** PDO-based MySQL integration with prepared statements
- **Security:** Password hashing, input sanitization, session management
- **User Experience:** Responsive design, error messaging, success feedback
- **Email Template:** Professional design matching exercise screenshot requirements
