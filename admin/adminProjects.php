<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="style.css">
</head>
<body class=" p-2 m-0">
    

<?php

include 'adminHeader.php';
require_once '../connection.php';


// Handle Add Project
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_project'])) {
    $name = trim($_POST['projectName']);
    $short_desc = trim($_POST['projectShortDescription']);
    $full_desc = trim($_POST['projectFullDescription']);
    $github = trim($_POST['projectGitRepo']);
    $image = $_FILES['projectImage'];

    $img_name = null;
    if ($image['name']) {
        $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        $img_name = uniqid('proj_', true) . '.' . $ext;
        move_uploaded_file($image['tmp_name'], "../images/projects/" . $img_name);
    }

    $img1 = $img2 = $img3 = null;
    foreach (['image1', 'image2', 'image3'] as $idx => $imgField) {
        if (!empty($_FILES[$imgField]['name'])) {
            $ext = strtolower(pathinfo($_FILES[$imgField]['name'], PATHINFO_EXTENSION));
            ${"img".($idx+1)} = uniqid('proj_', true) . '.' . $ext;
            move_uploaded_file($_FILES[$imgField]['tmp_name'], "../images/projects/" . ${"img".($idx+1)});
        }
    }

    if ($name && $short_desc && $full_desc && $github && $img_name) {
        Database::iud(
            "INSERT INTO projects (name, short_description, full_description, github_link, featured_image, image1, image2, image3, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())",
            [$name, $short_desc, $full_desc, $github, $img_name, $img1, $img2, $img3],
            "ssssssss"
        );
        $success = "Project added!";
    } else {
        $error = "All fields are required.";
    }
}

// Handle Edit Project
$edit_project = null;
if (isset($_POST['edit_project_id'])) {
    $edit_id = intval($_POST['edit_project_id']);
    $result = Database::select("SELECT * FROM projects WHERE id = ?", [$edit_id], "i");
    if ($result && count($result) > 0) {
        $edit_project = $result[0];
    }
}

// Handle Update Project
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_project'])) {
    $id = intval($_POST['project_id']);
    $name = trim($_POST['projectName']);
    $short_desc = trim($_POST['projectShortDescription']);
    $full_desc = trim($_POST['projectFullDescription']);
    $github = trim($_POST['projectGitRepo']);
    $img_name = $_POST['old_image'];

    $img1 = $_POST['old_image1'] ?? null;
    $img2 = $_POST['old_image2'] ?? null;
    $img3 = $_POST['old_image3'] ?? null;
    foreach (['image1', 'image2', 'image3'] as $idx => $imgField) {
        if (!empty($_FILES[$imgField]['name'])) {
            $ext = strtolower(pathinfo($_FILES[$imgField]['name'], PATHINFO_EXTENSION));
            ${"img".($idx+1)} = uniqid('proj_', true) . '.' . $ext;
            move_uploaded_file($_FILES[$imgField]['tmp_name'], "../images/projects/" . ${"img".($idx+1)});
        }
    }

    if ($name && $short_desc && $full_desc && $github && $img_name) {
        Database::iud(
            "UPDATE projects SET name=?, short_description=?, full_description=?, github_link=?, featured_image=?, image1=?, image2=?, image3=?, updated_at=NOW() WHERE id=?",
            [$name, $short_desc, $full_desc, $github, $img_name, $img1, $img2, $img3, $id],
            "ssssssssi"
        );
        $success = "Project updated!";
        $edit_project = null;
    } else {
        $error = "All fields are required.";
    }
}

// Handle Delete Project
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_project_id'])) {
    $delete_id = intval($_POST['delete_project_id']);
    Database::iud("DELETE FROM projects WHERE id = ?", [$delete_id], "i");
    $success = "Project deleted!";
}

// Fetch all projects
$all_projects = Database::select("SELECT * FROM projects ORDER BY created_at DESC");
?>
<!-- Paste your projects form and table HTML/PHP here -->


