<?php
$errors = array();
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $uploadDir = 'uploads/';
    $authorizedType = ["image/png", "image/jpeg", "image/gif", "image/webp"];
    $extension = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));
    $errorFile = $_FILES['avatar']['error'];
    $maxFileSize = 1000000;
    if ($errorFile === 0) {
        if ((!in_array(mime_content_type($_FILES['avatar']['tmp_name']), $authorizedType))) {
            $errors[] = 'Veuillez sélectionner une image de type jpg, png, gif ou webp !';
        } else if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
            $errors[] = "Votre fichier doit faire moins de 1M !";
        } else {
            $uniqueFileName =  $uploadDir . uniqid("", true) . "." . $extension;
            if (!move_uploaded_file($_FILES['avatar']['tmp_name'], $uniqueFileName))
                $errors[] = "Echec upload de votre fichier!";
        }
    } else
        $errors[] = "Anomalie sur votre fichier!";
}
?>
<form method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <h2>Upload a profile image</h2>
            <?php foreach ($errors as $err) : ?>
                <?php echo $err ?><br>
            <?php endforeach ?>
        </tr>
        <tr>
            <td>
                <label for="imageUpload">Image File :<br>png, jpg/jpeg, gif, webp</label>
                <input type="file" name="avatar" accept="image/png, image/jpeg, image/gif, image/webp" id=" imageUpload" />
            </td>
            <td>
                <br>
                <button name="send">Upload File</button>
            </td>
        </tr>
    </table>
</form>