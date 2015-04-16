<?php
require_once 'vendor/autoload.php';
$mailFrom = "DAISY@ucsf.edu";
$mailTo = "Stephen.Cheung@ucsf.edu";
//$mailHost = "CUDA.UCSF.EDU";
$mailHost = "jingo.ucsf.edu";
$validate = FALSE;

$adminName = (empty($_POST['adminName']) ? NULL : $_POST['adminName']);
$adminPhone = (empty($_POST['adminPhone']) ? NULL : $_POST['adminPhone']);
$adminEmail = (empty($_POST['adminEmail']) ? NULL : $_POST['adminEmail']);
$grace = (empty($_POST['grace']) ? NULL : $_POST['grace']);
$grandfathered = (empty($_POST['grandfathered']) ? NULL : $_POST['grandfathered']);
$unRestrictedTime = (empty($_POST['unRestrictedTime']) ? NULL : $_POST['unRestrictedTime']);
$adjustLeave = (empty($_POST['adjustLeave']) ? NULL : $_POST['adjustLeave']);
$overrideVacation = (empty($_POST['overrideVacation']) ? NULL : $_POST['overrideVacation']);
$autoPopulation_Time = (empty($_POST['autoPopulation_Time']) ? NULL : $_POST['autoPopulation_Time']);
$adjustMonths = (empty($_POST['adjustMonths']) ? NULL : $_POST['adjustMonths']);
$changeManagement = (empty($_POST['changeManagement']) ? NULL : $_POST['changeManagement']);
$employeeName = (empty($_POST['employeeName']) ? NULL : $_POST['employeeName']);
$employeeID = (empty($_POST['employeeID']) ? NULL : $_POST['employeeID']);
$employeeManagementGroup = (empty($_POST['employeeManagementGroup']) ? NULL : $_POST['employeeManagementGroup']);
$ucsfEmployee = (empty($_POST['ucsfEmployee']) ? NULL : $_POST['ucsfEmployee']);
$bargainingUnit = (empty($_POST['bargainingUnit']) ? NULL : $_POST['bargainingUnit']);
$AdjustTypeVac = (empty($_POST['AdjustTypeVac']) ? NULL : $_POST['AdjustTypeVac']);

$AdjDateVac = (empty($_POST['AdjDateVac']) ? NULL : $_POST['AdjDateVac']);
$AdjHoursVac = (empty($_POST['AdjHoursVac']) ? NULL : $_POST['AdjHoursVac']);
$AdjustReasonVac = (empty($_POST['AdjustReasonVac']) ? NULL : $_POST['AdjustReasonVac']);
$AdjVac = (empty($_POST['AdjVac']) ? NULL : $_POST['AdjVac']);
$AdjustTypeSick = (empty($_POST['AdjustTypeSick']) ? NULL : $_POST['AdjustTypeSick']);
$AdjDateSick = (empty($_POST['AdjDateSick']) ? NULL : $_POST['AdjDateSick']);
$AdjHoursSick = (empty($_POST['AdjHoursSick']) ? NULL : $_POST['AdjHoursSick']);
$AdjustReasonSick = (empty($_POST['AdjustReasonSick']) ? NULL : $_POST['AdjustReasonSick']);
$AdjSick = (empty($_POST['AdjSick']) ? NULL : $_POST['AdjSick']);
$AdjustCompTime = (empty($_POST['AdjustCompTime']) ? NULL : $_POST['AdjustCompTime']);
$AdjDateCompTime = (empty($_POST['AdjDateCompTime']) ? NULL : $_POST['AdjDateCompTime']);
$AdjHoursCompTime = (empty($_POST['AdjHoursCompTime']) ? NULL : $_POST['AdjHoursCompTime']);
$AdjustReasonCompTime = (empty($_POST['AdjustReasonCompTime']) ? NULL : $_POST['AdjustReasonCompTime']);
$AdjCompTime = (empty($_POST['AdjCompTime']) ? NULL : $_POST['AdjCompTime']);
$monthsService = (empty($_POST['monthsService']) ? NULL : $_POST['monthsService']);
$monthsServiceEffectiveDate = (empty($_POST['monthsServiceEffectiveDate']) ? NULL : $_POST['monthsServiceEffectiveDate']);

