<?php
/**
 * EDIT THE VALUES BELOW THIS LINE TO ADJUST THE CONFIGURATION
 * EACH OPTION HAS A COMMENT ABOVE IT WITH A DESCRIPTION
 */
/**
 * Specify the email address to which all mail messages are sent.
 * The script will try to use PHP's mail() function,
 * so if it is not properly configured it will fail silently (no error).
 */
$mailTo     = '{{ email }}';

/**
 * Set the message that will be shown on success
 */
$successMsg = 'Thank you, mail sent successfully!';

/**
 * Set the message that will be shown if not all fields are filled
 */
$fillMsg    = 'Please fill all fields!';

/**
 * Set the message that will be shown on error
 */
$errorMsg   = 'Hm... seems there is a problem, sorry!';

/**
 * Initial file taken from my portfolio website https://caleblent.com on January 1, 2023
 * 
 * Jan 1, 2023 - edited file contents to work with the Eau Galle Lakeside Retreat website.
 * Tested functionality briefly and seems to work correctly.
 * 
 * March 11, 2023 - added "rental-interests" section to reservation form, so modified the
 * code here to add that info to the email it sends out.
 * Also changed the formatting of the email - some of the words are BOLD now
 */

?>
<?php
if(
    !isset($_POST['name']) ||
    !isset($_POST['email']) ||  
    !isset($_POST['phone']) ||  
	!isset($_POST['message']) ||
    empty($_POST['name']) ||
    empty($_POST['email']) ||
    empty($_POST['phone']) ||
    empty($_POST['message'])
) {
	echo "two\n";
	if( empty($_POST['name']) && empty($_POST['email']) ) {
		$json_arr = array( "type" => "error", "msg" => $fillMsg );
		echo json_encode( $json_arr );		
	} else {

		$fields = "";
		if( !isset( $_POST['name'] ) || empty( $_POST['name'] ) ) {
			$fields .= "Name";
		}
		
		if( !isset( $_POST['email'] ) || empty( $_POST['email'] ) ) {
			if( $fields == "" ) {
				$fields .= "Email";
			} else {
				$fields .= ", Email";
			}
		}

		if( !isset( $_POST['phone'] ) || empty( $_POST['phone'] ) ) {
			if( $fields == "" ) {
				$fields .= "Phone";
			} else {
				$fields .= ", Phone";
			}
		}
		
		if( !isset( $_POST['message'] ) || empty( $_POST['message'] ) ) {
			if( $fields == "" ) {
				$fields .= "Message";
			} else {
				$fields .= ", Message";
			}
		}
		
		$json_arr = array( "type" => "error", "msg" => "Please fill in the following fields: ".$fields);
		echo json_encode( $json_arr );		
	
	}
} else {

	// Validate e-mail
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
		
		$msg = "<h3>Name: ".$_POST['name']."</h3>\r\n\n";
        $msg .= "<h5>Email: ".$_POST['email']."</h5>\r\n\n";
        $msg .= "<h5>Phone: ".$_POST['phone']."</h5>\r\n\n";
        $msg .= "<h5>Message: </h5><p>".$_POST['message']."</p>";

        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        
        // Create email headers
        $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();
		
		$success = @mail($mailTo, 'Contact from: ' . $_POST['name'], $msg, $headers);
		
		if ($success) {
			// $json_arr = array( "type" => "success", "msg" => $successMsg );
			// echo json_encode( $json_arr );
            echo '<script>alert("Message successfully sent! We will be in touch with you shortly.")</script>;';
		} else {
			$json_arr = array( "type" => "error", "msg" => $errorMsg );
			echo json_encode( $json_arr );
		}
		
	} else {
 		$json_arr = array( "type" => "error", "msg" => "Please enter valid email address!" );
		echo json_encode( $json_arr );	
	}
}

?>

<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Redirecting to {{ title }}...</title>
  </head>
  <body>
    <script>
      window.location.href =
        "{{ URL }}"
    </script>
  </body>
</html>
