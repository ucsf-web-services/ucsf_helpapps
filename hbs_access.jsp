<%@ page contentType="text/html; charset=iso-8859-1" language="java" import="java.sql.*" errorPage="" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<%@ page import="com.darwinsys.util.Mailer"%>
<%@ page import="javax.mail.*"%>
<%@ page import="javax.activation.*"%>
<%
    String title = "Campus HBS Access Form";
    String errorText = "";
    String entity = "";
    String sameName = "";
    String group = "";
    String detail ="This is a test";
    String mailFrom = "DAISY@UCSF.EDU";
	//String mailTo = "john.kealy@ucsf.edu";
    //String mailTo = "Veronica.Freiwald@ucsf.edu";
	//String mailTo = "Christopher.Kirkpatrick@ucsf.edu";
    String mailTo = "hbsproctr@ucsfmedctr.org";
    String mailHost = "CUDA.UCSF.EDU";
	boolean validate = false;
	String subject= "Campus HBS Employee Update";
	String requesterType="";
	if (request.getParameter("validate") != null) {
	 validate = true;
	 }

%>

<%@ include file="/include/header.inc" %>
<style>

	.reverse {
	 color:white;
	 background-color: #000;
	 color:#FFFFFF;
	 font-weight:bold;
	 }

.reverse1 {	 color:white;
	 background-color: #000;
	 color:#FFFFFF;
	 font-weight:bold;
}
.reverse11 {color:white;
	 background-color: #000;
	 color:#FFFFFF;
	 font-weight:bold;
}
</style>


<script language="JavaScript" type="text/JavaScript">
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

