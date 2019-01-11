<?php
require_once 'vendor/autoload.php';
include 'include/analyticstracking.php';

$privileged_networks = array();
$privileged_networks[] = "10."; //RFC 1918
$privileged_networks[] = "64.54."; //UCSF
$privileged_networks[] = "128.218."; //UCSF
$privileged_networks[] = "169.230."; //VPN
$privileged_networks[] = "192.168."; //RFC 1918
//$privileged_networks[] = "127.0.0.1"; //Localhost
$allowed = FALSE;

foreach ($privileged_networks as $network) {
    if (strpos($_SERVER['REMOTE_ADDR'], "$network") === 0) {
        $allowed = TRUE;
        break;
    }
}
if (!$allowed) {
    header('HTTP/1.0 403 Forbidden');
    die('Access denied (HTTP 403). Please login to VPN.' . " <a href='ipNetVerify.php'>Verify VPN Access Here</a>");    
}



if (!empty($_POST['EmailAddress'])) {

    $config = parse_ini_file("conf/config.ini");

    $pattern = $config['Pattern'];
    $EmailAddress = (empty($_POST['EmailAddress']) ? '' : $_POST['EmailAddress']);
    preg_match($pattern, $EmailAddress, $matches);
    if (empty($matches[0])) {
        $matches[0] = '';
    }

    $filter = 'mail=' . escapeString($matches[0]);

    $ldapconn = ldap_connect($config['LDAP host'], $config['Port'])
            or die('did not connect');

    ldap_set_option($cnx, LDAP_OPT_PROTOCOL_VERSION, 3);
    
    $ldapbind = ldap_bind($ldapconn, $config['Bind DN'], $config['Bind password'])
            or die('did not bind');

    $result = ldap_search($ldapconn, $config['Search base'], $filter)
            or die('did not search');

    $data = ldap_get_entries($ldapconn, $result);
    ldap_close($ldapconn);
}

function escapeString($string) {
    # Backslash must be listed first, since otherwise it would replace the
    # backslashes used in other replacements
    $chars = array(
     "\x00" => '\00',
     '\\' => '\5c',
     '(' => '\28',
     ')' => '\29',
     '*' => '\2A');
    return str_replace(array_keys($chars), array_values($chars), $string);
}

include 'include/header.php';
?>
<title>Email Helper</title>
<div class="row row--demo">
    <div class="columns three"> <a href="index.php"><h4>UCSF Help Applications</h4></a></div>
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
                            Enter a valid <b>UCSF</b> email address that ends with <b>'@ucsf.edu'</b> below and we will email your UserID.
                        </p>
                        <?php
                        if (!isset($_POST['EmailAddress'])) {
                            ?>
                            <p>&nbsp;</p>
                            E-mail Address

                            <input class="text-input" tabindex="1" name="EmailAddress" autofocus type="text" size="30">
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
                    <?php
                } else if (!empty($data[0]["ucsfeduidnumber"][0])) {

                    $mail = new PHPMailer();

                    $mailFrom = $config['IT Mail From'];
                    $mailHost = $config['Mail Host Test'];

                    $mail->IsSMTP();
                    $mail->Host = $mailHost;
                    $mail->From = $mailFrom;
                    $mail->FromName = 'IT Service Desk';
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
                    
                    <p>&nbsp;</p>
                    
                    <div><a href='https://ucsf.service-now.com/ess/home.do'>Login to Help@ucsf.edu here</a></div>
                    <tr>
                        
                        <td colspan="4">
                            <p>&nbsp;</p>
                            <p>Still need help?&nbsp;Please call the ITS Service Desk at 514-4100, option 2.</p>
                            <p>&nbsp;</p>
                        </td>
                        
                    </tr>
                <?php } else { ?>
                    <p>&nbsp;</p>
                    E-mail Address
                    <input class="text-input input-error" name="EmailAddress" autofocus type="text" size="30">
                    <label class="label-error">Please enter a valid UCSF email address.</label>

                    <tr>
                        <td colspan="4"><p>&nbsp;</p>
                            <button type="submit" class="btn btn--primary btn--fix">Submit</button>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p>Still need help?&nbsp;Please call the ITS Service Desk at 514-4100, option 2.</p>
                        </td>
                    </tr>
                <?php } ?>

            </table>
        </form>

        

    </div>


    <?php
    include 'include/footer.php';
    ?>
