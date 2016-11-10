<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<?php session_start();?>
<html>
<head>
 <title>TRẮC NGHIỆM TRỰC TUYẾN</title>    
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
 <link href="css/login.css" rel="stylesheet" type="text/css"/>
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
		unset($_SESSION["User"]);
		// xóa cookies
		setcookie("User","",time()-3600);
		setcookie("Password","",time()-3600);
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
	// trường hợp chưa đăng nhập, không lưu cookie trước đó
	// nếu người dùng nhấn nút "Đăng nhập"
	if (isset($_POST["btnDN"])){
		$user = $_POST["txtUserLogin"];
		$pass = $_POST["txtPassLogin"];
		
		
			$sql = "SELECT username as User, password as MatKhau".
				" FROM dbo_taikhoan WHERE username='".$user."' ".
					" AND password ='".md5($pass)."'";
		
		$result = $db->query($sql);
		// nếu xác thực thành công
		if($row = $result->fetch_array()){	
			// tạo session		 
			$_SESSION["loggedin"]= true;
			$_SESSION["User"] = $row["User"];
			$_SESSION["HoTen"] = $row["User"];
			
			// nếu người dùng chọn "Nhớ mật khẩu"
			if (isset($_POST["remember_me"])){
				setcookie("User",$row["User"],time()+3600*24 );
				setcookie("Password",$row["MatKhau"],time()+3600*24);
				 
			}
			header("location: index.php");
				
		}else{ // trường hợp nhập username và password không đúng
			
			// hiển thị thông báo lỗi
			echo "<p class='error'>
					<label>
						Tên đăng nhập hoặc mật khẩu không đúng.
					</label>
				</p><br><br>";
		}
	}	
	
	//Nếu người dùng nhấn đăng ký
	if (isset($_POST["btnDK"])){
		$userRe = $_POST["txtUserRegit"];
		$passRe = $_POST["txtPassRegit"];
		$passRe2 = $_POST["txtPassRegitRe"];
		$email 	= $_POST["txtEmail"];
		
			$sql = "INSERT INTO dbo_taikhoan (username, password, email, admin_permission, status, tra_loi_dung, tra_loi_sai)". 
					"VALUES ('".$userRe."','".md5($passRe)."','".$email."','0','0','0','0')";
					
			$sql_test_user_name = "SELECT username".
				" FROM dbo_taikhoan WHERE username='".$userRe."' ";
		
		//nếu nhập ko trùng pass
		if($passRe != $passRe2){
			// hiển thị thông báo lỗi
			echo "<p class='error'>
					<label>
						Không khớp mật khẩu, vui lòng nhập lại.
					</label>
				</p><br><br>";
		}
		else{
			$result = $db->query($sql_test_user_name);
		// nếu đã tồn tại tên đăng nhập
		if($result->num_rows > 0){	
			echo "<p class='error'>
					<label>
						 Tên đăng nhập đã tồn tại.
					</label>
				</p><br><br>";
		}else{
			if($db->query($sql)== TRUE){
					echo 	"<script language='javascript'>
								alert('Tạo tài khoản thành công. Đăng nhập bằng tài khoản bạn vừa tạo. =v= ');
							</script>";
			}
			else{
				echo "<p class='error'>
					<label>
						  Có lỗi xảy ra, hãy liên hệ với admin.".$sql."
					</label>
				</p><br><br>";
			}
		}
		}
	}	
	?>
</div>
 <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src="js/index_login.js"></script>
</body>
</html>
			
		    