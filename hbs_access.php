<?php
require __DIR__ . '/vendor/autoload.php';


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
$bodyClass = '';
include 'include/header.php';
?>
<title>HBS Access</title>
<?php if ($validate === FALSE) { ?>

    <div class="row row--demo">
        <h2>HBS Access Form</h2>
        <a href="index.php"><h4>UCSF Help Applications</h4></a>
        <h2>Campus HBS Access Form</h2>

        <!-- ***************************************************************** -->
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
                $("#approverRoleCheck").click(function () {
                    $("#A").toggle();
                });
                $("#adminRoleCheck").click(function () {
                    $("#B").toggle();
                });
                $("#replaceGroupOwnerCheck").click(function () {
                    $("#C").toggle();
                });
                $("#reportsRoleCheck").click(function () {
                    $("#D").toggle();
                });
            });
	    $(function () {
                $('#form1').parsley().on('field:validated', function() {}).on('form:submit', function() { return true; });
            });
        </script>

        <script language="JavaScript" type="text/JavaScript">
            function MM_findObj(n, d) { //v4.01
            var p,i,x; if(!d)
            d=document;if((p=n.indexOf("?"))>0&&parent.frames.length) {
            d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
            if(!(x=d[n])&&d.all) x=d.all[n];for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
            for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
            if(!x && d.getElementById) x=d.getElementById(n);return x;
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

        <form id="form1" action="" method="post" name="form1" onsubmit="MM_validateForm('adminName', '', 'R', 'ucsfEmployee', '', 'R', 'depCode', '', 'R', 'adminPhone', '', 'R', 'adminEmail', '', 'RisEmail', 'employeeName', '', 'R', 'employeeID', '', 'R', 'employeeManagementGroup', '', 'R', 'requesterType', '', 'R');
                    return document.MM_returnValue">
            <p>This form can only be submitted by the Management Group Owner OR the Access Administrator. Fill in the appropriate section based on your role.</p>
            <div class="row row--demo">
                <div class="columns twelve twelve--phone bold">Access Administrator or Management Group Owner Information</div>
            </div>
            <div class="row row--demo">
                <!--[if lt IE 10]><span id="four"><![endif]--><div class="columns three three--phone">Name<input autofocus class="text-input" type="text" name="adminName"></div><!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="four"><![endif]--><div class="columns three three--phone">Phone Number<input class="text-input" type="text" name="adminPhone" data-parsley-pattern="/[(]?\d{3}[-.)]?[ ]?\d{3}[-.]?\d{4}\b/g" data-parsley-pattern-message="The phone number must be in a North American phone number type." /></div><!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="four"><![endif]--><div class="columns three three--phone">Email Address<input class="text-input" type="text" name="adminEmail"></div><!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="four"><![endif]--><div class="columns three three--phone">Department Code<input class="text-input" type="text" name="depCode"></div><!--[if lt IE 10]></span><![endif]-->
            </div>
            
            <div class="row row--demo">
               <!--[if lt IE 10]><span id="one"><![endif]-->
                <div class='columns twelve twelve--phone bold'>Requester Type</div>
                <div class="columns twelve twelve--phone">I am the
                    <select name="requesterType" id="requesterType">
                        <option value=''>--select one--</option>
                        <option value='Access Administrator'>Access Administrator</option>
                        <option value='Management Group Owner'>Management Group Owner</option>
                    </select>
                </div>
                <!--[if lt IE 10]></span><![endif]-->
            </div>
            <p>&nbsp;</p>
            <div class="row row--demo">
                <!--[if lt IE 10]><span id="four"><![endif]-->
                <div class="columns three three--phone">
                    <label class="label-checkbox">
                        <input name="approverRoleCheck" type="checkbox" id="approverRoleCheck" value="true"/>A. Change the Employee's Approver Role
                    </label>            
                </div>
                <!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="four"><![endif]-->
                <div class="columns three three--phone">
                    <label class="label-checkbox">
                        <input name="adminRoleCheck" type="checkbox" id="adminRoleCheck" value="true">B. Change to Employee's HR Admin Role
                    </label>
                </div>
                <!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="four"><![endif]-->
                <div class="columns three three--phone">
                    <label class="label-checkbox">
                        <input name="replaceGroupOwnerCheck" type="checkbox" id="replaceGroupOwnerCheck" value="true">C. Replace Management Group Owner
                    </label>
                </div>
                <!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="four"><![endif]-->
                <div class="columns three three--phone">
                    <label class="label-checkbox">
                        <input name="reportsRoleCheck" type="checkbox" id="reportsRoleCheck" value="true">D. Change to Employee's Reports Role
                    </label>
                </div>
                <!--[if lt IE 10]></span><![endif]-->
            </div>

            <p>&nbsp;</p>
            <div class="row row--demo">
                <!--[if lt IE 10]><span id="one"><![endif]-->
                <div class="columns twelve twelve--phone bold">EMPLOYEE INFORMATION</div>
                <!--[if lt IE 10]></span><![endif]-->
            </div>
            <div class="row row--demo">
                <!--[if lt IE 10]><span id="three"><![endif]--><div class="columns four four--phone">Name<input class="text-input" type="text" name="employeeName"></div><!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="three"><![endif]--><div class="columns four four--phone">Employee ID #<input class="text-input" name="employeeID" type="text" data-parsley-type="digits" data-parsley-length="[9,9]" data-parsley-length-message="The employee id must be 9 digits long" /></div><!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="three"><![endif]--><div class="columns four four--phone">Management Group #<input class="text-input" name="employeeManagementGroup" type="text" size="30" data-parsley-minlength="6" /></div><!--[if lt IE 10]></span><![endif]-->
            </div>
            <div class="row row--demo">
                <!--[if lt IE 10]><span id="three"><![endif]-->
                <div class="columns four four--phone">Is this individual a UCSF Employee?</div>
                <!--[if lt IE 10]></span><![endif]-->
                <div class="columns eight eight--phone">
                    <div class="row row--demo">
                        <!--[if lt IE 10]><span id="three"><![endif]-->
                        <div class="columns four four--phone">
                            <label class="label-radio">
                                <input name="ucsfEmployee" type="radio" value="UCSF Employee" checked>Yes
                            </label>
                        </div>
                        <!--[if lt IE 10]></span><![endif]-->
                        <!--[if lt IE 10]><span id="three"><![endif]-->
                        <div class="columns four four--phone">
                            <label class="label-radio">
                                <input name="ucsfEmployee" type="radio" value="Not a UCSF Employee">No
                            </label>
                        </div>
                        <!--[if lt IE 10]></span><![endif]-->
                    </div>
                </div>
            </div>
            <p>&nbsp;</p>

            <div id="A" class="hide">
                <div class="row row--demo">
                    <div class="columns twelve twelve--phone bold">A. Change to Employee's Approver Role</div>
                </div>
                <div class="row row--demo">
                    <div class="columns four four--phone">Request</div>
                    <div class="columns eight eight--phone">
                        <select name="approverRole" id="approverRole">
                            <option>-select-</option>
                            <option>Allow Approver Role</option>
                            <option>Remove Approver Role</option>
                        </select>
                    </div>
                </div>
            </div>

            <div id="B" class="hide">
                <p>&nbsp;</p>
                <div class="row row--demo">
                    <div class="columns twelve twelve--phone bold">B. Change to Employee's HR Admin Role</div>
                </div>
                <div class="row row--demo">
                    <div class="columns four four--phone">Request</div>
                    <div class="columns eight eight--phone">
                        <select name="adminRole" id="AdminRole">
                            <option> -select- </option>
                            <option>Allow HR Admin Role</option>
                            <option>Remove HR Admin Role</option>
                        </select>
                    </div>
                </div>
                <div class="row row--demo">
                    <!--[if lt IE 10]><span id="two"><![endif]--><div class="columns four four--phone">Access Level</div><!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="two"><![endif]--><div class="columns eight eight--phone">Group/Department Number</div><!--[if lt IE 10]></span><![endif]-->
                </div>
                <div class="row row--demo">
                    <!--[if lt IE 10]><span id="two"><![endif]-->
                    <div class="columns four four--phone">
                        <label class="label-checkbox">
                            <input name="ManagementGroupAccess" type="checkbox" id="ManagementGroupAccess" value="true"/>Management Group Access
                        </label>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="two"><![endif]-->
                    <div class="columns eight eight--phone">
                        Management Group # from HBS
                        <input class="text-input" name="ManagementGroup" type="text" id="ManagementGroup">
                    </div>
                </div>
                <!--[if lt IE 10]></span><![endif]-->
                <!--[if lt IE 10]><span id="two"><![endif]-->
                <div class="row row--demo">
                    <div class="columns four four--phone">
                        <label class="label-checkbox">
                            <input name="DepartmentGroupAccess" type="checkbox" id="DepartmentGroupAccess" value="true"/>Department Plus Access
                        </label>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="two"><![endif]-->
                    <div class="columns eight eight--phone">
                        Department # from Department Hierarchy
                        <input class="text-input" name="DepartmentNum" type="text" id="DepartmentNum">
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                </div>




                <!--[if lt IE 10]><span id="one"><![endif]-->
                <p>Notes</p>
                <ul>
                    <li>Management Group - Provides the HBS HR Admin access to a single management group.</li>
                    <li>Department Plus - Provides the HBS HR Admin access to all 'child' management groups under the 'parent' department code.</li>
                </ul>
                <!--[if lt IE 10]></span><![endif]-->

                <p>&nbsp;</p>
            </div>

            <div id="C" class="hide">
                <div class="row row--demo">
                    <div class="columns twelve twelve--phone bold">C. Replace Management Group Owner</div>
                </div>
                <div class="row row--demo">
                    <!--[if lt IE 10]><span id="two"><![endif]--><div class="columns six six--phone">New Management Group Owner's Name</div><!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="two"><![endif]--><div class="columns six six--phone">Employee ID #</div><!--[if lt IE 10]></span><![endif]-->
                </div>
                <div class="row row--demo">
                    <!--[if lt IE 10]><span id="two"><![endif]-->
                    <div class="columns six six--phone">
                        <input class="text-input" name="managementGroupName" type="text" id="managementGroupName">
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="two"><![endif]-->
                    <div class="columns six six--phone">
                        <input class="text-input" name="managementEmployeeID" type="text" id="managementEmployeeID">
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                </div>
                <p>&nbsp;</p>
            </div>

            <div id="D" class="hide">
                <div class="row row--demo">
                    <div class="columns twelve twelve--phone bold">D. Change to Employee's Reports Role</div>
                </div>
                <div class="row row--demo">
                    <!--[if lt IE 10]><span id="two"><![endif]--><div class="columns four four--phone">Request</div><!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="two"><![endif]--><div class="columns eight eight--phone">Department Number</div><!--[if lt IE 10]></span><![endif]-->
                </div>
                <div class="row row--demo">
                    <!--[if lt IE 10]><span id="two"><![endif]-->
                    <div class="columns four four--phone">
                        <select name="reportsRole" id="reportsRole">
                            <option value="">-select-</option>
                            <option value="Allow">Allow Reports Role</option>
                            <option value="Remove">Remove Reports Role</option>
                        </select>
                    </div>
                    <!--[if lt IE 10]></span><![endif]-->
                    <!--[if lt IE 10]><span id="two"><![endif]-->
                    <div class="columns eight eight--phone"><input class="text-input" type="text" name="roleDepartmentNumber" id="roleDepartmentNumber"></div>
                    <!--[if lt IE 10]></span><![endif]-->
                </div>
            </div>

            <div class="row row--demo">
                <div class="columns twelve twelve--phone bold">Comments</div>
                <div class="columns twelve twelve--phone">
                    <textarea name="comments" cols="5" rows="5" id="comments"></textarea>
                </div>
            </div>

            <p>CERTIFICATION: Submission of this form serves as your electronic signature. It certifies that the request aligns with policy and has been appropriately approved by the employee in accordance with departmental procedures. </p>
            <p>&nbsp;</p>

            <!--[if lt IE 10]><span id="two"><![endif]--><div class="columns ten ten--phone"><a href="hbs_access.php" class="btn btn--primary">Reset Form</a></div><!--[if lt IE 10]></span><![endif]-->
            <input name="validate" type="hidden" id="validate" value="true">
            <!--[if lt IE 10]><span id="three"><![endif]-->
            <div></div>
            <!--[if lt IE 10]></span><![endif]-->
            <!--[if lt IE 10]><span id="six"><![endif]--><div class="columns one one--phone"><input class="btn btn--primary" type="submit" name="Submit" value="Submit Form"></div><!--[if lt IE 10]></span><![endif]-->
        </form>
        <p>&nbsp;</p>
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













