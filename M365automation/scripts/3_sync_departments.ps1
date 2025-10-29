# ---------------------------------------------
# Add users to M365 groups via Graph API
# ---------------------------------------------
Connect-MgGraph -Scopes "Group.ReadWrite.All","User.Read.All","Directory.Read.All"
# Get current script directory
$basePath = Split-Path -Parent $MyInvocation.MyCommand.Definition

# Build the relative path to CSV file
$csvPath = Join-Path $basePath "..\data\neurogroupmembers.csv"
Import-Csv $csvPath | ForEach-Object {
    $groupName = $_.Identity
    $memberEmail = $_.Members

    $group = Get-MgGroup -Filter "displayName eq '$groupName'"
    $user  = Get-MgUser -Filter "userPrincipalName eq '$memberEmail'"

    if ($group -and $user) {
        $uri = "https://graph.microsoft.com/v1.0/groups/$($group.Id)/members/`$ref"
        $body = @{ "@odata.id" = "https://graph.microsoft.com/v1.0/directoryObjects/$($user.Id)" } | ConvertTo-Json
        try {
            Invoke-MgGraphRequest -Method POST -Uri $uri -Body $body -ContentType "application/json"
            Write-Host "✅ Added $memberEmail to $groupName"
        } catch {
           Write-Warning "⚠️ Failed to add ${memberEmail} to ${groupName}: $($_.Exception.Message)"
        }
    } else {
        Write-Warning "⚠️ Group or user not found for: $groupName / $memberEmail"
    }
}

Disconnect-MgGraph
