<!DOCTYPE html>
<html lang="en">
<?php

    session_start();
    require_once("../controllers/db_con.php");
    include("head_admin.php");
    include("helper/main.php");
    $db = new database();
    $tbl = "";
    $errors = [];
    $user_profile_img = isset($_SESSION['profile_img']) ? $_SESSION['profile_img'] : "./uploads/default_profile.png";
    $session_username = isset($_SESSION['username']) ? $_SESSION['username'] : "admin";
?>
<body id="page-top">
<?php //include('../php/preloader.php')?>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include('sidebar_admin.php')?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php include("topbar_admin.php")?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <?php
                    @$page = $_GET["page"] ?: "dashboard";
                    @include("$page.php")
                ?>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <?php include("modal_container.php")?>

    <script src="../vendor/jquery-ui-1.13.2/external/jquery/jquery.js"></script>
    <script src="../vendor/jquery-ui-1.13.2/jquery-ui.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="../vendor/jquery/jquery.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Popper js -->
    <script src="../js/bootstrap/popper.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../js/sb-admin-2.min.js"></script>
    <script src="../js/active.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/chart.js/Chart.min.js"></script>

    <!-- Page level plugins -->
    <script src="../vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../js/chartjs/datatables-demo.js"></script>
    <script src="../js/script.js"></script>



    <!-- <script>
        $('#logout_session').click(function(){
            $('#logoutModal button').attr('disabled',true)
            $.ajax({
                url:'././helper/init.php?a=logout',
                method:'POST',
                dataType:'JSON',
                error:err=>{
                    console.log(err)
                    alert("an error occurred.")
                    $('#confirm_modal button').attr('disabled',false)
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload()
                    }else{
                        alert("An error occurred.")
                        $('#confirm_modal button').attr('disabled',false)
                    }
                }
            })
        })
    </script> -->
    <?php
        switch($page){
            case 'dashboard':
                include('./include/sales_area_graph.php');
                include('./include/menu_type_pie.php');
            break;
            case 't_settings':
                include('./include/manage_table_js.php');
            break;
            case 'reason_settings':
                include('./include/reason_settings_js.php');
            break;
            case 'f_plan':
                include('./include/f_plan_js.php');
            break;
            case 'reserved_list':
                include('./include/reserve_list_js.php');
            break;
            case 'menu_list':
                include('./include/menu_list_js.php');
            break;
            case 'users':
                include('./include/users_list_js.php');
            break;
            case 'a_users':
                include('./include/users_list_js.php');
            break;
            case 'ad_users':
                include('./include/users_list_js.php');
            break;
            default:
                echo "<script>console.log('None Import')</script>";
            break;
        }
    ?>

</body>

</html>