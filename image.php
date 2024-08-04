<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles.css"></link>
</head>
<body>
<div class="Image-section">
<form action="image.php" method="post" enctype="multipart/form-data">
    <div>
        <label class="imageChoose">Choose Images :</label>
        <input type="file" name="images[]" multiple required class="inputbtn"/>
    </div>
    <input  class="submitBtns" type="submit" name="submit" value="Submit">
</form>
</div>

<?php
$message = "";
$imagePaths = []; 

if (isset($_FILES['images'])) {
    $allowedTypes = ['png', 'jpg', 'jpeg'];
    $fileCount = count($_FILES['images']['name']);
    
    for ($i = 0; $i < $fileCount; $i++) {
        $fileName = $_FILES['images']['name'][$i];
        $fileTmpName = $_FILES['images']['tmp_name'][$i];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $fileSize = $_FILES['images']['size'][$i];

        if (!in_array($fileType, $allowedTypes)) {
            $message .= "<div class='alert'>Image upload failed: $fileName is an invalid file type.</div>";
        } elseif ($fileSize > 307200) {
            $message .= "<div class='alert'>Image upload failed: $fileName exceeds 300KB size limit.</div>";
        } else {
            $newFileName = time() . "_" . $i . "." . $fileType;
            $imagePath = "uploads/" . $newFileName;

            if (move_uploaded_file($fileTmpName, $imagePath)) {
                $imagePaths[] = $imagePath; 
                $message .= "<div></div>";
            } else {
                $message .= "<div>Image upload failed: $fileName</div>";
            }
        }
    }
}
echo $message;
?>

<?php if (!empty($imagePaths)): ?>
    <div class="uploadImage-Containers">
        <h2>Uploaded Images:</h2>
        <?php foreach ($imagePaths as $path): ?>
            <div class="imageFlex">
                <img src="<?php echo htmlspecialchars($path); ?>" alt="Uploaded Image" class="multipleImageContent"/>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

</body>
</html>
