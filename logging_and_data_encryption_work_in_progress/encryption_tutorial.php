<?php

include_once('lock_data.php');


/*Create an instance in order to encrypt/decrypt/hash/hash_check and key_management
to be able to unlock/lock certain data, as certain data may use different keys, while
data which are similiar such as text messages will use a different key, when compared
with user login data, just for security, it's good to diversify the keys, but also benefit in reusuing keys for related data*/

$lock_data = new lockData();

/*in order to encrypt/decrypt data we generate a key, and give it a name in relation
to the type of data we are dealing with, so email_ may have keyname email,text_messages
may have keyname text_messages for encrypting only text_messages etc.
 
These keys are then given a 30 long random character generated string, and stored in a file(which needs to be outside of the root directory*/

$lock_data->generate_key("email_credentials");
$lock_data->generate_key("text_messages");
$lock_data->generate_key("tmp");
//we can retrieve the random generated key value(to use for encryption/decryption):
echo $lock_data->get_key("email_credentials");

//delete a key
$lock_data->delete_key("tmp");

/*for storing user prompted passwords, use the hash function to hashpassword and hashcheck to then check if the hashed password (maybe taken from a database) matches the one entered by the user at login*/
$stored_password = $lock_data->hash_password("myPassword19");
echo $lock_data->check_password("myPassword19",$stored_password);

/*to encrypt data and decrypt data, we use the following, and choosing the approriately
 * generated key to use*/
$key_to_use = $lock_data->get_key("text_messages");
$text_message = "pretend this is a text message";
$enc = $lock_data->encrypt_string($text_message,'aes-128-ctr',$key_to_use);

echo "encrypted string = " . $enc;

/*decrypt, remember to the use the correct key you used to encrypt with*/
$decryp = $lock_data->decrypt_string($enc,'aes-128-ctr',$key_to_use);

echo "decrypted string = " . $decryp;



/*be sure to look in lock_data.php for where the keys are stored in a textfile,and to
 * be able to see the location and edit the location , makng sure it's outside
 * the web root*/




