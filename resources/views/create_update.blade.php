<html>

<head>
<link rel="stylesheet" href="{{ asset('css/create_update.css') }}" type="text/css">
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

@php
$update = false;
$id = $name = $email = $contact_no = $address = "";

if(isset($data)) {

    $update = true;

    $id = $data['id'];
    $name = $data['name'];
    $email = $data['email'];
    $contact_no = $data['contact_no'];
    $address = $data['address'];
    $image = 'public/uploads/'.$data['image'];
}
@endphp

<form action="@if($update) {{ url('update') }} @else {{ 'create' }} @endif" method="POST" enctype="multipart/form-data">
@csrf
@if($update)
<input type = "hidden" name = "id" value = "{{ $id }}">
@endif
@if($update && $data->image == null)
<div class="imgcontainer">
    <img class="avatar" id="avatar" src="{{ Storage::url('public/images/default_profile_pic.webp') }}" alt="Avatar" >
</div>
@elseif($update)
<div class="imgcontainer">
    <img class="avatar" id="avatar" src="{{ Storage::url($image) }}" alt="Avatar" >
</div>
@else
<div class="imgcontainer">
    <img class="avatar" id="avatar" src="{{ Storage::url('public/images/default_profile_pic.webp') }}" alt="Avatar" >
</div>
@endif
<div class="input-group">
    <label>Name</label>
     <input type = "text" name = "name" placeholder = "Enter Your Name" value = "@if(old('name')!=null){{ old('name') }}@else{{ $name }}@endif" required> <br>
     <span style="color: red">@error("name"){{ $message }}@enderror</span>
     <br>
</div>
<div class="input-group">
    <label>Email</label>
     <input type = "email" name = "email" placeholder = "Enter Your Email" value = "@if(old('email')!=null){{ old('email') }}@else{{ $email }}@endif" required> <br>
     <span style="color: red">@error("email"){{ $message }}@enderror</span>
     <br>
</div>
<div class="input-group">
    <label>Contact No.</label> 
     <input type = "tel" name = "contact_no" placeholder = "Enter Your Contact No." value = "@if(old('contact_no')!=null){{ old('contact_no') }}@else{{ $contact_no }}@endif" required> <br>
     <span style="color: red">@error("contact_no"){{ $message }}@enderror</span>
     <br>
</div>
<div class="input-group">
    <label>Address</label>
     <input type = "text" name = "address" placeholder = "Enter Your Address" value="@if(old('address')!=null){{ old('address') }}@else{{ $address }}@endif" required> <br>
     <span style="color: red">@error("address"){{ $message }}@enderror</span>
     <br>
</div>
<div class="input-group">
    <label>Upload Image</label> <input style="padding:0; height:26px;" type = "file" name="image" id="image"> <br>
     <span style="color: red">@error("image"){{ $message }}@enderror</span>
     <br>
</div>
@if($update) 
<input class = "form_btn" type = "submit" value = "Update">
@else
<input class = "form_btn" type = "submit" value = "Create">
@endif
<br><br>
</form>
<button class = "main_btn" onclick="document.location='/dashboard'">Back To Dashboard</button>


<script type="text/javascript">

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#avatar').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
}
$("#image").change(function(){
    readURL(this);
});
</script>

</body>
</html>