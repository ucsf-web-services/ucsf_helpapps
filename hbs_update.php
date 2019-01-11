<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';


$config = parse_ini_file("conf/config.ini");
$mailFrom = $config['Mail From'];
$mailTo = $config['Mail To'];

$mailHost = $config['Mail Host'];
$validate = FALSE;

$adminName = (empty($_POST['adminName']) ? NULL : $_POST['adminName']);
$adminPhone = (empty($_POST['adminPhone']) ? NULL : $_POST['adminPhone']);
$adminEmail = (empty($_POST['adminEmail']) ? NULL : $_POST['adminEmail']);
$grace = (empty($_POST['grace']) ? NULL : $_POST['grace']);
$grandfathered = (empty($_POST['grandfathered']) ? NULL : $_POST['grandfathered']);
$unRestricted_Time = (empty($_POST['unRestricted_Time']) ? NULL : $_POST['unRestricted_Time']);
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

$AdjustTypeCompTime = (empty($_POST['AdjustTypeCompTime']) ? NULL : $_POST['AdjustTypeCompTime']);
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

    if (!empty($AdjCompTime)) {
        $detail = $detail . "----------------------------\n\n";
        $detail = $detail . "Adjust Comp Time Balances \n";
        $detail = $detail . $AdjCompTime . "\n";
        $detail = $detail . $AdjustTypeCompTime . "\n";
        $detail = $detail . "Effective Date: " . $AdjDateCompTime . "\n";
        $detail = $detail . "Number of Hours: " . $AdjHoursCompTime . "\n";
        $detail = $detail . "Reason: " . $AdjustReasonCompTime . "\n";
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
        $detail = $detail . "End Date: " . $dateEndGrandfathered . "\n";
    }

    if (!empty($unRestricted_Time)) {
        // unRestricted_Time data
        $detail = $detail . "----------------------------\n\n";
        $detail = $detail . "Assign/Remove Non-Exempt Unrestricted Timesheet  \n";
        $detail = $detail . "Request: " . $unResTimeRequest . "\n";
        $subject = "HBS Update Timesheet for " . $employeeName . " submitted by " . $adminName;
    }

    if (!empty($autoPopulation_Time)) {
        // autoPopulation_Time data
        $detail = $detail . "----------------------------\n\n";
        $detail = $detail . "Assign/Remove Auto-Population of Timesheet  \n";
        $detail = $detail . "Request :" . $autoPopTimeRequest . "\n";
    }

    if (!empty($overrideVacation)) {
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
    $mail->FromName = 'noreply@ucsf.edu';
    $mail->AddAddress($mailTo);
    $mail->Subject = $subject;
    $mail->Body = $detail;

    if (!$mail->Send()) {
        echo 'Message was not sent.';
        echo 'Mailer error: ' . $mail->ErrorInfo;
    }
}
$bodyClass = '';
include 'include/header.php'
?>


