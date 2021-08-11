<x-slot name="header">
</x-slot>
<!-- component -->
<!-- This is an example component -->
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
                    <div id="chat"  wire:poll="mountdata" class="w-full overflow-y-auto p-10 relative" style="height: 700px;" ref="toolbarChat">
                        <ul>
                            <li class="clearfix2">
                            @if(filled($allmessages))
                            @foreach($allmessages as $mgs)
                                <div class="w-full flex justify-start">
                                    <div class="bg-gray-100 rounded px-5 py-2 my-2 text-gray-700 relative" style="max-width: 300px;">
                                        <span class="block">{{ $mgs->message }} </span>
                                        <span class="block text-xs { @if($mgs->user_id == auth()->id()) } text-left { @else} text-right  {@endif}"> {{ $mgs->created_at }} </span>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                            </li>
                        </ul>
                    </div>

                    <div class="w-full py-3 px-3 flex items-center justify-between border-t border-gray-300">
                       <form wire:submit.prevent="sendMessage"> 
                        <input  wire:model="message" aria-placeholder="type your message here" placeholder="type your message here"
                            class="py-2 mx-3 pl-5 block w-full rounded-full bg-gray-100 outline-none focus:text-gray-700" type="text" name="message" required/>

                        <button class="outline-none focus:outline-none" type="submit">
                            <svg class="text-gray-400 h-7 w-7 origin-center transform rotate-90" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                            </svg>
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>