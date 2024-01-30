
@echo off

set "projectPath=C:\Users\cnixon\AppData\Roaming\Python\Python311\KENT\Space_booking"

cd /d "%projectPath%"

call venv\Scripts\activate

cd venv\backend

Start /b python.exe app.py

rem Change back to the original directory
@echo off
set "projectPath=C:\Users\cnixon\AppData\Roaming\Python\Python311\KENT\Space_booking"

echo "Setting projectPath to: %projectPath%"

cd /d "%projectPath%\venv\frontend" 
start /b npm start


