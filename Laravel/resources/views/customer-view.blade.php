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
    
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            
            
        @if (session()->has('user_name'))
            {{session()->get('user_name')}};
        @else
            Navbar
        @endif
        
        </a>
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
    
   <div class="container">
    <a href="{{route('customer.create')}}">
    <button class="btn btn-primary d-inline-block m-2 float-right" >Add</button>
    </a>
    <a href="{{url('customer/trash')}}">
        <button class="btn btn-danger d-inline-block m-2 float-right" >Go to Trash</button>
    </a>
        <table class="table"> 
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>DOB</th>
                    <th>Address</th>
                    <th>State</th>
                    <th>Country</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($customers as $customer)
                <tr>
                    <td>{{$customer->name}}</td>
                    <td>{{$customer->email}}</td>
                    <td>
                        @if ($customer->gender== "M")
                            Male
                        @elseif($customer->gender== "F")
                            Female
                        @else
                            Other    
                        @endif
                    </td>
                    <td>{{$customer->dob}}</td>
                    <td>{{$customer->address}}</td>
                    <td>{{$customer->state}}</td>
                    <td>{{$customer->country}}</td>
                    <td>
                      @if ($customer->status== "1")
                      <a href="">
                        <Span class="badge badge-success">Active</Span>
                      </a>
                      @else
                      <a href="">
                        <Span class="badge badge-danger">InActive</Span>
                    </a>
                      @endif
                    </td>
                    <td>
                        <a href="{{route('customer.delete',['id'=> $customer->customer_id])}}"><button class="btn btn-danger">Trash</button></a>
                        <a href="{{route('customer.edit',['id'=> $customer->customer_id])}}"><button class="btn btn-primary">Edit</button></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
   </div>
  </body>
</html>