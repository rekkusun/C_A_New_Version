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

//Fetching the count of the total number of request
$fetch_no_request_count = "SELECT COUNT(*) FROM tbl_request WHERE deleted = :deleted";
$prepare_count_request = $conn -> prepare($fetch_no_request_count);
$prepare_count_request -> bindValue(':deleted',false);
$prepare_count_request->execute();
$count_of_request = $prepare_count_request->fetchColumn();

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
    <!--script type="text/javascript" src="/path/to/numberToWords.min.js"></script-->
    <title>SmartPark Systems Solutions Cash Advance</title>
</head>
<body>
    <nav class="level p-4">
            <div class="level-center">
                <div class="level-item">
                    <h4 class="title is-2 is-5-mobile is-spaced custom-text-color"><?php echo "HI, ". $username?></> 
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
                        <p class=" title is-size-3 is-size-4-tablet has-text-centered has-text-white"><?php echo $count_of_request?></p>
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
                <table class="table is-fullwidth is-striped is-hoverable" id="pendingtable">
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
                    <table class="table is-fullwidth is-hoverable is-striped">
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
    <!--Create Request Modal-->
    <form action="" id="requestForm" method="post">
        <div class="modal" id="requestmodal">
            <div class="modal-background"></div>
            <div class="modal-card card_modal">
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
                    <table class="table is-fullwidth is-hoverable" id="requesttable">
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
                <footer class="modal-card-foot">
                        <input type="submit" class="button is-success custom-background-color has-text-white" id="addbutton" name="save" value="Save"/>
                </footer>
            </div>
        </div>
    </form>
    <!--View modal-->
    <div class="modal" id="view_request">
        <div class="modal-background"></div>
        <div class="modal-card card_modal">
        <header class="modal-card-head">
            <p class="modal-card-title title is-3 custom-text-color" id="title_view"></p>
            <button class="delete" id="close_button"></button>
        </header>
        <section class="modal-card-body">
            <p class="title is-5">Requested Amount</p>
            <div class="m-4">
                <p class="title is-6">Amount in words: </p>
                <p class="subtitle is-6 ml-5 has-text-weight-medium mb-3" id="amount_words"></p>
                <p class="title is-6">Amount in number:  </p>
                <p class="subtitle is-6 ml-5 has-text-weight-medium" id="amount_number"></p>
            </div>
            <p class="title is-5 mt-4">Breakdown of Expenses</p>
                <table class="table is-fullwidth is-hoverable is-striped" id="view_table">
                    <thead>
                        <tr>
                            <th><abbr title="Purpose" class="is-flex is-justify-content-center">Purpose</abbr></th>
                            <th><abbr title="Unit Price"class="is-flex is-justify-content-center">Unit Price</abbr></th>
                            <th><abbr title="Quantity"class="is-flex is-justify-content-center">Quantity</abbr></th>
                            <th><abbr title="Total Price"class="is-flex is-justify-content-center">Total Price</abbr></th>
                            <th><abbr title="Description"class="is-flex is-justify-content-center">Description</abbr></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
        </section>
        <footer class="modal-card-foot" id="viewing_footer">
            <button type="button" class="button is-responsive custom-background-color has-text-white" name="edit_modal_open">
                <i class="fa-solid fa-file-pen" style="color: #ffffff;"></i>&nbsp&nbspEdit
            </button>
        </footer>
        </div>
    </div>
    <!--Edit modal-->
    <form action="" method="post" id="edit_request_form">
        <div class="modal" id="edit_modal">
            <div class="modal-background"></div>
            <div class="modal-card card_modal">
                <header class="modal-card-head">
                    <div class="modal-card-title">
                    <input type="text" class="input is-large is-info title is-3 custom-text-color"id="edit_title">
                    </div>
                    <!--p class="modal-card-title title is-3 custom-text-color" id="edit_title"></p-->
                    <button class="delete" id="close_edit_button"></button>
                </header>
                <section class="modal-card-body">
                    <p class="title is-5">Requested Amount</p>
                    <div class="m-4">
                        <p class="title is-6">Amount in words: </p>
                        <p class="subtitle is-6 ml-5 has-text-weight-medium mb-3" id="amount_words_edit"></p>
                        <p class="title is-6">Amount in number:  </p>
                        <p class="subtitle is-6 ml-5 has-text-weight-medium" id="amount_number_edit"></p>
                    </div>
                    <table class="table is-fullwidth is-striped is-hoverable" id="edit_table">
                        <thead>
                            <tr>
                                <th><abbr title="Purpose" class="is-flex is-justify-content-center">Purpose</abbr></th>
                                <th><abbr title="Unit Price"class="is-flex is-justify-content-center">Unit Price</abbr></th>
                                <th><abbr title="Quantity"class="is-flex is-justify-content-center">Quantity</abbr></th>
                                <th><abbr title="Total Price"class="is-flex is-justify-content-center">Total Price</abbr></th>
                                <th><abbr title="Description"class="is-flex is-justify-content-center">Description</abbr></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </section>
                <footer class="modal-card-foot">
                    <button type="button" class="button is-reponsive custom-background-color has-text-white">
                    <i class="fa-solid fa-floppy-disk" style="color: #ffffff;"></i>&nbsp&nbspSave
                    </button>
                </footer>
            </div>
        </div>
    </form>
