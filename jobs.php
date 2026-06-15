<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jobs - MAMA-KHALU.COM</title>
  <link rel="stylesheet" href="CSS/style.css">
  <link rel="stylesheet" href="CSS/jobs.css">
</head>
<body>

  <nav class="glass-nav">
    <div class="container navbar">
      <a href="index.php" class="logo">MAMA<span>KHALU</span></a>
      <button class="menu-toggle" onclick="document.querySelector('.nav-links').classList.toggle('open')">☰</button>
      <div class="nav-links">
        <a href="dashboard.php" class="nav-link">Dashboard</a>
        <a href="jobs.php" class="nav-link nav-active">Browse Jobs</a>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="my-applications.php" class="nav-link">My Applications</a>
            <a href="logout.php" class="nav-link">Logout</a>
            <div class="avatar"><?php echo strtoupper(substr($_SESSION['name'], 0, 1)); ?></div>
        <?php else: ?>
            <a href="login.php" class="nav-link">Login</a>
            <a href="register.php" class="btn btn-primary" style="padding: 0.5rem 1rem;">Get Started</a>
        <?php endif; ?>
      </div>
    </div>
  </nav>

  <main class="container mt-4 mb-5">
    <div class="flex-between mb-4">
      <div>
        <h1 class="mb-1">Find Your Dream Job</h1>
        <p class="text-muted">Browse open roles and take skill assessments to apply.</p>
      </div>
      <form method="GET" action="jobs.php" class="search-row">
        <?php if(isset($_GET['filter'])): ?>
          <input type="hidden" name="filter" value="<?php echo htmlspecialchars($_GET['filter']); ?>">
        <?php endif; ?>
        <input type="text" name="search" class="form-input" placeholder="Search jobs…" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit" class="btn btn-primary">Search</button>
      </form>
    </div>

    <!-- Filter Tabs -->
    <div class="filter-bar mb-4">
      <?php
      require 'php with db class/db.php';
      
      // Get counts
      $counts = [];
      $counts['All Jobs'] = $conn->query("SELECT COUNT(*) as c FROM jobs")->fetch_assoc()['c'];
      $counts['Frontend'] = $conn->query("SELECT COUNT(*) as c FROM jobs WHERE title LIKE '%Frontend%' OR title LIKE '%React%'")->fetch_assoc()['c'];
      $counts['Backend'] = $conn->query("SELECT COUNT(*) as c FROM jobs WHERE title LIKE '%Backend%' OR title LIKE '%Node%'")->fetch_assoc()['c'];
      $counts['Full Stack'] = $conn->query("SELECT COUNT(*) as c FROM jobs WHERE title LIKE '%Full Stack%'")->fetch_assoc()['c'];
      $counts['Design'] = $conn->query("SELECT COUNT(*) as c FROM jobs WHERE title LIKE '%Designer%' OR title LIKE '%UI/UX%'")->fetch_assoc()['c'];
      $counts['DevOps'] = $conn->query("SELECT COUNT(*) as c FROM jobs WHERE title LIKE '%DevOps%'")->fetch_assoc()['c'];

      $active_filter = isset($_GET['filter']) ? $_GET['filter'] : 'All Jobs';
      $search_param = isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : '';
      
      foreach ($counts as $label => $count) {
          $active_class = $active_filter === $label ? 'active' : '';
          echo "<a href='jobs.php?filter=" . urlencode($label) . $search_param . "' class='filter-tab $active_class' style='text-decoration:none; color:inherit;'>$label ($count)</a> ";
      }
      ?>
    </div>

    <!-- Job Cards -->
    <div class="grid-3">
      <?php
      $sql = "SELECT * FROM jobs";
      $conditions = [];

      if ($active_filter === 'Frontend') $conditions[] = "(title LIKE '%Frontend%' OR title LIKE '%React%')";
      if ($active_filter === 'Backend') $conditions[] = "(title LIKE '%Backend%' OR title LIKE '%Node%')";
      if ($active_filter === 'Full Stack') $conditions[] = "(title LIKE '%Full Stack%')";
      if ($active_filter === 'Design') $conditions[] = "(title LIKE '%Designer%' OR title LIKE '%UI/UX%')";
      if ($active_filter === 'DevOps') $conditions[] = "(title LIKE '%DevOps%')";

      if (isset($_GET['search']) && trim($_GET['search']) !== '') {
          $s = $conn->real_escape_string(trim($_GET['search']));
          $conditions[] = "(title LIKE '%$s%' OR company LIKE '%$s%' OR location LIKE '%$s%')";
      }

      if (count($conditions) > 0) {
          $sql .= " WHERE " . implode(" AND ", $conditions);
      }

      $result = $conn->query($sql);
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '<div class="glass-card slide-up">';
              echo '<h3 class="mb-1">' . htmlspecialchars($row['title']) . '</h3>';
              echo '<p class="text-muted mb-2 text-sm">' . htmlspecialchars($row['company']) . ' · ' . htmlspecialchars($row['location']) . '</p>';
              echo '<div class="flex-between">';
              echo '<strong class="text-primary">' . htmlspecialchars($row['salary']) . '</strong>';
              echo '<a href="job-detail.php?id=' . $row['id'] . '" class="btn btn-primary">View Job</a>';
              echo '</div>';
              echo '</div>';
          }
      } else {
          echo "<p>No jobs found.</p>";
      }
      ?>
    </div>
  </main>

  <script src="JS/script.js"></script>
</body>
</html>
