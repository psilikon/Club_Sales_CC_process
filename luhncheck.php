
<?php


function luhn_check($number) {

  // Strip any non-digits (useful for credit card numbers with spaces and hyphens)
  $number=preg_replace('/\D/', '', $number);

  // Set the string length and parity
  $number_length=strlen($number);
  $parity=$number_length % 2;

  // Loop through each digit and do the maths
  $total=0;
  for ($i=0; $i<$number_length; $i++) {
    $digit=$number[$i];
    // Multiply alternate digits by two
    if ($i % 2 == $parity) {
      $digit*=2;
      // If the sum is two digits, add them together (in effect)
      if ($digit > 9) {
        $digit-=9;
      }
    }
    // Total up the digits
    $total+=$digit;
  }

  // If the total mod 10 equals 0, the number is valid
	if ($total % 10 == 0) {
		$valid = 'TRUE';
	} else {
		$valid = 'FALSE';
	}
	return $valid;
}

$validMod = luhn_check($_POST['ccnum']);

$binnum = substr($_POST['ccnum'], 0, 6);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://www.binlist.net/json/$binnum");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Accept: application/json'
));

$resp = curl_exec($ch);
$resp = json_decode($resp, true);

$newArray = array('modcheck'=>$validMod);

$result = array_merge((array)$resp, (array)$newArray);

$json = json_encode($result);
echo $json;
curl_close($ch);

?>
