<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartPark Systems Solutions Cash Advance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="src/styles/style.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript">
        function handleEnter(event) {
    if (event.key === 'Enter') {
      event.preventDefault();

      // Retrieve form inputs
      let email = document.querySelector('input[name="email"]').value.trim();
      let password = document.querySelector('input[name="password"]').value.trim();

      // Validate inputs
      if (!email || !password) {
        swal('Error', 'All fields are required!', 'error'); // SweetAlert for errors
      } else {
        document.getElementById('loginform').submit();
      }
    }
  }

  // Add event listener to trigger handleEnter
  document.addEventListener('keydown', handleEnter);
    </script>
  </head>
<body>
    <div class="section columns custom-background-color p-1 border-radius-customize">
        <div class="p-6 column is-half has-background-white border-radius-customize-inner">
            <div class="contents">
                <div class="field is-flex is-justify-content-center is-align-item-center">
                    <div class="control">
                    <img src="src/image/SmartPark.png" title="SmartPark" alt="SmartPark Logo">  
                    </div>
                </div>
            </div>
            <div class="contents">
                <div class="field is-flex is-justify-content-center is-align-item-center my-3">
                    <div class="control">
                    <h3 class="is-size-3 has-text-weight-bold custom-text-color"><center>LOG IN</center></h3>  
                    </div>
                </div>
            </div>
                <div class="field">
                  <div class="control">
                        <form action="login.php" method="post" id="loginform">
                            <div class="field">
                              <label for="email" class="label">Email</label>
                              <div class="control">
                                <input type="email" class="input mb-3 is-link" name="email" placeholder="Enter email" autocomplete="off">
                              </div>
                            </div>
                            <div class="field">
                              <label for="password" class="label">Password</label>
                              <div class="control">
                                <input type="password" class="input is-link" name="password" placeholder="Enter password" autocomplete="off"> 
                              </div>
                            </div>
                            <div class="field">
                              <div class="control">
                              <button class="button is-ghost">Forgot Password?</button>
                              </div>
                            </div>
                            <div class="field">
                              <div class="control is-flex is-justify-content-center">
                                <input type="submit" name="login" class="button custom-background-color has-text-white is-size-6 mb-3" value="Log in">
                              </div>
                            </div>
                        </form> 
                  </div>
                </div>
          </div>   
          <div class="column is-half is-hidden-mobile is-flex is-justify-content-center is-align-items-center">
              <h3 class="has-text-white is-size-3 is-centered has-text-weight-bold"><center>Cash Advance Request System</center></h3>
            </div>            
    </div>  
</body>
</html>
<?php
session_start();
$servername = "127.0.0.1,3304";
$conn = new PDO("sqlsrv:server=$servername; Database=C_A", 'root','jeff');

if((isset($_POST['login'])&& $_SERVER['REQUEST_METHOD']=='POST')|| isset($_REQUEST['login'])){
  $email = $_POST['email'];
  $password = $_POST['password'];
    if(!empty($email) && !empty($password)){
      $stmtdata = $conn->prepare("SELECT user_email, user_password, user_fname FROM USERS WHERE user_email=:acc_email");
      $stmtdata->bindValue(":acc_email", $email, PDO::PARAM_STR);
      $stmtdata->execute();
      $user =$stmtdata->fetch(PDO::FETCH_ASSOC);

      if($user){
        if($email == $user['user_email'] && $password == $user['user_password']){
          $_SESSION['username'] = $user['user_fname'];
            sleep(1);
            header("Location: requestor.php");
            exit();
        }else {
          $_SESSION['error'] = "Invalid credentials"; 
          echo "<script>
                  swal('Error Login', 'Invalid credentials!', 'error');
                </script>";
      }
      }else{
        $_SESSION['error'] = "Invalid credentials";
        echo "<script>
                  swal('Error Login', 'Account does not exist!', 'error');
                </script>";
      }
    }else{
      $_SESSION['error'] = 'Invalid Credentials';
      echo "<script>
                  swal('Error Login', 'All fields are required to have inputs', 'error');
              </script>";
      header("Location : login.php");
    }
      
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if(!empty($email) && !empty($password)){
      $stmtdata = $conn->prepare("SELECT user_email, user_password, user_fname FROM USERS WHERE user_email=:acc_email");
      $stmtdata->bindValue(":acc_email", $email, PDO::PARAM_STR);
      $stmtdata->execute();
      $user =$stmtdata->fetch(PDO::FETCH_ASSOC);
      $name = $user['user_fname'];
      if($user){
        if($email == $user['user_email'] && $password == $user['user_password']){
          $_SESSION['username'] = $name;
            sleep(1);
            header("Location: requestor.php");
            exit();
        }else {
          $_SESSION['error'] = "Invalid credentials"; 
          echo "<script>
                  swal('Error Login', 'Invalid credentials!', 'error');
                </script>";
      }
      }else{
        $_SESSION['error'] = "Invalid credentials";
        echo "<script>
                  swal('Error Login', 'Account does not exist!', 'error');
                </script>";
      }
    }else{
      $_SESSION['error'] = 'Invalid Credentials';
      echo "<script>
                  swal('Error Login', 'All fields are required to have inputs', 'error');
              </script>";
      header("Location : login.php");
    }
}

?>

