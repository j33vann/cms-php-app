<?php
if(isset($_POST['checkBoxArray'])){
    $array = $_POST['checkBoxArray'];
    foreach($array as $arrayValue){
        $bulk_options = $_POST['bulk_options'];
        switch($bulk_options){
            case "published":
            $publish_query = "UPDATE posts SET post_status='{$bulk_options}' WHERE post_id={$arrayValue}";
            $publish_result = mysqli_query($connection, $publish_query);
            if(!$publish_result){
                die("Something went wrong" . mysqli_error($connection));
            }
            break;

            case "draft":
            $draft_query = "UPDATE posts SET post_status='{$bulk_options}' WHERE post_id={$arrayValue}";
            $draft_result = mysqli_query($connection, $draft_query);
            if(!$draft_result){
                die("Something went wrong" . mysqli_error($connection));
            }
            break;

            case "delete":
            $delete_query = "DELETE FROM posts WHERE post_id={$arrayValue}";
            $delete_result = mysqli_query($connection, $delete_query);
            if(!$delete_result){
                die("Something went wrong" . mysqli_error($connection));
            }
            break;

            case "clone":
                $select_clone_query = "SELECT * FROM posts WHERE post_id={$arrayValue}";
                $select_clone_result = mysqli_query($connection, $select_clone_query);
                if($select_clone_result){
                    while($row = mysqli_fetch_assoc($select_clone_result)){
                        $clone_post_title = $row['post_title'];
                        $clone_post_category_id = $row['post_category_id'];
                        $clone_post_author = $row['post_author'];
                        $clone_post_user = $row['post_user'];
                        $clone_post_status = $row['post_status'];
                        $clone_post_image = $row['post_image'];
                        $clone_post_image_temp = $row['post_image'];
                        $clone_post_tags = $row['post_tags'];
                        $clone_post_content = $row['post_content'];
                        $clone_post_date = date("d-m-y");

                        move_uploaded_file($clone_post_image_temp, "../images/$clone_post_image");
                    }
                } else {
                    die("error: " . nysqli_error($connection));
                }
                $clone_query = "INSERT INTO posts(post_title, post_category_id, post_author, post_user, post_status, post_image, post_tags, post_content, post_date) VALUES('$clone_post_title', '$clone_post_category_id', '$clone_post_author', '$clone_post_user', '$clone_post_status', '$clone_post_image', '$clone_post_tags', '$clone_post_content', now())";
                $clone_result = mysqli_query($connection, $clone_query);
                if(!$clone_result){
                    die("Something went wrong" . mysqli_error($connection));
                }
                break;
        }
    }
}
?>
<table class="table table-bordered table-hover">
    <form action="" method="post">
        <div class="col-xs-4">
            <select name="bulk_options" id="" class="form-control">
                <option value="" default hidden>Select an option</option>
                <option>draft</option>
                <option>published</option>
                <option>delete</option>
                <option>clone</option>
            </select>
        </div>
        <div class="col-xs-4">
            <button class="btn btn-success" type="submit" name="apply">Apply</button>
            <a href="posts.php?source=add_post"><button class="btn btn-primary" type="button">Add new</button></a>
        </div>
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAllBoxes"></th>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                    <th>Delete</th>
                                    <th>Edit</th>
                                    <th>Post view reset</th>
                                    <th>Post view count</th>
                                </tr>
                            </thead>
                                <?php
                                
                                $query = "SELECT posts.post_id, posts.post_author, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_view_count, categories.cat_id, categories.cat_title FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY post_id DESC";
                                // WHERE posts.post_user='{$_SESSION['username']}' 
                                $result = mysqli_query($connection, $query);

                                if(!$result){
                                    die("something went wrong");
                                }

                                while($row = mysqli_fetch_assoc($result)){
                                    $post_id = $row['post_id'];
                                    $post_author = $row['post_author'];
                                    $post_user = $row['post_user'];
                                    $post_title = $row['post_title'];
                                    $post_category = $row['post_category_id'];
                                    $post_status = $row['post_status'];
                                    $post_image = $row['post_image'];
                                    $post_tags = $row['post_tags'];
                                    $post_comments = $row['post_comment_count'];
                                    $post_date = $row['post_date'];
                                    $post_view_count = $row['post_view_count'];
                                    $category_title = $row['cat_title'];
                                    $category_id = $row['cat_id'];
                                    
                                ?>
                            <tbody>
                                <td><input type="checkbox" class="checkBoxes" id="valueCheckbox" name="checkBoxArray[]" value=<?php echo $post_id ?>></td>
                                
                                <td><?php echo $post_id ?></td>
                                
                                <?php
                                if(!isset($post_author) || !empty($post_author)){
                                    echo "<td>$post_author</td>"; 
                                    echo "<script>alert('asdasd')</script>"; 
                                } elseif(isset($post_user) || !empty($post_user)){
                                    echo "<td>$post_user</td>"; 
                                }
                                ?>
                                
                                <td><?php echo "<a href='../post.php?p_id=$post_id'>$post_title</a>" ?></td>

                                <?php
                                
                                // $cat_query = "SELECT * FROM categories WHERE cat_id={$post_category}";
                                // $cat_result = mysqli_query($connection, $cat_query);

                                // if(!$cat_result){
                                //     die("something went wrong");
                                // }

                                // while($cat_row = mysqli_fetch_assoc($cat_result)){
                                //     $cat_id = $cat_row['cat_id'];
                                //     $cat_title = $cat_row['cat_title'];
                                //     if($post_category = $cat_id){
                                
                                ?>
                                <td><?php echo $category_title ?></td>
                                <?php //} } ?>
                                <td><?php echo $post_status ?></td>
                                <td><?php echo "<img src='../images/$post_image' style='width:100%;'>" ?></td>
                                <td><?php echo $post_tags ?></td>

                                <?php
                                
                                $comment_query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
                                $send_comment_query = mysqli_query($connection, $comment_query);
                                if(!$send_comment_query){
                                    die("error: " . mysqli_error($connection));
                                }
                                $count_row = mysqli_fetch_array($send_comment_query);
                                if(isset($count_row['comment_id'])){
                                    $comment_id = $count_row['comment_id'];
                                } else {
                                    $comment_id = "";
                                }
                                $comment_count = mysqli_num_rows($send_comment_query);
                                ?>
                                <td><?php echo "<a href='post_comment.php?id=$post_id'>$comment_count</a>" ?></td>
                                <td><?php echo $post_date ?></td>
                                <!-- <td><?php //echo "<a rel='$post_id' class='deleteModalLink' data-toggle='modal' data-target='#deleteModal' style='cursor: pointer;'>delete</a>" ?></td> -->
                                <form action="" method="post" name="deleteForm">
                                    <input name="post_id" type="hidden" value="<?php echo $post_id ?>">
                                    <td><button name="delete" class="btn btn-danger">Delete</button></td>
                                </form>
                                <td><?php echo "<a class='btn btn-primary' href='posts.php?source=edit_post&p_id={$post_id}'>edit</a>" ?></td>
                                <td><?php echo "<a href='posts.php?reset={$post_id}'>reset</a>"; ?></td>
                                <td><?php echo $post_view_count ?></td>
                                </tbody>

<!-- Modal -->
<!-- 
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you wanna delete it?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a id='confirmDelete'><button type="button" class="btn btn-danger">Delete</button></a>
        <form action="" method="post">
            <input name="post_id" type="hidden" value="<?php //echo $post_id ?>">
            <button name="delete" class="btn btn-danger">Delete</button>
        </form>
      </div>
    </div>
  </div>
</div> -->

                                <?php
                                
                                }
                                if(isset($_POST['delete'])){
                                    $the_post_id = $_POST['post_id'];

                                    $query = "DELETE FROM posts WHERE post_id='$the_post_id'";

                                    $result = mysqli_query($connection, $query);

                                    if(!$result){
                                        echo "something went wrong. try again";
                                    }

                                    header("Location: posts.php");
                                }

                                if(isset($_GET['reset'])){
                                    $the_post_id = $_GET['reset'];
                                    $view_count_query = "UPDATE posts SET post_view_count=0 WHERE post_id={$the_post_id}";
                                    $view_count_result = mysqli_query($connection, $view_count_query);
                                    header("Location: posts.php");
                                }

                                ?>
                        </table>
                        </form>

<script src="js/jquery.js"></script>

<script>
    $('#selectAllBoxes').click(function(){
        if(this.checked){
        $(".checkBoxes").each(function(){
            this.checked = true;
        })
        }
    })
    
    $('.deleteModalLink').click(function(){
        var postId = $(this).attr("rel");
        $("#confirmDelete").attr("href",  "posts.php?delete=" + postId + "")
    })

</script> 