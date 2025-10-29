# 🧱 Enterprise IT Infrastructure Lab
A dual-project portfolio demonstrating enterprise IT systems administration and help desk operations.

## 1️⃣ Active Directory Domain Lab
Windows Server 2022 domain setup including AD DS, DNS, Group Policy, and department-based file permissions.
- Configured OU structure and GPO for centralized wallpaper and access control.
- Implemented file sharing and remote desktop management.
- Developed a PowerShell automation script to create users, assign department groups, and integrate with GPO-based drive mapping.
📄 [Full Report](./AD_Lab_Environment/AD_Lab_Report.pdf)

## 2️⃣ Microsoft 365 Automation Lab

PowerShell automation toolkit for managing Microsoft 365 users, licenses, groups, and shared mailboxes.  
Developed by **Gaoyuan Zhang** as part of a co-op portfolio and IT systems lab.

## 🚀 Features
- Bulk user creation from CSV
- Automatic license assignment
- Department-based group sync
- Shared mailbox permission automation
- Comprehensive export report

## ⚙️ Quick Start
```powershell
cd .\scripts
.
un_all.ps1
```
Logs and reports are saved in the `/logs` folder.

## 3️⃣ IT Help Desk Systemgit
Web-based ticket management system simulating real-world IT workflows.
- Role-based login (Employee, IT Staff, Admin)
- Ticket submission, assignment, and status tracking
🔗 [Live Demo](http://ithelpproject.kesug.com)
💻 [Source Code](./IT_HelpDesk_System/)