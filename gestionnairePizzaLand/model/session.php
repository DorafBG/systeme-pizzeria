<?php 
class session{

    public static function adherentConnected(){
        if(isset($_SESSION["login"])){
            return true;
        } else {
            return false;
        }
    }

    public static function adminConnected(){
        if(isset($_SESSION["login"])){
            if($_SESSION["login"] == 'admin'){
                return true;
            }
        }
        return false;
    }

    public static function adherentConnecting(){
        if(isset($_GET["action"])){
            if($_GET["action"] == 'connect'){
                return true;
            }
        }
        return false;
    }

}



?>