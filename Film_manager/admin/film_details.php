<!DOCTYPE html>
<html lang="en">
  <?php
          include('partials/header.php');
    ?>
    <?php

      include_once ('../db_connection.php');

      $films_result = pg_query($db_con_status, "SELECT * FROM get_movies()");

      $query_status = pg_result_status($films_result);

      if($query_status === PGSQL_COMMAND_OK || $query_status === PGSQL_TUPLES_OK)
      {
          $number_of_rows = pg_num_rows($films_result);
          $films_records = pg_fetch_all($films_result);
      }
      ?>
  <body>
    <style >
      table { 
          display: block;
    overflow-x: auto;
    white-space: nowrap;
      }

    </style>
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
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
                <?php
                            if(isset($_GET['message'])){?>
                                <div class="col-12 col-sm-12"> <span class="alert alert-warning"><?php echo $_GET['message'];?></span>  </div>
                            <?php }
                            ?>
                  <div class="card-body">
                    <h4 class="card-title">List of Films </h4>
                 
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th> index </th>
                          <th>  Title </th>
                          <th>  Overview </th>
                          <th>  Release Year </th>
                          <th> Country  </th>
                          <th>  Genre </th>
                          <th>  Type </th>
                          <th>  Main Movie</th>
                          <th>  edit </th>
                          <th>  delete </th>
                          
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        if($number_of_rows > 0){
                            for($i=0; $i<$number_of_rows; $i++){ ?>
                                    <tr>
                                        <td><?php echo $i+1 ?></td>
                                        <td><?php echo $films_records[$i]['movie_title']?></td>
                                        <td style="white-space:pre-line;"><?php echo $films_records[$i]['overview']?><p></td>
                                        <td><?php echo $films_records[$i]['release_year']?></td>
                                        <td><?php echo $films_records[$i]['country']?></td>
                                        <td><?php echo $films_records[$i]['genre']?></td>
                                        <td><?php if($films_records[$i]['type_of'] == 1){ echo 'Subordinated'; }else{ echo 'Main'; }  ?></td>
                                        <td><?php echo $films_records[$i]['submovie_name']; ?></td>
                                        <td><a class="btn btn-danger" href="add_film.php?film_id=<?php echo $films_records[$i]['movie_id']; ?>&subfilm_id=<?php echo $films_records[$i]['submovie_id'];?>">Edit</a> </td>
                                         <td><form  action="../action.php?operation=deleted_film&a_id=<?php echo $films_records[$i]['movie_id']?>&type=0" method="POST">
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
          <footer class="footer">
            <div class="container-fluid d-flex justify-content-between">
              <span class="text-muted d-block text-center text-sm-start d-sm-inline-block">Copyright © bootstrapdash.com 2021</span>
              <span class="float-none float-sm-end mt-1 mt-sm-0 text-end"> Free <a href="https://www.bootstrapdash.com/bootstrap-admin-template/" target="_blank">Bootstrap admin template</a> from Bootstrapdash.com</span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../../assets/js/off-canvas.js"></script>
    <script src="../../assets/js/hoverable-collapse.js"></script>
    <script src="../../assets/js/misc.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
  </body>
</html>