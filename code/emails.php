<?php
$replyemail="CWLPEmail@gmail.com"; // email address

//clean input in case of header injection attempts!
function clean_input_4email($value, $check_all_patterns = true) {
	$patterns[0] = '/content-type:/i';
	$patterns[1] = '/to:/i';
	$patterns[2] = '/cc:/i';
	$patterns[3] = '/bcc:/i';
	if ($check_all_patterns) {
		$patterns[4] = '/\r/';
		$patterns[5] = '/\n/';
		$patterns[6] = '/%0a/';
		$patterns[7] = '/%0d/';
	};
	//NOTE: can use str_ireplace as this is case insensitive but only available on PHP version 5.0.
	return preg_replace($patterns, "", $value);
};

function check_email_address($email) {
	// From http://www.ilovejackdaniels.com/php/email-address-validation/
	
	// First, we check that there's one @ symbol, and that the lengths are right
	if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
		// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		return false;
	};
	// Split it into sections to make life easier
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++) {
		if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
			return false;
		};
	};
	if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2) {
			return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++) {
			if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
				return false;
			};
		};
	};
	return true;
}; // check_email_address

function valid_referer($path) {
  $valid_ref1="http://www.cupwithlove.org/$path"; // valid source of input
  $valid_ref2="http://cupwithlove.org/$path";// valid source of input
  
  $ref_page = $_SERVER["HTTP_REFERER"];
	return ($ref_page != $valid_ref1 && $ref_page != $valid_ref2 );
}

?>