<title>HBS Update</title>
<?php if ($validate === FALSE) { ?>
    <div class="row row--demo">
        <a href="index.php"><h4>UCSF Help Applications</h4></a>
        <h2>HBS Update Form</h2>

        <noscript>
        <p>&nbsp;</p>
        <p><font color="red">
            Your browser does not support Help@UCSF Custom Applications <br>
            please upgrade your browser or enable JavaScript support <br>

            </font></p>
        <p>&nbsp;</p>
        </noscript>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="js/parsley.min.js"></script>
        <script>
            $(document).ready(function () {
                $('input:checkbox').prop('checked', false);
            });
            $(document).ready(function () {
                $('input:checkbox').prop('checked', false);
            });
            $(document).ready(function () {
                $("#grace").click(function () {
                    $("#A").toggle();
                });
                $("#adjustLeave").click(function () {
                    $("#B").toggle();
                });
                $("#adjustMonths").click(function () {
                    $("#C").toggle();
                });
                $("#grandfathered").click(function () {
                    $("#D").toggle();
                });
                $("#overrideVacation").click(function () {
                    $("#E").toggle();
                });
                $("#changeManagement").click(function () {
                    $("#F").toggle();
                });
                $("#unRestricted_Time").click(function () {
                    $("#G").toggle();
                });
                $("#autoPopulation_Time").click(function () {
                    $("#H").toggle();
                });
            });
	    $(function () {
  		$('#form1').parsley().on('field:validated', function() {}).on('form:submit', function() { return true; });
	    });
        </script>

        <script type="text/JavaScript">
            function MM_findObj(n, d) { //v4.01
            var p,i,x;  if(!d) 
            d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
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
        </script>

        <form id="form1" action="" method="post" name="form1" onSubmit="MM_validateForm('adminName', '', 'R', 'adminPhone', '', 'R', 'adminEmail', '', 'RisEmail', 'employeeName', '', 'R', 'employeeID', '', 'R', 'employeeManagementGroup', '', 'R', 'ucsfEmployee', '', 'R');
                return document.MM_returnValue">
            <div class="row row--demo">
                <div class="columns twelve twelve--phone bold">HBS HR ADMIN INFORMATION</div>
            </div>
            <div class="row row--demo">
                <!--[if lt IE 10]><span id="three"><![endif]--><div class="columns four four--phone">Name<input autofocus class="text-input" type="text" id='adminName' name="adminName" /></div><!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="three"><![endif]--><div class="columns four four--phone">Phone #<input class="text-input" type="text" id='adminPhone' name="adminPhone" data-parsley-pattern="/[(]?\d{3}[-.)]?[ ]?\d{3}[-.]?\d{4}\b/g" data-parsley-pattern-message="The phone number must be in a North American phone number type. " /></div><!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="three"><![endif]--><div class="columns four four--phone">Email Address<input class="text-input" type="text" id='adminEmail' name="adminEmail" /></div><!--[if lt IE 10]></span><![endif]-->
            </div>  
            <p>This form is used by the HBS HR Admin to request the following types of HBS updates for the specified employee:</p>
            <div class="row row--demo">
                <!--[if lt IE 10]><span id="four"><![endif]-->
                <div class="columns three three--phone">
                    <label class="label-checkbox">
                        <input name="grace" type="checkbox" id="grace" value="true"/>A. Provide a Grace Period for Vacation Maximum
                    </label>            
                </div>
                <!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="four"><![endif]-->
                <div class="columns three three--phone">
                    <label class="label-checkbox">
                        <input name="adjustLeave" type="checkbox" id="adjustLeave" value="true">B. Adjust Leave Balances
                    </label>
                </div>
                <!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="four"><![endif]-->
                <div class="columns three three--phone">
                    <label class="label-checkbox">
                        <input name="adjustMonths" type="checkbox" id="adjustMonths" value="true">C. Adjust Months of Service
                    </label>
                </div>
                <!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="four"><![endif]-->
                <div class="columns three three--phone">
                    <label class="label-checkbox">
                        <input name="grandfathered" type="checkbox" id="grandfathered" value="true">D. End Grandfathered Status
                    </label>
                </div>
                <!--[if lt IE 10]></span><![endif]-->
            </div>

            <div class="row row--demo">
                <!--[if lt IE 10]><span id="four"><![endif]-->
                <div class="columns three three--phone">
                    <label class="label-checkbox">
                        <input name="overrideVacation" type="checkbox" id="overrideVacation" value="true"/>E. Override Vacation Eligibility
                    </label>
                </div>
                <!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="four"><![endif]-->
                <div class="columns three three--phone">
                    <label class="label-checkbox">
                        <input name="changeManagement" type="checkbox" id="changeManagement" value="true"/>F. Change Management Group
                    </label>
                </div>
                <!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="four"><![endif]-->
                <div class="columns three three--phone">
                    <label class="label-checkbox">
                        <input name="unRestricted_Time" type="checkbox" id="unRestricted_Time" value="true"/>G. Assign/Remove Non-Exempt Unrestricted Timesheet
                    </label>
                </div>
                <!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="four"><![endif]-->
                <div class="columns three three--phone">
                    <label class="label-checkbox">
                        <input name="autoPopulation_Time" type="checkbox" id="autoPopulation_Time" value="true"/>H. Assign/Remove Auto-Population of Timesheet
                    </label>
                </div>
                <!--[if lt IE 10]></span><![endif]-->
            </div>
           
            <!--[if lt IE 10]><span id="one"><![endif]-->
            <p>Note: Items G and H only apply to Bi-Weekly employees.</p>
            <!--[if lt IE 10]></span><![endif]-->
            <p>&nbsp;</p>
            <div class="row row--demo">
                <div class="columns twelve twelve--phone bold">EMPLOYEE INFORMATION</div>
            </div>
            <div class="row row--demo">
                <!--[if lt IE 10]><span id="three"><![endif]--><div class="columns four four--phone">Name<input class="text-input" type="text" id='employeeName' name="employeeName" /></div><!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="three"><![endif]--><div class="columns four four--phone">Employee ID #<input class="text-input" id='employeeID' name="employeeID" type="text" data-parsley-type="digits" data-parsley-length="[9,9]" data-parsley-length-message="The employee id must be 9 digits long" /></div><!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="three"><![endif]--><div class="columns four four--phone">Management Group #<input class="text-input" id='employeeManagementGroup' name="employeeManagementGroup" type="text" size="30" data-parsley-minlength="6" /></div> <!--[if lt IE 10]></span><![endif]-->
            </div>
            <div class="row row--demo">
                <!--[if lt IE 10]><span id="three"><![endif]--><div class="columns four four--phone">Is this individual a UCSF Employee?</div><!--[if lt IE 10]></span><![endif]-->
                <div class="columns eight eight--phone">
                    <!--[if lt IE 10]><span id="three"><![endif]-->
                    <div class="columns four four--phone">
                        <label class="label-radio">
                            <input name="ucsfEmployee" type="radio" value="UCSF Employee" checked="checked" />Yes
                        </label>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="three"><![endif]-->
                    <div class="columns four four--phone">
                        <label class="label-radio">
                            <input name="ucsfEmployee" type="radio" value="Not a UCSF Employee" />No
                        </label>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                </div>
            </div>
            <p>&nbsp;</p>

            <div class="row row--demo hide" id="A">
                <div class="columns twelve twelve--phone bold">A. Provide a Grace Period for Vacation Maximum</div>

                <div class="columns six six--phone">Bargaining Unit</div>
                <div class="columns six six--phone">
                    <select name="bargainingUnit" id="bargainingUnit">
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
                </div>
            </div>
            <p>&nbsp;</p>

            <div class="hide" id="B">
                <div class="row row--demo">
                    <!--[if lt IE 10]><span id="six"><![endif]--><div class="columns twelve twelve--phone bold">B. Adjust Leave Balances</div><!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]--><div class="columns two two--phone">Leave Type</div><!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]--><div class="columns one one--phone">Add/Remove</div><!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]--><div class="columns two two--phone">Type of Adjustment</div><!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]--><div class="columns two two--phone">Effective Date (MM/DD/YYYY)</div><!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]--><div class="columns two two--phone"># of hours to Add/Remove</div><!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]--><div class="columns three three--phone">Reason</div><!--[if lt IE 10]></span><![endif]-->
                </div>    
                <div class="row row--demo">
                    <!--[if lt IE 10]><span id="six"><![endif]--><div class="columns two two--phone">Vacation Leave</div><!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns one one--phone">
                        <label class="label-radio">
                            <input name="AdjVac" type="radio" value="Add Leave">Add
                        </label>
                        <label class="label-radio">
                            <input name="AdjVac" type="radio" value="Remove Leave">Remove
                        </label>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns two two--phone">
                        <select name="AdjustTypeVac" id="AdjustTypeVac">
                            <option value=""> -select- </option>
                            <option>Starting Balance</option>
                            <option>Current Balance</option>
                        </select>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns two two--phone"><input class="text-input" name="AdjDateVac" type="text" id="AdjDateVac" size="12"></div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns two two--phone"><input class="text-input" name="AdjHoursVac" type="text" id="AdjHoursVac" size="10"></div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns three three--phone">
                        <select name="AdjustReasonVac" id="AdjustReasonVac">
                            <option value=""> -select- </option>
                            <option>Inaccurate Starting Balance</option>
                            <option>Catastrophic Leave</option>
                            <option>Intercampus Transfer to UCSF</option>
                            <option>Intercampus Transfer from UCSF</option>
                            <option>Transfer with Med Center </option>
                            <option>WC/Disability</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                </div>
                <div class="row row--demo">
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns two two--phone">Sick Leave</div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns one one--phone">
                        <label class="label-radio">
                            <input name="AdjSick" type="radio" value="Add Leave">Add
                        </label>
                        <label class="label-radio">
                            <input name="AdjSick" type="radio" value="Remove Leave">Remove
                        </label>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns two two--phone">
                        <select name="AdjustTypeSick" id="AdjustTypeSick">
                            <option value=""> -select- </option>
                            <option>Starting Balance</option>
                            <option>Current Balance</option>
                        </select>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns two two--phone"><input class="text-input" name="AdjDateSick" type="text" id="AdjDateSick" size="12"></div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns two two--phone"><input class="text-input" name="AdjHoursSick" type="text" id="AdjHoursSick" size="10"></div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns three three--phone">
                        <select name="AdjustReasonSick" id="AdjustReasonSick">
                            <option value=""> -select- </option>
                            <option>Inaccurate Starting Balance</option>
                            <option>Rehire/Reinstatement</option>
                            <option>Intercampus Transfer to UCSF</option>
                            <option>Intercampus Transfer from UCSF</option>
                            <option>Transfer with Med Center</option>
                            <option>WC/Disability</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                </div>
                <div class="row row--demo">
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns two two--phone">Comp Time</div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns one one--phone">
                        <label class="label-radio">
                            <input name="AdjCompTime" type="radio" value="Add Leave">Add
                        </label>
                        <label class="label-radio">
                            <input name="AdjCompTime" type="radio" value="Remove Leave">Remove
                        </label>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns two two--phone">
                        <select name="AdjustTypeCompTime" id="AdjustTypeCompTime">
                            <option value=""> -select- </option>
                            <option>Starting Balance</option>
                            <option>Current Balance</option>
                        </select>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns two two--phone"><input class="text-input" name="AdjDateCompTime" type="text" id="AdjDateCompTime" size="12"></div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns two two--phone"><input class="text-input" name="AdjHoursCompTime" type="text" id="AdjHoursCompTime" size="10"></div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="six"><![endif]-->
                    <div class="columns three three--phone">
                        <select name="AdjustReasonCompTime" id="AdjustReasonCompTime">
                            <option value=""> -select- </option>
                            <option>Inaccurate Starting Balance</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                </div>
                
                <!--[if lt IE 10]><span id="one"><![endif]-->
                <p>Note: If selecting "Other" as the Reason, specify the reason in the comments section.</p>
                <!--[if lt IE 10]></span><![endif]-->
                <p>&nbsp;</p>
            </div>

            <div class="hide" id="C">
                <div class="row row--demo">
                    <div class="columns twelve twelve--phone bold">C. Adjust Months of Service</div>
                    <!--[if lt IE 10]><span id="four"><![endif]-->
                    <div class="columns three three--phone">Add/Remove</div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="four"><![endif]-->
                    <div class="columns three three--phone"># of Months</div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="four"><![endif]-->
                    <div class="columns three three--phone">Effective Date (MM/DD/YYYY)</div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="four"><![endif]-->
                    <div class="columns three three--phone">Reason</div>
                    <!--[if lt IE 10]></span><![endif]-->
                    
                    <!--[if lt IE 10]><span id="four"><![endif]-->
                    <div class="columns three three--phone">
                        <label class="label-radio">
                            <input name="monthsService" type="radio" value="Add Months Service">Add
                        </label>
                        <label class="label-radio">
                            <input name="monthsService" type="radio" value="Remove Months Service">Remove
                        </label>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="four"><![endif]-->
                    <div class="columns three three--phone"><input class="text-input" name="adjustNumberMonths" type="text" id="adjustNumberMonths"></div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="four"><![endif]-->
                    <div class="columns three three--phone"><input class="text-input" name="monthsServiceEffectiveDate" type="text" id="monthsServiceEffectiveDate"></div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="four"><![endif]-->
                    <div class="columns three three--phone">
                        <select name="MOSAdjustReason" id="MOSAdjustReason">
                            <option value=""> -select- </option>
                            <option>Prior Service Credit</option>
                            <option>Intercampus Transfer</option>
                            <option>Inaccurate Starting MOS</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                </div>
                <!--[if lt IE 10]><span id="one"><![endif]-->
                <p>Note: If selecting "Other" as the Reason, specify the reason in the comments section.</p>
                <!--[if lt IE 10]></span><![endif]-->
                <p>&nbsp;</p>
            </div>

            <div class="hide" id="D">
                <div class="row row--demo">
                    <div class="columns twelve twelve--phone bold">D. End Grandfathered Status</div>
                    <!--[if lt IE 10]><span id="one"><![endif]-->
                    <div class="columns four four--phone">End Date (MM/DD/YYYY)</div>
                    <div class="columns eight eight--phone"><input class="text-input" name="dateEndGrandfathered" type="text" id="dateEndGrandfathered"></div>
                    <!--[if lt IE 10]></span><![endif]-->
                </div>
                <p>&nbsp;</p>
            </div>

            <div class="hide" id="E">
                <div class="row row--demo">
                    <div class="columns twelve twelve--phone bold">E. Override Vacation Eligibility</div>
                    
                    <!--[if lt IE 10]><span id="three"><![endif]-->
                    <div class="columns four four--phone">Date From (MM/DD/YYYY)</div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="three"><![endif]-->
                    <div class="columns four four--phone">Date To (MM/DD/YYYY)</div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="three"><![endif]-->
                    <div class="columns four four--phone">Eligibility Status</div>
                    <!--[if lt IE 10]></span><![endif]-->
                    
                    <!--[if lt IE 10]><span id="three"><![endif]-->
                    <div class="columns four four--phone"><input class="text-input" name="vacationOverrRideStart" type="text" id="vacationOverrRideStart"></div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="three"><![endif]-->
                    <div class="columns four four--phone"><input class="text-input" name="vacationOverrRideEnd" type="text" id="vacationOverrRideEnd"></div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="three"><![endif]-->
                    <div class="columns four four--phone">
                        <select name="EligibilityStatus" id="EligibilityStatus">
                            <option value=""> -select- </option>
                            <option>Eligible</option>
                            <option>Ineligible</option>
                        </select>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                    
                    <!--[if lt IE 10]><span id="one"><![endif]-->
                    <div class="columns twelve twelve--phone bold">Reason</div>
                    <div class="columns twelve twelve--phone"><textarea name="vacationOverrideReason" cols="5" rows="5" id="comments"></textarea></div>
                    <!--[if lt IE 10]></span><![endif]-->
                </div>
                <!--[if lt IE 10]><span id="one"><![endif]--><p>Note: Dates must be month end dates.</p><!--[if lt IE 10]></span><![endif]-->
                <p>&nbsp;</p>
            </div>

            <div class="hide" id="F">
                <div class="row row--demo">
                    <div class="columns twelve twelve--phone bold">F. Change Management Group</div>
                    <!--[if lt IE 10]><span id="one"><![endif]-->
                    <div class="columns four four--phone">New Management Group # </div>
                    <div class="columns eight eight--phone"><input class="text-input" name="managementGroupNumber" type="text" id="managementGroupNumber"></div>
                    <!--[if lt IE 10]></span><![endif]-->
                </div>
                <p>&nbsp;</p>
            </div>

            <div class="hide" id="G">
                <div class="row row--demo">
                    <div class="columns twelve twelve--phone bold">G. Assign/Remove Non-Exempt Unrestricted Timesheet</div>
                    <!--[if lt IE 10]><span id="one"><![endif]-->
                    <div class="columns four four--phone">Request</div>
                    <div class="columns eight eight--phone">
                        <select name="unResTimeRequest" id="unResTimeRequest">
                            <option value=""> -select- </option>
                            <option>Assign</option>
                            <option>Remove</option>
                        </select>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                </div>
                <p>&nbsp;</p>
            </div>

            <div class="hide" id="H">
                <div class="row row--demo">
                    <div class="columns twelve twelve--phone bold">H. Assign/Remove Auto-Population of Timesheet</div>
                    <!--[if lt IE 10]><span id="one"><![endif]-->
                    <div class="columns four four--phone">Request</div>
                    <div class="columns eight four--phone">
                        <select name="autoPopTimeRequest" id="autoPopTimeRequest">
                            <option value=""> -select- </option>
                            <option>Eligible</option>
                            <option>Ineligible</option>
                        </select>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                </div>
                <p>&nbsp;</p>
            </div>

            <div class="row row--demo">
                <!--[if lt IE 10]><span id="one"><![endif]-->
                <div class="columns twelve twelve--phone bold">Comments</div>
                <div class="columns twelve twelve--phone"><textarea name="comments" cols="5" rows="5" id="comments"></textarea></div>
                <!--[if lt IE 10]></span><![endif]-->
            </div>

            <!--[if lt IE 10]><span id="one"><![endif]-->
            <p>CERTIFICATION: Submission of this form serves as your electronic signature. It certifies that the request aligns with policy and has been appropriately approved by the employee in accordance with departmental procedures.</p>
            <!--[if lt IE 10]></span><![endif]-->

            <input name="validate" type="hidden" id="validate" value="true">
            <!--[if lt IE 10]><span id="two"><![endif]-->
            <div class="columns ten ten--phone"><a href="hbs_update.php" class="btn btn--primary">Reset Form</a></div>
            <!--[if lt IE 10]></span><![endif]-->
            <!--[if lt IE 10]><span id="three"><![endif]-->
            <div></div>
            <!--[if lt IE 10]></span><![endif]-->
            <!--[if lt IE 10]><span id="six"><![endif]-->
            <div columns one one--phone><input class="btn btn--primary" type="submit" id='submitButton' name="Submit" value="Submit Form"> </div>
            <!--[if lt IE 10]></span><![endif]-->
        </form>
    </div>

    <?php
} else {
    echo "<a href='index.php'><h4>UCSF Help Applications</h4></a>";
    echo "<pre>";
    echo "<h2>Email Sent</h2>\n";
    echo "From: " . $mailFrom . "\n";
    echo "To: " . $mailTo . "\n";
    echo "Subject: " . $subject . "\n";
    echo "_______________________ \n";
    echo $detail;
    echo "</pre>";
}

include 'include/footer.php';
?>
