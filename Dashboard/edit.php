<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0px;
            padding: 0px;
        }

        form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f9f9f9;
        }

        label {
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }
    </style>
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
    <h2>Edit Student Information</h2>

    <form method="POST" onsubmit="return confirm('Are you sure you want to Edit');">

        <input type="hidden" name="student_id" value="<?php echo isset($_POST['student_id']) ? htmlspecialchars($_POST['student_id']) : ''; ?>">

        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" placeholder="<?php echo htmlspecialchars($first_name); ?>" required>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" placeholder="<?php echo htmlspecialchars($last_name); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="<?php echo htmlspecialchars($email); ?>" required>

        <label for="date">Date of Birth:</label>
        <input type="date" id="date" name="date" placeholder="<?php echo htmlspecialchars($date_of_birth); ?>" required>

        <label for="gender">Gender:</label>
        <select id="gender" name="gender" required>
            <option value="" disabled selected><?php echo $gender ? htmlspecialchars($gender) : "Select gender"; ?></option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

        <label for="major">Major:</label>
        <input type="text" id="major" name="major" placeholder="<?php echo htmlspecialchars($major); ?>" required>

        <label for="enrollment_year">Enrollment Year:</label>
        <input type="number" id="enrollment_year" name="enrollment_year" placeholder="<?php echo htmlspecialchars($enrollment_year); ?>" required>

        <button type='submit' name='action' value='save'>Save Changes</button>
    </form>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>

<?php

$host = "localhost";
$dbname = "school";
$username = "root";
$password = "";

$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Retrieve POST data (use the same names as in the form)
$first_name = $_POST["first_name"] ?? "";
$last_name = $_POST["last_name"] ?? "";
$email = $_POST["email"] ?? "";
$date_of_birth = $_POST["date"] ?? "";
$gender = $_POST["gender"] ?? "";
$major = $_POST["major"] ?? "";
$enrollment_year = $_POST["enrollment_year"] ?? "";
$student_id = $_POST["student_id"] ?? ""; // Ensure student_id is correctly passed



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == "save") {
    try {


        // Ensure student_id is set
        if (empty($student_id)) {
            die("Error: Student ID is missing!");
        }

        // Prepare the UPDATE query
        $stm = $pdo->prepare("UPDATE Students 
            SET first_name = :first_name, 
                last_name = :last_name, 
                email = :email, 
                date_of_birth = :date_of_birth, 
                gender = :gender, 
                major = :major, 
                enrollment_year = :enrollment_year
            WHERE student_id = :student_id");

        // Bind parameters
        $stm->bindParam(":first_name", $first_name, PDO::PARAM_STR);
        $stm->bindParam(":last_name", $last_name, PDO::PARAM_STR);
        $stm->bindParam(":email", $email, PDO::PARAM_STR);
        $stm->bindParam(":date_of_birth", $date_of_birth, PDO::PARAM_STR);
        $stm->bindParam(":gender", $gender, PDO::PARAM_STR);
        $stm->bindParam(":major", $major, PDO::PARAM_STR);
        $stm->bindParam(":enrollment_year", $enrollment_year, PDO::PARAM_INT);
        $stm->bindParam(":student_id", $student_id, PDO::PARAM_INT);

        // Execute the query
        if ($stm->execute()) {
            echo "<script>
            alert('Record updated successfully.');
            setTimeout(function() {
                window.location.href = 'form.php';
            }, 2000); // Redirect after 2 seconds
          </script>";
        } else {
            echo "Error updating student record.";
        }
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
}
?>