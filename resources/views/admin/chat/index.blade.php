@extends('admin.layouts.master')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Chat Box</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Components</a></div>
                <div class="breadcrumb-item">Chat Box</div>
            </div>
        </div>

        <div class="section-body">

            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-sm-6 col-lg-3">
                    <div class="card" style="height: 70vh;">
                        <div class="card-header">
                            <h4>Who's Online?</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled list-unstyled-border">
                                @foreach ($senders as $sender)
                                    @php
                                        $chatUser = \App\Models\User::find($sender->sender_id);
                                        $unseenMessages = \App\Models\Chat::where([
                                            'sender_id' => $chatUser->id,
                                            'receiver_id' => auth()->user()->id,
                                            'seen' => 0,
                                        ])->count();
                                    @endphp

                                    <li class="media fp_chat_user" data-name="{{ $chatUser->name }}"
                                        data-user="{{ $chatUser->id }}" style="cursor: pointer;">
                                        <img alt="image" class="mr-3 rounded-circle"
                                            style="width: 50px !important; height:50px !important; object-fit:cover !important;"
                                            src="{{ asset($chatUser->avatar) }}">
                                        <div class="media-body">
                                            <div class="mt-0 mb-1 font-weight-bold">{{ $chatUser->name }}</div>
                                            <div class="text-warning text-small font-600-bold got_new_message">
                                                @if ($unseenMessages > 0)
                                                    <i class="beep"></i>new message
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-lg-9">
                    <div class="card chat-box" id="mychatbox" data-inbox="" style="height: 70vh;">
                        <div class="card-header">
                            <h4 id="chat_header"></h4>
                        </div>
                        <div class="card-body chat-content">
                        </div>
                        <div class="card-footer chat-form">
                            <form id="chat-form">
                                @csrf
                                <input type="text" class="form-control fp_send_message" placeholder="Type a message"
                                    name="message">
                                <input type="hidden" name="receiver_id" id="receiver_id" value="">
                                <input type="hidden" name="msg_temp_id" class="msg_temp_id" value="">
                                <button class="btn btn-primary">
                                    <i class="far fa-paper-plane"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            function scrollToBottom() {
                let chatContent = $('.chat-content');
                chatContent.scrollTop(chatContent.prop('scrollHeight'));
            }

            var userId = "{{ auth()->user()->id }}";

            $('#receiver_id').val("");



            $('.fp_chat_user').on('click', function() {
                let senderId = $(this).data('user');
                let senderName = $(this).data('name');

                $('#mychatbox').attr('data-inbox', senderId);

                $(this).find('.got_new_message').empty();

                $('#receiver_id').val(senderId);
                $.ajax({
                    method: 'GET',
                    url: '{{ route('admin.chat.get-conversation', ':senderId') }}'.replace(
                        ':senderId',
                        senderId),
                    beforeSend: function() {
                        $('.chat-content').empty();
                        $('#chat_header').text(senderName);
                    },
                    success: function(response) {
                        console.log(response);

                        $('.chat-content').empty();
                        $.each(response, function(index, message) {
                            let avatar = "{{ asset(':avatar') }}".replace(':avatar',
                                message.sender.avatar);
                            avatar = avatar.replace(/\/\/uploads/, '/uploads');
                            console.log(avatar, 'ktu jemi ne pik');
                            let html = `
                            <div class="chat-item ${message.sender_id == userId ? "chat-right" : "chat_left"} " style=""><img src="${avatar}" style="height:50px; width:50px; object-fit:cover;">
                                    <div class="chat-details">
                                        <div class="chat-text">${message.message}</div>

                                    </div>
                                </div>
                            `;

                            $('.chat-content').append(html);
                        });
                        scrollToBottom();
                    },
                    error: function(xhr, status, error) {

                    },
                    complete: function() {

                    },
                })
            });


            //Send Message
            $('#chat-form').on('submit', function(e) {
                e.preventDefault();

                var msgId = Math.floor(Math.random() * (1 - 10000 + 1)) + 10000;
                // console.log('test', msgId)
                $('.msg_temp_id').val(msgId);

                let formData = $(this).serialize();
                let avatar = "{{ auth()->user()->avatar }}";
                $.ajax({
                    method: 'POST',
                    url: "{{ route('admin.chat.send-message') }}",
                    data: formData,
                    beforeSend: function() {
                        let message = $('.fp_send_message').val();
                        // console.log("{{ auth()->user()->avatar }}");
                        if (message) {
                            let html = `
                            <div class="chat-item chat-right" style=""><img src="${avatar}">
                                    <div class="chat-details">
                                        <div class="chat-text">${message}</div>
                                        <div class="chat-time ${msgId}">sending...</div>
                                    </div>
                                </div>
                            `;

                            $('.chat-content').append(html);
                            $('.fp_send_message').val('');
                            scrollToBottom();
                        }
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.msgId == $('.msg_temp_id').val()) {
                            console.log('hello');
                            $('.' + msgId).remove();
                        }
                    },
                    error: function(xhr, status, error) {

                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value);
                        });
                    },
                })
            });
        });
    </script>
@endpush
