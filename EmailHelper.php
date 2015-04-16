<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Connecting and binding to LDAP information

$info = parse_ini_file("conf/config.ini");
//print_r($info);
$host = $info['LDAP host'];
$user = $info['Bind DN'];
$password = $info['Bind password'];
$port = $info['Port'];

//Where and what you are searching information
$searchDN = $info['Search base'];
$searchingFor = array($info['Attribute']);
$EmailAddress = (empty($_POST['EmailAddress']) ? NULL : $_POST['EmailAddress']);
//$EmailAddress = $_POST['EmailAddress'];
$filter = '(mail=' . $EmailAddress . ')';
//(mail=stephen.cheung@ucsf.edu)

//Connecting to LDAP or else die
$ldapconn = ldap_connect($host, $port)
        or die('did not connect');



//Binding to LDAP, dies if failed
$ldapbind = ldap_bind($ldapconn, $user, $password)
        or die('did not bind');

//
$result = ldap_search($ldapconn, $searchDN, $filter)
        or die('did not search');

$data = ldap_get_entries($ldapconn, $result);

ldap_close($ldapconn);


//var_dump($data);
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


                    <table class="table--bordered">
                        <tr>
                            <th>What is my help@UCSF User ID and password?</th>
                        </tr>
                    </table>

                    <form
                        action=""
                        method="post" name="EmailHelperForm"
                        onsubmit="return Mailer_Form_Validator(this);"
                        >

                        <table class="table--bordered">

                            <!-- ********************************************************* -->
                            <tr>
                                <th>Faculty &amp; Staff</th>
                                <td>
                                    <div>
                                        <p>Please enter your 9 digit UC Employee ID number (format 02nnnnnnn) for the UserID, and last four digits of your social security number for the password.</p>
                                    </div>

                                </td>
                            </tr>

                            <tr>
                                <th>Students</th>
                                <td>
                                    <div>
                                        <p>Please enter your SAA UserID for the user name and your birth date (8 digit format: yyyymmdd) for the password.
                                            If you have forgotten your SAA UserID you must visit the Office of Admission and Registration (MU200 West) for assistance.
                                        <p>     
                                            <br>
                                            <a href="https://directory.ucsf.edu/departments/search/id/1800">Office of Admission and Registration</a> contact information

                                    </div>
                                </td>
                            </tr>

                            
                        </table>



                        <br>
                        <br>
                        <table class="table--bordered">
                            <tr>
                                <th>Need to retrieve your help@UCSF User ID?</th>
                            </tr>
                        </table>



                        <table class="table--bordered">


                            <tr>
                                <td>
                                    <br>
                                    <p>
                                        Enter a valid <i style="font-size: 11pt;color:red">UCSF</i> email address below and your UserID will be shown below.
                                    </p>
                                    <?php
                                    if (empty($EmailAddress)) {
                                        ?>
                                        <br>
                                        E-mail Address
                                        <input name="EmailAddress" type="text" size="30" value="">

                                        <br>
                                        <br>
                                    <?php } else { ?>
                                        <br>
                                        <strong><?php echo "The UserID for " . $EmailAddress . " is " . $data[0]["ucsfeduidnumber"][0] . "." ?></strong>

                                        <br>
                                        <br>
                                        
                                        <?php } ?>
                                        
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="4"><br>
                                        <button type="submit" class="btn btn--primary btn--fix"">Submit</button>
                                        <br><br>
                                        <p>Still need help?&nbsp;Please call the ITS Service Desk at 514-4100, option 2.</p>
                                    </td>
                                </tr>

                            </table>
                        </form>
                        <br />
                        <strong>Click <a style="color:red" href='https://ucsf.service-now.com/ess/home.do'>here</a> for help@UCSF Login Page.</strong>

                    </div>
                    <div class="columns three">&nbsp;</div>
                </div>
            
            </table>

        

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
