<?php
if (isset($_GET['message'])) {
    $message = htmlspecialchars($_GET['message']);
} else {
    $message = "Registration successful!";
}
?>
<html>
<head>
<title>Registration Success</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
<div class="message success"><?php echo $message; ?></div>
</body>
</html>
