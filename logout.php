<?php
session_unset();
$_SESSION =[];
session_destroy();
echo"<script>
    document.getElementById('loginBtn').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default form submission
    let loginPage = document.body; 
    loginPage.classList.add('hidden');
    setTimeout(() => {
        window.location.href = 'login.php'; 
    }, 800);
        });    
        </script>";
exit();
?>