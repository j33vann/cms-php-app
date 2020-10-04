<?php
if(isset($_POST['edit_post'])){
    $post_title = mysqli_real_escape_string($connection, $_POST['post_title']);
    $post_category_id = mysqli_real_escape_string($connection, $_POST['post_category_id']);
    $post_user = mysqli_real_escape_string($connection, $_POST['post_user']);
    $post_status = mysqli_real_escape_string($connection, $_POST['post_status']);
    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    $post_tags = mysqli_real_escape_string($connection, $_POST['post_tags']);
    $post_content = mysqli_real_escape_string($connection, $_POST['post_content']);
    $post_date = date("d-m-y");
    $post_comment_count = 4;
    
    move_uploaded_file($post_image_temp, "../images/$post_image");
    $post_id = $_GET['p_id'];
    $query = "UPDATE posts SET post_title='$post_title', post_category_id='$post_category_id', post_user='$post_user', post_status='$post_status', ";
    if($post_image !=="" || !empty($post_image)){
        $query .= "post_image='$post_image', ";
    }
    $query .= "post_tags='$post_tags', post_content='$post_content', post_date=now(), post_comment_count='$post_comment_count' WHERE post_id=$post_id";
    $result = mysqli_query($connection, $query);

    if(!$result){
        echo "something went wrong";
    } else {
        echo "<p style='padding: 10px 0px 10px 5px;' class='bg-success'>Post updated successfully</p>";
    }
    // header("Location: posts.php?source=edit_post&p_id={$post_id}");
}

if(isset($_GET['p_id'])){
    $edit_posts_query = "SELECT * FROM posts WHERE post_id={$_GET['p_id']}";
    $result = mysqli_query($connection, $edit_posts_query);
    if(!$result){
        echo"something weseef";
    }
    while($row = mysqli_fetch_assoc($result)){
        $username = $row['post_user'];
        $post_cat_id = $row['post_category_id'];
        
?>

<form action="" method="post" enctype= "multipart/form-data">
<div class="form-group">
    <label for="post_title">Post title</label>
    <input class="form-control" type="text" name="post_title" value="<?php echo $row['post_title'] ?>">
    
    <label for="post_category">Post category</label>
    
    <select class="form-control" name="post_category_id" id="post_category">

    <?php
    $category_query = "SELECT * FROM categories";
    $category_result = mysqli_query($connection, $category_query);
    if(!$category_query){
        die("somethin went wrong");
    }
    ?>

    <?php 

    while($row_category = mysqli_fetch_assoc($category_result)){ 
        $cat_id = $row_category['cat_id'];
        $cat_title = $row_category['cat_title'];


        if($cat_id == $post_cat_id){
            echo "<option value={$cat_id} selected>{$cat_title}</option>";
        } else {
        echo "<option value={$cat_id}>{$cat_title}</option>";
            
        }
    } 

    // $select_cat_query = "SELECT * FROM categories WHERE cat_id = {$post_cat_id}";
    // $select_cat_result = mysqli_query($connection, $select_cat_query);
    // while($select_cat_row = mysqli_fetch_assoc($select_cat_result)){
        

    ?>



    </select>

    <label for="post_user">Post author</label>
    <select name="post_user" id="post_user">
    <?php
    $users_query = "SELECT * FROM users";
    $users_result = mysqli_query($connection, $users_query);
    if(!$users_query){
        die("somethin went wrong");
    }
    ?>
        <option value=<?php echo $username ?> ><?php echo $username ?></option>
    <?php
    while($row_users = mysqli_fetch_assoc($users_result)){
        $user_id = $row_users['user_id'];
        $user_author = $row_users['username'];
        if($user_author == $username){
            
        } else {
            echo "<option value={$user_author}>{$user_author}</option>";

        }
    }
    ?>
    </select><br>
    <label for="post_status">Post status</label>
    <select name="post_status" id="post_status" class="form-control">
        <option><?php echo $row['post_status'] ?></option>
        <?php
        if($row['post_status'] == 'published'){
            echo "<option>draft</option>";
        } else {
            echo "<option>published</option>";
        }
        ?>
    </select>
    <label for="post_image">Post image</label>
    <input type="file" name="post_image">
    <img name="post_image" width="100" src="../images/<?php echo $row['post_image']; ?>" alt="">-- default
    <?php if(!$row['post_image']) echo"File does not exist<br>"; ?><br>
    <label for="post_tags">Post tags</label>
    <input class="form-control" type="text" name="post_tags" value="<?php echo $row['post_tags'] ?>">
    <label for="post_content">Post content</label>
    <textarea id="body" class="form-control" name="post_content" rows="5"><?php echo $row['post_content'] ?></textarea>
    </div>
    <div class="form-group">
    <button class="btn btn-primary" name="edit_post">Edit post</button>
    </div>
</form>

<?php
    }
}

?>