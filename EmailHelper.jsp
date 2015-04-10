<%@ page contentType="text/html" pageEncoding="UTF-8" %>

<%
            String title = "";
%>

<%@ include file="/include/header.inc" %>
<!-- ************************************************************************ -->
<%@ taglib prefix="c" uri="http://java.sun.com/jstl/core_rt" %>
<!-- ************************************************************************ -->
<c:choose>
    <c:when test="${param.retry == 'true' || param.email == 'empty'}">
        <p align=center><font size="+1" color="red" class="validationStatus"><c:out value="Invalid E-mail Address -(${param.email})- Please try again."/></font></p>
    </c:when>
    <c:when test="${param.email == 'error'}">
        <p align=center><font color="red" class="validationStatus"><c:out value="E-mail Trnasport Error -cuda.ucsf.edu- Please try again Later."/></font></p>
    </c:when>
</c:choose>
<!-- ************************************************************************ -->
<script type="text/javascript" src='<%=response.encodeURL(request.getContextPath() + "/HelpWebApps/javascript/EmailHelperForm/Mailer_Form_Validator.js")%>'></script>

<script type="Text/Javascript">
    $(document).ready(function(){
        document.getElementById('EmailAddress').focus();
        $('#submit').hover(
        function(){$(this).attr({ src : '<%=request.getContextPath()%>/images/Submit_Request_1.gif'});},
        function(){$(this).attr({ src : '<%=request.getContextPath()%>/images/Submit_Request_0.gif'});});
    });
</script>
<!-- ************************************************************************ -->
<!-- **************************** MAIN FORM BODY **************************** -->
<!-- ************************************************************************ -->

<table width="97%" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td width="20" rowspan="2" valign="top">&nbsp;</td>
        <td width="970" height="35" valign="top">&nbsp;</td>
    </tr>
    <tr>
        <td>
            <div align="center">
                <div align="center">
                    <h3><font size="+1" face="Arial,Helvetica">What is my help@UCSF User ID and password?</font></h3>
                </div>
                <!-- ********************************************************* -->
                <form
                    action='<%= response.encodeURL(request.getContextPath() + "/HelpWebApps/Mailer.action")%>'
                    method="post" name="EmailHelperForm"
                    onsubmit="return Mailer_Form_Validator(this);"
                    enctype="x-www-form-encoded">

                    <table style="border:0px solid #000000;" bgcolor="#efefef" border="0" align="center" cellpadding="5" cellspacing="0">

                        <!-- ********************************************************* -->
                        <tr bgcolor="#cdc9c9">
                            <td><div align="center"><strong>Faculty &amp; Staff</strong></div></td>
                            <td bgcolor="#faf5e6" align="left">
                                <div>
                                    <p><b>Please enter your 9 digit UC Employee ID number (format 02nnnnnnn) for the UserID, and last four digits of your social security number for the password.</b></p>
                                </div>
                                <br /><br />
                            </td>
                        </tr>

                        <!-- ********************************************************* -->
                        <tr bgcolor="white"><td></td><td bgcolor="white"></td></tr>
                        <!-- ********************************************************* -->

                        <tr bgcolor="#cdc9c9">
                            <td><div align="center"><strong>Students</strong></div></td>
                            <td bgcolor="#faf5e6" align="left">
                                <div>
                                    <p><b>Please enter your SAA UserID for the user name and your birth date (8 digit format: yyyymmdd) for the password.
                                            If you have forgotten your SAA UserID you must visit the Office of Admission and Registration (MU200 West) for assistance.
                                            <br /><br />
                                            <a href="http://directory.ucsf.edu/heading_detail.jsp?HDR_NUM=51000">Office of Admission and Registration</a> contact information
                                        </b>
                                    </p>
                                </div>
                                <br /><br />
                            </td>
                        </tr>

                        <!-- ********************************************************* -->
                        <tr bgcolor="white"><td></td><td bgcolor="white"></td></tr>
                        <!-- ********************************************************* -->

                        <tr bgcolor="#cdc9c9">
                            <td><div align="center"><strong>Remedy Support Staff</strong></div></td>
                            <td bgcolor="#faf5e6" align="left">
                                <div>
                                    <p><b>Use your Remedy ID & Password.</b></p>
                                </div>
                                <br /><br />
                            </td>
                        </tr>
                    </table>
                    <!-- ********************************************************* -->
                    <br /><br />
                    <div align="center">
                        <h3><font size="+1" face="Arial,Helvetica">Need to retrieve your help@UCSF User ID?</font></h3>
                    </div>
                    <!-- ********************************************************* -->
                    <table style="border:0px solid #000000;" bgcolor="#efefef" border="0" align="center" cellpadding="5" cellspacing="0">

                        <!-- ********************************************************* -->
                        <tr bgcolor="#DDDDAA">
                            <td bgcolor="#efefef" colspan="2" align="left">
                                <div align="right" style="font-size: 10pt;color:blue;padding:10px">
                                    <p><br />
                                        <strong>Enter a valid <i style="font-size: 11pt;color:red">UCSF</i> email address below and we will email you your UserID.</strong>
                                    </p><br />
                                    <strong>E-mail Address</strong>
                                    <input style="font-weight:bold" id="EmailAddress" name="EmailAddress" type="text" size="30" value="">
                                </div>
                                <br /><br />
                            </td>
                        </tr>
                        <!-- ********************************************************* -->
                        <tr bgcolor="white"><td></td><td bgcolor="white"></td></tr>
                        <!-- ********************************************************* -->
                        <tr bgcolor="#DDDDAA">
                            <td colspan="4" align="center"><br />
                                <input id="submit" type="image" name="Submit" src="<%=request.getContextPath()%>/images/Submit_Request_0.gif" /><br />
                                <p><font><b>Still need help?</b>&nbsp;&nbsp;Please call the ITS Service Desk at 514-4100, option 2.</font></p>
                            </td>
                        </tr>

                    </table>
                    <br />
                    <strong>Click <a style="color:red" href='<%=response.encodeURL(request.getContextPath() + "/HelpWebApps/login.jsp")%>'>here</a> for help@UCSF Login Page.</strong>
                </form>
                <!-- ********************************************************* -->
            </div>
    <tr><td>&nbsp;</td></tr>
</table>

<!-- ********************************************************* -->
<%@ include file="/include/footer.inc" %>
</body>
</html>

