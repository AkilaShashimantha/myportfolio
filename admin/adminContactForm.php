<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Details</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="style.css">
</head>
<body class="m-0 p-2">
    
<?php
include 'adminHeader.php';
require_once '../connection.php';

// Fetch current profile image
$profile = Database::select("SELECT * FROM profile LIMIT 1");
$currentImage = $profile && count($profile) > 0 ? $profile[0]['image'] : null;

// --- CONTACT FIELD UPDATE LOGIC ---
$allowed = ['email', 'whatsapp', 'instagram', 'linkedin', 'facebook', 'threads', 'github'];
// Fetch current contact details
$contact = Database::select("SELECT * FROM contact_details LIMIT 1");
$contact = $contact && count($contact) > 0 ? $contact[0] : array_fill_keys($allowed, '');

// Handle single field update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_field'])) {
    $field = $_POST['update_field'];
    $value = $_POST[$field] ?? '';
    if (in_array($field, $allowed)) {
        if ($contact && isset($contact['id'])) {
            Database::iud("UPDATE contact_details SET `$field`=? WHERE id=?", [$value, $contact['id']], "si");
        } else {
            // Insert new row if not exists
            $fields = array_fill_keys($allowed, '');
            $fields[$field] = $value;
            Database::iud("INSERT INTO contact_details (email, whatsapp, instagram, linkedin, facebook, threads, github) VALUES (?, ?, ?, ?, ?, ?, ?)",
                array_values($fields), "sssssss");
        }
        header("Location: adminContactForm.php");
        exit;
    }
}

// --- IMAGE UPLOAD/UPDATE/DELETE LOGIC ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['add']) || isset($_POST['update']) || isset($_POST['delete']))) {
    // Add or Update
    if (isset($_POST['add']) || isset($_POST['update'])) {
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
            $newName = uniqid('profile_', true) . '.' . $ext;
            $target = "../images/profile_image/" . $newName;
            if (!is_dir("../images/profile_image")) mkdir("../images/profile_image", 0777, true);
            move_uploaded_file($_FILES['profile_image']['tmp_name'], $target);

            // Remove old image if updating
            if ($currentImage && file_exists("../images/profile_image/" . $currentImage)) {
                unlink("../images/profile_image/" . $currentImage);
            }

            // Update DB
            if ($profile && count($profile) > 0) {
                Database::iud("UPDATE profile SET image=? WHERE id=?", [$newName, $profile[0]['id']], "si");
            } else {
                Database::iud("INSERT INTO profile (image) VALUES (?)", [$newName], "s");
            }
            $currentImage = $newName;
        }
    }
    // Delete
    if (isset($_POST['delete'])) {
        if ($currentImage && file_exists("../images/profile_image/" . $currentImage)) {
            unlink("../images/profile_image/" . $currentImage);
        }
        Database::iud("UPDATE profile SET image=NULL WHERE id=?", [$profile[0]['id']], "i");
        $currentImage = null;
    }
    header("Location: adminContactForm.php");
    exit;
}

// For displaying the image in the form and for JS preview
$imageUrl = $currentImage ? "../images/profile_image/$currentImage" : "https://ui-avatars.com/api/?name=Profile&background=ccc&color=fff";
?>

