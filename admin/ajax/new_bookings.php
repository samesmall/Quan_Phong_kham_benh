<?php

require('../inc/db_config.php');
require('../inc/essentials.php');

adminLogin();
    

if(isset($_POST['get_bookings']))
{
    $frm_data = filteration($_POST);
   $query = "SELECT bo.* ,bd.* FROM `booking_order` bo INNER JOIN `booking_details` bd ON bo.booking_id = bd.booking_id
   WHERE (bo.order_id LIKE ? OR bd.phonenum LIKE ? OR bd.user_name LIKE ?)
   AND (bo.booking_status=? AND bo.arrival=?) ORDER BY bo.booking_id ASC";

   $res = select($query,["%$frm_data[search]%","%$frm_data[search]%","%$frm_data[search]%","pending",0],'sssss');
   $i=1;
   $table_data = "";

   if(mysqli_num_rows($res)==0){
    echo "<b style='padding-left: 20px'>No Data Found!</b>";
    exit();
   }
   while ($data = mysqli_fetch_assoc($res))
   {
    $date = date("d-m-Y",strtotime($data['datentime']));
    $checkin = date("d-m-Y",strtotime($data['check_in']));
    $checkout = date("d-m-Y",strtotime($data['check_out']));
    $table_data .="
    <tr>
        <td style='padding-left: 20px'>$i</td>
        <td>
            <span class='badge bg-primary'>
                $data[order_id]
            </span>
        </td>
        <td>
         $data[user_name]
        </td>
        <td>
        $data[phonenum]
        </td>
        <td>
             $data[room_name]
        </td>
        <td>
         $data[price] vnd
        </td>
        <td>
        <b>Check in:</b> $checkin
         <br>
        <b>Check out:</b> $checkout
        </td>
        <td>
         $data[total_pay] vnd
        </td>
        <td>
        $date
        </td>
        <td>
            <button type='button' onclick='assign_room($data[booking_id])' class='btn text-white btn-sm fw-bold custom-bg shadow-none' data-bs-toggle='modal' data-bs-target='#assign-room'>
               <i class='bi bi-check2-square'></i> Assign Room
            </button>
            <br>
            <button type='button' onclick='cancel_booking($data[booking_id])' class='mt-2 btn btn-outline-danger btn-sm fw-bold shadow-none'>
            <i class='bi bi-trash'></i> Cancel Booking
            </button>
        </td>
    </tr>
    ";
    $i++;
   }
   echo $table_data;
}


if(isset($_POST['assign_room']))
{
    $frm_data = filteration($_POST);

    $query = "UPDATE `booking_order` bo INNER JOIN `booking_details` bd 
    ON bo.booking_id = bd.booking_id
    SET bo.arrival = ?, bo.booking_status = ? 
    WHERE bo.booking_id = ?";

    $values = [1,$frm_data['booking_status'],$frm_data['booking_id']];
    $res = update($query,$values,'isi');//it will update 2 rows so it will return 2

    echo ($res==2) ? 1 : 0;

}


if(isset($_POST['cancel_booking']))
{
    $frm_data = filteration($_POST);
    
   $query = "UPDATE `booking_order` SET `booking_status`=?, `refund`=? WHERE `booking_id`=?";
   $values = ['cancelled',0,$frm_data['booking_id']];
   $res = update($query,$values,'sii');

   echo $res;
}


if(isset($_POST['search_user']))
{
  $frm_data = filteration($_POST);
  $query = "SELECT * FROM `user_cred` WHERE `name` LIKE ?";
  $res = select($query,["%$frm_data[name]%"],'s');
  $i= 1;

  $data = "";
  while($row = mysqli_fetch_assoc($res))
  {
    $del_btn = "<button type='button' onclick='remove_user($row[id])' class='btn btn-danger shadow-none btn-sm'>
    <i class='bi bi-trash'></i>
    </button>";
    $verified = "<span class='badge bg-warning'><i class='bi bi-x-lg'></i></span>";

    if($row['is_verified']){
        $verified = "<span class='badge bg-success'><i class='bi bi-check-lg'></i></span>";
        $del_btn ="";
    }

    $status = "<button onclick='toggle_status($row[id],0)' class='btn btn-sm btn-success text-white shadow-none'>active</button>";

    if(!$row['status']){
        $status = "<button onclick='toggle_status($row[id],1)' class='btn btn-sm btn-danger text-white shadow-none'>inactive</button>";
    }
    $date = date("d-m-Y : H:m:s",strtotime($row['datentime']));
    $data.="
    <tr>
        <td>$i</td>
        <td>$row[name]</td>
        <td>$row[email]</td>
        <td>$row[phonenum]</td>
        <td>$verified</td>
        <td>$status</td>
        <td>$date</td>
        <td>$del_btn</td>
    </tr>
    ";
    $i++;
  }
  echo $data;
}
?>

