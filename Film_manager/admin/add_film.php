

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

      if (isset($_GET['film_id'])) {
        if($number_of_rows > 0){
          for($i=0; $i<$number_of_rows; $i++){

            if($_GET['subfilm_id'] == "0"){
              if($_GET['film_id'] == $films_records[$i]['movie_id'] && $films_records[$i]['submovie_id'] == "0"){
                $movie_title = $films_records[$i]['movie_title'];
                $movie_overview = $films_records[$i]['overview'];
                $movie_release_yr = $films_records[$i]['release_year'];
                $movie_country = $films_records[$i]['country'];
                $movie_genre = $array = explode(',', $films_records[$i]['genre']);
                $type_of = $films_records[$i]['type_of'];
                $submovie_id = $films_records[$i]['submovie_id'];
              }
            }else{
              if($_GET['subfilm_id'] == $films_records[$i]['submovie_id']){
                $movie_title = $films_records[$i]['movie_title'];
                $movie_overview = $films_records[$i]['overview'];
                $movie_release_yr = $films_records[$i]['release_year'];
                $movie_country = $films_records[$i]['country'];
                $movie_genre = $array = explode(',', $films_records[$i]['genre']);
                $type_of = $films_records[$i]['type_of'];
                $submovie_id = $films_records[$i]['submovie_id'];
              }
            }
            
          } 
        }
      }
      ?>
  <body>
    <div class="container-scroller">
    
     <?php
          include('partials/navbar.php');
        ?>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
      
         <?php
          include('partials/sidebar.php');
        ?>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
           
            <div class="row">
             
              
              <div class="col-12">
                <div class="card">
                  <div class="card-body">
                    <h2 class="card-title" style="font-weight: bold;"> <?php if(isset($_GET['film_id'])){?> Edit <?php }else{ ?> Add <?php }  ?>Film Details</h2>
                    <form class="form-sample" <?php if(isset($_GET['film_id'])){?> action="../action.php?operation=add_edit_movie&type=edit&film_id=<?php echo $_GET['film_id']?>" <?php }else{ ?>  action="../action.php?operation=add_edit_movie&type=add" <?php } ?> method="POST">
                  
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Film Title</label>
                            <div class="col-sm-9">
                              <input type="text" name="film_title" class="form-control" <?php if (isset($movie_title)) { ?> value = "<?php echo $movie_title?>" <?php } ?> />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Film Overview</label>
                            <div class="col-sm-9">
                              <input type="text" name="film_overview" class="form-control" <?php if (isset($movie_overview)) { ?> value = "<?php echo $movie_overview?>" <?php } ?> />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Release Year</label>
                            <div class="col-sm-9">
                              <input type="number" min="1900" max="2099" step="1" value="2022" name="film_release_yr" class="form-control" <?php if (isset($movie_release_yr)) { ?> value = "<?php echo $movie_release_yr?>" <?php } ?> />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Country</label>
                            <div class="col-sm-9">
                              <input type="text" name="film_country" class="form-control" <?php if (isset($movie_country)) { ?> value = "<?php echo $movie_country?>" <?php } ?>/>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Genre</label>
                            <div class="col-sm-9">
                              <select class="form-control" name="film_genre[]" multiple>
                                <option <?php if (isset($movie_title)) { if(in_array("Drama", $movie_genre)){ ?>selected<?php } } ?>>Drama</option>
                                <option <?php if (isset($movie_title)) { if(in_array("Action", $movie_genre)) { ?>selected<?php } } ?>>Action</option>
                                <option <?php if (isset($movie_title)) { if(in_array("Comedy", $movie_genre)) { ?>selected<?php } } ?>>Comedy</option>
                                <option <?php if (isset($movie_title)) { if(in_array("Horror", $movie_genre)) { ?>selected<?php } } ?>>Horror</option>
                                <option <?php if (isset($movie_title)) { if(in_array("Thriller", $movie_genre)) { ?>selected<?php } } ?>>Thriller</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Movie Type</label>
                            <div class="col-sm-4">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="film_type" value="0" onclick="open_movie_name(1);" <?php if (isset($type_of) && $type_of == "0") { ?>checked <?php } ?> > Main </label>
                              </div>
                            </div>
                            <div class="col-sm-5">
                              <div class="form-check">
                                <label class="form-check-label">
                                  <input type="radio" class="form-check-input" name="film_type" value="1" onclick="open_movie_name(0);" <?php if (isset($type_of) && $type_of == "1") { ?>checked <?php } ?>> Subordinated </label>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" id="main_movie_row" <?php if (isset($type_of) && $type_of == "0") { ?> style="display:none;" <?php } ?> <?php if(!isset($type_of)) { ?> style="display: none;"<?php } ?>>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Main Film Name</label>
                            <div class="col-sm-9">
                              <select class="form-control" name="main_movie_id">
                                
                                 <?php
                                   if($number_of_rows > 0){
                                  for($i=0; $i<$number_of_rows; $i++){
                                    if($films_records[$i]['submovie_id'] == 0){ ?>
                                    <option value="<?php echo $films_records[$i]['movie_id']?>" <?php if(isset($submovie_id) && $_GET['film_id'] == $films_records[$i]['movie_id']){ ?> selected <?php } ?>><?php echo $films_records[$i]['movie_title']?></option>
                               <?php } } }?>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <input type="submit" class="btn btn-gradient-primary me-2"></input>
                    </form>
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
    <script src="../../assets/js/file-upload.js"></script>
    <!-- End custom js for this page -->

    <script>
      function open_movie_name(type_of){
        if (type_of) {
          document.getElementById('main_movie_row').style.display="none";
        }else{
          document.getElementById('main_movie_row').style.display="block";
        }
        
      }
    </script>
  </body>
</html>