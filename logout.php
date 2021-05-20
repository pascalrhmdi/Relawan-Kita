<?php 
    //This includes the session_start() to resume the session on this page. It identifies the session that needs to be destroyed.

    // session_destroy() destroys the session. Then the header() function redirects to the home page. 
    
    include_once 'includes/session.php';
    session_destroy();
    header('Location: Login.php');
?>