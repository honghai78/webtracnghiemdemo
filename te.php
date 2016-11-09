<html>
<?php
if(isset($_POST['submit']))
{
echo "B?n tên là:"; 
}
?>
<body>
<form id="form1" name="form1" method="post" action="">
  <p>
    <label for="textfield">Text Field:</label>
    <input type="text" name="name" required="">
  </p>
  <button type="submit" name="submit">Sub<button>
</form>
</body>
</html>