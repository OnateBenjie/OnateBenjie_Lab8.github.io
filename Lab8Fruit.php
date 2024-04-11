<?php

// Load the XML file
$xml = new DOMDocument();
$xml->load('Onate_Benjie.xml');

// Get the form data
$fruitName = $_POST['FruitName'];

// Check if the fruit already exists
if (fruitExists($xml, $fruitName)) {
    echo 'Error: The fruit already exists.';
    echo "<a href='index.php' class='btn'><br>Back</a><br/>";
    exit;
}

// Iterate through each basket
foreach ($xml->getElementsByTagName('Basket') as $basket) {
    // Check if the basket owner's name matches the form field name
    $name = $basket->getElementsByTagName('Name')->item(0)->nodeValue;
    $value = $_POST[$name]; // Get the fruit value from the corresponding form field

    // Append a new tag for the fruit with its name and value
    $fruitNode = $xml->createElement($fruitName, $value);
    $basket->appendChild($fruitNode);
}



// Function to check if the fruit already exists
function fruitExists($xml, $fruitName) {
    $existingFruits = [];
    foreach ($xml->getElementsByTagName('Basket') as $basket) {
        $fruits = $basket->getElementsByTagName("*");
        foreach ($fruits as $fruit) {
            // Compare fruit names in a case-insensitive manner
            if (strcasecmp($fruit->nodeName, $fruitName) === 0) {
                return true;
            }
        }
    }
    return false;
}
// Save the modified XML file
$xml->save('Onate_Benjie.xml');

// Return a response indicating success
echo 'New fruit added successfully.';
echo "<a href='index.php' class='btn'><br>Back</a><br/>";
?>