</body>
</html>
<!--End of html-->

<script>

var button_edit = document.querySelector('[name=edit_modal_open]');

//For Edit Modal   
var edit_modal_close = document.getElementById('close_edit_button');
var open_edit_modal = document.getElementById('edit_modal');

edit_modal_close.addEventListener('click',function(){
    open_edit_modal.classList.add('is-closing');
    setTimeout(()=>{
        open_edit_modal.classList.remove('is-active','is-closing');
    },300);
});

//initialized the modal for viewing globally to be accessible also by php  
var close_modal_view = document.getElementById('close_button');
var open_view_modal_view_request = document.getElementById('view_request');

close_modal_view.addEventListener('click',function(){
    open_view_modal_view_request.classList.add('is-closing');
    setTimeout(()=>{
        open_view_modal_view_request.classList.remove('is-active','is-closing');
    },300);
});



// Script for opening and closing the modal   
var openmodal = document.getElementById('requesttrigger');
var closemodal = document.getElementById('closebutton');
var modal = document.getElementById('requestmodal');
   
openmodal.addEventListener('click',function(){
    setTimeout(()=>{
       modal.classList.add('is-active');
    },500);
});
closemodal.addEventListener('click', function(){
    modal.classList.add('is-closing');
    setTimeout(()=>{
        modal.classList.remove('is-active','is-closing');
    },500);
});

//function for generating a value from the javascript
function addpending(title, date, request_id, status){
    var pending_table = document.getElementById('pendingtable');
    var pending_table_body = document.getElementsByTagName('tbody')[0];
    var addrow = pending_table_body.insertRow();

    var title_row = addrow.insertCell(0);
    var request_date = addrow.insertCell(1);
    var request_status = addrow.insertCell(2);
    var request_config = addrow.insertCell(3);

    //assigning an id to the button 
    button_edit.id="button_edit_view["+request_id+"]";
    
    title_row.classList.add('has-text-centered');
    title_row.innerHTML = title;
    request_date.classList.add('has-text-centered');
    request_date.innerHTML = date;
    
    request_status_display = document.createElement("span");
    request_status_display.classList.add('tag', 'is-primary','has-text-white');
    request_status_display.textContent = status;

    request_status.classList.add('has-text-centered');
    request_status.appendChild(request_status_display);

    var remarksdiv = document.createElement("div");
    remarksdiv.classList.add('is-flex','is-justify-content-space-around','is-align-items-center');
    remarksdiv.style.gap = "0.25rem";
    var buttonClasses = ['button', 'is-small', 'is-flex', 'is-align-items-center'];
   
    let create_view_form = document.createElement("form");
    create_view_form.action="";
    create_view_form.method="post";
    create_view_form.id="view_form";

    var view_button = document.createElement("button");
    view_button.classList.add(...buttonClasses,'is-link');
    view_button.innerHTML = '<div class="is-flex is-flex-direction-column"><i class="fa-solid fa-envelope-open-text" style="color: #ffffff;"></i><span class="has-text-white">View</span></div>';
    view_button.title = "View";
    view_button.name = "view_button["+request_id+"]";
    view_button.type="submit";
    create_view_form.appendChild(view_button);

    let edit_view_form = document.createElement("form");
    edit_view_form.action="";
    edit_view_form.method ="post";
    edit_view_form.id="edit_form";

    var edit_button = document.createElement("button");
    edit_button.classList.add(...buttonClasses,'is-warning');
    edit_button.innerHTML = '<div class="is-flex is-flex-direction-column"><i class="fa-solid fa-file-pen" style="color: #ffffff;"></i><span class="has-text-white">Edit</span></div>';
    edit_button.title = "Edit";
    edit_button.type="submit";
    edit_button.name="edit_button["+request_id+"]";
    edit_view_form.appendChild(edit_button);

    //This is for creating a delete form
    let create_delete_form = document.createElement("form");
    create_delete_form.method = "post";
    create_delete_form.action = "";
    create_delete_form.id="delete_form"

    var delete_button = document.createElement("button");
    delete_button.classList.add(...buttonClasses, 'is-danger');
    delete_button.innerHTML = '<div class="is-flex is-flex-direction-column"><i class="fa-regular fa-trash-can" style="color: #ffffff;"></i><span class="has-text-white">Delete</span></div>';
    delete_button.title = "Delete";
    delete_button.type = "submit";
    delete_button.name = "delete_button["+request_id+"]";
    delete_button.addEventListener("click",function(event){
        event.preventDefault(); 
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this request!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                let form = document.createElement("form");
                form.method="post";
                form.action="";
                
                let hiddeninput = document.createElement("input");
                hiddeninput.type="hidden";
                hiddeninput.name = "delete_button["+request_id+"]";
                hiddeninput.value = request_id;

                form.appendChild(hiddeninput);
                document.body.appendChild(form);
                form.submit();
            } else {}
            });
    });
    create_delete_form.appendChild(delete_button);

    remarksdiv.appendChild(create_view_form);
    remarksdiv.appendChild(edit_view_form);
    remarksdiv.appendChild(create_delete_form);
    request_config.appendChild(remarksdiv);
}

