<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Replace these variables with your actual database credentials
$host = 'localhost';
$dbname = 'mcqdb';
$username = 'mcquser';
$password = 'Admin';

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query to fetch questions grouped by topic and difficulty
    $query = "SELECT
                topic_id, t.name topic_name,
                difficulty_id difficulty_level, dl.name difficulty_name,
                q.id question_id,q.question_text,
                o.id option_id, o.option_text, o.is_correct
            FROM
                questions q
            LEFT JOIN topics t ON t.id = topic_id
            LEFT JOIN difficulty_level dl ON dl.id = difficulty_id
            LEFT JOIN options o ON q.id = o.question_id

            ORDER BY
                topic_id, difficulty_id;";

    // Prepare and execute the query
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch data
    $questionsData = $stmt->fetchAll(PDO::FETCH_ASSOC);



    // Step 4: Organize the Data (you may need to adjust this based on your specific table structure)
$organizedData = array();

foreach ($questionsData as $row) {
    $topicId = $row['topic_id'];
    $topicName = $row['topic_name'];
    $questionId = $row['question_id'];
    $questionText = $row['question_text'];
    $difficulty = $row['difficulty_level'];
    $difficultyName = $row['difficulty_name'];
    $optionId = $row['option_id'];
    $optionText = $row['option_text'];
    $isCorrect = $row['is_correct'];

    $organizedData[$topicId]['id'] = $topicId;
    $organizedData[$topicId]['name'] = $topicName;

    $question = array(
        'id' => $questionId,
        'name' => $questionText,
        'difficulty' => $difficulty,
        'difficulty_name' => $difficultyName,
        'options' => array(),
        'questions' => array()
    );

    $option = array(
        'id' => $optionId,
        'option_text' => $optionText,
        'is_correct' => $isCorrect
    );

    $question['options'][] = $option;

    $organizedData[$topicId]['questions'][] = $question;
}
    // Step 5: Convert to JSON
    $jsonObject = json_encode(array_values($organizedData), JSON_PRETTY_PRINT);

    // Output the JSON
    echo $jsonObject;
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>