---
extends: _layouts.post
section: content
title: Cinco claves para ser mejor programador. Principios SOLID
date: 2022-06-25
updated: 2022-07-14
description: Principales consejos para ser un gran programador. Todo ello aplicando los principios SOLID, consiguiendo código más eficaz, sencillo de mantener y fácil de ampliar.
categories: [programacion, php, laravel]
pin: true
---

Una de las principales herramientas para hacer código de mayor calidad, más fácil de mantener, y sobre todo, que te permita crecer como programador, es la de **implementar en nuestro código los principios SOLID**:

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

**Es sin lugar a dudas el principio SOLID más complicado de entender**, por esto, tengo que admitir que he vuelto a escribir este apartado porque no me gustaba como había quedado la explicación.

El principio, dice algo así: *"Let q(x) be a property provable about objects x of type T. Then q(y) should be provable for objects y of type S, where S is a subtype of T"*, que básicamente viene a decir: *"Cada clase que hereda de otra puede usarse como su padre sin necesidad de conocer las diferencias entre ellas"* [wikipedia](https://es.wikipedia.org/wiki/Principio_de_sustituci%C3%B3n_de_Liskov){.link-out}. Este principio fue propuesto por [Barbara Liskov](https://es.wikipedia.org/wiki/Barbara_Liskov){.link-out}

En resumen dice que si creamos una clase y a su vez creamos clases hijas a partir de esta, las hijas, deberían de ser capaces de sustituir completamente a la clase padre, y que el código funcione exactamente igual que con la clase padre. **La idea es que al ampliar las funcionalidades de una clase hija, está no esté modificando el comportamiento de la clase padre**.

Veamos un ejemplo que lo incumple:

```php 
Class Ave
{
    public function come()
    {
        return 'comiendo...';
    }

    public function vuela()
    {
        return 'volando';
    }
}

Class Gallina extends Ave
{
    public function vuela()
    {
        return '';
    }
}
```

**Cuando nos encontramos con una clase hija que tiene métodos que tenemos que dejar en blanco, nos encontramos ante un inclumplimiento del principio**, ya que la clase hija es incapaz de volar, y por tanto, no puede usarse en lugar de la clase padre... recordemos que una gallina no vuela. **Esto No significa que la clase no funcione, simplemente que no tiene sentido**, y que lo más recomendable es reescribir el código para que tenga más sentido.

> Lo más probable es que, si los tests que haces para la clase hija no valen para la clase padre, no se esté cumpliendo el Principio de Sustitución de Liskov.

Existen diversas formas de solucionar el problema de nuestra clase, la mas sencilla es añadir una clase intermedia:

```php 
Class Ave
{
    public function come()
    {
        return 'comiendo...';
    }
}

class AveVoladora extends Ave
{
    public function vuela()
    {
        return 'volando';
    }
}

Class Gallina extends Ave
{
}

class Gaviota extends AveVoladora
{   
}
```

No se si es el mejor ejemplo, pero espero que se entienda bien.

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

El método `volar()`, están rompiendo el principio actual, ya que está obligando a la clase `Perro()` a tener un método que no usa o necesita. *En la misma linea que en el Principio de Sustitución de Liskov*... La solución es separar las `interfaces`:

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

Implementando todo esto en tu código vas a conseguir proyectos más optimizados, sencillos de mantener y facil de ampliar. Y tal y como he comentado antes, serás **un mejor programador**. También es cierto que **no hay que obsesionarse con los principios SOLID**, lo ideal es tenerlos en mente e intentar seguirlos. La realidad es que no siempre se puede (por temas de tiempo, clientes,...), pero al menos hay que intentarlo.