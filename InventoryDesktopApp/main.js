// main.js
const { app, BrowserWindow, dialog } = require('electron');
const path = require('path');
const { spawn } = require('child_process');
const fs = require('fs');

let phpProcess = null;
const LARAVEL_REL = path.join(__dirname, '..', 'laravel'); // change if needed
const PHP_REL = path.join(__dirname, '..', 'php-win64', 'php.exe'); // path to php

function startPhpServer() {
  // Choose port and check it is free; for simplicity we use 8000.
  const port = 8000;
  const publicDir = path.join(LARAVEL_REL, 'public');

  // Ensure DB exists for sqlite (if used)
  const dbPath = path.join(LARAVEL_REL, 'database', 'database.sqlite');
  if (!fs.existsSync(dbPath)) {
    // create file
    fs.mkdirSync(path.dirname(dbPath), { recursive: true });
    fs.closeSync(fs.openSync(dbPath, 'w'));
  }

  phpProcess = spawn(PHP_REL, ['-S', `127.0.0.1:${port}`, '-t', publicDir], {
    cwd: LARAVEL_REL,
    stdio: 'ignore'
  });

  phpProcess.on('error', (err) => {
    dialog.showErrorBox('PHP server error', String(err));
  });

  // Optional: wait until server responds - simple delay
  return new Promise((resolve) => setTimeout(() => resolve(port), 1200));
}

function stopPhpServer() {
  if (phpProcess) {
    try { phpProcess.kill(); } catch (e) {}
    phpProcess = null;
  }
}

function createWindow(url) {
  const win = new BrowserWindow({
    width: 1200,
    height: 800,
    webPreferences: { contextIsolation: true }
  });
  win.loadURL(url);
}

app.whenReady().then(async () => {
  try {
    const port = await startPhpServer();
    createWindow(`http://127.0.0.1:${port}`);
  } catch (e) {
    dialog.showErrorBox('Start failed', String(e));
  }
});

app.on('before-quit', () => stopPhpServer());
app.on('window-all-closed', () => { if (process.platform !== 'darwin') app.quit(); });
