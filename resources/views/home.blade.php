@extends('layouts.app')

<link rel="stylesheet" href="{{ asset("css/profilePicker.css") }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome {{auth()->user()->name}} !</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    Set your profile picture and a brief bio about you and start chatting with your contacts!
                    <br><br>
                    <!-- profile setup -->
                    <h4> choose your profile: </h4>
                    <div class="container">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <form action="/edit-profile" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" name="profile"/>
                                <label for="imageUpload">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16"
                                        style="margin-left:10px ; margin-top:6px">
                                        <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                                    </svg>
                                </label>
                            
                            </div>
                            <div class="avatar-preview">
                                <div id="imagePreview" style="background-image: url({{asset("storage/profiles/".auth()->user()->profile)}});">
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4> set up a brief bio : </h4>
                    
                    <br>
                    <input type="text" placeholder=" your bio" id="about" name="about"
                     style="width: 80% ; height:50px ; border-radius:10px"
                    value="{{auth()->user()->about}}">
                    <br><br>
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save') }}
                    </button>



                </form>

                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<script>
    window.onload = function() {
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url('+e.target.result +')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });
    }

</script>
