<!-------Style links--------->
<?php
    if( isset($css) ){
        foreach( $css as $fileID => $filePath) echo "<link rel='stylesheet' id='$fileID' href='$filePath'>";
    }
    ?>
<style>
.swal2-popup.swal2-toast.swal2-show {
  background-color: rgba(706,55,46,49) !important;
  border: 3px solid white;
  position: relative !important;
  top: 20px !important;
  -webkit-animation: swal2-show .5s !important;
  animation: swal2-show .5s !important;
}
</style>