<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <div>
@include('Header')
</div>
<div>
@include('DashboardHeader')
</div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>