<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="./create.php">Create</a>
                    <a class="nav-link" href="./form.php">Delete & Edit</a>
                </div>
            </div>
        </div>
    </nav>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</html>

<?php
try {


    // Database connection
    $host = "localhost";
    $dbname = "school";
    $username = "root";
    $password = "";

    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Student data
    $first_name = $_POST["first_name"] ?? "";
    $last_name = $_POST["last_name"] ?? "";
    $email = $_POST["email"] ?? "";
    $date_of_birth = $_POST["date"] ?? "";
    $gender = $_POST["gender"] ?? "";
    $major = $_POST["major"] ?? "";
    $enrollment_year = $_POST["enrollment_year"] ?? "";



    echo "{$first_name} {$last_name} {$email} {$date_of_birth} {$gender} {$major} {$enrollment_year}";

    echo "<h3 class='text-center mt-4'>All Students</h3>";

    echo "<div class='container mt-3'>
            <table class='table table-bordered table-striped table-hover'>
            <thead class='table-dark'>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Major</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>";

    $stmt = $pdo->query("SELECT * FROM Students WHERE deleted_at IS NULL");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['major']}</td>
                <td>{$row['created_at']}</td>
                <td>{$row['updated_at']}</td>
                <td class='d-flex gap-2'>
                    <form method='post' action='form.php' onsubmit='return confirm(\"Are you sure you want to delete this student?\");'>
                        <input type='hidden' name='student_id' value='{$row["student_id"]}'>
                        <button type='submit' name='action' value='delete' class='btn btn-danger btn-sm'>Delete</button>
                    </form>
                    <form method='post' action='edit.php'>
                        <input type='hidden' name='student_id' value='{$row["student_id"]}'>
                        <input type='hidden' name='first_name' value='{$row["first_name"]}'>
                        <input type='hidden' name='last_name' value='{$row["last_name"]}'>
                        <input type='hidden' name='email' value='{$row["email"]}'>
                        <input type='hidden' name='date_of_birth' value='{$row["date_of_birth"]}'>
                        <input type='hidden' name='gender' value='{$row["gender"]}'>
                        <input type='hidden' name='major' value='{$row["major"]}'>
                        <input type='hidden' name='enrollment_year' value='{$row["enrollment_year"]}'>
                        <button type='submit' name='action' value='edit' class='btn btn-warning btn-sm'>Edit</button>
                    </form>
                </td>
            </tr>";
    }

    echo "</tbody></table></div>";
    echo "<h3 class='text-center mt-4'>Deleted Students</h3>";
    echo "<div class='container mt-3'>
            <table class='table table-bordered table-striped table-hover'>
            <thead class='table-dark'>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Major</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>";

    $stmt = $pdo->query("SELECT * FROM Students WHERE deleted_at IS NOT NULL");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['email']}</td>
                <td>{$row['major']}</td>
                
                <td class='d-flex gap-2'>
                    <!-- Permanently Delete Student -->
                    <form method='post' action='form.php' onsubmit='return confirm(\"Are you sure you want to *DELETE PERMANENTLY* this student?\");'>
                        <input type='hidden' name='student_id' value='{$row["student_id"]}'>
                        <button type='submit' name='student_action' value='delete_perm' class='btn btn-danger btn-sm'>Delete</button>
                    </form>
                    
                    <!-- Restore Student -->
                    <form method='post' action='form.php' onsubmit='return confirm(\"Are you sure you want to *ADD* this student to the TABLE again?\");'>
                        <input type='hidden' name='student_id' value='{$row["student_id"]}'>
                        <input type='hidden' name='first_name' value='{$row["first_name"]}'>
                        <input type='hidden' name='last_name' value='{$row["last_name"]}'>
                        <input type='hidden' name='email' value='{$row["email"]}'>
                        <input type='hidden' name='date_of_birth' value='{$row["date_of_birth"]}'>
                        <input type='hidden' name='gender' value='{$row["gender"]}'>
                        <input type='hidden' name='major' value='{$row["major"]}'>
                        <input type='hidden' name='enrollment_year' value='{$row["enrollment_year"]}'>
                        <button type='submit' name='student_action' value='restore' class='btn btn-success btn-sm'>Add</button>
                    </form>
                </td>
            </tr>";
    }
    echo "</tbody></table></div>";

    // Handle soft delete
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "delete") {
        $student_id = $_POST['student_id'];

        // Instead of deleting, update deleted_at timestamp
        $stm = $pdo->prepare("UPDATE Students SET deleted_at = NOW() WHERE student_id = :student_id");
        $stm->bindParam(":student_id", $student_id, PDO::PARAM_INT);

        if ($stm->execute()) {
            echo "<script>alert('Student ID $student_id has been soft deleted successfully.');</script>";
            echo "<script>window.location.href='form.php';</script>"; // Refresh the page
        } else {
            echo "Error deleting student.";
        }
    }



    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['student_action'])) {
        $student_id = $_POST['student_id'];

        if ($_POST['student_action'] == "delete_perm") {
            // Permanently delete the student
            $stmt = $pdo->prepare("DELETE FROM Students WHERE student_id = :student_id");
            $stmt->bindParam(":student_id", $student_id, PDO::PARAM_INT);
            $stmt->execute();
            // header("Location: " . $_SERVER['PHP_SELF']);
            
            echo "<script>alert('Student ID $student_id has been permanently deleted.');</script>";
        } elseif ($_POST['student_action'] == "restore") {
            // Restore student by setting deleted_at to NULL
            $stmt = $pdo->prepare("UPDATE Students SET deleted_at = NULL WHERE student_id = :student_id");
            $stmt->bindParam(":student_id", $student_id, PDO::PARAM_INT);
            $stmt->execute();
            // header("Location: " . $_SERVER['PHP_SELF']);
            echo "<script>alert('Student ID $student_id has been restored successfully.');</script>";
        }

        echo "<script>window.location.href='form.php';</script>"; // Refresh the page
        // Refresh page
        exit;
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>