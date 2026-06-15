<?php
session_start();
require 'php with db class/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$job_id = isset($_GET['id']) ? intval($_GET['id']) : 1;

// Fetch job name
$stmt = $conn->prepare("SELECT title FROM jobs WHERE id = ?");
$stmt->bind_param("i", $job_id);
$stmt->execute();
$job_res = $stmt->get_result();
$job_title = $job_res->num_rows > 0 ? $job_res->fetch_assoc()['title'] : "Assessment";

$exams = [
    1 => [
        ['q' => 'What does HTML stand for?', 'options' => ['Hyper Text Markup Language', 'High Text Machine Language', 'Hyper Tabular Markup Language', 'None of these'], 'correct' => 0],
        ['q' => 'Which CSS property is used to change the background color?', 'options' => ['color', 'bgcolor', 'background-color', 'background'], 'correct' => 2],
        ['q' => 'Inside which HTML element do we put the JavaScript?', 'options' => ['<js>', '<scripting>', '<script>', '<javascript>'], 'correct' => 2],
        ['q' => 'How do you create a function in JavaScript?', 'options' => ['function = myFunction()', 'function myFunction()', 'create myFunction()', 'def myFunction()'], 'correct' => 1],
        ['q' => 'Which of the following is not a frontend framework?', 'options' => ['React', 'Angular', 'Django', 'Vue'], 'correct' => 2],
    ],
    2 => [
        ['q' => 'Which Node.js module is used to create an HTTP server?', 'options' => ['fs', 'http', 'path', 'url'], 'correct' => 1],
        ['q' => 'What does SQL stand for?', 'options' => ['Structured Query Language', 'Simple Query Logic', 'Standard Query Library', 'Server Query Language'], 'correct' => 0],
        ['q' => 'What is a REST API?', 'options' => ['A database', 'An architectural style for APIs', 'A JavaScript framework', 'A server OS'], 'correct' => 1],
        ['q' => 'Which database is a NoSQL database?', 'options' => ['MySQL', 'PostgreSQL', 'MongoDB', 'SQLite'], 'correct' => 2],
        ['q' => 'What HTTP method is typically used to create a new resource?', 'options' => ['GET', 'POST', 'PUT', 'DELETE'], 'correct' => 1],
    ],
    3 => [
        ['q' => 'What does UI stand for?', 'options' => ['User Integration', 'User Interface', 'Universal Interface', 'Unique Identity'], 'correct' => 1],
        ['q' => 'What is the primary purpose of wireframing?', 'options' => ['To write code', 'To design the visual aesthetics', 'To establish structure and layout', 'To build the database'], 'correct' => 2],
        ['q' => 'Which tool is industry-standard for UI/UX design?', 'options' => ['Microsoft Word', 'Figma', 'Visual Studio', 'Eclipse'], 'correct' => 1],
        ['q' => 'What does UX stand for?', 'options' => ['User Experience', 'User Execution', 'User Extension', 'Universal Experience'], 'correct' => 0],
        ['q' => 'What is a "persona" in UX design?', 'options' => ['A CSS class', 'A server configuration', 'A fictional character representing a user type', 'A type of button'], 'correct' => 2],
    ],
    4 => [
        ['q' => 'What does the "useState" hook return in React?', 'options' => ['A state variable and a function to update it', 'Only a state variable', 'A reference to a DOM element', 'A callback function'], 'correct' => 0],
        ['q' => 'What is JSX?', 'options' => ['A database query language', 'A syntax extension for JavaScript', 'A CSS framework', 'A testing tool'], 'correct' => 1],
        ['q' => 'How do you pass data to a child component in React?', 'options' => ['Using state', 'Using context', 'Using props', 'Using Redux'], 'correct' => 2],
        ['q' => 'Which hook is used to perform side effects in React?', 'options' => ['useContext', 'useReducer', 'useEffect', 'useMemo'], 'correct' => 2],
        ['q' => 'What is the Virtual DOM?', 'options' => ['A real DOM object', 'A lightweight copy of the real DOM', 'A server-side concept', 'A new HTML5 element'], 'correct' => 1],
    ],
    5 => [
        ['q' => 'What defines a Full Stack Developer?', 'options' => ['Someone who only writes CSS', 'Someone who handles both frontend and backend', 'Someone who manages servers only', 'A database administrator'], 'correct' => 1],
        ['q' => 'Which stack uses MongoDB, Express, React, and Node?', 'options' => ['LAMP', 'MEAN', 'MERN', 'JAMstack'], 'correct' => 2],
        ['q' => 'What is CORS?', 'options' => ['Cross-Origin Resource Sharing', 'Cascading Object Rendering System', 'Centralized Operating Resource System', 'Computer Online Routing System'], 'correct' => 0],
        ['q' => 'What is a JWT?', 'options' => ['Java Web Toolkit', 'JSON Web Token', 'JavaScript Window Timer', 'Just Web Technologies'], 'correct' => 1],
        ['q' => 'Which of these is a popular version control system?', 'options' => ['Git', 'NPM', 'Docker', 'Webpack'], 'correct' => 0],
    ],
    6 => [
        ['q' => 'What is Docker used for?', 'options' => ['Creating virtual machines', 'Containerizing applications', 'Writing CSS', 'Querying databases'], 'correct' => 1],
        ['q' => 'What does CI/CD stand for?', 'options' => ['Continuous Integration / Continuous Deployment', 'Code Integration / Code Delivery', 'Centralized Information / Centralized Data', 'Computer Interface / Computer Design'], 'correct' => 0],
        ['q' => 'Which tool is commonly used for orchestration?', 'options' => ['Nginx', 'Kubernetes', 'Redis', 'React'], 'correct' => 1],
        ['q' => 'What is Terraform primarily used for?', 'options' => ['Frontend design', 'Infrastructure as Code (IaC)', 'Database migrations', 'Unit testing'], 'correct' => 1],
        ['q' => 'Which of the following is an AWS service?', 'options' => ['Azure', 'GCP', 'EC2', 'DigitalOcean'], 'correct' => 2],
    ]
];

