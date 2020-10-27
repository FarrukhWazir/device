<?php 
ini_set('memory_limit', '1024M');
$auth = base64_encode("dani@skais.com.my:c8Y4ska!");
$context = stream_context_create([
    "http" => [
        "header" => "Authorization: Basic $auth"
    ]
]);
$data = file_get_contents("https://ska.cumulocity.com/inventory/binaries/704", false, $context );

//$data = file_get_contents($firmware_url);
$file = "firmware".time()."bin";
$myfile = fopen($file, "w") or die("Unable to open file!");
fwrite($myfile, $data);

fclose($myfile);
?>