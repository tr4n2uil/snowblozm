cd build/classes
del /Q /S *
javac -d . -Xlint:unchecked -classpath "..\..\lib\*" ..\..\src\org\json\*.java ..\..\src\snowblozm\core\*.java ..\..\src\snowblozm\interfaces\*.java
jar cvfm ..\..\dist\snowblozm.jar ..\MANIFEST .\*
pause
