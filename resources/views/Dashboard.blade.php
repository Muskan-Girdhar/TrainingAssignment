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
    <nav class="navbar bg-body-tertiary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand">Welcome {{$data->name}}</a>
    <form class="d-flex" role="search">
    <a style="margin:2px"class="btn btn-outline-secondary" form-control me-2" type="submit" href="">Yours Data</a>   
    <a style="margin:2px"class="btn btn-outline-secondary" form-control me-2" type="submit" href="addpost">Addpost</a>
      <a style="margin:2px"class="btn btn-outline-secondary" form-control me-2" type="submit" href="logout">Logout</a>
    </form>
  </div>
</nav>  

</div>
<div>
@include('DashboardHeader')
</div>
<div>
    
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>
