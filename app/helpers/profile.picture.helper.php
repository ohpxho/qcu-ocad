<?php


function generateProfilePictureFromLetter($letter) {
	$letter = strtoupper($letter);
	echo "<div class='flex items-center justify-center w-full rounded-sm h-full bg-slate-300 text-slate-700'>$letter</div>";
	return;
}


?>