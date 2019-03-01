# API Profile Manager

## Introducción

La api permite gestionar un perfil de usuario básico.

Quienes la consuman deberán poder:
1. Traer su información
2. Borrar su información
3. Modificar su información
4. Subir una imagen.

## Requerimientos de instalación

La API fue desarrollada mediante el framework Laravel (versión 5.7) 
por tanto, tiene los siguientes requisitos para poder ser montada en 
nuestro localhost.

- PHP >= 7.1.3 (requerido por Laravel 5.7)

- Composer

- OpenSSL PHP Extension (requerido por Laravel 5.7)

- PDO PHP Extension (requerido por Laravel 5.7)

- Mbstring PHP Extension (requerido por Laravel 5.7)

- Tokenizer PHP Extension (requerido por Laravel 5.7)

- XML PHP Extension (requerido por Laravel 5.7)

- Ctype PHP Extension (requerido por Laravel 5.7)

- JSON PHP Extension (requerido por Laravel 5.7)

- BCMath PHP Extension (requerido por Laravel 5.7)

- MySql (alguna versión compatible con la del framework, 
para su desarrollo se utilizó la 5.7)

- Postman (Como sugerencia para poder probar las llamadas a la Api)

#### Primeros pasos
1. Crear una bd en nuestro servidor MySql.

2. Crear y configurar el archivo .env de Laravel con las 
credenciales necesarias para conectar a la bd, para esto
 tomar como modelo el archivo .env.example que 
 proporcionado por el framework.
 
3. Correr la migration para crear la tabla profiles en donde se alojarán
 los perfiles. Para poder hacer esto, nos paramos en el root del proyecto
  y corremos php artisan migrate.
  
## Endpoints de la API

### get-profile
Endpoint que nos devuelve un perfil de usuario en formato json.

Url: **http://localhost/profile/{profileId}/get-profile**

Method: **GET**

Parámetros: **id de perfil (mandatorio)**

Validaciones: **ninguna**

Respuesta esperada: 

    {
        "id": 1,
        "name": "daniel",
        "email": "emanuel@gmail.com",
        "image": "http://localhost/images/834256792.jpg",
        "created_at": "2019-03-01 01:03:02",
        "updated_at": "2019-03-01 01:43:54"
    }
    
### upload-image
Endpoint que nos permite cargar una imagen de perfil a través de la api.

A modo de sugerencia, revisar este link para ver como enviar un fichero 
usando postman.

https://stackoverflow.com/questions/16015548/tool-for-sending-multipart-form-data-request

Url: **http://localhost/profile/{profileId}/upload-image**

Method: **POST**

Parámetros: 
- **id de perfil (mandatorio)**
- **archivo de imagen (mandatorio)**

Validaciones: 
- **El tamaño máximo del archivo es de 2048 bytes.**
- **El archivo debe ser una imagen.**
- **El formato debe ser jpeg, png, jpg o gif.**

Respuesta esperada:

    {
        "message": "Image upload successfully"
    }
    
### create-profile
Endpoint que nos permite crear un nuevo perfil.

Url: **http://localhost/profile/create-profile**

Method: **POST**

Parámetros:
- **name (mandatorio)**
- **email (mandatorio)**

Validaciones:
- **El email no debe estar previamente cargado ya que es único.**

Respuesta esperada:

    {
        "message": "Profile created successfully",
        "profileId": 30
    }
    
### update-profile
Endpoint que permite modificar la información de perfil.

Url: **http://localhost/profile/{profileId}/update-profile**

Method: **PUT**

Parámetros:
- **id del perfil**
- **name (mandatorio)**
- **email (mandatorio)**

Validaciones:
- **Si se cambia el email este nuevo valor no debe estar previamente 
cargado ya que es único.**

Respuesta esperada:

    {
        "message": "Profile updated successfully",
        "profileId": 1
    }
    
### delete-profile
Endpoint que nos permite borrar un perfil

Url: **http://localhost/profile/{profileId}/delete-profile**

Method: **DELETE**

Parámetros:
- **id del perfil**

Validaciones: **ninguna**

Respuesta esperada:

    {
        "message": "Profile deleted successfully"
    }

## Test Unitarios
Los test unitarios corren con phpunit, cada uno de los test se 
encuentran en la clase exam/test/Feature/ProfileTest.php y para ejecutarlos podemos correr
 desde el root del proyecto el comando vendor/bin/phpunit.