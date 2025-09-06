<?php
require_once 'config.php';

try {
    // Create study_goals table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS study_goals (
        id INT AUTO_INCREMENT PRIMARY KEY,
        student_id INT NOT NULL DEFAULT 1,
        title VARCHAR(200) NOT NULL,
        description TEXT,
        target_date DATE,
        status ENUM('Active', 'Completed', 'Abandoned') DEFAULT 'Active',
        priority ENUM('Low', 'Medium', 'High') DEFAULT 'Medium',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        completed_at TIMESTAMP NULL
    )";
    
    $pdo->exec($sql);
    echo "Study goals table created successfully!<br>";
    
    // Create a sample student if not exists
    $sql = "CREATE TABLE IF NOT EXISTS student (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        index_number VARCHAR(20) UNIQUE NOT NULL,
        gender ENUM('Male', 'Female', 'Other') NOT NULL,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100),
        phone VARCHAR(20),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "Student table created successfully!<br>";
    
    // Insert a sample student if not exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM student WHERE id = 1");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $stmt = $pdo->prepare("INSERT INTO student (id, name, index_number, gender, password, email) VALUES (1, 'Demo Student', 'DEMO001', 'Other', 'demo123', 'demo@example.com')");
        $stmt->execute();
        echo "Sample student created successfully!<br>";
    }
    
    echo "<br>Database setup completed! You can now use the Student Study Planner.<br>";
    echo "<a href='student_study_planner.php'>Go to Student Study Planner</a>";
    
} catch (PDOException $e) {
    echo "Error setting up database: " . $e->getMessage();
}
?>