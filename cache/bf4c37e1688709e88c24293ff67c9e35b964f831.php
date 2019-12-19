<?php $__env->startSection('content'); ?><p>En ocasiones, podemos necesitar acceder a funciones (<em>helpers</em>), desde cualquier parte de nuestro código.</p>
<p><strong>Laravel</strong> no dispone de esta funcionalidad por defecto, pero existen varias formas de configurar nuestra aplicación, para solucionar esto.</p>
<p>Antes de empezar con las diferentes opciones que tenemos, lo primero es crear un archivo donde alojar nuestras funciones o <em>helpers</em>, en mi caso, suelo tener el archivo aquí:</p>
<pre><code class="language-php">\App\Http\Helpers</code></pre>
<p>En este nuevo archivo: <code>Helpers.php</code>, añadiremos todos los métodos que necesitemos:</p>
<pre><code class="language-php">&lt;<?php echo e('?php'); ?>


if (! function_exists('userId')) {
    function userId() {
        return auth()-&gt;user()-&gt;id;
    }
}</code></pre>
<p>Ahora es cuando podemos elegir entre las diferentes opciones para poder tener acceso a los <em>helpers</em>.</p>
<h4>a) Mediante el archivo <code>composer.json</code></h4>
<p>Añadimos el campo <code>files</code>, con la ruta hacia nuestro archivo.</p>
<pre><code class="language-php">"autoload": {
    "psr-4": {
        "App\\": "app/"
    },
    "classmap": [
        "database/seeds",
        "database/factories"
    ],
    "files":[
        "app/Http/Helpers.php"
    ]
},</code></pre>
<p>Ahora solo nos falta actualizar <code>composer</code>, y ya estaría:</p>
<pre><code class="language-php">composer dump</code></pre>
<h4>b) Mediante un <em>Service Provider</em></h4>
<p>Crea un nuevo <em>Services Provider</em>, usando <code>artisan</code>:</p>
<p><code>artisan make:provider HelpersServiceProvider</code></p>
<p>El archivo se crea en la ruta:</p>
<p><code>\app\Providers\HelpersServiceProvider.php</code></p>
<p>Y en el archivo, en el método <code>register()</code>, añadimos:</p>
<pre><code class="language-php">public function register()
{
    require_once app_path() . '/Http/Helpers.php';
}</code></pre>
<p>Es decir, la ruta a nuestro archivo <code>helpers</code>.</p>
<p>Y ahora en el archivo:</p>
<p><code>config/app.php</code></p>
<p>Debemos añadir el nuevo <em>Service Provider</em> a la lista:</p>
<pre><code class="language-php">App\Providers\HelpersServiceProvider::class,</code></pre>
<p>De estas dos opciones, personalmente, prefiero la segunda, aunque ambas son igualmente válidas.</p><?php $__env->stopSection(); ?>
<?php echo $__env->make('_layouts.post', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>