$adjustNumberMonths = (empty($_POST['adjustNumberMonths']) ? NULL : $_POST['adjustNumberMonths']);
$MOSAdjustReason = (empty($_POST['MOSAdjustReason']) ? NULL : $_POST['MOSAdjustReason']);
$dateEndGrandfathered = (empty($_POST['dateEndGrandfathered']) ? NULL : $_POST['dateEndGrandfathered']);
$vacationOverrRideStart = (empty($_POST['vacationOverrRideStart']) ? NULL : $_POST['vacationOverrRideStart']);
$vacationOverrRideEnd = (empty($_POST['vacationOverrRideEnd']) ? NULL : $_POST['vacationOverrRideEnd']);

$EligibilityStatus = (empty($_POST['EligibilityStatus']) ? NULL : $_POST['EligibilityStatus']);
$vacationOverrideReason = (empty($_POST['vacationOverrideReason']) ? NULL : $_POST['vacationOverrideReason']);
$managementGroupNumber = (empty($_POST['managementGroupNumber']) ? NULL : $_POST['managementGroupNumber']);
$unResTimeRequest = (empty($_POST['unResTimeRequest']) ? NULL : $_POST['unResTimeRequest']);
$autoPopTimeRequest = (empty($_POST['autoPopTimeRequest']) ? NULL : $_POST['autoPopTimeRequest']);
$comments = (empty($_POST['comments']) ? NULL : $_POST['comments']);




$validate = (empty($_POST['validate']) ? FALSE : $_POST['validate']);


