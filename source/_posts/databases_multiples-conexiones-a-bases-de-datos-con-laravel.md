---
extends: _layouts.post
section: content
title: Múltiples conexiones a bases de datos con Laravel
date: 2019-12-14
description: Conexiones múltiples a bases de datos utilizando Laravel 6.0, permitiendo conectar a diferentes bases de datos. Veremos todo el proceso, desde la configuración del archivo de configuración de la conexión, la gestión de los modelos y el tratamiento que hacen de los datos los Controladores.
categories: [eloquent,servidores,laravel]
---

**Laravel** permite realizar múltiples conexiones a bases de datos, independientemente del tipo de base de datos que sea (siempre que esté soportada por Laravel). 

Lo primero que tenemos que hacer, es definir estas conexiones. Para hacer esto, debemos ir a nuestro archivo de configuración:

```bash
\config\database.php 
```

Allí debemos configurar nuestras conexiones. Veamos un ejemplo con conexiones a `mysql`:

```php
'connections' => [

    'testing' => [
        'driver'   => 'sqlite',
        'database' => dirname(__DIR__).'/database/database.sqlite',
        'prefix'   => '',
        'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
    ],

    'mysql_connect_1' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'forge_1',
        'username' => 'forge',
        'password' => '123456789_forge_1',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => null,
    ],

    'mysql_connect_2' => [
        'driver' => 'mysql',
        'host' => '127.0.0.1',
        'port' => '3306',
        'database' => 'forge_2',
        'username' => 'forge',
        'password' => '123456789_forge_2',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => null,
    ],
],
```

O podemos hacerlo mediante el archivo `.env`:

```bash
DB_CONNECTION_1=mysql
DB_HOST_1=127.0.0.1
DB_PORT_1=3306
DB_DATABASE_1=database_1
DB_USERNAME_1=root
DB_PASSWORD_1=123456789

DB_CONNECTION_2=mysql
DB_HOST_2=127.0.0.1
DB_PORT_2=3306
DB_DATABASE_2=database_2
DB_USERNAME_2=root
DB_PASSWORD_2=123456789
```

Y su archivo de configuración:

```php
'connections' => [

    'mysql_connect_1' => [
        'driver' => env('DB_CONNECTION_1', ''),
        'host' => env('DB_HOST_1', '127.0.0.1'),
        'port' => env('DB_PORT_1', '3306'),
        'database' => env('DB_DATABASE_1', 'forge'),
        'username' => env('DB_USERNAME_1', 'forge'),
        'password' => env('DB_PASSWORD_1', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => null,
    ],

    'mysql_connect_2' => [
        'driver' => env('DB_CONNECTION_2', ''),
        'host' => env('DB_HOST_2', '127.0.0.1'),
        'port' => env('DB_PORT_2', '3306'),
        'database' => env('DB_DATABASE_2', 'forge'),
        'username' => env('DB_USERNAME_2', 'forge'),
        'password' => env('DB_PASSWORD_2', ''),
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
        'prefix' => '',
        'prefix_indexes' => true,
        'strict' => true,
        'engine' => null,
    ],
],
```

### Migraciones 

Para gestionar migraciones en nuestras dos conexiones, debemos añadir `Schema::connection('connection_name')`:

```php
public function up()

{
    Schema::connection('mysql_connect_1')->create('users', function (Blueprint $table) {

        $table->increments('id');
        $table->string('name');
        $table->string('email')->unique();
        $table->timestamp('email_verified_at')->nullable();
        $table->string('password');
        $table->rememberToken();
        $table->timestamps();

    });
}

```

O el otro ejemplo:

```php
public function up()

{
    Schema::connection('mysql_connect_2')->create('profiles', function (Blueprint $table) {

        $table->increments('id');
        $table->integer('user_id')->unsigned()->index();
        $table->string('profile_address');
        $table->string('profile_avatar');
        $table->timestamps();

    });
}

```

### Desde el Modelo

Podemos definir la base de datos que puede utilizar cada modelo:

```php
namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mysql_connect_1';
}
```

### Utilizando el: Query Builder 

También podemos especificar la conexión cuando hacemos una consulta a la base de datos, mediante un *query*:

```php
DB::connection('mysql_connect_2')->table('profiles')->select('profile_address')->get();
```

Veámoslo desde un *Controlador*:

```php
namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = DB::connection('mysql_connect_1')->find($id);

        return view('dashboard.user', compact('user'));
    }
}
```

Referencias:

+ [Fideloper](https://fideloper.com/laravel-multiple-database-connections){.link-out}
+ [Laracast](https://laracasts.com/discuss/channels/eloquent/laravel-5-multiple-database-connection){.link-out}
+ [Laraveldaily](https://laraveldaily.com/multiple-database-connections-in-the-same-laravel-project/){.link-out}
