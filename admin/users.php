<?php include "includes/header.php";?>
    <div id="wrapper">

        <!-- Navigation -->
        <?php include "includes/navbar.php"; ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <?php
                        if(isset($_GET['source'])){
                            switch ($_GET['source']){
                                case "add_user":
                                    include "includes/add_user.php";
                                break;
                                case "edit_user":
                                    include "includes/edit_user.php";
                                break;
                                case "33":
                                    echo "nioce";
                                break;
                                case "34":
                                    echo "nioce";
                                break;
                                default: 
                                    include "includes/view_all_users.php";
                                break;
                            }
                        } else {
                            include "includes/view_all_users.php";
                        }
                        ?>
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

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Custom Javascript -->
    <script src="js/scripts.js"></script>

</body>

</html>
