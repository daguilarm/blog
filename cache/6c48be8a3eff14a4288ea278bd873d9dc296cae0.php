<?php $__env->startSection('content'); ?><p>Ha salido la nueva versión de php: la <strong>versión 7.4</strong> con grandes novedades. Destacando las <em>arrow functions</em> que llevaban siendo (desde hace tiempo), una reivindicación por parte de la comunidad php:</p>
<pre><code class="language-php">&lt;<?php echo e('?php'); ?>


$factor = 10;
$nums = array_map(fn($n) =&gt; $n * $factor, [1, 2, 3, 4]);
// $nums = array(10, 20, 30, 40);</code></pre>
<p>Podrás encontrar más informacion sobre las novedades, aquí: <a href="https://www.php.net/manual/es/migration74.new-features.php" class="link-out">php.net</a></p>
<p>En cualquier caso, la idea de este post era la de exponer mi experiencia al actualizar mi Mac, y explicar como lo he hecho, y sobre todo, que problemas he encontrado.</p>
<p>Partimos de la base, de que la gestión de mi servidor local la realizo a través de <a href="https://laravel.com/" class="link-out">Laravel valet</a>, y por tanto, solo he tenido que hacer esto:</p>
<pre><code class="language-bash">valet use php@7.4</code></pre>
<p>Automáticamente me ha indicado que no tenía instalada la versión 7.4, y la ha instalado directamente. </p>
<p>Admito que no ha sido mi primera tentativa, ya que anteriormente, había intentado instalarla utilizando <code>brew</code>... y no fue la mejor de las opciones, realmente, fue un auténtico desastre y no solo porque no me ha instaló la nueva versión, sino porque que me borró el archivo de configuración de mysql:</p>
<pre><code class="language-bash">/usr/local/etc/my.cnf.d</code></pre>
<p>Por lo que he tenido que crearlo de nuevo:</p>
<pre><code class="language-bash">mkdir /usr/local/etc/my.cnf.d</code></pre>
<p>Importante, no olvidar actualizar <code>valet</code> antes:</p>
<pre><code class="language-bash">composer global update &amp;&amp; valet install</code></pre>
<p>Otros usuarios, se han encontrado otros problemas, por ejemplo, <a href="https://laracasts.com/" class="link-out">Jeffrey Way</a>, ha tenido problemas con <code>ngix</code> y <code>dnsmasq</code>, y ha recomendado actualizarlos:</p>
<pre><code class="language-bash">brew upgrade nginx &amp;&amp; brew upgrade dnsmasq</code></pre>
<p>También recomienda eliminar versiones anteriores de <code>php</code>:</p>
<pre><code class="language-bash">brew unlink php@7.2</code></pre>
<p>En mi caso, lo hizo automáticamente <code>valet</code>...</p>
<p>En fin, creo que que si usas <strong>Mac</strong> y <strong>Laravel</strong>, lo mejor para actualizar <code>php</code> es hacerlo desde <code>valet</code>, o al menos, ha sido lo más sencillo para mi.</p><?php $__env->stopSection(); ?>
<?php echo $__env->make('_layouts.post', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>