<%if(validate){requesterType=(String)request.getParameter("requesterType");}
if((validate)&&(!(requesterType.equals("--select one--")))){

		subject = "HBS Access Change for " + (String)request.getParameter("employeeName") + " submitted by " + (String)request.getParameter("adminName");
	 	detail="";
		detail = requesterType+ " information\n";
		detail = detail + "Name: " +(String)request.getParameter("adminName")+ "\n";
		detail = detail + "Phone: " +(String)request.getParameter("adminPhone")+ "\n";
		detail = detail + "Email: " +(String)request.getParameter("adminEmail")+ "\n";
		detail = detail + "Department Code: " +(String)request.getParameter("depCode")+ "\n\n";
		detail = detail + "----------------------------\n\n";
		detail = detail + "Employee information\n";
		detail = detail + "Name: " +(String)request.getParameter("employeeName")+ "\n";
		detail = detail + "ID: " +(String)request.getParameter("employeeID")+ "\n";
		detail = detail + "Management Group: " +(String)request.getParameter("employeeManagementGroup")+ "\n";
		detail = detail + "UCSF Employee: "+ (String)request.getParameter("ucsfEmployee")+ "\n\n";


		String approve = (String)request.getParameter("approverRole");
		if (!(approve.equals("-select-"))){
		detail = detail + "----------------------------\n\n";
		detail = detail + "Change to Employee's Approver Role\n";
		detail = detail + (String)request.getParameter("approverRole") + "\n\n";
		}

		String role = (String)request.getParameter("adminRole");
		if (!(role.equals("-select-"))){
		detail = detail + "----------------------------\n\n";
		detail = detail + "Request to " + (String)request.getParameter("adminRole") + "\n";
		detail = detail + "Access Level\n" ;
			if (request.getParameter("ManagmentGroupAccess")!=null){
			detail = detail + "Management Group Access\n";
			detail = detail + "Management Group #:" + (String)request.getParameter("ManagementGroup") + "\n";
			}
			if (request.getParameter("DepartmentGroupAccess")!=null){
			detail = detail + "Department Plus Access\n";
			detail = detail + "Department #:" + (String)request.getParameter("DepartmentNum") +"\n";
			}
		}

		String replaceGroup =	(String)request.getParameter("managementGroupName");
		if (replaceGroup.length() > 0){
			detail = detail + "----------------------------\n\nReplace Management Group Owner\n";
			detail = detail + "New Management Group Owner's Name: " +(String)request.getParameter("managementGroupName")+"\n";
			detail = detail + "Employee ID #: " + (String)request.getParameter("managementEmployeeID") +"\n";
		}

		/* adding new code for section D  "change to employee reports role" */

		String reports_role =	(String)request.getParameter("reportsRole");
		if (reports_role.length() > 0){
			detail = detail + "----------------------------\n\nChange to Employee's Reports Role\n";
			detail = detail + reports_role +" Reports Role\n";
			detail = detail + "Department Number: " + (String)request.getParameter("roleDepartmentNumber") +"\n";
		}
		/* end of added section */

		detail = detail + "----------------------------\n\n";
		detail= detail + "Comments:\n";
	    detail= detail + (String)request.getParameter("comments") +"\n";


		detail = detail + "----------------------------\n\n";



	               //section that emails
	                Mailer m = new Mailer();
	                m.setServer("cuda.ucsf.edu");
	                m.addTo(mailTo);
	                m.setFrom(mailFrom);
	                m.setSubject(subject);
	                m.setBody(detail);
	                m.doSend();
					%>


	<strong>Email sent</strong>
<pre>
From: <%=mailFrom %>
to: <%= mailTo%>
subject: <%= subject%>
_______________________
<%=detail%>
</pre>
	<p>
    <%}else{%>

	<%if (requesterType.equals("--select one--")){%>
	<p style="color:red">Please select weather you are the Management Group Owner or the Access Administrator </p>
	<%}%>
  </p>
<p><strong>This form can only be submitted by the Management Group Owner OR the Access Administrator. Fill in the appropriate section based on <em>your role</em>.</strong> </p>
<form action="" method="post" name="form1" onsubmit="MM_validateForm('adminName','','R','ucsfEmployee','','R','depCode','','R','adminPhone','','R','adminEmail','','RisEmail','employeeName','','R','employeeID','','R','employeeManagementGroup','','R');return document.MM_returnValue">
<table width="90%"  border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="4" class="reverse" scope="col"><div align="left" style="font-weight: bold">Access Administrator or Management Group Owner Information</div></td>
  </tr>
  <tr>
    <td><strong>Name</strong><br>
      <input type="text" name="adminName"></td>
    <td><span style="font-weight: bold">Phone Number</span><br>
      <input type="text" name="adminPhone"></td>
    <td><span style="font-weight: bold">Email Address</span><br>
      <input type="text" name="adminEmail"></td>
    <td><span style="font-weight: bold">Department Code</span><br>
      <input type="text" name="depCode"></td>
  </tr>
  <tr>
    <td colspan="4">
	<%if (requesterType.equals("--select one--")){%>
	<span style="font-weight: bold;color:red">
	<%}else{%>
	<span style="font-weight: bold">
	<%}%>
	I am the</span>
	<select name="requesterType" id="requesterType">
        <option selected>--select one--</option>
        <option>Access Administrator</option>
        <option>Management Group Owner</option>
      </select></td>
    </tr>
</table>

<p>This form is used by the Access Administrator to request the following types of HBS updates:<br>
  <strong>A. Change the Employee's Approver Role<br>
  B. Change to Employee's HR Admin Role<br>
  C. Replace Management Group Owner<br>
  D. </strong><strong>Change to Employee&rsquo;s Reports Role</strong><br>
</p>
<table width="90%"  border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" class="reverse" scope="col"><div align="left" style="font-weight: bold">Employee Information</div></td>
  </tr>
  <tr>
    <td><strong>Name</strong><br>
        <input type="text" name="employeeName"></td>
    <td><strong>Employee ID #</strong><br>
        <input name="employeeID" type="text"></td>
    <td><strong>Management Group #</strong><br>
        <input name="employeeManagementGroup" type="text" size="30">
    </td>
  </tr>
  <tr>
    <td><strong>Is this individual a UCSF Employee? <br>
    </strong></td>
    <td colspan="2"><strong>
      <input name="ucsfEmployee" type="radio" value="Yes" checked>
      Yes <br>
      <input name="ucsfEmployee" type="radio" value="No">
      No </strong></td>
  </tr>
</table>
<p>&nbsp;</p>



<table width="90%"  border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td class="reverse" style="font-weight: bold">A. Change to Employee's Approver Role </td>
  </tr>
  <tr>
    <td><strong>Request</strong></td>
  </tr>
  <tr>
    <td><select name="approverRole" id="approverRole">
	  <option>-select-</option>
      <option>Allow Approver Role</option>
      <option>Remove Approver Role</option>
    </select>


	</td>
  </tr>
</table>
<p>&nbsp;</p>

<table width="90%"  border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" class="reverse" scope="col"><div align="left"><strong>B. Change to Employee's HR Admin Role</strong></div></td>
    </tr>
  <tr>
    <td colspan="2" scope="col"><strong>Request</strong></td>
  </tr>
  <tr>
    <td colspan="2" scope="col"><select name="adminRole" id="AdminRole">
      <option> -select- </option>
	  <option>Allow HR Admin Role</option>
      <option>Remove HR Admin Role</option>
            </select></td>
  </tr>
  <tr>
    <td scope="col"><strong>Access Level </strong></td>
    <td scope="col"><strong>Group/Department Number </strong></td>
  </tr>
  <tr>
    <td scope="col"><input name="ManagmentGroupAccess" type="checkbox" id="ManagmentGroupAccess" value="true">
      Management Group Access </td>
    <td scope="col">
      <input name="ManagementGroup" type="text" id="ManagementGroup">
      Management Group # from HBS</span></td>
  </tr>
  <tr>
    <td scope="col"><input name="DepartmentGroupAccess" type="checkbox" id="DepartmentGroupAccess" value="true">
      Department Plus Access </td>
    <td scope="col">
      <input name="DepartmentNum" type="text" id="DepartmentNum">
      Department # from Department Hierarchy</td>
  </tr>
</table>
<p>Notes:</p>
<ul>
  <li>Management Group&ndash; Provides the HBS HR Admin access to a single management group.</li>
  <li>Department Plus&ndash; Provides the HBS HR Admin access to all &lsquo;child&rsquo; management groups under the &lsquo;parent&rsquo; department code. </li>
</ul>
<table width="90%"  border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" class="reverse"><strong>C. Replace Management Group Owner</strong></td>
    </tr>
  <tr>
    <td><strong>New Management Group Owner's Name</strong></td>
    <td><strong>Employee ID # </strong></td>
  </tr>
  <tr>
    <td><input name="managementGroupName" type="text" id="managementGroupName"></td>
    <td><input name="managementEmployeeID" type="text" id="managementEmployeeID"></td>
  </tr>
</table>
<p>Note: The employee information provided at the top of the form should be for the existing Management Group Owner. Provide the employee information for the new Management Group Owner in section C.</p>
<table width="90%"  border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" class="reverse11"><strong>D. Change to Employee's Reports Role</strong></td>
  </tr>
  <tr>
    <td><strong>Request</strong></td>
    <td><select name="reportsRole" size="1" id="24">
      <option value="">-select-</option>
      <option value="Allow">Allow Reports Role</option>
      <option value="Remove">Remove Reports Role</option>
    </select></td>
  </tr>
  <tr>
    <td><strong>Department Number</strong></td>
    <td><input type="text" name="roleDepartmentNumber" id="roleDepartmentNumber"></td>
  </tr>
</table>
<p>Note: Employee will have access to run reports for the selected department and all &quot;child&quot; departments under it.</p>
<table width="90%"  border="1" cellpadding="0" cellspacing="0">
  <tr>
    <td class="reverse">Comments</td>
  </tr>
  <tr>
    <td><textarea name="comments" cols="80" rows="2" id="comments"></textarea></td>
  </tr>
</table>
<p>CERTIFICATION: Submission of this form serves as your electronic signature. It certifies that the request aligns with policy and has been appropriately approved by the employee in accordance with departmental procedures. </p>
<p>&nbsp;</p>
<p align="center">
<input name="validate" type="hidden" id="validate" value="true">
  <input type="submit" name="Submit" value="Submit Form">
  </p>
      </form>
<p>&nbsp;</p>
<%}%>
<%@ include file="/include/footer.inc" %>
</body>
</html>
