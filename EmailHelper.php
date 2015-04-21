<?php
require_once 'vendor/autoload.php';
if (!empty($_POST['EmailAddress'])) {

    $config = parse_ini_file("conf/config.ini");
    
//    Sanitizing inputs to prevent ldap injection
    $pattern = '/^[\w]+\.[\w]+@ucsf.edu$/'; //one or more words and numbers, a period in between, one or more words and numbers and ending with @ucsf.edu
    $EmailAddress = (empty($_POST['EmailAddress']) ? '' : $_POST['EmailAddress']);
    preg_match($pattern,$EmailAddress,$matches);
    if(empty($matches[0])) {
        $matches[0] = '';
    }
//    print_r($matches);
    $filter = '(mail=' . $matches[0] . ')';
//    print_r($filter);
//(mail=stephen.cheung@ucsf.edu)
//Connecting to LDAP or else die
    $ldapconn = ldap_connect($config['LDAP host'], $config['Port'])
            or die('did not connect');



//Binding to LDAP, dies if failed
    $ldapbind = ldap_bind($ldapconn, $config['Bind DN'], $config['Bind password'])
            or die('did not bind');

//
    $result = ldap_search($ldapconn, $config['Search base'], $filter)
            or die('did not search');

    $data = ldap_get_entries($ldapconn, $result);

    ldap_close($ldapconn);
}
//var_dump($data);
include 'include/header.php';
?>


<div class="row row--demo">
    <div class="columns three"> </div>
    <div class="columns six">

        <form action="" method="post" name="EmailHelperForm">
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <table class="table--bordered">
                <tr>
                    <th>Need to retrieve your help@UCSF User ID?</th>
                </tr>
            </table>



            <table class="table--bordered">


                <tr>
                    <td>
                        <p>&nbsp;</p>
                        <p>
                            Enter a valid <b>UCSF</b> email address below and we will email your UserID.
                        </p>
                        <?php
                        
                        if (!isset($_POST['EmailAddress'])) {
                            ?>
                            <p>&nbsp;</p>
                            E-mail Address
                            <input class="text-input" name="EmailAddress" type="text" size="30">
                            <?php
                        } else if (!empty($data[0]["ucsfeduidnumber"][0])) {

                            $mail = new PHPMailer();

                            $mailFrom = "DAISY@ucsf.edu";
                            $mailHost = "jingo.ucsf.edu";

                            $mail->IsSMTP();
                            $mail->Host = $mailHost;
                            $mail->From = $mailFrom;
                            $mail->AddAddress($EmailAddress);
                            $mail->Subject = "Forgot your User ID?";


                            $detail = "\n";
                            $detail .= "Your User ID is " . $data[0]["ucsfeduidnumber"][0] . ".\n\n";
                            $detail .= "If you did not use EmailHelper, well someone is trying to get your user id.";


                            $mail->Body = $detail;
                            if (!$mail->Send()) {
                                echo 'Message was not sent.';
                                echo 'Mailer error: ' . $mail->ErrorInfo;
                            }
                            ?>

                            <p>&nbsp;</p>

                            <strong>Message sent to <?php echo $EmailAddress . '.' ?></strong>
                            

                        <?php } else { ?>
                            <p>&nbsp;</p>
                            E-mail Address
                            <input class="text-input input-error" name="EmailAddress" type="text" size="30">
                            <label class="label-error">Please enter a valid UCSF email address.</label>
                            
                        <?php } ?>
                    </td>
                </tr>

                <tr>
                    <td colspan="4"><p>&nbsp;</p>
                        <button type="submit" class="btn btn--primary btn--fix">Submit</button>
                        <p>&nbsp;</p>
                        <p>&nbsp;</p>
                        <p>Still need help?&nbsp;Please call the ITS Service Desk at 514-4100, option 2.</p>
                    </td>
                </tr>

            </table>
        </form>

        <div><a href='https://ucsf.service-now.com/ess/home.do'>help@UCSF Login Page</a></div>
        
        
    </div>
</div>

<?php
include 'include/footer.php';
?>
