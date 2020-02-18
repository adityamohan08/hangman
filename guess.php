<?php 
    session_set_cookie_params(
        0,                 // Lifetime -- 0 means erase when browser closes
        '/',               // Which paths are these cookies relevant?
        'hangman.joebailey.xyz', // Only expose this to which domain?
        true,              // Only send over the network when TLS is used
        true               // Don't expose to Javascript
    );
    //Start Session
    session_start();
    //If game restarted or accessed directly
    if (!$_SESSION['word'] && !$_POST["word"] || $_POST["restart"] || !$_POST["guess"] && !$_POST["word"]) {
        //Remove Session for data sanitization
        session_unset();
        session_destroy();
        //Redirect to homepage
        header("Location: index.php");
        exit;
    }
    function noHTML($input, $encoding = 'UTF-8') {
        return htmlentities($input, ENT_QUOTES | ENT_HTML5, $encoding);
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
            //Create Word Session Variable with lowercase array of word
            $_SESSION['word'] = array_unique(str_split(strtolower(noHTML($_POST["word"]))));
            //Create Word Session Variable with duplicates
            $_SESSION['original_word'] = str_split(strtolower(noHTML($_POST["word"])));
            //Create Letters Session Variable with array length
            $_SESSION['letters'] = sizeof($_SESSION['word']);
            //Set the game in motion
            $_SESSION['turn'] = 1;
            //Print Letters to be guessed
            print("<p>Letters to be guessed: ".$_SESSION['letters']."</p>");
            //Print word to be guesses
            echo "<p>Word to be guessed: ";
            foreach ($_SESSION['original_word'] as $i){
                echo "- ";
            }
            echo "</p>";
            //Print hangman image
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
                //Print word to be guessed
                echo "<p>Word to be guessed: ";
                foreach ($_SESSION['original_word'] as $i){
                    if (in_array($i, $guesses)) {
                        echo $i." ";
                    }
                    else {
                        echo "- ";
                    }
                }
                echo "</p>";
            };
            //Get session variables
            $word = $_SESSION['word'];
            $turn = $_SESSION['turn'];
            //Get guess
            $guess = strtolower(noHTML($_POST["guess"]));

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
            if ($turn < 6) {
                //If last turn and guess isn't right
                if ($turn == 5 && !array_diff($word, $guesses)) {
                    echo "<h2>Game over!</h2>";
                    session_unset();
                    session_destroy();
                    $turn = 6;
                }
                //If already guessed
                else if (in_array($guess, $guesses)) {
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
                        echo "<p>Word: ".join( "", $_SESSION['original_word'])."</p>";
                        session_unset();
                        session_destroy();
                    }
                }
            }
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