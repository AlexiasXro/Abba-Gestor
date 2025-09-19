' Crear objeto WScript.Shell
Set WshShell = CreateObject("WScript.Shell")

' Obtener la carpeta donde está este archivo .vbs
ScriptPath = WScript.ScriptFullName
Set fso = CreateObject("Scripting.FileSystemObject")
ScriptFolder = fso.GetParentFolderName(ScriptPath)

' Construir la ruta completa al .bat relativo a esta carpeta
BatPath = ScriptFolder & "\run_gestor.bat"

' Ejecutar el .bat oculto (0 = oculto, True = espera a que termine)
WshShell.Run Chr(34) & BatPath & Chr(34), 0

' Limpiar
Set WshShell = Nothing
Set fso = Nothing
