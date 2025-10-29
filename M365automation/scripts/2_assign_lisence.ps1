# ===========================================
# Microsoft 365 License Assignment Script
# Author: Gaoyuan Zhang
# Date: 2025-10-28
# ===========================================

# Load module and connect
Import-Module Microsoft.Graph.Users.Actions -ErrorAction SilentlyContinue
Connect-MgGraph -Scopes "User.ReadWrite.All","Directory.ReadWrite.All"

# ✅ Get E5 license (your tenant)
$license = (Get-MgSubscribedSku | Where-Object {$_.SkuPartNumber -eq "Office_365_E5_(no_Teams)"}).SkuId

if (-not $license) {
    Write-Host "❌ License not found. Please check your SkuPartNumber." -ForegroundColor Red
    exit
}

Write-Host "✅ License SkuId loaded: $license" -ForegroundColor Cyan

# ✅ Assign license to all users who don’t have it yet
Get-MgUser -All | ForEach-Object {
    $userId = $_.Id
    $userUPN = $_.UserPrincipalName

    # Set UsageLocation (must be a valid ISO country code, e.g., CA, US, GB)
    if (-not $_.UsageLocation) {
        Write-Host "🌎 Setting usage location for $userUPN to 'CA'"
        Update-MgUser -UserId $userId -UsageLocation "CA"
    }

    # Get current license list
    $existing = (Get-MgUserLicenseDetail -UserId $userId).SkuId
    if ($existing -notcontains $license) {
        Write-Host "🔹 Assigning license to $userUPN"
        Set-MgUserLicense -UserId $userId -AddLicenses @{SkuId=$license} -RemoveLicenses @()
    } else {
        Write-Host "✅ $userUPN already has license — skipped" -ForegroundColor Green
    }
}

