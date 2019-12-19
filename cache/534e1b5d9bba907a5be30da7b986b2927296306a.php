<?php $__env->startSection('content'); ?><p>En 2015, empecé mi primer blog sobre programación. Fue en otro dominio, y con un <strong>CMS</strong>, que en aquel momento, me parecía una buena opción: <a href="https://anchorcms.com/" class="link-out">AnchorCMS</a>. No tardé mucho en cansarme de sus limitaciones, y empecé a modificarlo, y modificarlo, y terminó siendo algo totalmente distinto, y durante algún tiempo funcionó. </p>
<p>Fue entonces cuando descubrí <a href="https://laravel.com" class="link-out">Laravel</a>, y decidí crear mi propio CMS. Durante los años, llegué a realizar dos desarrollos diferentes del blog, y al final, terminé por cansarme.</p>
<p>No fue hasta hace unos meses, cuando empecé a trastear con <em>frameworks</em> de desarrollo para sitios estáticos. </p>
<p>Mi primer encuentro con el mundo estático, fue con <a href="https://vuepress.vuejs.org/" class="link-out">Vuepress</a>, y la verdad es que no me gustó nada... ultimamente, cada vez me gusta menos <a href="https://vuejs.org/" class="link-out">Vuejs</a>, y después de este, probé algún que otro <em>frameworks</em> mas, pero ninguno de ellos terminaron por convencerme demasiado. </p>
<p>Había desistido, hasta que un artículo sobre <a href="https://jigsaw.tighten.co/" class="link-out">Jigsaw</a>, cayó en mis manos, y me decidí a probarlo... pasé una mañana de Sábado realizando las primeras pruebas, y aquello me gusto, era exáctamente lo que estaba buscando, y empecé a trabajar en el nuevo blog.</p>
<p><strong>A favor</strong>:</p>
<ul>
<li>Es un sistema basado en <code>php</code>, sigo sintiéndome mucho más cómodo aquí.</li>
<li>Utiliza <strong>Blade</strong> como gestor de plantillas... una maravilla, cuando llevas tanto tiempo trabajando con <strong>Laravel</strong>.</li>
<li><a href="https://tailwindcss.com/" class="link-out">Tailwindcss</a> como framework css. Ahora mismo, me parece imprescindible.</li>
<li>Compatible con <a href="https://www.netlify.com/" class="link-out">Netlify</a>, permitiendo <em>deploy</em> en tiempo real, desde <a href="https://github.com/" class="link-out">Github</a>.</li>
<li><em>Markdown</em> como formato de archivos.</li>
<li>Busqueda con <a href="https://www.algolia.com/" class="link-out">Angolia</a> integrada.</li>
<li>Desarrollo muy rápido.</li>
</ul>
<p><strong>En contra</strong>:</p>
<ul>
<li>Solo para programadores, ya que no dispone de un panel de administración para gestionar el sistema, no es un <strong>CMS</strong>.</li>
</ul>
<p>Si lo que buscas es un <strong>CMS</strong> con panel de administrador, aquí tienes algunas opciones: </p>
<ul>
<li><a href="https://wink.themsaid.com/" class="link-out">Wink</a> </li>
<li><a href="https://es.wordpress.com/" class="link-out">Wordpress</a></li>
</ul><?php $__env->stopSection(); ?>
<?php echo $__env->make('_layouts.post', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>