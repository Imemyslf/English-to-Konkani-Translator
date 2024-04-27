<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NLP - Langअनुवादक</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <header class="bg-dark">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Langअनुवादक</a>
            </div>
        </nav>
    </header>
    <main>
        <div class="nav-description">
            <h3>Computer Terminologies TRANSLATOR</h3>
            <p>Our website serves as a comprehensive resource for translating computer terminologies. With a vast database of specialized terms, users can easily find accurate translations for technical jargon in various languages. Whether you're a student, professional, or enthusiast in the field of technology, our platform provides a seamless experience for understanding and communicating computer-related concepts. Powered by MySQL database, our website ensures reliable and up-to-date translations, helping users bridge language barriers and access information with ease. Experience efficient and precise translations for computer terminologies on our user-friendly platform today!</p>
        </div>
        <div class="left-container">
            <div class="search-container">
                <form method="POST">
                    <input type="text" name="search" id="search" placeholder="Enter text to search">
                    <button type="submit" name="submit" id="submit" class="submit"><i class="fas fa-2x fa-search"></i></button>
                    
                    <div class="result-container">
                        <?php
                            $conn = new mysqli("localhost", "root", "", "nlp_db");
                            if(!$conn) {
                                die("Connection failed !");
                            }
                            if(isset($_POST["submit"]) && isset($_POST["search"])) {
                                $eng_key = $_POST["search"];
                                $query  = "SELECT konk_v FROM etk_dictionary WHERE eng_v = '$eng_key'";
                                $result = $conn->query($query);
                                if($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo "<p class='result'>".$row['konk_v']."</p>";
                                    }
                                }
                            }
                        ?>
                    </div>
                </form>
            </div>
            <div class="suggestion-list" id="show-list"></div>
        </div>
    </main>
    <footer class="footer mt-auto py-3">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-4">
                    <b>Managed and Alloted Work :</b>
                    <p>Haysten D'costa <i>(Leader)</i></p>
                </div>
                <div class="col-md-4">
                    <b>Developed Backend:</b>
                    <p>Rayyan Shaikh <i>(Co-Leader)</i></p>
                </div>
                <div class="col-md-4">
                    <b>Developed Frontend:</b>
                    <p>Kishan Sharma <i>(BackUP)</i></p>
                </div>
            </div>
            <p class="mt-3">&copy; 2024 Langअनुवादक. All rights reserved.</p>
        </div>
    </footer>

    <script type="text/javascript">
        $(document).ready(function() {
            $("#search").keyup(function() {
                var searchTxt = $(this).val();
                if(searchTxt != '') {
                    $.ajax({
                        url:'searchDB.php',
                        method:'post',
                        data:{query:searchTxt},
                        success:function(response) {
                            $("#show-list").html(response);
                        }
                    });
                } else {
                    $("#show-list").html('');
                }
            });
            $(document).on('click', 'a', function() {
                $("#search").val($(this).text());
                $("#show-list").html('');
            });
        });
    </script>
</body>
</html>