<!-- Project Form -->
<div class="container-fluid">
  <div class="row justify-content-center align-items-start">
    <!-- Project Form (Left Side) -->
    <div class="col-12 col-md-5 col-lg-4 d-flex flex-column align-items-center mt-5">
      <h3 class="text-center mb-3"><?php echo $edit_project ? "Edit Project" : "Add Project"; ?></h3>
      <div class="bg-white p-4 rounded shadow-sm w-100 mb-4">
        <form action="" method="post" enctype="multipart/form-data" class="form-control border-0 bg-white">
            <?php if ($edit_project): ?>
                <input type="hidden" name="project_id" value="<?php echo $edit_project['id']; ?>">
                <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($edit_project['featured_image']); ?>">
                <input type="hidden" name="old_image1" value="<?php echo htmlspecialchars($edit_project['image1']); ?>">
                <input type="hidden" name="old_image2" value="<?php echo htmlspecialchars($edit_project['image2']); ?>">
                <input type="hidden" name="old_image3" value="<?php echo htmlspecialchars($edit_project['image3']); ?>">
            <?php endif; ?>
            <div class="mb-3">
                <label class="form-label">Project Name</label>
                <input type="text" name="projectName" class="form-control" value="<?php echo $edit_project ? htmlspecialchars($edit_project['name']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Short Description</label>
                <input type="text" name="projectShortDescription" class="form-control" maxlength="120" value="<?php echo $edit_project ? htmlspecialchars($edit_project['short_description']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Full Description</label>
                <textarea name="projectFullDescription" class="form-control" rows="4" required><?php echo $edit_project ? htmlspecialchars($edit_project['full_description']) : ''; ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">GitHub Repo Link</label>
                <input type="url" name="projectGitRepo" class="form-control" value="<?php echo $edit_project ? htmlspecialchars($edit_project['github_link']) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Select Image</label>
                <input type="file" name="projectImage" class="form-control" <?php echo $edit_project ? '' : 'required'; ?>>
                <?php if ($edit_project && $edit_project['featured_image']): ?>
                    <img src="../images/projects/<?php echo htmlspecialchars($edit_project['featured_image']); ?>" alt="Project Image" class="img-thumbnail mt-2" style="max-width:100px;">
                <?php endif; ?>
            </div>
            <div class="mb-3">
                <label class="form-label">More Images (Optional)</label>
                <input type="file" name="image1" class="form-control mb-2">
                <input type="file" name="image2" class="form-control mb-2">
                <input type="file" name="image3" class="form-control">
                <?php if ($edit_project): ?>
                    <div class="d-flex gap-2 mt-2">
                        <?php if ($edit_project['image1']): ?>
                            <div class="position-relative">
                                <img src="../images/projects/<?php echo htmlspecialchars($edit_project['image1']); ?>" class="img-thumbnail" style="max-width:60px;">
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="delete_proj_image" value="image1">
                                    <input type="hidden" name="project_id" value="<?php echo $edit_project['id']; ?>">
                                    <button type="submit" class="btn-close position-absolute top-0 end-0" style="background: #fff; width: 28px; height: 28px; color: #000; font-size: 1.2rem; opacity: 1; border-radius: 50%;" title="Delete">
                                        <span style="position: absolute; top: 3px; left: 7px; color: #000; font-weight: bold; font-size: 1.2rem;">&#10005;</span>
                                    </button>
                                </form>
                            </div>
                        <?php endif; ?>
                        <?php if ($edit_project['image2']): ?>
                            <div class="position-relative">
                                <img src="../images/projects/<?php echo htmlspecialchars($edit_project['image2']); ?>" class="img-thumbnail" style="max-width:60px;">
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="delete_proj_image" value="image2">
                                    <input type="hidden" name="project_id" value="<?php echo $edit_project['id']; ?>">
                                    <button type="submit" class="btn-close position-absolute top-0 end-0" style="background: #fff; width: 28px; height: 28px; color: #000; font-size: 1.2rem; opacity: 1; border-radius: 50%;" title="Delete">
                                        <span style="position: absolute; top: 3px; left: 7px; color: #000; font-weight: bold; font-size: 1.2rem;">&#10005;</span>
                                    </form>
                            </div>
                        <?php endif; ?>
                        <?php if ($edit_project['image3']): ?>
                            <div class="position-relative">
                                <img src="../images/projects/<?php echo htmlspecialchars($edit_project['image3']); ?>" class="img-thumbnail" style="max-width:60px;">
                                <form method="post" style="display:inline;">
                                    <input type="hidden" name="delete_proj_image" value="image3">
                                    <input type="hidden" name="project_id" value="<?php echo $edit_project['id']; ?>">
                                    <button type="submit" class="btn-close position-absolute top-0 end-0" style="background: #fff; width: 28px; height: 28px; color: #000; font-size: 1.2rem; opacity: 1; border-radius: 50%;" title="Delete">
                                        <span style="position: absolute; top: 3px; left: 7px; color: #000; font-weight: bold; font-size: 1.2rem;">&#10005;</span>
                                    </form>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="d-flex justify-content-center gap-2">
                <?php if ($edit_project): ?>
                    <button type="submit" name="update_project" class="btn btn-success col-5 mt-2">Update</button>
                    <a href="adminDashboard.php" class="btn btn-secondary col-5 mt-2 ms-2">Cancel</a>
                <?php else: ?>
                    <button type="submit" name="add_project" class="btn btn-outline-primary col-5 mt-2">Submit</button>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

    <!-- Projects Table (Right Side) -->
    <div class="col-12 col-md-7 col-lg-7 mt-5 d-flex flex-column align-items-center">
      <h3 class="text-center">Existing Projects</h3>
      <div class="bg-light p-4 rounded shadow-sm w-100 mt-2">
        <table class="table table-dark table-striped mb-0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Short Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($all_projects as $proj): ?>
                <tr>
                    <td>
                        <?php if ($proj['featured_image']): ?>
                            <img src="../images/projects/<?php echo htmlspecialchars($proj['featured_image']); ?>" alt="Project" style="max-width:60px;">
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($proj['name']); ?></td>
                    <td><?php echo htmlspecialchars($proj['short_description']); ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="edit_project_id" value="<?php echo $proj['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-warning me-2">Edit</button>
                        </form>
                        <form method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this project?');">
                            <input type="hidden" name="delete_project_id" value="<?php echo $proj['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_proj_image'], $_POST['project_id'])) {
    $imgField = $_POST['delete_proj_image'];
    $projId = intval($_POST['project_id']);
    $result = Database::select("SELECT * FROM projects WHERE id = ?", [$projId], "i");
    if ($result && count($result) > 0) {
        $proj = $result[0];
        if (!empty($proj[$imgField])) {
            $imgPath = "../images/projects/" . $proj[$imgField];
            if (file_exists($imgPath)) unlink($imgPath);
            Database::iud("UPDATE projects SET $imgField = NULL WHERE id = ?", [$projId], "i");
            $success = "Image deleted!";
            // Refresh $edit_project
            $edit_project = Database::select("SELECT * FROM projects WHERE id = ?", [$projId], "i")[0];
        }
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>