//function for inserting contents for the table in view request
function display_information(purpose, unit_price, quantity, total, description){
   //verfiying if table exist
    var view_table = document.getElementById('view_table');
    if (!view_table) {
        console.error("Table with ID 'view_table' not found.");
        return;
    }
  // verifying if table body exist
    var view_table_body = document.getElementsByTagName('tbody')[3];
    if (!view_table_body) {
        console.error("No <tbody> found inside 'view_table'.");
        return;
    }

    var add_row = view_table_body.insertRow();

    var purpose_row = add_row.insertCell(0);
    var unit_price_row = add_row.insertCell(1);
    var quantity_row = add_row.insertCell(2);
    var total_row = add_row.insertCell(3);
    var description_row = add_row.insertCell(4);

    purpose_row.classList.add('has-text-centered', 'custom-text-color');
    purpose_row.innerHTML=purpose;

    unit_price_row.classList.add('has-text-centered', 'custom-text-color');
    unit_price_row.innerHTML=unit_price;

    quantity_row.classList.add('has-text-centered','custom-text-color');
    quantity_row.innerHTML=quantity;

    total_row.classList.add('has-text-centered','custom-text-color');
    total_row.innerHTML=total;

    description_row.classList.add('has-text-centered','custom-text-color');
    description_row.innerHTML=description;
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
    delete_button.name = "delete_row";
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
/*function assign_button(id){
    <button type="button" class="button is-responsive custom-background-color has-text-white" name="edit_modal_open">
        <i class="fa-solid fa-file-pen" style="color: #ffffff;"></i>&nbsp&nbspEdit
    </button>

    var get_view_footer = document.getElementById('viewing_footer');
    var create_button = document.createElement("button");
    
}
   */
//To still make interaction whenever the user presses the enter button
function EnterButton(event){
        if(event.key ==='Enter'){
            let expensesCount = document.querySelectorAll('input[name="expenses[]"]');
            let amountCount = document.querySelectorAll('input[name="Total_price[]"]');
            let unitamountCount = document.querySelectorAll('input[name="amount[]"]');
            let quantityCount = document.querySelectorAll('input[name="quantity[]"]');
            let explanationCount = document.querySelectorAll('input[name="explanation[]"]');
           const expenses_count = expensesCount.length;
           const Total_price = amountCount.length;
           const unit_amount_count = unitamountCount.length;
           const quantity_count = quantityCount.length;
           const explanation_count = explanationCount.length;

            let form = document.getElementById('addbutton');
            if(form && form.tagName === 'FORM'){
                event.preventDefault();
                form.submit();
            }
        }    
}
document.addEventListener('keydown', EnterButton);

//function for setting modal_title and total amount
function insert_text(amount, amount_in_words, title){
    var get_title_view = document.getElementById('title_view');
    var get_amount_words = document.getElementById('amount_words');
    var get_amount_number = document.getElementById('amount_number');
    
    get_title_view.innerHTML=title;
    get_amount_words.innerHTML=amount_in_words;
    get_amount_number.innerHTML=amount;
}

//function to display edit_title and amount
function edit_modal_content( modal_title, amount_number, amount_words){  
    var title_modal = document.getElementById('edit_title');
    var modal_number = document.getElementById('amount_number_edit');
    var modal_words = document.getElementById('amount_words_edit');

    title_modal.value=modal_title;
    modal_number.innerHTML=amount_number;
    modal_words.innerHTML=amount_words;
}

//function for creating fields intended for modal update
function generate_edit_fields(purpose, unit_price, quantity, total, description){
    
    var edit_table = document.getElementById('edit_table');
    var edit_table_body = document.getElementsByTagName('tbody')[4];
    var add_edit_row = edit_table_body.insertRow();

    var edit_purpose_row = add_edit_row.insertCell(0);
    var unit_price_row = add_edit_row.insertCell(1);
    var quantity_row = add_edit_row.insertCell(2);
    var total_row = add_edit_row.insertCell(3);
    var description_row = add_edit_row.insertCell(4);
    var configuration_row = add_edit_row.insertCell(5);

    let purpose_input = document.createElement("input");
    purpose_input.type ="text";
    purpose_input.value=purpose;
    purpose_input.classList.add('input','is-info');

    let unit_price_input = document.createElement("input");
    unit_price_input.type = "number";
    unit_price_input.value=unit_price;
    unit_price_input.classList.add('input','is-info');

    let quantity_input = document.createElement("input");
    quantity_input.type="number";
    quantity_input.value=quantity;
    quantity_input.classList.add('input','is-info');

    let total_input = document.createElement("input");
    total_input.type ="number";
    total_input.value=total;
    total_input.readOnly=true
    total_input.classList.add('input','is-info');

    let description_input = document.createElement("input");
    description_input.type="text";
    description_input.value=description;
    description_input.classList.add('input','is-info');

    let configuration_button = document.createElement("button");
    configuration_button.classList.add('button','is-danger','is-small',);
    configuration_button.title = 'Remove';
    configuration_button.innerHTML ='<i class="fa-regular fa-trash-can" style="color: #ffffff;"></i>';

    let config_div = document.createElement("div");
    config_div.classList.add('is-flex','is-justify-content-center','is-align-items-center','mt-3');
    config_div.appendChild(configuration_button);

    edit_purpose_row.appendChild(purpose_input);
    unit_price_row.appendChild(unit_price_input);
    quantity_row.appendChild(quantity_input);
    total_row.appendChild(total_input);
    description_row.appendChild(description_input);
    configuration_row.appendChild(config_div);
}

//For avoiding form resubmission when page refresh
if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}
</script>
<!--End of Javascript-->
<?php
//This is use to convert numbers into words
  use NumberToWords\NumberToWords;
  //Instantiate the NumberToWords class
  $numberToWords = new NumberToWords();
  $numberToWords=$numberToWords->getNumberTransformer('en');


