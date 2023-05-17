<?php

require('../inc/db_config.php');
require('../inc/essentials.php');

adminLogin();
    
if(isset($_POST['add_doctors']))
{

  $frm_data = filteration($_POST);
  $flag = 0;
  
  $q1 = "INSERT INTO `doctors`( `Doctor_name`, `Specialized`) VALUES (?,?)";
  $values = [$frm_data['Doctor_name'], $frm_data['Specialized']];

  if(insert($q1,$values,'ss')){
    $flag = 1;
  }

  if($flag){
    echo 1;
  }else{
    echo 0;
  }



}

if(isset($_POST['get_all_doctors']))
{
 
  $res = selectAll('doctors');
  $i= 1;
  $data = "";
  while($row = mysqli_fetch_assoc($res))
  {
    $data.="
    <tr class='align-middle'>
        <td style='padding-left: 20px'>$i</td>
        <td style='padding-left: 20px'>$row[Doctor_id]</td>
        <td>$row[Doctor_name]</td>
        <td>$row[Specialized]</td>
 
        
        <td>
          <button type='button' onclick='edit_details($row[Doctor_id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-doctors'>
            <i class='bi bi-pencil-square'></i>
          </button>
          <button type='button' onclick='remove_doctors($row[Doctor_id])' class='btn btn-danger shadow-none btn-sm'>
          <i class='bi bi-trash'></i>
          </button>
        </td>
    </tr>
    ";
    $i++;
  }
  echo $data;
}

if(isset($_POST['get_doctors']))
{
  $frm_data = filteration($_POST);
  $res1 = select("SELECT * FROM `doctors` WHERE  `Doctor_id`=?",[$frm_data['get_doctors']],'i');

  $doctordata = mysqli_fetch_assoc($res1);
 


  $data = ["doctordata" => $doctordata];

  $data = json_encode($data);
  echo $data;

}

if(isset($_POST['edit_doctors']))
{

  $frm_data = filteration($_POST);
  $flag = 0;

  $q1 = "UPDATE `doctors` SET `Doctor_name`=?,`Specialized`=? WHERE `Doctor_id`=?";
  $values = [$frm_data['Doctor_name'], $frm_data['Specialized'], $frm_data['Doctor_id']];
   
  if(update($q1,$values,'ssi')){
    $flag = 1;
  }

  if($flag){
    echo 1;
  }else{
    echo 0;
  }
}





if(isset($_POST['remove_doctors']))
{
    $frm_data = filteration($_POST);

    
    $res1 = delete("DELETE FROM `doctors` WHERE `Doctor_id`=?",[$frm_data['Doctor_id']],'i');
    if($res1)
    {
      echo 1;
    }
    else{
      echo 0;
    }
}
?>

