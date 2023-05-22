<!DOCTYPE html>
<?php


include_once ('../db_connection.php');

$users_result = pg_query($db_con_status, "SELECT * FROM get_person()");

$query_status = pg_result_status($users_result);

if($query_status === PGSQL_COMMAND_OK || $query_status === PGSQL_TUPLES_OK)
{
    $number_of_rows = pg_num_rows($users_result);
    $user_records = pg_fetch_all($users_result);
}

$films_result = pg_query($db_con_status, "SELECT * FROM get_movies()");

$query_status_film = pg_result_status($films_result);

if($query_status_film === PGSQL_COMMAND_OK || $query_status_film === PGSQL_TUPLES_OK)
{
  $number_of_rows_films = pg_num_rows($films_result);
  $films_records = pg_fetch_all($films_result);
}
?>
<html lang="en">
 <?php
          include('partials/header.php');
        ?>
  <body>
    <div class="container-scroller">
   <?php
          include('partials/navbar.php');
        ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_sidebar.html -->
        <?php
          include('partials/sidebar.php');
        ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            
            <div class="row">
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <?php if(isset($_GET['operation']) && $_GET['operation']=='update_success'){ ?>
                            <div class="alert alert-success">
                                <strong>Success!</strong>
                            </div>
                        <?php } ?>
                    <h4 class="card-title">Add Film Related Person </h4>
                 
                    <form class="forms-sample" <?php if(isset($_GET['p_id'])){?> action="../action.php?operation=add_edit_person&type=edit&p_id=<?php echo $_GET['p_id']?>" <?php }else{ ?>  action="../action.php?operation=add_edit_person&type=add" <?php } ?> method="POST" enctype="multipart/form-data">
                      <div class="form-group">
                        <label for="exampleInputUsername1">Person Name</label>
                        <input type="text" name="name" class="form-control" id="exampleInputUsername1" placeholder="Enter Person Name" <?php if(isset($_GET['p_name'])){?> value="<?php echo $_GET['p_name']?>" <?php } ?> >
                      </div>

                      <div class="form-group">
                        <label for="exampleInputUsername1">Film Role</label>
                        <select class="form-control" name="role_name" >
                          <option <?php if(isset($_GET['role_name'])){ if($_GET['role_name'] == "Actor"){?> selected <?php } } ?>>Actor</option>
                          <option <?php if(isset($_GET['role_name'])){ if($_GET['role_name'] == "Producer"){?> selected <?php } } ?>>Producer</option>
                          <option <?php if(isset($_GET['role_name'])){ if($_GET['role_name'] == "Writer"){?> selected <?php } } ?>>Writer</option>        
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="exampleInputUsername1">Film Name</label>
                        <select class="form-control" name="film_id">
                                
                                 <?php
                                   if($number_of_rows_films > 0){
                                    for($i=0; $i<$number_of_rows_films; $i++){ ?>
                                    <option <?php if(isset($_GET['f_id'])){ 
                                                          if($_GET['f_id'] < 899){
                                                            if($_GET['f_id'] == $films_records[$i]['movie_id'] && $films_records[$i]['type_of'] == 0){?> 
                                                              selected 
                                                              
                                                      <?php }else{} 
                                                          }else{
                                                            if($_GET['f_id'] == $films_records[$i]['submovie_id'] && $films_records[$i]['type_of'] == 1){?> 
                                                              selected 
                                                      <?php }else{} 
                                                          }
                                                      } ?> 

                                                      <?php 
                                                            if($films_records[$i]['type_of'] == 0){?> 
                                                              value="<?php echo $films_records[$i]['movie_id']?>" 
                                                              
                                                      <?php }else{ ?>
                                                              value="<?php echo $films_records[$i]['submovie_id']?>"
                                                      <?php  } 
                                                       ?> 

                                                      >
                                                      <?php echo $films_records[$i]['movie_title']?>
                                                        
                                                      </option>
                               <?php } }?>
                              </select>
                      </div>
                                   
                      <button type="submit" class="btn btn-gradient-primary me-2"><?php if(isset($_GET['p_id'])){?> Edit <?php }else{ ?> Add <?php }?></button>
                      <input type="button" class="btn btn-light">Cancel</input>
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                <?php
                            if(isset($_GET['message'])){?>
                                <div class="col-12 col-sm-12"> <span class="alert alert-warning"><?php echo $_GET['message'];?></span>  </div>
                            <?php }
                            ?>
                  <div class="card-body">
                    <h4 class="card-title">List of Actor </h4>
                 
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th> index </th>
                          <th>  name </th>
                          <th> Role </th>
                          <th> Film Name </th>
                          <th>  edit </th>
                          <th>  delete </th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        if($number_of_rows > 0){
                            for($i=0; $i<$number_of_rows; $i++){ ?>
                                    <tr>
                                        <td><?php echo $i+1?></td>
                                        <td><?php echo $user_records[$i]['person_name'] ?></td>
                                        <td><?php echo $user_records[$i]['role_name'] ?></td>
                                        <td>
                                        <?php
                                          if($number_of_rows_films > 0){
                                            for($j=0; $j<$number_of_rows_films; $j++){
                                              if($user_records[$i]['film_id'] < 899){
                                                if($films_records[$j]['movie_id'] == $user_records[$i]['film_id'] && $films_records[$j]['type_of'] == 0){ 
                                                  echo $films_records[$j]['movie_title']; 
                                                }else{

                                                } 
                                              }else{
                                                if($films_records[$j]['submovie_id'] == $user_records[$i]['film_id']){ 
                                                  echo $films_records[$j]['movie_title']; 
                                                }else{
                                                  
                                                } 
                                              } 
                                            } 
                                          } 
                                        ?></td>
                                        <td>
                                          <a class="btn btn-danger" href="add_person.php?p_id=<?php echo $user_records[$i]['person_id']?>&p_name=<?php echo $user_records[$i]['person_name']?>&f_id=<?php echo $user_records[$i]['film_id']?>&role_name=<?php echo $user_records[$i]['role_name']?>">Edit
                                          </a> 
                                        </td>
                                         <td><form  action="../action.php?operation=deleted_person&a_id=<?php echo $user_records[$i]['person_id']?>" method="POST">
                                          <button type="submit" class="btn btn-gradient-primary me-2">Delete</button>  
                                          </form> 
                                      </td>
                                    </tr>
                                    <?php } } else{ ?>
                                        <tr>
                                            <td colspan="4">No data found</td>
                                        </tr>
                                    <?php }?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <?php
          include('partials/footer.php');
        ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
   
  </body>
</html>