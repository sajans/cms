<?php

if (file_exists($path)) {
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);
    header("Content-Type: $mimi");
    header("Content-Disposition: attachment; filename=\"$name\";");
    header("Content-Transfer-Encoding: binary");

    readfile($path);
} else {
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: private", false);
    header("Content-Type: $mimi_cms");
    header("Content-Disposition: attachment; filename=\"$name_cms\";");
    header("Content-Transfer-Encoding: binary");

    readfile($path_cms);
    //echo 2 ;	
}
?>