// Fallback questions if job_id not exactly 1 or 2
$questions = isset($exams[$job_id]) ? $exams[$job_id] : $exams[1];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $score = 0;
    foreach ($questions as $index => $q) {
        if (isset($_POST["q_$index"]) && $_POST["q_$index"] == $q['correct']) {
            $score++;
        }
    }
    
    $percentage = ($score / count($questions)) * 100;
    $passed = $percentage >= 80 ? 1 : 0;
    
    $ins = $conn->prepare("INSERT INTO exam_results (user_id, job_id, score, passed) VALUES (?, ?, ?, ?)");
    $ins->bind_param("iiii", $_SESSION['user_id'], $job_id, $percentage, $passed);
    $ins->execute();
    
    $_SESSION['last_exam_score'] = $percentage;
    $_SESSION['last_exam_job'] = $job_id;
    
    header("Location: exam-result.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Skill Assessment - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/exam.css">
</head>
<body>

  <nav class="glass-nav">
    <div class="container navbar flex-between">
      <div class="exam-header">
        <a href="index.php" class="logo">MAMA<span>KHALU</span></a>
        <div class="exam-divider"></div>
        <span class="exam-label">Skill Assessment — <?php echo htmlspecialchars($job_title); ?></span>
      </div>
      <div class="exam-right">
        <a href="jobs.php" class="btn btn-outline" style="padding:8px 16px;">Cancel</a>
      </div>
    </div>
  </nav>

  <main class="container mt-5 mb-5 exam-main">
    <form method="POST">
        <?php foreach($questions as $index => $q): ?>
        <div class="glass-card-static slide-up question-card mb-4">
          <h2 class="question-text"><?php echo ($index+1).". ".$q['q']; ?></h2>
          <div class="options-container" style="display:flex; flex-direction:column; gap:10px; margin-top:20px;">
             <?php foreach($q['options'] as $optIndex => $optText): ?>
                <label style="padding:15px; border:1px solid #ccc; border-radius:8px; cursor:pointer;">
                    <input type="radio" name="q_<?php echo $index; ?>" value="<?php echo $optIndex; ?>" required>
                    <?php echo $optText; ?>
                </label>
             <?php endforeach; ?>
          </div>
        </div>
        <?php endforeach; ?>
        
        <button type="submit" class="btn btn-primary w-full">Submit Exam</button>
    </form>
  </main>
</body>
</html>
