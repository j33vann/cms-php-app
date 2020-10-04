<?php

if(isset($_POST['create_user'])){
    $username = $_POST['username'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
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

    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

    $query = "INSERT INTO users(username, user_firstname, user_lastname, user_email, user_password, user_role) VALUES('$username', '$user_firstname', '$user_lastname', '$user_email', '$user_password', '$user_role')";

    $result = mysqli_query($connection, $query);

    if(!$result){
        echo "something went wrong";
    }
}

?>

<form action="" method="post" enctype= "multipart/form-data">
<div class="form-group">
    <label for="user_firstname">First name</label><br>
    <input class="form-control" name="user_firstname" id="user_firstname">
    <label for="user_lastname">Last name</label>
    <input class="form-control" type="text" name=user_lastname>
    <label for="user_role">Roll</label>
    <select name="user_role" id="user_role" class="form-control">
        <option>subscriber</option>
        <option>admin</option>
    </select>
    <label for="username">Username</label>
    <input class="form-control" type="text" name="username">
    <label for="user_email">E - mail</label>
    <input class="form-control" type="text" name="user_email">
    <!-- <label for="user_image">user image</label>
    <input type="file" name="user_image"> -->
    <label for="user_password">Password</label>
    <input type="password" class="form-control" type="text" name="user_password">
    <!-- <label for="user_content">user content</label>
    <textarea class="form-control" name="user_content" rows="5"></textarea> -->
    </div>
    <div class="form-group">
    <button class="btn btn-primary" name="create_user">Add user</button>
    </div>
</form>