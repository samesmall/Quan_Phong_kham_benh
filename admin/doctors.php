<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Doctors</title>
    <?php require('inc/link.php'); ?>
    <?php require('inc/scripts.php'); ?>

</head>

<body class="bg-light">

    <?php require('inc/header.php') ?>

    <div class="col-lg-10 ms-auto p-4 overflow-hidden">

        <!-- features section -->
        <div class="card border-0 shadow-sm mb-4" style="background:rgba(231, 231, 231, 1)">
            <div class="card-body">

                <div class="d-flex align-self-center justify-content-between">
                    <h3 class="mt-1" style="font-family: 'Josefin Sans', sans-serif; color:rgba(15, 74, 78, 1); font-weight: 700;"><i class="bi bi-people-fill"> </i> DOCTORS</h3>
                    <div class="text-end mb-3">
                        <button type="button" class="btn btn-success shadow-none btn-sm" data-bs-toggle="modal" data-bs-target="#add-doctors">
                            <i class="bi bi-plus-square"></i> Add
                        </button>
                    </div>
                </div>

                <!--  overflow-y: scroll; -->
                <div class="table-responsive-lg" style="height:450px;border-radius: 10px;background:white">
                    <table class="table table-hover border" style="width: 100%">
                        <thead>
                        <tr class="text-white text-left" style="background:#6096B4;font-size:13px;">
                                <th scope="col-sm" style="padding-left: 20px">ID<br>Số thứ tự</th>
                                <th scope="col-sm" style="padding-left: 20px">Doctor_id<br>Mã bác sĩ</th>
                                <th scope="col" style="width: 30%">Doctor_name<br>Tên bác sĩ</th>
                                <th scope="col-sm" style="width: 30%">Specialized<br>Chuyên ngành</th>
                                <th scope="col-sm">Action<br>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody id="doctors-data">
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>

    <!-- add room modal -->
    <div class="modal fade" id="add-doctors" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <form id="add_doctors_form" autocomplete="off">
                <div class="modal-content">
                    <div class="modal-header text-white" style="background:#6096B4">
                        <h5 class="modal-title">Add New Doctor</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Doctor name</label>
                                <input type="text" id="Doctor_name" class="form-control shadow-none" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label fw-bold">Specialized</label>
                                <textarea name="Specialized" rows="4" class="form-control shadow-none" required></textarea>
                            </div>
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
 <!-- edit doctor modal -->
        <div class="modal fade" id="edit-doctors" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-md">
                    <form id="edit_doctors_form" autocomplete="off">
                        <div class="modal-content">
                            <div class="modal-header text-white" style="background:#6096B4">
                                <h5 class="modal-title">Edit Doctor</h5>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <input type="hidden" name="Doctor_id">
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-bold">Doctor name</label>
                                        <input type="text" id="Doctor_name" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label fw-bold">Specialized</label>
                                        <textarea name="Specialized" rows="4" class="form-control shadow-none" required></textarea>
                                    </div>
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
    <script src="scripts/doctors.js"></script>
</body>

</html>