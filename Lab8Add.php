<?php
$xml = new DOMDocument('1.0');
$xml->load('Onate_Benjie.xml');

$Basket = $_POST["Basket"];
$inputs = $_POST;

$newid = $xml->createElement("Basket");
$newid->setAttribute('id', $Basket);

foreach ($inputs as $tag => $value) {
    // Skip the Basket input, as it's already handled
    if ($tag === "Basket") {
        continue;
    }

    $newTag = $xml->createElement($tag, $value);
    $newid->appendChild($newTag);
}

$xml->getElementsByTagName("Fruits")->item(0)->appendChild($newid);
$xml->save("Onate_Benjie.xml");

echo "RECORD SAVED <br> <a href='index.php'>Back</a>";
?>
