<div class="contactus">
    <p>Contact Us</p>

    <div class="contactuscontent">
        <ul class="contactInfo">
            <li><h4>DeSalvo Custom Cycles</h4></li>
            <li>668 Tolman Creek Road</li>
            <li>Ashland, OR 97520</li>
            <li>Phone: 541-488-8400</li>
        </ul>

        <form id="contactUs" action="php/contactFormHandler.php" method="post">
            <fieldset>
                <legend>Send Us An Email</legend>

                <label for="contactName">Name:</label>
                <input type="text" class="text" id="contactName" name="contactName" value="" />

                <label for="contactEmail">Email:</label>
                <input type="text" class="text" id="contactEmail" name="contactEmail" value="" />
                <input type="text" class="text" id="honeyPot" name="honeyPot" value="" />

                <label for="contactSubject">Subject:</label>
                <input type="text" class="text" id="contactSubject" name="contactSubject" value="" />

                <label for="contactDepartment">Department:</label>
                <select id="contactDepartment" name="contactDepartment">
                    <option value="USA Sales">USA Sales</option>
                    <option value="International Sales">International Sales</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Webmaster">Webmaster</option>
                </select>

                <label for="contactComment">Comment:</label>
                <textarea id="contactComment" name="contactComment"></textarea>

                <input type="submit" id="contactSubmit" value="Submit" />
            </fieldset>
        </form>
    </div>
</div>