@echo off
TITLE Git Auto Commit & Push Bot

echo ==========================================
echo      GIT AUTO COMMIT & PUSH BOT
echo ==========================================
echo.

TZ=Asia/Kabul
TODAY="$(date +'%Y-%m-%d')"
DEFAULT_MSG="Last Update - ${TODAY}"
COMMIT_MSG="${*:-$DEFAULT_MSG}"

echo Adding files...
git add .


# Commit and push to origin main

echo.
echo Committing files...
git commit -m "$COMMIT_MSG"

echo.
echo Pushing to GitHub...
git push origin main

echo.
echo ✅ All changes have been pushed to GitHub!
pause
