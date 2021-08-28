<?php 
	$upload_errors = array(
		0 => 'There is no error, the file uploaded with success',
  		1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    	2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    	3 => 'The uploaded file was only partially uploaded',
    	4 => 'No file was uploaded',
    	6 => 'Missing a temporary folder',
    	7 => 'Failed to write file to disk.',
    	8 => 'A PHP extension stopped the file upload.',
	);

	if (isset($_POST["submit"])) {
		// process the form data
		$tmp_file = $_FILES["file_upload"]["tmp_name"];
		$target_file = basename($_FILES["file_upload"]["name"]);
		$upload_dir = "file_uploaded";

		// You will probably want to first use file_exist() to make sure
		// there isn't already a file by the same names.
		// move_uploaded_file will return false if $tmp_file is not a valid upload file
		// or if it cannot be moved for any other trason
		// The directory for uploading files need the chmod 777(drwxrwxrwx) permision.
		if (move_uploaded_file($tmp_file, $upload_dir . "/" . $target_file )) {
			$message = "File uploaded successfully.";
		} else {
			$error = $_FILES['file_upload']['error'];
			$message = $upload_errors[$error];
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Upload</title>
</head>
<body>
	<?php 
		// The maximum file size (in bytes) must be declared before the file input field
		// and can't be larger than the setting for upload_max_filesize in php.ini.
		// 
		// This form value can be manipulated. You should stilluse it,but you rely
		// on upload_max_filesize as the absolute limit.
		// 
		// Think of it as a polite declaration : "Hey PHP, here comes a file less than X..."
		// PHP will stop and complain once X is exxeeded
		// 
		// 1 megabyte is actually 1,048,576 bytes.
		// You can round it unless the precision matters.
	?>

	<?php 
		if (!empty($message)) {
			echo "<p>{$message}</p>";
		}
	?>
	<form action="upload.php" enctype="multipart/form-data" method="post">
		
		<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
		<input type="file" name="file_upload">

		<input type="submit" name="submit" value="Upload">
	</form>
</body>
</html>