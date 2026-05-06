Set WshShell = CreateObject("WScript.Shell")
WshShell.Run "cmd /c cd /d C:\sispendik && php artisan schedule:run", 0, False