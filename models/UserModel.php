<?php
class UserModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // --------------------------
    // Validation Methods
    // --------------------------

    private function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function isValidPassword($password)
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}$/', $password);
    }

    // --------------------------
    // Email Check
    // --------------------------

    public function emailExists($email)
    {
        $stmt = $this->conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    // --------------------------
    // Authentication & Retrieval
    // --------------------------

    public function getUserByEmail($email)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --------------------------
    // Registration (Enhanced)
    // --------------------------

    public function registerJobSeeker($user_type, $fullname, $email, $password, $disability, $birthday, $address, $phone, $preferred_work, $skills, $resumePath)
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $this->conn->prepare("
        INSERT INTO users (
            user_type, fullname, email, password, disability,
            birthday, location, contact_number, preferred_work,
            skills, resume
        ) VALUES (
            :user_type, :fullname, :email, :password, :disability,
            :birthday, :location, :contact_number, :preferred_work,
            :skills, :resume
        )
    ");

    return $stmt->execute([
        ':user_type' => $user_type,
        ':fullname' => $fullname,
        ':email' => $email,
        ':password' => $hashedPassword,
        ':disability' => $disability,
        ':birthday' => $birthday,
        ':location' => $address,
        ':contact_number' => $phone,
        ':preferred_work' => $preferred_work,
        ':skills' => $skills,
        ':resume' => $resumePath
    ]);
}


    public function registerClient($user_type, $fullname, $email, $password)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("
            INSERT INTO users (user_type, fullname, email, password)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$user_type, $fullname, $email, $hashedPassword]);
    }

    // --------------------------
    // Profile Update
    // --------------------------

    public function updateUser($id, $fullname, $email, $description, $location, $disability, $contact_number, $imgPath = null)
    {
        $sql = "UPDATE users 
                SET fullname = :fullname, email = :email, description = :description, 
                    location = :location, disability = :disability, contact_number = :contact_number";

        $params = [
            ':fullname' => $fullname,
            ':email' => $email,
            ':description' => $description,
            ':location' => $location,
            ':disability' => $disability,
            ':contact_number' => $contact_number
        ];

        if ($imgPath !== null) {
            $sql .= ", img = :img";
            $params[':img'] = $imgPath;
        }

        $sql .= " WHERE user_id = :user_id";
        $params[':user_id'] = $id;

        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }
}
?>
