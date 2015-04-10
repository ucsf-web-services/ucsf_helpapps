<%@ page contentType="text/html; charset=iso-8859-1" language="java" import="java.sql.*" errorPage="" %>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<%@ page import="com.darwinsys.util.Mailer"%>
<%@ page import="javax.mail.*"%>
<%@ page import="javax.activation.*"%>
<!--Modification Log                                                                 -->
<!-- Ticket#/Date      Changed By       Description                                  -->
<!-- 4374 10/04/2010   G. Chaudhary     Changes to existing HBS Employee Update form.-->
<%
            String title = "Campus HBS Employee Update Form";
            String errorText = "";
            String entity = "";
            String sameName = "";
            String group = "";
            String detail = "Campus HBS Employee Update Form";
		    String mailFrom = "DAISY@UCSF.EDU";
            //String mailTo = "DAISY@UCSF.EDU";
			String mailTo = "hbsproctr@ucsfmedctr.org";
            String mailHost = "CUDA.UCSF.EDU";
            boolean validate = false;
            String subject = "Campus HBS Employee Update";

            if (request.getParameter("validate") != null) {
                validate = true;
            }


%>

<%@ include file="/include/header.inc" %>

<html>
    <style>
        .reverse {
            color:white;
            background-color: #000;
            color:#FFFFFF;
            font-weight:bold;
        }
    </style>

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

    <% if (validate) {
                subject = "HBS Employee Update for " + (String) request.getParameter("employeeName") + " submitted by " + (String) request.getParameter("adminName");
                detail = "";
                detail = "HBS HR Admin Information information\n";
                detail = detail + "Name: " + (String) request.getParameter("adminName") + "\n";
                detail = detail + "Phone: " + (String) request.getParameter("adminPhone") + "\n";
                detail = detail + "Email: " + (String) request.getParameter("adminEmail") + "\n";
                //detail = detail + "Department Code: " +(String)request.getParameter("depCode")+ "\n\n";
                detail = detail + "----------------------------\n\n";
                detail = detail + "Employee information\n";
                detail = detail + "Name: " + (String) request.getParameter("employeeName") + "\n";
                detail = detail + "ID: " + (String) request.getParameter("employeeID") + "\n";
                detail = detail + "Management Group: " + (String) request.getParameter("employeeManagementGroup") + "\n";
                detail = detail + (String) request.getParameter("ucsfEmployee") + "\n\n";

                // meat of the form follows... null checks for each section...
                if (request.getParameter("grace") != null) {
                    // grace data
                    detail = detail + "----------------------------\n\n";
                    detail = detail + "Provide a Grace Period for Vacation Maximum \n";
                    detail = detail + "Bargaining Unit :" + (String) request.getParameter("bargainingUnit") + "\n";
                }

                if (request.getParameter("AdjVac") != null) {
                    // Adjust Leave data
                    detail = detail + "----------------------------\n\n";
                    detail = detail + "Adjust Vacation Leave Balances \n";
                    detail = detail + (String) request.getParameter("AdjVac") + "\n";
                    detail = detail + (String) request.getParameter("AdjustTypeVac") + "\n";
                    detail = detail + "Effective Date: " + (String) request.getParameter("AdjDateVac") + "\n";
                    detail = detail + "Number of Hours: " + (String) request.getParameter("AdjHoursVac") + "\n";
                    detail = detail + "Reason: " + (String) request.getParameter("AdjustReasonVac") + "\n";
                }

                if (request.getParameter("AdjSick") != null) {
                    detail = detail + "----------------------------\n\n";
                    detail = detail + "Adjust Sick Leave Balances \n";
                    detail = detail + (String) request.getParameter("AdjSick") + "\n";
                    detail = detail + (String) request.getParameter("AdjustTypeSick") + "\n";
                    detail = detail + "Effective Date: " + (String) request.getParameter("AdjDateSick") + "\n";
                    detail = detail + "Number of Hours: " + (String) request.getParameter("AdjHoursSick") + "\n";
                    detail = detail + "Reason: " + (String) request.getParameter("AdjustReasonSick") + "\n";
                }

                if (request.getParameter("adjustMonths") != null) {
                    // Adjust Months data
                    detail = detail + "----------------------------\n\n";
                    detail = detail + "Adjust Months of Service\n";
                    detail = detail + (String) request.getParameter("monthsService") + "\n";
                    detail = detail + "Effective Date: " + (String) request.getParameter("monthsServiceEffectiveDate") + "\n";
                    detail = detail + "Number of Months: " + (String) request.getParameter("adjustNumberMonths") + "\n";
                    detail = detail + "Reason: " + (String) request.getParameter("MOSAdjustReason") + "\n";
                }

                if (request.getParameter("grandfathered") != null) {
                    // grandfathered data
                    detail = detail + "----------------------------\n\n";
                    detail = detail + "End Grandfathered Status  \n";
                    detail = detail + "End Date :" + (String) request.getParameter("dateEndGrandfathered") + "\n";
                }

                if (request.getParameter("unRestricted_Time") != null) {
                    // unRestricted_Time data
                    detail = detail + "----------------------------\n\n";
                    detail = detail + "Assign/Remove Non-Exempt Unrestricted Timesheet  \n";
                    detail = detail + "Request :" + (String) request.getParameter("unResTimeRequest") + "\n";
                }

                if (request.getParameter("autoPopulation_Time") != null) {
                    // autoPopulation_Time data
                    detail = detail + "----------------------------\n\n";
                    detail = detail + "Assign/Remove Auto-Population of Timesheet  \n";
                    detail = detail + "Request :" + (String) request.getParameter("autoPopTimeRequest") + "\n";
                }

                if (request.getParameter("overrideVaction") != null) {
                    // Over Ride Vacation data
                    detail = detail + "----------------------------\n\n";
                    detail = detail + "Override Vacation Eligibility \n";
                    detail = detail + "Date From: " + (String) request.getParameter("vacationOverrRideStart") + "\n";
                    detail = detail + "Date To: " + (String) request.getParameter("vacationOverrRideEnd") + "\n";
                    detail = detail + "Eligibility Status: " + (String) request.getParameter("EligibilityStatus") + "\n";
                }

                if (request.getParameter("changeManagment") != null) {
                    // Change Managment data
                    detail = detail + "----------------------------\n\n";
                    detail = detail + "Change Management Group  \n";
                    detail = detail + "Change Group to: " + (String) request.getParameter("managmentGroupNumber") + "\n";
                }

                // CRQ 4374 Begins //
				// Comment out Schedule data//
				/*
                if (request.getParameter("requestNewSchedule") != null) {
                    // requestNewSchedule data
                    detail = detail + "----------------------------\n\n";
                    detail = detail + "Request a New Schedule  \n";
                    detail = detail + "Request :" + (String) request.getParameter("requestNewSchedule") + "\n";

                    // ********************  New Schedule Data  WEEK 1******************** \\
                    detail = detail + "----------------------------\n";
                    detail = detail + "Week (1) New Schedule Data  \n";
                    detail = detail + "----------------------------\n\n";

                    // ********************
                    if (request.getParameter("Week1SundayTimeInStatus1") != null || request.getParameter("Week21undayTimeInStatus2") != null) {
                        detail = detail + "Sunday Time In: " +
                                (String) request.getParameter("Week1SundayTimeInStatus1") + ":" + (String) request.getParameter("Week1SundayTimeInStatus2") + "\n";
                    }
                    if (request.getParameter("Week1SundayTimeOutStatus1") != null || request.getParameter("Week1SundayTimeOutStatus2") != null) {
                        detail = detail + "Sunday Time Out: " +
                                (String) request.getParameter("Week1SundayTimeOutStatus1") + ":" + (String) request.getParameter("Week1SundayTimeOutStatus2") + "\n";
                    }
                    if (request.getParameter("Week1SundayMealBreakStatus") != null) {
                        detail = detail + "Sunday Meal/Break: " + (String) request.getParameter("Week1SundayMealBreakStatus") + "\n";
                    }
                    if (request.getParameter("Week1SundayTotalWorkTime") != null) {
                        detail = detail + "Sunday Total Work Time: " + (String) request.getParameter("Week1SundayTotalWorkTime") + "\n\n";
                    }

                    // ********************
                    if (request.getParameter("Week1MondayTimeInStatus1") != null || request.getParameter("Week1MondayTimeInStatus2") != null) {
                        detail = detail + "Monday Time In: " +
                                (String) request.getParameter("Week1MondayTimeInStatus1") + ":" + (String) request.getParameter("Week1MondayTimeInStatus2") + "\n";
                    }
                    if (request.getParameter("Week1MondayTimeOutStatus1") != null || request.getParameter("Week1MondayTimeOutStatus1") != null) {
                        detail = detail + "Monday Time Out: " +
                                (String) request.getParameter("Week1MondayTimeOutStatus1") + ":" + (String) request.getParameter("Week1MondayTimeOutStatus2") + "\n";
                    }
                    if (request.getParameter("Week1MondayMealBreakStatus") != null) {
                        detail = detail + "Monday Meal/Break: " + (String) request.getParameter("Week1MondayMealBreakStatus") + "\n";
                    }

                    if (request.getParameter("Week1MondayTotalWorkTime") != null) {
                        detail = detail + "Monday Total Work Time: " + (String) request.getParameter("Week1MondayTotalWorkTime") + "\n\n";
                    }

                    // ********************
                    if (request.getParameter("Week1TuesdayTimeInStatus1") != null || request.getParameter("Week1TuesdayTimeInStatus2") != null) {
                        detail = detail + "Tuesday Time In: " +
                                (String) request.getParameter("Week1TuesdayTimeInStatus1") + ":" + (String) request.getParameter("Week1TuesdayTimeInStatus2") + "\n";
                    }
                    if (request.getParameter("Week1TuesdayTimeInStatus1") != null || request.getParameter("Week1TuesdayTimeInStatus1") != null) {
                        detail = detail + "Tuesday Time Out: " +
                                (String) request.getParameter("Week1TuesdayTimeOutStatus1") + ":" + (String) request.getParameter("Week1TuesdayTimeOutStatus2") + "\n";
                    }
                    if (request.getParameter("Week1TuesdayMealBreakStatus") != null) {
                        detail = detail + "Tuesday Meal/Break: " + (String) request.getParameter("Week1TuesdayMealBreakStatus") + "\n";
                    }
                    if (request.getParameter("Week1TuesdayTotalWorkTime") != null) {
                        detail = detail + "Tuesday Total Work Time: " + (String) request.getParameter("Week1TuesdayTotalWorkTime") + "\n\n";
                    }

                    // ********************
                    if (request.getParameter("Week1WednesdayTimeInStatus1") != null || request.getParameter("Week1WednesdayTimeInStatus2") != null) {
                        detail = detail + "Wednesday Time In: " +
                                (String) request.getParameter("Week1WednesdayTimeInStatus1") + ":" + (String) request.getParameter("Week1WednesdayTimeInStatus2") + "\n";
                    }
                    if (request.getParameter("Week1WednesdayTimeOutStatus1") != null || request.getParameter("Week1WednesdayTimeOutStatus2") != null) {
                        detail = detail + "Wednesday Time Out: " +
                                (String) request.getParameter("Week1WednesdayTimeOutStatus1") + ":" + (String) request.getParameter("Week1WednesdayTimeOutStatus2") + "\n";
                    }
                    if (request.getParameter("Week1WednesdayMealBreakStatus") != null) {
                        detail = detail + "Wednesday Meal/Break: " + (String) request.getParameter("Week1WednesdayMealBreakStatus") + "\n";
                    }
                    if (request.getParameter("Week1WednesdayTotalWorkTime") != null) {
                        detail = detail + "Wednesday Total Work Time: " + (String) request.getParameter("Week1WednesdayTotalWorkTime") + "\n\n";
                    }

                    // ********************
                    if (request.getParameter("Week1ThursdayTimeInStatus1") != null || request.getParameter("Week1ThursdayTimeInStatus2") != null) {
                        detail = detail + "Thursday Time In: " +
                                (String) request.getParameter("Week1ThursdayTimeInStatus1") + ":" + (String) request.getParameter("Week1ThursdayTimeInStatus2") + "\n";
                    }
                    if (request.getParameter("Week1ThursdayTimeOutStatus1") != null || request.getParameter("Week1ThursdayTimeOutStatus2") != null) {
                        detail = detail + "Thursday Time Out: " +
                                (String) request.getParameter("Week1ThursdayTimeOutStatus1") + ":" + (String) request.getParameter("Week1ThursdayTimeOutStatus2") + "\n";
                    }
                    if (request.getParameter("Week1ThursdayMealBreakStatus") != null) {
                        detail = detail + "Thursday Meal/Break: " + (String) request.getParameter("Week1ThursdayMealBreakStatus") + "\n";
                    }
                    if (request.getParameter("Week1ThursdayTotalWorkTime") != null) {
                        detail = detail + "Thursday Total Work Time: " + (String) request.getParameter("Week1ThursdayTotalWorkTime") + "\n\n";
                    }

                    // ********************
                    if (request.getParameter("Week1FridayTimeInStatus1") != null || request.getParameter("Week1FridayTimeInStatus2") != null) {
                        detail = detail + "Friday Time In: " +
                                (String) request.getParameter("Week1FridayTimeInStatus1") + ":" + (String) request.getParameter("Week1FridayTimeInStatus2") + "\n";
                    }
                    if (request.getParameter("Week1FridayTimeOutStatus1") != null || request.getParameter("Week1FridayTimeOutStatus2") != null) {
                        detail = detail + "Friday Time Out: " +
                                (String) request.getParameter("Week1FridayTimeOutStatus1") + ":" + (String) request.getParameter("Week1FridayTimeOutStatus2") + "\n";
                    }
                    if (request.getParameter("Week1FridayMealBreakStatus") != null) {
                        detail = detail + "Friday Meal/Break: " + (String) request.getParameter("Week1FridayMealBreakStatus") + "\n";
                    }
                    if (request.getParameter("Week1FridayTotalWorkTime") != null) {
                        detail = detail + "Friday Total Work Time: " + (String) request.getParameter("Week1FridayTotalWorkTime") + "\n\n";
                    }

                    // ********************
                    if (request.getParameter("Week1SaturdayTimeInStatus1") != null || request.getParameter("Week1SaturdayTimeInStatus2") != null) {
                        detail = detail + "Saturday Time In: " +
                                (String) request.getParameter("Week1SaturdayTimeInStatus1") + ":" + (String) request.getParameter("Week1SaturdayTimeInStatus2") + "\n";
                    }
                    if (request.getParameter("Week1SaturdayTimeOutStatus1") != null || request.getParameter("Week1SundayTimeOutStatus2") != null) {
                        detail = detail + "Saturday Time Out: " +
                                (String) request.getParameter("Week1SaturdayTimeOutStatus1") + ":" + (String) request.getParameter("Week1SaturdayTimeOutStatus2") + "\n";
                    }
                    if (request.getParameter("Week1SaturdayMealBreakStatus") != null) {
                        detail = detail + "Saturday Meal/Break: " + (String) request.getParameter("Week1SaturdayMealBreakStatus") + "\n";
                    }
                    if (request.getParameter("Week1SaturdayTotalWorkTime") != null) {
                        detail = detail + "Saturday Total Work Time: " + (String) request.getParameter("Week1SaturdayTotalWorkTime") + "\n\n";
                    }
					*/

                    // ********************  New Schedule Data  WEEK 2******************** \\
/*                    detail = detail + "----------------------------\n";
                    detail = detail + "Week (2) New Schedule Data  \n";
                    detail = detail + "----------------------------\n\n";

                    if (request.getParameter("Week2SundayTimeInStatus1") != null || request.getParameter("Week2SundayTimeInStatus2") != null) {
                        detail = detail + "Sunday Time In: " +
                                (String) request.getParameter("Week2SundayTimeInStatus1") + ":" + (String) request.getParameter("Week2SundayTimeInStatus2") + "\n";
                    }
                    if (request.getParameter("Week2SundayTimeOutStatus1") != null || request.getParameter("Week2SundayTimeOutStatus2") != null) {
                        detail = detail + "Sunday Time Out: " +
                                (String) request.getParameter("Week2SundayTimeOutStatus1") + ":" + (String) request.getParameter("Week2SundayTimeOutStatus2") + "\n";
                    }
                    if (request.getParameter("Week2SundayMealBreakStatus") != null) {
                        detail = detail + "Sunday Meal/Break: " + (String) request.getParameter("Week2SundayMealBreakStatus") + "\n";
                    }
                    if (request.getParameter("Week2SundayTotalWorkTime") != null) {
                        detail = detail + "Sunday Total Work Time: " + (String) request.getParameter("Week2SundayTotalWorkTime") + "\n\n";
                    }

                    // ********************
                    if (request.getParameter("Week2MondayTimeInStatus1") != null || request.getParameter("Week2MondayTimeInStatus2") != null) {
                        detail = detail + "Monday Time In: " +
                                (String) request.getParameter("Week2MondayTimeInStatus1") + ":" + (String) request.getParameter("Week2MondayTimeInStatus2") + "\n";
                    }
                    if (request.getParameter("Week2MondayTimeOutStatus1") != null || request.getParameter("Week2MondayTimeOutStatus2") != null) {
                        detail = detail + "Monday Time Out: " +
                                (String) request.getParameter("Week2MondayTimeOutStatus1") + ":" + (String) request.getParameter("Week2MondayTimeOutStatus2") + "\n";
                    }
                    if (request.getParameter("Week2MondayMealBreakStatus") != null) {
                        detail = detail + "Monday Meal/Break: " + (String) request.getParameter("Week2MondayMealBreakStatus") + "\n";
                    }
                    if (request.getParameter("Week2MondayTotalWorkTime") != null) {
                        detail = detail + "Monday Total Work Time: " + (String) request.getParameter("Week2MondayTotalWorkTime") + "\n\n";
                    }

                    // ********************
                    if (request.getParameter("Week2TuesdayTimeInStatus1") != null || request.getParameter("Week2TuesdayTimeInStatus2") != null) {
                        detail = detail + "Tuesday Time In: " +
                                (String) request.getParameter("Week2TuesdayTimeInStatus1") + ":" + (String) request.getParameter("Week2TuesdayTimeInStatus2") + "\n";
                    }
                    if (request.getParameter("Week2TuesdayTimeOutStatus1") != null || request.getParameter("Week2TuesdayTimeOutStatus2") != null) {
                        detail = detail + "Tuesday Time Out: " +
                                (String) request.getParameter("Week2TuesdayTimeOutStatus1") + ":" + (String) request.getParameter("Week2TuesdayTimeOutStatus2") + "\n";
                    }
                    if (request.getParameter("Week2TuesdayMealBreakStatus") != null) {
                        detail = detail + "Tuesday Meal/Break: " + (String) request.getParameter("Week2TuesdayMealBreakStatus") + "\n";
                    }
                    if (request.getParameter("Week2TuesdayTotalWorkTime") != null) {
                        detail = detail + "Tuesday Total Work Time: " + (String) request.getParameter("Week2TuesdayTotalWorkTime") + "\n\n";
                    }

                    // ********************
                    if (request.getParameter("Week2WednesdayTimeInStatus1") != null || request.getParameter("Week2WednesdayTimeInStatus2") != null) {
                        detail = detail + "Wednesday Time In: " +
                                (String) request.getParameter("Week2WednesdayTimeInStatus1") + ":" + (String) request.getParameter("Week2WednesdayTimeInStatus2") + "\n";
                    }
                    if (request.getParameter("Week2WednesdayTimeOutStatus1") != null || request.getParameter("Week2WednesdayTimeOutStatus2") != null) {
                        detail = detail + "Wednesday Time Out: " +
                                (String) request.getParameter("Week2WednesdayTimeOutStatus1") + ":" + (String) request.getParameter("Week2WednesdayTimeOutStatus2") + "\n";
                    }
                    if (request.getParameter("Week2WednesdayMealBreakStatus") != null) {
                        detail = detail + "Wednesday Meal/Break: " + (String) request.getParameter("Week2WednesdayMealBreakStatus") + "\n";
                    }
                    if (request.getParameter("Week2WednesdayTotalWorkTime") != null) {
                        detail = detail + "Wednesday Total Work Time: " + (String) request.getParameter("Week2WednesdayTotalWorkTime") + "\n\n";
                    }

                    // ********************
                    if (request.getParameter("Week2ThursdayTimeInStatus1") != null || request.getParameter("Week2ThursdayTimeInStatus2") != null) {
                        detail = detail + "Thursday Time In: " +
                                (String) request.getParameter("Week2ThursdayTimeInStatus1") + ":" + (String) request.getParameter("Week2ThursdayTimeInStatus2") + "\n";
                    }
                    if (request.getParameter("Week2ThursdayTimeOutStatus1") != null || request.getParameter("Week2ThursdayTimeOutStatus2") != null) {
                        detail = detail + "Thursday Time Out: " +
                                (String) request.getParameter("Week2ThursdayTimeOutStatus1") + ":" + (String) request.getParameter("Week2ThursdayTimeOutStatus2") + "\n";
                    }
                    if (request.getParameter("Week2ThursdayMealBreakStatus") != null) {
                        detail = detail + "Thursday Meal/Break: " + (String) request.getParameter("Week2ThursdayMealBreakStatus") + "\n";
                    }
                    if (request.getParameter("Week2ThursdayTotalWorkTime") != null) {
                        detail = detail + "Thursday Total Work Time: " + (String) request.getParameter("Week2ThursdayTotalWorkTime") + "\n\n";
                    }

                    // ********************
                    if (request.getParameter("Week2FridayTimeInStatus1") != null || request.getParameter("Week2FridayTimeInStatus2") != null) {
                        detail = detail + "Friday Time In: " +
                                (String) request.getParameter("Week2FridayTimeInStatus1") + ":" + (String) request.getParameter("Week2FridayTimeInStatus2") + "\n";
                    }
                    if (request.getParameter("Week2FridayTimeOutStatus1") != null || request.getParameter("Week2FridayTimeOutStatus2") != null) {
                        detail = detail + "Friday Time Out: " +
                                (String) request.getParameter("Week2FridayTimeOutStatus1") + ":" + (String) request.getParameter("Week2FridayTimeOutStatus2") + "\n";
                    }
                    if (request.getParameter("Week2FridayMealBreakStatus") != null) {
                        detail = detail + "Friday Meal/Break: " + (String) request.getParameter("Week2FridayMealBreakStatus") + "\n";
                    }
                    if (request.getParameter("Week2FridayTotalWorkTime") != null) {
                        detail = detail + "Friday Total Work Time: " + (String) request.getParameter("Week2FridayTotalWorkTime") + "\n\n";
                    }

                    // ********************
                    if (request.getParameter("Week2SaturdayTimeInStatus1") != null || request.getParameter("Week2SaturdayTimeInStatus2") != null) {
                        detail = detail + "Saturday Time In: " +
                                (String) request.getParameter("Week2SaturdayTimeInStatus1") + ":" + (String) request.getParameter("Week2SaturdayTimeInStatus2") + "\n";
                    }
                    if (request.getParameter("Week2SaturdayTimeOutStatus1") != null || request.getParameter("Week2SundayTimeOutStatus2") != null) {
                        detail = detail + "Saturday Time Out: " +
                                (String) request.getParameter("Week2SaturdayTimeOutStatus1") + ":" + (String) request.getParameter("Week2SaturdayTimeOutStatus2") + "\n";
                    }
                    if (request.getParameter("Week2SaturdayMealBreakStatus") != null) {
                        detail = detail + "Saturday Meal/Break: " + (String) request.getParameter("Week2SaturdayMealBreakStatus") + "\n";
                    }
                    if (request.getParameter("Week2SaturdayTotalWorkTime") != null) {
                        detail = detail + "Saturday Total Work Time: " + (String) request.getParameter("Week2SaturdayTotalWorkTime") + "\n\n";
                    }
                }
				*/
				// CRQ 4374 Ends//

    %>

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

    <%
     detail = detail + "\n\nComments:\n";
     detail = detail + (String) request.getParameter("comments") + "\n";

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
From: <%=mailFrom%>
to: <%= mailTo%>
subject: <%= subject%>
_______________________
        <%=detail%>
    </pre>
    <%} else {%>

    <form action="" method="post" name="form1" onSubmit="MM_validateForm('adminName','','R','adminPhone','','R','adminEmail','','RisEmail','employeeName','','R','employeeID','','R','employeeManagementGroup','','R');return document.MM_returnValue">
        <table width="90%"  border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="3" scope="col" class="reverse"><div align="left">HBS HR ADMIN INFORMATION</div></td>
            </tr>
            <tr>
                <td><strong>Name</strong><br><input type="text" name="adminName"></td>
                <td><strong>Phone #</strong><br><input type="text" name="adminPhone"></td>
                <td><strong>Email Address</strong><br>
                    <input type="text" name="adminEmail">
                </td>
            </tr>
        </table>

        <p>This form is used by the HBS HR Admin to request the following types of HBS updates for the specified employee:</p>

        <table width="90%"  border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td><input name="grace" type="checkbox" id="grace" value="true"></td>
                <td><strong>A.&nbsp;Provide a Grace Period for Vacation Maximum</strong></td>
                <td><input name="grandfathered" type="checkbox" id="grandfathered" value="true"></td>
                <td><strong>D.&nbsp;End Grandfathered Status</strong></td>
                <td><input name="unRestricted_Time" type="checkbox" id="unRestricted_Time" value="true"></td>
                <td><strong>G.&nbsp;Assign/Remove Non-Exempt Unrestricted Timesheet</strong></td>
            </tr>
            <tr>
                <td><input name="adjustLeave" type="checkbox" id="adjustLeave" value="true"></td>
                <td><strong>B.&nbsp;Adjust Leave Balances</strong></td>
                <td><input name="overrideVaction" type="checkbox" id="overrideVaction" value="true"></td>
                <td><strong>E.&nbsp;Override Vacation Eligibility</strong></td>
                <td><input name="autoPopulation_Time" type="checkbox" id="autoPopulation_Time" value="true"></td>
                <td><strong>H.&nbsp;Assign/Remove Auto-Population of Timesheet</strong></td>
            </tr>
            <tr>
                <td><input name="adjustMonths" type="checkbox" id="adjustMonths" value="true"></td>
                <td><strong>C.&nbsp;Adjust Months of Service</strong></td>
                <td><input name="changeManagment" type="checkbox" id="changeManagment" value="true"></td>
                <!-- Ticket # CRQ 4374 Begins -->
                <td colspan="3"><strong>F.&nbsp;Change Management Group</strong></td>
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

        <table width="90%"  border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="3" scope="col" class="reverse"><div align="left">EMPLOYEE INFORMATION</div></td>
            </tr>
            <tr>
                <td><strong>Name</strong><br>
                    <input type="text" name="employeeName"></td>
                <td><span style="font-weight: bold">Employee ID #</span><br>
                    <input name="employeeID" type="text"></td>
                <td><span style="font-weight: bold">Management Group #</span><br>
                    <input name="employeeManagementGroup" type="text" size="30">
                </td>
            </tr>
            <tr>
                <td><strong>Is this individual a UCSF Employee?
                        <br>
                    </strong></td>
                <td colspan="2"><strong>
                        <input name="ucsfEmployee" type="radio" value="UCSF Employee" checked>
                        Yes <br>
                        <input name="ucsfEmployee" type="radio" value="Not a UCSF Employee">
                        No    </strong></td>
            </tr>
        </table>

        <p>&nbsp;</p>
        <table width="90%"  border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td class="reverse">A. Provide a Grace Period for Vacation Maximum </td>
            </tr>
            <tr>
                <td><strong>Bargaining Unit</strong></td>
            </tr>
            <tr>
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

        <table width="90%"  border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="6" class="reverse" scope="col"><div align="left"><strong>B. Adjust Leave Balances</span></strong></div></td>
            </tr>
            <tr valign="top">
                <td><strong>Leave Type </strong></td>
                <td><strong>Type of Adjustment </strong></td>
                <td><strong>Effective Date</strong><br>
                    (MM/DD/YYYY)</td>
                <td><strong># of Hours</strong><br>(# of hours to Add/Remove)</td>
                <td valign="top" nowrap="nowrap"><strong>Reason</strong></td>
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
        <p><em>Note: </em>If selecting "Other" as the Reason, specify the reason in the comments section.<br />
        </p>

        <table width="90%"  border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="4" class="reverse" scope="col"><div align="left"><strong>C. Adjust Months of Service</strong></div></td>
            </tr>
            <tr valign="top">
                <td><strong>Effective Date</strong><br>
                    (MM/DD/YYYY)</td>
                <td><strong># of Months </strong></td>
                <td rowspan="2"><br>
                    <input name="monthsService" type="radio" value="Add Months Service">
                    Add<br>
                    <input name="monthsService" type="radio" value="Remove Months Service">
                    Remove</td>
                <td><strong>Reason</strong></td>
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

        <table width="90%"  border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td class="reverse"><strong>D. End Grandfathered Status </strong></td>
            </tr>
            <tr>
                <td><strong>End Date</strong><br>
                    (MM/DD/YYYY)</td>
            </tr>
            <tr>
                <td><input name="dateEndGrandfathered" type="text" id="dateEndGrandfathered"></td>
            </tr>
        </table>

        <p>&nbsp;</p>
        <table width="90%"  border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="3" class="reverse">E. Override Vacation Eligibility</td>
            </tr>
            <tr>
                <td><strong>Date From</strong><br>
                    (MM/DD/YYYY)</td>
                <td><strong>Date To</strong><br>
                    (MM/DD/YYYY)</td>
                <td><strong>Eligibility Status</strong><br>
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
                <td colspan="3"><strong>Reason:
                        <textarea name="vacationOverrideReason" cols="80" rows="2" id="comments"></textarea>
                    </strong></td>
            </tr>
        </table>

        <strong><br />
        </strong><em>Note: </em>Dates must be month end dates.<br>
        <p>&nbsp;</p>

        <table width="90%"  border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td class="reverse"><strong>F. Change Management Group </strong></td>
            </tr>
            <tr>
                <td><strong>New Management Group # </strong></td>
            </tr>
            <tr>
                <td><input name="managmentGroupNumber" type="text" id="managmentGroupNumber"></td>
            </tr>
        </table>
        <p>&nbsp;</p>

        <!-- ################ -->
        <table width="90%"  border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td class="reverse">G. Assign/Remove Non-Exempt Unrestricted Timesheet </td>
            </tr>
            <tr>
                <td><strong>Request</strong></td>
            </tr>
            <tr>
                <td>
                    <select name="unResTimeRequest" id="unResTimeRequest">
                        <option value=""> -select- </option>
                        <option>Assign Non-Exempt Unrestricted Timesheet</option>
                        <option>Remove Non-Exempt Unrestricted Timesheet</option>
                    </select>
                </td>
            </tr>
        </table>
        <p>&nbsp;</p>
        <!-- ################ -->
        <table width="90%"  border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td class="reverse">H. Assign/Remove Auto-Population of Timesheet </td>
            </tr>
            <tr>
                <td><strong>Request</strong></td>
            </tr>
            <tr>
                <td>
                    <select name="autoPopTimeRequest" id="autoPopTimeRequest">
                        <option value=""> -select- </option>
                        <option>Assign Auto-Population of Timesheet</option>
                        <option>Remove Auto-Population of Timesheet</option>
                    </select>
                </td>
            </tr>
        </table>
        <p>&nbsp;</p>
        <!-- ########################### -->
        <!-- Ticket # CRQ 4374 Begins -->
      <!--  <div id="newScheduleWeek1">
            <table width="90%"  border="1" cellpadding="0" cellspacing="0">
                <tr><td colspan="5" class="reverse">I. Request a New Schedule</td></tr>
                <tr><td align="center" colspan="5" bgcolor="#C9C299"><strong>Week 1</strong></td></tr>

                <tr>
                    <th><strong>Weekday</strong></th>
                    <th><strong>Time In</strong></th>
                    <th><strong>Time Out</strong></th>
                    <th><strong>Meal Break (min)</strong></th>
                    <th><strong>Total Work Time (Hours)</strong></th>
                </tr>

                <tr bgcolor="#FFFFCC">
                    <td>Sunday</td>
                    <td align="center">
                        <select name="Week1SundayTimeInStatus1" id="Week1SundayTimeInStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week1SundayTimeInStatus2" id="Week1SundayTimeInStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week1SundayTimeOutStatus1" id="Week1SundayTimeOutStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week1SundayTimeOutStatus2" id="Week1SundayTimeOutStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week1SundayMealBreakStatus" id="Week1SundayMealBreakStatus">
                            <option>00</option>
                            <option>30</option>
                            <option>45</option>
                            <option>60</option>
                        </select>
                    </td>
                    <td align="center"><input name="Week1SundayTotalWorkTime" type="text" id="Week1SundayTotalWorkTime" size="12"></td>
                </tr>

                <tr>
                    <td>Monday</td>
                    <td align="center">
                        <select name="Week1MondayTimeInStatus1" id="Week1MondayTimeInStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week1MondayTimeInStatus2" id="Week1MondayTimeInStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week1MondayTimeOutStatus1" id="Week1MondayTimeOutStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week1MondayTimeOutStatus2" id="Week1MondayTimeOutStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week1MondayMealBreakStatus" id="Week1MondayMealBreakStatus">
                            <option>00</option>
                            <option>30</option>
                            <option>45</option>
                            <option>60</option>
                        </select>
                    </td>
                    <td align="center"><input name="Week1MondayTotalWorkTime" type="text" id="Week1MondayTotalWorkTime" size="12"></td>
                </tr>
                <tr>
                    <td>Tuesday</td>
                    <td align="center">
                        <select name="Week1TuesdayTimeInStatus1" id="Week1TuesdayTimeInStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week1TuesdayTimeInStatus2" id="Week1TuesdayTimeInStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week1TuesdayTimeOutStatus1" id="Week1TuesdayTimeOutStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week1TuesdayTimeOutStatus2" id="Week1TuesdayTimeOutStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week1TuesdayMealBreakStatus" id="Week1TuesdayMealBreakStatus">
                            <option>00</option>
                            <option>30</option>
                            <option>45</option>
                            <option>60</option>
                        </select>
                    </td>
                    <td align="center"><input name="Week1TuesdayTotalWorkTime" type="text" id="Week1TuesdayTotalWorkTime" size="12"></td>
                </tr>

                <tr>
                    <td>Wednesday</td>
                    <td align="center">
                        <select name="Week1WednesdayTimeInStatus1" id="Week1WednesdayTimeInStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week1WednesdayTimeInStatus2" id="Week1WednesdayTimeInStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week1WednesdayTimeOutStatus1" id="Week1WednesdayTimeOutStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week1WednesdayTimeOutStatus2" id="Week1WednesdayTimeOutStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week1WednesdayMealBreakStatus" id="Week1WednesdayMealBreakStatus">
                            <option>00</option>
                            <option>30</option>
                            <option>45</option>
                            <option>60</option>
                        </select>
                    </td>
                    <td align="center"><input name="Week1WednesdayTotalWorkTime" type="text" id="Week1WednesdayTotalWorkTime" size="12"></td>
                </tr>
                <tr>
                    <td>Thursday</td>
                    <td align="center">
                        <select name="Week1ThursdayTimeInStatus1" id="Week1ThursdayTimeInStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week1ThursdayTimeInStatus2" id="Week1ThursdayTimeInStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week1ThursdayTimeOutStatus1" id="Week1ThursdayTimeOutStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week1ThursdayTimeOutStatus2" id="Week1ThursdayTimeOutStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week1ThursdayMealBreakStatus" id="Week1ThursdayMealBreakStatus">
                            <option>00</option>
                            <option>30</option>
                            <option>45</option>
                            <option>60</option>
                        </select>
                    </td>
                    <td align="center"><input name="Week1ThursdayTotalWorkTime" type="text" id="Week1ThursdayTotalWorkTime" size="12"></td>
                </tr>
                <tr>
                    <td>Friday</td>
                    <td align="center">
                        <select name="Week1FridayTimeInStatus1" id="Week1FridayTimeInStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week1FridayTimeInStatus2" id="Week1FridayTimeInStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week1FridayTimeOutStatus1" id="Week1FridayTimeOutStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week1FridayTimeOutStatus2" id="Week1FridayTimeOutStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week1FridayMealBreakStatus" id="Week1FridayMealBreakStatus">
                            <option>00</option>
                            <option>30</option>
                            <option>45</option>
                            <option>60</option>
                        </select>
                    </td>
                    <td align="center"><input name="Week1FridayTotalWorkTime" type="text" id="Week1FridayTotalWorkTime" size="12"></td>
                </tr>
                <tr bgcolor="#FFFFCC">
                    <td>Saturday</td>
                    <td align="center">
                        <select name="Week1SaturdayTimeInStatus1" id="Week1SaturdayTimeInStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week1SaturdayTimeInStatus2" id="Week1SaturdayTimeInStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week1SaturdayTimeOutStatus1" id="Week1SaturdayTimeOutStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week1SaturdayTimeOutStatus2" id="Week1SaturdayTimeOutStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week1SaturdayMealBreakStatus" id="Week1SaturdayMealBreakStatus">
                            <option>00</option>
                            <option>30</option>
                            <option>45</option>
                            <option>60</option>
                        </select>
                    </td>
                    <td align="center"><input name="Week1SaturdayTotalWorkTime" type="text" id="Week1SaturdayTotalWorkTime" size="12"></td>
                </tr>
            </table>
        </div> -->
        <!-- ########################### -->
       <!-- <div id="newScheduleWeek2">
            <table width="90%"  border="1" cellpadding="0" cellspacing="0">
                <tr><td align="center" colspan="5" bgcolor="#C9C299"><strong>Week 2</strong></td></tr> 

           <tr>
                    <th><strong>Weekday</strong></th>
                    <th><strong>Time In</strong></th>
                    <th><strong>Time Out</strong></th>
                    <th><strong>Meal Break (min)</strong></th>
                    <th><strong>Total Work Time (Hours)</strong></th>
                </tr> 

               <tr bgcolor="#FFFFCC">
                    <td>Sunday</td>
                    <td align="center">
                        <select name="Week2SundayTimeInStatus1" id="Week2SundayTimeInStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week2SundayTimeInStatus2" id="Week2SundayTimeInStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week2SundayTimeOutStatus1" id="Week2SundayTimeOutStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week2SundayTimeOutStatus2" id="Week2SundayTimeOutStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week2SundayMealBreakStatus" id="Week2SundayMealBreakStatus">
                            <option>00</option>
                            <option>30</option>
                            <option>45</option>
                            <option>60</option>
                        </select>
                    </td>
                    <td align="center"><input name="Week2SundayTotalWorkTime" type="text" id="Week2SundayTotalWorkTime" size="12"></td>
                </tr>

                <tr>
                    <td>Monday</td>
                    <td align="center">
                        <select name="Week2MondayTimeInStatus1" id="Week2MondayTimeInStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week2MondayTimeInStatus2" id="Week2MondayTimeInStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week2MondayTimeOutStatus1" id="Week2MondayTimeOutStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week2MondayTimeOutStatus2" id="Week2MondayTimeOutStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week2MondayMealBreakStatus" id="Week2MondayMealBreakStatus">
                            <option>00</option>
                            <option>30</option>
                            <option>45</option>
                            <option>60</option>
                        </select>
                    </td>
                    <td align="center"><input name="Week2MondayTotalWorkTime" type="text" id="Week2MondayTotalWorkTime" size="12"></td>
                </tr>
                <tr>
                    <td>Tuesday</td>
                    <td align="center">
                        <select name="Week2TuesdayTimeInStatus1" id="Week2TuesdayTimeInStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week2TuesdayTimeInStatus2" id="Week2TuesdayTimeInStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week2TuesdayTimeOutStatus1" id="Week2TuesdayTimeOutStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week2TuesdayTimeOutStatus2" id="Week2TuesdayTimeOutStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week2TuesdayMealBreakStatus" id="Week2TuesdayMealBreakStatus">
                            <option>00</option>
                            <option>30</option>
                            <option>45</option>
                            <option>60</option>
                        </select>
                    </td>
                    <td align="center"><input name="Week2TuesdayTotalWorkTime" type="text" id="Week2TuesdayTotalWorkTime" size="12"></td>
                </tr>

                <tr>
                    <td>Wednesday</td>
                    <td align="center">
                        <select name="Week2WednesdayTimeInStatus1" id="Week2WednesdayTimeInStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week2WednesdayTimeInStatus2" id="Week2WednesdayTimeInStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week2WednesdayTimeOutStatus1" id="Week2WednesdayTimeOutStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week2WednesdayTimeOutStatus2" id="Week2WednesdayTimeOutStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week2WednesdayMealBreakStatus" id="Week2WednesdayMealBreakStatus">
                            <option>00</option>
                            <option>30</option>
                            <option>45</option>
                            <option>60</option>
                        </select>
                    </td>
                    <td align="center"><input name="Week2WednesdayTotalWorkTime" type="text" id="Week2WednesdayTotalWorkTime" size="12"></td>
                </tr>
                <tr>
                    <td>Thursday</td>
                    <td align="center">
                        <select name="Week2ThursdayTimeInStatus1" id="Week2ThursdayTimeInStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week2ThursdayTimeInStatus2" id="Week2ThursdayTimeInStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week2ThursdayTimeOutStatus1" id="Week2ThursdayTimeOutStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week2ThursdayTimeOutStatus2" id="Week2ThursdayTimeOutStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week2ThursdayMealBreakStatus" id="Week2ThursdayMealBreakStatus">
                            <option>00</option>
                            <option>30</option>
                            <option>45</option>
                            <option>60</option>
                        </select>
                    </td>
                    <td align="center"><input name="Week2ThursdayTotalWorkTime" type="text" id="Week2ThursdayTotalWorkTime" size="12"></td>
                </tr>
                <tr>
                    <td>Friday</td>
                    <td align="center">
                        <select name="Week2FridayTimeInStatus1" id="Week2FridayTimeInStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week2FridayTimeInStatus2" id="Week2FridayTimeInStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week2FridayTimeOutStatus1" id="Week2FridayTimeOutStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week2FridayTimeOutStatus2" id="Week2FridayTimeOutStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week2FridayMealBreakStatus" id="Week2FridayMealBreakStatus">
                            <option>00</option>
                            <option>30</option>
                            <option>45</option>
                            <option>60</option>
                        </select>
                    </td>
                    <td align="center"><input name="Week2FridayTotalWorkTime" type="text" id="Week2FridayTotalWorkTime" size="12"></td>
                </tr>
                <tr bgcolor="#FFFFCC">
                    <td>Saturday</td>
                    <td align="center">
                        <select name="Week2SaturdayTimeInStatus1" id="Week2SaturdayTimeInStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week2SaturdayTimeInStatus2" id="Week2SaturdayTimeInStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week2SaturdayTimeOutStatus1" id="Week2SaturdayTimeOutStatus1">
                            <option>00</option>
                            <option>01</option>
                            <option>02</option>
                            <option>03</option>
                            <option>04</option>
                            <option>05</option>
                            <option>06</option>
                            <option>07</option>
                            <option>08</option>
                            <option>09</option>
                            <option>10</option>
                            <option>11</option>
                            <option>12</option>
                            <option>13</option>
                            <option>14</option>
                            <option>15</option>
                            <option>16</option>
                            <option>17</option>
                            <option>18</option>
                            <option>19</option>
                            <option>20</option>
                            <option>21</option>
                            <option>22</option>
                            <option>23</option>
                        </select>

                        <select name="Week2SaturdayTimeOutStatus2" id="Week2SaturdayTimeOutStatus2">
                            <option>00</option>
                            <option>15</option>
                            <option>30</option>
                            <option>45</option>
                        </select>
                    </td>
                    <td align="center">
                        <select name="Week2SaturdayMealBreakStatus" id="Week2SaturdayMealBreakStatus">
                            <option>00</option>
                            <option>30</option>
                            <option>45</option>
                            <option>60</option>
                        </select>
                    </td>
                    <td align="center"><input name="Week2SaturdayTotalWorkTime" type="text" id="Week2SaturdayTotalWorkTime" size="12"></td>
                </tr>
            </table>
        </div>
        <p><em>Note: </em>Total Work Time is the number of hours between the Time In and Time Out, minus the Meal Break.</p>
        <p>&nbsp;</p> -->
       <!-- Ticket # CRQ 4374 Ends -->

        <!-- ########################### -->
        <table width="90%"  border="1" cellpadding="0" cellspacing="0">
            <tr>
                <td class="reverse">Comments</td>
            </tr>
            <tr>
                <td><textarea name="comments" cols="80" rows="2" id="comments"></textarea></td>
            </tr>
        </table>
        <p>CERTIFICATION: Submission of this form serves as your electronic signature. It certifies that the request aligns with policy and has been appropriately approved by the employee in accordance with departmental procedures.<o:p></o:p></span></span></p>

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
