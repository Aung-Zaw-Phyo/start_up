<div 
    class=""
    x-data="{isShow: @entangle('showForm')}"
>
    <div class="p-3 md:px-6 mb-1.5 bg-white rounded-md shadow-sm relative">
        <a wire:navigate href="{{$this->backPageRoute}}" class="absolute top-0 -right-[80px] inline-flex items-center px-4 py-2 bg-gray-800 bg-opacity-70 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150">Back</a>

        <div class="">
            <div class="">
                <p class="absolute top-0 right-0 p-2 pl-8 bg-white bg-opacity-85 text-sm">{{ $this->post->created_at->diffForHumans()}}</p>
                <div class="flex md:hidden mb-1.5">
                    <h1 class="font-bold text-blue-600 text-lg">{{ count($this->post->votes) }}</h1>
                    <div class="text-xs text-gray-400">Voted</div>
                </div>
                <h1 class="md:text-lg font-semibold mb-2">{{ $this->post->title }}</h1>
                <p class="leading-6 mb-4">{{ $this->post->content }}</p>
                <div class="mb-4">
                    @if (count($this->post->images))
                        <div class="flex justify-center gap-6 py-4 bg-gray-100 rounded-lg mb-3">
                            @foreach ($this->post->images as $image)
                                <div class="bg-white border border-gray-300 rounded-lg p-4">
                                    <img width="80" src="{{ asset($image->path) }}" alt="">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="flex justify-between items-center flex-wrap mb-8 gap-3">
                    <div class="flex gap-3 items-center">
                        <img class="w-[45px] h-[45px] sm:w-[55px] sm:h-[55px] rounded-full" src="{{ $this->post->user->image }}" alt="">
                        <h1 class="text-lg font-semibold">{{ $this->post->user->name }}</h1>
                        <a href="#" class="underline text-gray-500 text-lg">Message</a>
                    </div>
                    <div class="flex items-center justify-end flex-wrap gap-3">
                        <div class="flex items-center">
                            <div class="px-3 py-1.5 rounded-lg text-blue-600 text-lg font-bold">
                                {{ count($this->post->votes) }} Votes
                            </div>
                            <x-button wire:click="vote">Vote</x-button>
                        </div>
                        <x-button @click="isShow=true">Post Comment</x-button>
                    </div>
                </div>
            </div>

            <div>
                <p class="mr-6 text-gray-600 text-xl mb-3">Comments ({{ count($this->post->comments) }})</p>
                @foreach ($this->post->comments as $comment)
                    <div class="mb-3 p-3 shadow rounded-lg flex gap-3 relative">
                        <img class="w-[40px] h-[40px] sm:w-[50px] sm:h-[50px] rounded-full" src="{{ $comment->user->image }}" alt="">
                        <div class="">
                            <div class="absolute top-1 right-1 p-2 pl-3 bg-white bg-opacity-85 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 12.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5ZM12 18.75a.75.75 0 1 1 0-1.5.75.75 0 0 1 0 1.5Z" />
                                </svg>
                            </div>
                            <h1 class="font-semibold">{{ $comment->user->name }}</h1>
                            <p class="text-gray-600 text-sm mb-2">{{ $comment->created_at->diffForHumans() }}</p>
                            <p>{{ $comment->content }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div 
        x-show="isShow"
        x-transition.origin.top.right.duration.300
        @closeForm.window="isShow = false"
        class="
            fixed w-screen h-screen overflow-y-scroll overscroll-contain top-0 bottom-0 
            right-0 left-0 bg-black bg-opacity-70 flex justify-center items-center
        "
    >
        <div x-cloak @click.away="isShow=false" class="p-3 shadow-dialog  sm:p-6 bg-white shadow-lg  rounded-lg">
            <h1 class="uppercase font-semibold text-lg text-center mb-4">Post Comment</h1>
            <div class="mb-3">
                <textarea 
                    wire:model="content"
                    name="" 
                    id="" 
                    placeholder="Enter your message"
                    class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    cols="30" rows="3"></textarea>
                @error('content')
                    <div class="text-red-600">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <input 
                    type="file"
                    class="w-full p-2 !border-gray-300 outline-gray-300 focus:outline-indigo-500 focus:!border-indigo-500 focus:!ring-indigo-500 rounded-md shadow-sm"
                >
            </div>
            <x-button wire:click="submit" class="inline-flex w-full h-10 justify-center">Submit</x-button>
        </div>
    </div>
</div>
