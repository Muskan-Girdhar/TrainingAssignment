@extends('layout')
@section('content')
<div>
<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="yourpost">Posts</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="yourdraft">Draft</a>
  </li>
 
</ul>

<div>
@foreach($users as $user)
   <div>
   <div class="container-fluid mb-3 heightset">
            <div class="row border border-black">
                
                <div class="col-md-7 d-flex flex-column justify-content-center align-items-center p-4">
                    
                    <h1  font-family: 'Righteous', cursive;>  </h1>
                    <button type="button" class="btn btn-info">Tittle-{{$user->tittle}}</button>
                    <h4 class=" fs-4" style="font-family: 'Kalam', cursive;">Description-{{$user->description}}</h4>
                </div>
                <div class="col-md-4">
                <iframe  height="200" width="400"src="/assets/{{$user->file}}"></iframe>
                   
                </div>
            </div>
        </div>
      
    </div>
    @endforeach
</div>

</div>

@endsection