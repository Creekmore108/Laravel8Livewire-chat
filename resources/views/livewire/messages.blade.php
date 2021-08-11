    <x-slot name="header">

    </x-slot>

    <div class="w-screen">
    <div class="grid grid-cols-3 min-w-full border rounded" style="min-height: 80vh;">
            <div class="col-span-1 bg-white border-r border-gray-300">
                
                <ul class="overflow-auto" style="height: 500px;">
                    <h2 class="ml-2 mb-2 text-gray-600 text-lg my-2">Members</h2>
                    <li>
                    @foreach($users as $user)

                    @if($user->id !== auth()->id())
                    @php
                        $not_seen = App\Models\Message::where('user_id', $user->id)
                        ->where('receiver_id', auth()->id())->where('is_seen',false)->get() ?? null
                    @endphp 
                        <a wire:click="getUser({{ $user->id }})" class="hover:bg-gray-100 border-b border-gray-300 px-3 py-2 cursor-pointer flex items-center text-sm focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                <img class="h-10 w-10 rounded-full object-cover"
                                src="https://images.pexels.com/photos/837358/pexels-photo-837358.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260"
                                alt="username" />
                                <div class="w-full pb-2">
                                    <div class="flex">
                                        
                                        <span class="block ml-2 font-semibold text-base text-gray-600 ">{{ $user->name }}</span>
                                        @if($user->is_online==true)
                                        <span class="block text-sm ml-2"><x-icons.user-circle  /></span>
                                        @endif
                                        @if(filled($not_seen))
                                            <span class="group-hover:bg-yellow-300 bg-yellow-500 ml-3 inline-block py-0.5 px-3 text-xs font-medium rounded-full">
                                                {{ $not_seen->count() }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </a>
                            @endif
                            @endforeach
                            </li>
                </ul>
            </div>

    <div class="col-span-2 bg-white">
                <div class="w-full">
                    <div class="flex items-center border-b border-gray-300 pl-3 py-3">
                        <img class="h-10 w-10 rounded-full object-cover"
                        src="https://images.pexels.com/photos/3777931/pexels-photo-3777931.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260"
                        alt="username" />
                        <span class="block ml-2 font-bold text-base text-gray-600">{{ Auth::user()->name }}</span>
                        <span class="connected text-green-500 ml-2" >
                            <svg width="6" height="6">
                                <circle cx="3" cy="3" r="3" fill="currentColor"></circle>
                            </svg>
                        </span>
                    </div>
                    <div id="chat"  wire:poll="mountdata" class="w-full overflow-y-scroll p-1 relative bottom-1" style="height: 600px;" ref="toolbarChat">
                        <ul>
                            <li class="clearfix">
                            @if(filled($allmessages))
                            @foreach($allmessages as $mgs)
                                @if($mgs->user_id == auth()->id())
                                <div class="w-full flex justify-end">
                                    <div class="bg-gradient-to-l from-yellow-700 to-white  rounded-l-xl shadow-xl px-5 py-2 my-2 text-gray-700 relative" style="max-width: 300px;">
                                        <p class="flex flex-wrap">{{ $mgs->message }} </p>
                                        <span class="block text-xs">sent {{ $mgs->created_at }} </span>
                                    </div>
                                </div>
                                @else
                                <div class="w-full flex justify-start">
                                    <div class="bg-gradient-to-r from-yellow-400 to-white rounded-r-xl shadow-xl px-5 py-2 my-2 text-gray-700 relative" style="max-width: 300px;">
                                        <p class="flex flex-wrap">{{ $mgs->message }} </p>
                                        <span class="block text-xs">received {{ $mgs->created_at }} </span>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                            @endif
                            </li>
                        </ul>
                    </div>
                    <form wire:submit.prevent="sendMessage">
                    <div class="w-full py-3 px-3 flex items-center justify-between border-t border-gray-300">
                        
                            <input  wire:model="message" aria-placeholder="type your message here" placeholder="type your message here"
                            class="py-2 mx-3 pl-5 block w-full rounded-full bg-gray-100 outline-none focus:ring-yellow-600 focus:border-yellow-600 focus: focus:text-gray-700" type="text" name="message" required/>

                            <button class="outline-none focus:outline-none" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg"  class="text-yellow-600 h-7 w-7 origin-center transform rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                            </svg>
                            </button>
                        
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>