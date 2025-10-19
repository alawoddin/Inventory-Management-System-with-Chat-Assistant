@echo off
echo ==========================================
echo      Laravel Maintenance Commands
echo ==========================================

echo.
echo Clearing cache...
php artisan cache:clear

echo.
echo Clearing route cache...
php artisan route:clear

echo.
echo Clearing config cache...
php artisan config:clear

echo.
echo Optimizing Laravel...
php artisan optimize

@REM echo.
@REM echo Migrating database...
@REM php artisan migrate

echo.
echo Starting Laravel server...
php artisan serve

echo.
echo All tasks completed!
pause
