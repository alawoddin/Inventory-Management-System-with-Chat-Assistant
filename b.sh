@echo off
TITLE Git Auto Commit & Push Bot

echo ==========================================
echo      GIT AUTOMATION TOOL - BY YOU
echo ==========================================
echo.

REM Asking for commit message
set /p commitMsg="Enter your commit message: "

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
