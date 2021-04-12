<div class="container">
  <form action="/register_user" method="POST">
  <center>
    <label name="registration"><?= "<h1>" ?>Register<?= "</h1>" ?></label>
    <!-- <input type="hidden" name="table" value="tbl_users" readonly> -->
    <!--
    <label for="fname">First Name</label>
    <input type="text" id="fname" name="firstname" placeholder="Your name..">

    <label for="lname">Last Name</label>
    <input type="text" id="lname" name="lastname" placeholder="Your last name..">

    <label for="country">Country</label>
    <select id="country" name="country">
      <option value="australia">Australia</option>
      <option value="canada">Canada</option>
      <option value="usa">USA</option>
      <option value="usa">Other</option>
    </select>
    

    <label for="subject">Subject</label>
    <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>
    -->
    <label for="uname">Username</label>
    <input type="text" id="uname" name="username" placeholder="Type a username.">

    <label for="pw">Last Name</label>
    <input type="password" id="pw" name="password" placeholder="Password">
    
    <input type="submit" value="Submit">
  </center>
  </form>
</div>

<?php
include "./Public/snippets/footer.php";
?>