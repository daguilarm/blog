---
extends: _layouts.post
section: content
title: Refactoriza y simplica tus Controladores con Laravel
date: 2022-08-02
description: Optimiza, refactoriza y simplifica los Controladores de Laravel. Mantener unos Controladores simples y minimalistas optimizan Laravel y eliminan componentes innecesarios.
categories: [php, laravel, refactoring]
---
Los *Controladores* en **Laravel**, gestionan las peticiones `HTTP` y sirven para gestionar la relación entre el *Modelo* y la *Vista*. Todo lo demás que incluyamos en el *Controlador*, está de más. Por ejemplo, las llamadas a la base de datos no deberían estar aquí, sino en el *Modelo* o la validación de datos enviados desde un formulario. **La realidad, es que los *Controladores* están llenos de código que realizan estas funciones, mientras que lo lógico sería que no las hicieran**.

En este artículo, voy a explicar como optimizo los Controladores de mis proyectos, y para ello, vamos a empezar por algo sencillo. Pongamos el caso de un *Controlador* simple, que no tiene un sistema **CRUD** (acrónimo en inglés para crear, leer, actualizar y borrar), y únicamente tiene una acción `index`:

```php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MyController extends Controller
{
    /**
     * Display a listing of the resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereRole('user')->take(20)->get();

        return view('index', compact('users'));
    }
}
```

Lo primero que hay que hacer, es quitar todo lo innecesario. En este caso, no es necesario que herede de `Controller`. **Esta herencia nos va a dar acceso a validación, autorización y los jobs**. No es el caso:

```php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyController
{
    /**
     * Display a listing of the resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereRole('user')->take(20)->get();

        return view('index', compact('users'));
    }
}
```

Al tener un sólo método, podemos usar `__invoke`, y podemos quitar los comentarios:

```php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MiControlador
{
    public function __invoke(): View
    {
        $users = User::whereRole('user')->take(20)->get();

        return view('index', compact('users'));
    }
}
```

Y esto nos va a permitir simplificar la ruta del *Controlador*:

```php 
// Antes
Route::get('/home', [MiControlador::class, 'index']);

// Después 
Route::get('/home', MiControlador::class);
```

También debemos eliminar la llamada a la base de datos del *Controlador* y pasarla directamente al *Modelo*. Todo ello mediante un `scope`:

```php 
// Modelo - User
public function scopeRole($query) {
    $query
        ->where('role', 'user')
        ->take(20)
        ->get();
}
```

Todo junto en el *Controlador*, quedaría algo así:

```php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MiControlador
{
    public function __invoke(): View
    {
        return view('index')
            ->withUsers(User::role());
    }
}
```

Mucho más simple, directo y sobre todo, legible. Ahora tenemos un *Controlador* que realiza exclusivamente su función, [cumpliendo con los principios SOLID](https://daguilar.dev/blog/programacion_5_consejos_para_ser_un_gran_programador/).

Veamos ahora un caso más complejo. Ahora el **Controlador** es un sistema **CRUD**. Veamos cómo quedaría un *Controlador* sin refactorizar: 

```php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MiControlador extends Controller
{
    /**
     * Display a listing of the resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereRole('user')->take(20)->get();

        return view('index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $validator = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return redirect('post/create')
                ->withErrors($validator)
                ->withInput();
        }

        $create = User::create($data);

        return Redirect::route('store');
    }

    /**
     * Display the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Igual que antes...
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Igual que antes...
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int                         $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Igual que antes...
    }
}
```

En este caso tampoco vamos a heredar `Controller`. En cualquier caso, si necesitásemos algún componente de la herencia sería más sencillo añadir la dependencia que vayamos a usar, en vez de heredar todo de una forma innecesaria. Vamos a empezar aplicando los mismos principios de antes para el método `index()` (sólo voy a usar las acciones `index` y `store` por no repetirme):

```php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MiControlador
{
    public function index(): View
    {
        return view('index')
            ->withUsers(User::role());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        $validator = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
        ]);

        if ($validator->fails()) {
            return redirect('post/create')
                ->withErrors($validator)
                ->withInput();
        }

        $create = User::create($data);

        return Redirect::route('store');
    }
}
```

En este caso no podemos usar `__invoke`, pero tampoco es tan importante. Ahora vamos retirar toda la validación, añadiendo un `FormRequest` y eliminando los comentarios:

```php 
namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MiControlador
{
    public function index(): View
    {
        return view('index')
            ->withUsers(User::role());
    }

    public function store(UserRequest $request): Redirect
    {
        User::create($request->all());

        return Redirect::route('store');
    }
}
```

El `FormRequest` quedaría así:

```php 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email'],
        ]
    }
}
```

Creo que se simplifica mucho todo el código, y eliminamos toda la lógica que no debería ir en el *Controlador*. Otras veces, en las que me encuentro mucha lógica en el *Controlador*, y me refiero a lógica que si debe de ir aquí, opto por extraer esta lógica a una clase externa o a un `trait`, aunque por lo generar si el código no voy a reutilizarlo suelo optar por una clase. 

Un ejemplo muy simple pero que puede servir para explicar lo que pretendo:

```php 
namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MiControlador
{
    public function index(): View
    {
        return view('index')
            ->withUsers(User::role());
    }

    public function store(UserRequest $request): Redirect
    {
        $user = User::create($request->all());

        if($request->id === 1) {
            return Redirect::route('store.caso_1');
        }

        return Redirect::route('store');
    }
}
```

En este caso tan simple, voy a extraer el método directamente en el *Controlador*:

```php 
namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MiControlador
{
    public function index(): View
    {
        return view('index')
            ->withUsers(User::role());
    }

    public function store(UserRequest $request): Redirect
    {
        $user = User::create($request->all());

        return $this->redirection($request->id);
    }

    private function redirection(int $id): Redirect 
    {
        return $id === 1
            ? Redirect::route('store.caso_1')
            : Redirect::route('store');
    }
}
```

Creo que más o menos se capta la idea.

> Fuentes:
> 
> - [https://styde.net/controladores-en-laravel/](https://styde.net/controladores-en-laravel/){.link-out}
> - [https://freek.dev/1324-simplifying-controllers](https://freek.dev/1324-simplifying-controllers){.link-out}
> - [https://www.laraveltip.com/guia-definitiva-de-principios-solid-explicados-con-laravel/](https://www.laraveltip.com/guia-definitiva-de-principios-solid-explicados-con-laravel/){.link-out}