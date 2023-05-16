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
    <title>Admin Panel - New Bookings</title>
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
                        <h3 class="mt-1" style="font-family: 'Josefin Sans', sans-serif; color:rgba(15, 74, 78, 1); font-weight: 700;">NEW BOOKINGS</h3>
                        <input type="text" oninput="get_bookings(this.value)" class="form-control shadow-none w-25" placeholder="Search By Name">
                    </div>

                    <div class="mt-3 table-responsive" style="border-radius: 10px;background:white">
                        <table class="table table-hover border" style="min-width: 1180px">
                            <thead>
                                <tr class="text-dark ">
                                    <th scope="col-sm" style="padding-left: 20px">ID</th>
                                    <th scope="col-sm">Order ID</th>
                                    <th scope="col-sm">Name </th>
                                    <th scope="col-sm">Phone </th>
                                    <th scope="col-sm">Room</th>
                                    <th scope="col-sm">Price</th>
                                    <th scope="col-sm">Room Details</th>
                                    <th scope="col-sm">Total Price</th>
                                    <th scope="col-sm">Date</th>
                                    <th scope="col-sm">Action</th>
                                </tr>
                            </thead>
                            <tbody id="table-data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>



    <!-- Assign Room Number Modal -->
    <div class="modal fade" id="assign-room" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog ">
            <form id="assign_room_form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Assign Room</h5>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Room Number</label>
                            <input type="text" id="booking_status" class="form-control shadow-none" required>
                        </div>
                        <span class="badge rounded-pill bg-light text-dark mb-3 text-wrap lh-base">
                            Note: Assign Room Number only when user has been arrived! 
                       </span>
                       <input type="hidden" name="booking_id">
                    </div>
                    <div class="modal-footer">
                        <button type="reset" class="btn text-secondary shadow-none" data-bs-dismiss="modal">CANCEL</button>
                        <button type="submit" class="btn custom-bg text-white shadow-none">ASSIGN</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <?php require('inc/scripts.php') ?>
    <script src="scripts/new_bookings.js"></script>
</body>

</html>