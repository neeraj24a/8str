<?php
    if(isset($_POST['name']) &&isset($_POST['email']) && isset($_POST['comment'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $msg = $_POST['comment']."\r\n".$name;
        
        //$to      = 'neeraj24a@gmail.com';
        $to      = 'paul@8thwonderpromos.com';
        $subject = '8thwonderpromos | Contact';
        $headers = 'From: contact@8thwonderpromos.com' . "\r\n" .
            'Reply-To: '.$email . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        if(mail($to, $subject, $msg, $headers)){
            echo '<span class="text-success send-true">Your email was sent!</span>';
        } else {
            echo '<span class="text-danger">The input is not a valid email address!</span>';
        }
    }
?>