if ($validate !== FALSE) {
    $subject = "HBS Employee Update for " . $employeeName . " submitted by " . $adminName;
    $detail = "";
    $detail = "HBS HR Admin Information information\n";
    $detail = $detail . "Name: " . $adminName . "\n";
    $detail = $detail . "Phone: " . $adminPhone . "\n";
    $detail = $detail . "Email: " . $adminEmail . "\n";
    //$detail = $detail . "Department Code: " . $depCode. "\n\n";
    $detail = $detail . "----------------------------\n\n";
    $detail = $detail . "Employee information\n";
    $detail = $detail . "Name: " . $employeeName . "\n";
    $detail = $detail . "ID: " . $employeeID . "\n";
    $detail = $detail . "Management Group: " . $employeeManagementGroup . "\n";
    $detail = $detail . $ucsfEmployee . "\n\n";

    // meat of the form follows... null checks for each section...
    if (!empty($grace)) {
        // grace data
        $detail = $detail . "----------------------------\n\n";
        $detail = $detail . "Provide a Grace Period for Vacation Maximum \n";
        $detail = $detail . "Bargaining Unit :" . $bargainingUnit . "\n";
    }

    if (!empty($AdjVac)) {
        // Adjust Leave data
        $detail = $detail . "----------------------------\n\n";
        $detail = $detail . "Adjust Vacation Leave Balances \n";
        $detail = $detail . $AdjVac . "\n";
        $detail = $detail . $AdjustTypeVac . "\n";
        $detail = $detail . "Effective Date: " . $AdjDateVac . "\n";
        $detail = $detail . "Number of Hours: " . $AdjHoursVac . "\n";
        $detail = $detail . "Reason: " . $AdjustReasonVac . "\n";
    }

    if (!empty($AdjSick)) {
        $detail = $detail . "----------------------------\n\n";
        $detail = $detail . "Adjust Sick Leave Balances \n";
        $detail = $detail . $AdjSick . "\n";
        $detail = $detail . $AdjustTypeSick . "\n";
        $detail = $detail . "Effective Date: " . $AdjDateSick . "\n";
        $detail = $detail . "Number of Hours: " . $AdjHoursSick . "\n";
        $detail = $detail . "Reason: " . $AdjustReasonSick . "\n";
    }

    if (!empty($adjustMonths)) {
        // Adjust Months data
        $detail = $detail . "----------------------------\n\n";
        $detail = $detail . "Adjust Months of Service\n";
        $detail = $detail . $monthsService . "\n";
        $detail = $detail . "Effective Date: " . $monthsServiceEffectiveDate . "\n";
        $detail = $detail . "Number of Months: " . $adjustNumberMonths . "\n";
        $detail = $detail . "Reason: " . $MOSAdjustReason . "\n";
    }

    if (!empty($grandfathered)) {
        // grandfathered data
        $detail = $detail . "----------------------------\n\n";
        $detail = $detail . "End Grandfathered Status  \n";
        $detail = $detail . "End Date :" . $dateEndGrandfathered . "\n";
    }

    if (!empty($unRestricted_Time)) {
        // unRestricted_Time data
        $detail = $detail . "----------------------------\n\n";
        $detail = $detail . "Assign/Remove Non-Exempt Unrestricted Timesheet  \n";
        $detail = $detail . "Request :" . $unResTimeRequest . "\n";
    }

    if (!empty($autoPopulation_Time)) {
        // autoPopulation_Time data
        $detail = $detail . "----------------------------\n\n";
        $detail = $detail . "Assign/Remove Auto-Population of Timesheet  \n";
        $detail = $detail . "Request :" . $autoPopTimeRequest . "\n";
    }

    if (!empty($overrideVaction)) {
        // Over Ride Vacation data
        $detail = $detail . "----------------------------\n\n";
        $detail = $detail . "Override Vacation Eligibility \n";
        $detail = $detail . "Date From: " . $vacationOverrRideStart . "\n";
        $detail = $detail . "Date To: " . $vacationOverrRideEnd . "\n";
        $detail = $detail . "Eligibility Status: " . $EligibilityStatus . "\n";
    }

    if (!empty($changeManagement)) {
        // Change Management data
        $detail = $detail . "----------------------------\n\n";
        $detail = $detail . "Change Management Group  \n";
        $detail = $detail . "Change Group to: " . $managementGroupNumber . "\n";
    }
    
    $detail = $detail . "\n\nComments:\n";
    $detail = $detail . $comments . "\n";
 
    $mail = new PHPMailer();

    $mail->IsSMTP();
    $mail->Host = $mailHost;

    $mail->From = $mailFrom;
    $mail->AddAddress($mailTo);
    $mail->Subject = $subject;
    $mail->Body = $detail;

    if (!$mail->Send()) {
        echo 'Message was not sent.';
        echo 'Mailer error: ' . $mail->ErrorInfo;
    }
}
?>


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>help@UCSF: Campus HBS Update Form</title>
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
        <?php if($validate === FALSE) { ?>
        <div class="row row--demo">
            <h2>Campus HBS Update Form</h2>

            <!-- ***************************************************************** -->
            <noscript class="statusbar">
            <br />
            <p><font color="red">
                Your browser does not support Help@UCSF Custom Applications <br />
                please upgrade your browser or enable JavaScript support
                </font></p>
            </noscript>
            <!-- ***************************************************************** -->



            <script type="text/JavaScript">
                <!--
                function MM_findObj(n, d) { //v4.01
                var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
                d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
                if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
                for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
                if(!x && d.getElementById) x=d.getElementById(n); return x;
                }

                function MM_validateForm() { //v4.0
                var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
                for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=MM_findObj(args[i]);
                if (val) { nm=val.name; if ((val=val.value)!="") {
                if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
                if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
                } else if (test!='R') { num = parseFloat(val);
                if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
                if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
                min=test.substring(8,p); max=test.substring(p+1);
                if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
                } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
                } if (errors) alert('The following error(s) occurred:\n'+errors);
                document.MM_returnValue = (errors == '');
                }
                //-->
            </script>

            <script  type="text/JavaScript">

                function testForObject(Id, Tag)
                {
                var o = document.getElementById(Id);
                if (o){
                if (Tag){
                if (o.tagName.toLowerCase() == Tag.toLowerCase()){
                return o;
                }
                } else {
                return o;
                }
                }
                return null;
                }

                //  ****************************  //
                function traverseDom (root)
                {
                var s = '';

                var c = root, n = null;
                var it = 0;
                do {
                n = c.firstChild;
                if (n == null){
                // visit c
                if (c.nodeType == 3)
                s += c.nodeValue.replace(/\s/, "");
                // done visit c

                n = c.nextSibling;
                }

                if (n == null){
                var tmp = c;
                do {
                n = tmp.parentNode;
                if (n == root)
                break;

                // visit n
                if (n.nodeType == 3)
                s += n.nodeValue.replace(/\s/, "");
                // done visit n

                tmp = n;
                n = n.nextSibling;
                }while (n == null)
                }
                c = n;
                }
                while (c != root);
                return s;
                }
            </script>






            <form action="" method="post" name="form1" onSubmit="MM_validateForm('adminName', '', 'R', 'adminPhone', '', 'R', 'adminEmail', '', 'RisEmail', 'employeeName', '', 'R', 'employeeID', '', 'R', 'employeeManagementGroup', '', 'R');
                    return document.MM_returnValue">
                <table class="table--bordered">
                    <tr>
                        <th colspan="3"><div align="left">HBS HR ADMIN INFORMATION</div></th>
                    </tr>
                    <tr>
                        <td>Name<br>
                            <input type="text" name="adminName"></td>
                        <td>Phone #<br>
                            <input type="text" name="adminPhone"></td>
                        <td>Email Address<br>
                            <input type="text" name="adminEmail">
                        </td>
                    </tr>
                </table>
                <br>

                <p>This form is used by the HBS HR Admin to request the following types of HBS updates for the specified employee:</p>

                <table class="table--bordered">
                    <tr>
                        <td><input name="grace" type="checkbox" id="grace" value="true"></td>
                        <td>A.&nbsp;Provide a Grace Period for Vacation Maximum/td>
                        <td><input name="grandfathered" type="checkbox" id="grandfathered" value="true"></td>
                        <td>D.&nbsp;End Grandfathered Status</td>
                        <td><input name="unRestricted_Time" type="checkbox" id="unRestricted_Time" value="true"></td>
                        <td>G.&nbsp;Assign/Remove Non-Exempt Unrestricted Timesheet</td>
                    </tr>
                    <tr>
                        <td><input name="adjustLeave" type="checkbox" id="adjustLeave" value="true"></td>
                        <td>B.&nbsp;Adjust Leave Balances</td>
                        <td><input name="overrideVaction" type="checkbox" id="overrideVaction" value="true"></td>
                        <td>E.&nbsp;Override Vacation Eligibility</td>
                        <td><input name="autoPopulation_Time" type="checkbox" id="autoPopulation_Time" value="true"></td>
                        <td>H.&nbsp;Assign/Remove Auto-Population of Timesheet</td>
                    </tr>
                    <tr>
                        <td><input name="adjustMonths" type="checkbox" id="adjustMonths" value="true"></td>
                        <td>C.&nbsp;Adjust Months of Service</td>
                        <td><input name="changeManagement" type="checkbox" id="changeManagement" value="true"></td>
                        <!-- Ticket # CRQ 4374 Begins -->
                        <td>F.&nbsp;Change Management Group</td>
                        <!-- Ticket # CRQ 4374 Begins -->
                        <!--   <td><input name="requestNewSchedule" type="checkbox" id="requestNewSchedule" value="true"></td> -->
                        <!--   <td><strong>I.&nbsp;Request a New Schedule</strong></td> -->
                        <!-- Ticket # CRQ 4374 Ends -->
                    </tr>
                </table>
                <!-- Ticket # CRQ 4374 Begins -->
                <!-- <p><em>Note: </em>Items G, H, and I only apply to Bi-Weekly employees.</p> -->
                <p><em>Note: </em>Items G and H only apply to Bi-Weekly employees.</p>
                <!-- Ticket # CRQ 4374 Ends -->
                <br>

                <table class="table--bordered">
                    <tr>
                        <th colspan="3"><div align="left">EMPLOYEE INFORMATION</div></th>
                    </tr>
                    <tr>
                        <td>Name<br>
                            <input type="text" name="employeeName"></td>
                        <td>Employee ID #<br>
                            <input name="employeeID" type="text"></td>
                        <td>Management Group #<br>
                            <input name="employeeManagementGroup" type="text" size="30">
                        </td>
                    </tr>
                    <tr>
                        <td>Is this individual a UCSF Employee?
                            <br>
                        </td>
                        <td colspan="2">
                            <input name="ucsfEmployee" type="radio" value="UCSF Employee">
                            Yes &nbsp;
                            <input name="ucsfEmployee" type="radio" value="Not a UCSF Employee">
                            No    </td>
                    </tr>
                </table>

                <p>&nbsp;</p>
                <table class="table--bordered">
                    <tr>
                        <th colspan="2"><div align="left">A. Provide a Grace Period for Vacation Maximum</div> </th>
                    </tr>
                    <tr>
                        <td>Bargaining Unit</td>


                        <td><select name="bargainingUnit" id="bargainingUnit">
                                <option value=""> -select- </option>
                                <option>99 (4 Months)</option>
                                <option>CX (4 Months)</option>
                                <option>HX (3 Months) </option>
                                <option>LX (3 Months) </option>
                                <option>NX (3 Months) </option>
                                <option>PA (4 Months) </option>
                                <option>RX (4 Months) </option>
                                <option>SX (4 Months) </option>
                                <option>TX (4 Months) </option>
                            </select>
                        </td>
                    </tr>
                </table>
                <p>&nbsp;</p>

                <table class="table--bordered">
                    <tr>
                        <th colspan="6"><div align="left">B. Adjust Leave Balances</div></th>
                    </tr>
                    <tr valign="top">
                        <td>Leave Type </td>
                        <td>Type of Adjustment</td>
                        <td>Effective Date<br>
                            (MM/DD/YYYY)</td>
                        <td># of Hours<br>(# of hours to Add/Remove)</td>
                        <td valign="top" nowrap="nowrap">Reason</td>
                        <td valign="middle" nowrap="nowrap"><p>&nbsp;
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>Vacation Leave </td>
                        <td><select name="AdjustTypeVac" id="AdjustTypeVac">
                                <option value=""> -select- </option>
                                <option>Starting Balance</option>
                                <option>Current Balance</option>
                            </select></td>
                        <td><input name="AdjDateVac" type="text" id="AdjDateVac" size="12"></td>
                        <td><input name="AdjHoursVac" type="text" id="AdjHoursVac" size="10"></td>
                        <td><select name="AdjustReasonVac" id="AdjustReasonVac">
                                <option value=""> -select- </option>
                                <!-- Ticket # CRQ 4374 Begins 
                                Coommented out the existing drop down
                                <option>Rehire/Reinstatement</option>
                                <option>WC/Disability</option>
                                <option>Intercampus Transfer</option>
                                <option>Curtailment</option>
                                <option>Inaccurate Starting Balance</option>
                                <option>Other</option> 
                                Added new drop down -->
                                <option>Inaccurate Starting Balance</option>
                                <option>Catastrophic Leave</option>
                                <option>Intercampus Transfer to UCSF</option>
                                <option>Intercampus Transfer from UCSF</option>
                                <option>Transfer with Med Center </option>
                                <option>WC/Disability</option>
                                <option>Other</option>
                                <!-- Ticket # CRQ 4374 Begins -->

                            </select></td>
                        <td valign="middle" nowrap="nowrap"><input name="AdjVac" type="radio" value="Add Leave">
                            Add<br>
                            <input name="AdjVac" type="radio" value="Remove Leave">
                            Remove</td>
                    </tr>
                    <tr>
                        <td>Sick Leave </td>
                        <td><select name="AdjustTypeSick" id="AdjustTypeSick">
                                <option value=""> -select- </option>
                                <option>Starting Balance</option>
                                <option>Current Balance</option>
                            </select></td>
                        <td><input name="AdjDateSick" type="text" id="AdjDateSick" size="12"></td>
                        <td><input name="AdjHoursSick" type="text" id="AdjHoursSick" size="10"></td>
                        <td valign="middle" nowrap="nowrap"><select name="AdjustReasonSick" id="AdjustReasonSick">
                                <option value=""> -select- </option>
                                <!-- Ticket # CRQ 4374 Begins 
                                Coommented out the existing drop down
                                <option>Rehire/Reinstatement</option>
                                <option>WC/Disability</option>
                                <option>Intercampus Transfer</option>
                                <option>Curtailment</option>
                                <option>Inaccurate Starting Balance</option>
                                <option>Other</option> -->
                                <option>Inaccurate Starting Balance</option>
                                <option>Rehire/Reinstatement</option>
                                <option>Intercampus Transfer to UCSF</option>
                                <option>Intercampus Transfer from UCSF</option>
                                <option>Transfer with Med Center</option>
                                <option>WC/Disability</option>
                                <option>Other</option>
                                <!-- Ticket # CRQ 4374 Ends -->

                            </select></td>
                        <td valign="middle" nowrap="nowrap"><input name="AdjSick" type="radio" value="Add Leave">
                            Add<br>
                            <input name="AdjSick" type="radio" value="Remove Leave">
                            Remove</td>
                    </tr>
                    <tr>
                        <td>Comp Time </td>
                        <td><select name="AdjustCompTime" id="AdjustCompTime">
                                <option value=""> -select- </option>
                                <option>Starting Balance</option>
                                <option>Current Balance</option>
                            </select></td>
                        <td><input name="AdjDateCompTime" type="text" id="AdjDateCompTime" size="12"></td>
                        <td><input name="AdjHoursCompTime" type="text" id="AdjHoursCompTime" size="10"></td>
                        <td valign="middle" nowrap="nowrap"><select name="AdjustReasonCompTime" id="AdjustReasonCompTime">
                                <option value=""> -select- </option>
                                <!-- Ticket # CRQ 4374 Begins 
                                Coommented out Intercampus Transfer from drop down 
                                <option>Intercampus Transfer</option> 
                                Ticket # CRQ 4374 Ends -->
                                <option>Inaccurate Starting Balance</option>
                                <option>Other</option>
                            </select>
                        </td>
                        <td valign="middle" nowrap="nowrap"><input name="AdjCompTime" type="radio" value="Add Leave">
                            Add<br>
                            <input name="AdjCompTime" type="radio" value="Remove Leave">
                            Remove
                        </td>
                    </tr>
                </table>
                <p><em>Note: </em>If selecting "Other" as the Reason, specify the reason in the comments section.</p><br>

                <table class="table--bordered">
                    <tr>
                        <th colspan="4"><div align="left">C. Adjust Months of Service</div></th>
                    </tr>
                    <tr valign="top">
                        <td>Effective Date<br>
                            (MM/DD/YYYY)</td>
                        <td># of Months </td>

                        <td>Reason</td>
                        <td rowspan="2"><br>
                            <input name="monthsService" type="radio" value="Add Months Service">
                            Add<br>
                            <input name="monthsService" type="radio" value="Remove Months Service">
                            Remove</td>
                    </tr>
                    <tr>
                        <td><input name="monthsServiceEffectiveDate" type="text" id="monthsServiceEffectiveDate"></td>
                        <td><input name="adjustNumberMonths" type="text" id="adjustNumberMonths"></td>
                        <td><select name="MOSAdjustReason" id="MOSAdjustReason">
                                <option value=""> -select- </option>
                                <option>Prior Service Credit</option>
                                <option>Intercampus Transfer</option>
                                <option>Inaccurate Starting MOS</option>
                                <option>Other</option>
                            </select></td>
                    </tr>
                </table>
                <p><em>Note: </em>If selecting "Other" as the Reason, specify the reason in the comments section.</p>

                <table class="table--bordered">
                    <tr>
                        <th colspan="2"><div align="left">D. End Grandfathered Status</div></th>
                    </tr>
                    <tr>
                        <td>End Date<br>
                            (MM/DD/YYYY)</td>

                        <td><input name="dateEndGrandfathered" type="text" id="dateEndGrandfathered"></td>
                    </tr>
                </table>

                <p>&nbsp;</p>
                <table class="table--bordered">
                    <tr>
                        <th colspan="3"><div align="left">E. Override Vacation Eligibility</div></th>
                    </tr>
                    <tr>
                        <td>Date From<br>
                            (MM/DD/YYYY)</td>
                        <td>Date To<br>
                            (MM/DD/YYYY)</td>
                        <td>Eligibility Status<br>
                        </td>
                    </tr>
                    <tr valign="top">
                        <td><input name="vacationOverrRideStart" type="text" id="vacationOverrRideStart"></td>
                        <td><input name="vacationOverrRideEnd" type="text" id="vacationOverrRideEnd"></td>
                        <td><select name="EligibilityStatus" id="EligibilityStatus">
                                <option value=""> -select- </option>
                                <option>Eligible</option>
                                <option>Ineligible</option>
                            </select></td>
                    </tr>
                    <tr valign="top">
                        <td colspan="3"><strong><div align="left">Reason:</div>
                                <textarea name="vacationOverrideReason" cols="80" rows="2" id="comments"></textarea>
                            </strong></td>
                    </tr>
                </table>

                <p><em>Note: </em>Dates must be month end dates.</p><br>

                <table class="table--bordered">
                    <tr>
                        <th colspan="2"><div align="left"> F. Change Management Group</div></th>
                    </tr>
                    <tr>
                        <td>New Management Group # </td>

                        <td><input name="managementGroupNumber" type="text" id="managementGroupNumber"></td>
                    </tr>
                </table><br>

                <!-- ################ -->
                <table class="table--bordered">
                    <tr>
                        <th colspan="2"><div align="left">G. Assign/Remove Non-Exempt Unrestricted Timesheet</div> </th>
                    </tr>
                    <tr>
                        <td>Request</td>

                        <td>
                            <select name="unResTimeRequest" id="unResTimeRequest">
                                <option value=""> -select- </option>
                                <option>Assign Non-Exempt Unrestricted Timesheet</option>
                                <option>Remove Non-Exempt Unrestricted Timesheet</option>
                            </select>
                        </td>
                    </tr>
                </table><br>
                <!-- ################ -->
                <table class="table--bordered">
                    <tr>
                        <th colspan="2"><div align="left">H. Assign/Remove Auto-Population of Timesheet</div></th>
                    </tr>
                    <tr>
                        <td>Request</td>

                        <td>
                            <select name="autoPopTimeRequest" id="autoPopTimeRequest">
                                <option value=""> -select- </option>
                                <option>Assign Auto-Population of Timesheet</option>
                                <option>Remove Auto-Population of Timesheet</option>
                            </select>
                        </td>
                    </tr>
                </table>

                <br>

                <table class="table--bordered">
                    <tr>
                        <td>Comments</td>
                    </tr>
                    <tr>
                        <td><textarea name="comments" cols="80" rows="2" id="comments"></textarea></td>
                    </tr>
                </table>
                <p>CERTIFICATION: Submission of this form serves as your electronic signature. It certifies that the request aligns with policy and has been appropriately approved by the employee in accordance with departmental procedures.</p>

                
                <input name="validate" type="hidden" id="validate" value="true">
                <div align="center"><input class="btn btn--primary btn--fix" type="submit" name="Submit" value="Submit Form"> </div>
                
            </form>
        </div>
        
        <?php } else { 
                echo "<pre>";
                echo "<h2>Email Sent</h2>\n";
                echo "From: " . $mailFrom . "\n";
                echo "To: " . $mailTo . "\n";
                echo "Subject: " . $subject . "\n";
                echo "_______________________ \n";
                echo $detail;
                echo "</pre>";
               
            }
            ?>
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
