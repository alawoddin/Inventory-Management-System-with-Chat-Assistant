@echo off
TITLE Git Auto Commit & Push Bot

echo ==========================================
echo      GIT AUTO COMMIT & PUSH BOT
echo ==========================================
echo.

REM Get today's date only
for /f "tokens=1-4 delims=/ " %%a in ('date /t') do (set mydate=%%a-%%b-%%c)

REM Commit message is ONLY today's date
set commitMsg=%mydate%

echo Using commit message: "%commitMsg%"
echo.

echo Adding files...
git add .

echo.
echo Committing files...
git commit -m "%commitMsg%"

echo.
echo Pushing to GitHub...
git push origin main

echo.
echo ✅ All changes have been pushed to GitHub!
pause
