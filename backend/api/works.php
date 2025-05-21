<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/xml');

echo file_get_contents('../data/works.xml');
