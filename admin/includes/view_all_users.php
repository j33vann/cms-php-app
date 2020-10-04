

<table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>First name</th>
                                    <th>Last name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                                <?php
                                
                                $query = "SELECT * FROM users";
                                $result = mysqli_query($connection, $query);

                                if(!$result){
                                    die("something went wrong");
                                }

                                while($row = mysqli_fetch_assoc($result)){
                                    $user_id = $row['user_id'];
                                    $username = $row['username'];
                                    $user_firstname = $row['user_firstname'];
                                    $user_lastname = $row['user_lastname'];
                                    $user_email = $row['user_email'];
                                    $user_role = $row['user_role'];
                                    // $user_image = $row['user_image'];
                                    // $user_tags = $row['user_tags'];
                                    // $user_users = $row['user_user_count'];
                                    
                                ?>
                            <tbody>

                                <td><?php echo $user_id ?></td>
                                <td><?php echo $username ?></td>
                                <td><?php echo $user_firstname ?></td>
                                <td><?php echo $user_lastname ?></td>

                                <td><?php echo $user_email ?></td>
                                <td><?php echo $user_role ?></td>
                                <td><?php echo "<a href='users.php?change_to_admin={$user_id}'>Admin</a>" ?></td>
                                <td><?php echo "<a href='users.php?change_to_subscriber={$user_id}'>Subscriber</a>" ?></td>
                                <td><?php echo "<a href='users.php?delete={$user_id}'>delete</a>" ?></td>
                                <td><?php echo "<a href='users.php?source=edit_user&u_id={$user_id}'>edit</a>" ?></td>
                                </tbody>
                                <?php 
                                
                                }
                                if(isset($_GET['delete'])){
                                    if(!isset($_SESSION['user_role'])){
                                        header("Location: ../index.php");
                                    } else {
                                        if($_SESSION['user_role'] !== 'admin'){
                                            header("Location: ../index.php");
                                        } else {                                    
                                            $the_user_id = mysli_real_escape_string($connection, $_GET['delete']);
        
                                            $query = "DELETE FROM users WHERE user_id='$the_user_id'";
        
                                            $result = mysqli_query($connection, $query);
        
                                            if(!$result){
                                                echo "something went wrong. try again";
                                            }
        
                                            header("Location: users.php");
                                        }
                                    }
                                }

                                if(isset($_GET['change_to_admin'])){
                                    $the_user_id = $_GET['change_to_admin'];

                                    $query = "UPDATE users SET user_role='admin' WHERE user_id='$the_user_id'";

                                    $result = mysqli_query($connection, $query);

                                    if(!$result){
                                        echo "something went wrong. try again";
                                    }

                                    header("Location: users.php");
                                }

                                if(isset($_GET['change_to_subscriber'])){
                                    $the_user_id = $_GET['change_to_subscriber'];

                                    $query = "UPDATE users SET user_role='subscriber' WHERE user_id='$the_user_id'";

                                    $result = mysqli_query($connection, $query);

                                    if(!$result){
                                        echo "something went wrong. try again";
                                    }

                                    header("Location: users.php");
                                }


                                ?>
                        </table>