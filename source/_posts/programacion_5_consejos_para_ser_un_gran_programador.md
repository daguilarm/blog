---
extends: _layouts.post
section: content
title: Las cinco claves para ser un gran programador. Principios SOLID.
date: 2022-06-25
description: Principales consejos para ser un gran programador. Todo ello aplicando los principios SOLID, consiguiendo código más eficaz, sencillo de mantener y facil de ampliar.
categories: [programacion, php, laravel]
---

Una de las principales herramientas para hacer código de mayor calidad, más fácil de mantener, y sobre todo, que te permita crecer como programador, es la de implementar en nuestro código los principios SOLID:

- **S**. *Single responsibility principle*: Principio de responsabilidad única.
- **O**. *Open-Closed principle*: Principio abierto-cerrado.
- **L**. *Liskov substitution principle*: Principio de sustitución de Liskov.
- **I**. *Interface segregation principle*: Principio de segregación de interfaces.
- **D**. *Dependency Inversion Principle*: Principio de inversión de dependiencia.

Antes de empezar, es importante indicar que los ejemplos que se van a utilizar, están basados en PHP y LARAVEL. Veamos estos principios uno a uno, y con ejemplos:

## 1) **Single responsibility**. 

Cada clase debe de tener una sola función o responsabilidad. Veamos un simple controlador de **Laravel**:

```php
class PostController extends Controller
{
    public function index() {
        // Cargamos los posts de la base de datos
        $posts = DB::table('posts')
            ->latest()
            ->get();

        // Renderizamos la vista y enviamos los posts a ella
        return view('dashboard.posts', compact('posts'));
    }
}
```

En este caso, estamos llamando por un lado a la base de datos y por otro lado, generando la vista. Esta clase tiene dos responsabilidades. Lo normal sería que la llamada a la base de datos se hiciera en otra clase, por ejemplo desde el modelo, de forma que nuestra clase quedaría así:

```php
class PostController extends Controller
{
    public function index() {
        // Renderizamos la vista y enviamos los posts a ella
        return view('dashboard.posts')
            ->withPosts(Post::allThePosts());
    }
}
```

Y nuestro modelo quedaría así:

```php
class Post extends Models
{
    public function scopeAllThePosts($query) {
        return $query
            ->latest()
            ->get();
    }
}
```

Podemos imaginar que un controlador puede llegar a complicarse mucho más, por ejemplo, con validación. En este caso, sería necesario extraerla a un `FormRequest` dejando toda la operación fuera del controlador (por ejemplo).

## 2) **Open-closed principle**. 

Los objetos deben de estar abiertos a extensión pero cerrados a modificación. Es decir, si queremos añadir funcionalidades nuevas a una clase, debemos hacerlo añadiendo métodos y no modificando la clase. La clase solo debería modificarse para solucionar errores.

En este principio introducimos el concepto de `interface`, ya que nos va a ayudar a generar una estructura homogenea. El ejemplo típico que se suele utilizar aquí es el del cálculo de las áreas, de diferentes figuras geométicas. Veamos un ejemplo de como no debería hacerse:

Lo que queremos hacer es calcular el area total de una serie de rectángulos. Para ello, definimos la clase rectángulo:

```php 
class Rectangulo
{
    private $ancho;
    private $alto;
    
    public function __construct($ancho, $alto) {
        $this->ancho = $ancho;
        $this->alto = $alto;
    }
}
```

Ahora necesitamos una clase que calcule la suma del area de todos los rectángulos:

```php 
class CalculoDelArea
{
    public area = 0;

    public function areaTotal(array $rectangulos) {
        foreach($rectangulos as $rectangulo) {
            $this->area += $rectangulo->ancho * $rectangulo->largo;
        }

        return $this->area;
    }
}
```

Pues ya estaría, tenemos una clase que calcula el area total de nuestros rectángulos. El problema biene cuando queremos añadir nuevas figuras geométricas, como cuadrados o circulos... ahora tendríamos que añadir a nuestra clase CalculoDelArea cada uno de estos casos, mediante condicionales:

