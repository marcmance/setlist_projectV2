<?php
	function printArray($arr) {
		echo "<br/>";
		echo '<div style="background-color:#E3DCDE;border:1px solid black;">';
		echo "<pre>";
		print_r($arr);
		echo "</pre>";
		echo "</div>";
	}

	function echoPretty($string = null) {
		if($string == null) {
			$string = "";
		}
		echo "<br/>";
		echo '<div style="background-color:#E3DCDE;border:1px solid black;">';
		echo '<b>You echoed:</b><br/>';
		echo $string;
		echo "</div>";
	} 
?>