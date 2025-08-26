$files = @(
    "pages\dashboard.html",
    "pages\student_management.html", 
    "pages\staff_directory.html",
    "pages\fee_management.html",
    "pages\reports_analytics.html",
    "pages\login.html"
)

$scriptToRemove = '<script type="module" src="https://static.rocket.new/rocket-web.js?_cfg=https%3A%2F%2Fschooladm9526back.builtwithrocket.new&_be=https%3A%2F%2Fapplication.rocket.new&_v=0.1.5"></script>'

Write-Host "🔧 Fixing broken external script in all HTML files..."

foreach ($file in $files) {
    $fullPath = "c:\Users\Owner\Desktop\school management\$file"
    if (Test-Path $fullPath) {
        Write-Host "Fixing $file..."
        $content = Get-Content $fullPath -Raw
        $content = $content.Replace($scriptToRemove, "")
        Set-Content $fullPath $content
        Write-Host "✅ Fixed $file"
    } else {
        Write-Host "⚠️ File not found: $file"
    }
}

Write-Host ""
Write-Host "🎉 All files fixed! The problematic external script has been removed."
Write-Host "This script was preventing JavaScript from working properly."
