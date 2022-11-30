<?php
    // Check if a user's roles has a specific privilege
    function checkPrivilege($privilege, $roles){
        foreach($roles as $role){
            if($role[$privilege] === 1){
                return true;
            }
        }
    }