```php 
class CalculoDelArea
{
    public area = 0;

    public function areaTotal(array $figuras) {
        foreach($figuras as $figura) {
            // Llegan los condicionales 
            if($figura instanceof Rectangulo) {
                $this->area += $rectangulo->ancho * $rectangulo->largo;
            }

            // Añadimos condicionales para otras formas....
        }

        return $this->area;
    }
}
```

Esto es un desastre si tenemos que empezar a añadir modificaciones cada vez que nos surge una necesidad nueva. Para solucionarlo, vamos a utilizar las `interfaces`, y cumplir el **Open-closed principle**:

```php 
// Lo primero es crear una interface, que obligue a las clases a tener un método área
interface Operaciones {
    public function area();
}

// Ahora generamos una clase para cada figura geomética, y que debe implementar la interface
class Rectangulo implements Operaciones
{
    private $ancho;
    private $alto;
    
    public function __construct($ancho, $alto) {
        $this->ancho = $ancho;
        $this->alto = $alto;
    }
    
    public function area() {
        return $this->ancho * $this->alto;
    }
}

// Ahora generamos una para un cuadrado 
class Cuadrado implements Operaciones {
  
    private $lado;
    
    public function __construct($lado) {
        $this->lado = $lado;
    }
    
    public function area() {
        return $this->lado * $this->lado;
    }
}
```

Con esta estructura, cada clase de cada figura es la que se ocupa de realizar el cálculo del area, y la clase que realiza la suma, no tiene por qué saber como se realiza dicha operación:

```php
class CalculoDelArea {
  
    protected $figuras;
    
    public function __construct($figuras = array()) {
        $this->figuras = $figuras;
    }
    
    public function sum() {
        $area = [];
        
        foreach($this->figuras as $figura) {
            $area[] = $figura->area();
        }
    
        return array_sum($area);
    }
}
```

## 3) **Liskov Substitution Principle**. 

