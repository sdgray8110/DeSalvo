<?php
if ($_GET['complete'] == 'true') {
    $message = 'Your email has been sent. We&rsquo;ll review your correspondence and respond as quickly as possible.';
    $messageHead = 'Thank You';
} else if ($_GET['complete'] == 'spam') {
    $message = 'Your email has been identified as spam and has not been sent. If this has happened again, please fill the form out again and barring success, please give us a call.';
    $messageHead = 'Email Not Sent.';
}

echo '
<div class="contactus">
    <p>Contact Us</p>

    <div class="contactuscontent">
        <ul class="contactInfo">
            <li><h4>DeSalvo Custom Cycles</h4></li>
            <li>668 Tolman Creek Road</li>
            <li>Ashland, OR 97520</li>
            <li>Phone: 541-488-8400</li>
        </ul>

        <div id="contactUs">
            <fieldset>
                <legend>'.$messageHead.'</legend>
                 <p>'.$message.'</p>
            </fieldset>
        </div>
    </div>
</div>
';
?>