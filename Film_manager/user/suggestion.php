<?php 
  session_start();

  include_once ('../db_connection.php');

  if (!isset($_SESSION['login'])) {
    $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/index.php";
    header("Location: ".$actual_link);
  }
      $uid = $_SESSION['uid'];
      $recommended_result = pg_query($db_con_status, "SELECT * FROM get_recommended_movies($uid)");

      $recommended_records = pg_fetch_all($recommended_result);
      $recommended_array = explode(',', $recommended_records[0]['genre']);
      
      $films_result = pg_query($db_con_status, "SELECT * FROM get_movies()");

      $query_status = pg_result_status($films_result);

      if($query_status === PGSQL_COMMAND_OK || $query_status === PGSQL_TUPLES_OK)
      {
          $number_of_rows = pg_num_rows($films_result);
          $films_records = pg_fetch_all($films_result);
      }

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Entertainment</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery-func.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--[if IE 6]><link rel="stylesheet" href="css/ie6.css" type="text/css" media="all" /><![endif]-->
</head>
<body>
<!-- START PAGE SOURCE -->
<div id="shell">
  <div id="header">
    <br>
    <h1 style="color:black;">Entertainment</h1>
    
    <div id="navigation">
      <ul>
        <li><a style="color: black;" class="" href="index.php">SHOW ALL</a></li>
        <li><a style="color:black;" href="suggestion.php">RECOMMENDED</a></li>
        <li><a style="color:black" href="#"><i style="color:black" class="fa  fa-user">&nbsp;</i><?php echo $_SESSION['uname']?></a> </li>
        <li><a style="color:black" href="logout.php"><i style="color:black" class="fa  fa-lock">&nbsp;</i> LogOut</a> </li>
      
      </ul>
    </div>
    <div id="sub-navigation" style="color:black;">
      <h4>Recommended Movies<h4>
    </div>
  </div>
  <br>
   <div class="content-wrapper">
    <div class="container-fluid">
      <div class="row">

      <!-- Icon Cards-->
       <?php if($number_of_rows > 0){
             for($i=0; $i<$number_of_rows; $i++){ if($films_records[$i]['submovie_id'] == 0)
             { $genre_arr = explode(',', $films_records[$i]['genre']);  if(array_intersect($recommended_array,$genre_arr) != null){?>
          <div class="col-lg-3 col-md-4 col-sm-6 col-12 mb-2 mt-4" style=" margin-left: 25px;background-color:white;height:125px; border-radius: 10px;opacity: 0.5;">
             <a href="movie_detail.php?id=<?php echo $films_records[$i]['movie_id']?>"><div class="row" >
               <h2><?php echo $films_records[$i]['movie_title'] ?></h2>
              </div> </a>
              <p><?php if($films_records[$i]['rating'] == null){echo 0;}else{echo round($films_records[$i]['rating'],2);}?> rating</p>
          </div>
        <?php } } } } ?>
              
    </div>
  </div>
</div>
  
<!-- END PAGE SOURCE -->
</body>
</html>