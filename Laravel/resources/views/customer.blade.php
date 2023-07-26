<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Registration Form</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
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
  <div class="container mt-5">
    <h1>{{$title}}</h1>
    <form action="{{$url}}" method="post">
      @csrf
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" class="form-control" name="name" placeholder="Enter your name" value="{{$customer->name}}" >
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" name="email" placeholder="Enter your email" value="{{$customer->email}}">
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" name="password" placeholder="Enter your password" >
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirm Password:</label>
        <input type="password" class="form-control" name="confirm-password" placeholder="Confirm your password" >
      </div>
      <div class="form-group">
        <label for="country">Country:</label>
        <input type="text" class="form-control" name="country" value="{{$customer->country}}" placeholder="Enter your Country" >
      </div>
      <div class="form-group">
        <label for="state">State:</label>
        <input type="text" class="form-control" name="state" value="{{$customer->state}}" placeholder="Enter your state" >
      </div>
      <div class="form-group">
        <label for="address">Address:</label> 
        <textarea class="form-control" name="address"  placeholder="Enter your address" >{{$customer->address}}</textarea>
      </div>
      <div class="form-group">
        <label>Gender:</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="male" value="M"
          {{$customer->gender == "M"? "checked" : ""}} >
          <label class="form-check-label" for="M">
            Male
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="female" value="F" {{$customer->gender == "F"? "checked" : ""}}>
          <label class="form-check-label" for="F">
            Female
          </label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gender" id="other" value="O" {{$customer->gender == "O"? "checked" : ""}}>
          <label class="form-check-label" for="O">
            Other
          </label>
        </div>
      </div>
      <div class="form-group">
        <label for="dob">Date of Birth:</label>
        <input type="date" class="form-control" name="dob" value="{{$customer->dob}}" required>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
