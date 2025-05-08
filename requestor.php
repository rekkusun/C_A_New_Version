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
    <nav class="level p-4">
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
                <table class="table is-fullwidth is-striped" id="pendingtable">
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
                            <th><abbr title="Expenses" class="is-flex is-justify-content-center">Expense Summary</abbr></th>
                            <th><abbr title="Unit Price"class="is-flex is-justify-content-center">Unit Price</abbr></th>
                            <th><abbr title="Quantity"class="is-flex is-justify-content-center">Quantity</abbr></th>
                            <th><abbr title="Total Price"class="is-flex is-justify-content-center">Total Price</abbr></th>
                            <th><abbr title="Remarks"class="is-flex is-justify-content-center">Remarks</abbr></th>
                            <th><abbr title="Configuration"class="is-flex is-justify-content-center">Configuration</abbr></th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    <div class="sticky-container  is-pulled-right m-6">
                        <button type="button" class="button is-responsive custom-background-color has-text-white sticky-button" onclick="generatefield()">
                            <i class="fa-solid fa-plus"></i>&nbspAdd
                        </button>
                    </div>
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
 // Script for opening and closing the modal   
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
//function for generating a value from the javascript
function addpending(title, date, status){
    var pending_table = document.getElementById('pendingtable');
    var pending_table_body = document.getElementsByTagName('tbody')[0];
    var addrow = pending_table_body.insertRow();
    var title_row = addrow.insertCell(0);
    var request_date = addrow.insertCell(1);
    var request_status = addrow.insertCell(2);
    var request_config = addrow.insertCell(3);

    title_row.classList.add('has-text-centered');
    title_row.innerHTML = title;
    request_date.classList.add('has-text-centered');
    request_date.innerHTML = date;
    request_status.classList.add('has-text-centered');
    request_status.innerHTML = status;

    var remarksdiv = document.createElement("div");
    remarksdiv.classList.add('is-flex','is-justify-content-space-around','is-align-items-center');
    remarksdiv.style.gap = "0.25rem";
    var buttonClasses = ['button', 'is-small', 'is-flex', 'is-align-items-center'];
    var view_button = document.createElement("button");
    view_button.classList.add(...buttonClasses,'is-link');
    view_button.innerHTML = '<div class="is-flex is-flex-direction-column"><i class="fa-solid fa-envelope-open-text" style="color: #ffffff;"></i><span class="has-text-white">View</span></div>';
    view_button.title = "View";
    view_button.addEventListener("click", function(){
        swal({
            title: "File Opened",
            text: "You open the file",
            icon: "success",
            button: "Okay",
        });
    });

    var edit_button = document.createElement("button");
    edit_button.classList.add(...buttonClasses,'is-warning');
    edit_button.innerHTML = '<div class="is-flex is-flex-direction-column"><i class="fa-solid fa-file-pen" style="color: #ffffff;"></i><span class="has-text-white">Edit</span></div>';
    edit_button.title = "Edit";
    edit_button.addEventListener("click",function(){
        swal({
            title: "File Edited",
            text: "You open the file",
            icon: "success",
            button: "Okay",
        });
    });

    var delete_button = document.createElement("button");
    delete_button.classList.add(...buttonClasses, 'is-danger');
    delete_button.innerHTML = '<div class="is-flex is-flex-direction-column"><i class="fa-regular fa-trash-can" style="color: #ffffff;"></i><span class="has-text-white">Delete</span></div>';
    delete_button.title = "Delete";
    delete_button.addEventListener("click", function(){
        swal({
            title: "File Deleted",
            text: "You deleted the file",
            icon: "warning",
            button: "Okay",
        });
    });
    remarksdiv.appendChild(view_button);
    remarksdiv.appendChild(edit_button);
    remarksdiv.appendChild(delete_button);
    request_config.appendChild(remarksdiv);
}
//function for generating a new field for specific expenses and amount
function generatefield(){
    var requesttable = document.getElementById('requesttable');
    var requesttablebody = document.getElementsByTagName('tbody')[2];
    
    var addrow = requesttablebody.insertRow();
    var expenses_row = addrow.insertCell(0);
    var unit_amount_row = addrow.insertCell(1);
    var quantity_row = addrow.insertCell(2);
    var total_price_row = addrow.insertCell(3);
    var remarks_row = addrow.insertCell(4);
    var delete_row = addrow.insertCell(5);

    delete_row.style.display = "flex";
    delete_row.style.justifyContent = "center";
    delete_row.style.alignContent = "center";
    
    let expensesInput = document.createElement("input");
    expensesInput.type = "text";
    expensesInput.placeholder = "Enter Expenses here";
    expensesInput.classList.add('input', 'is-info');
    expensesInput.name = "expenses[]";

    let unit_amount = document.createElement("input");
    unit_amount.type= "number";
    unit_amount.placeholder = "Enter amount here";
    unit_amount.classList.add('input','is-info');
    unit_amount.name = "amount[]";

    let quantity = document.createElement("input");
    quantity.type="number";
    quantity.value = 1;
    quantity.min = "1";
    quantity.classList.add('input','is-info');
    quantity.name="quantity[]";

    let Total_price = document.createElement("input");
    Total_price.type = "number"
    Total_price.readOnly = true;
    Total_price.classList.add('input','is-info');
    Total_price.name = "Total_price[]";

    let explanation = document.createElement("input");
    explanation.type = "text";
    explanation.classList.add('input','is-info');
    explanation.placeholder = "Provide details here";
    explanation.name = "explanation[]";

    let delete_button = document.createElement("button");
    delete_button.classList.add('button','has-background-danger', 'mx-1','my-2', 'mobile-view');
    delete_button.title = 'Remove';
    delete_button.innerHTML ='<i class="fa-regular fa-trash-can" style="color: #ffffff;"></i>';
    delete_button.addEventListener('click', function(){
        addrow.remove();
    });

    unit_amount.addEventListener("input", updateTotal);
    quantity.addEventListener("input", updateTotal);

    unit_amount.addEventListener("input",function(){
        if(this.value<0){
            this.value = 0;
        };
        updateTotal();
    })
    quantity.addEventListener("input", function(){
        if(this.value <= 0){
            this.value = 1;
        }
        updateTotal(); 
    });

    function updateTotal() {
        let price = parseFloat(unit_amount.value) || 0;
        let piece = parseFloat(quantity.value) || 1;
        Total_price.value = price * piece;
    }

    expenses_row.appendChild(expensesInput);
    unit_amount_row.appendChild(unit_amount);
    quantity_row.appendChild(quantity);
    total_price_row.appendChild(Total_price);
    remarks_row.appendChild(explanation);
    delete_row.appendChild(delete_button);

    updateTotal(); // Initialize total price correctly
}

   
    //To still make interaction when Enter button is clicked
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

    //For avoiding form resubmission when page refresh
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<?php
//Fetching Pending Request
$fetch_pending = "SELECT * FROM tbl_request WHERE request_status = :status_request AND deleted = :deleted_file ORDER BY request_date DESC";
$prepare_pending_request = $conn->prepare($fetch_pending);
$prepare_pending_request->bindValue(':status_request',"Pending Review");
$prepare_pending_request ->bindValue(':deleted_file',false);
$prepare_pending_request->execute();
$rows = $prepare_pending_request->fetchAll(PDO::FETCH_ASSOC);
foreach($rows as $row){
   echo "<script>
        addpending('" . addslashes($row['request_title']) . "', 
                   '" . addslashes($row['request_date']) . "', 
                   '" . addslashes($row['request_status']) . "');
        </script>";
}

