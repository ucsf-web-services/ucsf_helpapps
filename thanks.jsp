
<%
        String title = "Listserv Creation Request Confirmation";

        if (request.getParameter("type") != null) {
            if (request.getParameter("type").toString().equals("disclosure")) {
                title = "ActiveSync Disclosure";
            }
        }
%>

<%@ include file="/include/header.inc" %>

<% if (title.equals("Listserv Creation Request Confirmation")) {%>
<p>
    <%=request.getParameter("type")%>
Thank you. Your request to create:<br> <strong><%=request.getParameter("listname")%>@listserv.ucsf.edu</strong> <br>has been submitted.</p>
<p></p> You can track this request at <a href="http://help.ucsf.edu">http://help.ucsf.edu</a>.<br> The ticket number is:<br> <strong><%=request.getParameter("ticket")%></strong><p>

We will contact you when your list is available. Typically this process takes five working days.
<p>
<%} else {%>
<p>Thank you for reviewing UCSF's ActiveSync disclosure terms</p>
<%}%>

<%@ include file="/include/footer.inc" %>

</body>
</html>

