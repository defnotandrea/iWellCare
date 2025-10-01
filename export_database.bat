@echo off
echo ========================================
echo iWellCare Database Export Tool
echo ========================================
echo.

REM Check if XAMPP MySQL is running
echo Checking MySQL status...
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo MySQL is running.
    echo.
    echo Choose export method:
    echo 1. Export using mysqldump (Recommended)
    echo 2. Export using Laravel script
    echo 3. Export structure only
    echo 4. Exit
    echo.
    set /p choice="Enter your choice (1-4): "
    
    if "%choice%"=="1" goto mysqldump_export
    if "%choice%"=="2" goto laravel_export
    if "%choice%"=="3" goto structure_export
    if "%choice%"=="4" goto end
    goto invalid_choice
) else (
    echo MySQL is not running.
    echo.
    echo Please start MySQL in XAMPP first:
    echo 1. Open XAMPP Control Panel
    echo 2. Click "Start" next to MySQL
    echo 3. Wait for it to show "Running"
    echo 4. Run this script again
    echo.
    pause
    goto end
)

:mysqldump_export
echo.
echo Exporting database using mysqldump...
echo.
cd /d "C:\xampp\mysql\bin"
mysqldump.exe -u root -p iwellcare > "C:\xampp\htdocs\iWellCare\iwellcare_backup_%date:~-4,4%-%date:~-10,2%-%date:~-7,2%_%time:~0,2%-%time:~3,2%-%time:~6,2%.sql"
if %ERRORLEVEL%==0 (
    echo.
    echo Export completed successfully!
    echo File saved in: C:\xampp\htdocs\iWellCare\
) else (
    echo.
    echo Export failed. Please check your MySQL connection.
)
goto end

:laravel_export
echo.
echo Exporting database using Laravel script...
echo.
cd /d "C:\xampp\htdocs\iWellCare"
php database_export.php
goto end

:structure_export
echo.
echo Using manual structure export...
echo The database structure has been exported to: database_export_manual.sql
echo.
echo To import this structure:
echo 1. Start MySQL in XAMPP
echo 2. Open phpMyAdmin (http://localhost/phpmyadmin)
echo 3. Create database 'iwellcare'
echo 4. Import the database_export_manual.sql file
goto end

:invalid_choice
echo.
echo Invalid choice. Please enter 1, 2, 3, or 4.
goto end

:end
echo.
echo Press any key to exit...
pause >nul
