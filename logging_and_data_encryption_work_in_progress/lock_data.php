<?php

class lockData
{
	
	//constructor
	private function hash_key($key)
	{
		return openssl_digest($key,'SHA256',TRUE);

	}
	private function generate_encryption_length($cipher_method)
	{
		return openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
	}

	public function encrypt_string($sensitive_data,$cipher_method,$key)
	{
		$enc_key = $this->hash_key($key);
		$enc_length = $this->generate_encryption_length($cipher_method);
		$protected_data = openssl_encrypt($sensitive_data,$cipher_method,$enc_key,0,$enc_length) . "::" . bin2hex($enc_length);
		unset($enc_key,$enc_length);
		return $protected_data;
	}

	public function decrypt_string($protected_data,$cipher_method,$key)
	{
		$enc_length;
		list($protected_data,$enc_length) = explode("::",$protected_data);
		$enc_key = $this->hash_key($key);
		
		$unprotected_data = openssl_decrypt($protected_data,$cipher_method,$enc_key,0,hex2bin($enc_length));
		unset($enc_key);
		return $unprotected_data;
			
	}

//	Todo: Create function for hashing password and comparing hashed passwords

}
