<?php
include 'include/header.php';
?>
<title>HelpApps</title>
<style>
    td:hover{
        text-decoration: underline;
    }
</style>
<div class="row row--demo">
    <div class="columns three three--phone"> </div>
    <div class="columns six six--phone">
        <h2>UCSF Help Applications</h2>
        <table class="table table--bordered">
            <tbody>
                <tr>
                    <td><a href="EmailHelper.php"><div>Retrieve User ID</div></a></td>
                </tr>
                <tr>
                    <td><a href="hbs_access.php"><div>Request HBS Access</div></a></td>
                </tr>
                <tr>
                    <td><a href="hbs_update.php"><div>Request HBS Update</div></a></td>
                </tr>
                <tr>
                    <td><a href="ipNetVerify.php"><div>Network Verification</div></a></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<?php
include 'include/footer.php';
?>