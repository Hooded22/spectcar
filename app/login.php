<?php
    session_start();
    include_once "classes/Page.php";
    include_once "classes/Pdo_.php";
    function log_user_in($login,$password){
		$curl = curl_init();
		$url = 'http://localhost:9000/api/auth/login';
		$data = array('login' => $login, 'password' => $password);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		try {
			$result = json_decode(curl_exec($curl))[0];
            if(isset($result->token)) {
                return $result;
            } else {
                return null;
            }
		} catch (\Throwable $th) {
            echo $th;
			return null;
		} finally {
			curl_close($curl);
		}
		
	}

    // adding new user
    if (isset($_REQUEST['log_user_in'])) {
        $login = $_REQUEST['login'];
        $password = $_REQUEST['password'];
        $user = log_user_in($login, $password);
        if($user == null) {
            echo "Incorect login or password";
        } else {
            $_SESSION['user'] = $user;
            header("Location: http://localhost:9001/index.php");
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
    <h1> Log in</h1>
    <form method="post" action="login.php">
        <table>
            <tr>
                <td>login</td>
                <td>
                    <label for="name"></label>
                    <input required type="text" name="login" id="login" size="40" value="Test33"/>
                </td>
            </tr>
            <tr>
                <td>password</td>
                <td>
                    <label for="name"></label>
                    <input required type="text" name="password"
                    id="password" size="40" value="Test12345"/>
                </td>
            </tr>
        </table>
        <input type="submit" id= "submit" value="Log in" name="log_user_in">
    </form>
</body>
</html>