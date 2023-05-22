<?php
/**
 * Created by PhpStorm.
 * User: Md Deloawer Hossain
 * Date: 08.01.2021
 * Time: 17:13
 */

 $host = "localhost";
 $port = "5432"; // should be 5432
 $databaseName = "Film_manager";
 $userName = "postgres";
 $password = "1234";
 $db_con_status = pg_connect("host=".$host." port=".$port." dbname=".$databaseName." user=".$userName." password=".$password) or
  die("Connection Fail!");
?>