<?php
    function get_views_count(){
        if(isset($_GET['onlineUsers'])){
            global $connection;
            if(!$connection){
                session_start();
                $connection = mysqli_connect("localhost", "root", "", "cms");
                $session = session_id();
                $time = time();
                $time_out_in_seconds = 30;
                $time_out = $time - $time_out_in_seconds;

                $view_count_query = "SELECT * FROM users_online WHERE session='$session'";
                $send_query = mysqli_query($connection, $view_count_query);
                $view_count = mysqli_num_rows($send_query);

                if($view_count == NULL){
                    mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
                } else {
                    mysqli_query($connection, "UPDATE users_online SET time='$time' WHERE session='$session'");
                }

                $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
                echo $count_users_online = mysqli_num_rows($users_online_query);
                if(!$count_users_online){
                    die("error: " . mysqli_error($connection) . "Sdf");
                }
            } else {
                echo "nope";
            }
        }
    }
    get_views_count();

    function pager($count, $page){
        for($i=1;$i<=$count;$i++){
            if($page == $i){
            echo "<li><a href='index.php?page={$i}' style='color:white; background-color: black'>{$i}</a></li>";
            } else {
            echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
            }
        }
    }

    function isLoggedIn(){
        if(isset($_SESSION['user_role'])){
            return true;
        }
    }

    function isLoggedInAndRedirect($redirectLocation){
        if(isLoggedIn()){
            redirect($redirectLocation);
        } 
    }

  
?>
