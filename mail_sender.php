<?php 
    require_once(__DIR__ . '/vendor/autoload.php');
    use PHPMailer\PHPMailer\PHPMailer;
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $secretkey = '6LcyFKgZAAAAAG2LFnmWS-ixZCCDei6EboPVizbW';

    $url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secretkey."&response=".$_POST['g-recaptcha-response'];
    $response = file_get_contents($url);
    $response = json_decode($response);
     

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);


    if($response->success){
        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $_ENV['MAIL_HOST'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $_ENV['MAIL_USERNAME'];                 // SMTP username
        $mail->Password = $_ENV['MAIL_PASSWORD'];                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $_ENV['MAIL_PORT'];                                    // TCP port to connect to
        
        $mail->setFrom($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
        $mail->addReplyTo($_ENV['MAIL_FROM_ADDRESS'], $_ENV['MAIL_FROM_NAME']);
        $mail->addAddress($_ENV['MAIL_TO_ADDRESS']);     // Add a recipient

        $mail->isHTML(true);                                  // Set email format to HTML
        
        $mail->Subject = 'Contact Message - AugustineWafula';
        $mail->Body    = 'Email: '.$email.' <br/>Name: '.$name.' <br/>Message: '.$message;

        
        
        if($mail->send()) {
            echo ("Message sent");
        } else {
            echo ("Oops!Something went wrong");
        }
    }else{
        echo ("Verification Failed");
    }

?>
