<?php include "includes/header.php";?>
    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/navbar.php"; error_reporting(0);?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome <?php echo $_SESSION['username']; ?>
                            <small>Role: <?php echo $_SESSION['user_role']; ?></small>
                        </h1>
                        <div class="col-xs-6">
                            <form action="" method="post">
                                <?php
                                
                                if(isset($_POST['cat_title'])){
                                    $cat_title = $_POST['cat_title'];
                                    $cat_title = mysqli_real_escape_string($connection, $cat_title);
                                    if($cat_title == "" || empty($cat_title)){
                                        echo "Please enter a value";
                                    } else {
                                        $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?)");
                                        mysqli_stmt_bind_param($stmt, "s", $cat_title);
                                        mysqli_stmt_execute($stmt);
                                        if(!$stmt){
                                            die("Something went wrong. Please try again.");
                                        }
                                    }
                                }

                                ?>
                                <div class="form-group">
                                    <label for="cat_title">Add category</label>
                                    <input type="text" class="form-control" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-primary">Add category</button>
                                </div>
                            </form>
                                <?php
                                    if(isset($_GET['edit'])){
                                        $edit_cat_id = $_GET['edit'];
                                        $stmt = mysqli_prepare($connection, "SELECT cat_title FROM categories WHERE cat_id=?");
                                        // $query = "SELECT * FROM categories WHERE cat_id={$edit_cat_id}";
                                        mysqli_stmt_bind_param($stmt, "i", $edit_cat_id);
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_bind_result($stmt, $cat_title);
                                        // $select_categories = mysqli_query($connection, $query);
                                        while(mysqli_stmt_fetch($stmt)){
                                ?>
                                    <form action="" method="post">
                                        <div class="form-group">
                                            <label for="edit_cat_title">Edit category</label>
                                            <input type="text" class="form-control" name="edit_cat_title" value="<?php echo $cat_title ?>">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-primary">Edit category</button>
                                        </div>
                                    </form>
                                <?php
                                        }
                                    }
                                    if(isset($_POST['edit_cat_title'])){
                                        $edit_cat_title = mysqli_real_escape_string($_POST['edit_cat_title']);
                                        if($edit_cat_title !== "" || !empty($edit_cat_title)){
                                            echo $edit_cat_title;
                                            $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title=? WHERE cat_id=?");
                                            // $query = "UPDATE categories SET cat_title='$edit_cat_title' WHERE cat_id={$edit_cat_id}";
                                            mysqli_stmt_bind_param($stmt, "si", $edit_cat_title, $edit_cat_id);
                                            mysqli_stmt_execute($stmt);
                                            // $result = mysqli_query($connection, $query);
                                            if(!$stmt){
                                                die("something went wrong");
                                            } else {
                                                echo "working";
                                            }
                                            header("Location: categories.php");
                                        } else {
                                            echo "Please enter a value";
                                        }
                                    }
                                ?>
                        </div>
                        <div class="col-xs-6">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category title</th>
                                    <th>Delete</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            <?php
                        
                                $query = "SELECT * FROM categories";
                                
                                $all_queries = mysqli_query($connection, $query);

                                while($row = mysqli_fetch_assoc($all_queries)){
                                    $cat_id = $row['cat_id'];
                                    $cat_title = $row['cat_title'];
                                    echo "<tr>";
                                    echo "<td>{$cat_id}</td>";
                                    echo "<td>{$cat_title}</td>";
                                    echo "<td><a href='categories.php?delete={$cat_id}'>delete</td>";
                                    echo "<td><a href='categories.php?edit={$cat_id}'>edit</td>";
                                    echo "</tr>";
                                }

                                if(isset($_GET['delete'])){
                                    $the_cat_id = $_GET['delete'];
                                    $query = "DELETE FROM categories WHERE cat_id={$the_cat_id}";
                                    $result = mysqli_query($connection, $query);
                                    header("Location: categories.php");
                                    if(!$result){
                                        die("something went wrong");
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>
    <script src="js/scripts.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
