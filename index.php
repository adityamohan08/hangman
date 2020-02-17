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
    <form name="word_to_be_guessed" method="POST" action="guess.php">
        <label> 
            Enter in the word to be guessed
            <input type="text" name="word" required maxlength="25" autofocus/>
            <input type='submit' value='Submit Word'/>
        </label>
    </form>
</body>
</html>