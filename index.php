<?php
include 'data/quotes.php';

// Initialisation d'une variable qui contiendra la citation sélectionnée.
$selectedQuote = "";

// Fonction pour sélectionner une citation aléatoire à partir des langages sélectionnés
function getRandomQuote($selectedLangs, $quotes)
{
    $availableQuotes = [];

    // Parcourt les langages choisis par l'utilisateur
    foreach ($selectedLangs as $lang) {
        // Si le langage existe dans le tableau $quotes
        if (isset($quotes[$lang])) {
            // On ajoute ses citations dans le tableau global
            $availableQuotes = array_merge($availableQuotes, $quotes[$lang]);
        }
    }

    // Si on a des citations disponibles, on en retourne une au hasard
    if (!empty($availableQuotes)) {
        return $availableQuotes[array_rand($availableQuotes)];
    } else {
        // Sinon, on renvoie un message d'erreur
        return "Aucune citation disponible. Veuillez sélectionner au moins un langage.";
    }
}

// Vérifie si le formulaire a été soumis en méthode POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['lang'])) {
    // Appelle la fonction avec les langages sélectionnés
    $selectedQuote = getRandomQuote($_POST['lang'], $quotes);
}

// Vérifie si le mot entrer dans la recherche est présent dans une citation du tableau 
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['search'])) {
    $searchTerm = strtolower(trim($_GET['search']));
    $foundQuotes = [];

    // Parcourt les citations pour trouver celles qui contiennent le terme de recherche
    foreach ($quotes as $lang => $langQuotes) {
        foreach ($langQuotes as $quote) {
            if (strpos(strtolower($quote), $searchTerm) !== false) {
                $foundQuotes[] = $quote;
            }
        }
    }

    // Si des citations sont trouvées, on en sélectionne une au hasard
    if (!empty($foundQuotes)) {
        $selectedQuote = $foundQuotes[array_rand($foundQuotes)];
    } else {
        $selectedQuote = "Aucune citation ne correspond à votre recherche.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Quotes exercise</title>
</head>

<body>
    <header>
        <h1>TP Quotes</h1>
        <form method="GET" action="#" class="search-form">
            <input type="text" name="search" placeholder="Rechercher une citation">
            <button class="search-btn" type="submit">🔍</button>
        </form>
    </header>

    <main>
        <form method="POST" action="#" class="quote-form">
            <fieldset class="filters">
                <legend>Choisissez un ou plusieurs langages :</legend>
                <label><input type="checkbox" name="lang[]" value="html"> HTML</label>
                <label><input type="checkbox" name="lang[]" value="css"> CSS</label>
                <label><input type="checkbox" name="lang[]" value="javascript"> JS</label>
                <label><input type="checkbox" name="lang[]" value="php"> PHP</label>
                <label><input type="checkbox" name="lang[]" value="sql"> SQL</label>
            </fieldset>
            <div class="submit-btn">
                <button type="submit" class="quote-btn">Afficher une quote</button>
            </div>
        </form>

        <div class="quote-box">
            <?php if (!empty($selectedQuote)) echo "<p>$selectedQuote</p>"; ?>
        </div>
    </main>
</body>

</html>