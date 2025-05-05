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
            <div class="table-container">
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
                </div>
                <div class="is-flex is-justify-content-end mx-5">
                <button class="button is-responsive custom-background-color has-text-white" id="requesttrigger" data-target="request-form-modal"><i class="fa-solid fa-plus"></i>&nbspAdd</button>
                </div>     
            </div>
       
        </div>
        <div class="column">
            <div class="box">
                <h3 class="title is-5 custom-text-color">Approved requests</h3>
                <div class="table-container">
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
    </div>
    <form action="" id="requestForm" method="post">
        <div class="modal" id="requestmodal">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head">
                    <p class="modal-card-title title is-3 custom-text-color">Request Form</p>
                    <button class="delete" id="closebutton"></button>
                </header>
                <section class="modal-card-body">
                    <div class="mb-4">
                    <label for="title_request" class="title is-6 custom-text-color" require>General Purpose</label>
                    <input class="input" type="text" name="title_request" id="title_request" placeholder="Purpose of Request">
                    </div>
                    <h6 class="title is-6 custom-text-color">Breakdown of Expenses</h6>
                    <table class="table is-fullwidth" id="requesttable">
                        <thead>
                            <tr>
                            <th><abbr title="Expenses" class="is-flex is-justify-content-center">Expenses</abbr></th>
                            <th><abbr title="Amount"class="is-flex is-justify-content-center">Amount</abbr></th>
                            <th><abbr title="Configuration"class="is-flex is-justify-content-center">Configuration</abbr></th>
                            </tr>
                        </thead>
                        <tbody>    
                        </tbody>
                    </table>
                    <button type="button" class="button is-responsive custom-background-color has-text-white is-pulled-right" onclick="generatefield()"><i class="fa-solid fa-plus"></i>&nbspAdd</button>
                </section>
                <footer class="modal-card-foot is-justify-content-right">
                        <input type="submit" class="button is-success custom-background-color has-text-white" id="addbutton" name="save" value="Save"/>
                </footer>
            </div>
        </div>
    </form>
</body>
</html>
<script>
    var session = "logout()";
    var openmodal = document.getElementById('requesttrigger');
    var closemodal = document.getElementById('closebutton');
    var modal = document.getElementById('requestmodal');

openmodal.addEventListener('click',function(){
    setTimeout(()=>{
        modal.classList.add('is-active');
    });
});
closemodal.addEventListener('click', function(){
    modal.classList.add('is-closing');
    setTimeout(()=>{
        modal.classList.remove('is-active','is-closing');
    },300);
});
let count = 0;
function generatefield(){
    count++;

    var requesttable = document.getElementById('requesttable');
    var requesttablebody = document.getElementsByTagName('tbody')[2];
    
    var addrow = requesttablebody.insertRow();
    var expenses_row = addrow.insertCell(0);
    var amount_row = addrow.insertCell(1);
    var delete_row = addrow.insertCell(2);
    delete_row.style.display = "flex";
    delete_row.style.justifyContent = "center";
    delete_row.style.alignContent = "center";
    
    let expensesInput = document.createElement("input");
    expensesInput.type = "text";
    expensesInput.placeholder = "Enter Expenses here";
    expensesInput.classList.add('input', 'is-info');
    expensesInput.name = "expenses[]";

    let amountInput = document.createElement("input");
    amountInput.type= "number";
    amountInput.placeholder = "Enter amount here";
    amountInput.classList.add('input','is-info');
    amountInput.name = "amount[]";

    let delete_button = document.createElement("button");
    delete_button.classList.add('button','has-background-danger', 'mx-1','my-2', 'mobile-view');
    delete_button.title = 'Remove';
    delete_button.innerHTML ='<i class="fa-regular fa-trash-can" style="color: #ffffff;"></i>';
    delete_button.addEventListener('click', function(){
        addrow.remove();
    });

    expenses_row.appendChild(expensesInput);
    amount_row.appendChild(amountInput);
    delete_row.appendChild(delete_button);

}
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
                        }, 500);
                        });
            }else{}
                
            });
          </script>';
   
}

if (isset($_POST['save'])) {
    $title = trim($_POST['title_request']);

    if (empty($title)|| empty($_POST['expenses']) || empty($_POST['amount'])) {
        echo "<script>
                swal('Error', 'All fields are required to have inputs', 'error');
              </script>";
    } else {
        $hasemptyfield=false;
        for ($i = 0; $i < count($_POST['expenses']); $i++) {
            $expense = trim($_POST['expenses'][$i]);
            $amount = trim($_POST['amount'][$i]);

            if(empty($expense)||empty($amount)){
                $hasemptyfield = true;
                break;
            }
        }
           if($hasemptyfield){
                echo"<script>
                swal('Error', 'All fields are required to have inputs', 'error');
              </script>";
            }else{
                echo "Title Subject: " . htmlspecialchars($title) . "<br>";
                for ($i = 0; $i < count($_POST['expenses']); $i++) {  
                echo "Expense: " . htmlspecialchars($_POST['expenses'][$i]) . " - ";
                echo "Amount: " . htmlspecialchars($_POST['amount'][$i]) . "<br>";
                }
            }    
        }
    }



?>