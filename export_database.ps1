# iWellCare Database Export Script (PowerShell)
# This script provides multiple methods to export your database

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "iWellCare Database Export Tool" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Check if MySQL is running
Write-Host "Checking MySQL status..." -ForegroundColor Yellow
$mysqlProcess = Get-Process -Name "mysqld" -ErrorAction SilentlyContinue

if ($mysqlProcess) {
    Write-Host "MySQL is running." -ForegroundColor Green
    Write-Host ""
    Write-Host "Choose export method:" -ForegroundColor White
    Write-Host "1. Export using mysqldump (Recommended)" -ForegroundColor White
    Write-Host "2. Export using Laravel script" -ForegroundColor White
    Write-Host "3. Export structure only" -ForegroundColor White
    Write-Host "4. Create multiple export formats" -ForegroundColor White
    Write-Host "5. Exit" -ForegroundColor White
    Write-Host ""
    
    $choice = Read-Host "Enter your choice (1-5)"
    
    switch ($choice) {
        "1" { 
            Write-Host "`nExporting database using mysqldump..." -ForegroundColor Yellow
            $timestamp = Get-Date -Format "yyyy-MM-dd_HH-mm-ss"
            $outputFile = "C:\xampp\htdocs\iWellCare\iwellcare_backup_$timestamp.sql"
            
            try {
                & "C:\xampp\mysql\bin\mysqldump.exe" -u root -p iwellcare > $outputFile
                Write-Host "Export completed successfully!" -ForegroundColor Green
                Write-Host "File saved as: $outputFile" -ForegroundColor Green
                Write-Host "File size: $((Get-Item $outputFile).Length) bytes" -ForegroundColor Green
            }
            catch {
                Write-Host "Export failed: $($_.Exception.Message)" -ForegroundColor Red
            }
        }
        "2" { 
            Write-Host "`nExporting database using Laravel script..." -ForegroundColor Yellow
            Set-Location "C:\xampp\htdocs\iWellCare"
            php database_export.php
        }
        "3" { 
            Write-Host "`nUsing manual structure export..." -ForegroundColor Yellow
            Write-Host "The database structure has been exported to: database_export_manual.sql" -ForegroundColor Green
            Write-Host "`nTo import this structure:" -ForegroundColor White
            Write-Host "1. Start MySQL in XAMPP" -ForegroundColor White
            Write-Host "2. Open phpMyAdmin (http://localhost/phpmyadmin)" -ForegroundColor White
            Write-Host "3. Create database 'iwellcare'" -ForegroundColor White
            Write-Host "4. Import the database_export_manual.sql file" -ForegroundColor White
        }
        "4" {
            Write-Host "`nCreating multiple export formats..." -ForegroundColor Yellow
            
            # SQL Export
            $timestamp = Get-Date -Format "yyyy-MM-dd_HH-mm-ss"
            $sqlFile = "C:\xampp\htdocs\iWellCare\iwellcare_backup_$timestamp.sql"
            & "C:\xampp\mysql\bin\mysqldump.exe" -u root -p iwellcare > $sqlFile
            
            # CSV Export for each table
            Write-Host "Creating CSV exports..." -ForegroundColor Yellow
            $csvDir = "C:\xampp\htdocs\iWellCare\csv_export_$timestamp"
            New-Item -ItemType Directory -Path $csvDir -Force | Out-Null
            
            # Get list of tables
            $tables = @("users", "patients", "doctors", "appointments", "consultations", "prescriptions", "medications", "prescription_medications", "medical_records", "invoices", "inventory", "sessions", "notifications", "otp_codes", "failed_jobs", "migrations")
            
            foreach ($table in $tables) {
                try {
                    $csvFile = "$csvDir\$table.csv"
                    & "C:\xampp\mysql\bin\mysql.exe" -u root -p -e "SELECT * FROM iwellcare.$table" --batch --raw > $csvFile
                    Write-Host "Exported $table to CSV" -ForegroundColor Green
                }
                catch {
                    Write-Host "Failed to export $table to CSV" -ForegroundColor Red
                }
            }
            
            Write-Host "`nMultiple format export completed!" -ForegroundColor Green
            Write-Host "SQL file: $sqlFile" -ForegroundColor Green
            Write-Host "CSV files: $csvDir" -ForegroundColor Green
        }
        "5" { 
            Write-Host "Exiting..." -ForegroundColor Yellow
            exit
        }
        default { 
            Write-Host "`nInvalid choice. Please enter 1, 2, 3, 4, or 5." -ForegroundColor Red
        }
    }
} else {
    Write-Host "MySQL is not running." -ForegroundColor Red
    Write-Host ""
    Write-Host "Please start MySQL in XAMPP first:" -ForegroundColor White
    Write-Host "1. Open XAMPP Control Panel" -ForegroundColor White
    Write-Host "2. Click 'Start' next to MySQL" -ForegroundColor White
    Write-Host "3. Wait for it to show 'Running'" -ForegroundColor White
    Write-Host "4. Run this script again" -ForegroundColor White
    Write-Host ""
    Write-Host "Alternatively, you can use the manual structure export:" -ForegroundColor Yellow
    Write-Host "The database structure has been exported to: database_export_manual.sql" -ForegroundColor Green
}

Write-Host ""
Write-Host "Press any key to exit..." -ForegroundColor Gray
$null = $Host.UI.RawUI.ReadKey("NoEcho,IncludeKeyDown")
