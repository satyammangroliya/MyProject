<!doctype html>
<html lang="en">
  <head>
    <title>Customer Trash</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            
            
        <?php if(session()->has('user_name')): ?>
            <?php echo e(session()->get('user_name')); ?>;
        <?php else: ?>
            Navbar
        <?php endif; ?>
        
        </a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
            aria-expanded="false" aria-label="Toggle navigation"></button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo e(url('/')); ?>">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo e(url('/register')); ?>">Register <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo e(url('/customer')); ?>">Customer <span class="sr-only">(current)</span></a>
                </li>
                
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>
    
   <div class="container">
    <a href="<?php echo e(route('customer.create')); ?>">
    <button class="btn btn-primary d-inline-block m-2 float-right" >Add</button>
    </a>
    <a href="<?php echo e(url('customer')); ?>">
        <button class="btn btn-primary d-inline-block m-2 float-right" >Customer View</button>
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
                <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($customer->name); ?></td>
                    <td><?php echo e($customer->email); ?></td>
                    <td>
                        <?php if($customer->gender== "M"): ?>
                            Male
                        <?php elseif($customer->gender== "F"): ?>
                            Female
                        <?php else: ?>
                            Other    
                        <?php endif; ?>
                    </td>
                    <td><?php echo e($customer->dob); ?></td>
                    <td><?php echo e($customer->address); ?></td>
                    <td><?php echo e($customer->state); ?></td>
                    <td><?php echo e($customer->country); ?></td>
                    <td>
                      <?php if($customer->status== "1"): ?>
                      <a href="">
                        <Span class="badge badge-success">Active</Span>
                      </a>
                      <?php else: ?>
                      <a href="">
                        <Span class="badge badge-danger">InActive</Span>
                    </a>
                      <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo e(route('customer.force-delete',['id'=> $customer->customer_id])); ?>"><button class="btn btn-danger">Delete</button></a>
                        <a href="<?php echo e(route('customer.restore',['id'=> $customer->customer_id])); ?>"><button class="btn btn-primary">Restore</button></a>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
   </div>
  </body>
</html><?php /**PATH C:\xampp\htdocs\Learning\resources\views/customer-trash.blade.php ENDPATH**/ ?>