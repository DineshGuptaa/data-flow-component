<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Step 1: Connect to the Database
$servername = "localhost";
$username = "mcquser";
$password = "Admin";
$database = "mcqdb";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 2: Execute the Query
$sql = "
    SELECT
        topic_id, t.name topic_name,
        difficulty_id difficulty_level, dl.name difficulty_name,
        q.id question_id, q.question_text,
        o.id option_id, o.option_text, o.is_correct
    FROM
        questions q
    LEFT JOIN topics t ON t.id = topic_id
    LEFT JOIN difficulty_level dl ON dl.id = difficulty_id
    LEFT JOIN options o ON q.id = o.question_id
    ORDER BY
        topic_id, difficulty_id;
";

$result = $conn->query($sql);


// Step 3: Organize the Data
$organizedData = array();

while ($row = $result->fetch_assoc()) {
    $topicId = $row['topic_id'];
    $difficultyId = $row['difficulty_level'];
    $questionId = $row['question_id'];

    // Create topic if not exists
    if (!isset($organizedData[$topicId])) {
        $organizedData[$topicId] = array(
            'id' => $topicId,
            'name' => $row['topic_name'],
            'questions' => array()
        );
    }

    // Create question if not exists
    if (!isset($organizedData[$topicId]['questions'][$questionId])) {
        $question = array(
            'id' => $questionId,
            'name' => $row['question_text'],
            'difficulty_level' => $difficultyId,
            'difficulty_name' => $row['difficulty_name'],
            'options' => array(),
            'questions' => array(),
        );
        $organizedData[$topicId]['questions'][] = $question;
    }

    // Add option to question
    $option = array(
        'option_id' => $row['option_id'],
        'option_text' => $row['option_text'],
        'is_correct' => $row['is_correct']
    );
    end($organizedData[$topicId]['questions']);
    $lastKey = key($organizedData[$topicId]['questions']);
    $organizedData[$topicId]['questions'][$lastKey]['options'][] = $option;
}

// Step 4: Convert to JSON
$jsonObject = json_encode(array_values($organizedData), JSON_PRETTY_PRINT);

// Output the JSON
echo $jsonObject;

// Step 5: Close the database connection
$conn->close();

?>