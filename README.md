# Docu 1.0
![N|Solid](http://www.damiancipolat.com/editor_docs/adjuntos/1438782992_dd1.png)

>"Docu" es un sistema de documentación On-line creado con PHP 5.0, el sistema esta completo y tiene
todas las funcionalidades necesarias para ser usado.

## Instalación:
Para instalar Docu, se deben seguir los siguientes pasos.
- Copiar todo el contenido de la carpeta al servidor en donde se lo ejecutara.
- El archivo DB.sql contiene los codigos sql para crear la base de datos que necesita el software.
   Dentro de dicho archivo se encuentran el codigo sql para crear la db tanto en postgresql como en mysql, el script
   funciona por igual para ambas bases de datos.
- Ejecutar todos los querys contenidos en el script en la base de datos a usar.
- En la carpeta "/libs"  cambiar en el archivo Config.php los datos
   - host
   - usuario
   - password
   - nombre de la base de datos
   - tipo de motor de bd
   - puerto (No se lo usa si es mysql).
   
   Se debe cambiar el contenido de las variables por los datos que usaremos en nuestro servidor.

- Dar permisos de escritura y lectura a la carpeta "adjuntos".
- Una vez cumplidos todos los pasos anteriores, "Docu" deberia funcionar correctamente.

En caso de errores o consultas escribir a:
damian.cipolat@gmail.com, asunto: DOCU 1.0
