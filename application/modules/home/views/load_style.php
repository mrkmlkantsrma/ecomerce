<!-------Style links--------->
<?php
    if( isset($css) ){
        foreach( $css as $fileID => $filePath) echo "<link rel='stylesheet' id='$fileID' href='$filePath'>";
    }
    ?>
