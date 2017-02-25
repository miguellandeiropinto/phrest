@echo off

where php.exe >nul 2>nul

if %errorlevel%==1 (

    @echo You need to have php installed.

) else (
  set PHREST_COMMAND=php phrest
  goto Init
)

:Init
  %PHREST_COMMAND% %*
