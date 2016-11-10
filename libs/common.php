<?php

function auto_login(){
		$db = $GLOBALS["db"];
	if (isset($_COOKIE["User"]) && isset($_COOKIE["Password"])){
		$user = $_COOKIE["User"];
		$pass = $_COOKIE["Password"];
			
		$sql = "SELECT username as User, password as MatKhau".
				" FROM dbo_taikhoan WHERE username='".$user."' ".
					" AND password ='".$pass."'";
					
		$result = $db->query($sql);
		// nếu xác thực thành công
		if($row = $result->fetch_array()){
	
			// tạo lại session
			$_SESSION["loggedin"]= true;
			$_SESSION["User"] = $row["User"];
			$_SESSION["HoTen"] = $row["User"];
		
			// đặt lại cookie với thời gian mới
			setcookie("User",$row["User"],time()+3600*24 );
			setcookie("Password",$row["MatKhau"],time()+3600*24);
				
			header("location: index.php");
				
		}else{
			// xác thực không thành công, xóa cookie đã lưu
			setcookie("User","",time()-3600);
			setcookie("Password","",time()-3600);
			Header("Location: login.php");
		}
	}
	else{
			Header("Location: login.php");
		}
}
?>