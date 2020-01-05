<div class="flex flex-col mb-4">
    <p class="text-gray-600 font-medium my-2">
        {{ $post->getDate()->format('d/m/Y') }}
    </p>

    <h2 class="text-3xl mt-0">
        <a
            href="{{ $post->getUrl() }}"
            title="Read more - {{ $post->title }}"
            class="{{ $loop->even ? 'text-gray-600' : 'text-gray-700' }} font-extrabold"
        >{{ $post->title }}</a>
    </h2>

    <p class="mb-4 mt-0">{!! $post->getExcerpt(200) !!}</p>

    <a
        href="{{ $post->getUrl() }}"
        title="Read more - {{ $post->title }}"
        class="uppercase font-semibold tracking-wide mb-2 sm:text-orange-600"
    >Leer mas...</a>
</div>
