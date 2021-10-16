@extends('layouts.app')
<style>
    .contact-bar{
        border-left: #0069d9 solid 6px;
        border-bottom: rgb(173, 173, 173) solid 1px;
        background-color: rgba(0,0,0,.03);
        margin-left: 1px;
        margin-right: 1px;
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Your contacts</div>
                    <br>
                <!--add contact-->
                <form method="POST" action="/add-contact">
                    @csrf
                <div class="container" style="margin-top: 10px">
                    <div class="row">
                        <div class="col-md-8">
                            <input type="text" name="email"
                             placeholder="enter an email to add a new contact..." style="width: 100%;">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __(' + Add contact') }}
                            </button>
                        </div>
                    </div>
                 </div>
                 @if (session('error'))
                 <div class="alert alert-warning">
                     <br>
                     {{ session('error') }}
                 </div>
                 @endif
                 <hr>
                </form>
             
                <!--end add contact-->
            
            @foreach ($contacts as $contact)
                
            
            <!--contact-->  
            <div class="contact-bar">        
            <a href="/users/{{$contact->id}}/chat">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <img src="{{asset('storage/profiles/'.$contact->profile)}}" 
                        style="width:100px;height:100px;border-radius:50%;padding:15px;">
                    </div>
                    <div class="col-md-8" style="padding:20px;">
                        {{$contact->name}}
                        <br>
                        {{$contact->email}}
                    </div>
                </div>
            </div>
            </a>
            </div>
            <!--end contact-->
            	
            @endforeach
    

               
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    window.onload = function() {
   
}

</script>
