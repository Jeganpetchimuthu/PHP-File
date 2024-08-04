<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles.css"></link>
</head>
<body>
    <?php
    $message = "";
    $imagePath = "";
    
    if (isset($_FILES['image'])) {
        $allowedTypes = ['png', 'jpg', 'jpeg'];
        $fileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        
        if (!in_array($fileType, $allowedTypes)) {
            $message = "<div class='alert'>Image upload failed: invalid file type</div>";
        } elseif ($_FILES['image']['size'] > 307200) {
            $message = "<div class='alert'>Image upload failed: file size exceeds 300KB</div>";
        } else {
            $fileName = time() . "." . $fileType;
            $imagePath = "uploads/" . $fileName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $imagePath)) {
                $message = "<div></div>";
            } else {
                $message = "<div>Image upload failed</div>";
                $imagePath = ""; // Reset image path if upload failed
            }
        }
    }
    echo $message;
    ?>
<div class="Image-section">
    <form action="index.php" method="post" enctype="multipart/form-data">
        <div>
            <label  class="imageChoose">Choose Image</label>
            <input type="file" name="image" required   class="inputbtn"/>
        </div>
        <input type="submit" name="submit" value="Submit" class="submitBtns">
    </form>
</div>
    <?php if ($imagePath): ?>
        <div  class="uploadImage-Containers">
            <h2>Uploaded Image:</h2>
            <div  class="imageFlex">
           
            <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Uploaded Image"  class="multipleImageContent">
    </div>
        </div>
    <?php endif; ?>
</body>
</html>