//Fetching Pending Request
$fetch_pending = "SELECT * FROM tbl_request WHERE request_status = :status_request AND deleted = :deleted_file ORDER BY request_date DESC";
$prepare_pending_request = $conn->prepare($fetch_pending);
$prepare_pending_request->bindValue(':status_request',"Pending Review");
$prepare_pending_request->bindValue(':deleted_file',false);
$prepare_pending_request->execute();
$rows = $prepare_pending_request->fetchAll(PDO::FETCH_ASSOC);

//Displaying list of request
foreach($rows as $row){
   echo "<script>
        addpending('" . addslashes($row['request_title']) . "', 
                   '" . addslashes($row['request_date']) . "', 
                   '" . addslashes($row['request_id']) . "',
                   '" . addslashes($row['request_status'])."');
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
                 $sql_insert_breakdown = "INSERT INTO Request_Breakdown (request_breakdown_description, request_unit_price, request_quantity, request_breakdown_amount, request_title_id, request_brief_description) VALUES(:request_description, :request_unit_price, :request_quantity, :request_description_amount, :request_title_id, :request_brief_description)";
                 $prepare_breakdown_request = $conn->prepare($sql_insert_breakdown);
                 $prepare_breakdown_request ->bindParam(':request_description',$_POST['expenses'][$i]);
                 $prepare_breakdown_request -> bindParam(':request_unit_price',$_POST['amount'][$i]);
                 $prepare_breakdown_request -> bindParam(':request_quantity', $_POST['quantity'][$i]);
                 $prepare_breakdown_request ->bindParam(':request_description_amount', $_POST['Total_price'][$i]);
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

    if(isset($_POST['delete_button'])&&$_SERVER["REQUEST_METHOD"] == "POST"){
        foreach($_POST['delete_button']as $id=>$value){
            try {
                $delete_request = "UPDATE tbl_request SET deleted=:new_value WHERE request_id = :requested_delete";
                $prepare_deletion = $conn->prepare($delete_request);
                $prepare_deletion -> bindValue(':new_value',true);
                $prepare_deletion -> bindValue(':requested_delete',$id);
                $prepare_deletion->execute();
                echo '<script>
                    swal({
                        title: "File Deleted",
                        text: "You deleted the file successfully!",
                        icon: "success",
                        button: "Okay",
                    }).then(() => {
                        window.location.href = "requestor.php";
                    });
                </script>';
            } catch (PDOException $e) {
                echo '<script>
                    swal({
                        title: "Error!",
                        text: "Unable to delete the file.",
                        icon: "error",
                        button: "Okay",
                    });
                </script>';
            }
        }
    }
    //Viewing of specific request
    if(isset($_POST['view_button'])){
        foreach($_POST['view_button'] as $id=>$value){
            try{
                //Code to get the purpose of request and displaying it in the modal
                $Select_Title = "SELECT request_title, request_total_amount FROM tbl_request WHERE request_id = :requested_id";
                $prepare_select_title = $conn->prepare($Select_Title);
                $prepare_select_title->bindParam(':requested_id',$id);
                $prepare_select_title->execute();
                $fetched_title =$prepare_select_title->fetch(PDO::FETCH_ASSOC);

                $converted_word =  ucwords($numberToWords->toWords($fetched_title['request_total_amount'])) . " Pesos";
                echo "<script>
                insert_text(" . json_encode($fetched_title['request_total_amount']) . ", 
                            " . json_encode($converted_word) . ", 
                            " . json_encode($fetched_title['request_title']) . ");
                    </script>";

                $Select_Request = "SELECT * FROM Request_Breakdown WHERE request_title_id = :requested_id";
                $prepare_selection = $conn->prepare($Select_Request);
                $prepare_selection->bindValue(':requested_id', $id, PDO::PARAM_INT);
                $prepare_selection->execute();
                $fetched_data = $prepare_selection->fetchAll(PDO::FETCH_ASSOC);
                
                //Code to pass the fetched data to js through json
                foreach($fetched_data as $row){
                    echo "<script>
                        display_information(
                            " . json_encode(addslashes($row['request_breakdown_description'])) . ", 
                            " . json_encode($row['request_unit_price']) . ", 
                            " . json_encode($row['request_quantity']) . ", 
                            " . json_encode($row['request_breakdown_amount']) . ", 
                            " . json_encode(addslashes($row['request_brief_description'])) . "
                        );
                        open_view_modal_view_request.classList.add('is-active');
                    </script>";
                }
            } catch(PDOException $e){
                echo "<script>console.error('Database Error: " . addslashes($e->getMessage()) . "');</script>";
            }
        }
    }
    //For viewing the request to be edited
    if(isset($_POST['edit_button'])){
        foreach($_POST['edit_button'] as $id=>$value){
            try{
                //Code to get the purpose of request and displaying it in the modal
                $Select_Title = "SELECT request_title, request_total_amount FROM tbl_request WHERE request_id = :requested_id";
                $prepare_select_title = $conn->prepare($Select_Title);
                $prepare_select_title->bindParam(':requested_id',$id);
                $prepare_select_title->execute();
                $fetched_title =$prepare_select_title->fetch(PDO::FETCH_ASSOC);

                $converted_word =  ucwords($numberToWords->toWords($fetched_title['request_total_amount'])) . " Pesos";
                echo "<script>
                edit_modal_content(" . json_encode($fetched_title['request_title']) . ", 
                            " . json_encode($fetched_title['request_total_amount']) . ", 
                            " . json_encode($converted_word) . ");
                    open_edit_modal.classList.add('is-active');
                    </script>";
                
                $Select_breakdown = "SELECT * FROM Request_Breakdown WHERE request_title_id=:requested_id";
                $prepare_breakdown = $conn->prepare($Select_breakdown);
                $prepare_breakdown->bindParam(':requested_id',$id);
                $prepare_breakdown->execute();
                $fetched_breakdown = $prepare_breakdown->fetchAll(PDO::FETCH_ASSOC);
                
                foreach($fetched_breakdown as $data){
                    echo "<script>
                            generate_edit_fields(".json_encode(addslashes($data['request_breakdown_description'])).', '
                                                  .addslashes($data['request_unit_price']).', '
                                                  .addslashes($data['request_quantity']).', '
                                                  .addslashes($data['request_breakdown_amount']).', '
                                                  .json_encode(addslashes($data['request_brief_description'])).");
                         </script>";
                }
            }catch(PDOException $e){
                echo "<script>console.error('Database Error: " . addslashes($e->getMessage()) . "');</script>";
            }
            
        }
    }
    
?>