<?php
require_once("bootstrap.php");

if ($dbh->checkAdmin($_SESSION['idutente']) && isset($_POST['action'])) {
    if ($_POST['action'] === "add-pony" && isset($_POST['name']) && isset($_POST['breed'])
    && isset($_POST['hourly-fee']) && isset($_FILES['image'])
    && isset($_POST['special-marks']) && isset($_POST['description'])) {

        $name = htmlspecialchars(trim($_POST['name']));
        $breed = htmlspecialchars(trim($_POST['breed']));
        $special_marks = htmlspecialchars(trim($_POST['special-marks']));
        if (strlen($special_marks) === 0) {
            $special_marks = null;
        }
        $description = htmlspecialchars(trim($_POST['description']));
        if (strlen($description) === 0) {
            $description = null;
        }
        $is_available = isset($_POST['is-available']);

        $addition_successful = false;

        if (strlen($name) > 0 && strlen($breed) > 0) {
            // Upload the image only if all the parameters are valid
            $image_name = upload_image($_FILES['image']);
            if ($image_name !== null) {
                $addition_successful = $dbh->add_pony($name, $breed, floatval($_POST['hourly-fee']),
                $image_name, $special_marks, $description, $is_available);
            }
        }

        header('location: pony.php?operation-successful=' . ($addition_successful ? "true" : "false"));
        exit();
    } else if ($_POST['action'] === "edit-pony" && isset($_POST['name'])
      && isset($_POST['breed']) && isset($_POST['hourly-fee'])
      && isset($_POST['special-marks']) && isset($_POST['description'])
      && isset($_POST['pony-id']) && isset($_POST['old-image-name'])) {
            
        $name = htmlspecialchars(trim($_POST['name']));
        $breed = htmlspecialchars(trim($_POST['breed']));
        $special_marks = htmlspecialchars(trim($_POST['special-marks']));
        if (strlen($special_marks) === 0) {
            $special_marks = null;
        }
        $description = htmlspecialchars(trim($_POST['description']));
        if (strlen($description) === 0) {
            $description = null;
        }
        $edit_successful = false;
            
        if (strlen($name) > 0 && strlen($breed) > 0) {
            // Upload the image only if all the parameters are valid
            $image_name = isset($_FILES['image']) && strlen($_FILES["image"]["name"]) > 0 ? upload_image($_FILES['image']) : $_POST['old-image-name'];
            if ($image_name !== null) {
                $edit_successful = $dbh->edit_pony(intval($_POST['pony-id']), $name, $breed,
                floatval($_POST['hourly-fee']), $image_name, $special_marks, $description);
            }
        }

        header('location: pony.php?operation-successful=' . ($edit_successful ? "true" : "false"));
        exit();
    } else {
        header('location: pony.php?operation-successful=false');
        exit();
    }
} else {
    header('location: pony.php?operation-successful=false');
    exit();
}
?>
