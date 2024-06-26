@echo off
set MINGW_HOME=C:\MinGW\bin
set JAVA_HOME=%JAVA_HOME%=C:\Program Files\Java\jdk-20
set PATH=%PATH%;%MINGW_HOME%
set CLASSPATH=.\ActivitiesApplication.jar
set CLASSPATH=%CLASSPATH%;.\EventDispatcher.jar
set CLASSPATH=%CLASSPATH%;.\jackson-core-2.14.0-SNAPSHOT.jar
set CLASSPATH=%CLASSPATH%;.\javax.json-1.1.4.jar
set CLASSPATH=%CLASSPATH%;.\json-simple-1.0-SNAPSHOT.jar
set CLASSPATH=%CLASSPATH%;.\JSONExerciseGenerate.jar
set CLASSPATH=%CLASSPATH%;.\sqlite-jdbc-3.37.2.jar
start javaw -cp %CLASSPATH% br.gov.sp.fatec.itu.aa.main.ActivitiesApplication 1 >> logs\log 2 >> logs\log.err
