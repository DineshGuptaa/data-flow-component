-- DROP DATABASE mcqdb;

CREATE DATABASE mcqdb;
CREATE USER mcquser IDENTIFIED BY 'Admin';
USE mcqdb;

DROP TABLE options;
DROP TABLE questions;
DROP TABLE difficulty_level;
DROP TABLE topics;
DROP TABLE user_responses;
DROP TABLE users;


-- Create topics table
CREATE TABLE topics (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE difficulty_level (
    id INT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

-- Create questions table
CREATE TABLE questions (
    id INT PRIMARY KEY,
    question_text VARCHAR(255) NOT NULL,
    topic_id INT,
    difficulty_id INT,
    FOREIGN KEY (topic_id)      REFERENCES topics(id),
    FOREIGN KEY (difficulty_id) REFERENCES difficulty_level(id)
);

-- Create options table- here will answers and which answer is correct
CREATE TABLE options (
    id INT PRIMARY KEY,
    question_id INT,
    option_text VARCHAR(255) NOT NULL,
    is_correct BOOLEAN,
    FOREIGN KEY (question_id) REFERENCES questions(id)
);
-- User Table
CREATE TABLE users (
    id INT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
);
-- User Response Tables
CREATE TABLE user_responses (
    id INT PRIMARY KEY,
    user_id INT,
    question_id INT,
    option_id INT,
    is_correct BOOLEAN,
    response_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (question_id) REFERENCES questions(id),
    FOREIGN KEY (option_id) REFERENCES options(id)
);


-- Inserting users
INSERT INTO users (id, username, email) VALUES
(1, 'shishir', 'shishir@example.com'),
(2, 'ishita', 'ishita@example.com'),
(3, 'dinesh', 'dinesh@example.com');

-- Inserting topics
INSERT INTO topics (id, name) VALUES
(1, 'General'),
(2, 'Loop'),
(3, 'Advance');

-- Inserting difficulty_level
INSERT INTO difficulty_level (id, name) VALUES
(1, 'Easy'),
(2, 'Medium'),
(3, 'Hard');

-- Inserting questions
INSERT INTO questions (id, question_text, topic_id, difficulty_id) VALUES
(1, 'What is the capital of France?', 1, 1),
(2, 'Which planet is known as the Red Planet?', 2, 2),
(3, 'In what year did World War II end?', 3, 3),
(4, 'What is 2 + 2?', 1, 1),
(5, 'Who developed the theory of relativity?', 2, 3),
(6, 'What is the square root of 144?', 1, 2);

-- Inserting options
INSERT INTO options (id, question_id, option_text, is_correct) VALUES
(1, 1, 'Berlin', false),
(2, 1, 'Madrid', false),
(3, 1, 'Paris', true),
(4, 1, 'Rome', false),
(5, 2, 'Mars', true),
(6, 2, 'Venus', false),
(7, 2, 'Jupiter', false),
(8, 2, 'Saturn', false),
(9, 3, '1943', false),
(10, 3, '1945', true),
(11, 3, '1950', false),
(12, 3, '1939', false);


SELECT
    topic_id, t.name topic_name,
    difficulty_id difficulty, dl.name difficulty_name,
    q.id question_id,q.question_text,
    o.option_text
FROM
    questions q
LEFT JOIN topics t ON t.id = topic_id
LEFT JOIN difficulty_level dl ON dl.id = difficulty_id
LEFT JOIN options o ON q.id = o.question_id

ORDER BY
    topic_id, difficulty_id;
