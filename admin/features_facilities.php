<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();

if (isset($_GET['seen'])) {
    $frm_data = filteration($_GET);
    if ($frm_data['seen'] == 'all') {
        $q = "UPDATE `user_queries` SET `seen`=?";
        $values = [1];
        if (update($q, $values, 'i')) {
            alert('success', 'Marked all as read');
        } else {
            alert('error', 'Operation Failed');
        }
    } else {
        $q = "UPDATE `user_queries` SET `seen`=? WHERE `sr_no`=?";
        $values = [1, $frm_data['seen']];
        if (update($q, $values, 'ii')) {
            alert('success', 'Marked as read');
        } else {
            alert('error', 'Operation Failed');
        }
    }
}


if (isset($_GET['del'])) {
    $frm_data = filteration($_GET);
    if ($frm_data['del'] == 'all') {
        $q = "DELETE FROM `user_queries`";
        if (mysqli_query($con, $q)) {
            alert('success', 'All Data Deleted');
        } else {
            alert('error', 'Operation Failed');
        }
    } else {
        $q = "DELETE FROM `user_queries` WHERE `sr_no`=?";
        $values = [$frm_data['del']];
        if (delete($q, $values, 'i')) {
            alert('success', 'Data Deleted');
        } else {
            alert('error', 'Operation Failed');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Features & Facilities</title>
    <?php require('inc/link.php'); ?>
    <?php require('inc/scripts.php'); ?>

</head>

<body class="bg-light">

    <?php require('inc/header.php') ?>
    
    <div class="container-fluid" id="main-content">

        <div class="col-lg-10 ms-auto p-4 overflow-hidden">

            <!-- features section -->
            <div class="card border-0 shadow-sm mb-4" style="background:rgba(231, 231, 231, 1)">
                <div class="card-body">
                    <div class="d-flex align-self-center justify-content-between">
                        <h3 class="mt-1" style="font-family: 'Josefin Sans', sans-serif; color:rgba(15, 74, 78, 1); font-weight: 700;">FEATURES & FACILITIES</h3>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm mb-4" style="background:rgba(231, 231, 231, 1);">
                <div class="card-body">
                    <div class="d-flex align-self-center justify-content-between">
                        <h5 class="card-title m-0 pt-2" style="font-weight: 700;">Features</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#feature-s">
                            <i class="bi bi-plus-square"></i> Add
                        </button>
                    </div>
                <div class="table-responsive-md mt-3" style="border-radius: 10px;background:white">
                    <table class="table table-hover border" style="width: 100%">
                        <thead>
                            <tr class="text-dark">
                                <th scope="col-sm" style="padding-left: 20px">ID</th>
                                <th scope="col-sm">Name</th>
                                <th scope="col-sm">Action</th>
                            </tr>
                        </thead>
                        <tbody id="features-data">
                        </tbody>

                    </table>
                </div>
                </div>
            </div>

            <!-- facilities section -->
            <div class="card border-0 shadow-sm mb-4" style="background:rgba(231, 231, 231, 1);">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h5 class="card-title m-0 pt-2" style="font-weight: 700;">Facilities</h5>
                        <button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#facility-s">
                            <i class="bi bi-plus-square"></i> Add
                        </button>
                    </div>
                    <div class="table-responsive-md mt-3" style="border-radius: 10px; background:white">
                        <table class="table table-hover border" style="width: 100%">
                            <thead>
                                <tr class="text-dark">
                                    <th scope="col" style="padding-left: 20px">ID</th>
                                    <th scope="col">Icon</th>
                                    <th scope="col">Name</th>
                                    <th scope="col" width="40%">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="facilities-data">
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
    <!-- management feature modal -->
    <div class="modal fade" id="feature-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="feature_s_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Feature</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" id="feature_name" class="form-control shadow-none" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- management facility modal -->
    <div class="modal fade" id="facility-s" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form id="facility_s_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Facility</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Name</label>
                            <input type="text" name="facility_name" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Icon</label>
                            <input type="file" name="facility_icon" accept=".svg, .png" class="form-control shadow-none" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Description</label>
                            <textarea name="facility_desc" class="form-control shadow-none" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">SUBMIT</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <?php require('inc/scripts.php') ?>
    <script src="scripts/features_facilities.js"></script>



</body>

</html>