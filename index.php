<!DOCTYPE html>

<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" type="text/css" href="lab6.css">
    <title>Lab 6</title>
</head>
<body>
    <h1>Student Quiz</h1>

    <div class="crud">
        <button onclick="Add()">Add Owner</button>
        <button onclick="Fruit()">Add Fruit</button>
        <button onclick="Edit()">Edit</button>
        <button onclick="Delete()">Delete</button>
    </div>
    <div class="info">
                <?php
$xml = new DOMDocument('1.0');
$xml->load('Onate_Benjie.xml');

$fruits = $xml->getElementsByTagName("Basket");

// Initialize headers array
$headers = [];

// Iterate through the first fruit to get headers
$firstFruit = $fruits[0];
foreach ($firstFruit->childNodes as $child) {
    if ($child->nodeType === XML_ELEMENT_NODE) {
        $headers[] = $child->tagName;
    }
}

// Add 'ID' as the first header
array_unshift($headers, 'ID');

// Add a new header for total number of fruits
$headers[] = 'Total Fruits';

// Initialize an array to store the total number of fruits for each column
$totalFruitsPerColumn = array_fill_keys($headers, 0);

echo '<table border="1">';
echo '<thead><tr>';
// Output the headers
foreach ($headers as $header) {
    echo "<th>$header</th>";
}
echo '</tr></thead>';
echo '<tbody>';

// Loop through each fruit
foreach ($fruits as $fruit) {
    echo '<tr>';
    // Get the ID of the fruit
    $id = $fruit->getAttribute('id');
    echo "<td>$id</td>";

    // Initialize total fruits count for this fruit
    $totalFruits = 0;

    // Loop through each header
    foreach ($headers as $header) {
        // Skip the "ID" and "Total Fruits" headers
        if ($header !== 'ID' && $header !== 'Total Fruits') {
            // Get the value of each header (except ID)
            $value = $fruit->getElementsByTagName($header)->length > 0 ? $fruit->getElementsByTagName($header)->item(0)->nodeValue : '';
            echo "<td>$value</td>";

            // Add the value to the total fruits count for this column
            $totalFruits += (int)$value;
            $totalFruitsPerColumn[$header] += (int)$value;
        }
    }

    // Output the total number of fruits for this basket owner
    echo "<td>$totalFruits</td>";

    echo '</tr>';
}

// Output the total number of fruits for each column
echo '<tr>';
foreach ($headers as $header) {
    if ($header === 'ID') {
        echo '<td></td>'; // Skip the ID column
    } else {
        if ($header === 'Name') {
            // Output "Total" for the "Name" column
            echo "<td>Total</td>";
        } else {
            // Output the total for other columns
            echo "<td>{$totalFruitsPerColumn[$header]}</td>";
        }
    }
}
echo '</tr>';


echo '</tbody></table>';
?>

    </div>


  <div class="Form" id="addForm">
    <span class="closebutton" onclick="closeAdd()" style="position: absolute; top: 15px; right: 20px;">x</span>
    <h2>Add Basket Owner</h2>
    <form id="studentForm" onsubmit="AddForm()">
        <?php
        $xml = new DOMDocument('1.0');
        $xml->load('Onate_Benjie.xml');

        $firstBasket = $xml->getElementsByTagName("Basket")[0];
        echo "<input type='number' name='Basket' placeholder='Basket' required>";
        // Iterate through child nodes and generate input fields
        foreach ($firstBasket->childNodes as $child) {
            if ($child->nodeType === XML_ELEMENT_NODE) {
                $tagName = $child->tagName;
                echo "<input type='text' name='$tagName' placeholder='$tagName' required>";
            }
        }
        ?>
        <input type="submit" name="Submit" value="Submit">
    </form>
</div>

 <div class="Form" id="FruitForm">
    <span class="closebutton" onclick="closeFruit()" style="position: absolute; top: 15px; right: 20px;">x</span>
    <h2>Add Fruit</h2>
    <form id="FruitForm" method="post" action="Lab8Fruit.php">
    <input type="text" name="FruitName" placeholder="Fruit Name" required>
    <?php
    $xml = new DOMDocument('1.0');
    $xml->load('Onate_Benjie.xml');

    $baskets = $xml->getElementsByTagName("Basket");

    // Iterate through each basket owner
    foreach ($baskets as $basket) {
        // Get the name of the basket owner
        $name = $basket->getElementsByTagName("Name")->item(0)->nodeValue;
        echo "<input type='number' name='$name' placeholder='Value for $name' required>"; // Input field for the new fruit value
    }
    ?>
    <input type="submit" name="Submit" value="Submit">
</form>
</div>






    <div class="Form" id="editForm">
        <form method="POST" action="Lab6Edit.php">
            <span class="closebutton" onclick="closeEdit()" style="position: absolute; top: 15px; right: 20px;">x</span>
            <h2>Edit Student Quiz</h2>
            <p>Select StudNo</p>
            <select name="StudNo">

                <?php
                $xml = new domdocument('1.0');
                $xml->load("Onate_Benjie.xml");

                $students = $xml->getElementsByTagName("StudNo");

                foreach($students as $student){
                $id = $student->getAttribute('id');

                echo "
                <option>$id</option>";
                }
                ?>
            </select>
            <input type="text" name="newName" placeholder="Name">
            <input type="number" name="newQ1" placeholder="Apple">
            <input type="number" name="newQ2" placeholder="Banana">
            <input type="number" name="newQ3" placeholder="Mango">
            <input type="number" name="newQ4" placeholder="Papaya">
            <input type="number" name="newQ5" placeholder="Melon">
            <input type="submit" name="update">
        </form>
    </div>
   
    
    <div class="Form" id="delForm">
        <span class="closebutton" onclick="closeDel()" style="position: absolute; top: 15px; right: 20px;">x</span>
        <h2>Delete Basket</h2>
        <form id="deleteForm" onsubmit="DelForm()">
            <p>Select Basket</p>
            <select name="id">
                <?php
                $xml = new domdocument('1.0');
                $xml->load('Onate_Benjie.xml');

                $Fruits = $xml->getElementsByTagName('Basket');

                foreach($Fruits as $Fruit){
                $id = $Fruit->getAttribute('id');

                echo "
                <option>$id</option>";
                }
                ?>
            </select>
            <input type="submit" name="delete">
        </form>
    </div>



    <script src="Lab6.js"></script>

    <script>
        function getdata() {
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 ) {
                   document.getElementById("info").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "Onate_Benjie.xml", true);
            xmlhttp.send();
        }

    function AddForm() {
        var formData = new FormData(document.getElementById("studentForm"));

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4) {
                console.log(xmlhttp.responseText);
                // Handle response here, e.g., show success message or redirect to another page
            }
        };
        xmlhttp.open("POST", "Lab8Add.php", true);
        xmlhttp.send(formData);

        return false; // Prevent default form submission
    }


   function DelForm() {
    var form = document.getElementById('deleteForm');
    var formData = new FormData(form);

    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4) {
            if (xmlhttp.status == 200) {
                console.log(xmlhttp.responseText);
            }
        }
    };
    xmlhttp.open('POST', 'Lab8Del.php', true);
    xmlhttp.send(formData);

    return false; // Prevent default form submission
}

</script>

</body>
</html>