<?php

return [
    'baseUrl' => 'https://daguilar.dev',
    'production' => false,
    'siteName' => 'Blog de Damián Aguilar',
    'siteDescription' => 'Blog sobre programación de Damián Aguilar: php, javascript, vuejs, phyton, java... y mucho más.',
    'siteAuthor' => 'Damián Aguilar',
    'siteLanguage' => 'es',

    // // Categories
    // 'allCategories' => function ($page, $posts) {
    //     return $posts->pluck('categories')->flatten()->unique();
    // },
    // 'countPostsInCategory' => function ($page, $posts, $category) {
    //     return $posts->reduce(function ($carry, $post) use ($category) {
    //         return $carry + collect($post->categories)->contains($category);
    //     });
    // },
    // 'getPostsWithCategory' => function ($page, $posts, $category) {
    //     return $posts->filter(function ($post) use ($category) {
    //         return collect($post->categories)->contains($category);
    //     });
    // },

    // collections
    'collections' => [
        'posts' => [
            'author' => 'Damián Aguilar', // Default author, if not provided in a post
            'sort' => '-date',
            'path' => 'blog/{filename}',
        ],
        'categories' => [
            'path' => '/blog/categories/{filename}',
            'posts' => function ($page, $allPosts) {
                return $allPosts->filter(function ($post) use ($page) {
                    return $post->categories ? in_array($page->getFilename(), $post->categories, true) : false;
                });
            },
        ],
        'legals' => [
            'path' => '/blog/legal/{filename}'
        ]
    ],

    // helpers
    'getDate' => function ($page) {
        return Datetime::createFromFormat('U', $page->date);
    },
    'getExcerpt' => function ($page, $length = 255) {
        $content = $page->excerpt ?? $page->getContent();
        $cleaned = strip_tags(
            preg_replace(['/<pre>[\w\W]*?<\/pre>/', '/<h\d>[\w\W]*?<\/h\d>/'], '', $content),
            '<code>'
        );

        $truncated = substr($cleaned, 0, $length);

        if (substr_count($truncated, '<code>') > substr_count($truncated, '</code>')) {
            $truncated .= '</code>';
        }

        return strlen($cleaned) > $length
            ? preg_replace('/\s+?(\S+)?$/', '', $truncated) . '...'
            : $cleaned;
    },
    'isActive' => function ($page, $path) {
        return str_ends_with(trimPath($page->getPath()), trimPath($path));
    },
];
