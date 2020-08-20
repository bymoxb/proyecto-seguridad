<?php require 'callAPI.php'; 

class Checkout{

    function __construct()
	{ 

    }
   function init(){
        $status=null;
        require_once('ViewForm.php');
    }

    function callAPI(){
            if(isset($_POST["kushkiToken"]) && isset($_POST["total"]) && isset($_POST["kushkiPaymentMethod"]) ){
      
                if($_POST["kushkiPaymentMethod"]=="card"){
                    $data_array =  array(
                        "token"        => htmlspecialchars($_POST["kushkiToken"]),
                        "amount"         => array(
                              "subtotalIva"         => 0,
                              "subtotalIva0"        => (float) htmlspecialchars($_POST["total"]),
                              "ice"        => 0,
                              "iva"        => 0,
                              "currency"         => "USD"
                                     ),
                        "metadata"         => array(
                                "contractID"         => "COVA"
                                    ),
                        "fullResponse"        => false,
                    );
                    $response = callAPI('POST', 'https://api-uat.kushkipagos.com/card/v1/charges', json_encode($data_array));
                    if($response['status']=="Success")
                    { 
                        
                        require_once('ViewDataCard.php');
                    }
                    else{ 
                        $status=$response['status'];
                        require_once('ViewForm.php');
                     }
                }
                if($_POST["kushkiPaymentMethod"]=="cash"){
                    $fecha = date("Y-m-d");
                       $nuevafecha = strtotime ('+3 month',strtotime($fecha));
                        $nuevafecha = date ("Y-m-d",$nuevafecha );

                    $data_array =  array(
                        "token"        => htmlspecialchars($_POST["kushkiToken"]),
                        "expirationDate"        => $nuevafecha." ".date("H:i:s"),
                        "amount"         => array(
                              "subtotalIva"         => 0,
                              "subtotalIva0"        => (float) htmlspecialchars($_POST["total"]),
                              "iva"        => 0,
                                     ),
                    );
                    $response = callAPI('POST', 'https://api-uat.kushkipagos.com/cash/v1/charges/init', json_encode($data_array));
                    if($response['status']=="Success")
                    { 
                        $url=$response['pdfUrl'];
                        require_once('ViewDataCash.php');
                    }
                    else{ 
                        $status=$response['status'];
                        require_once('ViewForm.php');
                     }
                }
                    
                }
                else{
                    header("location:pago.php"); 
                }

                
       

            
    }
}


?>