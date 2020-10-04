<?php 
ob_start();
session_start();

include "db.php";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);

    $query = "SELECT * FROM users WHERE username='{$username}'";
    $login_result = mysqli_query($connection, $query);
    if(!$login_result){
        die("something went wrong");
    }
    while($row = mysqli_fetch_assoc($login_result)){
        $user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_role = $row['user_role'];
    }

    
    // $hash_query = "SELECT randSalt FROM users";
    // $hash_result = mysqli_query($connection, $hash_query);
    // $hash_row = mysqli_fetch_array($hash_result);
    // $hashedString = $hash_row['randSalt'];
    // $password = crypt($password, $hashedString);

    // $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));

    if(password_verify($password, $db_password)){
        
        $_SESSION['username'] = $db_username;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_firstname'] = $user_firstname;
        $_SESSION['user_lastname'] = $user_lastname;
        $_SESSION['user_role'] = $user_role;

        header("Location: ../admin/");
    } else {
        header("Location: ../index.php");
    }
}

?>
