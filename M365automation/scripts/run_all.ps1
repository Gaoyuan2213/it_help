# ===========================================
# Microsoft 365 Automation Runner (relative path version)
# Author: Gaoyuan Zhang
# Version: 2025-10-29
# ===========================================

# ---- Detect base folder ----
if ($PSScriptRoot) {
    $basePath = $PSScriptRoot
} else {
    $basePath = Split-Path -Parent (Get-Location).Path
}

# ---- Define log folder (in parent directory) ----
$parentPath = Split-Path -Parent $basePath
$logFolder = Join-Path $parentPath "logs"

# ---- Ensure log folder exists ----
if (-not (Test-Path $logFolder)) {
    Write-Host "🗂️ Creating logs folder at $logFolder ..."
    New-Item -ItemType Directory -Path $logFolder | Out-Null
}

# ---- Define log file path ----
$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
$logPath = Join-Path $logFolder "M365_Automation_Log_$timestamp.txt"

# ---- Start transcript (log everything) ----
Start-Transcript -Path $logPath -Append
Write-Host "🚀 Starting Microsoft 365 Automation Sequence..." -ForegroundColor Cyan
Write-Host "==================================================="

# ============================================================
# 🧩 Step 1: Create Microsoft 365 Users
# ============================================================
if (Test-Path (Join-Path $basePath "1_Create-M365-Users.ps1")) {
    Write-Host "`n🧩 Step 1: Creating Microsoft 365 Users..." -ForegroundColor Yellow
    & (Join-Path $basePath "1_Create-M365-Users.ps1")
} else {
    Write-Host "❌ Script not found: 1_Create-M365-Users.ps1" -ForegroundColor Red
}

# ============================================================
# 🧩 Step 2: Assign Licenses
# ============================================================
if (Test-Path (Join-Path $basePath "2_assign_license.ps1")) {
    Write-Host "`n🧩 Step 2: Assigning Licenses..." -ForegroundColor Yellow
    & (Join-Path $basePath "2_assign_license.ps1")
} else {
    Write-Host "❌ Script not found: 2_assign_license.ps1" -ForegroundColor Red
}

# ============================================================
# 🧩 Step 3: Sync Department Groups & Shared Mailboxes
# ============================================================
if (Test-Path (Join-Path $basePath "3_sync_departments.ps1")) {
    Write-Host "`n🧩 Step 3: Syncing Department Groups & Mailboxes..." -ForegroundColor Yellow
    & (Join-Path $basePath "3_sync_departments.ps1")
} else {
    Write-Host "❌ Script not found: 3_sync_departments.ps1" -ForegroundColor Red
}

# ============================================================
# 🧩 Step 4: Assign Shared Mailbox Permissions
# ============================================================
if (Test-Path (Join-Path $basePath "Assign-SharedMailboxPermissions.ps1")) {
    Write-Host "`n🧩 Step 4: Assigning Shared Mailbox Permissions..." -ForegroundColor Yellow
    & (Join-Path $basePath "Assign-SharedMailboxPermissions.ps1")
} else {
    Write-Host "❌ Script not found: Assign-SharedMailboxPermissions.ps1" -ForegroundColor Red
}

# ============================================================
# 🧩 Step 5: Export Microsoft 365 Comprehensive Report
# ============================================================
if (Test-Path (Join-Path $basePath "export_report.ps1")) {
    Write-Host "`n🧩 Step 5: Exporting Microsoft 365 Report..." -ForegroundColor Yellow
    & (Join-Path $basePath "export_report.ps1")
} else {
    Write-Host "❌ Script not found: export_report.ps1" -ForegroundColor Red
}

# ============================================================
# ✅ Finish
# ============================================================
Write-Host "`n🎯 All automation tasks completed successfully!" -ForegroundColor Green
Stop-Transcript
Write-Host "📄 Log saved to: $logPath"
