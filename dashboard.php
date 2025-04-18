<?php
// Include the database connection
require 'db.php';

// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Fetch the user's data from the database
    $user_id = $_SESSION['user_id'];
    $query = "SELECT full_name FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_name = htmlspecialchars($user['full_name']); // Escape for security
    } else {
        $user_name = "Unknown User"; // Fallback if user not found
    }
    $stmt->close();

    // Fetch the user's scheduled meetings
    $query = "SELECT topic, meeting_date, meeting_time FROM meetings WHERE user_id = ? ORDER BY meeting_date, meeting_time";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $meetings = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $meetings[] = $row;
        }
    }
    $stmt->close();
} else {
    // Redirect to login page if not logged in
    header("Location: auth.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - EduSphere</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    .sidebar {
      transition: all 0.3s;
    }
    .sidebar-item:hover {
      background-color: rgba(79, 70, 229, 0.1);
    }
    .sidebar-item.active {
      background-color: rgba(79, 70, 229, 0.1);
      border-left: 3px solid #4F46E5;
    }
    .course-card:hover .course-card-overlay {
      opacity: 1;
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
    .dark-mode .border-gray-200 {
      border-color: #374151;
    }
    .dark-mode .bg-gray-50 {
      background-color: #111827;
    }
    .dark-mode .bg-gray-100 {
      background-color: #1F2937;
    }
    .dark-mode .sidebar {
      background-color: #1F2937;
      border-color: #374151;
    }
    .dark-mode .sidebar-item:hover {
      background-color: rgba(99, 102, 241, 0.2);
    }
    .dark-mode .sidebar-item.active {
      background-color: rgba(99, 102, 241, 0.2);
    }
    /* Progress Ring Styles */
    .progress-ring {
      position: relative;
    }
    .progress-ring__circle {
      transition: stroke-dashoffset 0.35s;
      transform: rotate(-90deg);
      transform-origin: 50% 50%;
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex">
  <!-- Sidebar -->
  <aside class="sidebar fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 overflow-y-auto hidden lg:block">
    <div class="px-6 py-4">
      <a href="home.php" class="flex items-center mb-8">
        <svg class="h-10 w-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
          <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
        </svg>
        <span class="ml-2 text-xl font-bold text-gray-800">EduSphere</span>
      </a>
      
      <div class="mb-8">
        <div class="flex items-center">
          <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="h-12 w-12 rounded-full">
          <div class="ml-3">
            <!-- Display the user's name dynamically -->
            <h3 class="text-lg font-medium text-gray-800"><?php echo $user_name; ?></h3>
            <p class="text-sm text-gray-600">Student</p>
          </div>
        </div>
      </div>
      
      <nav>
        <ul class="space-y-1">
          <li>
            <a href="#" class="sidebar-item active flex items-center px-4 py-3 text-gray-800 rounded-lg pl-3">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
              </svg>
              Dashboard
            </a>
          </li>
          <li>
            <a href="#meetings-section" class="sidebar-item flex items-center px-4 py-3 text-gray-700 hover:text-gray-800 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
              </svg>
              My Courses
            </a>
          </li>
          <li>
            <a href="profile.php" class="sidebar-item flex items-center px-4 py-3 text-gray-700 hover:text-gray-800 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
              </svg>
              Profile
            </a>
          </li>
          <li>
            <a href="schedule.php" class="sidebar-item flex items-center px-4 py-3 text-gray-700 hover:text-gray-800 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
              Schedule a Meeting
            </a>
          </li>
          <li>
            <a href="fourums.php" class="sidebar-item flex items-center px-4 py-3 text-gray-700 hover:text-gray-800 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
              </svg>
              Forums
            </a>
          </li>
          <li>
            <a href="#" class="sidebar-item flex items-center px-4 py-3 text-gray-700 hover:text-gray-800 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
              </svg>
              Certificates
            </a>
          </li>
          <li>
            <a href="#" class="sidebar-item flex items-center px-4 py-3 text-gray-700 hover:text-gray-800 rounded-lg">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              Settings
            </a>
          </li>
        </ul>
      </nav>
    </div>
    
    <div class="px-6 py-4 border-t border-gray-200 mt-6">
      <button id="theme-toggle-sidebar" class="flex items-center w-full px-4 py-2 text-gray-700 hover:text-gray-800 rounded-lg mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>
        Dark Mode
      </button>
      <a href="auth.php" class="flex items-center w-full px-4 py-2 text-gray-700 hover:text-gray-800 rounded-lg">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
        </svg>
        Logout
      </a>
    </div>
  </aside>
  
  <!-- Mobile Sidebar Toggle -->
  <div class="fixed bottom-6 right-6 z-50 lg:hidden">
    <button id="sidebar-toggle" class="h-14 w-14 rounded-full bg-indigo-600 text-white flex items-center justify-center shadow-lg">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>
  </div>

  <!-- Main Content -->
  <div class="w-full lg:pl-64">
    <!-- Header -->
    <header class="bg-white shadow z-10 sticky top-0">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex justify-between items-center">
          <div class="flex items-center">
            <button id="mobile-menu-button" class="lg:hidden mr-4 text-gray-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
              </svg>
            </button>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
          </div>
          <div class="flex items-center space-x-4">
            <button id="theme-toggle-header" class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
              </svg>
            </button>
            <div class="relative">
              <button class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 relative">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute top-0 right-0 h-2 w-2 rounded-full bg-red-500"></span>
              </button>
            </div>
            <div class="flex items-center">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User" class="h-8 w-8 rounded-full">
            </div>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Welcome Message -->
      <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Welcome back, <?php echo $user_name; ?>!</h2>
        <p class="text-gray-600">Continue your learning journey and track your progress.</p>
      </div>
      
      <!-- Progress Summary Cards -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Weekly Progress Card -->
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-800">Weekly Progress</h3>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
              +12%
            </span>
          </div>
          <div>
            <p class="text-sm text-gray-600 mb-1">You've completed 75% of your weekly goal</p>
            <div class="w-full bg-gray-200 rounded-full h-4">
              <div class="bg-indigo-600 h-4 rounded-full" style="width: 75%;"></div>
            </div>
            <p class="text-lg font-semibold text-gray-800 mt-2">6.5 hours</p>
          </div>
        </div>
        
        <!-- Active Courses Card -->
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-800">Active Courses</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
            </svg>
          </div>
          <p class="text-3xl font-bold text-gray-800 mb-1">4</p>
          <p class="text-sm text-gray-600 mb-2">Enrolled courses</p>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-indigo-600 rounded-full h-2" style="width: 45%"></div>
          </div>
          <p class="text-xs text-gray-500 mt-2">45% Completion rate</p>
        </div>
        
        <!-- Pending Quizzes Card -->
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-800">Pending Quizzes</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
          </div>
          <p class="text-3xl font-bold text-gray-800 mb-3">2</p>
          <div class="space-y-2">
            <div class="flex justify-between items-center text-sm">
              <span class="text-gray-600">JavaScript Quiz</span>
              <span class="text-red-500 font-medium">Due tomorrow</span>
            </div>
            <div class="flex justify-between items-center text-sm">
              <span class="text-gray-600">React Fundamentals</span>
              <span class="text-gray-500">Due in 5 days</span>
            </div>
          </div>
        </div>
        
        <!-- Certificates Card -->
        <div class="bg-white p-6 rounded-lg shadow">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-medium text-gray-800">Certificates</h3>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
            </svg>
          </div>
          <p class="text-3xl font-bold text-gray-800 mb-3">2</p>
          <div class="space-y-2">
            <div class="flex justify-between items-center text-sm">
              <span class="text-gray-600">HTML & CSS Basics</span>
              <span class="text-gray-500">May 15, 2023</span>
            </div>
            <div class="flex justify-between items-center text-sm">
              <span class="text-gray-600">Python Programming</span>
              <span class="text-gray-500">Feb 28, 2023</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Scheduled Meetings -->
      <div class="bg-white rounded-lg shadow mb-8" id="meetings-section">
        <div class="px-6 py-5 border-b border-gray-200">
          <h3 class="text-lg font-medium text-gray-800">Scheduled Meetings</h3>
        </div>
        <div class="p-6">
          <?php if (!empty($meetings)): ?>
            <ul class="divide-y divide-gray-200">
              <?php foreach ($meetings as $meeting): ?>
                <li class="py-4">
                  <div class="flex justify-between items-center">
                    <div>
                      <h4 class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($meeting['topic']); ?></h4>
                      <p class="text-sm text-gray-600">
                        <?php echo date("F j, Y", strtotime($meeting['meeting_date'])); ?> at <?php echo date("g:i A", strtotime($meeting['meeting_time'])); ?>
                      </p>
                    </div>
                    <div>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700">
                        Upcoming
                      </span>
                    </div>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php else: ?>
            <p class="text-sm text-gray-600">You have no scheduled meetings.</p>
          <?php endif; ?>
        </div>
      </div>
      
      <!-- In Progress & Recommended Courses Tabs -->
      <div class="bg-white rounded-lg shadow mb-8" id="my-courses-section">
        <div class="border-b border-gray-200">
          <nav class="flex -mb-px">
        <button class="course-tab active py-4 px-6 border-b-2 border-indigo-500 font-medium text-sm text-indigo-600" data-tab="in-progress">
          Courses in Progress
        </button>
        <button class="course-tab py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="recommended">
          Recommended for You
        </button>
        <button class="course-tab py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" data-tab="completed">
          Completed Courses
        </button>
          </nav>
        </div>
        
        <!-- In Progress Courses -->
        <div id="in-progress" class="course-content p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Course 1 -->
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
          <div class="relative">
            <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1052&q=80" alt="JavaScript Course" class="w-full h-40 object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
          <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Continue</a>
            </div>
          </div>
          <div class="p-4">
            <div class="flex justify-between items-center mb-3">
          <span class="text-xs font-medium text-indigo-600">JavaScript</span>
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <span class="text-xs text-gray-600 ml-1">4.9</span>
          </div>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">JavaScript Mastery: ES6 to Advanced</h3>
            <div class="flex justify-between items-center text-sm mb-3">
          <span class="text-gray-600">Instructor: <span class="font-medium">Sarah Johnson</span></span>
            </div>
            <div class="mb-2">
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-indigo-600 rounded-full h-2" style="width: 65%"></div>
          </div>
            </div>
            <div class="flex justify-between items-center text-xs text-gray-500">
          <span>13/20 Lessons</span>
          <span>65% Complete</span>
            </div>
          </div>
        </div>
        
        <!-- Course 2 -->
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
          <div class="relative">
            <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="Machine Learning Course" class="w-full h-40 object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
          <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Continue</a>
            </div>
          </div>
          <div class="p-4">
            <div class="flex justify-between items-center mb-3">
          <span class="text-xs font-medium text-indigo-600">Machine Learning</span>
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
              <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
            </svg>
            <span class="text-xs text-gray-600 ml-1">4.8</span>
          </div>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-2">Machine Learning with Python</h3>
            <div class="flex justify-between items-center text-sm mb-3">
          <span class="text-gray-600">Instructor: <span class="font-medium">Michael Chen</span></span>
            </div>
            <div class="mb-2">
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-indigo-600 rounded-full h-2" style="width: 25%"></div>
          </div>
            </div>
            <div class="flex justify-between items-center text-xs text-gray-500">
          <span>5/20 Lessons</span>
          <span>25% Complete</span>
            </div>
          </div>
        </div>
        
        <!-- Course 3 -->
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
          <div class="relative">
            <img src="https://images.unsplash.com/photo-1522542550221-31fd19575a2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="Web Design Course" class="w-full h-40 object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
          <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">Continue</a>
            </div>
          </div>
          <div class="p-4">
            <div class="flex justify-between items-center mb-3">
          <span class="text-xs font-medium text-indigo-600">Web Design</span>
          <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="text-xs text-gray-600 ml-1">4.7</span>
                  </div>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Modern UI/UX Design Principles</h3>
                <div class="flex justify-between items-center text-sm mb-3">
                  <span class="text-gray-600">Instructor: <span class="font-medium">Emily Rodriguez</span></span>
                </div>
                <div class="mb-2">
                  <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-indigo-600 rounded-full h-2" style="width: 40%"></div>
                  </div>
                </div>
                <div class="flex justify-between items-center text-xs text-gray-500">
                  <span>8/20 Lessons</span>
                  <span>40% Complete</span>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Recommended Courses (hidden by default) -->
        <div id="recommended" class="course-content hidden p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Recommended Course 1 -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
              <div class="relative">
                <img src="https://images.unsplash.com/photo-1666875753105-c63a6f3bdc86?q=80&w=2073&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Data Science Course" class="w-full h-40 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                  <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
                </div>
              </div>
              <div class="p-4">
                <div class="flex justify-between items-center mb-3">
                  <span class="text-xs font-medium text-indigo-600">Data Science</span>
                  <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="text-xs text-gray-600 ml-1">4.9</span>
                  </div>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Data Science and Visualization</h3>
                <div class="flex justify-between items-center text-sm mb-3">
                  <span class="text-gray-600">Instructor: <span class="font-medium">David Wilson</span></span>
                </div>
                <div class="flex justify-between items-center mt-4">
                  <span class="text-lg font-bold text-gray-800">$89.99</span>
                  <a href="#" class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium">Enroll Now</a>
                </div>
              </div>
            </div>
            
            <!-- Recommended Course 2 -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
              <div class="relative">
                <img src="https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="Node.js Course" class="w-full h-40 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                  <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
                </div>
              </div>
              <div class="p-4">
                <div class="flex justify-between items-center mb-3">
                  <span class="text-xs font-medium text-indigo-600">Node.js</span>
                  <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="text-xs text-gray-600 ml-1">4.8</span>
                  </div>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Node.js Backend Development</h3>
                <div class="flex justify-between items-center text-sm mb-3">
                  <span class="text-gray-600">Instructor: <span class="font-medium">Alex Turner</span></span>
                </div>
                <div class="flex justify-between items-center mt-4">
                  <span class="text-lg font-bold text-gray-800">$74.99</span>
                  <a href="#" class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium">Enroll Now</a>
                </div>
              </div>
            </div>
            
            <!-- Recommended Course 3 -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
              <div class="relative">
                <img src="https://images.unsplash.com/photo-1544197150-b99a580bb7a8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="Docker Course" class="w-full h-40 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                  <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
                </div>
              </div>
              <div class="p-4">
                <div class="flex justify-between items-center mb-3">
                  <span class="text-xs font-medium text-indigo-600">DevOps</span>
                  <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="text-xs text-gray-600 ml-1">4.9</span>
                  </div>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Docker and Kubernetes Essentials</h3>
                <div class="flex justify-between items-center text-sm mb-3">
                  <span class="text-gray-600">Instructor: <span class="font-medium">Jessica Lee</span></span>
                </div>
                <div class="flex justify-between items-center mt-4">
                  <span class="text-lg font-bold text-gray-800">$94.99</span>
                  <a href="#" class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-medium">Enroll Now</a>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Completed Courses (hidden by default) -->
        <div id="completed" class="course-content hidden p-6">
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Completed Course 1 -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
              <div class="relative">
                <img src="https://images.unsplash.com/photo-1621839673705-6617adf9e890?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="HTML Course" class="w-full h-40 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                  <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Certificate</a>
                </div>
                <div class="absolute top-0 right-0 bg-green-500 text-white px-3 py-1 m-2 rounded-full text-xs font-medium">Completed</div>
              </div>
              <div class="p-4">
                <div class="flex justify-between items-center mb-3">
                  <span class="text-xs font-medium text-indigo-600">Web Development</span>
                  <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="text-xs text-gray-600 ml-1">5.0</span>
                  </div>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">HTML & CSS Fundamentals</h3>
                <div class="flex justify-between items-center text-sm mb-3">
                  <span class="text-gray-600">Instructor: <span class="font-medium">Tom Anderson</span></span>
                </div>
                <div class="flex justify-between items-center mt-4">
                  <span class="text-gray-500 text-sm">Completed on May 15, 2023</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
              </div>
            </div>
            
            <!-- Completed Course 2 -->
            <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">
              <div class="relative">
                <img src="https://images.unsplash.com/photo-1526379095098-d400fd0bf935?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="Python Course" class="w-full h-40 object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                  <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Certificate</a>
                </div>
                <div class="absolute top-0 right-0 bg-green-500 text-white px-3 py-1 m-2 rounded-full text-xs font-medium">Completed</div>
              </div>
              <div class="p-4">
                <div class="flex justify-between items-center mb-3">
                  <span class="text-xs font-medium text-indigo-600">Python</span>
                  <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <span class="text-xs text-gray-600 ml-1">4.9</span>
                  </div>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Python Programming Fundamentals</h3>
                <div class="flex justify-between items-center text-sm mb-3">
                  <span class="text-gray-600">Instructor: <span class="font-medium">Linda Kim</span></span>
                </div>
                <div class="flex justify-between items-center mt-4">
                  <span class="text-gray-500 text-sm">Completed on Feb 28, 2023</span>
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Recent Activity & Discussion Forums -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Activity -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-5 border-b border-gray-200">
              <h3 class="text-lg font-medium text-gray-800">Recent Activity</h3>
            </div>
            <div class="p-6">
              <ul class="divide-y divide-gray-200">
                <li class="py-4 first:pt-0 last:pb-0">
                  <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                      <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-green-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                      </span>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800">
                        Completed lesson <span class="font-semibold">Advanced JavaScript Patterns</span>
                      </p>
                      <p class="text-sm text-gray-500">
                        JavaScript Mastery: ES6 to Advanced
                      </p>
                    </div>
                    <div class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500">
                      2 hours ago
                    </div>
                  </div>
                </li>
                
                <li class="py-4">
                  <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                      <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-indigo-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                      </span>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800">
                        Posted in forum <span class="font-semibold">Introduction to CNN Architecture</span>
                      </p>
                      <p class="text-sm text-gray-500">
                        Machine Learning with Python
                      </p>
                    </div>
                    <div class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500">
                      Yesterday
                    </div>
                  </div>
                </li>
                
                <li class="py-4">
                  <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                      <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-blue-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                      </span>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800">
                        Scored <span class="font-semibold">92%</span> on quiz
                      </p>
                      <p class="text-sm text-gray-500">
                        Modern UI/UX Design Principles
                      </p>
                    </div>
                    <div class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500">
                      2 days ago
                    </div>
                  </div>
                </li>
                
                <li class="py-4">
                  <div class="flex space-x-3">
                    <div class="flex-shrink-0">
                      <span class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-purple-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                      </span>
                    </div>
                    <div class="flex-1 min-w-0">
                      <p class="text-sm font-medium text-gray-800">
                        Enrolled in new course <span class="font-semibold">Machine Learning with Python</span>
                      </p>
                      <p class="text-sm text-gray-500">
                        Instructor: Michael Chen
                      </p>
                    </div>
                    <div class="flex-shrink-0 whitespace-nowrap text-sm text-gray-500">
                      1 week ago
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
        
        <!-- Discussion Forums -->
        <div>
          <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-5 border-b border-gray-200">
              <h3 class="text-lg font-medium text-gray-800">Discussion Forums</h3>
            </div>
            <div class="p-6">
              <ul class="divide-y divide-gray-200">
                <li class="py-4 first:pt-0">
                  <a href="#" class="block hover:bg-gray-50 -m-4 p-4 rounded-lg">
                    <div class="flex justify-between items-center mb-1">
                      <h4 class="text-sm font-medium text-gray-800">JavaScript Mastery</h4>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                        3 new
                      </span>
                    </div>
                    <p class="text-sm text-gray-600 line-clamp-1">Discussion on advanced JS concepts and patterns.</p>
                    <div class="mt-2 flex justify-between">
                      <div class="flex items-center text-xs text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        76 members
                      </div>
                      <span class="text-xs text-gray-500">Active</span>
                    </div>
                  </a>
                </li>
                
                <li class="py-4">
                  <a href="#" class="block hover:bg-gray-50 -m-4 p-4 rounded-lg">
                    <div class="flex justify-between items-center mb-1">
                      <h4 class="text-sm font-medium text-gray-800">Machine Learning</h4>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        Active
                      </span>
                    </div>
                    <p class="text-sm text-gray-600 line-clamp-1">Neural networks, data preprocessing, and model evaluation.</p>
                    <div class="mt-2 flex justify-between">
                      <div class="flex items-center text-xs text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        124 members
                      </div>
                      <span class="text-xs text-gray-500">Active</span>
                    </div>
                  </a>
                </li>
                
                <li class="py-4">
                  <a href="#" class="block hover:bg-gray-50 -m-4 p-4 rounded-lg">
                    <div class="flex justify-between items-center mb-1">
                      <h4 class="text-sm font-medium text-gray-800">UI/UX Design</h4>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                        1 new
                      </span>
                    </div>
                    <p class="text-sm text-gray-600 line-clamp-1">Design principles, portfolio reviews, and career advice.</p>
                    <div class="mt-2 flex justify-between">
                      <div class="flex items-center text-xs text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        93 members
                      </div>
                      <span class="text-xs text-gray-500">Active</span>
                    </div>
                  </a>
                </li>
                
                <li class="py-4 last:pb-0">
                  <a href="#" class="block hover:bg-gray-50 -m-4 p-4 rounded-lg">
                    <div class="flex justify-between items-center mb-1">
                      <h4 class="text-sm font-medium text-gray-800">Student Lounge</h4>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        General
                      </span>
                    </div>
                    <p class="text-sm text-gray-600 line-clamp-1">General discussions, study tips, and learning resources.</p>
                    <div class="mt-2 flex justify-between">
                      <div class="flex items-center text-xs text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        215 members
                      </div>
                      <span class="text-xs text-gray-500">Active</span>
                    </div>
                  </a>
                </li>
              </ul>
            </div>
          </div>
          
          <!-- Upcoming Events -->
          <div class="bg-white rounded-lg shadow mt-8">
            <div class="px-6 py-5 border-b border-gray-200">
              <h3 class="text-lg font-medium text-gray-800">Upcoming Events</h3>
            </div>
            <div class="p-6">
              <ul class="divide-y divide-gray-200">
                <li class="py-4 first:pt-0">
                  <div class="flex space-x-4">
                    <div class="flex-shrink-0 bg-red-100 rounded-md p-2 flex flex-col items-center justify-center">
                      <span class="text-lg font-bold text-red-800">15</span>
                      <span class="text-xs font-medium text-red-800">MAY</span>
                    </div>
                    <div class="flex-1 min-w-0">
                      <h4 class="text-sm font-medium text-gray-800">JavaScript Quiz Deadline</h4>
                      <p class="text-xs text-gray-500 mt-1">10:00 AM - 11:30 AM</p>
                      <div class="flex items-center mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                          1 day left
                        </span>
                      </div>
                    </div>
                  </div>
                </li>
                
                <li class="py-4">
                  <div class="flex space-x-4">
                    <div class="flex-shrink-0 bg-green-100 rounded-md p-2 flex flex-col items-center justify-center">
                      <span class="text-lg font-bold text-green-800">20</span>
                      <span class="text-xs font-medium text-green-800">MAY</span>
                    </div>
                    <div class="flex-1 min-w-0">
                      <h4 class="text-sm font-medium text-gray-800">Machine Learning Workshop</h4>
                      <p class="text-xs text-gray-500 mt-1">2:00 PM - 4:00 PM</p>
                      <div class="flex items-center mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                          Workshop
                        </span>
                      </div>
                    </div>
                  </div>
                </li>
                
                <li class="py-4 last:pb-0">
                  <div class="flex space-x-4">
                    <div class="flex-shrink-0 bg-blue-100 rounded-md p-2 flex flex-col items-center justify-center">
                      <span class="text-lg font-bold text-blue-800">25</span>
                      <span class="text-xs font-medium text-blue-800">MAY</span>
                    </div>
                    <div class="flex-1 min-w-0">
                      <h4 class="text-sm font-medium text-gray-800">ReactJS Live Coding Session</h4>
                      <p class="text-xs text-gray-500 mt-1">6:00 PM - 7:30 PM</p>
                      <div class="flex items-center mt-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                          Live Session
                        </span>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>

  <script>
    // Dark mode toggle functionality
    const themeToggleHeader = document.getElementById('theme-toggle-header');
    const themeToggleSidebar = document.getElementById('theme-toggle-sidebar');
    const body = document.body;
    
    function toggleDarkMode() {
      body.classList.toggle('dark-mode');
      
      // Save preference to localStorage
      if (body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');
        
        // Update toggle icons
        themeToggleHeader.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="5"></circle>
          <line x1="12" y1="1" x2="12" y2="3"></line>
          <line x1="12" y1="21" x2="12" y2="23"></line>
          <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
          <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
          <line x1="1" y1="12" x2="3" y2="12"></line>
          <line x1="21" y1="12" x2="23" y2="12"></line>
          <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
          <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg>`;
      } else {
        localStorage.setItem('theme', 'light');
        
        // Update toggle icons
        themeToggleHeader.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>`;
      }
    }
    
    // Add event listeners to both toggle buttons
    themeToggleHeader.addEventListener('click', toggleDarkMode);
    themeToggleSidebar.addEventListener('click', toggleDarkMode);
    
    // Check for saved theme preference or respect OS theme setting
    const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");
    if (localStorage.getItem("theme") === "dark" || (!localStorage.getItem("theme") && prefersDarkScheme.matches)) {
      body.classList.add("dark-mode");
      
      // Update toggle icons
      themeToggleHeader.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="12" r="5"></circle>
        <line x1="12" y1="1" x2="12" y2="3"></line>
        <line x1="12" y1="21" x2="12" y2="23"></line>
        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
        <line x1="1" y1="12" x2="3" y2="12"></line>
        <line x1="21" y1="12" x2="23" y2="12"></line>
        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
      </svg>`;
    }
    
    // Mobile sidebar toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const mobileSidebar = document.querySelector('.sidebar');
    
    sidebarToggle.addEventListener('click', () => {
      mobileSidebar.classList.toggle('hidden');
    });
    
    // Courses tabs functionality
    const courseTabs = document.querySelectorAll('.course-tab');
    const courseContents = document.querySelectorAll('.course-content');
    
    courseTabs.forEach(tab => {
      tab.addEventListener('click', () => {
        // Remove active class from all tabs
        courseTabs.forEach(t => {
          t.classList.remove('active', 'text-indigo-600', 'border-indigo-500');
          t.classList.add('text-gray-500', 'border-transparent');
        });
        
        // Add active class to clicked tab
        tab.classList.add('active', 'text-indigo-600', 'border-indigo-500');
        tab.classList.remove('text-gray-500', 'border-transparent');
        
        // Hide all content sections
        courseContents.forEach(content => {
          content.classList.add('hidden');
        });
        
        // Show content for the selected tab
        const tabId = tab.getAttribute('data-tab');
        document.getElementById(tabId).classList.remove('hidden');
      });
    });
    
    // Progress ring animation
    document.addEventListener('DOMContentLoaded', function() {
      const circles = document.querySelectorAll('.progress-ring__circle');
      
      circles.forEach(circle => {
        // Get the radius of the circle
        const radius = circle.r.baseVal.value;
        
        // Calculate the circumference
        const circumference = radius * 2 * Math.PI;
        
        // Set the stroke-dasharray
        circle.style.strokeDasharray = `${circumference} ${circumference}`;
        
        // Set initial stroke-dashoffset (this will be updated for each progress ring)
        // For example, for 75% progress:
        // const offset = circumference - (75 / 100) * circumference;
        // circle.style.strokeDashoffset = offset;
      });
    });
  </script>
</body>
</html>