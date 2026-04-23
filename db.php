<?php
$conn = mysqli_connect(
    "shortline.proxy.rlwy.net",  // HOST
    "root",                      // USER
    "HWhvCcoQPRkjWAPmlBGfFneILSGCTJSh", // PASSWORD
    "railway",                  // DATABASE
    17085                       // PORT (IMPORTANT)
);

if(!$conn){
    die("Connection failed: " . mysqli_connect_error());
}
?>
