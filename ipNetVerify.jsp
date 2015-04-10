
<%
            String title = "ITS Network Verification";
            String release_level = "1";
            int slice = 0;
            int octet3;
            int octet4;
            String ip = "test";
            String networkLocation = "not UCSF";

            if (request.getParameter("ip_add") != null) {
                ip = (String) request.getParameter("ip_add");
            } else {
                ip = request.getRemoteAddr();
            }

            String subnet;
            subnet = ip.substring(8);

            //new code added 2013-10-30 - jk

            if (ip.startsWith("10.")) {
                release_level = "3";
                networkLocation = "UCSF Network - Private Space";
                }
    
            // end new code

            if (ip.startsWith("64.54.")) {
                release_level = "3";
                subnet = ip.substring(6);
                slice = subnet.indexOf(".");
                octet3 = Integer.parseInt(subnet.substring(0, slice));
                slice = slice + 1;
                octet4 = Integer.parseInt(subnet.substring(slice));
                if (octet3 >= 10 && octet3 <= 14) {
					if (octet3 == 10){
					networkLocation = "Medical Center Cisco VPN";
					} else if (octet3 == 13){
					networkLocation = "Medical Center Web VPN";
					}else{
                    networkLocation = "UCSF Medical Center";
					}
                } else if (octet3 >= 0 && octet3 <= 127) {
                    networkLocation = "UCSF Medical Center Network";
                } else if (octet3 >= 249 && octet3 <= 251) {
                    networkLocation = "UCSF Campus Nortel VPN System";
                } else if (octet3 >= 128 && octet3 <= 255) {
                    networkLocation = "UCSF Campus Network";
                } else {
                    networkLocation = "UCSF Medical Center Network";
                }
            }
            if (ip.startsWith("128.218.")) {
                release_level = "3";
                networkLocation = "UCSF Campus Network";
                subnet = ip.substring(8);
                slice = subnet.indexOf(".");
                octet3 = Integer.parseInt(subnet.substring(0, slice));
                slice = slice + 1;
                octet4 = Integer.parseInt(subnet.substring(slice));
                if (octet3 == 28) {
                    if ((octet4 >= 192) && (octet4 <= 223)) {
                        networkLocation = "UCSF ITS SSL VPN Test System";
                    }
                } else if (octet3 == 174) {
                    if ((octet4 >= 37) && (octet4 <= 61) || ((octet4 >= 69) && (octet4 <= 93))) {
                        networkLocation = "UCSF Campus Nortel VPN System";
                    }
                } else {
                    networkLocation = "UCSF Campus Network";
                }
            }
            if (ip.startsWith("169.230.")) {
                release_level = "3";
                subnet = ip.substring(8);
                slice = subnet.indexOf(".");
                octet3 = Integer.parseInt(subnet.substring(0, slice));
                slice = slice + 1;
                octet4 = Integer.parseInt(subnet.substring(slice));
                if (octet3 >= 100 && octet3 <= 109) {
                    networkLocation = "UCSF Mission Bay Mixed Housing Network";
                } else if (octet3 >= 110 && octet3 <= 120) {
                    networkLocation = "UCSF Mission Bay Community Center Network";
                } else if (octet3 >= 226 && octet3 <= 227) {
                    networkLocation = "UCSF QB3 Authenitcated Wireless Network";
                } else if ((octet3 == 228) && (octet4 <= 127)) {
                    networkLocation = "UCSF QB3 Open Wireless Wireless Network";
                } else if (octet3 >= 240 && octet3 <= 243) {
                    networkLocation = "UCSF Campus SSL VPN System";
                } else if (octet3 >= 244 && octet3 <= 247) {
                    networkLocation = "UCSF Campus DSL VPN System";
                } else {
                    networkLocation = "UCSF Mission Bay Campus Network";
                }
            }
%>

<%@ include file="/include/header.inc" %>

<H2 class="subhead2">Test <abbr title="Virtual Private Network">VPN</abbr></H2>
<p>
    <a>The box below tests whether the Virtual Private Network (<abbr title="Virtual Private Network">VPN</abbr>)</a> 
    appears to be working at the time you visited (loaded) this web page.
</p>

<%if (release_level.equals("3")) {%>
<p style="border:2px solid #933;padding:8px;background-color:#c0edb2">
    <em>Yes</em>, you are on the UCSF computing network:<br><br>
    You appear to be connecting from the IP address of: <strong><%= ip%></strong><br><br>
    From this UCSF computing resources identify you as being connected from: <strong><%= networkLocation%></strong><br><br>
    If you are having problems connecting to a site or network resource please contact your local CSC, 
computer administrator or the ITS Help Desk and provide them the information found in this box. </p>
<%} else {%>
<p style="border:2px solid #933;padding:8px;background-color:#f0d3d3">
    <em>No</em>, you are not on the UCSF computing network.<br><br>
    You look to be connecting from the IP address of:  <strong><%= ip%></strong><br><br>
    This shows either that you are not on the UCSF network, you are not using one of the UCSF <abbr title="Virtual Private Network">VPN</abbr> services or your <abbr title="Virtual Private Network">VPN</abbr> client is not working correctly. Web sites and computing resources that require you to be on the UCSF network will not currently allow you access.<br><br>
    If you do not currently have access to the UCSF <abbr title="Virtual Private Network">VPN</abbr> systems please review the <a href ="/information/network/vpn/nortel/use/index.jsp"><abbr title="Virtual Private Network">VPN</abbr> information</a> on this website. If you are currently attempting to use the UCSF VPN system are having problems connecting to a site or network resource please contact your local CSC, computer administrator or the ITS Help Desk and provide them the information found in this box. 
    <%}%>
</p>

<p>    
Testing your Java Virtual Machine (JVM)<br></p>
<p><applet code="JavaVersionTest.class" width="300" height="30"></applet>
<br/>
<br/>

<p class="goto">
    <strong>Go To</strong>: <a href="http://vpn.ucsf.edu">Virtual Private Network (<abbr title="Virtual Private Network">VPN</abbr>)</a>
</p>
<!-- end main content -->

<%@ include file="/include/googleAnalyticsScript.js" %>
<%@ include file="/include/footer.inc" %>


