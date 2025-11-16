Set-ExecutionPolicy RemoteSigned -Scope CurrentUser -Force

# --- Configuration ---
$installDir = "C:\php"
$tempDir = "$env:TEMP\php_install"
if (!(Test-Path $tempDir)) { New-Item -ItemType Directory -Path $tempDir | Out-Null }

Write-Host "[1/4] Installing VC++ Redistributable..." -ForegroundColor Cyan
$vc = "$tempDir\vc_redist.x64.exe"
(New-Object Net.WebClient).DownloadFile('https://aka.ms/vs/17/release/vc_redist.x64.exe', $vc)
Start-Process $vc "/install /quiet /norestart" -Wait

Write-Host "[2/4] Downloading PHP 8.2..." -ForegroundColor Cyan
$phpZip = "$tempDir\php.zip"
(New-Object Net.WebClient).DownloadFile('https://windows.php.net/downloads/releases/php-8.2.20-ts-Win32-vs16-x64.zip', $phpZip)

Write-Host "[3/4] Installing PHP to C:\php..." -ForegroundColor Cyan
if (Test-Path $installDir) { Remove-Item -Recurse -Force $installDir }
Expand-Archive -Path $phpZip -DestinationPath $installDir
Copy-Item "$installDir\php.ini-development" "$installDir\php.ini"

# Configure php.ini
$ini = "$installDir\php.ini"
(Get-Content $ini) -replace ';date.timezone =', 'date.timezone = Asia/Kolkata' | Set-Content $ini
@('mbstring','curl','openssl','gd') | ForEach-Object {
    (Get-Content $ini) -replace ";extension=$_", "extension=$_" | Set-Content $ini
}

Write-Host "[4/4] Adding to PATH..." -ForegroundColor Cyan
$userPath = [Environment]::GetEnvironmentVariable("Path", "User")
if ($userPath -notlike "*$installDir*") {
    [Environment]::SetEnvironmentVariable("Path", "$userPath;$installDir", "User")
    $env:Path += ";$installDir"
}

Write-Host "
 PHP 8.2 installed to C:\php!" -ForegroundColor Magenta
Write-Host " Open a NEW PowerShell and run: php --version" -ForegroundColor Green
