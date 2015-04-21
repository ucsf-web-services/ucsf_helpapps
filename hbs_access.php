<?php
require_once 'vendor/autoload.php';



$mailFrom = "DAISY@ucsf.edu";
$mailTo = "Stephen.Cheung@ucsf.edu";
//$mailHost = "CUDA.UCSF.EDU";
$mailHost = "jingo.ucsf.edu";
$validate = FALSE;

$adminName = (empty($_POST['adminName']) ? NULL : $_POST['adminName']);
//$adminName = $_POST['adminName'];
$adminPhone = (empty($_POST['adminPhone']) ? NULL : $_POST['adminPhone']);
//$adminPhone = @$_POST['adminPhone'];
$adminEmail = (empty($_POST['adminEmail']) ? NULL : $_POST['adminEmail']);
//$adminEmail = @$_POST['adminEmail'];
$depCode = (empty($_POST['depCode']) ? NULL : $_POST['depCode']);
//$depCode = @$_POST['depCode'];

$employeeName = (empty($_POST['employeeName']) ? NULL : $_POST['employeeName']);
//$employeeName = @$_POST['employeeName'];
$employeeID = (empty($_POST['employeeID']) ? NULL : $_POST['employeeID']);
//$employeeID = @$_POST['employeeID'];
$employeeManagementGroup = (empty($_POST['employeeManagementGroup']) ? NULL : $_POST['employeeManagementGroup']);
//$employeeManagementGroup = @$_POST['employeeManagementGroup'];
$ucsfEmployee = (empty($_POST['ucsfEmployee']) ? NULL : $_POST['ucsfEmployee']);
//$ucsfEmployee = @$_POST['ucsfEmployee'];
//
$approverRole = (empty($_POST['approverRole']) ? NULL : $_POST['approverRole']);
//$approverRole = @$_POST['approverRole'];
$adminRole = (empty($_POST['adminRole']) ? NULL : $_POST['adminRole']);
//$adminRole = @$_POST['adminRole'];
$ManagementGroupAccess = (empty($_POST['ManagementGroupAccess']) ? NULL : $_POST['ManagementGroupAccess']);
//$ManagementGroupAccess = @$_POST['ManagementGroupAccess'];
$ManagementGroup = (empty($_POST['ManagementGroup']) ? NULL : $_POST['ManagementGroup']);
//$ManagementGroup = @$_POST['ManagementGroup'];
$DepartmentGroupAccess = (empty($_POST['DepartmentGroupAccess']) ? NULL : $_POST['DepartmentGroupAccess']);
//$DepartmentGroupAccess = @$_POST['DepartmentGroupAccess'];
$DepartmentNum = (empty($_POST['DepartmentNum']) ? NULL : $_POST['DepartmentNum']);
//$DepartmentNum = @$_POST['DepartmentNum'];
//
$managementGroupName = (empty($_POST['managementGroupName']) ? NULL : $_POST['managementGroupName']);
//$managementGroupName = @$_POST['managementGroupName'];
$managementEmployeeID = (empty($_POST['managementEmployeeID']) ? NULL : $_POST['managementEmployeeID']);
//$managementEmployeeID = @$_POST['managementEmployeeID'];
$reportsRole = (empty($_POST['reportsRole']) ? NULL : $_POST['reportsRole']);
//$reportsRole = @$_POST['reportsRole'];
$roleDepartmentNumber = (empty($_POST['roleDepartmentNumber']) ? NULL : $_POST['roleDepartmentNumber']);
//$roleDepartmentNumber = @$_POST['roleDepartmentNumber'];
$comments = (empty($_POST['comments']) ? NULL : $_POST['comments']);
//$comments = @$_POST['comments'];


//if ($_POST['validate'] !== null) {
    $validate = (empty($_POST['validate']) ? FALSE : $_POST['validate']);
//}



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

