@echo off

del snowblozm.js
cd neo
for /r %%f in (*.js) do (type "%%f") >> ..\snowblozm.js

pause
