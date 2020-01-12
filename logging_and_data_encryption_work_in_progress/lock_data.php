<?php
define("KEYS","/p3t/keys.txt");
class lockData
{
	//properties
	public $keys = array();	
	
	//key management functions
	private function update_keys()
	{
		file_put_contents(KEYS,'<?php return ' . var_export($this->keys,true) . ';');
	}

	public function generate_key($key_name)
	{
		$this->update_keys();
		$random_string = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQUSTUVWXYZ'),1,30);
		$arr1 = array($key_name=>$random_string);
		$this->keys = include KEYS;
		$arr2 = array();
		$arr2 = $this->keys + $arr1;
		$this->keys = $arr2;

		$this->update_keys();

	}

	public function get_key($key_name)
	{
		$this->keys = include KEYS;
		return $this->keys[$key_name];
	}

	public function delete_key($key_name)
	{
		$this->keys = include KEYS;
		unset($this->keys[$key_name]);
		$this->update_keys();
	}

	public function print_available_keys()
	{
		$arr1 = $this->keys;
		$arr1 = include KEYS;

		//iterate through and print only the names of the keys, not
		//the key values

	}
	
	
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

	public function hash_password($password)
	{
		return password_hash($password,PASSWORD_DEFAULT);
	}

	public function check_password($password,$hashed_password)
	{
		if(password_verify($password,$hashed_password))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	

}
