<?php
function isalphanum($value) {
	if (preg_match('/^[a-zA-Z0-9]+$/', $value)) {
		return true;
	} else {
		return false;
	}
}

function isnum($value) {
	if (preg_match('/^[0-9]+$/', $value)) {
		return true;
	} else {
		return false;
	}
}
?>
