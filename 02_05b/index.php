<?php

function print_array($a)
{
	echo '<pre>';
	var_dump($a);
	echo '</pre>';
}

function get_users()
{
	return file_get_contents('visits.txt');
}

function log_visit()
{
	$visits = (int)file_get_contents('visits.txt');
	$visits++;
	file_put_contents('visits.txt', $visits);
}

if (!isset($_COOKIE['visited'])) {
	setcookie('visited', true, time() + (86400 * 30));
	log_visit();
}

function sanitize_form()
{
	print_array($_POST);
	foreach ($_POST as $name => $value) {
		switch ($name) {
			case 'email':
				echo 'in email';
				$value = filter_var($value, FILTER_SANITIZE_EMAIL);
				break;
			case 'message':
				echo 'in email';
				$value = filter_var(htmlspecialchars($value), FILTER_SANITIZE_ADD_SLASHES);
				break;
			case 'phoneNumber':
				$value = preg_replace('/\D/', '', $value);
				if (strlen($value) != 10) {
					$value = '';
				} else {
					$value = '(' . substr($value, 0, 3) . ') ' . substr($value, 3, 3) . '-' . substr($value, 6); // Format to (xxx) xxx-xxxx
				}
				break;
			default:
				$value = filter_var(preg_replace('/[^A-Za-z0-9 \-]/', '', $value), FILTER_SANITIZE_ADD_SLASHES);
		}
		$_POST[$name] = $value;
	}

	return true;
}

if (isset($_POST['submit'])) {
	sanitize_form();
	print_array($_POST);
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Validate my Form</title>
	<meta name="author" value="Joe Casabona" />
	<style>
		body {
			background: #EFEFEF;
		}

		main {
			max-width: 800px;
			padding: 20px;
			margin: 0 auto;
			background: #FFFFFF;
			font-size: 1.5rem;
		}

		div {
			margin: 35px;
		}

		input,
		textarea {
			font-size: 1.25rem;
			padding: 5px;
			width: 95%;
			border: 1px solid #DDDDDD;
		}
	</style>
</head>

<body>
	<main>
		<h1>Contact Me</h1>
		<form name="contact" method="POST" id="contact">
			<div>
				<label for="name">Your Name*:</label><br />
				<input type="text" name="name" required />
			</div>
			<div>
				<label for="email">Your Email*:</label><br />
				<input type="email" name="email" required />
			</div>
			<div>
				<label for="message">Your Message*:</label><br />
				<textarea name="message" required></textarea>
			</div>
			<div>
				<label for="phoneNumber">Your Phone Number*:</label><br />
				<input type="tel" name="phoneNumber" required pattern="\(\d{3}\) \d{3}-\d{4}" title="Phone number must be in the format: (xxx) xxx-xxxx" />
			</div>
			<div><input type="submit" name="submit" value="Contact Me" /></div>
		</form>
	</main>
	<p><b><?php echo get_users(); ?></b> users have visited this site.</p>
</body>

</html>