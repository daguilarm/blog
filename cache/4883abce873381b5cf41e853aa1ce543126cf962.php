<?php $__env->startSection('content'); ?><p><a href="https://www.netlify.com/" class="link-out">Netlify</a>, es una plataforma que va más allá de ser un simple servicio de alojamiento estático para sitios web. Nos permite vincular nuestro repositorio (por ejemplo, de Github o Gitlab), de forma que nos permite una integración continua. </p>
<p>Es decir, cada vez que actualizamos nuestro repositorio, automáticamente, se actualiza nuestro proyecto alojado en <a href="https://www.netlify.com/">Netlify</a>.</p>
<p>Ofrece un servicio gratuito, para sitios pequeños (y estáticos), incluyendo:</p>
<ul>
<li>Dominio propio.</li>
<li>Gestión de DNS.</li>
<li>HTTPS.</li>
<li>Rollbacks.</li>
</ul>
<p>Si necesitamos bases de datos, formularios, etc... entonces vamos a tener que optar por otras soluciones.</p>
<p>A nivel personal, este blog se encuentra alojado en <a href="https://www.netlify.com/" class="link-out">Netlify</a>, y sinceramente, no tengo ninguna queja.</p><?php $__env->stopSection(); ?>
<?php echo $__env->make('_layouts.post', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>