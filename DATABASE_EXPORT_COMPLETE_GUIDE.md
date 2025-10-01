# iWellCare Database Export - Complete Guide

## 🎯 Quick Start

### Option 1: Automated Export (Recommended)
```bash
# Run the automated export script
export_database.bat
# OR
powershell -ExecutionPolicy Bypass -File export_database.ps1
```

### Option 2: Manual Export
1. Start XAMPP MySQL service
2. Open phpMyAdmin: http://localhost/phpmyadmin
3. Select `iwellcare` database
4. Click "Export" tab
5. Choose "Custom" export method
6. Download SQL file

---

## 📋 Database Information

- **Database Name**: `iwellcare`
- **Host**: `127.0.0.1` (localhost)
- **Port**: `3306`
- **Username**: `root`
- **Password**: (empty)
- **Character Set**: `utf8mb4`
- **Collation**: `utf8mb4_unicode_ci`

---

## 🗂️ Database Structure

### Core Tables (15 tables)

#### User Management
- `users` - System users (admins, doctors, patients)
- `patients` - Patient profiles and medical information
- `doctors` - Doctor profiles and credentials

#### Medical Records
- `appointments` - Appointment scheduling
- `consultations` - Medical consultations
- `prescriptions` - Prescription records
- `prescription_medications` - Prescription details
- `medical_records` - Patient medical history
- `medications` - Medication database

#### Billing & Inventory
- `invoices` - Invoice management
- `inventory` - Medical inventory

#### System Tables
- `sessions` - User sessions
- `notifications` - System notifications
- `otp_codes` - OTP verification codes
- `failed_jobs` - Failed job queue
- `migrations` - Laravel migration tracking

---

## 🚀 Export Methods

### Method 1: Automated Scripts

#### Windows Batch Script
```cmd
# Double-click or run in Command Prompt
export_database.bat
```

#### PowerShell Script
```powershell
# Run in PowerShell
powershell -ExecutionPolicy Bypass -File export_database.ps1
```

### Method 2: Command Line (mysqldump)

#### Start MySQL First
1. Open XAMPP Control Panel
2. Start MySQL service
3. Wait for "Running" status

#### Export Command
```cmd
cd C:\xampp\mysql\bin
mysqldump.exe -u root -p iwellcare > C:\xampp\htdocs\iWellCare\iwellcare_backup.sql
```

#### Advanced Export Options
```cmd
# Export with structure and data
mysqldump.exe -u root -p --routines --triggers iwellcare > iwellcare_complete.sql

# Export structure only
mysqldump.exe -u root -p --no-data iwellcare > iwellcare_structure.sql

# Export data only
mysqldump.exe -u root -p --no-create-info iwellcare > iwellcare_data.sql

# Export specific tables
mysqldump.exe -u root -p iwellcare users patients doctors > iwellcare_core_tables.sql
```

### Method 3: phpMyAdmin (Web Interface)

#### Step-by-Step Process
1. **Access phpMyAdmin**
   - URL: http://localhost/phpmyadmin
   - Username: `root`
   - Password: (leave empty)

2. **Select Database**
   - Click on `iwellcare` in left sidebar

3. **Export Settings**
   - Click "Export" tab
   - Choose "Custom" method
   - Format: SQL

4. **Export Options**
   ```
   Object creation options:
   ✅ Add DROP TABLE / VIEW / PROCEDURE / FUNCTION / EVENT / TRIGGER statement
   ✅ Add CREATE PROCEDURE / FUNCTION / EVENT / TRIGGER statement
   ✅ Add CREATE TABLE statement
   
   Data creation options:
   ✅ Add INSERT INTO statement
   ✅ Complete inserts
   
   Data dump options:
   ✅ Add locks before inserting data
   ✅ Disable foreign key checks
   ```

5. **Download**
   - Click "Go" to download SQL file

### Method 4: Laravel Artisan (When MySQL is Running)

```cmd
cd C:\xampp\htdocs\iWellCare
php database_export.php
```

---

## 📁 Export Files Created

### 1. Complete Database Export
- **File**: `iwellcare_backup_YYYY-MM-DD_HH-MM-SS.sql`
- **Contains**: Full database structure + data
- **Size**: Varies based on data volume

### 2. Structure Only Export
- **File**: `database_export_manual.sql`
- **Contains**: Database structure only (no data)
- **Size**: ~15-20 KB

### 3. CSV Exports (if using PowerShell script)
- **Directory**: `csv_export_YYYY-MM-DD_HH-MM-SS/`
- **Files**: One CSV per table
- **Format**: Comma-separated values

---

## 🔧 Troubleshooting

