<div>
    @foreach ($this->posts as $post)
        <div class="p-3 md:px-6 mb-1.5 bg-white rounded-md shadow-sm flex gap-3 relative">
            <div class="p-3 hidden md:flex flex-col items-center border-r border-gray-500">
                <h1 class="font-bold text-blue-600 text-2xl mb-3">{{ count($post->votes) }}</h1>
                <div>Voted</div>
            </div>
            <div class="w-full">
                <p class="absolute top-0 right-0 p-2 pl-8 bg-white bg-opacity-85 text-sm">{{ $post->created_at->diffForHumans()}}</p>
                <div class="flex md:hidden mb-1.5">
                    <h1 class="font-bold text-blue-600 text-lg">{{ $post->vote }}</h1>
                    <div class="text-xs text-gray-400">Voted</div>
                </div>
                <h1 class="md:text-lg font-semibold mb-2">{{ $post->title }}</h1>
                <p class="line-clamp-3 leading-6 mb-4">{{ $post->content }}</p>
                @if (count($post->images))
                    <div class="flex justify-center gap-6 py-4 bg-gray-100 rounded-lg mb-3">
                        @foreach ($post->images as $image)
                            <div class="bg-white border border-gray-300 rounded-lg p-4">
                                <img width="80" src="{{ asset($image->path) }}" alt="">
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="flex justify-between items-center">
                    <div class="flex gap-3 items-center">
                        <img class="w-[40px] h-[40px] rounded-full" src="{{ $post->user->image }}" alt="">
                        <h1 class="text-gray-500">{{ $post->user->name }}</h1>
                    </div>
                    <div class="flex items-center">
                        <p class="mr-6 text-gray-500">{{ count($post->comments) }} comments</p>
                        <a wire:navigate href="{{ route('post-detail', $post->id) }}" class="underline p-1 md:text-lg">Open</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    <div class="py-4">
        {{ $this->posts->links() }}
    </div>
</div>
