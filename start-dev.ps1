# あけみんゴルフ — start the local site
# Usage:  powershell -ExecutionPolicy Bypass -File start-dev.ps1
$env:Path = 'C:\php;' + $env:Path
Set-Location $PSScriptRoot

Write-Host "Starting Akemin Golf at http://127.0.0.1:8000" -ForegroundColor Yellow
Write-Host "Public site : http://127.0.0.1:8000/ja  (and /en, /zh)"
Write-Host "Admin panel : http://127.0.0.1:8000/admin/login"
Write-Host ""

# Use built assets by default (avoids VPN / browser blocking Vite dev server on [::1]:5173).
# For live reload while editing: run `npm run dev` in a second terminal, then refresh.
if (-not (Test-Path "public\build\manifest.json")) { npm run build }
Remove-Item "public\hot" -Force -ErrorAction SilentlyContinue

php artisan serve --host=127.0.0.1 --port=8000
