<?php
$actions = array(
		'init',
		'callAPI'
);

	if (in_array($action, $actions)) {

        call($action);
     
    }
    else{
        header("location:pago.php");  
    }

function call($action)
{

    require_once("CheckOut.php");
    
	$controller = new Checkout();
	$controller->{$action}();
}
