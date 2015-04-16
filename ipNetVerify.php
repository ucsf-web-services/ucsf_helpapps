<?php
$release_level = "1";
$slice = 0;
$octet3;
$octet4;
$ip = "test";
$networkLocation = "not UCSF";



if ($_SERVER['REMOTE_ADDR'] != null) {
    $ip = $_SERVER['REMOTE_ADDR'];
} else {
    $ip = "Unknown IP Address";
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
?>

<html>
    <head>
        <link type="text/css" rel="stylesheet" href="css/main.css">
        <style>
            .wrapper{
                background-color: #B3B9BF;
            }
            .white-container {
                background-color: #FFFFFF;
                display: block;
                max-width: 1230px;
                margin: 0 auto;
                padding-left:15px;
                font-family: 'HelveticaNeueLTStd',arial, sans-serif;
                padding-right:15px;
            }
            .footer{
                position: relative;
                width:100%;
                background-color: #000000;
                color:#ffffff;
                font-family: 'HelveticaNeueLTStd',arial, sans-serif;
                clear:both;
                max-width: 1230px;
                margin: 0 auto;
                padding-left:30px;
            }

            .top-header-container{
                max-width:1230px;
                margin: 0 auto;
                font-family:HelveticaNeueLTStd-Roman, arial, san-serif;
            }

            .nav-bar .brand-logo {
                box-shadow: none;
            }

            .nav-bar {
                border-bottom: 1px #fff solid;
            }

        </style>
    </head>
    <body  class="wrapper">
        <!-- start banner -->
        <div id="ucsf-banner-nav" class="no-logo">
            <div class="top-header-container row">
                <ul class="menu">
                    <li class="first"><a href="http://www.ucsf.edu">University of California San Francisco</a></li>
                    <li><a href="http://www.ucsfhealth.org/">UCSF Medical Center</a></li>
                    <li><a href="http://www.ucsf.edu/search" title="">Search UCSF</a></li>
                    <li><a href="http://www.ucsf.edu/about">About UCSF</a></li>
                </ul>
            </div>
        </div>
        <!-- end banner -->
        <!--Site Header (subbrand and navigation)-->
        <!-- Start Page Container -->
        <div class="white-container">
            <!-- Start Navigation -->
            <header class="nav-bar">
                <div class="brand-logo"><img src="imgs/UCSF_InfoTechnology_navy_RGB-2.png" height="58" width="227" border="0" hspace="14"></div>
            </header>
            <!--/Site Header (subbrand and navigation)-->
            <!-- Content -->
            <div class="row row--demo">
                <div class="columns three"> </div>
                <div class="columns six">

                    <h2>ITS Network Verification</h2>
                    <h3>Test VPN</h3>
                    <p>The box below tests whether the Virtual Private Network appears to be working at the time you visited (loaded) this web page.</p>

<?php if ($release_level === "3") { ?>

                        <p style="border:2px solid #933;padding:8px;background-color:#c0edb2">

                            <em>Yes</em>, you are on the UCSF computing network:<br><br>
                            You appear to be connecting from the IP address of: <strong><?php echo($ip); ?></strong><br><br>
                            From this UCSF computing resources identify you as being connected from: <strong><?php echo($networkLocation); ?></strong><br><br> 
                            If you are having problems connecting to a site or network resource please contact your local CSC, 
                            computer administrator or the ITS Help Desk and provide them the information found in this box.

                        </p>

<?php } else { ?>

                        <p style="border:2px solid #933;padding:8px;background-color:#f0d3d3">

                            <em>No</em>, you are not on the UCSF computing network.<br><br>
                            You look to be connecting from the IP address of:  

                            <strong><?php echo($ip); ?></strong><br><br>

                            This shows either that you are not on the UCSF network, you are not using one of the UCSF <abbr title="Virtual Private Network">VPN</abbr> services or your <abbr title="Virtual Private Network">VPN</abbr> client is not working correctly. Web sites and computing resources that require you to be on the UCSF network will not currently allow you access.<br><br>
                            If you are currently attempting to use the UCSF VPN system and are having problems connecting to a site or network resource please contact your local CSC, computer administrator or the ITS Help Desk and provide them the information found in this box. 

<?php } ?>
                    <p> 
                        <br>
                        <strong>Go To</strong>: <a href="http://vpn.ucsf.edu">Virtual Private Network (VPN)</a>
                    </p>
                    <br>

                    <h3>Verifying your Java Virtual Machine (JVM)<br></h3>
                    <a href="https://www.java.com/en/download/installed.jsp">Verify Java Version</a>
                    <p>&nbsp</p>
                    <p>&nbsp</p>
                    <p>&nbsp</p>

                </div>
            </div>

            <!-- /Content-->
            <!-- Start Footer -->
            <div class="footer">
                <footer>
                    &copy; 2015 University of California Regents, All Rights Reserved.
                </footer>
            </div>
            <!-- End Footer -->
        </div>
        <!-- end of container -->
    </body>
</html>
