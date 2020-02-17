<?php 
    //Start Session
    session_start();
    //If game restarted or accessed directly
    if ($_POST["restart"] || !$_POST["guess"] && !$_POST["word"]) {
        //Remove Session for data sanitization
        session_unset();
        session_destroy();
        //Redirect to homepage
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
        //If word has just been entered on homepage
        if ($_POST["word"]) {
            //Create Word Session variable with lowercase array of word
            $_SESSION['word'] = array_unique(str_split(strtolower($_POST["word"])));
            //Create Letters Session Variable with array length
            $_SESSION['letters'] = sizeof($_SESSION['word']);
            //Set the game in motion
            $_SESSION['turn'] = 1;
            //Print Letters to be guessed and hangman image
            print("<p>Letters to be guessed: ".$_SESSION['letters']."</p>");
            print("<img src='img/1.png' alt='hangman' />"); 
        }
        //If guess has been made
        else {
            function update($guesses, $incorrect) {
                //Update letters to be guessed variable
                $_SESSION['letters'] = $_SESSION['letters'] - $right;
                print("<p>Letters to be guessed: ".$_SESSION['letters']."</p>");
                //Print letters guessed by joining string with a space
                print("<p>Letters guessed: ".implode(" ", $guesses));
                //Print incorrect gusses left
                print("<p>Incorrect guesses left: ".$incorrect)."</p>";
                //Update Incorrect Session Variable
                $_SESSION['incorrect'] = $incorrect;
            };
            //Get session variables
            $word = $_SESSION['word'];
            $turn = $_SESSION['turn'];
            //Get guess
            $guess = strtolower($_POST["guess"]);

            //If there have been previous guesses
            if ($_SESSION['guesses']) {
                //Get previous guesses
                $guesses = $_SESSION['guesses'];
            }
            else {
                //Create empty guesses array
                $guesses = [];
            };
            // If game isn't over
            if ($turn < 5) {
                //If already guessed
                if (in_array($guess, $guesses)) {
                    echo "<h2>You've already guessed that letter!</h2>";
                    //If Incorrect Session exists
                    if ($_SESSION['incorrect']) {
                        $incorrect = $_SESSION['incorrect'];
                    }
                    else {
                        $incorrect = 5;
                    };
                    update($guesses, $incorrect);
                }
                //If not already guessed
                else {
                    array_push($guesses, $guess);
                    //Update Session Guesses
                    $_SESSION['guesses'] = $guesses;
                    //If game hasn't been won
                    if (array_diff($word, $guesses)) {
                        //If guess is right
                        if (in_array($guess, $word)) {
                            echo "<h2>You got it right</h2>";
                            //Update the number of right guesses
                            $right = $right + 1;
                            //If Incorrection Session Variable exists set it 
                            if ($_SESSION['incorrect']) {
                                $incorrect = $_SESSION['incorrect'];
                            }
                            else {
                                $incorrect = 5;
                            };
                        }
                        //Guess is wrong
                        else {
                            echo "<h2>You got it wrong</h2>";
                            //Update number of turns
                            $_SESSION['turn'] = $_SESSION['turn'] + 1;
                            $turn = $_SESSION['turn'];
                            $incorrect = 6 - $_SESSION['turn'];
                        };
                        update($guesses, $incorrect);
                    }
                    //Game won and destroy session
                    else {
                        echo "<h2>Game won!</h2>";
                        session_unset();
                        session_destroy();
                    }
                }
            }
            //Game lost and destroy session
            else {
                echo "<h2>Game over!</h2>";
                session_unset();
                session_destroy();
                $turn = 6;
            };
            //Print the hangman image
            print("<img src='img/".$turn.".png' alt='hangman' />");
        }
    ?>
    <form method='POST' action=''>
        <input type='text' name='guess' required maxlength="1" autofocus style="width:1.5em;text-align:center;" />
        <input 
            type='submit' 
            value='Guess' 
            <?php 
                //If game over disable submit button
                if (!$_POST["word"]) {
                    if(!array_diff($word, $guesses) || $turn >= 6) {
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