<?php
$host = 'localhost';
$dbname = 'exam_jhudle';
$username = 'root';
$password = '';

try {
    $dbh = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
        CREATE TABLE IF NOT EXISTS profile (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            age INT,
            gender VARCHAR(10),
            bday DATE,
            email VARCHAR(100),
            contact_number VARCHAR(20)
        )
    ";
    $dbh->exec($sql);

    $mobile_number = $_POST['mobile_number'];
    $full_name = $_POST['full_name'];
    $email_address = $_POST['email_address'];
    $birthday = $_POST['birthday'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];

    $pattern_of_mobile_number = '/^09\d{9}$/';
    if (!preg_match($pattern_of_mobile_number, $mobile_number)) {
        $response = array('status' => 'Error', 'message' => 'Invalid phone number');
        echo json_encode($response);
        exit;
    }

    $pattern_of_full_name = '/^[a-zA-Z,.\s]+$/';
    if (!preg_match($pattern_of_full_name, $full_name)) {
        $response = array('status' => 'Error', 'message' => 'Invalid Full Name');
        echo json_encode($response);
        exit;
    }

    $pattern_of_email_address = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    if (!preg_match($pattern_of_email_address, $email_address)) {
        $response = array('status' => 'Error', 'message' => 'Invalid Email address');
        echo json_encode($response);
        exit;
    }

    if (empty($birthday)) {
        $response = array('status' => 'Error', 'message' => 'Invalid Date of Birth');
        echo json_encode($response);
        exit;
    }

    if (empty($age) || !is_numeric($age) || $age < 0) {
        $response = array('status' => 'Error', 'message' => 'Invalid Age');
        echo json_encode($response);
        exit;
    }

    $stmt = $dbh->prepare("INSERT INTO profile (name, age, gender, bday, email, contact_number)
        VALUES (:name, :age, :gender, :bday, :email, :contact_number)");

    $stmt->bindParam(':name', $full_name);
    $stmt->bindParam(':age', $age);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':bday', $birthday);
    $stmt->bindParam(':email', $email_address);
    $stmt->bindParam(':contact_number', $mobile_number);

    $stmt->execute();

    $response = array('status' => 'Success', 'message' => 'Data inserted successfully');
    echo json_encode($response);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
