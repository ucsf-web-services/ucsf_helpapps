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

$depCode = (empty($_POST['depCode']) ? NULL : $_POST['depCode']);

$employeeName = (empty($_POST['employeeName']) ? NULL : $_POST['employeeName']);

$employeeID = (empty($_POST['employeeID']) ? NULL : $_POST['employeeID']);

$employeeManagementGroup = (empty($_POST['employeeManagementGroup']) ? NULL : $_POST['employeeManagementGroup']);

$ucsfEmployee = (empty($_POST['ucsfEmployee']) ? NULL : $_POST['ucsfEmployee']);

$approverRole = (empty($_POST['approverRole']) ? NULL : $_POST['approverRole']);

$adminRole = (empty($_POST['adminRole']) ? NULL : $_POST['adminRole']);

$ManagementGroupAccess = (empty($_POST['ManagementGroupAccess']) ? NULL : $_POST['ManagementGroupAccess']);

$ManagementGroup = (empty($_POST['ManagementGroup']) ? NULL : $_POST['ManagementGroup']);

$DepartmentGroupAccess = (empty($_POST['DepartmentGroupAccess']) ? NULL : $_POST['DepartmentGroupAccess']);

$DepartmentNum = (empty($_POST['DepartmentNum']) ? NULL : $_POST['DepartmentNum']);

$managementGroupName = (empty($_POST['managementGroupName']) ? NULL : $_POST['managementGroupName']);

$managementEmployeeID = (empty($_POST['managementEmployeeID']) ? NULL : $_POST['managementEmployeeID']);

$reportsRole = (empty($_POST['reportsRole']) ? NULL : $_POST['reportsRole']);

$roleDepartmentNumber = (empty($_POST['roleDepartmentNumber']) ? NULL : $_POST['roleDepartmentNumber']);

$comments = (empty($_POST['comments']) ? NULL : $_POST['comments']);

$validate = (empty($_POST['validate']) ? FALSE : $_POST['validate']);




if ($validate !== FALSE) {
    $requesterType = $_POST['requesterType'];
}
if (($validate !== FALSE) && ($requesterType !== "--select one--")) {

    $subject = "HBS Access Change for " . $employeeName . " submitted by " . $adminName;
    $detail = "";
    $detail = $requesterType . " information\n";
    $detail = $detail . "Name: " . $adminName . "\n";

    $detail = $detail . "Phone: " . $adminPhone . "\n";
    $detail = $detail . "Email: " . $adminEmail . "\n";
    $detail = $detail . "Department Code: " . $depCode . "\n";
    $detail = $detail . "----------------------------\n\n";
    $detail = $detail . "Employee information\n";
    $detail = $detail . "Name: " . $employeeName . "\n";
    $detail = $detail . "ID: " . $employeeID . "\n";
    $detail = $detail . "Management Group: " . $employeeManagementGroup . "\n";
    $detail = $detail . "UCSF Employee: " . $ucsfEmployee . "\n";


    if ($approverRole !== "-select-") {
        $detail = $detail . "----------------------------\n\n";
        $detail = $detail . "Change to Employee's Approver Role\n";
        $detail = $detail . $approverRole . "\n\n";
    }

    if ($adminRole !== "-select-") {
        $detail = $detail . "----------------------------\n\n";
        $detail = $detail . "Request to " . $adminRole . "\n";
        $detail = $detail . "Access Level\n";
        if (isset($ManagementGroupAccess)) {
            $detail = $detail . "Management Group Access\n";
            $detail = $detail . "Management Group #: " . $ManagementGroup . "\n";
        }
        if (isset($DepartmentGroupAccess)) {
            $detail = $detail . "Department Plus Access\n";
            $detail = $detail . "Department #: " . $DepartmentNum . "\n";
        }
    }


    if (strlen($managementGroupName) > 0) {
        $detail = $detail . "----------------------------\n\nReplace Management Group Owner\n";
        $detail = $detail . "New Management Group Owner's Name: " . $managementGroupName . "\n";
        $detail = $detail . "Employee ID #: " . $managementEmployeeID . "\n";
    }


    if (strlen($reportsRole) > 0) {
        $detail = $detail . "----------------------------\n\nChange to Employee's Reports Role\n";
        $detail = $detail . $reportsRole . " Reports Role\n";
        $detail = $detail . "Department Number: " . $roleDepartmentNumber . "\n";
    }

    $detail = $detail . "----------------------------\n\n";
    $detail = $detail . "Comments:\n";
    $detail = $detail . $comments . "\n";
    $detail = $detail . "----------------------------\n\n";

    $mail = new PHPMailer();

    $mail->IsSMTP();
    $mail->Host = $mailHost;

    $mail->From = $mailFrom;
    $mail->FromName = 'NoReply';
    $mail->AddAddress($mailTo);
    $mail->Subject = $subject;
    $mail->Body = $detail;

    if (!$mail->Send()) {
        echo 'Message was not sent.';
        echo 'Mailer error: ' . $mail->ErrorInfo;
    }
}

