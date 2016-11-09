<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php session_start();?>
<html>
<head>
 <title>TRẮC NGHIỆM TRỰC TUYẾN</title>    
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <link href="demo.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class = "form">
<?php require_once("config.php");?>
<?php 
$db = $GLOBALS["db"];
	// nếu nút Logout được nhấn
	if (isset($_GET["logut"])){
		// hủy bỏ session
		unset($_SESSION["loggedin"]);
		unset($_SESSION["User"]);
		unset($_SESSION["HoTen"]);
		unset($_SESSION["Type"]);
		// xóa cookies
		setcookie("User","",time()-3600);
		setcookie("Password","",time()-3600);
		setcookie("Type","",time()-3600);
		// chuyển đến trang login 
		header("location: login.php");
		exit();
	}
	
	// trong trường hợp đã đăng nhập, chuyển đến trang index
	if(isset($_SESSION["loggedin"])){
		header("location: index.php");
		exit();
	} 
		// trường hợp đã nhớ mật khẩu trước đó
		// gọi hàm auto_login() trong thư viện libs/common.php
		// hàm này được gọi trong file header.php để đảm bảo khi truy cập vào
		// trang nào cũng tự đăng nhập, không nhất thiết là vào login.php mới tự đăng nhập
		
		//auto_login();
		 
	 
	
	
	
	
	// trường hợp chưa đăng nhập, không lưu cookie trước đó
	// nếu người dùng nhấn nút "Đăng nhập"
	if (isset($_POST["btnDN"])){
		$user = $_POST["txtUserLogin"];
		$pass = $_POST["txtPassLogin"];
		
		
			$sql = "SELECT username as User, password as MatKhau".
				" FROM dbo_taikhoan WHERE username='".$user."' ".
					" AND password ='".$pass."'";
		
		$result = $db->query($sql);
		// nếu xác thực thành công
		if($row = $result->fetch_array()){	
			// tạo session		 
			$_SESSION["loggedin"]= true;
			$_SESSION["User"] = $row["User"];
			$_SESSION["HoTen"] = $row["User"];
			
			// nếu người dùng chọn "Nhớ mật khẩu"
			if (isset($_POST["chkNhoMK"])){
				setcookie("User",$row["User"],time()+3600*24 );
				setcookie("Password",$row["MatKhau"],time()+3600*24);
				 
			}
			header("location: index.php");
				
		}else{ // trường hợp nhập username và password không đúng
			
			// hiển thị thông báo lỗi, link đến trang đăng nhập lại
			echo "<div class='error'><br><div align='center'>Tên đăng nhập và mật khẩu không hợp lệ. <br>";
			echo " <a href='".$_SERVER["PHP_SELF"]."'> Thử lại </a> </div> </div><br>";
		}
	}else { // trong trường hợp lần đầu tiên mở form hoặc đã nhấn logout thì hiển thị form đăng nhập	
	?>	
	<div class = "header">
	<h1><a href="#" id="loginform" class = "a1">Đăng nhập</a> | <a href="#" id="regiterform">Đăng ký</a></h1>
	</div>
	<form class = "login" id="form1" name="form1" method="post" action="">
	<input placeholder="Tên đăng nhập" type="text" required="" class = "inputlogin" name="txtUserLogin">
	<input placeholder="Mật khẩu" type="password" required="" class = "inputlogin" name="txtPassLogin">
	<p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Nhớ tài khoản của tôi.
          </label>
    </p>
	<button type="submit" name = "btnDN">Đăng Nhập</button>
	</form>
	<form class = "regiter" id="form2" name="form2" method="post" action="">
	<input placeholder="Tên đăng nhập" type="text" required="" class = "inputlogin" name = "txtUserRegit">
	<input placeholder="Mật khẩu" type="password" required="" class = "inputlogin" name = "txtPassRegit">
	<input placeholder="Nhập lại mật khẩu" type="password" required="" class = "inputlogin" name = "txtPassRegitRe">
	<input placeholder="Email" type="email" required="" class = "inputlogin" name = "txtEmail">
	<p></p>
	<button type="submit" name = "btnDK">Đăng Ký</button>
	</form>
	<?php 
	} // else 
?>
</div>
 <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js/index_login.js"></script>
</body>
</div>
			
		    