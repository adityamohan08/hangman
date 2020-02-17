<?php 
    session_start();

    if ($_POST["restart"]) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en-GB">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <h1>Hangman</h1>
    <?php
        if ($_POST["word"]) {
            $_SESSION['word'] = array_unique(str_split(strtolower($_POST["word"])));
            $_SESSION['turn'] = 0;
            $word = array_unique(str_split(strtolower($_POST["word"])));
            $letters = sizeof($word);
            $_SESSION['letters'] = $letters;
            $_SESSION['turn'] = 1;
        }
        else {
            $word = $_SESSION['word'];
            $turn = $_SESSION['turn'];
            $guess = strtolower($_POST["guess"]);

            if ($_SESSION['guesses']) {
                $guesses = $_SESSION['guesses'];
            }
            else {
                $guesses = [];
            };        
            if ($turn < 5) {
                if (in_array($guess, $guesses)) {
                    echo "<h2>You've already guessed that letter!</h2>";                    
                }
                else {
                    array_push($guesses, $guess);
                    $_SESSION['guesses'] = $guesses;
                    if (array_diff($word, $guesses)) {
                        if (in_array($guess, $word)) {
                            echo "<h2>You got it right</h2>";
                            $right = $right + 1;
                        }
                        else {
                            echo "<h2>You got it wrong</h2>";
                            $_SESSION['turn'] = $turn + 1;
                        };
                    }
                    else {
                        echo "<h2>Game won!</h2>";
                        session_unset();
                        session_destroy();
                    }
                }
            }
            else {
                echo "<h2>Game over!</h2>";
                session_unset();
                session_destroy();
            }
        }
        $letters = $_SESSION['letters'] - $right;
        $_SESSION['letters'] = $letters;
        $incorrect = 5;
        print("<p>Letters to be guessed: ".$letters."</p>");
        if ($guesses) {
            print("<p>Letters guessed: ".implode(" ", $guesses));
            if (!array_diff($word, $guesses)) {
                $incorrect = 5 - $turn;
            }
            print("<p>Incorrect guesses left: ".$incorrect);
        }
    ?>
    <form method='POST' action=''>
        <input type='text' name='guess' required maxlength="1" autofocus/>
        <input 
            type='submit' 
            value='Guess' 
            <?php 
                if (!$_POST["word"]) {
                    if(!array_diff($word, $guesses) || $turn >= 5) {
                        echo "disabled";
                    }
                }; 
            ?>
        />
    </form>
    <form method='POST' action=''>
        <input type="text" name="restart" value="yes" hidden/>
        <input type='submit' value='Restart Game'/>
    </form>
</body>
</html>