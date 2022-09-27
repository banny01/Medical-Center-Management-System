<?php
function userManage($level, $permissions){
    $sup = 0;
    foreach ($permissions as $permission){
        if($level == $permission){
            $sup = 1;
            break;
        }
    }
    if($sup == 0){
        header('Location: index.php');
    }    
}
?>