<?php 
    $xml = new DOMDocument('1.0');
    $xml->load('Onate_Benjie.xml');
    
    $patients = $xml->getElementsByTagName("Fruits");
    
    $firstFruit = $xml->Fruit[0];
    $headers = [];
    foreach ($firstFruit->children() as $child) {
            $headers[] = $child->getName();
    }

    echo '<table border="1">';
    echo '<thead><tr>';
    foreach ($headers as $header) {
        echo "<th>$header</th>";
    }
    echo '</tr></thead>';
    echo '<tbody>';
    
    foreach($patients as $patient) {
        $name = $patient->getElementsByTagName("Name")->item(0)->nodeValue;
        $gender = $patient->getElementsByTagName("Q1")->item(0)->nodeValue;
        echo "<tr><td>$name</td><td>$gender</td></tr>";
    }
    
    echo "</tbody>";
    echo "</table>";
?>
