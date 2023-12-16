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
$sql = "SELECT
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
$result = $conn->query($sql);

// Step 3: Fetch the Data
$data = array();

while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Step 4: Organize the Data (you may need to adjust this based on your specific table structure)
$organizedData = array();

foreach ($data as $row) {
    $topicId = $row['topic_id'];
    $topicName = $row['topic_name'];
    $questionId = $row['question_id'];
    $questionText = $row['question_text'];
    $difficulty = $row['difficulty_level'];
    $difficultyName = $row['difficulty_name'];
    $optionId = $row['option_id'];
    $optionText = $row['option_text'];
    $isCorrect = $row['is_correct'];

    $organizedData[$topicId]['topic_id'] = $topicId;
    $organizedData[$topicId]['topic_name'] = $topicName;

    // Check if the question with the same ID already exists
    $existingQuestion = false;
    foreach ($organizedData[$topicId]['questions'] as $question) {
        if ($question['question_id'] === $questionId) {
            $existingQuestion = true;

            // Add the new option to the existing question
            $option = array(
                'id' => $optionId,
                'option_text' => $optionText,
                'is_correct' => $isCorrect
            );

            $question['options'][] = $option;

            break;
        }
    }

    // If the question does not exist, add it to the array
    if (!$existingQuestion) {
        $question = array(
            'question_id' => $questionId,
            'question_text' => $questionText,
            'difficulty' => $difficulty,
            'difficulty_name' => $difficultyName,
            'options' => array(
                array(
                    'id' => $optionId,
                    'option_text' => $optionText,
                    'is_correct' => $isCorrect
                )
            )
        );

        $organizedData[$topicId]['questions'][] = $question;
    }
}

// Step 5: Convert to JSON
$jsonObject = json_encode(array_values($organizedData), JSON_PRETTY_PRINT);

// Output the JSON
echo $jsonObject;

// Close the database connection
$conn->close();

?>
