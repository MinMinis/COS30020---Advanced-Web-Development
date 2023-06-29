<?php
function sanitize_input($data)
{
    $data = trim($data); // remove all white space
    $data = stripslashes($data); // remove any backslashes
    $data = htmlspecialchars($data); // converts any special characters to HTML entity
    return $data;
}
