<?php
          
                $host = "127.0.0.1";
                $user = "root";
                $pass = "usbw";
                $db = "hermes";
                $conn = mysqli_connect($host,$user,$pass,$db);  
                mysqli_set_charset($conn, "utf8");

                if($conn->connection_errno){
                    die("Error :" . $conn->connection_error);
                }
                
?>