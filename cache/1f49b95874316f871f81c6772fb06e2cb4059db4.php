<?php $__env->startSection('content'); ?><p>En ocasiones, nos encontramos en la situación en la que necesitamos generar enlaces externos de forma dinámica. Por ejemplo, pensemos en un código <code>markdown</code>, en el que queremos que nuestro enlace tenga el attributo <code>target</code>, con el valor <em>_blank</em>.</p>
<p>La forma más sencilla de hacerlo, es añadiendo a nuestro enlace una clase <code>css</code>(siempre que tengamos la versión extendida de <code>markdown</code>):</p>
<pre><code class="language-html">[Laravel](https://laravel.com/){.link-out}</code></pre>
<p>Con <code>markdown</code>, podemos añadir attributos con los corchetes:</p>
<pre><code class="language-html">[Laravel](https://laravel.com/){#myID .link-out}</code></pre>
<p>Que se renderizará en:</p>
<pre><code class="language-html">&lt;a href="https://laravel.com/" id="myID" class="link-out"&gt;Laravel&lt;/a&gt;</code></pre>
<p>Ahora, solo tenemos que añadir un poco de código <code>javascript</code> en nuestra página:</p>
<pre><code class="language-javascript">&lt;script&gt;
    document.addEventListener('DOMContentLoaded', function() {
        var linksTargetBlank = document.querySelectorAll('.link-out');
        for (var i = 0; i &lt; linksTargetBlank.length; i++) {
            linksTargetBlank[i].target = "_blank";
        }
    }, false);
&lt;/script&gt;</code></pre>
<p>Automáticamente, una vez que se cargue la página, añadirá el atritudo <code>target</code> con el valor <em>_blank</em>, a todos los enlaces con la clase <em>.link-out</em>.</p><?php $__env->stopSection(); ?>
<?php echo $__env->make('_layouts.post', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>