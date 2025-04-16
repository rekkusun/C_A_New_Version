<?php
session_set_cookie_params(3600);
session_start();
require 'vendor/autoload.php';

if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
}else{
    header("Location: login.php");
    exit();
}

use NumberToWords\NumberToWords;

//Instantiate the NumberToWords class
$numberToWords = new NumberToWords();

function logout(){
    $_SESSION = [];
    session_destroy();
    sleep(2);
    header('Location:login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.2/css/bulma.min.css">
    <link rel="stylesheet" href="src/styles/request.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://kit.fontawesome.com/1e5b2dce42.js" crossorigin="anonymous"></script>
    <title>SmartPark Systems Solutions Cash Advance</title>
</head>
<body>
    <nav class="level  p-5 p-4-tablet">
    <div class="level-center">
            <div class="level-item">
                <h4 class="title is-2 is-spaced custom-text-color"><?php echo "HI, ". $username?></h> 
            </div>
        </div>
        <div class="level-left">
            <p class="level-item">
                <image src="src/image/SmartPark.png" class="level-item" alt="SmartPark Logo" title="SmartPark">
            </p>
        </div>
       <div class="level-right">
            <div class="level-item">
                <form action="" method="post">
                <input type="submit" name="logout" class="button is-danger has-text-white" value="Logout">
                </form>
            </div>
       </div>
        
    </nav>

    <div class="columns is-4 p-4 is-flex-shrink-1">
        <div class="column">
        <div class="card custom-background-color">
                <div class="card-content is-flex-direction-column is-justify-content-center is-align-content-center">
                    <p class="title">
                        <p class=" title is-size-3 is-size-4-tablet has-text-centered has-text-white">100</p>
                    </p>
                    <p class="title has-text-centered is-size-4 is-size-5-tablet has-text-white p-4-tablet">
                        Total No. of Request
                    </p>
                </div>
            </div>
        </div>
        <div class="column">
        <div class="card custom-background-color">
                <div class="card-content is-flex-direction-column is-justify-content-center is-align-content-center">
                    <p class="title ">
                        <p class="title is-size-3 is-size-4-tablet has-text-centered has-text-white">100</p>
                    </p>
                    <p class="title has-text-centered is-size-4 is-size-5-tablet has-text-white p-4-tablet">
                        Approved Request
                    </p>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="card custom-background-color ">
                <div class="card-content is-flex-direction-column is-justify-content-center is-align-content-center">
                    <p class="title ">
                        <p class="title is-size-3 is-size-4-tablet has-text-centered has-text-white">100</p>
                    </p>
                    <p class=" title has-text-centered is-size-4 is-size-5-tablet has-text-white p-4-tablet">
                        Pending Requests
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="block mx-4">
    <div class="columns">
        <div class="column is-two-thirds">
            <div class="box">
            <h3 class="title is-5 custom-text-color">Pending request</h3>
                <table class="table is-fullwidth is-striped">
                    <thead>
                        <tr>
                            <th class="has-text-centered">Request Title</th>
                            <th class="has-text-centered">Request Posted</th>
                            <th class="has-text-centered">Request Status</th>
                            <th class="has-text-centered">Configuration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="has-text-centered">test1</td>
                            <td class="has-text-centered">test1</td>
                            <td class="has-text-centered">test1</td>
                            <td class="has-text-centered">test1</td>
                        </tr>
                        <tr>
                            <td class="has-text-centered">test2</td>
                            <td class="has-text-centered">test2</td>
                            <td class="has-text-centered">test2</td>
                            <td class="has-text-centered">test2</td>
                        </tr>
                    </tbody>
                </table>
                <div class="is-flex is-justify-content-end mx-5">
                <button class="button is-responsive custom-background-color has-text-white"><i class="fa-solid fa-plus"></i>&nbspAdd</button>
                </div>
                
            </div>
       
        </div>
        <div class="column">
            <div class="box">
                <h3 class="title is-5 custom-text-color">Approved requests</h3>
                <table class="table is-fullwidth is-striped">
                    <thead>
                        <tr>
                            <th class="has-text-centered">Request Title</th>
                            <th class="has-text-centered">Date Approved</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="has-text-centered">First Request</td>
                            <td class="has-text-centered">July 20, 2024</td>
                        </tr>
                        <tr>
                        <td class="has-text-centered">First Request</td>
                        <td class="has-text-centered">July 20, 2024</td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
    
    </div>
</body>
</html>
<script>
    var session = "logout()";
</script>
<?php
if(isset($_POST['logout'])){
    session_unset();
    echo '<script>
            swal({
            title: "Are you sure you want to logout?",
            icon: "warning",
            buttons: ["Cancel", "Yes, Log me out"],
            dangerMode: true,
            })
            .then((willlogout) => {
            if (willlogout) {
                 fetch("logout.php")
                        .then(() => {
                        setTimeout(()=>{
                            window.location.href = "login.php";
                        }, 2000);
                        });
            }else{}
                
            });
          </script>';
   
}
?>