<?php $__env->startSection('content'); ?><p>Crear un package con <strong><a href="https://laravel.com/" class="link-out">Laravel</a></strong>, subirlo a <strong><a href="https://github.com/" class="link-out">Github</a></strong> y publicarlo en <strong><a href="https://packagist.org/" class="link-out">Packagist</a></strong>, es bastante sencillo, el problema suele venir cuando intentamos que que se sincronicen entre ellos.</p>
<p>El primer aviso, lo dará <strong>Packagist</strong>, informando que tenemos que ir a <strong>Github</strong> y activar los <em>webhooks</em>, para que se actualice automáticamente, por lo que nuestro primer paso será ese: ir a <strong>Github</strong>.</p>
<p>Debemos entrar en nuestro repositorio, ir a <code>settings</code> y pulsar en <em>webhooks</em>. Básicamente, sería lo mismo que:</p>
<pre><code>https://github.com/github-username/my-repository-name/settings/hooks</code></pre>
<p>Si ya existe un <em>webhook</em> hacia <strong>Packagist</strong> lo editamos, y si no, lo creamos.</p>
<p><img src="../../../assets/img/posts/github-webhooks-1.png" alt="Github webhooks" class="thumbnail" /></p>
<p>Debemos rellenar los campos como se describe a continuación:</p>
<p><img src="../../../assets/img/posts/github-webhooks-2.png" alt="Github webhooks" class="thumbnail" /></p>
<ul>
<li><strong>Payload URL</strong>: <a href="https://packagist.org/api/update-package?username=USERNAME">https://packagist.org/api/update-package?username=USERNAME</a> (usando el USERNAME de <strong>Packagist</strong>).</li>
<li><strong>Content type</strong>: seleccionamos <em>application/json</em>.</li>
<li><strong>Secret</strong>: es nuestra API KEY de <strong>Packagist</strong>. Vamos a <code>profile &gt; show API Token</code> y añadimos este valor al campo de <strong>Github</strong>. </li>
<li><strong>SSL verification</strong>: activamos <em>Enable SSL verification</em>.</li>
<li><strong>Which events would you like to trigger this webhook?</strong>: seleccionamos <em>Just the push event</em>.</li>
<li>Y por último, <strong>y lo más importante</strong>, marcamos la casilla: <em>Active</em>.</li>
</ul>
<p>Guardamos los datos, y listo. Ahora solo tenemos que hacer un cambio en nuestro repositorio y esperar unos minutos a que <strong>Github</strong>, envie la notificación a <strong>Packagist</strong>.</p><?php $__env->stopSection(); ?>
<?php echo $__env->make('_layouts.post', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>