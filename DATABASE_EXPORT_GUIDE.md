# iWellCare Database Export Guide

## Current Database Configuration
- **Database Name**: `iwellcare`
- **Host**: `127.0.0.1` (localhost)
- **Port**: `3306`
- **Username**: `root`
- **Password**: (empty)

## Method 1: Using XAMPP phpMyAdmin (Recommended)

### Step 1: Start XAMPP Services
1. Open XAMPP Control Panel
2. Start **Apache** and **MySQL** services
3. Wait for both to show "Running" status

### Step 2: Access phpMyAdmin
1. Open your web browser
2. Go to: `http://localhost/phpmyadmin`
3. Login with:
   - Username: `root`
   - Password: (leave empty)

### Step 3: Export Database
1. Click on `iwellcare` database in the left sidebar
2. Click the **"Export"** tab at the top
3. Choose export method:
   - **Quick**: For basic export
   - **Custom**: For advanced options (recommended)
4. In Custom export:
   - **Format**: SQL
   - **Tables**: Select all tables
   - **Data creation options**: Check "Add DROP TABLE / VIEW / PROCEDURE / FUNCTION / EVENT / TRIGGER statement"
   - **Add statements**: Check "Add CREATE PROCEDURE / FUNCTION / EVENT / TRIGGER statement"
5. Click **"Go"** to download the SQL file

## Method 2: Using Command Line (mysqldump)

### Step 1: Open Command Prompt as Administrator
1. Press `Win + R`
2. Type `cmd` and press `Ctrl + Shift + Enter`

### Step 2: Navigate to XAMPP MySQL bin directory
```cmd
cd C:\xampp\mysql\bin
```

### Step 3: Export Database
```cmd
mysqldump.exe -u root -p iwellcare > C:\xampp\htdocs\iWellCare\iwellcare_backup.sql
```
- Press Enter when prompted for password (leave empty)

### Step 4: Verify Export
```cmd
dir C:\xampp\htdocs\iWellCare\iwellcare_backup.sql
```

## Method 3: Using Laravel Artisan (When MySQL is Running)

### Step 1: Start MySQL in XAMPP
1. Open XAMPP Control Panel
2. Start MySQL service

### Step 2: Run Export Script
```cmd
cd C:\xampp\htdocs\iWellCare
php database_export.php
```

## Method 4: Manual Table Export (If Database is Corrupted)

If you can't access the database normally, you can export individual tables:

### Step 1: Access MySQL Data Directory
Navigate to: `C:\xampp\mysql\data\iwellcare\`

### Step 2: Copy Database Files
1. Copy the entire `iwellcare` folder
2. This contains all your database files (.frm, .ibd files)
3. Store this as a backup

## Troubleshooting MySQL Connection Issues

### Fix 1: Port Conflict
```cmd
netstat -ano | findstr :3306
```
If port 3306 is in use, change MySQL port in `C:\xampp\mysql\bin\my.ini`

### Fix 2: Service Conflicts
1. Open Services (`services.msc`)
2. Stop any MySQL services
3. Set them to Manual startup

### Fix 3: Reset MySQL
1. Stop MySQL in XAMPP
2. Rename `C:\xampp\mysql\data\mysql` to `mysql_backup`
3. Restart XAMPP
4. Let it recreate MySQL data directory

## Database Structure Overview

Based on your migrations, your database contains these main tables:

### Core Tables
- `users` - System users (doctors, admins, patients)
- `patients` - Patient information
- `doctors` - Doctor profiles and credentials
- `appointments` - Appointment scheduling
- `consultations` - Medical consultations
- `prescriptions` - Prescription records
- `medical_records` - Patient medical history

### Billing & Inventory
- `invoices` - Invoice management
- `billings` - Billing records
- `inventory` - Medical inventory
- `medications` - Medication database
- `prescription_medications` - Prescription details

### System Tables
- `migrations` - Laravel migration tracking
- `sessions` - User sessions
- `notifications` - System notifications
- `otp_codes` - OTP verification codes
- `failed_jobs` - Failed job queue

## Recommended Export Settings

For a complete backup, use these settings in phpMyAdmin:

### Custom Export Settings
- **Format**: SQL
- **Tables**: All tables
- **Object creation options**:
  - ✅ Add DROP TABLE / VIEW / PROCEDURE / FUNCTION / EVENT / TRIGGER statement
  - ✅ Add CREATE PROCEDURE / FUNCTION / EVENT / TRIGGER statement
  - ✅ Add CREATE TABLE statement
- **Data creation options**:
  - ✅ Add INSERT INTO statement
  - ✅ Complete inserts
- **Data dump options**:
  - ✅ Add locks before inserting data
  - ✅ Disable foreign key checks
- **Output**:
  - ✅ Save output to a file
  - ✅ Compression: None (for compatibility)

## File Naming Convention

Use this naming convention for your exports:
```
iwellcare_backup_YYYY-MM-DD_HH-MM-SS.sql
```

Example: `iwellcare_backup_2024-01-15_14-30-25.sql`

## Verification Steps

After export, verify your backup:

1. **Check file size**: Should be > 0 bytes
2. **Open file**: Should contain SQL statements
3. **Test import**: Try importing to a test database
4. **Count tables**: Verify all expected tables are included

## Next Steps

1. **Fix MySQL issue** using the troubleshooting steps above
2. **Export database** using Method 1 (phpMyAdmin)
3. **Test the export** by importing it to a test database
4. **Store backup safely** in multiple locations
5. **Schedule regular backups** for future maintenance

## Emergency Recovery

If you need to recover from a corrupted database:

1. **Stop MySQL** in XAMPP
2. **Rename current data folder**: `iwellcare` → `iwellcare_corrupted`
3. **Restore from backup**: Copy backup files to data directory
4. **Start MySQL** and test the system
5. **Run migrations** if needed: `php artisan migrate`

---

**Note**: Always test your backups before relying on them for production data recovery.
