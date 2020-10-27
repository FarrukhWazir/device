<?php
error_reporting(0);
function status_icon($status='0')
{
	
	if($status == 1 OR $status == 'true') 
	{
		?><i style='color:green' class='fa fa-check'></i><?php
	}
	else
	{
		?><i style='color:red' class='fa fa-times'></i><?php
	}
}
function strigToBinary($string)
{
    $characters = str_split($string);
 
    $binary = [];
    foreach ($characters as $character) {
        $data = unpack('H*', $character);
        $binary[] = base_convert($data[1], 16, 2);
    }
 
    return implode(' ', $binary);    
}