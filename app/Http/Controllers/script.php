<?php
if (isset($GLOBALS["HTTP_RAW_POST_DATA"])) {
  $imageData=$GLOBALS['HTTP_RAW_POST_DATA'];
  $filteredData=substr($imageData, strpos($imageData, ",")+1);
  $unencodedData=base64_decode($filteredData);
  $fp = fopen('/path/to/file.png', 'wb' );
  fwrite( $fp, $unencodedData);
  fclose( $fp );
}
?>