El principio, dice algo así: *"Let q(x) be a property provable about objects x of type T. Then q(y) should be provable for objects y of type S, where S is a subtype of T"*, que básicamente viene a decir: *"Cada clase que hereda de otra puede usarse como su padre sin necesidad de conocer las diferencias entre ellas"* [wikipedia](https://es.wikipedia.org/wiki/Principio_de_sustituci%C3%B3n_de_Liskov){.link-out}. Básicamente, podemos decir que al extender una clase padre desde un hijo, nos sobran métodos, o hay métodos que no funcionan con nuestra clase hija. Este principio fue propuesto por [Barbara Liskov](https://es.wikipedia.org/wiki/Barbara_Liskov)[.link-out]

Volvamos al ejemplo de antes: la clase para calcular el area, y le añadimos un método nuevo:

```php 
class CalculoDelArea
{
    protected $figuras;
    
    public function __construct($figuras = array()) {
        $this->figuras = $figuras;
    }
    
    public function sum() {
        $area = [];
        
        foreach($this->figuras as $figura) {
            $area[] = $figura->area();
        }
    
        return array_sum($area);
    }

    public function output()
    {
        return 'La suma total es: ' . $this->sum();
    }
```

Ahora añadimos una nueva clase para calcular el volumen, y para ello vamos a extender la case del `CalculoDelArea`:

```php 
class CalculoDelVolumen extends CalculoDelArea
{
    public function __construct($shapes = array())
    {
        parent::__construct($shapes);
    }

    public function sum()
    {
        // Calculoa el volumen... da igual como lo haga
        return $volumen;
    }
}
```

Ahora imaginemos que creamos una clase para impimir el resultado:

```php 
class Resultado {

    protected $operacion;

    // Si cumpliesemo el principio de sustitución de Liskov, daría igual si en vez de CalculoDelVolumen, usamos CalculoDelArea
    public function __construct(CalculoDelVolumen $operacion)
    {
        $this->operacion = $operacion;
    }

    public function toJson()
    {
        $data = array (
          'sum' => $this->operacion->sum()
        );

        return json_encode($data);
    }
}
```

**El principio de sustitución de Liskov**, dice que si lo hemos hecho bien, daría igual que usásemos la clase `CalculoDelArea` o su clase hija `CalculoDelVolumen`, es decir, cualquier clase hija debería poder ser sustituida por la clase padre. Si se producen errores, entonces no se cumple el **principio de sustitución de Liskov**.

## 4) **Interface segretation principle**. 

Una clase nunca debe ser forzada a implementar una `interface` que no usa, o emplear métodos que no tiene por qué usar. Veamos el típico ejemplo sobre pájaros y perros. Lo primero es crear una `interface` con las acciones que pueden hacer:

```php 
interface Comportamiento
{
    public function correr();
    public function volar();
}
```

Ahora creemos la clase `Perro()`:

```php
class Perro implements Comportamiento
{
    public function correr()
    {
        return 'perro corriendo';
    }

    public function volar()
    {
        null;
    }
}
```

El método `volar()`, están rompiendo el principio actual, ya que está obligando a la clase `Perro()` a tener un método que no usa o necesita. La solución es separar las `interfaces`:

```php 
interface ComportamientoTerrestre
{
    public function correr();
}

interface ComportamientoAereo
{
    public function volar();
}

class Perro implements ComportamientoTerrestre
{
    public function correr()
    {
        return 'perro corriendo';
    }
}

class Pajaro implements ComportamientoAereo
{
    public function volar()
    {
        return 'pajaro volando';
    }
}
```

## 5) **Dependency inversion principle**. 

Los módulos de alto nivel no deberían depender de los de bajo nivel. Ambos deberían depender de abstracciones. Las abstracciones no deberían depender de los detalles. Son los detalles los que deberían depender de abstracciones. [Robert C. Martin](https://es.wikipedia.org/wiki/Robert_C._Martin)[.link-out].

El ejemplo que suele ponerse es el de un proceso de pago, donde se pueden utilizar diversos métodos de pago, pero vayamos paso por paso. Primero vamos a hacerlo directamente, definiendo un método de pago:

```php
class PayPal 
{
    public function hacerPago()
    {
        return 'hacemos el pago con paypal...';
    }
}
```

Y ahora la clase que los llama, en este caso a la clase `Paypal()`:

```php
class Pago
{
    protected $metodoDePago;

    public function __construct(Paypal $paypal)
    {
        $this->metodoDePago = $paypal;
    }

    public function pagar()
    {
        $this->metodoDePago->hacerPago();
    }
}
```

Y ahora realizamos el pago:

```php 
$operacion = new Pago(
    new Paypal();
);

$operation->pagar();
```

El problema radica en que la clase `Pago()` no tiene por qué saber que método de pago vamos a usar, y por tanto, debe de funcionar con cualquiera. Es aquí donde vienen en nuestra ayuda las `interfaces`, permitiendo que podamos utilizar abstracciones. Lo primero será crear la `interface` para hacer el pago:

```php
interface MetodoDePagoInterface
{
    public function hacerPago();
}
```

Ahora los métodos de pago deben implementarla:


```php
class PayPal implements MetodoDePagoInterface
{
    public function hacerPago()
    {
        return 'hacemos el pago con paypal...';
    }
}

class CreditCard implements MetodoDePagoInterface
{
    public function hacerPago()
    {
        return 'hacemos el pago con tarjeta de crédito...';
    }
}
```

Y por último hacemos que la clase `Pago()` llame directamente a la `interface` en vez de al método de pago:

```php
class Pago
{
    protected $metodoDePago;

    public function __construct(MetodoDePagoInterface $metodo)
    {
        $this->metodoDePago = $metodo;
    }

    public function pagar()
    {
        $this->metodoDePago->hacerPago();
    }
}
```

Y ahora ejecutamos el código:

```php 
$operacion = new Pago(
    new Paypal();
);

$operation->pagar();
```

Y podemos cambiar el sistema de pago:

```php 
$operacion = new Pago(
    new CreditCard();
);

$operation->pagar();
```

Implementando todo esto en tu código vas a conseguir proyectos más optimizados, sencillos de mantener y facil de ampliar. Y tal y como he comentado antes, serás **un mejor programador**.