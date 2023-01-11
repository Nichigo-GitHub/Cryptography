<!DOCTYPE html>
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
<html lang="en">
	<head>
		<!-- title of our page -->
		<title>Cryptography | Basics</title>		
		
		<!-- javascript links for our jquery -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<!-- css script for our style -->
		<style>
			*, *:before, *:after {
				 box-sizing: border-box;
				 margin: 0;
				 padding: 0;
			}
			 body {
				 font-family: 'Open Sans', Helvetica, Arial, sans-serif;
			}
			 input, button {
				 border: none;
				 outline: none;
				 background: none;
				 font-family: 'Open Sans', Helvetica, Arial, sans-serif;
			}
			 .back {
				 background: linear-gradient(120grad, #9664bd, #91DDF2);
				 position: fixed;
				 width: 100%;
				 height: 100%;
			}
			 .cont {
				 overflow: hidden;
				 position: relative;
				 width: 900px;
				 height: 550px;
				 margin: 0 auto;
				 top: 50%;
				 transform: translateY(-50%);
				 background: #fff;
			}
			 .form {
				 position: relative;
				 width: 640px;
				 height: 100%;
				 transition: transform 1.2s ease-in-out;
				 padding: 50px 30px 0;
			}
			 .sub-cont {
				 overflow: hidden;
				 position: absolute;
				 left: 640px;
				 top: 0;
				 width: 900px;
				 height: 100%;
				 padding-left: 260px;
				 background: #fff;
				 transition: transform 1.2s ease-in-out;
			}
			 .cont.s--signup .sub-cont {
				 transform: translate3d(-640px, 0, 0);
			}
			 button {
				 display: block;
				 margin: 0 auto;
				 width: 260px;
				 height: 36px;
				 border-radius: 30px;
				 color: #8a2be2;
				 font-size: 15px;
				 cursor: pointer;				 
				 border: 2px solid #8a2be2;
			}
			 button:hover {
				 transition: all 0.3s ease;
				 color: white;
				 background: #8a2be2;
				 border: 2px solid #8a2be2;
			}
			 .img {
				 overflow: hidden;
				 z-index: 2;
				 position: absolute;
				 left: 0;
				 top: 0;
				 width: 260px;
				 height: 100%;
				 padding-top: 360px;
			}
			 .img:before {
				 content: '';
				 position: absolute;
				 right: 0;
				 top: 0;
				 width: 900px;
				 height: 100%;
				 background-image: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/142996/paris.jpg');
				 background-size: cover;
				 transition: transform 1.2s ease-in-out;
			}
			 .img:after {
				 content: '';
				 position: absolute;
				 left: 0;
				 top: 0;
				 width: 100%;
				 height: 100%;
				 background: rgba(0, 0, 0, 0.25);
			}
			 .cont.s--signup .img:before {
				 transform: translate3d(640px, 0, 0);
			}
			 .img__text {
				 z-index: 2;
				 position: absolute;
				 left: 0;
				 top: 50px;
				 width: 100%;
				 padding: 0 20px;
				 text-align: center;
				 color: #fff;
				 transition: transform 1.2s ease-in-out;
			}
			 .img__text h2 {
				 margin-bottom: 10px;
				 font-weight: normal;
			}
			 .img__text p {
				 font-size: 14px;
				 line-height: 1.5;
			}
			 .cont.s--signup .img__text.m--up {
				 transform: translateX(520px);
			}
			 .img__text.m--in {
				 transform: translateX(-520px);
			}
			 .cont.s--signup .img__text.m--in {
				 transform: translateX(0);
			}
			 .img__btn {
				 overflow: hidden;
				 z-index: 2;
				 position: relative;
				 width: 100px;
				 height: 36px;
				 margin: 0 auto;
				 background: transparent;
				 color: #fff;
				 border: 2px solid #fff;
				 border-radius: 30px;
				 font-size: 15px;
				 cursor: pointer;
			}
			 .img__btn:after {
				 content: '';
				 z-index: 2;
				 position: absolute;
				 left: 0;
				 top: 0;
				 width: 100%;
				 height: 100%;
				 background: transparent;
				 color: #fff;
			}
			 .img__btn:hover {
				 overflow: hidden;
				 z-index: 2;
				 position: relative;
				 width: 100px;
				 height: 36px;
				 margin: 0 auto;
				 background: white;
				 color: black;
				 font-size: 15px;
				 border-radius: 30px;
				 transition: all 0.3s ease;
			}
			 .img__btn span {
				 position: absolute;
				 left: 0;
				 top: 0;
				 display: flex;
				 justify-content: center;
				 align-items: center;
				 width: 100%;
				 height: 100%;
				 transition: transform 1.2s;
			}
			 .img__btn span.m--in {
				 transform: translateY(-72px);
			}
			 .cont.s--signup .img__btn span.m--in {
				 transform: translateY(0);
			}
			 .cont.s--signup .img__btn span.m--up {
				 transform: translateY(72px);
			}
			 h2 {
				 width: 100%;
				 font-size: 26px;
				 text-align: center;
			}
			 label {
				 display: block;
				 width: 260px;
				 margin: 25px auto 0;
				 text-align: center;
			}
			 label span {
				 font-size: 14px;
				 color: #838383;
			}
			 label span.frequency {
				 font-size: 13px;
				 color: #FF66FF;
			}
			 input {
				 display: block;
				 width: 100%;
				 margin-top: 5px;
				 padding-bottom: 5px;
				 font-size: 16px;
				 border-bottom: 1px solid rgba(0, 0, 0, 0.4);
				 text-align: center;
			}
			 .submit {
				 margin-top: 40px;
				 margin-bottom: 20px;
				 background: #ffffff;
			}
			 .fb-btn {
				 border: 2px solid #00bfff;
				 color: #00bfff;
			}
			 .fb-btn:hover {
				 color: white;
				 background: #00bfff;
				 border: 2px solid #00bfff;
			}
			 .sign-in {
				 transition-timing-function: ease-out;
			}
			 .cont.s--signup .sign-in {
				 transition-timing-function: ease-in-out;
				 transition-duration: 1.2s;
				 transform: translate3d(640px, 0, 0);
			}
			 .sign-up {
				 transform: translate3d(-900px, 0, 0);
			}
			 .cont.s--signup .sign-up {
				 transform: translate3d(0, 0, 0);
			}
		</style>
	</head>	
	<body>
		<div class="back">
			<div class="cont">
				<div class="form sign-in">
					<form action="<?php $_PHP_SELF ?>" method="POST">
						<h2>Caesar Cipher</h2>
						<label>
							<span>Enter a Message or Code</span>
							<input name="caesar_text" type="text"/>
						</label>				
						<button name="submit" type="submit" class="submit" value="1">
							Encrypt
						</button>
						<button name="submit" type="submit" class="fb-btn" value="2">						
							Decrypt						
						</button>
						<label>
							<span>Result</span>
							<input type="text" value="<?php echo $message; ?>"/>
							<?php 						
								if ($message != "") :?>					
									<span>
										<?php echo "<br>Letter Frequency<br>"; ?>
									</span>	<?php
									$counter = 1;
									foreach (count_chars($message, 1) as $letters => $value) :?>
										<span class="frequency">
											<?php echo "【"; ?>
										</span>
										<span>
											<?php echo strtoupper(chr($letters)) . ": $value" ?>
										</span>
										<span class="frequency">
											<?php echo "】"; ?>
										</span> <?php
										if ($counter == 4 || $counter == 8 || $counter == 12 || $counter == 16 || $counter == 20 || $counter == 24 || $counter == 28)
											echo "<br>";
										$counter++;
									endforeach;
								endif; 
							?>						
						</label>
					</form>
				</div>			
				<div class="sub-cont">
					<div class="img">
						<div class="img__text m--up">
							<h2>Need more Encryption?</h2>
							<p>Try out Vernam Cipher for a more secure Encryption!</p>
						</div>
						<div class="img__text m--in">
							<h2>Want a more Simpler Cipher?</h2>
							<p>The classic Caesar Cipher is just what you need!</p>
						</div>
						<div class="img__btn">
							<span class="m--up">Vernam</span>
							<span class="m--in">Caesar</span>
						</div>
					</div>
					<div class="form sign-up">
						<form action="<?php $_PHP_SELF ?>" method="POST">
							<h2>Vernam Cipher</h2>
							<label>
								<span>Enter a Message or Code</span>
								<input name="vernam_text" type="text"/>
							</label>
							<button name="submit" type="submit" class="submit" id="vernam_encipher" value="3">
								Encrypt
							</button>	
							<label>
								<span>Enter a Key when Decrypting</span>
								<input name="vernam_key" type="text" value="<?php if (isset($_POST['vernam_text'])) {echo $message_and_key['key'];} ?>"/>
							</label>
							<br><br>
							<button name="submit" type="submit" class="fb-btn" value="4">						
								Decrypt						
							</button>						
							<label>
								<span>Result</span>
								<input type="text" value="<?php if (isset($_POST['vernam_text'])) {echo $message_and_key['message'];} ?>"/>
							</label>						
						</form>
					</div>
				</div>
			</div>
		</div>
	</body>	
	<script type="text/javascript">
		document.querySelector('.img__btn').addEventListener('click', function() {
			document.querySelector('.cont').classList.toggle('s--signup');
		});					
	</script>
</html>