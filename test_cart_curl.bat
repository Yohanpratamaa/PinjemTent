@echo off
echo Testing Cart Update API
echo.

REM Get CSRF token first
for /f "tokens=*" %%a in ('curl -s -c cookies.txt http://127.0.0.1:8000/login ^| findstr "csrf-token"') do set csrf_line=%%a
for /f "tokens=3 delims=<>""" %%b in ("%csrf_line%") do set csrf_token=%%b

echo CSRF Token: %csrf_token%
echo.

REM Test cart update
curl -X PUT http://127.0.0.1:8000/user/cart/2 ^
  -H "Content-Type: application/json" ^
  -H "Accept: application/json" ^
  -H "X-CSRF-TOKEN: %csrf_token%" ^
  -b cookies.txt ^
  -d "{\"quantity\": 3, \"tanggal_mulai\": \"2025-10-28\", \"tanggal_selesai\": \"2025-11-05\", \"notes\": \"Test update via CURL\"}"

echo.
echo Test completed!
