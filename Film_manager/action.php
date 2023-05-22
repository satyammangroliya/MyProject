<?php

session_start();



include_once ('db_connection.php');
$operation = isset($_GET['operation']) ? $_GET['operation']:'';


switch ($operation){
    case 'add_user':

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_name = $_POST["user_name"];
            $user_email = $_POST["user_email"];
            $user_password = $_POST["user_password"];
            $result = pg_query($db_con_status, "SELECT add_user('$user_name', '$user_email', '$user_password')");
            
            if($result){
                $uid = pg_last_oid($result);
                $_SESSION['login'] = 1;
                $_SESSION['uid'] = $uid;
                $_SESSION['uname'] = $user_name;
                $_SESSION['uemail'] = $user_email;
                $message = ($result) ? "Register ".$user_name." succesfully added":"Registered fail";
                
                $result_status = pg_result_status($result);
                pg_free_result($result);
                pg_close($db_con_status);
                $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/index.php?message=".$message;
                header("Location: ".$actual_link);
            }else{
                $message = "Registered fail";

                $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/index.php?message=".$message;
                header("Location: ".$actual_link);
            }
            
        }

        
        break;

        

        case 'validate_user':

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                //$user_name = $_POST["user_name"];
                $u_email = $_POST['user_email'];
                $u_password = $_POST['user_password'];
                $result = pg_query($db_con_status, "SELECT * FROM validate_user('$u_email', '$u_password')");
                
                if(pg_num_rows($result) > 0){
                    $user_records = pg_fetch_all($result);

                    $_SESSION['login'] = 1;
                    $_SESSION['uid'] = $user_records[0]['user_id'];
                    $_SESSION['uname'] = $user_records[0]['user_name'];
                    $_SESSION['uemail'] = $u_email;

                    $message = ($result) ? "The user ".$u_email." Login succesfully ":"The user login failed";
                
                    $result_status = pg_result_status($result);
                    pg_free_result($result);

                    $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/user/index.php?".$message;
                    header("Location: ".$actual_link);
                }else{
                    $message = "The user login failed to login";
                
                    $result_status = pg_result_status($result);
                    pg_free_result($result);
                    
                    $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/index.php?".$message;
                    header("Location: ".$actual_link); 
                }
                pg_close($db_con_status);      
                
            }
            
            
            break;


            case 'validate_admin':

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $u_email = $_POST['user_email'];
                $u_password = $_POST['user_password'];
               if($u_email == "admin@gmail.com" && $u_password == "admin"){
                    
                    $_SESSION['login_admin'] = 1;
                    $_SESSION['uid'] = 0;
                    $_SESSION['uemail'] = $u_email;
                    
                    $message = "The user ".$u_email." Login succesfully ";
                
                    $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/admin/index.php?".$message;
                    header("Location: ".$actual_link);

                }else{
                    $message = "The user login failed to login";
                
                    $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/index.php?".$message;
                    header("Location: ".$actual_link); 
                }
                
            }
            
            
            break;

            case 'add_edit_person':
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
                    $type = isset($_GET['type']) ? $_GET['type']:'add';
                 
                    if($type =='add'){
                        $id=0;
                        $op = 'add';
                        $name =  $_POST['name'];
                        $role = $_POST['role_name'];
                        $film_id = $_POST['film_id'];                      
                    } 
                    else{
                        $id = isset($_GET['p_id']) ? $_GET['p_id']:0;
                        $op = 'edit';
                        $name =  $_POST['name'];

                        $role = $_POST['role_name'];
                        $film_id = $_POST['film_id'];

                    }
                        $result = pg_query($db_con_status, "SELECT op_person('$op','$name','$film_id','$role','$id')");
                        $message = ($result) ? "Succesfully ".$type."ed":" failed";               
                        $result_status = pg_result_status($result);
                        pg_free_result($result); 
                        pg_close($db_con_status);

                }
                      
                    $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/admin/add_person.php?message=".$message;
                    header("Location: ".$actual_link);
               
                break;

                 case 'deleted_person':

                    $del_id = $_GET['a_id'];
                    
                    $result = pg_query($db_con_status, "SELECT delete_content('$del_id', 'person','person_id')");

                    $message = ($result) ? "Person successfully deleted":" Delete operation fail";
                    $result_status = pg_result_status($result);
                    pg_free_result($result);
                    pg_close($db_con_status);

                $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/admin/add_person.php?message=".$message;
                header("Location: ".$actual_link);
                break;

                case 'deleted_actor':

                    $del_id = $_GET['a_id'];
                    echo $del_id;

                    $result = pg_query($db_con_status, "SELECT delete_actor('$del_id', 'users','user_id')");

                    $message = ($result) ? "Actor successfully deleted":" Delete operation fail";
                    $result_status = pg_result_status($result);
                    pg_free_result($result);
                    pg_close($db_con_status);

                $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/admin/add_actor.php?message=".$message;
                header("Location: ".$actual_link);
                break;

                case 'deleted_film':

                    $del_id = $_GET['a_id'];
                    echo $del_id;

                    if ($_GET['type'] == '1') {
                        $result = pg_query($db_con_status, "SELECT delete_content('$del_id', 'Subordinated','submovie_id')");
                    }else{
                        $result = pg_query($db_con_status, "SELECT delete_content('$del_id', 'movie','movie_id')");
                    }
                    

                    $message = ($result) ? "Film successfully deleted":" Delete operation fail";
                    $result_status = pg_result_status($result);
                    pg_free_result($result);
                    pg_close($db_con_status);

                $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/admin/film_details.php?message=".$message;
                header("Location: ".$actual_link);
                break;


                case 'add_edit_producer':
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
                       
                       
                        $type = isset($_GET['type']) ? $_GET['type']:'add';
                        echo $type;
                        if($type =='add'){
                            $pid = 0;
                            $op = 'add';
                            $name =  $_POST['name'];
                            
                        } else{
                            $pid = isset($_GET['id']) ? $_GET['id']:0;
                            $op = 'edit';
                            $name =  $_POST['name'];
                        }
                        $result = pg_query($db_con_status, "SELECT op_producer('$op','$name','$pid')");
            
                        $message = ($result) ? "Operation Successful":"Operation fail";
            
                        $result_status = pg_result_status($result);
                        pg_free_result($result);
                        pg_close($db_con_status);
                    }
            
            
                    $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/admin/add_producer.php?message=".$message;
                    header("Location: ".$actual_link);
                    break;


                    case 'add_edit_movie':
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
                       
                       
                        $type = isset($_GET['type']) ? $_GET['type']:'add';
                        echo $type;
                        if($type =='add'){
                            $film_id = 0;
                            $op = 'add';
                            
                        } else{
                            $film_id = isset($_GET['film_id']) ? $_GET['film_id']:0;
                            $op = 'edit';
                        }

                        $film_title =  str_replace("'","",$_POST['film_title']);
                        $film_overview = str_replace("'","",$_POST['film_overview']);
                        $film_release_yr = $_POST['film_release_yr'];
                        $film_country = $_POST['film_country'];
                        $film_genre_arr = $_POST['film_genre'];

                        $film_genre = implode(",",$film_genre_arr);

                        if ($_POST['film_type'] == '1') {
                            $main_movie_id = $_POST['main_movie_id'];

                            $result = pg_query($db_con_status, "SELECT op_subordinated_movie('$op','$film_title','$film_overview','$film_release_yr','$film_country','$film_genre','$main_movie_id','$film_id')");
                        }else{
                            $result = pg_query($db_con_status, "SELECT op_movie('$op','$film_title','$film_overview','$film_release_yr','$film_country','$film_genre','$film_id')");
                        }
                        
                        
                        $message = ($result) ? "Movie ".$op."ed Successfully":"Operation fail";
            
                        $result_status = pg_result_status($result);
                        pg_free_result($result);
                        pg_close($db_con_status);
                    }
            
            
                    $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/admin/film_details.php?message=".$message;
                    header("Location: ".$actual_link);
                    break;

   

      

    
 

    case 'delete_meeting':
        $m_id = $_GET['m_id'];
        $result = pg_query($db_con_status, "SELECT delete_content('$m_id', 'work_meeting','meeting_id')");
        $message = ($result) ? "Meeting successfully deleted":" Delete operation fail";
        $result_status = pg_result_status($result);
        pg_free_result($result);
        pg_close($db_con_status);

        $actual_link = "http://$_SERVER[HTTP_HOST]/WorkTogether/frs.php?message=".$message;
        header("Location: ".$actual_link);
        break;

    case 'change_rating':
        $movie_id = $_GET['movie_id'];
        $user_id = $_GET['user_id'];
        $rating = $_POST['rating'];
        $submovie = $_GET['submovie'];

        $result = pg_query($db_con_status, "SELECT change_rating('$movie_id', '$user_id','$rating','$submovie')");
        $message = ($result) ? "Rating Changed":"Change Rating operation fail";
        $result_status = pg_result_status($result);
        pg_free_result($result);
        pg_close($db_con_status);

        if ($submovie == 0) {
            $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/user/movie_detail.php?id=".$movie_id."&message=".$message;
        }else{
            $actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/user/submovie_detail.php?id=".$movie_id."&message=".$message; 
        }
        header("Location: ".$actual_link);
        break;

   

        case 'logout':


            $_SESSION['user_name'] = '';
            $_SESSION['user_role'] = '';

            unset( $_SESSION['user_name']);
            unset( $_SESSION['user_role']);

            session_destroy();

        $actual_link = "http://$_SERVER[HTTP_HOST]/WorkTogether";
        header("Location: ".$actual_link);
        break;

        case 'login_user':
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $user_name = $_POST["user_name"];

                $users_result = pg_query($db_con_status, "SELECT validate_username('$user_name')");

                $query_status = pg_result_status($users_result);

                if($query_status === PGSQL_COMMAND_OK || $query_status === PGSQL_TUPLES_OK)
                {
                    $number_of_rows = pg_num_rows($users_result);
                    $user_records = pg_fetch_assoc($users_result);

                   $dataarr = explode(',',$user_records['validate_username']);
                   $namearr = explode('(',$dataarr[0]);
                   $name =  $namearr[1];
                   $rolearr = explode(')',$dataarr[1]);
                   $role =  $rolearr[0];

                    $_SESSION['user_name'] = $name;
                    $_SESSION['user_role'] = $role;


                    if($number_of_rows >0 ){
                        if($role ==1){
                            $actual_link = "http://$_SERVER[HTTP_HOST]/WorkTogether/frs.php";
                        } else{
                            $actual_link = "http://$_SERVER[HTTP_HOST]/WorkTogether/list_study_group.php";
                        }
                    } else{
                        $actual_link = "http://$_SERVER[HTTP_HOST]/WorkTogether";
                    }


                } else{
                    $actual_link = "http://$_SERVER[HTTP_HOST]/WorkTogether";
                }

            }

            pg_free_result($result);
            pg_close($db_con_status);


        header("Location: ".$actual_link);
        break;
}