include 'include/header.php';
?>
<?php if ($validate === FALSE) { ?>

    <div class="row row--demo">
        <h2>Campus HBS Access Form</h2>

        <!-- ***************************************************************** -->
        <noscript class="statusbar">
        <p>&nbsp;</p>
        <p><font color="red">
            Your browser does not support Help@UCSF Custom Applications <p>&nbsp;</p>
        please upgrade your browser or enable JavaScript support
        </font></p>
    </noscript>

    <script language="JavaScript" type="text/JavaScript">
        function MM_findObj(n, d) { //v4.01
        var p,i,x;  

        if(!d) d=document; 

        if((p=n.indexOf("?"))>0&&parent.frames.length) {

        d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);

        }

        if(!(x=d[n])&&d.all) 
        x=d.all[n]; 

        for (i=0;!x&&i<d.forms.length;i++) 
        x=d.forms[i][n];

        for(i=0;!x&&d.layers&&i<d.layers.length;i++) 
        x=MM_findObj(n,d.layers[i].document);

        if(!x && d.getElementById) 
        x=d.getElementById(n); 
        return x;
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

    <form action="" method="post" name="form1" onsubmit="MM_validateForm('adminName', '', 'R', 'ucsfEmployee', '', 'R', 'depCode', '', 'R', 'adminPhone', '', 'R', 'adminEmail', '', 'RisEmail', 'employeeName', '', 'R', 'employeeID', '', 'R', 'employeeManagementGroup', '', 'R');
                return document.MM_returnValue">
        <p>This form can only be submitted by the Management Group Owner OR the Access Administrator. Fill in the appropriate section based on your role.</p>
        <div class="row row--demo">
            <div class="columns twelve"><b>Access Administrator or Management Group Owner Information</b></div>
        </div>
        <div class="row row--demo">
            <div class="columns three">Name<input class="text-input" tabindex="1" type="text" name="adminName"></div>
            <div class="columns three">Phone Number<input class="text-input" tabindex="2" type="text" name="adminPhone"></div>
            <div class="columns three">Email Address<input class="text-input" tabindex="3" type="text" name="adminEmail"></div> 
            <div class="columns three">Department Code<input class="text-input" tabindex="4" type="text" name="depCode"></div> 
        </div>
        <div class="row row--demo">
            <div class="columns four">I am the</div>
            <div class="columns eight">
                <select tabindex="5" name="requesterType" id="requesterType">
                    <option selected>--select one--</option>
                    <option>Access Administrator</option>
                    <option>Management Group Owner</option>
                </select>
            </div>
        </div>
        <?php
        echo "<p>This form is used by the Access Administrator to request the following types of HBS updates:</p>"
        . "<strong><p>A. Change the Employee's Approver Role</p>"
        . "<p>B. Change to Employee's HR Admin Role</p>"
        . "<p>C. Replace Management Group Owner</p>"
        . "<p>D. Change to Employee's Reports Role</p></strong>";
        ?>


        <div class="row row--demo">
            <div class="columns twelve"><b>EMPLOYEE INFORMATION</b></div>
        </div>
        <div class="row row--demo">
            <div class="columns four">Name<input class="text-input" tabindex="6" type="text" name="employeeName"></div>
            <div class="columns four">Employee ID #<input class="text-input" tabindex="7" name="employeeID" type="text"></div>
            <div class="columns four">Management Group #<input class="text-input" tabindex="8" name="employeeManagementGroup" type="text" size="30"></div> 
        </div>
        <div class="row row--demo">
            <div class="columns four">Is this individual a UCSF Employee?</div>
            <div class="columns eight">
                <div class="row row--demo">
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
        </div>


        <div class="row row--demo">
            <div class="columns twelve"><b>A. Change to Employee's Approver Role</b></div>
        </div>
        <div class="row row--demo">
            <div class="columns four">Request</div>
            <div class="columns eight">
                <select name="approverRole" id="approverRole">
                    <option>-select-</option>
                    <option>Allow Approver Role</option>
                    <option>Remove Approver Role</option>
                </select>
            </div>
        </div>

        <div class="row row--demo">
            <div class="columns twelve"><b>B. Change to Employee's HR Admin Role</b></div>
        </div>
        <div class="row row--demo">
            <div class="columns four">Request</div>
            <div class="columns eight">
                <select name="adminRole" id="AdminRole">
                    <option> -select- </option>
                    <option>Allow HR Admin Role</option>
                    <option>Remove HR Admin Role</option>
                </select>
            </div>
        </div>
        <div class="row row--demo">
            <div class="columns four">Access Level</div>
            <div class="columns eight">Group/Department Number</div>
        </div>
        <div class="row row--demo">
            <div class="columns four">
                <label class="label-checkbox">
                    <input name="ManagementGroupAccess" type="checkbox" id="ManagementGroupAccess" value="true"/>Management Group Access
                </label>
            </div>
            <div class="columns eight">
                Management Group # from HBS
                <input class="text-input" name="ManagementGroup" type="text" id="ManagementGroup">
            </div>
        </div>
        <div class="row row--demo">
            <div class="columns four">
                <label class="label-checkbox">
                    <input name="DepartmentGroupAccess" type="checkbox" id="DepartmentGroupAccess" value="true"/>Department Plus Access
                </label>
            </div>
            <div class="columns eight">
                Department # from Department Hierarchy
                <input class="text-input" name="DepartmentNum" type="text" id="DepartmentNum">
            </div>
        </div>
    </div>

    <?php
    echo "<p>Notes</p>"
    . "<ul>"
    . "<li>Management Group - Provides the HBS HR Admin access to a single management group.</li>"
    . "<li>Department Plus - Provides the HBS HR Admin access to all 'child' management groups under the 'parent' department code.</li>"
    . "</ul>";
    ?>

    <div class="row row--demo">
        <div class="columns twelve"><b>C. Replace Management Group Owner</b></div>
    </div>
    <div class="row row--demo">
        <div class="columns six">New Management Group Owner's Name</div>
        <div class="columns six">Employee ID #</div>
    </div>
    <div class="row row--demo">
        <div class="columns six">
            <input class="text-input" name="managementGroupName" type="text" id="managementGroupName">
        </div>
        <div class="columns six">
            <input class="text-input" name="managementEmployeeID" type="text" id="managementEmployeeID">
        </div>
    </div>


    <div class="row row--demo">
        <div class="columns twelve"><b>D. Change to Employee's Reports Role</b></div>
    </div>
    <div class="row row--demo">
        <div class="columns four">Request</div>
        <div class="columns eight">Department Number</div>
    </div>
    <div class="row row--demo">
        <div class="columns four">
            <select name="reportsRole" id="reportsRole">
                <option value="">-select-</option>
                <option value="Allow">Allow Reports Role</option>
                <option value="Remove">Remove Reports Role</option>
            </select>
        </div>
        <div class="columns eight"><input class="text-input" type="text" name="roleDepartmentNumber" id="roleDepartmentNumber"></div>
    </div>

    <div class="row row--demo">
        <div class="columns twelve"><b>Comments</b></div>
        <div class="columns twelve">
            <textarea name="comments" cols="5" rows="5" id="comments"></textarea>
        </div>
    </div>

    <p>CERTIFICATION: Submission of this form serves as your electronic signature. It certifies that the request aligns with policy and has been appropriately approved by the employee in accordance with departmental procedures. </p>
    <p>&nbsp;</p>
    <p>
        <input name="validate" type="hidden" id="validate" value="true">
    <div align="center"><input class="btn btn--primary btn--fix" type="submit" name="Submit" value="Submit Form"> </div>
    </p>
    </form>
    <p>&nbsp;</p>

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
                








