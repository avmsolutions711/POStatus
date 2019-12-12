<?php
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST')
{
    $requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);
	$number = $json->queryResult->parameters->number;
	$userStatus= $json->queryResult->parameters->userStatus;
	$userChoice= $json->queryResult->parameters->UserChoice;
	$action=$json->queryResult->action;
	$username = 'sguna002';
	$password = 'sguna002';
     switch ($userChoice) {
        
        case "yes":
		
        $URL="https://b2bprod01.7-eleven.com:9002/rest/Default/Chatbot/getPOStatus/_get?number=$number;
		     
	     $opts = array('http' =>
 array(
		     'header'    => ['Content-type: application/json' , 'Accept: application/json', 'Authorization: Basic '.base64_encode("$username:$password")], 'method'    => 'GET'));
$context = stream_context_create($opts);
$jsonStr = file_get_contents($URL, false, $context);
$obj = json_decode($jsonStr);
$Status_MSG = $obj->{'POStatus'};
		    	  break;
	case "no":
		     $Status_MSG="Thank you ! please reach us for more information to 7ElevenBPIAll@cognizant.com";
		     
		     break;
            
        default:
            $Status_MSG = "I couldn't answer ,Please reach out to 7ElevenBPIAll@cognizant.com , Thanks";
            break;
    }
	
    $response = new \stdClass();
    $response->fulfillmentText = $Status_MSG;
    $response->fulfillmentText = $Status_MSG;
    $response->source = "webhook";
    echo json_encode($response);
}
else
{
    $response = new \stdClass();
    $response->fulfillmentText = "This method not allowed here";
    $response->fulfillmentText = "This method not allowed here";
    $response->source = "webhook";
    echo json_encode($response);
}
?>
