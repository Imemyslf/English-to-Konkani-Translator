<?php

$connect = mysqli_connect("localhost","root","","konk");

if (isset($_POST["query"]))
{
    $output = '';
    $query = "SELECT * FROM fruit WHERE name LIKE '%" . $_POST["query"] . "%'";
    $result = mysqli_query($connect, $query);
    $output = '<ul class="list-un">';
    
    if (mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_array($result)){
            $output .= '<li>'.$row["name"].'</li>';
        }
    }
    else{
        $output = '<li>Item not found</li>';
    }

    $output .= '</ul>';
    echo $output;
}

mysqli_close($connect);

?>

//sup kisun