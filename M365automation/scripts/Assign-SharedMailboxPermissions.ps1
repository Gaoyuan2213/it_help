# ===========================================
# Assign Shared Mailbox Permissions
# Author: Gaoyuan Zhang
# Version: 2025-10-29
# ===========================================

# CSV format:
# Identity,Members
# Admin Department,Alice_Admin@gaoyuanzhang.onmicrosoft.com
# IT Department,Eddie_IT@gaoyuanzhang.onmicrosoft.com
# Employee Department,ava@gaoyuanzhang.onmicrosoft.com

# Define base path
$basePath = Split-Path -Parent $MyInvocation.MyCommand.Definition
$csvPath = Join-Path $basePath "..\data\shared_mailbox_access.csv"

# Connect to Exchange Online
Write-Host "🔗 Connecting to Exchange Online..." -ForegroundColor Cyan
Connect-ExchangeOnline -UserPrincipalName GaoyuanZhang@gaoyuanzhang.onmicrosoft.com

# Import CSV
if (!(Test-Path $csvPath)) {
    Write-Error "❌ CSV file not found at $csvPath"
    exit
}

$csvData = Import-Csv -Path $csvPath

# Map departments to shared mailboxes
$mailboxMap = @{
    "Admin Department"     = "admin@gaoyuanzhang.onmicrosoft.com"
    "IT Department"        = "it@gaoyuanzhang.onmicrosoft.com"
    "Employee Department"  = "shared-employee@gaoyuanzhang.onmicrosoft.com"
}

# Loop through all users
foreach ($row in $csvData) {
    $groupName = $row.Identity.Trim()
    $userEmail = $row.Members.Trim()

    if ($mailboxMap.ContainsKey($groupName)) {
        $mailbox = $mailboxMap[$groupName]

        try {
            # Add full access
            Add-MailboxPermission -Identity $mailbox -User $userEmail -AccessRights FullAccess -AutoMapping $false -ErrorAction Stop
            Write-Host "✅ Added FULL ACCESS for $userEmail to $mailbox" -ForegroundColor Green

            # Add send-as permission
            Add-RecipientPermission -Identity $mailbox -Trustee $userEmail -AccessRights SendAs -Confirm:$false -ErrorAction Stop
            Write-Host "✅ Added SEND AS for $userEmail to $mailbox" -ForegroundColor Green
        }
        catch {
            Write-Warning ("⚠️ Failed to assign permissions for {0} on {1}: {2}" -f $userEmail, $mailbox, $_.Exception.Message)
        }
    }
    else {
        Write-Warning ("⚠️ Unknown department '{0}' for user {1}" -f $groupName, $userEmail)
    }
}

# Disconnect
Disconnect-ExchangeOnline -Confirm:$false
Write-Host "`n🎯 Shared mailbox permissions assignment complete!" -ForegroundColor Cyan

