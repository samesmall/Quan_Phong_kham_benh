<?php

require('../inc/db_config.php');
require('../inc/essentials.php');

adminLogin();
    
if(isset($_POST['add_admins']))
{

  $frm_data = filteration($_POST);
 
  
  $q1 = "INSERT INTO `admin_cred`( `admin_name`, `admin_pass`) VALUES (?,?)";
  $values = [$frm_data['admin_name'], $frm_data['admin_pass']];

  if(insert($q1,$values,'ss')){
    $flag = 1;
  }

  if($flag){
    echo 1;
  }else{
    echo 0;
  }



}

if(isset($_POST['get_all_admins']))
{
 
  $res = selectAll('admin_cred');
  $i= 1;
  $data = "";
  while($row = mysqli_fetch_assoc($res))
  {
    $data.="
    <tr class='align-middle'>
        <td style='padding-left: 20px'>$i</td>
        <td>$row[admin_name]</td>
        <td>$row[admin_pass]</td>
        <td>
          <button type='button' onclick='remove_admins($row[sr_no])' class='btn btn-danger shadow-none btn-sm'>
          <i class='bi bi-trash'></i>
          </button>
        </td>
    </tr>
    ";
    $i++;
  }
  echo $data;
}







if(isset($_POST['remove_admins']))
{
    $frm_data = filteration($_POST);

    
    $res1 = delete("DELETE FROM `admin_cred` WHERE `sr_no`=?",[$frm_data['sr_no']],'i');
    if($res1)
    {
      echo 1;
    }
    else{
      echo 0;
    }
}
?>

