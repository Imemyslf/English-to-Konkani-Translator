<?php
    $conn = new mysqli("localhost", "root", "", "nlp_db");
    if(!$conn) {
        die("Connection failed !");
    }

    if(isset($_POST['query'])) {
        $inpTxt = $_POST['query'];
        $query  = "SELECT * FROM etk_dictionary WHERE eng_v LIKE '$inpTxt%'";
        $result = $conn->query($query);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<a class='item' href='#'>".$row['eng_v']."</a>";
            }
        } else {
            echo "<p class='item'>No such records found</p>";
        }
    }
?>