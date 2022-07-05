---
extends: _layouts.post
section: content
title: Lenguajes de programación de bajo nivel VS alto nivel
date: 2021-05-13
description: En este artículo se muestran las diferencias principales entre los lenguajes de programación de alto nivel, frente a los lenguajes de programación de bajo nivel o código máquina
categories: [programacion, php, python, javascript]
cover_image: programming-languages-low-hight-level.jpg
---

Los **lenguajes de programación** pueden clasificarse en función de si son lenguajes de programación de bajo nivel o de alto nivel. Aunque también se puede establecer una opción intermedia, definiendo a los lenguajes de medio nivel, aunque no es algo sobre lo que recaiga demasiado consenso, por lo que vamos a quedarnos con la clasificación de: **bajo nivel y alto nivel**.

## Lenguajes de bajo nivel 

>Un lenguaje de programación de características de bajo nivel o de primera generación, es aquel en el que sus instrucciones ejercen un control directo sobre el hardware y están condicionados por la estructura física de las computadoras que lo soportan... [Wikipedia](https://es.wikipedia.org/wiki/Lenguaje_de_bajo_nivel){.link-out}

Basicamente, un lenguaje de bajo nivel es un lenguaje de programación pensado para interactuar directamente con la máquina, por lo que está íntimamente relacionado con su estructura y funcionamiento, utilizando instrucciones básicas que la máquina interpreta directamente, siendo por tanto dificil de interpretar o entender por el programador. En definitiva, cada **CPU** va a tener su propio **código máquina**, el cual va a estar controlado (en general) por 
el *firmware*.

En el **código máquina** puro, se utiliza código binario por lo que el código está repleto de ceros y unos. Esta situación deriva en que el código binario se convertierta en hexadecimal (u otras variantes) para simplificar el trabajo del programador, principalmente, reduciendo las cadenas de código. Por ejemplo, el código binario `1001111000001010` se convierte en `9E0A`.

Veamos un ejemplo del cálculo del **número de Fibonacci** mediante código maquina, utilizando una representación hexadecimal:

```
8B542408 83FA0077 06B80000 0000C383
FA027706 B8010000 00C353BB 01000000
B9010000 008D0419 83FA0376 078BD989
C14AEBF1 5BC3
```

El siguiente paso es el **Ensamblador**, un primer intento de hacer el **código máquina** más legible para humanos:

```
ORG 100h
MOV AL, 200 ; AL = 0C8h
MOV BL, 4
MUL BL ; AX = 0320h (800)

RET
```

Aunque como puede verse, está lejos de los lenguajes de alto nivel a lo hora de entender lo que hace... no se ve demasiada lógica en el código. A no ser que te dediques a realizar compiladores de código, desarrollar lenguajes de programación o sistemas operativos, esto igual no lo ves nunca. 

A nivel personal, hace muchos años me compré un libro de programación con ensamblador. Al principio me parecío algo muy interesante y me volqué en su lectura, pero no tardó en convertise en algo demasiado complejo, tedioso y poco interesante... y terminé por abandonarlo.

### Principales lenguajes de bajo nivel

+ Código máquina.
+ Ensamblador.
+ C/C++ (Es un lenguaje de alto nivel que puede programar a bajo nivel... este sería el que podríamos considerar como intermedio, y por tanto voy a ponerlo en las dos listas, aunque siendo estrictos, es un lenguaje de alto nivel).

## Lenguajes de alto nivel 

Los **lenguajes de alto nivel** son aquellos que son entendibles por humanos de forma directa sin necesidad de tener que interpretarlos, es decir, se adaptan a las capacidades congnitivas humanas.

>En lugar de tratar con registros, direcciones de memoria y las pilas de llamadas, lenguajes de alto nivel se refieren a las variables, objetos [...], subrutinas, funciones, bucles, hilos y otros conceptos de la informática abstracta [Wikipedia](https://es.wikipedia.org/wiki/Lenguaje_de_alto_nivel){.link-out}

Veamos el ejemplo de antes, un número de **Fibonacci** pero con **PHP**:

```php
<?php
 
function fibonacci($n)
{
    $fibonacci  = [0, 1];
 
    for($i = 2; $i <= $n; $i++)
    {
        $fibonacci[] = $fibonacci[$i - 1] + $fibonacci[$i - 2];
    }

    echo $fibonacci[$n];
}
 
fibonacci(10);
```

Por lo menos aquí **se ve la lógica del código** y puede entenderse lo que hace. Podemos decir, que un **lenguaje de programación de alto nivel**, pretende emular nuestra forma de pensar y razonar, evitando al programador los detalles técnicos de cómo hacerlo.

Estos lenguajes de **programación de alto nivel**, deben de ser posteriormente comprendidos y ejecutados por la máquina, para ello es necesario convertir la lógica del lenguaje a **código máquina**. Este proceso se puede hacer de dos formas:

1. **Compiladores**. Lo que hace es traducir completamente el programa en **código fuente**, generando un programa compilado y que puede ser ejecutado directamente por la máquina. **Por ejemplo C/C++ o Go**.
2. **Intérpretes**. Van traduciendo sentencia a sentencia el código del programa conforme se va utilizando. **Por ejemplo JavaScript, Python o PHP.**

Por lo general, el ciclo de desarrollo en un lenguaje interpretado es bastante más rápido que en uno compilado, mientras que un código compilado es mucho más rápido que uno interpretado, ya que no requiere del proceso de traducción que el programa interpretado necesita.

### Principales lenguajes de alto nivel

+ Python (probablemente el de más alto nivel)
+ C/C++ (Es un lenguaje de alto nivel que puede programar a bajo nivel... este sería el que podríamos considerar como intermedio, y por tanto voy a ponerlo en las dos listas).
+ C# 
+ Java 
+ Javascript 
+ PHP 
+ Visual Basic 
+ Erlang
+ Basic (mi primer lenguaje de programación)
+ Cobol
+ ...


### Fuentes 

+ [https://es.wikipedia.org/wiki/Lenguaje_de_bajo_nivel](https://es.wikipedia.org/wiki/Lenguaje_de_bajo_nivel){.link-out}
+ [https://techterms.com/definition/low-level_language](https://techterms.com/definition/low-level_language){.link-out}
+ [https://karmany.net/ingenieria-inversa/19-ingenieria-inversa-novatos/7-codigo-maquina-lenguaje-ensamblador](https://karmany.net/ingenieria-inversa/19-ingenieria-inversa-novatos/7-codigo-maquina-lenguaje-ensamblador){.link-out}
+ [https://whatis.techtarget.com/definition/machine-code-machine-language](https://whatis.techtarget.com/definition/machine-code-machine-language){.link-out}
+ [https://stackoverflow.com/questions/21571709/difference-between-machine-language-binary-code-and-a-binary-file](https://stackoverflow.com/questions/21571709/difference-between-machine-language-binary-code-and-a-binary-file){.link-out}
+ [https://es.wikipedia.org/wiki/Lenguaje_de_alto_nivel](https://es.wikipedia.org/wiki/Lenguaje_de_alto_nivel){.link-out}
+ [https://programacionconphp.com/serie-fibonacci-en-php/](https://programacionconphp.com/serie-fibonacci-en-php/){.link-out}
+ [https://ccia.ugr.es/~jfv/ed1/c/cdrom/cap1/f_cap12.htm](https://ccia.ugr.es/~jfv/ed1/c/cdrom/cap1/f_cap12.htm){.link-out}
+ [http://cv.uoc.edu/moduls/XW02_79049_00373/web/main/m4/v2_3.html](http://cv.uoc.edu/moduls/XW02_79049_00373/web/main/m4/v2_3.html){.link-out}
+ [https://blog.makeitreal.camp/lenguajes-compilados-e-interpretados/](https://blog.makeitreal.camp/lenguajes-compilados-e-interpretados/){.link-out}
