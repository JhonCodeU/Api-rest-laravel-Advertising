## Project Setup

```sh
composer install
```

### Compile and Hot-Reload for Development

```sh
php artisan migration --seed
php artisan migration:refresh --seed
```

### Run server

```sh
php artisan serve --port=8000
```


# API REST con Laravel

## ¿Qué es un API?

- Se podría resumir en que una API REST es una fracción de código alojada en un servidor esperando a que una aplicación externa (cliente) haga alguna solicitud para poder realizar su proceso (consultar, calcular, etc.) y devolver una respuesta.
- Típicamente el cliente se conecta a la API mediante un enlace (link)

## Sitio web: estructura inicial

Les comparto el paso a paso:**Crear proyecto**

```bash
laravelnew api-9
```

Entrar a la carpeta y crear **Model-Controller-Migration-Factory**

```bash
cd api-8
php artisan make:model Customer -cmf

```

**migrations/customer**

```php
  publicfunction up()
  {
    Schema::create('customers', function (Blueprint $table) {
        $table->id();
        $table->string('dni')->unique();
        $table->string('name');
        $table->string('last_name');
        $table->string('email');
        $table->string('cell_phone');
        $table->boolean('habeas_data');
        $table->unsignedBigInteger('city_id');
        $table->foreign('city_id')->references('id')->on('cities');
        $table->timestamps();
    });
  }

```

**CustomerFactory.php**

```php
publicfunctiondefinition()
  {
    return [
        'dni' => $this->faker->unique()->randomNumber(8),
        'name' => $this->faker->name,
        'last_name' => $this->faker->lastName,
        'email' => $this->faker->unique()->safeEmail,
        'cell_phone' => $this->faker->phoneNumber,
        'habeas_data' => true,
        'city_id' => $this->faker->numberBetween(1, 64)
    ];
}

```

**DatabaseSeeder.php**

```php
publicfunctionrun()
  {
        User::factory(5)->create();
        $this->call(DepartamentSeeder::class);
        $this->call(CitySeeder::class);
        Customer::factory(3)->create();
  }

```

Comando de migración:

```bash
php artisan migrate --seed
```

ir a: routes > web.phpponer lo siguiente:

```php
<?php
useIlluminate\Support\Facades\Route;
Route::get('/', [\App\Http\Controllers\CustomerController::class, 'index']);

```

ir a: app > http > controllers > CustomerController.php escribir lo siguiente:

```php
<?php
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\Request;
{
publicfunctionindex()
    {
return view ('index', [
                    return CustomerResource::collection(Customer::all());
        ]);
    }
}
<?php
public function getExcerptAttribute()
    {
				// Content hace referencia al content en la db/migrations
        return substr($this->content, 0, 120);
    }

    public function getPublishedAtAttribute()
    {
				// created_at hace referencia al created_at en la db/migrations
        return $this->created_at->format('d/m/Y');
    }
```

## Terminos

[Códigos de estado de respuesta HTTP - HTTP | MDN](https://developer.mozilla.org/es/docs/Web/HTTP/Status)

# API

## Versión 1: planificación y configuración inicial

<aside>
🤖 php artisan make:controller Api/V1/CustomerController --api --model=Customer

</aside>

Con este comando cramos el controlador para la api basado en el modelo del Customer del cual creamos en clases pasadas

Entramos al archivo y dentro de la funcion show agregamos lo siguiente

```php
public function show(Customer $Customer)
    {
        return $Customer;
    }
```

*web/api.php*

```php
Route::apiResource('v1/Customers', App\Http\Controllers\Api\V1\CustomerController::class)->only('show');
```

si le quitamos el only('show') habilitamos todas las rutas del archivo controlador de la api, podemos ver todas las rutas disponibles con

```php
php artisan route:list
```

probamos la api con el siguiente comando

```php
curl http://localhost:8000/api/v1/customers/1 | jq
``

## Versión 1: recurso

Cuando se construye una API, se puede necesitar una capa de transformación entre el Modelo Eloquent y la respuesta JSON.

En esta capa de Recursos se pueden limitar la cantidad de campos del registro y mejorar la presentación de los mismos.

[Eloquent: API Resources](https://laravel.com/docs/8.x/eloquent-resources)

```
php artisan make:resource V1/CustomerResource

```

nos dirigimos al archivo creado dentro de app > Http > resources > CustomerResource.php así quedaria:

```php
<?php

namespaceApp\Http\Resources\V1;

useIlluminate\Http\Resources\Json\JsonResource;

classCustomerResourceextendsJsonResource
{
    /**
     * Transform the resource into an array.
     *
     *@param  \Illuminate\Http\Request  $request
     *@return array
     */
publicfunctiontoArray($request)
    {
return [
            'title' => $this->title,
            'slug' => $this->slug,
            'excerpt' => $this->excerpt,
            'content' => $this->content
        ];
    }
}


```

en CustomerController.php vamos a retornar ese recurso que estamos utilizando.agregamos lo siguiente:

```php
use App\Http\Resources\V1\CustomerResource;

```

```php
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }


