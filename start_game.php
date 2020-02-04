<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hangman</title>
</head>
<body>
    <?php
        $word = str_split("yeet");

        switch ($_GET["turn"]) {
        
            case "1":
                $guess1 = $_GET["guess1"]; 
                if (in_array($guess1, $word)) {
                    echo "yes";
                }
                else {
                    echo "no";
                }   
                echo "<form method='GET' action=''>
                        <input type='text' name='guess2' required />
                        <input hidden name='turn' value='2' />
                        <input hidden name='guess1' value=$guess1 />
                        <input type='submit' value='Guess'/>
                    </form>";
                break;  
        
            case "2":
                $guess1 = $_GET["guess1"];
                $guess2 = $_GET["guess2"];

                $guesses = [$guess1]; 
                if (in_array($guess2, $guesses)) {
                    echo "already guessed";
                }
                else {
                    if (in_array($guess2, $word)) {
                        echo "yes";
                    }
                    else {
                        echo "no";
                    }
                }      
                echo "<form method='GET' action=''>
                        <input type='text' name='guess3' required />
                        <input hidden name='turn' value='3' />
                        <input hidden name='guess1' value=$guess1 />
                        <input hidden name='guess2' value=$guess2 />
                        <input type='submit' value='Guess'/>
                    </form>";
                break;

            case "3":
                $guess1 = $_GET["guess1"];
                $guess2 = $_GET["guess2"];
                $guess3 = $_GET["guess3"];

                $guesses = [$guess1, $guess2]; 
                if (in_array($guess3, $guesses)) {
                    echo "already guessed";
                }
                else {
                    if (in_array($guess3, $word)) {
                        echo "yes";
                    }
                    else {
                        echo "no";
                    }
                }      
                echo "<form method='GET' action=''>
                        <input type='text' name='guess4' required />
                        <input hidden name='turn' value='4' />
                        <input hidden name='guess1' value=$guess1 />
                        <input hidden name='guess2' value=$guess2 />
                        <input hidden name='guess3' value=$guess3 />
                        <input type='submit' value='Guess'/>
                    </form>";
                break;

            case "4":
                $guess1 = $_GET["guess1"];
                $guess2 = $_GET["guess2"];
                $guess3 = $_GET["guess3"];
                $guess4 = $_GET["guess4"];

                $guesses = [$guess1, $guess2, $guess3]; 
                if (in_array($guess4, $guesses)) {
                    echo "already guessed";
                }
                else {
                    if (in_array($guess4, $word)) {
                        echo "yes";
                    }
                    else {
                        echo "no";
                    }
                }      
                echo "<form method='GET' action=''>
                        <input type='text' name='guess5' required />
                        <input hidden name='turn' value='5' />
                        <input hidden name='guess1' value=$guess1 />
                        <input hidden name='guess2' value=$guess2 />
                        <input hidden name='guess3' value=$guess3 />
                        <input hidden name='guess4' value=$guess4 />
                        <input type='submit' value='Guess'/>
                    </form>";
                break;

            case "5":
                $guess1 = $_GET["guess1"];
                $guess2 = $_GET["guess2"];
                $guess3 = $_GET["guess3"];
                $guess4 = $_GET["guess4"];
                $guess5 = $_GET["guess5"];

                $guesses = [$guess1, $guess2, $guess3, $guess4]; 
                if (in_array($guess5, $guesses)) {
                    echo "already guessed";
                }
                else {
                    if (in_array($guess5, $word)) {
                        echo "yes";
                    }
                    else {
                        echo "no";
                    }
                }
                break;

            default:
                echo '<form method="GET" action="">
                    <input type="text" name="guess1" required />
                    <input hidden name="turn" value="1" />
                    <input type="submit" value="Guess"/>
                </form>';
        };
    ?>
</body>
</html>