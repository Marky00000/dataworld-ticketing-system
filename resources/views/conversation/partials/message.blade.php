@php
    $isOwnMessage = $msg->user_id === $user->id;
    $isInternal = $msg->is_internal_note;
    $messageType = $msg->message_type;
@endphp

@if($messageType === 'status_change' || $messageType === 'assignment_change' || $messageType === 'priority_change' || $messageType === 'system_note')
    <!-- System Message -->
    <div class="flex justify-center my-2">
        <div class="system-message">
            <i class="fas fa-{{ $messageType === 'status_change' ? 'exchange-alt' : ($messageType === 'assignment_change' ? 'user-check' : 'flag') }} mr-1"></i>
            {{ $msg->message }}
            <span class="ml-1 text-gray-500">• {{ $msg->created_at->diffForHumans() }}</span>
        </div>
    </div>
@else
    <!-- Regular Message -->
    <div class="flex items-start space-x-2 {{ $isOwnMessage ? 'justify-end' : '' }} message" data-id="{{ $msg->id }}">
        @if(!$isOwnMessage && !$isInternal)
            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center text-gray-600 text-sm font-medium flex-shrink-0">
                {{ substr($msg->user->name ?? 'S', 0, 1) }}
            </div>
        @endif
        
        <div class="message-bubble 
            {{ $isOwnMessage ? 'sent' : 'received' }}
            {{ $isInternal ? 'internal-note' : '' }}">
            
            @if(!$isOwnMessage && !$isInternal)
                <p class="text-xs font-medium text-gray-600 mb-1">{{ $msg->user->name }}</p>
            @endif
            
            @if($isInternal)
                <p class="text-xs font-medium text-yellow-700 mb-1 flex items-center">
                    <i class="fas fa-lock mr-1"></i> Internal Note
                </p>
            @endif
            
            <p class="text-sm">{{ $msg->message }}</p>
            
            @if($msg->attachments)
                <div class="mt-2 space-y-1">
                    @foreach(json_decode($msg->attachments) as $attachment)
                    <a href="#" class="text-xs {{ $isOwnMessage ? 'text-blue-100' : 'text-primary' }} hover:underline flex items-center">
                        <i class="fas fa-paperclip mr-1"></i>
                        {{ $attachment }}
                    </a>
                    @endforeach
                </div>
            @endif
            
            <div class="message-time flex items-center justify-end space-x-1 {{ $isOwnMessage ? 'text-blue-100' : 'text-gray-500' }}">
                <span>{{ $msg->created_at->format('g:i A') }}</span>
                @if($isOwnMessage)
                    <i class="fas fa-check-double text-xs"></i>
                @endif
            </div>
        </div>
        
        @if($isOwnMessage || $isInternal)
            <div class="w-8 h-8 {{ $isInternal ? 'bg-yellow-500' : 'bg-primary' }} rounded-full flex items-center justify-center text-white text-sm font-medium flex-shrink-0">
                @if($isInternal)
                    <i class="fas fa-lock text-xs"></i>
                @else
                    {{ substr($user->name, 0, 1) }}
                @endif
            </div>
        @endif
    </div>
@endif