
<?php 
    require_once(__DIR__ . '/vendor/autoload.php');
    use PHPMailer\PHPMailer\PHPMailer;
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if($name != null && $email != null && $message != null){
        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $_ENV['MAIL_HOST'];  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $_ENV['MAIL_USERNAME'];                 // SMTP username
        $mail->Password = $_ENV['MAIL_PASSWORD'];                           // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $_ENV['MAIL_PORT'];                                    // TCP port to connect to
        
        $mail->setFrom('noreply@augustinewafula.com', 'augustinewafula.com');
        $mail->addAddress($_ENV['MAIL_FROM_ADDRESS'], 'Augustine');     // Add a recipient
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);                                  // Set email format to HTML
        
        $mail->Subject = 'Portfolio';
        $mail->Body    = 'Email: '.$email.' <br/>Name: '.$name.' <br/>Message: '.$message;

        
        
        if($mail->send()) {
            echo ("Message sent");
        } else {
            echo ("Oops!Something went wrong");
        }
    }
?>
