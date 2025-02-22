<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Styled Form & Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-nav .nav-link {
            transition: 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
        }

        .form-container {
            max-width: 500px;
            margin: 30px auto;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
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

    <div class="form-container">
        <h3 class="text-center">Add New User</h3>
        <form method="post" onsubmit="return confirm('Are you sure you want to create a new user?');">
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" name="first_name" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" name="last_name" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Gender</label>
                <select name="gender" class="form-select">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Major</label>
                <input type="text" name="major" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Enrollment Year</label>
                <input type="text" name="enrollment_year" class="form-control">
            </div>
            <button type="submit" name="submit1" class="btn btn-primary w-100">Create</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
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



    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit1'])) {
        // Retrieve form data
        $first_name = $_POST['first_name'] ?? '';
        $last_name = $_POST['last_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $date_of_birth = $_POST['date'] ?? '';
        $gender = $_POST['gender'] ?? '';
        $major = $_POST['major'] ?? '';
        $enrollment_year = $_POST['enrollment_year'] ?? '';

        // Display values (for debugging)
        echo "{$first_name} {$last_name} {$email} {$date_of_birth} {$gender} {$major} {$enrollment_year}";

        // Database connection (Ensure you have this set up)
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement
        $stmt = $pdo->prepare("INSERT INTO Students 
                               (first_name, last_name, email, date_of_birth, gender, major, enrollment_year, created_at) 
                               VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");

        // Execute the query with values
        if ($stmt->execute([$first_name, $last_name, $email, $date_of_birth, $gender, $major, $enrollment_year])) {
            echo "New student added successfully!";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit; // Important to stop further execution
        } else {
            echo "Error: Could not insert student.";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>