<?php
	
function splitURL() {
	$url = array_slice(array_filter(explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))), 1);
	return $url;
}

?>

<?php

$url = splitURL();
$path = '/';

if(count($url) >= 2) {
	$url = [$url[0], $url[1]];
}

$urlLen = count($url);

foreach($url as $key => $value) {
	$path = $path.''.$value.'/';	
	if($key < $urlLen - 1):

?>			
		<a href="<?php echo URLROOT.''.$path ?>"><span><?php echo ucwords(str_replace('_', ' ', $value)); ?></span></a>
		<span class="text-neutral-400"> / </span>

<?php

	else:

?>

		<span class="text-neutral-400"><?php echo ucwords(str_replace('_', ' ', $value)) ; ?></span>

<?php

	endif;
}

?>
