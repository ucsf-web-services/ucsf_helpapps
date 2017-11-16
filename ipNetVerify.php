<?php
$release_level = "1";
$slice = 0;
$octet3;
$octet4;
$ip = "test";
$networkLocation = "not UCSF";

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
//$ip = '169.230.243.74';
//$ip = '64.54.101.82';
//$ip = '10.7.186.158';
//$ip = '128.218.229.103';
//$ip = '169.230.243.74';
$subnet = substr($ip, 8);

if (substr($ip, 0, 3) === "10.") {
    $release_level = "3";
    $networkLocation = "UCSF Network- Private Space";
}

if (substr($ip, 0, 6) === "64.54.") {
    $release_level = "3";
    $subnet = substr($ip, 6);
    $slice = strrpos($subnet, ".");
    $octet3 = substr($subnet, 0, $slice);
    $slice = $slice + 1;
    $octet4 = substr($subnet, $slice);
    if ($octet3 >= 10 && $octet3 <= 14) {
        if ($octet3 == 10) {
            $networkLocation = "Medical Center Cisco VPN";
        } else if ($octet3 == 13) {
            $networkLocation = "Medical Center Web VPN";
        } else {
            $networkLocation = "UCSF Medical Center";
        }
    } else if ($octet3 >= 0 && $octet3 <= 127) {
        $networkLocation = "UCSF Medical Center Network";
    } else if ($octet3 >= 249 && $octet3 <= 251) {
        $networkLocation = "UCSF Campus Nortel VPN System";
    } else if ($octet3 >= 128 && $octet3 <= 255) {
        $networkLocation = "UCSF Campus Network";
    } else {
        $networkLocation = "UCSF Medical Center Network";
    }
}

if (substr($ip, 0, 8) === "128.218.") {
    $release_level = "3";
    $networkLocation = "UCSF Campus Network";
    $subnet = substr($ip, 8);
    $slice = strrpos($subnet, ".");
    $octet3 = substr($subnet, 0, $slice);
    $slice = $slice + 1;
    $octet4 = substr($subnet, $slice);
    if ($octet3 == 28) {
        if (($octet4 >= 192) && ($octet4 <= 223)) {
            $networkLocation = "UCSF ITS SSL VPN Test System";
        }
    } else if ($octet3 == 174) {
        if (($octet4 >= 37) && ($octet4 <= 61) || (($octet4 >= 69) && ($octet4 <= 93))) {
            $networkLocation = "UCSF Campus Nortel VPN System";
        }
    } else {
        $networkLocation = "UCSF Campus Network";
    }
}

if (substr($ip, 0, 8) === "169.230.") {
    $release_level = "3";
    $subnet = substr($ip, 8);
    $slice = strrpos($subnet, ".");
    $octet3 = substr($subnet, 0, $slice);
    $slice = $slice + 1;
    $octet4 = substr($subnet, $slice);
    if ($octet3 >= 100 && $octet3 <= 109) {
        $networkLocation = "UCSF Mission Bay Mixed Housing Network";
    } else if ($octet3 >= 110 && $octet3 <= 120) {
        $networkLocation = "UCSF Mission Bay Community Center Network";
    } else if ($octet3 >= 226 && $octet3 <= 227) {
        $networkLocation = "UCSF QB3 Authenitcated Wireless Network";
    } else if (($octet3 == 228) && ($octet4 <= 127)) {
        $networkLocation = "UCSF QB3 Open Wireless Wireless Network";
    } else if ($octet3 >= 240 && $octet3 <= 243) {
        $networkLocation = "UCSF Campus SSL VPN System";
    } else if ($octet3 >= 244 && $octet3 <= 247) {
        $networkLocation = "UCSF Campus DSL VPN System";
    } else {
        $networkLocation = "UCSF Mission Bay Campus Network";
    }
}

include 'include/header.php'
?>


<div class="row row--demo">
    <div class="columns three"> </div>
    <div class="columns six">

        <h2>ITS Network Verification</h2>
        <h3>Test VPN</h3>
        <p>The box below tests whether the Virtual Private Network appears to be working at the time you visited (loaded) this web page.</p>

        <?php if ($release_level === "3") { ?>

            <p style="border:2px solid #933;padding:8px;background-color:#c0edb2">

                <em>Yes</em>, you are on the UCSF computing network:
            <p>&nbsp;</p>
            You appear to be connecting from the IP address of: <strong><?php echo($ip); ?></strong>
            <p>&nbsp;</p>
            From this UCSF computing resources identify you as being connected from: <strong><?php echo($networkLocation); ?></strong>
            <p>&nbsp;</p>
            If you are having problems connecting to a site or network resource please contact your local CSC, 
            computer administrator or the ITS Help Desk and provide them the information found in this box.

            </p>

        <?php } else { ?>

            <div style="border:2px solid #933;padding:8px;background-color:#f0d3d3">

                <em>No</em>, you are not on the UCSF computing network.<p>&nbsp;</p>
                You look to be connecting from the IP address of:  

                <strong><?php echo($ip); ?></strong><p>&nbsp;</p>

                This shows either that you are not on the UCSF network, you are not using one of the UCSF <abbr title="Virtual Private Network">VPN</abbr> services or your <abbr title="Virtual Private Network">VPN</abbr> client is not working correctly. Web sites and computing resources that require you to be on the UCSF network will not currently allow you access.<p>&nbsp;</p>
                If you are currently attempting to use the UCSF VPN system and are having problems connecting to a site or network resource please contact your local CSC, computer administrator or the ITS Help Desk and provide them the information found in this box. 
            </div>
        <?php } ?>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </div>
    <?php
    include 'include/footer.php'
    ?>