<!-- Contact Details Form -->
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="bg-white p-4 rounded shadow-sm mt-4 text-center">
                <h3 class="mb-4">Profile Image</h3>
                <form method="post" enctype="multipart/form-data" class="mb-3">
                    <div class="d-flex justify-content-center align-items-center mb-3">
                        <div class="circle-image me-3" id="profilePreview" style="background-image: url('<?php echo $imageUrl; ?>');"></div>
                        <div class="image2" style="background-image: url('<?php echo $imageUrl; ?>');"></div>
                    </div>
                    <input type="file" name="profile_image" id="profile_image" accept="image/*" class="form-control mb-3" onchange="previewProfileImage(event)">
                    <div class="d-flex justify-content-center gap-2">
                        <button type="submit" name="add" class="btn btn-success"<?php if($currentImage) echo ' disabled'; ?>>Add</button>
                        <button type="submit" name="update" class="btn btn-primary"<?php if(!$currentImage) echo ' disabled'; ?>>Update</button>
                        <button type="submit" name="delete" class="btn btn-danger"<?php if(!$currentImage) echo ' disabled'; ?>>Delete</button>
                    </div>
                </form>
                <small class="text-muted">Choose an image to set as your profile. This image will be used as the site icon and profile display.</small>
            </div>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="bg-white p-4 rounded shadow-sm mt-4">
                <h3 class="mb-4 text-center">Contact Details</h3>
                <form method="post" class="mb-3 d-flex align-items-center gap-2">
                    <label class="form-label mb-0" style="width:140px;">Email Address</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($contact['email']); ?>">
                    <button type="submit" name="update_field" value="email" class="btn btn-primary">Save</button>
                </form>
                <form method="post" class="mb-3 d-flex align-items-center gap-2">
                    <label class="form-label mb-0" style="width:140px;">Whatsapp Number</label>
                    <input type="text" name="whatsapp" class="form-control" value="<?php echo htmlspecialchars($contact['whatsapp']); ?>">
                    <button type="submit" name="update_field" value="whatsapp" class="btn btn-primary">Save</button>
                </form>
                <form method="post" class="mb-3 d-flex align-items-center gap-2">
                    <label class="form-label mb-0" style="width:140px;">Instagram Link</label>
                    <input type="url" name="instagram" class="form-control" value="<?php echo htmlspecialchars($contact['instagram']); ?>">
                    <button type="submit" name="update_field" value="instagram" class="btn btn-primary">Save</button>
                </form>
                <form method="post" class="mb-3 d-flex align-items-center gap-2">
                    <label class="form-label mb-0" style="width:140px;">LinkedIn Link</label>
                    <input type="url" name="linkedin" class="form-control" value="<?php echo htmlspecialchars($contact['linkedin']); ?>">
                    <button type="submit" name="update_field" value="linkedin" class="btn btn-primary">Save</button>
                </form>
                <form method="post" class="mb-3 d-flex align-items-center gap-2">
                    <label class="form-label mb-0" style="width:140px;">Facebook Link</label>
                    <input type="url" name="facebook" class="form-control" value="<?php echo htmlspecialchars($contact['facebook']); ?>">
                    <button type="submit" name="update_field" value="facebook" class="btn btn-primary">Save</button>
                </form>
                <form method="post" class="mb-3 d-flex align-items-center gap-2">
                    <label class="form-label mb-0" style="width:140px;">Threads Link</label>
                    <input type="url" name="threads" class="form-control" value="<?php echo htmlspecialchars($contact['threads']); ?>">
                    <button type="submit" name="update_field" value="threads" class="btn btn-primary">Save</button>
                </form>
                <form method="post" class="mb-3 d-flex align-items-center gap-2">
                    <label class="form-label mb-0" style="width:140px;">Github Link</label>
                    <input type="url" name="github" class="form-control" value="<?php echo htmlspecialchars($contact['github']); ?>">
                    <button type="submit" name="update_field" value="github" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function previewProfileImage(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('profilePreview').style.backgroundImage = `url('${e.target.result}')`;
        // Also update .image2 if present
        let img2 = document.querySelector('.image2');
        if(img2) img2.style.backgroundImage = `url('${e.target.result}')`;
    };
    reader.readAsDataURL(file);
}
</script>

<!-- Optionally, update the favicon dynamically if you want -->
<?php if ($currentImage): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    let link = document.querySelector("link[rel~='icon']");
    if (!link) {
        link = document.createElement('link');
        link.rel = 'icon';
        document.head.appendChild(link);
    }
    link.href = "<?php echo $imageUrl; ?>";
});
</script>
<?php endif; ?>

</body>
</html>