//User_Logout
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
//Performing Request
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
                for ($count_amount = 0; $count_amount < count($_POST['Total_price']); $count_amount++) {
                    $_POST['Total_price'][$count_amount] = filter_var($_POST['Total_price'][$count_amount], FILTER_SANITIZE_NUMBER_INT);
                    $total += (int) $_POST['Total_price'][$count_amount];
                }
                $date_today = date("Y-m-d");
                $status = "Pending Review";
                $deleted = 0;
                $sql_insert_title = "INSERT INTO tbl_request (request_title, request_total_amount, request_date, requestor_id,request_status,deleted) VALUES(:title, :amount, :date_posted, :requestor, :status_request,:deleted)";
                $prepare_tbl_request = $conn->prepare($sql_insert_title);
                $prepare_tbl_request->bindParam(':title',$request_title);
                $prepare_tbl_request->bindParam(':amount',$total);
                $prepare_tbl_request->bindParam(':date_posted',$date_today);
                $prepare_tbl_request->bindParam(':requestor', $current_user);
                $prepare_tbl_request->bindParam(':status_request',$status);
                $prepare_tbl_request->bindParam(':deleted',$deleted);
                $prepare_tbl_request->execute();


                $sql_fetch_request_id = "SELECT request_id FROM tbl_request WHERE request_title = :title_request";
                $fetch_request_id = $conn ->prepare($sql_fetch_request_id);
                $fetch_request_id->bindParam(':title_request',$request_title);
                $fetch_request_id->execute();
                $fetch_id = $fetch_request_id->fetch(PDO::FETCH_ASSOC);
                $fetch_request_id = $fetch_id['request_id']; 

                for ($i = 0; $i < count($_POST['expenses']); $i++) {
                    echo $_POST['Total_Price'][$i];
                 $sql_insert_breakdown = "INSERT INTO Request_Breakdown (request_breakdown_description, request_unit_price, request_quantity, request_breakdown_amount, request_title_id, request_brief_description) VALUES(:request_description, :request_unit_price, :request_quantity, :request_description_amount, :request_title_id, :request_brief_description)";
                 $prepare_breakdown_request = $conn->prepare($sql_insert_breakdown);
                 $prepare_breakdown_request ->bindParam(':request_description',$_POST['expenses'][$i]);
                 $prepare_breakdown_request -> bindParam(':request_unit_price',$_POST['amount'][$i]);
                 $prepare_breakdown_request -> bindParam(':request_quantity', $_POST['quantity'][$i]);
                 $prepare_breakdown_request ->bindParam(':request_description_amount', $_POST['Total_Price'][$i]);
                 $prepare_breakdown_request ->bindParam(':request_title_id', $fetch_request_id);
                 $prepare_breakdown_request ->bindParam(':request_brief_description', $_POST['explanation'][$i]);
                 $prepare_breakdown_request ->execute();
                }
                //Displaying a success message and updating the table content
                echo "<script>
                            swal('Success!', 'Your Request Has Been Uploaded!', 'success')
                            .then(() => {
                                window.location.href = 'requestor.php';
                            });
                        </script>";
                $conn = null;
                }catch(PDOException $e){
                    echo "<script>
                            swal('Error Inserting', 'Failed to Upload Request', 'error');
                          </script>";

                    echo $e->getMessage();
                    
                }
            }    
        }
        
    }

?>