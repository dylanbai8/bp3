<?php

    // 重置系统
    require_once("../functions.php");
    
    force_login();
    
    $reset = force_post_param("reset");
    
    if($reset == 1){
            
        if (!unlink("../config.php")){
          echo '{"errno":-1,"msg":"fail"}';
        }
        else{
          echo '{"errno":0,"msg":"success"}';
        }
    }
