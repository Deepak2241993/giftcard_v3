<?php
$uploadDir = 'deepak/';
$response = array();

if (isset($_FILES['upload']['name'])) {
    $file = $_FILES['upload']['tmp_name'];
    $file_name = $_FILES['upload']['name'];

    // Extract file extension
    $file_name_array = explode(".", $file_name);
    $extension = strtolower(end($file_name_array));

    // Generate a random name for the uploaded file
    $new_image_name = uniqid() . '.' . $extension;

    // Set the allowed file extensions
    $allowed_extensions = array("jpg", "gif", "png");

    // Check if the file extension is allowed
    if (in_array($extension, $allowed_extensions)) {
        // Check if the upload directory exists, and create it if not
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Move the uploaded file to the target directory with the new name
        if (move_uploaded_file($file, $uploadDir . $new_image_name)) {
            $response['url'] = "https://myforevermedspa.com/public/ckeditor/".$uploadDir . $new_image_name;
			$url=$response['url'];
			$function_number = $_GET['CKEditorFuncNum'];
			$message = '';
  echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($function_number, '$url', '$message');</script>";
        } 
		else {
            $response['error'] = 'Failed to upload the image';
        }
    }
	else {
        $response['error'] = 'Invalid file extension. Allowed extensions: jpg, gif, png';
    }
} 
else {
    $response['error'] = 'No file uploaded';
}

// Return the response as JSON
echo json_encode($response);
?>
