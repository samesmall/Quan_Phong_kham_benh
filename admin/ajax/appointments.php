<?php

require('../inc/db_config.php');
require('../inc/essentials.php');

adminLogin();
    
if(isset($_POST['add_appointments']))
{

  $frm_data = filteration($_POST);
  $flag = 0;
  
  $q1 = "INSERT INTO `appointments`( `doctors_id`, `patients_id`, `Appointment_time`,`note`) VALUES (?,?,?,?)";
  $values = [$frm_data['doctors_id'], $frm_data['patients_id'], $frm_data['Appointment_time'], $frm_data['note']];

  if(insert($q1,$values,'iiss')){
    $flag = 1;
  }

  if($flag){
    echo 1;
  }else{
    echo 0;
  }



}

if(isset($_POST['get_all_appointments']))
{
 
  $res = selectAll('appointments');
  $i= 1;
  $data = "";
  while($row = mysqli_fetch_assoc($res))
  {
    $data.="
    <tr class='align-middle'>
        <td style='padding-left: 20px'>$i</td>
        <td><span class='badge bg-danger'>
        $row[Appointment_id]
        </span></td>
        <td style='padding-left: 20px'>
        <span class='badge bg-info'>
        $row[doctors_id]
        </span></td>
        <td>
        <span class='badge bg-success'>
        $row[patients_id]
        </span></td>
        <td>$row[Appointment_time]</td>
        <td>$row[note]</td>
 
        
        <td>
          <button type='button' onclick='edit_appointments($row[Appointment_id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-appointments'>
            <i class='bi bi-pencil-square'></i>
          </button>
          <button type='button' onclick='remove_appointments($row[Appointment_id])' class='btn btn-danger shadow-none btn-sm'>
          <i class='bi bi-trash'></i>
          </button>
        </td>
    </tr>
    ";
    $i++;
  }
  echo $data;
}

if(isset($_POST['get_appointments']))
{
  $frm_data = filteration($_POST);
  $res1 = select("SELECT * FROM `appointments` WHERE  `Appointment_id`=?",[$frm_data['get_appointments']],'i');

  $appointmentdata = mysqli_fetch_assoc($res1);
 


  $data = ["appointmentdata" => $appointmentdata];

  $data = json_encode($data);
  echo $data;

}

if(isset($_POST['edit_appointments']))
{

  $frm_data = filteration($_POST);
  $flag = 0;

  $q1 = "UPDATE `appointments` SET `Appointment_time`=?,`doctors_id`=?,`Appointment_id`=?,`note`=? WHERE `patients_id`=?";
  $values = [$frm_data['Appointment_time'], $frm_data['doctors_id'], $frm_data['Appointment_id'], $frm_data['note'], $frm_data['patients_id']];
   
  if(update($q1,$values,'siisi')){
    $flag = 1;
  }

  if($flag){
    echo 1;
  }else{
    echo 0;
  }
}





if(isset($_POST['remove_appointments']))
{
    $frm_data = filteration($_POST);

    
    $res1 = delete("DELETE FROM `appointments` WHERE `Appointment_id`=?",[$frm_data['Appointment_id']],'i');
    if($res1)
    {
      echo 1;
    }
    else{
      echo 0;
    }
}
?>