//    $mail->SMTPAuth   = true;
//    $mail->SMTPSecure = "tls"; 
//    $mail->Port       = 587;

    $mail->From = $mailFrom;
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


            
            <?php if($validate === FALSE) { ?>
            
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
                <!-- ***************************************************************** -->

                <script language="JavaScript" type="text/JavaScript">
                    <!--
                    
                    
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
                    //-->
                </script>

                <p><strong>This form can only be submitted by the Management Group Owner OR the Access Administrator. Fill in the appropriate section based on <em>your role</em>.</strong> </p>

                <form action="" method="post" name="form1" onsubmit="MM_validateForm('adminName', '', 'R', 'ucsfEmployee', '', 'R', 'depCode', '', 'R', 'adminPhone', '', 'R', 'adminEmail', '', 'RisEmail', 'employeeName', '', 'R', 'employeeID', '', 'R', 'employeeManagementGroup', '', 'R');
                    return document.MM_returnValue">
                    <table class="table--bordered">
                        <tr>
                            <th colspan="4"><div align="left"> Access Administrator or Management Group Owner Information</div> </th>
                        </tr>
                        <tr>
                            <td>Name<p>&nbsp;</p>
                                <input type="text" name="adminName"></td>
                            <td>Phone Number<p>&nbsp;</p>
                                <input type="text" name="adminPhone"></td>
                            <td>Email Address<p>&nbsp;</p>
                                <input type="text" name="adminEmail"></td>
                            <td>Department Code<p>&nbsp;</p>
                                <input type="text" name="depCode"></td>
                        </tr>
                        <tr>

                            <td>I am the</td>    

                            <td colspan="3">
                                <select name="requesterType" id="requesterType">
                                    <option selected>--select one--</option>
                                    <option>Access Administrator</option>
                                    <option>Management Group Owner</option>
                                </select>
                            </td>

                        </tr>
                    </table>

                    <p>&nbsp;</p>

                    <p>This form is used by the Access Administrator to request the following types of HBS updates:<p>&nbsp;</p>
                        <strong>
                            A. Change the Employee's Approver Role<p>&nbsp;</p>
                            B. Change to Employee's HR Admin Role<p>&nbsp;</p>
                            C. Replace Management Group Owner<p>&nbsp;</p>
                            D. Change to Employee&rsquo;s Reports Role<p>&nbsp;</p>
                        </strong>
                    </p>

                    <p>&nbsp;</p>

                    <table class="table--bordered">
                        <tr>
                            <th colspan="3"><div align="left">Employee Information</div></th>
                        </tr>

                        <tr>
                            <td>Name<p>&nbsp;</p>
                                <input type="text" name="employeeName"></td>
                            <td>Employee ID #<p>&nbsp;</p>
                                <input name="employeeID" type="text"></td>
                            <td>Management Group #<p>&nbsp;</p>
                                <input name="employeeManagementGroup" type="text" size="30">
                            </td>
                        </tr>



                        <tr>
                            <td>Is this individual a UCSF Employee? <p>&nbsp;</p></td>
                            <td colspan="2">

                                <input name="ucsfEmployee" type="radio" value="Yes">
                                Yes &nbsp;
                                <input name="ucsfEmployee" type="radio" value="No">
                                No
                            </td>
                        </tr>


                    </table>
                    <p>&nbsp;</p>

                    <table class="table--bordered">
                        <tr>
                            <th colspan="2"><div align="left">A. Change to Employee's Approver Role </div></th>
                        </tr>
                        <tr>
                            <td>Request</td>

                            <td>
                                <select name="approverRole" id="approverRole">
                                    <option>-select-</option>
                                    <option>Allow Approver Role</option>
                                    <option>Remove Approver Role</option>
                                </select>



                            </td>
                        </tr>
                    </table>
                    <p>&nbsp;</p>

                    <table class="table--bordered">
                        <tr>
                            <th colspan="2" >
                        <div align="left">B. Change to Employee's HR Admin Role</div>
                            </th>
                        </tr>
                        <tr>
                            <td>Request</td>
                            <td>
                                <select name="adminRole" id="AdminRole">
                                    <option> -select- </option>
                                    <option>Allow HR Admin Role</option>
                                    <option>Remove HR Admin Role</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Access Level</td>
                            <td>Group/Department Number</td>
                        </tr>
                        <tr>
                            <td><input name="ManagementGroupAccess" type="checkbox" id="ManagementGroupAccess" value="true">
                                Management Group Access </td>
                            <td>
                                <input name="ManagementGroup" type="text" id="ManagementGroup">
                                Management Group # from HBS</span></td>
                        </tr>
                        <tr>
                            <td><input name="DepartmentGroupAccess" type="checkbox" id="DepartmentGroupAccess" value="true">
                                Department Plus Access </td>
                            <td>
                                <input name="DepartmentNum" type="text" id="DepartmentNum">
                                Department # from Department Hierarchy</td>
                        </tr>
                    </table>
                    <p>Notes:</p>
                    <ul>
                        <li>Management Group &ndash; Provides the HBS HR Admin access to a single management group.</li>
                        <li>Department Plus &ndash; Provides the HBS HR Admin access to all &lsquo;child&rsquo; management groups under the &lsquo;parent&rsquo; department code. </li>
                    </ul>
                    <table class="table--bordered">
                        <tr>
                            <th colspan="2"><div align="left">C. Replace Management Group Owner</div></th>
                        </tr>
                        <tr>
                            <td>New Management Group Owner's Name</td>
                            <td>Employee ID # </td>
                        </tr>
                        <tr>
                            <td><input name="managementGroupName" type="text" id="managementGroupName"></td>
                            <td><input name="managementEmployeeID" type="text" id="managementEmployeeID"></td>
                        </tr>



                    </table>
                    <p>Note: The employee information provided at the top of the form should be for the existing Management Group Owner. Provide the employee information for the new Management Group Owner in section C.</p>
                    <table class="table--bordered"><p>&nbsp;</p>
                        <tr>
                            <th colspan="2"><div align="left">D. Change to Employee's Reports Role</div></th>
                        </tr>
                        <tr>
                            <td>Request</td>
                            <td><select name="reportsRole" size="1" id="24">
                                    <option value="">-select-</option>
                                    <option value="Allow">Allow Reports Role</option>
                                    <option value="Remove">Remove Reports Role</option>
                                </select></td>
                        </tr>
                        <tr>
                            <td>Department Number</td>
                            <td><input type="text" name="roleDepartmentNumber" id="roleDepartmentNumber"></td>
                        </tr>
                    </table>
                    <p>Note: Employee will have access to run reports for the selected department and all &quot;child&quot; departments under it.</p>
                    <table class="table--bordered"><p>&nbsp;</p>
                        <tr>
                            <th>Comments</th>
                        </tr>
                        <tr>
                            <td><textarea name="comments" cols="80" rows="2" id="comments"></textarea></td>
                        </tr>
                    </table>
                    <p>CERTIFICATION: Submission of this form serves as your electronic signature. It certifies that the request aligns with policy and has been appropriately approved by the employee in accordance with departmental procedures. </p>
                    <p>&nbsp;</p>
                    <p>
                        <input name="validate" type="hidden" id="validate" value="true">
                    <div align="center"><input class="btn btn--primary btn--fix" type="submit" name="Submit" value="Submit Form"> </div>
                    </p>
                </form>
                <p>&nbsp;</p>




                <!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
                
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
            
            include 'include/footer.php';
            ?>
                
                
                
                
                
                
                
                
                
