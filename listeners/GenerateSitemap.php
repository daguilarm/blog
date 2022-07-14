<?php

namespace App\Listeners;

use Illuminate\Support\Str;
use samdark\sitemap\Sitemap;
use TightenCo\Jigsaw\Jigsaw;

class GenerateSitemap
{
    protected $exclude = [
        '/assets/*',
        '*/favicon.ico',
        '*/404*'
    ];

    public function handle(Jigsaw $jigsaw)
    {
        $baseUrl = $jigsaw->getConfig('baseUrl');

        if (! $baseUrl) {
            echo("\nTo generate a sitemap.xml file, please specify a 'baseUrl' in config.php.\n\n");

            return;
        }

        $sitemap = new Sitemap($jigsaw->getDestinationPath() . '/sitemap.xml');

        collect($jigsaw->getPages())->reject(function ($path) {
   
            // exclude collection..
            // collection path always set to /{collection name}/name
            return count(explode("/", trim($path, '/'))) > 1 || Str::is($this->exclusions, $path);
         
         })->each(function ($path) use ($baseUrl, $jigsaw, $sitemap) {
         
            // get the source path
             $sourcePath = empty(trim($path, '/')) 
                   ? $jigsaw->getSourcePath() . $path . "/index.blade.php" 
               : $jigsaw->getSourcePath() . $path . ".blade.php";
         
            // i'm on Windows
             $sourcePath = str_replace('\\', '/', $sourcePath);
         
            // use php filemtime
             $sitemap->addItem(rtrim($baseUrl, '/') . $path, filemtime($sourcePath), Sitemap::DAILY);
         });

        $sitemap->write();
    }

    public function isExcluded($path)
    {
        return Str::is($this->exclude, $path);
    }
}
