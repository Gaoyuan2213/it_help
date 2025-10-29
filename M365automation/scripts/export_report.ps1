# ===========================================
# Microsoft 365 Comprehensive Report Generator
# Author: Gaoyuan Zhang
# Version: 2025-10-29
# ===========================================

# Auto-detect base folder of script
$basePath = Split-Path -Parent $MyInvocation.MyCommand.Definition
$parentPath = Split-Path -Parent $basePath
$logFolder = Join-Path $parentPath "logs"
# Generate timestamped report path inside logs folder
$timestamp = Get-Date -Format "yyyyMMdd_HHmmss"
$reportPath = Join-Path $logFolder "M365_Comprehensive_Report_$timestamp.csv"
Write-Host "📊 Generating Microsoft 365 comprehensive user report..." -ForegroundColor Cyan

# Ensure required modules are loaded
Import-Module Microsoft.Graph.Users -ErrorAction SilentlyContinue
Import-Module Microsoft.Graph.Groups -ErrorAction SilentlyContinue
Import-Module Microsoft.Graph.Identity.DirectoryManagement -ErrorAction SilentlyContinue

# Connect to Microsoft Graph (if not already connected)
$context = Get-MgContext
if (-not $context) {
    Connect-MgGraph -Scopes "User.Read.All","Group.Read.All","Directory.Read.All"
}

# Retrieve all users
$users = Get-MgUser -All | Select-Object Id, DisplayName, UserPrincipalName, Department, JobTitle, AccountEnabled
$report = @()

# Loop through users
foreach ($u in $users) {
    Write-Host "🔍 Processing: $($u.DisplayName)"

    # Check license status
    $licenses = (Get-MgUserLicenseDetail -UserId $u.Id -ErrorAction SilentlyContinue)
    $licenseStatus = if ($licenses) { "Licensed" } else { "Unlicensed" }

    # Get group memberships (department groups, Teams, etc.)
    $groups = (Get-MgUserMemberOf -UserId $u.Id -ErrorAction SilentlyContinue | 
              Where-Object { $_.AdditionalProperties.displayName } | 
              Select-Object -ExpandProperty AdditionalProperties)
    $groupNames = ($groups | ForEach-Object { $_.displayName }) -join ", "

    # Append to report array
    $report += [PSCustomObject]@{
        DisplayName        = $u.DisplayName
        UserPrincipalName  = $u.UserPrincipalName
        Department         = $u.Department
        JobTitle           = $u.JobTitle
        AccountEnabled     = $u.AccountEnabled
        LicenseStatus      = $licenseStatus
        GroupMemberships   = $groupNames
    }
}

# Export the report
$report | Export-Csv -Path $reportPath -NoTypeInformation -Encoding UTF8
Write-Host "✅ Report generated successfully: $reportPath" -ForegroundColor Green

# Optional summary
$licensedCount = ($report | Where-Object { $_.LicenseStatus -eq "Licensed" }).Count
$totalCount = $report.Count
Write-Host "`n📋 Summary:"
Write-Host " - Total Users: $totalCount"
Write-Host " - Licensed Users: $licensedCount"
Write-Host " - Unlicensed Users: $(($totalCount - $licensedCount))"
