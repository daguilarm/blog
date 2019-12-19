<?php $__env->startSection('content'); ?><p><strong>Laravel</strong> permite realizar múltiples conexiones a bases de datos, independientemente del tipo de base de datos que sea (siempre que esté soportada por Laravel). </p>
<p>Lo primero que tenemos que hacer, es definir estas conexiones. Para hacer esto, debemos ir a nuestro archivo de configuración:</p>
<pre><code class="language-bash">\config\database.php </code></pre>
<p>Allí debemos configurar nuestras conexiones. Veamos un ejemplo con conexiones a <code>mysql</code>:</p>
<pre><code class="language-php">'connections' =&gt; [

    'testing' =&gt; [
        'driver'   =&gt; 'sqlite',
        'database' =&gt; dirname(__DIR__).'/database/database.sqlite',
        'prefix'   =&gt; '',
        'foreign_key_constraints' =&gt; env('DB_FOREIGN_KEYS', true),
    ],

    'mysql_connect_1' =&gt; [
        'driver' =&gt; 'mysql',
        'host' =&gt; '127.0.0.1',
        'port' =&gt; '3306',
        'database' =&gt; 'forge_1',
        'username' =&gt; 'forge',
        'password' =&gt; '123456789_forge_1',
        'charset' =&gt; 'utf8mb4',
        'collation' =&gt; 'utf8mb4_unicode_ci',
        'prefix' =&gt; '',
        'prefix_indexes' =&gt; true,
        'strict' =&gt; true,
        'engine' =&gt; null,
    ],

    'mysql_connect_2' =&gt; [
        'driver' =&gt; 'mysql',
        'host' =&gt; '127.0.0.1',
        'port' =&gt; '3306',
        'database' =&gt; 'forge_2',
        'username' =&gt; 'forge',
        'password' =&gt; '123456789_forge_2',
        'charset' =&gt; 'utf8mb4',
        'collation' =&gt; 'utf8mb4_unicode_ci',
        'prefix' =&gt; '',
        'prefix_indexes' =&gt; true,
        'strict' =&gt; true,
        'engine' =&gt; null,
    ],
],</code></pre>
<p>O podemos hacerlo mediante el archivo <code>.env</code>:</p>
<pre><code class="language-bash">DB_CONNECTION_1=mysql
DB_HOST_1=127.0.0.1
DB_PORT_1=3306
DB_DATABASE_1=database_1
DB_USERNAME_1=root
DB_PASSWORD_1=123456789

DB_CONNECTION_2=mysql
DB_HOST_2=127.0.0.1
DB_PORT_2=3306
DB_DATABASE_2=database_2
DB_USERNAME_2=root
DB_PASSWORD_2=123456789</code></pre>
<p>Y su archivo de configuración:</p>
<pre><code class="language-php">'connections' =&gt; [

    'mysql_connect_1' =&gt; [
        'driver' =&gt; env('DB_CONNECTION_1', ''),
        'host' =&gt; env('DB_HOST_1', '127.0.0.1'),
        'port' =&gt; env('DB_PORT_1', '3306'),
        'database' =&gt; env('DB_DATABASE_1', 'forge'),
        'username' =&gt; env('DB_USERNAME_1', 'forge'),
        'password' =&gt; env('DB_PASSWORD_1', ''),
        'charset' =&gt; 'utf8mb4',
        'collation' =&gt; 'utf8mb4_unicode_ci',
        'prefix' =&gt; '',
        'prefix_indexes' =&gt; true,
        'strict' =&gt; true,
        'engine' =&gt; null,
    ],

    'mysql_connect_2' =&gt; [
        'driver' =&gt; env('DB_CONNECTION_2', ''),
        'host' =&gt; env('DB_HOST_2', '127.0.0.1'),
        'port' =&gt; env('DB_PORT_2', '3306'),
        'database' =&gt; env('DB_DATABASE_2', 'forge'),
        'username' =&gt; env('DB_USERNAME_2', 'forge'),
        'password' =&gt; env('DB_PASSWORD_2', ''),
        'charset' =&gt; 'utf8mb4',
        'collation' =&gt; 'utf8mb4_unicode_ci',
        'prefix' =&gt; '',
        'prefix_indexes' =&gt; true,
        'strict' =&gt; true,
        'engine' =&gt; null,
    ],
],</code></pre>
<h3>Migraciones</h3>
<p>Para gestionar migraciones en nuestras dos conexiones, debemos añadir <code>Schema::connection('connection_name')</code>:</p>
<pre><code class="language-php">public function up()

{
    Schema::connection('mysql_connect_1')-&gt;create('users', function (Blueprint $table) {

        $table-&gt;increments('id');
        $table-&gt;string('name');
        $table-&gt;string('email')-&gt;unique();
        $table-&gt;timestamp('email_verified_at')-&gt;nullable();
        $table-&gt;string('password');
        $table-&gt;rememberToken();
        $table-&gt;timestamps();

    });
}
</code></pre>
<p>O el otro ejemplo:</p>
<pre><code class="language-php">public function up()

{
    Schema::connection('mysql_connect_2')-&gt;create('profiles', function (Blueprint $table) {

        $table-&gt;increments('id');
        $table-&gt;integer('user_id')-&gt;unsigned()-&gt;index();
        $table-&gt;string('profile_address');
        $table-&gt;string('profile_avatar');
        $table-&gt;timestamps();

    });
}
</code></pre>
<h3>Desde el Modelo</h3>
<p>Podemos definir la base de datos que puede utilizar cada modelo:</p>
<pre><code class="language-php">namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mysql_connect_1';
}</code></pre>
<h3>Utilizando el: Query Builder</h3>
<p>También podemos especificar la conexión cuando hacemos una consulta a la base de datos, mediante un <em>query</em>:</p>
<pre><code class="language-php">DB::connection('mysql_connect_2')-&gt;table('profiles')-&gt;select('profile_address')-&gt;get();</code></pre>
<p>Veámoslo desde un <em>Controlador</em>:</p>
<pre><code class="language-php">namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * <?php echo e('@'); ?>param  \Illuminate\Http\Request  $request
     * <?php echo e('@'); ?>param  int  $id
     * <?php echo e('@'); ?>return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = DB::connection('mysql_connect_1')-&gt;find($id);

        return view('dashboard.user', compact('user'));
    }
}</code></pre>
<p>Referencias:</p>
<ul>
<li><a href="https://fideloper.com/laravel-multiple-database-connections" class="link-out">Fideloper</a></li>
<li><a href="https://laracasts.com/discuss/channels/eloquent/laravel-5-multiple-database-connection" class="link-out">Laracast</a></li>
<li><a href="https://laraveldaily.com/multiple-database-connections-in-the-same-laravel-project/" class="link-out">Laraveldaily</a></li>
</ul><?php $__env->stopSection(); ?>
<?php echo $__env->make('_layouts.post', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>