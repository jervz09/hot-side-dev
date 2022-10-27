<?php

	function decamelize($string) {
		return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', preg_replace('/\s+/', '', $string)));
	}

?>