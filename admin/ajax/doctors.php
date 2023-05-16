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

 



}

if(isset($_POST['get_all_doctors']))
{
  $res = select("SELECT * FROM `doctors`",[0],'i');
  $i= 1;
  $data = "";
  while($row = mysqli_fetch_assoc($res))
  {
    $data.="
    <tr class='align-middle'>
        <td style='padding-left: 20px'>$i</td>
        <td>$row[Doctor_name]</td>
        <td>$row[Specialized]</td>
        <td>
        
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

if(isset($_POST['get_room']))
{
  $frm_data = filteration($_POST);
  $res1 = select("SELECT * FROM `rooms` WHERE  `id`=?",[$frm_data['get_room']],'i');
  $res2 = select("SELECT * FROM `room_features` WHERE  `room_id`=?",[$frm_data['get_room']],'i');
  $res3 = select("SELECT * FROM `room_facilities` WHERE  `room_id`=?",[$frm_data['get_room']],'i');

  $roomdata = mysqli_fetch_assoc($res1);
  $features = [];
  $facilities = [];

  if(mysqli_num_rows($res2)>0)
  {
     while($row = mysqli_fetch_assoc($res2)){
         array_push($features,$row['features_id']);
     }
  }

  if(mysqli_num_rows($res3)>0)
  {
     while($row = mysqli_fetch_assoc($res3)){
         array_push($facilities,$row['facilities_id']);
     }
  }

  $data = ["roomdata" => $roomdata, "features"=> $features, "facilities"=> $facilities];

  $data = json_encode($data);
  echo $data;

}

if(isset($_POST['edit_room']))
{
  $features = filteration(json_decode($_POST['features']));
  $facilities = filteration(json_decode($_POST['facilities']));

  $frm_data = filteration($_POST);
  $flag = 0;

  $q1 = "UPDATE `rooms` SET `name`=?,`area`=?,`price`=?,`quantity`=?,`adult`=?,`children`=?,`description`=? WHERE `id`=?";
  $values = [$frm_data['name'], $frm_data['area'],  $frm_data['price'], $frm_data['quantity'], $frm_data['adult'], $frm_data['children'], $frm_data['desc'], $frm_data['room_id']];
   
  if(update($q1,$values,'siiiiisi')){
    $flag = 1;
  }

  $del_features = delete("DELETE FROM `room_features` WHERE `room_id`=?",[$frm_data['room_id']],'i' );
  $del_facilities = delete("DELETE FROM `room_facilities` WHERE `room_id`=?",[$frm_data['room_id']],'i' );

  if(!($del_facilities && $del_features)){
     $flag = 0;     
  }

  $q2 = "INSERT INTO `room_facilities`( `room_id`, `facilities_id`) VALUES (?,?)";

  if($stmt = mysqli_prepare($con,$q2))
  {
    foreach($facilities as $f){
      mysqli_stmt_bind_param($stmt,'ii',$frm_data['room_id'],$f);
      mysqli_stmt_execute($stmt);
    }
    $flag = 1;
    mysqli_stmt_close($stmt);
  }else{
     $flag = 0;
     die('query cannot be prepared - insert');
  }

  if($flag){
    echo 1;
  }else{
    echo 0;
  }

  $q3 = "INSERT INTO `room_features`( `room_id`, `features_id`) VALUES (?,?)";

  if($stmt = mysqli_prepare($con,$q3))
  {
    foreach($features as $f){
      mysqli_stmt_bind_param($stmt,'ii',$frm_data['room_id'],$f);
      mysqli_stmt_execute($stmt);
    }
    $flag = 1;
    mysqli_stmt_close($stmt);
  }else{
     $flag = 0;
     die('query cannot be prepared - insert');
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

    
    $res1 = delete("DELETE FROM `doctors` WHERE `id`=?",[$frm_data['room_id']],'i');
    if($res1)
    {
      echo 1;
    }
    else{
      echo 0;
    }
}
?>

