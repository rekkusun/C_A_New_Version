<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartPark Systems Solutions Cash Advance</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="src/styles/style.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  </head>
<body>
    <div class="section columns custom-background-color p-1 border-radius-customize">
        <div class="p-6 column is-half has-background-white border-radius-customize-inner">
            <div class="contents">
                <div class="field is-flex is-justify-content-center is-align-item-center">
                    <div class="control">
                    <img src="src/image/SmartPark.png">  
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
                        <form action="" method="post">
                            <div class="field">
                              <label for="email">Email</label>
                              <div class="control">
                                <input type="email" class="input mb-3 is-link" name="email" placeholder="Enter email">
                              </div>
                            </div>
                            <div class="field">
                              <label for="password">Password</label>
                              <div class="control">
                                <input type="password" class="input is-link" name="password" placeholder="Enter password">
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
$servername = "127.0.0.1, 3304";
$conn = new PDO("sqlsrv:server=$servername; Database=C_A", 'root','jeff');

if(isset($_POST['login'])){
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmtemail = $conn->prepare("SELECT * FROM USERS WHERE user_email=:acc_email");
  $stmtemail->bindValue(":acc_email", $email);
  $stmtemail->execute();
  $fetched_email = $stmtemail->fetchColumn();

  if(isset($_POST['email'])==$fetched_email){
    $stmtpassword = $conn->prepare("SELECT * FROM USERS WHERE user_password=:acc_password");
    $stmtpassword->bindValue(":acc_password", $password);
    $stmtpassword->execute();
    $fetched_password = $stmtpassword->fetchColumn();
      if(isset($_POST['password'])==$fetched_password){
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;
        header("Location:requestor.php");
        exit;
      }else{
        echo "<script>
                 swal('Error Login','Invalid Email', 'error');
              </script>";
      }
  }else{
    echo "<script>
              swal('Error Login','Invalid Email', 'error');
          </script>";
  }
}

if(isset($_SESSION['email'])){
  unset($_SESSION['email']); unset($_SESSION['password']);
}
?>