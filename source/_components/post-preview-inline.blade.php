<div class="flex flex-col w-full bg-white rounded-xl shadow-xl p-4 my-6 {{ $post->pin ? 'border-2 border-blue-400' : 'border border-gray-300' }}">
    <div class="flex {{ $post->pin ? 'justify-between' : 'justify-end' }}">
        @if(!$post->pin)
            <div class="text-gray-600 font-medium my-2">
                {{ $post->getDate()->format('d/m/Y') }}
            </div>
        @endif
        @if($post->pin)
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="fill-current text-blue-500" style="transform: rotate(30deg);">
                    <path d="M15 11.586V6h2V4a2 2 0 0 0-2-2H9a2 2 0 0 0-2 2v2h2v5.586l-2.707 1.707A.996.996 0 0 0 6 14v2a1 1 0 0 0 1 1h4v3l1 2 1-2v-3h4a1 1 0 0 0 1-1v-2a.996.996 0 0 0-.293-.707L15 11.586z"></path>
                </svg>
            </div>
        @endif
    </div>

    <h2 class="text-3xl mt-0">
        <a
            href="{{ $post->getUrl() }}/"
            title="Read more - {{ $post->title }}"
            class="{{ $loop->even ? 'text-gray-600' : 'text-gray-700' }} font-extrabold"
        >{{ $post->title }}</a>
    </h2>

    <p class="mb-4 mt-0">{!! $post->getExcerpt(200) !!}</p>

    <a
        href="{{ $post->getUrl() }}/"
        title="Read more - {{ $post->title }}"
        class="uppercase font-semibold tracking-wide mb-2 sm:text-orange-600"
    >Leer mas...</a>
</div>
