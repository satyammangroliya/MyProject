<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-primary">
      <a class="navbar-brand" href="#">Navbar</a>
      <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
          aria-expanded="false" aria-label="Toggle navigation"></button>
      <div class="collapse navbar-collapse" id="collapsibleNavId">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <li class="nav-item active">
                  <a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                  <a class="nav-link" href="{{url('/register')}}">Register <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item active">
                  <a class="nav-link" href="{{url('/customer')}}">Customer <span class="sr-only">(current)</span></a>
              </li>
              
          </ul>
          <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="text" placeholder="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
          </form>
      </div>
  </nav>
      <form action="{{url('/')}}/register" method="post">
        @csrf
        
   <div class="container">
        <x-input type="text" name="name" label="Please enter your name"/>
        <x-input type="email" name="email" label="Please enter your email"/>
        <x-input type="password" name="password" label="Password"/>
        <x-input type="password" name="password_confirm" label="Please confirm your password"/>
        <button   class="btn btn-primary">Submit</button>
   </div>
</form>
  </body>
</html>