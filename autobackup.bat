@echo off
For /f "tokens=2-4 delims=/ " %%a in ('date /t') do (set mydate=%%c-%%a-%%b)
For /f "tokens=1-2 delims=/:" %%a in ("%TIME%") do (set mytime=%%a%%b)

SET backupdir=C:\Projets\Tasker

C:\xampp\mysql\bin\mysqldump.exe -uroot tasker > %backupdir%\sql_backups\%database%_%mydate%_%mytime%_.sql