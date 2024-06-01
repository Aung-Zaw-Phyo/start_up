<div 
    x-data="{isShow: @entangle('showForm')}"
>
    <div class="p-3 md:px-6 mb-1.5 bg-white rounded-md shadow-sm flex flex-col justify-center items-center">
        <img class="mx-auto rounded-full mb-4" width="140" src="{{ $this->user->image }}" alt="">
        <h1 class="text-lg font-semibold">{{ $this->user->name }}</h1>
        <p>{{ $this->user->email }}</p>
    </div>

    <div class="py-3 mb-1.5 flex justify-between items-center gap-3">
        <div class="flex gap-3">
            <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option class="" value="">Latest</option>
                <option class="" value="">Oldest</option>
                <option class="" value="">Popular</option>
            </select>
            <x-input 
                placeholder="Enter the keywords"
            />
        </div>
        <div>
            <x-button @click="isShow=true">Create Post</x-button>
        </div>
    </div>

    <div 
        class="p-3 md:px-6 mb-1.5 bg-white rounded-md shadow-sm "
        x-show="isShow"
        x-transition.origin.top.right.duration.300
        @closeForm.window="isShow = false"
        x-cloak  
    >
        <div class="p-3 mx-auto lg:w-[70%]">
            <h1 class="uppercase font-semibold text-lg text-center mb-4">Create Post</h1>
            <div class="mb-3">
                <textarea 
                    wire:model="title"
                    name="" 
                    id="" 
                    placeholder="Enter your message"
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    cols="30" rows="2"></textarea>
                @error('title')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <textarea 
                    wire:model="content"
                    name="" 
                    id="" 
                    placeholder="Enter your message"
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    cols="30" rows="5"></textarea>
                @error('content')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4 ">
                <div class="border rounded-md shadow-sm">
                    <input 
                        type="file" wire:model="images" multiple accept=".png, .jpg, .jpeg"
                        class="w-full p-2 !border-gray-600 outline-gray-300 focus:outline-indigo-500 focus:!border-indigo-500 focus:!ring-indigo-500 rounded-md shadow-sm"
                    >
                </div>
                @error('images')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror

                @if ($this->images)
                    <div class="p-3 rounded-md mt-3 flex flex-wrap gap-3 bg-[#F3F4F6]">
                        @foreach ($this->images as $image)
                            <img class="rounded-sm w-24 md:w-36" src="{{ $image->temporaryUrl() }}" alt="">
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="flex justify-end gap-3">
                <x-secondary-button @click="isShow=false" class="h-10 justify-center">Close</x-secondary-button>
                <x-button wire:click="submit" class="h-10 justify-center">Submit</x-button>
            </div>
        </div>
    </div>

    <div class="p-3 rounded border-none bg-white bg-opacity-60">
        @foreach ($this->posts as $post)
            <div class="p-3 md:px-6 mb-1.5 bg-white rounded-md shadow-sm flex gap-3 relative">
                <div class="p-3 hidden md:flex flex-col items-center border-r border-gray-500">
                    <h1 class="font-bold text-blue-600 text-2xl mb-3">{{ $post->vote }}</h1>
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
                                    <img width="80" src="{{ asset('storage/' . $image->path) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <div class="flex justify-between items-center w-full">
                        <div class="flex gap-3 items-center">
                            {{-- <img class="w-[40px] h-[40px] rounded-full" src="{{ $post->user->image }}" alt="">
                            <h1 class="text-gray-500">{{ $post->user->name }}</h1> --}}
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
    
</div>
