<?php
session_start();
include 'db.php';

// For testing without login (optional):
// $_SESSION['user_id'] = 1;

if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to schedule a meeting.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $topic = $_POST['meeting_topic'];
    $date = $_POST['meeting_date'];
    $time = $_POST['meeting_time'];

    $sql = "INSERT INTO meetings (user_id, topic, meeting_date, meeting_time)
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $topic, $date, $time);

    if ($stmt->execute()) {
        $success_message = "✅ Meeting scheduled successfully!";
    } else {
        $error_message = "❌ Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Schedule Meeting - EduSphere</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    .dark-mode {
      background-color: #111827;
      color: #F9FAFB;
    }
    .dark-mode .bg-white {
      background-color: #1F2937;
    }
    .dark-mode .text-gray-800 {
      color: #F9FAFB;
    }
    .dark-mode .text-gray-700 {
      color: #E5E7EB;
    }
    .dark-mode .text-gray-600 {
      color: #D1D5DB;
    }
    .dark-mode .text-gray-500 {
      color: #9CA3AF;
    }
    .dark-mode .bg-gray-50 {
      background-color: #111827;
    }
    .dark-mode .bg-gray-100 {
      background-color: #1F2937;
    }
    .dark-mode .border-gray-200 {
      border-color: #374151;
    }
    .dark-mode input,
    .dark-mode select,
    .dark-mode textarea {
      background-color: #374151;
      color: #F9FAFB;
      border-color: #4B5563;
    }
    .dark-mode input::placeholder,
    .dark-mode textarea::placeholder {
      color: #9CA3AF;
    }
    .dark-mode input:focus,
    .dark-mode select:focus,
    .dark-mode textarea:focus {
      border-color: #6366F1;
      outline: none;
      box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.5);
    }
  </style>
</head>
<body class="bg-gray-50">
  <header class="bg-white shadow">
    <div class="container mx-auto px-4 py-4">
      <div class="flex justify-between items-center">
        <a href="home.php" class="flex items-center">
          <svg class="h-10 w-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
            <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
          </svg>
          <span class="ml-2 text-xl font-bold text-gray-800">EduSphere</span>
        </a>
        <nav class="hidden md:flex items-center space-x-8">
          <a href="home.php" class="text-gray-600 hover:text-indigo-600">Home</a>
          <a href="courses.php" class="text-gray-600 hover:text-indigo-600">Courses</a>
          <a href="forums.php" class="text-gray-600 hover:text-indigo-600">Forums</a>
          <a href="dashboard.php" class="text-gray-600 hover:text-indigo-600">Dashboard</a>
          <a href="#" class="text-gray-600 hover:text-indigo-600">About</a>
        </nav>
        <div class="flex items-center space-x-4">
          <button id="theme-toggle" class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
          </button>
          <a href="dashboard.php" class="hidden md:block px-4 py-2 rounded text-gray-700 hover:text-indigo-600">My Account</a>
          <a href="auth.php" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Sign In</a>
        </div>
      </div>
    </div>
  </header>

  <main class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Tutor Information Section -->
      <div class="bg-white p-6 rounded-lg shadow-sm">
        <div class="flex items-start mb-4">
          <div class="h-16 w-16 rounded-full bg-gray-200 overflow-hidden mr-4">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="John Doe" class="h-full w-full object-cover">
          </div>
          <div>
            <h2 class="text-xl font-bold text-gray-800" id="instructor-name">John Doe</h2>
            <p class="text-gray-600 text-sm">JavaScript Development Instructor</p>
            <div class="flex items-center mt-2">
              <div class="flex text-yellow-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 fill-current" viewBox="0 0 24 24">
                  <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                </svg>
                <!-- Repeat for 5 stars -->
              </div>
              <span class="text-sm text-gray-600 ml-1">5.0 (124 reviews)</span>
            </div>
          </div>
        </div>
        <div class="border-t border-gray-200 pt-4 mt-4">
          <h3 class="font-semibold text-gray-800 mb-2">About</h3>
          <p class="text-gray-600 text-sm">
            Senior JavaScript developer with over 10 years of experience. I specialize in teaching beginner to advanced concepts in JavaScript, React, Node.js, and full-stack development.
          </p>
        </div>
      </div>

      <!-- Meeting Form Section -->
      <div class="md:col-span-2 bg-white p-6 rounded-lg shadow-sm">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Schedule a Meeting</h1>
        <?php if (isset($success_message)): ?>
    <div class="message success"><?= $success_message ?></div>
<?php endif; ?>
<?php if (isset($error_message)): ?>
    <div class="message error"><?= $error_message ?></div>
<?php endif; ?>
        <form id="meeting-form" action="schedule.php" method="POST" class="space-y-4">
          <div>
            <label for="meeting_date" class="block text-sm font-medium text-gray-700 mb-1">Select Date</label>
            <input 
              type="date" 
              id="meeting_date" 
              name="meeting_date" 
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
              required
            >
          </div>
          <div>
            <label for="meeting_time" class="block text-sm font-medium text-gray-700 mb-1">Select Time</label>
            <input
               type="time"
               id="meeting_time"
               name="meeting_time"
               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
               required
               min="09:00"
               max="16:00"
>
          </div>
          <div>
            <label for="meeting-topic" class="block text-sm font-medium text-gray-700 mb-1">Meeting Topic</label>
            <input 
              type="text" 
              id="meeting_topic" 
              name="meeting_topic" 
              placeholder="e.g., JavaScript Promises, React Hooks" 
              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
              required
            >
          </div>
          <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
              Schedule Meeting
            </button>
          </div>
        </form>
      </div>
    </div>
  </main>

  <footer class="bg-white border-t border-gray-200 py-8 mt-12">
    <div class="container mx-auto px-4">
      <p class="text-gray-500 text-sm">&copy; 2023 EduSphere. All rights reserved.</p>
    </div>
  </footer>

  <script>
    // Set initial theme based on user's device preference
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
      document.body.classList.add('dark-mode');
    }

    // Theme Toggle
    const themeToggle = document.getElementById('theme-toggle');
    themeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark-mode');
    });
  </script>
</body>
</html>