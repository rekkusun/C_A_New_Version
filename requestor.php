<?php
session_set_cookie_params(3600);
session_start();
require 'vendor/autoload.php';
$servername = "127.0.0.1,3304";
$conn = new PDO("sqlsrv:server=$servername; Database=C_A", 'root','jeff');
if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
if(isset($_SESSION['username'])){
    $username = $_SESSION['username'];
    $sql = "SELECT id_user FROM USERS WHERE user_fname = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username',$username);
    $stmt->execute();
    $user_id = $stmt->fetch(PDO::FETCH_ASSOC);
    $current_user = $user_id['id_user'];
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
}?>
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

    <nav class="level  p-4">
            <div class="level-center">
                <div class="level-item">
                    <h4 class="title is-2 is-5-mobile is-spaced custom-text-color"><?php echo "HI, ". $username?></h> 
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

    <div class="columns is-4 p-4">
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
    <div class="block p-4">
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
                        
                    </tbody>
                </table>
                </div>
                <div class="is-flex is-justify-content-end mx-5 mx-3-mobile">
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
   
    function EnterButton(event){
        if(event.key ==='Enter'){
            let expensesCount = document.querySelectorAll('input[name="expenses[]"]');
            let amountCount = document.querySelectorAll('input[name="amount[]"]');
           const expenses_count = expensesCount.length;
           const amount_count = amountCount.length;

            let form = document.getElementById('addbutton');
            if(form && form.tagName === 'FORM'){
                event.preventDefault();
                form.submit();
            }
        }    
    }
    document.addEventListener('keydown', EnterButton);
    document.getElementById('addbutton').addEventListener("click",function(){
        location.reload();
    });
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
                        }, 800);
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
    }else {
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
                try{
                    $request_title = htmlspecialchars($title);
                    $total = 0;
                for ($count_amount = 0; $count_amount < count($_POST['amount']); $count_amount++) {
                    $_POST['amount'][$count_amount] = filter_var($_POST['amount'][$count_amount], FILTER_SANITIZE_NUMBER_INT);
                    $total += (int) $_POST['amount'][$count_amount];
                }
                $date_today = date("Y-m-d");
                $status = "Pending Review";
                $sql_insert_title = "INSERT INTO tbl_request (request_title, request_total_amount, request_date, requestor_id,request_status) VALUES(:title, :amount, :date_posted, :requestor, :status_request)";
                $prepare_tbl_request = $conn->prepare($sql_insert_title);
                $prepare_tbl_request->bindParam(':title',$request_title);
                $prepare_tbl_request->bindParam(':amount',$total);
                $prepare_tbl_request->bindParam(':date_posted',$date_today);
                $prepare_tbl_request->bindParam(':requestor', $current_user);
                $prepare_tbl_request->bindParam(':status_request',$status);
                $prepare_tbl_request->execute();

                $sql_fetch_request_id = "SELECT request_id FROM tbl_request WHERE request_title = :title_request";
                $fetch_request_id = $conn ->prepare($sql_fetch_request_id);
                $fetch_request_id->bindParam(':title_request',$request_title);
                $fetch_request_id->execute();
                $fetch_id = $fetch_request_id->fetch(PDO::FETCH_ASSOC);
                $fetch_request_id = $fetch_id['request_id']; 

                for ($i = 0; $i < count($_POST['expenses']); $i++) {
                 $sql_insert_breakdown = "INSERT INTO Request_Breakdown (request_breakdown_description, request_breakdown_amount, request_title_id) VALUES(:request_description, :request_description_amount, :request_title_id)";
                 $prepare_breakdown_request = $conn->prepare($sql_insert_breakdown);
                 $prepare_breakdown_request ->bindParam(':request_description',$_POST['expenses'][$i]);
                 $prepare_breakdown_request ->bindParam(':request_description_amount', $_POST['amount'][$i]);
                 $prepare_breakdown_request ->bindParam(':request_title_id', $fetch_request_id);
                 $prepare_breakdown_request ->execute();
                }
                echo "<script>swal('Success!', 'Your Request Has Been Uploaded!', 'success');</script>";
                $conn = null;
                }catch(PDOException $e){
                    echo "<script>
                            swal('Error Inserting', 'Failed to Upload Request', 'error');
                          </script>";
                }
            }    
        }
        
    }

?>