<?php
require __DIR__ . '/vendor/autoload.php';

$release_level = "1";
$slice = 0;
$octet3;
$octet4;

$which = new WhichBrowser\Parser(getallheaders());

$networkLocation = "not UCSF";

if (!empty($_GET["ip"])) {
    $ip = $_GET["ip"];
} else if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else if (!empty($_SERVER['REMOTE_ADDR'])) {
    $ip = $_SERVER['REMOTE_ADDR'];
} else {
    $ip = 'Cannot Find Ip';
}
/*
$ip = '169.230.243.74';
$ip = '64.54.101.82';
$ip = '10.7.186.158';
$ip = '128.218.229.103';
$ip = '169.230.243.74';
*/
$subnet = substr($ip, 8);

if (substr($ip, 0, 3) === "10.") {
    $release_level = "3";
    $networkLocation = "UCSF Network - Private Space";
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
$bodyClass = ' ipnetverifypage';
include 'include/header.php';
//$release_level = "3";
?>

<title>Ip Verify</title>
<div class="row row--demo">
    <div class="columns three">
        <h4><a href="index.php">UCSF Help Applications</a></h4>
    </div>
    <div class="columns six">
      <div class="heading_info">
        <h2>Network Verification</h2>
        <p>This page tests whether you are on the UCSF network.</p>
        <p>If you are having problems connecting to a website or network resource please contact the <a href="http://help.ucsf.edu" target="_blank">IT Service Desk</a> at 415-514-4100 and provide them the information below.</p>
        <p>&nbsp;</p>
      </div>

        <?php if ($release_level === "3") { ?>
          <div class="status">
            <h3 class="okay"><strong> <em>Yes</em>, you are on the UCSF computing network.</strong></h3>
            <p>This UCSF network resource identified you as being connected <br />from: <strong><?php echo($networkLocation); ?></strong></p>
          </div>
        <?php } else { ?>
          <div class="status">
            <h3 class="error"><strong><em>No</em>, you are not on the UCSF computing network.</strong></h3>
            <p>This shows either that you are not on the UCSF network, you are not using one of the UCSF
              <abbr title="Virtual Private Network">VPN</abbr> services or your <abbr title="Virtual Private Network">VPN</abbr>
              client is not working correctly. Web sites and computing resources that require you to be on the UCSF network will not allow you access.</p>
          </div>
        <?php } ?>

        <table width="100%" cellpadding="0" cellspacing="0" border="0" class="ipnetverify">
          <thead>
            <th>Info</th><th>Status</th>
          </thead>
          <tr>
            <td>Connected to UCSF Network</td><td><strong><?php echo ($release_level=="3") ? '<span class="okay">Yes</span>' : '<span class="error">No</span>'; ?></strong></td>
          </tr>
          <tr>
            <td>IP Address</td><td><strong><?php echo($ip); ?></strong></td>
          </tr>
          <tr>
            <td>Network Location</td><td><strong><?php echo($networkLocation); ?></strong></td>
          </tr>
          <tr>
            <td>Operating System</td><td><strong><?php echo $which->os->toString(); ?></strong></td>
          </tr>
          <tr>
            <td>Browser</td><td><strong><?php echo $which->browser->getName(); ?></strong></td>
          </tr>
          <tr>
            <td>Browser Version</td><td><strong><?php echo $which->browser->getVersion(); ?></strong></td>
          </tr>
          <tr>
            <td>Javascript Enabled</td>
            <td>
              <strong>
                <span class="okay">
                  <script type="text/javascript">
                    document.write("Yes");
                  </script>
                </span>
              </strong>
              <noscript>
                <strong><span class="error">No</span></strong>
              </noscript>
            </td>
          </tr>
          <tr>
            <td>Browser Cookies Enabled</td>
            <td>
              <strong>
                <script type="text/javascript">
                  if (navigator.cookieEnabled) {
                    document.write('<span class="okay">Yes</span>');
                  }
                  else
                  {
                    document.write('<span class="error">No</span>');
                  }
                </script>
              </strong>
              <noscript>
                <span class="error">No</span>
              </noscript>
            </td>
          </tr>
          <tr>
            <td>Browser Plugins Installed</td><td><strong>
                <span id="plugins">

                </span>
                <script type="text/javascript">
                  console.log(window.navigator.javaEnabled());
                  console.dir(window.navigator.plugins);

                  var x=navigator.plugins.length; // store the total no of plugin stored
                  var txt="";
                  for(var i=0;i<x;i++)
                  {
                    txt+=navigator.plugins[i].name + "<br/>";
                  }
                  document.getElementById("plugins").innerHTML=txt;
                </script>
              </strong>
              <noscript>
              Plugin detection unavailable.
              </noscript>
              </td>
          </tr>
          <tr>
            <td>Device</td><td>
              <?php
              $result = $which->device->toArray();
              foreach ($result as $key => $value) {
                $key = ucfirst($key);
                echo "<strong>{$key}</strong>: {$value}<br />";
              }
              ?></td>
          </tr>
          <tr>
            <td>Screen Size</td><td>
              <strong>
            <script type="text/javascript">
              document.write(window.screen.width + 'px X ' + window.screen.height + 'px' );
            </script>
              </strong>
               <noscript>
              Screen size unavailable.
              </noscript>
            </td>
          </tr>

        </table>
    </div>
  <?php
  include 'include/footer.php'
  ?>