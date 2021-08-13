<?php
$pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!^(){}<>%@#&*+=_-])[^\s$`,.\/\\;:|]{8,40}$/';
$subject = 'mayurS123@';
$matches = array();
$result = preg_match ($pattern, $subject, $matches);
var_dump($result);
?>