<?php
	// encrypt message
	function Cipher($ch, $key) {
		if (!ctype_alpha($ch))
			return $ch;

		$offset = ord(ctype_upper($ch) ? 'A' : 'a');
		
		return chr(fmod(((ord($ch) + $key) - $offset), 26) + $offset);
	}

	function Caesar_Encipher($input, $key) {
		$output = "";

		$inputArr = str_split($input);
		
		foreach ($inputArr as $ch)
			$output .= Cipher($ch, $key);

		return $output;
	}
	
	function Caesar_Decipher($input, $key) {
		return Caesar_Encipher($input, 26 - $key);
	}
	
	function Vernam_Encipher($input) {
		$output = "";
		$encrypt_key = "";
		$key = Array();
		
		for($counter = 1; $counter < strlen($input) + 1; $counter++) {
			$key[$counter] = rand() * $counter;
			
			if ($counter == strlen($input))
				$encrypt_key .= $key[$counter];
			else 
				$encrypt_key .= $key[$counter] . " ";
		}
		
		$letters = Array();
		
		for($counter = 1; $counter < strlen($input) + 1; $counter++) {
			$letters[$counter] = $key[$counter] ^ ord($input[$counter-1]);
			
			if ($counter == strlen($input))
				$output .= $letters[$counter];
			else
				$output .= $letters[$counter] . " ";
		}
		
		$message_array = array("message" => $output, "key" => $encrypt_key);
		
		return $message_array;
	}
	
	function Vernam_Decipher($input, $string_key) {
		$output = "";				
		$key = array_map('intval', explode(' ',$string_key));	
		$letters = array_map('intval', explode(' ',$input));
		
		for($counter = 0; $counter < count($letters); $counter++)			
			$output .= chr($key[$counter] ^ $letters[$counter]);
		
		$message_array = array("message" => $output, "key" => null);
		
		return $message_array;
	}
	
	if (isset($_POST['caesar_text'])) {
		if ($_POST['submit'] == 1) {
			$message = Caesar_Encipher($_POST['caesar_text'], 3);	
		} else if ($_POST['submit'] == 2) {
			$message = Caesar_Decipher($_POST['caesar_text'], 3);
		} else
			$message = "";
	} else
		$message = "";
		
	if (isset($_POST['vernam_text'])) {
		if ($_POST['submit'] == 3) {
			$message_and_key = Vernam_Encipher($_POST['vernam_text']); 
			echo "<script type='text/javascript'> window.onload = function() {document.querySelector('.cont').classList.toggle('s--signup');} </script>";
		} else if (isset($_POST['vernam_key']) && $_POST['submit'] == 4) {
			$message_and_key = Vernam_Decipher($_POST['vernam_text'], $_POST['vernam_key']); 
			echo "<script type='text/javascript'> window.onload = function() {document.querySelector('.cont').classList.toggle('s--signup');} </script>";
		} else
			$message_and_key = null;
	} else
		$message_and_key = null;
?>