<?php
require_once 'vendor/autoload.php';

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
    $mail->FromName = 'noreply@ucsf.edu';
    $mail->AddAddress($mailTo);
    $mail->Subject = $subject;
    $mail->Body = $detail;

    if (!$mail->Send()) {
        echo 'Message was not sent.';
        echo 'Mailer error: ' . $mail->ErrorInfo;
    }
}

include 'include/header.php'
?>



<?php if ($validate === FALSE) { ?>
    <div class="row row--demo">
        <h2>Campus HBS Update Form</h2>

        <noscript>
        <p>&nbsp;</p>
        <p><font color="red">
            Your browser does not support Help@UCSF Custom Applications <br>
            please upgrade your browser or enable JavaScript support <br>

            </font></p>
        <p>&nbsp;</p>
        </noscript>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#grace").click(function () {
                    $("#A").toggle();
                });
            });
            $(document).ready(function () {
                $("#adjustLeave").click(function () {
                    $("#B").toggle();
                });
            });
            $(document).ready(function () {
                $("#adjustMonths").click(function () {
                    $("#C").toggle();
                });
            });
            $(document).ready(function () {
                $("#grandfathered").click(function () {
                    $("#D").toggle();
                });
            });
            $(document).ready(function () {
                $("#overrideVaction").click(function () {
                    $("#E").toggle();
                });
            });
            $(document).ready(function () {
                $("#changeManagement").click(function () {
                    $("#F").toggle();
                });
            });
            $(document).ready(function () {
                $("#unRestricted_Time").click(function () {
                    $("#G").toggle();
                });
            });
            $(document).ready(function () {
                $("#autoPopulation_Time").click(function () {
                    $("#H").toggle();
                });
            });
        </script>

        <script type="text/JavaScript">
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
            <div class="row row--demo">
                <div class="columns twelve"><b>HBS HR ADMIN INFORMATION</b></div>
            </div>
            <div class="row row--demo">
                <div class="columns four">Name<input autofocus class="text-input" type="text" name="adminName"></div>

                <div class="columns four">Phone #<input class="text-input" type="text" name="adminPhone"></div>
                <div class="columns four">Email Address<input class="text-input" type="text" name="adminEmail"></div> 
            </div>  
            <p>This form is used by the HBS HR Admin to request the following types of HBS updates for the specified employee:</p>
            <div class="row row--demo">
                <div class="columns three">
                    <label class="label-checkbox">
                        <input name="grace" type="checkbox" id="grace" value="true"/>A. Provide a Grace Period for Vacation Maximum
                    </label>            
                </div>
                <div class="columns three">
                    <label class="label-checkbox">
                        <input name="adjustLeave" type="checkbox" id="adjustLeave" value="true">B. Adjust Leave Balances
                    </label>
                </div>
                <div class="columns three">
                    <label class="label-checkbox">
                        <input name="adjustMonths" type="checkbox" id="adjustMonths" value="true">C. Adjust Months of Service
                    </label>
                </div>
                <div class="columns three">
                    <label class="label-checkbox">
                        <input name="grandfathered" type="checkbox" id="grandfathered" value="true">D. End Grandfathered Status
                    </label>
                </div>
            </div>

            <div class="row row--demo">
                <div class="columns three">
                    <label class="label-checkbox">
                        <input name="overrideVaction" type="checkbox" id="overrideVaction" value="true"/>E. Override Vacation Eligibility
                    </label>
                </div>
                <div class="columns three">
                    <label class="label-checkbox">
                        <input name="changeManagement" type="checkbox" id="changeManagement" value="true"/>F. Change Management Group
                    </label>
                </div>
                <div class="columns three">
                    <label class="label-checkbox">
                        <input name="unRestricted_Time" type="checkbox" id="unRestricted_Time" value="true"/>G. Assign/Remove Non-Exempt Unrestricted Timesheet
                    </label>
                </div>
                <div class="columns three">
                    <label class="label-checkbox">
                        <input name="autoPopulation_Time" type="checkbox" id="autoPopulation_Time" value="true"/>H. Assign/Remove Auto-Population of Timesheet
                    </label>
                </div>
            </div>
            <p>Note: Items G and H only apply to Bi-Weekly employees.</p>
            <p>&nbsp;</p>
            <div class="row row--demo">
                <div class="columns twelve"><b>EMPLOYEE INFORMATION</b></div>
            </div>
            <div class="row row--demo">
                <div class="columns four">Name<input class="text-input" type="text" name="employeeName"></div>

                <div class="columns four">Employee ID #<input class="text-input" name="employeeID" type="text"></div>
                <div class="columns four">Management Group #<input class="text-input" name="employeeManagementGroup" type="text" size="30"></div> 
            </div>
            <div class="row row--demo">
                <div class="columns four">Is this individual a UCSF Employee?</div>
                <div class="columns eight">
                    <div class="columns four">
                        <label class="label-radio">
                            <input name="ucsfEmployee" type="radio" value="UCSF Employee">Yes
                        </label>
                    </div>
                    <div class="columns four">
                        <label class="label-radio">
                            <input name="ucsfEmployee" type="radio" value="Not a UCSF Employee">No
                        </label>
                    </div>
                </div>
            </div>
            <p>&nbsp;</p>

            <div class="row row--demo" id="A" style="display:none;">
                <div class="columns twelve"><b>A. Provide a Grace Period for Vacation Maximum</b></div>

                <div class="columns six">Bargaining Unit</div>
                <div class="columns six">
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

            <div id="B" style="display:none;">
                <div class="row row--demo">
                    <div class="columns twelve"><b>B. Adjust Leave Balances</b></div>
                    <div class="columns two">Leave Type</div>
                    <div class="columns two">Type of Adjustment</div>
                    <div class="columns two">Effective Date (MM/DD/YYYY)</div>
                    <div class="columns two"># of hours to Add/Remove</div>
                    <div class="columns three">Reason</div>
                    <div class="columns one">Add/Remove</div>
                </div>    
                <div class="row row--demo">
                    <div class="columns two">Vacation Leave</div>
                    <div class="columns two">
                        <select name="AdjustTypeVac" id="AdjustTypeVac">
                            <option value=""> -select- </option>
                            <option>Starting Balance</option>
                            <option>Current Balance</option>
                        </select>
                    </div>
                    <div class="columns two"><input class="text-input" name="AdjDateVac" type="text" id="AdjDateVac" size="12"></div>
                    <div class="columns two"><input class="text-input" name="AdjHoursVac" type="text" id="AdjHoursVac" size="10"></div>
                    <div class="columns three">
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
                    <div class="columns one">
                        <label class="label-radio">
                            <input name="AdjVac" type="radio" value="Add Leave">Add
                        </label>
                        <label class="label-radio">
                            <input name="AdjVac" type="radio" value="Remove Leave">Remove
                        </label>
                    </div>
                </div>
                <div class="row row--demo">
                    <div class="columns two">Sick Leave</div>
                    <div class="columns two">
                        <select name="AdjustTypeSick" id="AdjustTypeSick">
                            <option value=""> -select- </option>
                            <option>Starting Balance</option>
                            <option>Current Balance</option>
                        </select>
                    </div>
                    <div class="columns two"><input class="text-input" name="AdjDateSick" type="text" id="AdjDateSick" size="12"></div>
                    <div class="columns two"><input class="text-input" name="AdjHoursSick" type="text" id="AdjHoursSick" size="10"></div>
                    <div class="columns three">
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
                    <div class="columns one">
                        <label class="label-radio">
                            <input name="AdjSick" type="radio" value="Add Leave">Add
                        </label>
                        <label class="label-radio">
                            <input name="AdjSick" type="radio" value="Remove Leave">Remove
                        </label>
                    </div>
                </div>
                <div class="row row--demo">
                    <div class="columns two">Comp Time</div>
                    <div class="columns two">
                        <select name="AdjustCompTime" id="AdjustCompTime">
                            <option value=""> -select- </option>
                            <option>Starting Balance</option>
                            <option>Current Balance</option>
                        </select>
                    </div>
                    <div class="columns two"><input class="text-input" name="AdjDateCompTime" type="text" id="AdjDateCompTime" size="12"></div>
                    <div class="columns two"><input class="text-input" name="AdjHoursCompTime" type="text" id="AdjHoursCompTime" size="10"></div>
                    <div class="columns three">
                        <select name="AdjustReasonCompTime" id="AdjustReasonCompTime">
                            <option value=""> -select- </option>
                            <option>Inaccurate Starting Balance</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="columns one">
                        <label class="label-radio">
                            <input name="AdjCompTime" type="radio" value="Add Leave">Add
                        </label>
                        <label class="label-radio">
                            <input name="AdjCompTime" type="radio" value="Remove Leave">Remove
                        </label>
                    </div>
                </div>
                <p>Note: If selecting "Other" as the Reason, specify the reason in the comments section.</p>
                <p>&nbsp;</p>
            </div>

            <div id="C" style="display:none;">
                <div class="row row--demo">
                    <div class="columns twelve"><b>C. Adjust Months of Service</b></div>
                    <div class="columns three">Effective Date (MM/DD/YYYY)</div>
                    <div class="columns three"># of Months</div>
                    <div class="columns three">Reason(MM/DD/YYYY)</div>
                    <div class="columns three">Add/Remove</div>

                    <div class="columns three"><input class="text-input" name="monthsServiceEffectiveDate" type="text" id="monthsServiceEffectiveDate"></div>
                    <div class="columns three"><input class="text-input" name="adjustNumberMonths" type="text" id="adjustNumberMonths"></div>
                    <div class="columns three">
                        <select name="MOSAdjustReason" id="MOSAdjustReason">
                            <option value=""> -select- </option>
                            <option>Prior Service Credit</option>
                            <option>Intercampus Transfer</option>
                            <option>Inaccurate Starting MOS</option>
                            <option>Other</option>
                        </select>
                    </div>
                    <div class="columns three">
                        <label class="label-radio">
                            <input name="monthsService" type="radio" value="Add Months Service">Add
                        </label>
                        <label class="label-radio">
                            <input name="monthsService" type="radio" value="Remove Months Service">Remove
                        </label>
                    </div>
                </div>
                <p>Note: If selecting "Other" as the Reason, specify the reason in the comments section.</p>
                <p>&nbsp;</p>
            </div>

            <div id="D" style="display:none;">
                <div class="row row--demo">
                    <div class="columns twelve"><b>D. End Grandfathered Status</b></div>
                    <div class="columns four">End Date (MM/DD/YYYY)</div>
                    <div class="columns eight"><input class="text-input" name="dateEndGrandfathered" type="text" id="dateEndGrandfathered"></div>
                </div>
                <p>&nbsp;</p>
            </div>

            <div id="E" style="display:none;">
                <div class="row row--demo">
                    <div class="columns twelve"><b>E. Override Vacation Eligibility</b></div>
                    <div class="columns four">Date From (MM/DD/YYYY)</div>
                    <div class="columns four">Date To (MM/DD/YYYY)</div>
                    <div class="columns four">Eligibility Status (MM/DD/YYYY)</div>
                    <div class="columns four"><input class="text-input" name="vacationOverrRideStart" type="text" id="vacationOverrRideStart"></div>
                    <div class="columns four"><input class="text-input" name="vacationOverrRideEnd" type="text" id="vacationOverrRideEnd"></div>
                    <div class="columns four">
                        <select name="EligibilityStatus" id="EligibilityStatus">
                            <option value=""> -select- </option>
                            <option>Eligible</option>
                            <option>Ineligible</option>
                        </select>
                    </div>
                    <div class="columns twelve"><b>Reason</b></div>
                    <div class="columns twelve"><textarea name="vacationOverrideReason" cols="5" rows="5" id="comments"></textarea></div>
                </div>
                <p>Note: Dates must be month end dates.</p>
                <p>&nbsp;</p>
            </div>

            <div id="F" style="display:none;">
                <div class="row row--demo">
                    <div class="columns twelve"><b>F. Change Management Group</b></div>
                    <div class="columns four">New Management Group # </div>
                    <div class="columns eight"><input class="text-input" name="managementGroupNumber" type="text" id="managementGroupNumber"></div>
                </div>
                <p>&nbsp;</p>
            </div>

            <div id="G" style="display:none;">
                <div class="row row--demo">
                    <div class="columns twelve"><b>G. Assign/Remove Non-Exempt Unrestricted Timesheet</b></div>
                    <div class="columns four">Request</div>
                    <div class="columns eight">
                        <select name="unResTimeRequest" id="unResTimeRequest">
                            <option value=""> -select- </option>
                            <option>Eligible</option>
                            <option>Ineligible</option>
                        </select>
                    </div>
                </div>
                <p>&nbsp;</p>
            </div>

            <div id="H" style="display:none;">
                <div class="row row--demo">
                    <div class="columns twelve"><b>H. Assign/Remove Auto-Population of Timesheet</b></div>
                    <div class="columns four">Request</div>
                    <div class="columns eight">
                        <select name="autoPopTimeRequest" id="autoPopTimeRequest">
                            <option value=""> -select- </option>
                            <option>Eligible</option>
                            <option>Ineligible</option>
                        </select>
                    </div>
                </div>
                <p>&nbsp;</p>
            </div>

            <div class="row row--demo">
                <div class="columns twelve"><b>Comments</b></div>
                <div class="columns twelve"><textarea name="comments" cols="5" rows="5" id="comments"></textarea></div>
            </div>


            <p>CERTIFICATION: Submission of this form serves as your electronic signature. It certifies that the request aligns with policy and has been appropriately approved by the employee in accordance with departmental procedures.</p>


            <input name="validate" type="hidden" id="validate" value="true">
            <div align="center"><input class="btn btn--primary btn--fix" type="submit" name="Submit" value="Submit Form"> </div>

        </form>
    </div>

    <?php
} else {
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