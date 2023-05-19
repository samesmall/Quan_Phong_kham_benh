<?php

require('../inc/db_config.php');
require('../inc/essentials.php');

adminLogin();
    
if(isset($_POST['add_testresults']))
{

  $frm_data = filteration($_POST);
  $flag = 0;
  
  $q1 = "INSERT INTO `testresults`( `type_of_result`, `result_description`,`patients_id`) VALUES (?,?,?)";
  $values = [$frm_data['type_of_result'], $frm_data['result_description'], $frm_data['patients_id']];

  if(insert($q1,$values,'ssi')){
    $flag = 1;
  }

  if($flag){
    echo 1;
  }else{
    echo 0;
  }
}

if(isset($_POST['get_all_testresults']))
{
 
  $res = selectAll('testresults');
  $i= 1;
  $data = "";
  while($row = mysqli_fetch_assoc($res))
  {
    $data.="
    <tr class='align-middle'>
        <td style='padding-left: 20px'>$i</td>
        <td style='padding-left: 20px'><span class='badge bg-warning'>$row[result_id]</span></td>
        <td> <span class='badge bg-success'>$row[patients_id]</span></td>
        <td>$row[type_of_result]</td>
        <td>$row[result_description]</td>
 
        
        <td>
          <button type='button' onclick='edit_testresults($row[result_id])' class='btn btn-primary shadow-none btn-sm' data-bs-toggle='modal' data-bs-target='#edit-testresults'>
            <i class='bi bi-pencil-square'></i>
          </button>
          <button type='button' onclick='remove_testresults($row[result_id])' class='btn btn-danger shadow-none btn-sm'>
          <i class='bi bi-trash'></i>
          </button>
        </td>
    </tr>
    ";
    $i++;
  }
  echo $data;
}

if(isset($_POST['get_testresults']))
{
  $frm_data = filteration($_POST);
  $res1 = select("SELECT * FROM `testresults` WHERE  `result_id`=?",[$frm_data['get_testresults']],'i');

  $testresultsdata = mysqli_fetch_assoc($res1);
 


  $data = ["testresultdata" => $testresultdata];

  $data = json_encode($data);
  echo $data;

}

if(isset($_POST['edit_testresults']))
{

  $frm_data = filteration($_POST);
  $flag = 0;

  $q1 = "UPDATE `testresults` SET `type_of_result`=?,`result_description`=? WHERE `result_id`=?";
  $values = [$frm_data['type_of_result'], $frm_data['result_description'],$frm_data['result_id']];
   
  if(update($q1,$values,'ssi')){
    $flag = 1;
  }

  if($flag){
    echo 1;
  }else{
    echo 0;
  }
}





if(isset($_POST['remove_testresults']))
{
    $frm_data = filteration($_POST);

    
    $res1 = delete("DELETE FROM `testresults` WHERE `result_id`=?",[$frm_data['result_id']],'i');
    if($res1)
    {
      echo 1;
    }
    else{
      echo 0;
    }
}
?>

