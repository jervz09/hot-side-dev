<?php

	function decamelize($string) {
		return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', preg_replace('/\s+/', '', $string)));
	}

	function let_crypt($string, $encrypt = false){

		// Store the cipher method
		$ciphering = "AES-128-CTR";

		// Use OpenSSl Encryption method
		$iv_length = openssl_cipher_iv_length($ciphering);
		$options = 0;

		// Non-NULL Initialization Vector for encryption
		$crypt_iv = '1234567891011121';

		// Store the encryption key
		$crypt_key = "h0ts1d3R3sT0b4R";
		// echo openssl_decrypt(base64_decode("aEt0Z2hHTnV2Q2hlQ0p4NWZoZWxmT3FycFI4Q3NadjNlSEFFY29WTWh2MEJxQkJR"), $ciphering,
		// $crypt_key, $options, $crypt_iv);
		if($encrypt){
		// Use openssl_encrypt() function to encrypt the data
			return base64_encode(openssl_encrypt($string, $ciphering,
					$crypt_key, $options, $crypt_iv));
		}else{
		// Use openssl_decrypt() function to decrypt the data
			return openssl_decrypt(base64_decode($string), $ciphering,
				$crypt_key, $options, $crypt_iv);
		}
	}

?>