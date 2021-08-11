    <x-slot name="header">

    </x-slot>

<div class="flex">
    <div class="py-8 ">
        <div class="mx-auto max-w-6xl  sm:px-1 lg:px-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                        <div class="card">
                          <div class="card-header">
                            Users:
                          </div>
                          <div class="card-body chatbox p-0">
                            <ul class="list-group list-group-flush">
                            @foreach($users as $user)

                            @if($user->id !== auth()->id())
                            @php
                                $not_seen = App\Models\Message::where('user_id', $user->id)
                                ->where('receiver_id', auth()->id())->where('is_seen',false)->get() ?? null
                            @endphp 
                                <a wire:click="getUser({{ $user->id }})" class="text-dark link">
                                <li class="pl-3">
                                    <div class="group flex items-center">
                                        <img class="w-10 h-10 bg-gray-300 rounded-full flex-shrink-0" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60" alt="">
                                       @if($user->is_online==true)
                                        <x-icons.user-circle  />
                                        @endif
                                        {{ $user->name }}
                                        @if(filled($not_seen))
                                        <span class="group-hover:bg-yellow-300 bg-yellow-500 ml-3 inline-block py-0.5 px-3 text-xs font-medium rounded-full">
                                            {{ $not_seen->count() }}
                                        </span>
                                        @endif
                                    </div>
                                </li>
                                </a>
                                @endif
                            @endforeach
                            </ul>
                          </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="py-8">
        <div class="mx-auto max-w-3xl sm:px-1 lg:px-1">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                        <div class="card">
                          <div class="card-header">@if(isset($sender)) {{ $sender->name }} @endif </div>
                          <div class="card-body">Messages</div>
                          <div class="bg-white" wire:poll="mountdata">
                        @if(filled($allmessages))
                            @foreach($allmessages as $mgs)
                              <div >@if($mgs->user_id == auth()->id()) Sent @else Received  @endif
                                <p>{{ $mgs->user->name }}</p>
                                {{ $mgs->message }} 
                                <br><p class='text-sm'> <em>
                                   {{ $mgs->created_at }} 
                                </em></p>
                              </div>
                            @endforeach
                        @endif
                          </div>
                          <div class="card-footer"></div>
                                <form  wire:submit.prevent="sendMessage">
                                    <div class="row">
                                        <span class="flex">
                                        <div class="col-md-8">
                                            <!-- <input type="text" name="senderId">{{ $user->id }}</input> -->
                                            <input type="text" wire:model="message" class="form-control">
                                        </div>
                                        <div class="ml-4 align-middle">
                                            <button class="bg-blue-700 text-white px-3" type="submit">
                                                Send
                                            </button>
                                        </div>
                                        </span>
                                    </div>
                                </form>
                            
                          </div>
                        </div>
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>