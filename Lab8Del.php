<?php 

	$xml = new domdocument('1.0');
	$xml->load('Onate_Benjie.xml');
	$xml -> formatOutput = true;
	$xml -> preserveWhiteSpace = false;

	$id = $_POST['id'];
	$Baskets = $xml->getElementsByTagName('Basket');

	foreach($Baskets as $Basket){
		$oldid = $Basket->getAttribute('id');
			if($id == $oldid){
				$xml->getElementsByTagName('Fruits')->item(0)->removeChild($Basket);
				$xml->save('Onate_Benjie.xml');
				echo "RECORD DELETED <br> <a href='index.php'>Back</a>";
				break;
			}
	}

?>