@extends('layouts.app')

<link rel="stylesheet" href="{{ asset("css/chat.css") }}">
@section('content')
<div class="container">
    <div class="row justify-content-center">


                    <section class="msger">
                        <header class="msger-header">
                          <div class="msger-header-title">
                            <i class="fas fa-comment-alt"></i> Chat with <b>{{$messagedUser->name}}</b> , {{$messages->count()}} messages.
                            <br>
                            
                          </div>
                          <div class="msger-header-options">
                            <span><i class="fas fa-cog"></i></span>
                          </div>
                        </header>
                      
                        <main class="msger-chat">
                          <div class="status-bar">
                            {{$messagedUser->about}}
                          </div>
                          @foreach ($messages as $message)
                            @if($message->sender_id==$messagedUser->id)
                            
                              <div class="msg left-msg">
                                <div
                                class="msg-img"
                                style="background-image: url({{asset('storage/profiles/'.$messagedUser->profile)}}"
                                ></div>
                          
                                <div class="msg-bubble">
                                  <div class="msg-info">
                                    <div class="msg-info-name">{{$messagedUser->name}}</div>
                                    <div class="msg-info-time">{{$message->created_at->diffForHumans()}}</div>
                                  </div>
                          
                                  <div class="msg-text">
                                   {{$message->body}}
                                  </div>
                                </div>
                              </div>

                            @else
                              <div class="msg right-msg">
                                <div
                                class="msg-img"
                                style="background-image: url({{asset('storage/profiles/'.auth()->user()->profile)}})"
                                ></div>
                          
                                <div class="msg-bubble">
                                  <div class="msg-info">
                                    <div class="msg-info-name">{{auth()->user()->name}}</div>
                                    <div class="msg-info-time">{{$message->created_at->diffForHumans()}}</div>
                                  </div>
                          
                                  <div class="msg-text">
                                    {{$message->body}}
                                  </div>
                                </div>
                              </div>
                            @endif
                          @endforeach
                        </main>
                      
                        <div class="msger-inputarea">
                          <input type="text" name="body"  class="msger-input" placeholder="Enter your message...">
                          <button type="submit" id="button" class="msger-send-btn">Send</button>
                        </div>
                      </section>

    </div>
</div>
@endsection

@section('scripts')
<script>
  
  window.onload = function() {
      listen();
      const msgerForm = get(".msger-inputarea");
      const msgerInput = get(".msger-input");
      const msgerChat = get(".msger-chat");
      const btn=document.getElementById('button');
      

      btn.addEventListener('click',post);
      function post() {
        const msgText = msgerInput.value;
        if (!msgText) return;
        
        //send post request
        var csrfToken = "{{ csrf_token() }}";
        var xhr= new XMLHttpRequest();
          var parameters='body='+ msgText ;
          xhr.open('POST','/users/{{$messagedUser->id}}/chat',true);
          xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
          xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);

          xhr.onload = function(){
          appendMessage("{{auth()->user()->name}}","{{asset('storage/profiles/'.auth()->user()->profile)}}", "right", msgText);
            console.log(this.response);
          }
          xhr.send(parameters);
        msgerInput.value = "";
      }


      function appendMessage(name, img, side, text) {
        //   Simple solution for small apps
        const msgHTML = `
          <div class="msg ${side}-msg">
            <div class="msg-img" style="background-image: url(${img})"></div>

            <div class="msg-bubble">
              <div class="msg-info">
                <div class="msg-info-name">${name}</div>
                <div class="msg-info-time">${formatDate(new Date())}</div>
              </div>

              <div class="msg-text">${text}</div>
            </div>
          </div>
        `;
        msgerChat.insertAdjacentHTML("beforeend", msgHTML);
        msgerChat.scrollTop += 500;
      }

      function get(selector, root = document) {
        return root.querySelector(selector);
      }

      function formatDate(date) {
        const h = "0" + date.getHours();
        const m = "0" + date.getMinutes();
        return `${h.slice(-2)}:${m.slice(-2)}`;
      }

      function listen() {
                        Echo.private('chat.'+{{$messagedUser->id}}+'.'+{{auth()->user()->id}})
                            .listen('NewMessage', function (message){
                              console.log('listened');
                               appendMessage(message.sender.name,"{{asset('storage/profiles/'.$messagedUser->profile)}}",'left',message.body );
                            })
                        }
  }
  
</script>
@endsection