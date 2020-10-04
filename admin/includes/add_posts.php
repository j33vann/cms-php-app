<?php

if(isset($_POST['create_post'])){
    $post_title = $_POST['post_title'];
    $post_category_id = $_POST['post_category_id'];
    $post_user = $_POST['post_user'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_date = date("d-m-y");
    // $post_comment_count = 4;

    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts(post_title, post_category_id, post_user, post_status, post_image, post_tags, post_content, post_date) VALUES('$post_title', '$post_category_id', '$post_user', '$post_status', '$post_image', '$post_tags', '$post_content', now())";

    $result = mysqli_query($connection, $query);

    if(!$result){
        echo "something went wrong";
    } else {
        echo "<p style='padding: 10px 0px 10px 5px;' class='bg-success'>Post added successfully</p>";
    }
}

?>

<form action="" method="post" enctype= "multipart/form-data">
<div class="form-group">
    <label for="post_title">Post title</label>
    <input class="form-control" type="text" name="post_title">
    <?php
    $category_query = "SELECT * FROM categories";
    $category_result = mysqli_query($connection, $category_query);
    if(!$category_query){
        die("somethin went wrong");
    }
    ?>
    <label for="post_category">Post category</label><br>
    <select class="form-control" name="post_category_id" id="post_category">
    <?php while($row_category = mysqli_fetch_assoc($category_result)){ ?>
        <option value=<?php echo $row_category['cat_id']; ?>> <?php echo $row_category['cat_title'];?></option>
        <?php } ?>
    </select><br>
    <?php
    $users_query = "SELECT * FROM users";
    $users_result = mysqli_query($connection, $users_query);
    if(!$users_query){
        die("somethin went wrong");
    }
    ?>
    <label for="post_user">Post author</label>
    <!-- <input class="form-control" type="text" name="post_author"> -->
    <select name="post_user" id="post_user">
    <?php
    while($row_users = mysqli_fetch_assoc($users_result)){
        $user_id = $row_users['user_id'];
        $user_author = $row_users['username'];
        ?>
        <option value=<?php echo $user_author ?> ><?php echo $user_author ?></option>
        <?php
    }
    ?>
    </select><br>
    <label for="post_status">Post status</label>
    <select class="form-control" name="post_status" id="post_status">
        <option value="draft">draft</option>
        <option value="published">publish</option>
    </select>
    <label for="post_image">Post image</label>
    <input type="file" name="post_image">
    <label for="post_tags">Post tags</label>
    <input class="form-control" type="text" name="post_tags">
    <label for="post_content">Post content</label>
    <textarea class="form-control" id="body" name="post_content"></textarea>
    <style>
        .ck-editor__editable_inline{
            min-height: 250px;
        }
    </style>
    </div>
    <div class="form-group">
    <button class="btn btn-primary" name="create_post">Add post</button>
    </div>
</form>