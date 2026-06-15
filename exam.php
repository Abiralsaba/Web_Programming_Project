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

// Basic PHP-based questions
$exams = [
    1 => [
        ['q' => 'What does the "useState" hook return in React?', 'options' => ['A state variable and a function to update it', 'Only a state variable', 'A reference to a DOM element', 'A callback function'], 'correct' => 0],
        ['q' => 'Which CSS property is used to create flexible layouts?', 'options' => ['float', 'position', 'display: flex', 'overflow'], 'correct' => 2],
    ],
    2 => [
        ['q' => 'Which Node.js module is used to create an HTTP server?', 'options' => ['fs', 'http', 'path', 'url'], 'correct' => 1],
        ['q' => 'What does SQL stand for?', 'options' => ['Structured Query Language', 'Simple Query Logic', 'Standard Query Library', 'Server Query Language'], 'correct' => 0],
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
