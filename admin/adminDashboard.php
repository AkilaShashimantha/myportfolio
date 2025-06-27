<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: adminLogin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="style.css">
</head>
<body class=" p-2 m-0">

<?php include 'adminHeader.php'; ?>

<div class=" container-fluid">
<div class=" row">

<!-- Services -->
<div class="col-12  p-2">
<div class="row justify-content-center">

<div class="col-12 d-flex justify-content-center ">
<p class=" fs-3 ">Services</p>
</div>

<div class=" col-12 ">

<div class="row">

<div class="col-12 col-lg-12 d-flex justify-content-center">

<?php
include '../connection.php';

// Set $edit_service before rendering the form
$edit_service = null;
if (isset($_POST['edit_service_id'])) {
    $edit_id = intval($_POST['edit_service_id']);
    $result = Database::select("SELECT * FROM services WHERE id = ?", [$edit_id], "i");
    if ($result && count($result) > 0) {
        $edit_service = $result[0];
    }
}

// Handle delete
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_service_id'])) {
    $delete_id = intval($_POST['delete_service_id']);
    try {
        Database::iud(
            "DELETE FROM services WHERE id = ?",
            [$delete_id],
            "i"
        );
        $success = "Service deleted successfully!";
    } catch (Exception $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_service'])) {
    $id = intval($_POST['service_id']);
    $title = trim($_POST['service_type']);
    $description = trim($_POST['serviceDescription']);

    if ($title !== "" && $description !== "") {
        try {
            Database::iud(
                "UPDATE services SET title = ?, description = ?, updated_at = NOW() WHERE id = ?",
                [$title, $description, $id],
                "ssi"
            );
            $success = "Service updated successfully!";
            $edit_service = null; // Reset form after update
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
// Handle add
else if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_service'])) {
    $title = trim($_POST['service_type']);
    $description = trim($_POST['serviceDescription']);

    if ($title !== "" && $description !== "") {
        try {
            Database::iud(
                "INSERT INTO services (title, description, created_at, updated_at) VALUES (?, ?, NOW(), NOW())",
                [$title, $description],
                "ss"
            );
            $success = "Service added successfully!";
        } catch (Exception $e) {
            $error = "Error: " . $e->getMessage();
        }
    } else {
        $error = "Please fill in all fields.";
    }
}

// Fetch all services
$all_services = Database::select("SELECT * FROM services");
?>

<?php if (isset($success)): ?>
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" role="alert" style="z-index:9999; min-width:300px;">
        <?php echo $success; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
<?php if (isset($error)): ?>
    <div class="alert alert-danger alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" role="alert" style="z-index:9999; min-width:300px;">
        <?php echo $error; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>

<div class=" col-12">

<div class=" col-10 col-lg-6">
<!-- Services Form -->
<div class="bg-white p-4 rounded shadow-sm mb-5 ">
    <form action="" method="post" class="form-control border-0 bg-white">
        <?php if ($edit_service): ?>
            <input type="hidden" name="service_id" value="<?php echo $edit_service['id']; ?>">
        <?php endif; ?>
        <div class="row">
            <div class="col-12"><label class="form-label text-dark">Services type</label></div>
            <div class="col-12 mb-3">
                <input type="text" name="service_type" id="service_type" class="form-control"
                    value="<?php echo $edit_service ? htmlspecialchars($edit_service['title']) : ''; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col-12"><label class="form-label text-dark">Description</label></div>
            <div class="col-12 mb-3">
                <textarea name="serviceDescription" class="form-control" style="height: 200px;"><?php echo $edit_service ? htmlspecialchars($edit_service['description']) : ''; ?></textarea>
            </div>
            <div class="col-12 d-flex justify-content-center gap-2">
                <?php if ($edit_service): ?>
                    <button type="submit" name="update_service" class="btn btn-success col-5 mt-2">Update</button>
                    <a href="adminDashboard.php" class="btn btn-secondary col-5 mt-2 ms-2">Cancel</a>
                <?php else: ?>
                    <button type="submit" name="add_service" class="btn btn-outline-primary col-5 mt-2">Submit</button>
                <?php endif; ?>
            </div>
        </div>
    </form>
</div>

</div>


<div class="row">


<!-- Existing Services Table -->
<div class="bg-light p-4 rounded shadow-sm mb-5 ">
    <h5 class="mb-4">Existing Services</h5>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th style="width: 160px;">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($all_services as $srv): ?>
            <tr>
                <td><?php echo htmlspecialchars($srv['title']); ?></td>
                <td><?php echo htmlspecialchars($srv['description']); ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="edit_service_id" value="<?php echo $srv['id']; ?>">
                        <button type="submit" class="btn btn-sm btn-warning me-2">Edit</button>
                    </form>
                    <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this service?');">
                        <input type="hidden" name="delete_service_id" value="<?php echo $srv['id']; ?>">
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

</div>

</div>

<script>
// Auto-dismiss alerts after 3 seconds
setTimeout(function() {
    document.querySelectorAll('.alert').forEach(function(alertNode) {
        var bsAlert = bootstrap.Alert.getOrCreateInstance(alertNode);
        bsAlert.close();
    });
}, 3000);
</script>
</div>

</div>
</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>



