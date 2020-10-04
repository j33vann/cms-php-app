<?php

if(isset($_POST['edit_user'])){
    $username = $_POST['username'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_email = $_POST['user_email'];
    // $user_password = $_POST['user_password'];
    // $user_image = $_FILES['user_image']['name'];
    // $user_image_temp = $_FILES['user_image']['tmp_name'];
    $user_role = $_POST['user_role'];
    // $user_content = $_POST['user_content'];
    // $user_date = date("d-m-y");
    // $user_comment_count = 4;
    // move_uploaded_file($user_image_temp, "../images/$user_image");
    // $hash = "$2y$10$";
    // $salt = "Th2NPLY9zcyZWbs7C2JEuf";
    // $hash_salt_pwd = $hash . $salt;
    // $user_password = crypt($user_password, $hash_salt_pwd);
    $the_user_id = $_GET['u_id'];
    $query = "UPDATE users SET username='$username', user_firstname='$user_firstname', user_lastname='$user_lastname', user_email='$user_email', user_role='$user_role' WHERE user_id='$the_user_id'";

    $result = mysqli_query($connection, $query);

    if(!$result){
        echo "something went wrong" . mysqli_error($connection);
    }
}

if(isset($_GET['u_id'])){
    $the_user_id = $_GET['u_id'];
    $get_query = "SELECT * FROM users where user_id={$the_user_id}";
    $get_result = mysqli_query($connection, $get_query);
    while($row = mysqli_fetch_assoc($get_result)){
        $get_username = $row['username'];
        $get_user_firstname = $row['user_firstname'];
        $get_user_lastname = $row['user_lastname'];
        $get_user_email = $row['user_email'];
        $get_user_role = $row['user_role'];
    }
}
?>

<form action="" method="post" enctype= "multipart/form-data">
<div class="form-group">
    <label for="user_firstname">First name</label><br>
    <input class="form-control" name="user_firstname" id="user_firstname" value="<?php echo $get_user_firstname ?>">
    <label for="user_lastname">Last name</label>
    <input class="form-control" type="text" name="user_lastname" value="<?php echo $get_user_lastname ?>">
    <label for="user_role">Roll</label>
    <select name="user_role" id="user_role" class="form-control">
        <option><?php echo $get_user_role ?></option>
        <?php
        if($get_user_role == 'admin'){
            echo "<option value='subscriber'>subscriber</option>";
        } else {
            echo "<option>admin</option>";
        }
        ?>
    </select>
    <label for="username">Username</label>
    <input class="form-control" type="text" name="username" value="<?php echo $get_username ?>">
    <label for="user_email">E - mail</label>
    <input class="form-control" type="text" name="user_email" value="<?php echo $get_user_email ?>">
    <!-- <label for="user_image">user image</label>
    <input type="file" name="user_image"> -->
    <!-- <label for="user_password">Password</label>
    <input type="password" class="form-control" type="text" name="user_password"> -->
    <!-- <label for="user_content">user content</label>
    <textarea class="form-control" name="user_content" rows="5"></textarea> -->
    </div>
    <div class="form-group">
    <button class="btn btn-primary" name="edit_user">Edit user</button>
    </div>
</form>