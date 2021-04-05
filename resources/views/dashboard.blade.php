<html>
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}" type="text/css"> 
    </head>
<body>
<h1>DASHBOARD</h1>

@if($message = Session::get('success'))
<div id="msg_positive" class="msg_positive">
{{ $message }} 
</div>
@endif

<table border="1">
    <tr>
        <th>S.No.</th>
        <th>Profile Picture</th>
        <th>Name</th>
        <th>Email</th>
        <th>Contact No.</th>
        <th>Address</th>
        <th class="th_center" colspan="2">Action</th>
    </tr>
    @foreach ($users as $sNo => $user)
    <tr>
        <td>{{ ($users->currentPage() - 1) * 5 + ++$sNo }}</td>
        @if($user->image == null)
        <td><img src="{{ Storage::url('public/images/default_profile_pic.webp') }}" style="width:100px; height:100px;"></td>
        @else
        <td><img src="{{ Storage::url('public/uploads/'.$user->image) }}" style="width:100px; height:100px;"></td>
        @endif
        <td>{{ $user->name }}</td>
        <td>{{ $user['email'] }}</td>
        <td>{{ $user['contact_no'] }}</td>
        <td>{{ $user['address'] }}</td>
        <td> <button style = "height: 100%; width: 100%;" class = "edit_btn" onclick = "document.location = '{{ 'edit/'.$user['id'] }}'" >Update</button> </td>
        <td>
            <form style = "height: 100%;" action = "delete" method = "POST">
                @csrf
                <input type = "hidden" name = "id" value = "{{ $user['id'] }}">
                <input class = "del_btn" onclick= "return confirm('Are you sure?');" type = "submit" value = "Delete">
             </form>
        </td>
    </tr>   
    @endforeach
</table>

<br>
<button class="create_btn" onclick="document.location='create'">Create</button>

<span class="d-flex justify-content-center">
    {{ $users->links() }}
</span> 

<script>
    setTimeout(  
       function() {
          document.getElementById("msg_positive").style.display = "none";
    }, 3000); // 3000 milliseconds = 3 seconds
</script>
</body>
</html>