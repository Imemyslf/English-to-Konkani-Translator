<?php
        $connect = mysqli_connect("localhost", "root", "", "item");

        if (!$connect) {
            die("Couldn't connect to database");
        }

        $query = "SELECT name FROM fruit";
        $result = mysqli_query($connect, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }

        $fruits = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $fruits[] = $row['name'];
        }
        
        // foreach ($fruits as $fruit){
        //     echo $fruit ."<br>";
        // }

        $is_post_req = false;
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['word'])) {
            $is_post_req = true;
            $word = $_POST['word'];
            
            // echo "Received word: " . $word;

            $r1 = "SELECT konk FROM fruit WHERE name = '" . $word . "'";
            $result = mysqli_query($connect, $r1);
            if ($result) {
                $row = mysqli_fetch_assoc($result);
                $konk = $row['konk'];
                // echo "ID of the fruit is: " . $id;
                echo $konk;
                } 
            }
            exit; // Stop further execution
        }

        mysqli_close($connect);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>

    /* Box sizing rules */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
    }

    /* Remove default margin */
    * {
        margin: 0;
        padding: 0;
        family: inherit;
    }

    /* Remove list styles on ul, ol elements with a list role, which suggests default styling will be removed */
    ul[role='list'],
    ol[role='list'] {
        list-style: none;
    }

    /* Set core root defaults */
    html:focus-within {
        scroll-behavior: smooth;
    }

    html,
    body {
        height: 100%;
    }

    /* Set core body defaults */
    body {
        text-rendering: optimizeSpeed;
        line-height: 1.5;
    }

    /* A elements that don't have a class get default styles */
    a:not([class]) {
        text-decoration-skip-ink: auto;
    }

    /* Make images easier to work with */
    img,
    picture,
    svg {
        max-width: 100%;
        display: block;
    }

    /* Remove all animations, transitions and smooth scroll for people that prefer not to see them */
    @media (prefers-reduced-motion: reduce) {
        html:focus-within {
            scroll-behavior: auto;
        }

        *,
        *::before,
        *::after {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
            scroll-behavior: auto !important;
        }
    }

    * {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        box-sizing: border-box;
    }

    body {
        background: #262a2f;
        color: #333;
    }

    main {
        display: flex;
        justify-content: center;
        align-items: center;
        border: 5px solid red;
    }
    .search-box {
        max-width: 50%;
        width: auto;
        background: #fff;
        margin: 2rem;
        border-radius: 5px;
    }

    .row {
        display: flex;
        align-items: center;
        padding: 10px 20px;
    }

    input {
        flex: 1;
        height: 50px;
        background: transparent;
        border: 0;
        outline: 0;
        font-size: 18px;
        color: #333;
    }

    button {
        background: transparent;
        border: none;
        outline: 0;
    }

    .search {
        width: 35px;
        height: 35px;
        cursor: pointer;
    }

    ::placeholder {
        color: #555;
    }

    .result-box ul {
        border-top: 1px solid #999;
        padding: 15px 10px;
    }

    .result-box ul li {
        list-type: none;
        border-top: 3px;
        padding: 10px 5px;
        cursor: pointer;
    }

    .result-box ul li:hover {
        background: #d9f3ff;
    }

    .result-box {
        max-height: 300px;
        overflow-y: scroll;
    }

    .result-box p {
        padding: 20px 10px;
    }

    .display {

        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto;
        background: linear-gradient(138deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0));
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        margin-top: 10px;
        width: max-content;
        height: 50px;
        padding: 5px;
        border-radius: 5px;
    }

    .display p {
        color: white;
        font-size: 20px;
    }

    </style>
</head>

<body>
    <main>
        <div class="search-box">
            <div class="row">
                <input type="text" name="language" id="language" placeholder="Enter search key" autocomplete="off">
                <button type="button" onclick="convert()"><img src="./search.png" alt="search_png" class="search"></button>
                <div class="show"></div>
            </div>
            <div class="result-box"></div>
        </div>
        <div class="display">
            <p class="content"></p>
        </div>
</main>


    <script>
    let fruits = <?php echo json_encode($fruits); ?>;
    let word = '';
    const resultBox = document.querySelector(".result-box");
    const inputBox = document.getElementById("language");

    inputBox.onkeyup = function() {
        let result = [];
        let input = inputBox.value;
        if (input.length) {
            result = fruits.filter((fruit) => {
                return fruit.toLowerCase().includes(input.toLowerCase());
            });
            console.log(result);
        }
        display(result);
    }

    function display(result) {
        if (result.length) {
            const content = result.map((list) => {
                return "<li onclick=selectInput(event)>" + list + "</li>";
            });
            resultBox.innerHTML = "<ul>" + content.join('') + "</ul>";
        } else if (inputBox.value.length) {
            resultBox.innerHTML = "<p>Word not found</p>";
        } else {
            resultBox.innerHTML = '';
        }
    }

    function selectInput(event) {
        inputBox.value = event.target.innerHTML;
        word = inputBox.value;
        resultBox.innerHTML = '';
        console.log(word);

        fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `word=${word}`
            })
            .then(response => response.text())
            .then(data => {
                console.log(data); 
                let id = data;
                const display = document.querySelector('.content');
                display.innerText = id;
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    </script>
</body>

</html>