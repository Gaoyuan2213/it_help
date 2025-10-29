# ===========================================
# Microsoft 365 Bulk User Creation Script
# Author: Gaoyuan Zhang
# Date: 2025-10-28
# ===========================================

# ✅ Import required module and connect to Microsoft Graph
Import-Module Microsoft.Graph.Users -ErrorAction SilentlyContinue
Connect-MgGraph -Scopes "User.ReadWrite.All"

# ✅ Path to the CSV file containing user data
# Get current script folder (not current working directory)
$basePath = Split-Path -Parent $MyInvocation.MyCommand.Definition

# Build relative path to CSV file (one folder up, then into "data")
$csvPath = Join-Path $basePath "..\data\new_users.csv"

# ✅ Import user data from the CSV file
$users = Import-Csv -Path $csvPath

# ✅ Loop through each record and create the user
foreach ($u in $users) {
    Write-Host "Creating user: $($u.DisplayName) <$($u.UserPrincipalName)>"

    try {
        # Create the user account in Microsoft 365
        New-MgUser `
            -AccountEnabled:$true `
            -DisplayName $u.DisplayName `
            -UserPrincipalName $u.UserPrincipalName `
            -MailNickname $u.MailNickname `
            -PasswordProfile @{
                ForceChangePasswordNextSignIn = $true
                Password = $u.Password
            } `
            -Department $u.Department `
            -JobTitle $u.JobTitle

        Write-Host "✅ Successfully created: $($u.DisplayName)" -ForegroundColor Green
    }
    catch {
        Write-Host "❌ Failed to create: $($u.DisplayName) — $($_.Exception.Message)" -ForegroundColor Red
    }
}

# ✅ Display all users after creation
Write-Host "`nUser creation complete. Current tenant users:" -ForegroundColor Cyan
Get-MgUser | Select DisplayName, UserPrincipalName, Department, JobTitle
