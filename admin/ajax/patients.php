<?php

require('../inc/db_config.php');
require('../inc/essentials.php');

adminLogin();
    
if(isset($_POST['add_patients']))
{

  $frm_data = filteration($_POST);
  $flag = 0;
  
  $q1 = "INSERT INTO `patients`( `Patients_name`, `date_of_birth`, `gender`,`address`, `number`) VALUES (?,?,?,?,?)";
  $values = [$frm_data['Patients_name'], $frm_data['date_of_birth'], $frm_data['gender'], $frm_data['address'],$frm_data['number']];

  if(insert($q1,$values,'ssisi')){
    $flag = 1;
  }

  if($flag){
    echo 1;
  }else{
    echo 0;
  }



}

if(isset($_POST['get_all_patients']))
{
 
  $res = selectAll('patients');
  $i= 1;
  
  $data = "";
  while($row = mysqli_fetch_assoc($res))
  {
    $gender = ($row['gender'] == 1) ? 'Nam' : 'Nữ';
    
    
    $data.="
    <tr class='align-middle'>
        <td style='padding-left: 20px'>$i</td>
        <td style='padding-left: 20px'>
        <span class='badge bg-success'>
        $row[patients_id]
            </span>
            </td>
        <td>$row[Patients_name]</td>
        <td>$row[date_of_birth]</td>
        <td>$gender</td>
        <td>$row[address]</td>
        <td>$row[number]</td>
 
        
        <td>
          <button type='button' onclick='edit_patients($row[patients_id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-patients'>
            <i class='bi bi-pencil-square'></i>
          </button>
          <button type='button' onclick='remove_patients($row[patients_id])' class='btn btn-danger shadow-none btn-sm'>
          <i class='bi bi-trash'></i>
          </button>
        </td>
    </tr>
    ";
    $i++;
  }
  echo $data;
}

if(isset($_POST['get_patients']))
{
  $frm_data = filteration($_POST);
  $res1 = select("SELECT * FROM `patients` WHERE  `patients_id`=?",[$frm_data['get_patients']],'i');

  $patientdata = mysqli_fetch_assoc($res1);
  $data = ["patientdata" => $patientdata];
  $data = json_encode($data);
  echo $data;

}

if(isset($_POST['edit_patients']))
{

  $frm_data = filteration($_POST);
  $flag = 0;

  $q1 = "UPDATE `patients` SET `Patients_name`=?,`date_of_birth`=?,`gender`=?,`address`=?,`number`=? WHERE `patients_id`=?";
  $values = [$frm_data['Patients_name'], $frm_data['date_of_birth'], $frm_data['gender'], $frm_data['address'], $frm_data['number'], $frm_data['patients_id']];
   
  if(update($q1,$values,'ssisii')){
    $flag = 1;
  }

  if($flag){
    echo 1;
  }else{
    echo 0;
  }
}





if(isset($_POST['remove_patients']))
{
    $frm_data = filteration($_POST);

    
    $res1 = delete("DELETE FROM `patients` WHERE `patients_id`=?",[$frm_data['patients_id']],'i');
    if($res1)
    {
      echo 1;
    }
    else{
      echo 0;
    }
}
?>

