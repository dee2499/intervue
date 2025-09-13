# Intervue - One-Way Video Interview Platform

A Laravel-based clone of Intervue that enables asynchronous video interviews. This platform allows administrators and reviewers to create interviews with custom questions, candidates to record and upload video responses, and reviewers to evaluate and score submissions.

## Features

- **Role-Based Authentication**: Admin, Reviewer, and Candidate roles with appropriate permissions
- **Interview Management**: Create, edit, and delete interviews with multiple questions
- **Video Recording**: Browser-based video recording using MediaRecorder API
- **File Upload**: Alternative option to upload pre-recorded videos
- **Submission Review**: Watch video responses and provide scores/comments
- **Responsive Design**: Works on desktop, tablet, and mobile devices

## Technology Stack

- **Backend**: Laravel 8+, PHP 8.0+
- **Frontend**: Blade Template, Bootstrap 5, Alpine.js, jQuery
- **Database**: MySQL 5.7+
- **File Storage**: Laravel Storage System
- **Authentication**: Laravel UI

## Installation

### Prerequisites

- PHP 8.0 or higher
- Composer
- MySQL 5.7 or higher
- Web server (Apache, Nginx, etc.)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone https://github.com/dee2499/intervue.git
   cd intervue
   ```
2. **Install dependencies**
   ```bash
    composer install
   ```
3. **Configure environment**
   ```bash
    cp .env.example .env
   ```
   Edit the ```.env``` file and configure your database connection:
   ```bash
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=intervue_db
    DB_USERNAME=root
    DB_PASSWORD=your_password
   ```
4. **Generate application key**
   ```bash
    php artisan key:generate
   ```
5. **Create database**
   ```bash
    Create a MySQL database named intervue_db using your preferred database management tool.
   ```
6. **Run migrations**
   ```bash
    php artisan migrate
   ```
7. **Seed the database**
   ```bash
    php artisan db:seed
   ```
8. **Create storage link**
   ```bash
    php artisan storage:link
   ```
9. **Set file permissions (optional)**
   ```bash
    chmod -R 775 storage
    chmod -R 775 bootstrap/cache
   ```
## Running the Application

### Using Laravel's Built-in Server
```bash
    php artisan serve
   ```
Access the application at ``` http://localhost:8000 ```

### Using Apache/Nginx
Configure your web server to point to the ``` public ``` directory of the project.

### Test Account Credentials

The database seeder creates the following test accounts for testing and demonstration purposes:

- **Admin**  
  [admin@intervue.com](mailto:admin@intervue.com) / `password`

- **Reviewer**  
  [reviewer@intervue.com](mailto:reviewer@intervue.com) / `password`

- **Candidate**  
  [candidate@intervue.com](mailto:candidate@intervue.com) / `password`

> You can change these in the database seeders or directly via the database if needed.

## Usage Guide

### For Admin/Reviewer Users
1. Log in with **admin** or **reviewer** credentials.
2. Navigate to **"My Interviews"** to create new interviews.
3. Add questions with optional time limits.
4. View candidate submissions under the **"Submissions"** tab.
5. Watch submitted videos and provide scores/comments.

### For Candidate Users
1. Log in with **candidate** credentials.
2. View available interviews on the **dashboard**.
3. Click on an interview to begin participation.
4. For each question:
    - Click the **red record button** to start recording.
    - Click the **stop button** to finish.
    - Preview and **re-record** if needed.
    - Submit your response.
    - Alternatively, upload a pre-recorded video file.

---

## Known Limitations

| Limitation | Description |
|------------|-------------|
| **Browser Compatibility** | Best in **Chrome**, **Firefox**, and **Edge**. Limited support in **Safari**. |
| **File Size Limit** | Uploads are limited to **100MB**. |
| **No Real-Time Notifications** | No instant alerts for submissions or reviews. |
| **Limited Admin Panel** | Basic functionality for managing users/interviews. |
| **No Countdown Timer** | Questions with time limits lack a countdown.

---

## 🛠 Troubleshooting

### Video Recording Not Working
- Use **supported browsers** (Chrome, Firefox, Edge).
- Allow **camera and microphone access**.
- Use **HTTPS** or `localhost`.
- Use **file upload** if recording fails.

### File Upload Issues
- Ensure the file is **under 100MB**.
- Accepted formats: `MP4`, `MOV`, `AVI`, `WebM`.
- Check **storage permissions**.
- Update PHP limits in `php.ini`:

```ini
upload_max_filesize = 100M
post_max_size = 100M
```

### Common Issues
- Clear caches if changes aren't reflected:

```upload_max_filesize = 100M
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```
- Check file permissions for storage and bootstrap/cache directories
- Verify database connection settings in ``` .env ``` file

### Ensure permissions:
```
chmod -R 775 storage
chmod -R 775 bootstrap/cache

```
- Verify ``` .env ``` database settings.

| Browser          | Video Recording    | File Upload    |
| ---------------- | ------------------ | -------------- |
| **Chrome 50+**   | ✅ Full support     | ✅ Full support |
| **Firefox 49+**  | ✅ Full support     | ✅ Full support |
| **Edge 79+**     | ✅ Full support     | ✅ Full support |
| **Safari 14.1+** | ⚠️ Limited support | ✅ Full support |

### Security Considerations
- Passwords hashed using Laravel’s encryption.
- CSRF protection on all forms.
- Input validation and sanitization.
- Role-based access control.
- Secure file upload and storage handling.

### License
- This project is open-source and available under the MIT License.