```

Esto Funciona de la siguiente manera:Tenemos una rutala ruta dispara un controladorel controlador tiene dentro e si una acciónesta acción retorna ese recurso y eso es lo que le mostramos al usuario o al software que se vaya a conectar a nuestra aplicación.

## Versión 1: colección

[How to use HTTP Status Codes properly in Laravel](https://medium.com/@naumancs/how-to-use-http-status-codes-properly-in-laravel-3f66eebf0e66)

En esta seccion retornamos una colección complete y agregamos la de eliminar

app > Http > Controllers > Api > V1 > CustomerController 

```php
public function index()
    {
        return CustomerResource::collection(Customer::latest()->paginate());
    }

public function destroy(Customer $Customer)
    {
        $Customer->delete();
        return response()->json(null, 204);
    }
```

routes > api

modificamos la linea de only

```php
->only(['index', 'show', 'destroy']);
```

# Autenticación

**Laravel Sanctum**

proporciona un sistema de autenticación para SPA (aplicaciones de una sola página), aplicaciones móviles y API simples basadas en tokens. Sanctum permite que cada usuario de su aplicación genere múltiples tokens API para su cuenta. A estos tokens se les pueden otorgar habilidades / alcances que especifican qué acciones pueden realizar los tokens.

[https://laravel.com/docs/8.x/sanctum#introduction](https://laravel.com/docs/8.x/sanctum#introduction)

instalamos el complemento con:

```php
composer require laravel/sanctum
```

ahora hacemos la migraciones correspondientes

```bash
php artisan migrate
```

ahora dentro del archivo de rutas de la api aplicamos el middleware a las rutas

->middleware('auth:sanctum')

quedando así

```php
Route::group(['prefix' => 'v1', 'namespace' => 'App\Http\Controllers\Api\V1'], function () {
    Route::apiResource('customers', CustomerController::class);
    Route::get('departaments', [DepartamentController::class, 'index']);
    Route::get('cities', [CityController::class, 'index']);
})->middleware('auth:sanctum');
```

Ahora si entremos a las rutas nos salta un error diciento que no estamos loggeados sin embargo para la api, al momento de hacer una peticion tenemos que agregar la cabecera de 

Accept:  application/json  

para que de esta manera nos trate como api y no como cliente web

Ejemplo con Curl

```bash
curl http://localhost:8000/api/v2/Customers/4 -H "Accept: application/json" | jq
```

y vamos a recebir un 401 unauthorized, que es correcto porque no hemos creado el token

```json
{
  "message": "Unauthenticated."
}
```

## Autenticación

```bash
php artisan make:controller Api/LoginController
```

Apicontroller

```php
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Metodo que recibe el formulario
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'token' => $request->user()->createToken($request->name)->plainTextToken,
                'message' => 'Success'
            ]);
        }

        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    // Metodo que verifica que llegue la informacion correctamente
    public function validateLogin(Request $request)
    {
        return $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'name' => 'required'
        ]);
    }
}
```

 routes > api

agregamos la siguiente linea para activar la ruta de login

```php
use App\Http\Controllers\Api\LoginController;
Route::Customer('login', [LoginController::class, 'login']);
```

Dentro del modelo de usuario activamos el uso de tokens

agregando HasApi tokens

```php
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasFactory, Notifiable, **HasApiTokens**;
...
}
```

para utilizar la api agregamos el header

```php
"Accept: application/json"
```

y enviamos los datos del login por medio de un form data

![Curso%20de%20API%20REST%20con%20Laravel%20accc95b23fdb4614bdfc210732a2adaf/Untitled.png](Curso%20de%20API%20REST%20con%20Laravel%20accc95b23fdb4614bdfc210732a2adaf/Untitled.png)

curl

```bash
curl http://localhost:8000/api/login -H "Accept: application/json" -F "email=correo@example.com" -F "password=password" -F "name=curl"
```

response:

```json
{
  "token": "2|84UteVmkf07ostkRdza1rPCoksE2N7k1tzNJ3cte",
  "message": "Success"
}
```

y accedemos a las rutas agregando el parametro de autenticación por medio de Bearer token

![Curso%20de%20API%20REST%20con%20Laravel%20accc95b23fdb4614bdfc210732a2adaf/Untitled%201.png](Curso%20de%20API%20REST%20con%20Laravel%20accc95b23fdb4614bdfc210732a2adaf/Untitled%201.png)

curl

```bash
curl http://localhost:8000/api/v2/Customers/4 -H "Accept: application/json" -H "Authorization: Bearer TOKENHERE"| jq
```
