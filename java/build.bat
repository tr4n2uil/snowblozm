cd build/classes
del /Q /S *
javac -d . -Xlint:unchecked -classpath "..\..\lib\*" ..\..\src\org\json\*.java ..\..\src\snowblozm\core\*.java ..\..\src\snowblozm\interfaces\*.java ..\..\src\snowblozm\util\*.java ..\..\src\snowblozm\remote\*.java
jar cvfm ..\..\dist\snowblozm.jar ..\MANIFEST .\*
pause