### MySQL Not Running
**Error**: `No connection could be made because the target machine actively refused it`

**Solutions**:
1. **Start XAMPP MySQL**:
   - Open XAMPP Control Panel
   - Click "Start" next to MySQL
   - Wait for "Running" status

2. **Check Port Conflicts**:
   ```cmd
   netstat -ano | findstr :3306
   ```
   If port 3306 is in use, change MySQL port in `C:\xampp\mysql\bin\my.ini`

3. **Reset MySQL Service**:
   - Stop MySQL in XAMPP
   - Rename `C:\xampp\mysql\data\mysql` to `mysql_backup`
   - Restart XAMPP

### Permission Issues
**Error**: `Access denied for user 'root'@'localhost'`

**Solutions**:
1. **Check Password**: Ensure password is empty (default XAMPP setup)
2. **Reset MySQL Password**:
   ```cmd
   cd C:\xampp\mysql\bin
   mysql.exe -u root
   ALTER USER 'root'@'localhost' IDENTIFIED BY '';
   FLUSH PRIVILEGES;
   ```

### File Permission Issues
**Error**: `Permission denied` when creating export files

**Solutions**:
1. **Run as Administrator**: Right-click Command Prompt → "Run as administrator"
2. **Change Directory**: Export to a writable location
3. **Check Antivirus**: Temporarily disable real-time protection

---

## 📊 Export Verification

### Check Export Success
1. **File Size**: Should be > 0 bytes
2. **File Content**: Open with text editor, should contain SQL statements
3. **Table Count**: Verify all 15 tables are included

### Test Import (Optional)
1. Create test database: `CREATE DATABASE iwellcare_test;`
2. Import export file to test database
3. Verify data integrity

---

## 🔄 Import Instructions

### Using phpMyAdmin
1. Open phpMyAdmin
2. Create new database: `iwellcare_restored`
3. Select the new database
4. Click "Import" tab
5. Choose your export file
6. Click "Go"

### Using Command Line
```cmd
cd C:\xampp\mysql\bin
mysql.exe -u root -p iwellcare_restored < C:\path\to\your\export\file.sql
```

---

## 📈 Best Practices

### Regular Backups
1. **Daily**: Export data only
2. **Weekly**: Full database export
3. **Before Updates**: Always backup before system changes

### File Naming Convention
```
iwellcare_backup_YYYY-MM-DD_HH-MM-SS.sql
iwellcare_structure_YYYY-MM-DD.sql
iwellcare_data_YYYY-MM-DD.sql
```

### Storage Locations
- **Local**: `C:\xampp\htdocs\iWellCare\backups\`
- **Cloud**: Google Drive, OneDrive, Dropbox
- **External**: USB drive, external hard drive

### Security Considerations
- **Encrypt**: Use password protection for sensitive exports
- **Access Control**: Limit access to backup files
- **Retention**: Keep backups for at least 30 days

---

## 🆘 Emergency Recovery

### If Database is Corrupted
1. **Stop MySQL** in XAMPP
2. **Rename current data folder**: `iwellcare` → `iwellcare_corrupted`
3. **Restore from backup**: Copy backup files to data directory
4. **Start MySQL** and test system
5. **Run migrations** if needed: `php artisan migrate`

### If Export Files are Missing
1. **Check Recycle Bin**: Files might have been deleted
2. **Search System**: Use Windows search for `.sql` files
3. **Check Antivirus Quarantine**: Files might be quarantined
4. **Use Data Recovery Tools**: Recuva, PhotoRec, etc.

---

## 📞 Support

If you encounter issues not covered in this guide:

1. **Check Logs**: `C:\xampp\htdocs\iWellCare\storage\logs\`
2. **XAMPP Logs**: `C:\xampp\mysql\data\*.err`
3. **Windows Event Viewer**: Check for MySQL-related errors
4. **Community Support**: Laravel forums, Stack Overflow

---

## 📝 Quick Reference Commands

```cmd
# Start MySQL
# (Use XAMPP Control Panel)

# Export full database
mysqldump.exe -u root -p iwellcare > backup.sql

# Export structure only
mysqldump.exe -u root -p --no-data iwellcare > structure.sql

# Export data only
mysqldump.exe -u root -p --no-create-info iwellcare > data.sql

# Import database
mysql.exe -u root -p iwellcare < backup.sql

# Check MySQL status
tasklist | findstr mysqld

# Check port usage
netstat -ano | findstr :3306
```

---

**Last Updated**: January 15, 2025  
**Version**: 1.0  
**Compatible with**: iWellCare v1.0, XAMPP 8.0+, MySQL 8.0+
