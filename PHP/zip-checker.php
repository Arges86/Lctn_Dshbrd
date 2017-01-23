<?php
//Borrowed from https://www.sanwebe.com/2013/04/username-live-check-using-ajax-php
if(isset($_POST["zipcode"]))
{
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
        die();
    }
    $servername = "localhost";
    $username = "root";
    $password = "smokey!1";
    $dbname = "myDB";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error){
        die('Could not connect to database!');
    }
    
    $zipcode = filter_var($_POST["zipcode"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW|FILTER_FLAG_STRIP_HIGH);
    
    $statement = $conn->prepare("SELECT zip FROM Zip_Code_DB WHERE zip=?");
    $statement->bind_param('s', $zipcode);
    $statement->execute();
    $statement->bind_result($zipcode);
    //Return
    if($statement->fetch()){
        die('<span class="glyphicon glyphicon-ok"></span>
        <script>
        $(".form-group-b").show();
        $("#reg-form").attr("class", "enable-enter"); //changes class to enable enter key
        </script>');
    }else{
        die('<span class="glyphicon glyphicon-remove"></span><br><small>Caution, 
        this zip code does not exist in the US.  Therefore, you may not get your 
        expected results.</small>
        <script>
        $(".form-group-b").hide(); //hides the forms
        $("#reg-form").attr("class", "disable-enter"); //changes class to prevent enter key
        </script>');
    }
}
?>