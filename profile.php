<?php
// Start the session
require 'db.php';
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Fetch the user's data from the database
    $user_id = $_SESSION['user_id'];
    $query = "SELECT full_name, email, username FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_name = htmlspecialchars($user['full_name']); // Escape for security
        $user_email = htmlspecialchars($user['email']);   // Escape for security
        $user_username = htmlspecialchars($user['username']); // Escape for security
    } else {
        $user_name = "Unknown User"; // Fallback if user not found
        $user_email = "Unknown Email";
        $user_username = "Unknown Username";
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
  <title>User Profile - EduSphere</title>
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
    .dark-mode .bg-gray-50 {
      background-color: #111827;
    }
    .dark-mode .bg-gray-100 {
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
    .dark-mode .shadow {
      box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3), 0 1px 2px 0 rgba(0, 0, 0, 0.4);
    }
    .progress-bar {
      background: linear-gradient(to right, #4F46E5 0%, #4F46E5 var(--progress), #E5E7EB var(--progress), #E5E7EB 100%);
    }
    .dark-mode .progress-bar {
      background: linear-gradient(to right, #4F46E5 0%, #4F46E5 var(--progress), #374151 var(--progress), #374151 100%);
    }
    .chart-container {
      position: relative;
      width: 100%;
      max-width: 400px;
      margin: 0 auto;
    }
    .circular-chart {
      display: block;
      margin: 10px auto;
      max-width: 100%;
    }
    .circle {
      stroke: #4F46E5;
      fill: none;
      stroke-width: 2.8;
      stroke-linecap: round;
    }
    .circle-bg {
      stroke: #E5E7EB;
      fill: none;
      stroke-width: 2.8;
    }
    .dark-mode .circle-bg {
      stroke: #374151;
    }
    .percentage {
      fill: #4F46E5;
      font-size: 0.5em;
      text-anchor: middle;
      font-weight: bold;
    }
    .dark-mode .percentage {
      fill: #818CF8;
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
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
        <div class="flex items-center space-x-4">
          <nav class="hidden md:flex space-x-8">
            <a href="courses.php" class="text-gray-600 hover:text-indigo-600">Courses</a>
            <a href="dashboard.php" class="text-gray-600 hover:text-indigo-600">Dashboard</a>
            <a href="forum.php" class="text-gray-600 hover:text-indigo-600">Forum</a>
            <a href="#" class="text-gray-600 hover:text-indigo-600">Support</a>
          </nav>
          <div class="relative">
            <button class="flex items-center focus:outline-none">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User Avatar" class="h-8 w-8 rounded-full object-cover">
              <span class="hidden md:block ml-2 text-sm font-medium text-gray-700"><?php echo $user_name; ?></span>
              <svg xmlns="http://www.w3.org/2000/svg" class="hidden md:block h-4 w-4 ml-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
          </div>
          <button id="theme-toggle" class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
          </button>
          <button class="md:hidden p-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
      </div>
    </div>
  </header>

  <main class="flex-grow py-8">
    <div class="container mx-auto px-4">
      <div class="mb-6">
        <a href="dashboard.php" class="text-indigo-600 hover:text-indigo-800 inline-flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
          </svg>
          Back to Dashboard
        </a>
      </div>
      
      <!-- Profile Header -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="relative h-48 bg-gradient-to-r from-indigo-600 to-purple-600">
          <div class="absolute bottom-0 left-0 w-full p-6 flex items-end">
            <div class="flex flex-col sm:flex-row items-center sm:items-end sm:space-x-6">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User Avatar" class="h-24 w-24 rounded-full border-4 border-white object-cover">
              <div class="mt-4 sm:mt-0 text-center sm:text-left">
                <h1 class="text-2xl font-bold text-white"><?php echo $user_name; ?></h1>
                <p class="text-indigo-100">Web Development Student</p>
              </div>
            </div>
            <div class="ml-auto hidden sm:block">
              <button class="px-4 py-2 bg-white text-indigo-600 font-medium rounded-md hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Edit Profile
              </button>
            </div>
          </div>
        </div>
        <div class="p-6">
          <div class="sm:hidden mb-6 flex justify-center">
            <button class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Edit Profile
            </button>
          </div>
          <div class="flex flex-wrap -mx-3">
            <div class="w-full md:w-1/2 px-3 mb-6">
              <h2 class="text-lg font-semibold text-gray-900 mb-4">About Me</h2>
              <p class="text-gray-600">I'm a self-taught web developer passionate about creating intuitive user experiences. Currently focused on mastering JavaScript and React. I have 2 years of hobbyist experience and am looking to transition to a professional role in front-end development.</p>
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6">
              <h2 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h2>
              <ul class="space-y-3">
                <li class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                  </svg>
                  <?php echo $user_email; ?>
                </li>
                <li class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                  </svg>
                  (555) 123-4567
                </li>
                <li class="flex items-center text-gray-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  Jalandhar, Punjab, India
                </li>
              </ul>
            </div>
          </div>
          <div class="flex flex-wrap -mx-3">
            <div class="w-full md:w-1/2 px-3 mb-6">
              <h2 class="text-lg font-semibold text-gray-900 mb-4">Skills</h2>
              <div class="space-y-3">
                <div>
                  <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">HTML & CSS</span>
                    <span class="text-sm font-medium text-gray-700">90%</span>
                  </div>
                  <div class="h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-indigo-600 rounded-full" style="width: 90%"></div>
                  </div>
                </div>
                <div>
                  <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">JavaScript</span>
                    <span class="text-sm font-medium text-gray-700">75%</span>
                  </div>
                  <div class="h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-indigo-600 rounded-full" style="width: 75%"></div>
                  </div>
                </div>
                <div>
                  <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">React</span>
                    <span class="text-sm font-medium text-gray-700">60%</span>
                  </div>
                  <div class="h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-indigo-600 rounded-full" style="width: 60%"></div>
                  </div>
                </div>
                <div>
                  <div class="flex justify-between mb-1">
                    <span class="text-sm font-medium text-gray-700">Node.js</span>
                    <span class="text-sm font-medium text-gray-700">45%</span>
                  </div>
                  <div class="h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-indigo-600 rounded-full" style="width: 45%"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="w-full md:w-1/2 px-3 mb-6">
              <h2 class="text-lg font-semibold text-gray-900 mb-4">Learning Progress</h2>
              <div class="chart-container">
                <svg viewBox="0 0 36 36" class="circular-chart">
                  <path class="circle-bg" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" />
                  <path class="circle" stroke-dasharray="65, 100" d="M18 2.0845
                    a 15.9155 15.9155 0 0 1 0 31.831
                    a 15.9155 15.9155 0 0 1 0 -31.831" />
                  <text x="18" y="18.5" class="percentage">65%</text>
                </svg>
                <p class="text-center text-gray-600">Overall Completion</p>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Profile Tabs -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="border-b border-gray-200">
          <nav class="-mb-px flex overflow-x-auto">
            <a href="#" class="border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">Courses</a>
            <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">Certificates</a>
            <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">Activity</a>
            <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">Forum Posts</a>
            <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">Notes</a>
            <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">Saved Items</a>
          </nav>
        </div>
        <!-- Tab Content - Courses -->
        <div class="p-6">
          <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">My Courses</h2>
            <div class="flex items-center">
              <span class="mr-2 text-sm text-gray-600">Sort by:</span>
              <select class="text-sm border-gray-300 rounded-md focus:border-indigo-500 focus:ring-indigo-500">
                <option>Recently Accessed</option>
                <option>Progress</option>
                <option>Alphabetical</option>
              </select>
            </div>
          </div>
          
          <!-- Course Cards -->
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Course 1 -->
            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
              <div class="h-40 bg-gray-200 relative">
                <img src="https://images.unsplash.com/photo-1587620962725-abab7fe55159?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="JavaScript Fundamentals" class="w-full h-full object-cover">
                <div class="absolute top-2 right-2">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    In Progress
                  </span>
                </div>
              </div>
              <div class="p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-1">Introduction to JavaScript</h3>
                <p class="text-sm text-gray-600 mb-3">Learn the fundamentals of JavaScript programming</p>
                <div class="flex items-center text-sm text-gray-500 mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  12 hours of content
                </div>
                <div class="mb-3">
                  <div class="flex justify-between text-xs text-gray-600 mb-1">
                    <span>Progress</span>
                    <span>65%</span>
                  </div>
                  <div class="w-full h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-indigo-600 rounded-full" style="width: 65%"></div>
                  </div>
                </div>
                <a href="course-detail.php" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Continue Learning</a>
              </div>
            </div>
            
            <!-- Course 2 -->
            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
              <div class="h-40 bg-gray-200 relative">
                <img src="https://images.unsplash.com/photo-1592424002053-21f369ad7fdb?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="React Fundamentals" class="w-full h-full object-cover">
                <div class="absolute top-2 right-2">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                    In Progress
                  </span>
                </div>
              </div>
              <div class="p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-1">React Fundamentals</h3>
                <p class="text-sm text-gray-600 mb-3">Learn modern React with hooks and functional components</p>
                <div class="flex items-center text-sm text-gray-500 mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  15 hours of content
                </div>
                <div class="mb-3">
                  <div class="flex justify-between text-xs text-gray-600 mb-1">
                    <span>Progress</span>
                    <span>30%</span>
                  </div>
                  <div class="w-full h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-indigo-600 rounded-full" style="width: 30%"></div>
                  </div>
                </div>
                <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Continue Learning</a>
              </div>
            </div>
            
            <!-- Course 3 -->
            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
              <div class="h-40 bg-gray-200 relative">
                <img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Advanced CSS" class="w-full h-full object-cover">
                <div class="absolute top-2 right-2">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    Completed
                  </span>
                </div>
              </div>
              <div class="p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-1">Advanced CSS & Sass</h3>
                <p class="text-sm text-gray-600 mb-3">Master flexbox, CSS Grid, responsive design and more</p>
                <div class="flex items-center text-sm text-gray-500 mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  18 hours of content
                </div>
                <div class="mb-3">
                  <div class="flex justify-between text-xs text-gray-600 mb-1">
                    <span>Progress</span>
                    <span>100%</span>
                  </div>
                  <div class="w-full h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-indigo-600 rounded-full" style="width: 100%"></div>
                  </div>
                </div>
                <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">View Certificate</a>
              </div>
            </div>
            
            <!-- Course 4 -->
            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm hover:shadow-md transition-shadow">
              <div class="h-40 bg-gray-200 relative">
                <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="Node.js Basics" class="w-full h-full object-cover">
                <div class="absolute top-2 right-2">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                    Not Started
                  </span>
                </div>
              </div>
              <div class="p-4">
                <h3 class="text-lg font-medium text-gray-900 mb-1">Node.js Basics</h3>
                <p class="text-sm text-gray-600 mb-3">Build backend applications with JavaScript</p>
                <div class="flex items-center text-sm text-gray-500 mb-3">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  14 hours of content
                </div>
                <div class="mb-3">
                  <div class="flex justify-between text-xs text-gray-600 mb-1">
                    <span>Progress</span>
                    <span>0%</span>
                  </div>
                  <div class="w-full h-2 bg-gray-200 rounded-full">
                    <div class="h-2 bg-indigo-600 rounded-full" style="width: 0%"></div>
                  </div>
                </div>
                <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium text-sm">Start Course</a>
              </div>
            </div>
          </div>
          
          <!-- View All Courses Button -->
          <div class="mt-8 text-center">
            <button class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              View All Courses
            </button>
          </div>
        </div>
      </div>
      
      <!-- Learning Stats -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-6">
          <h2 class="text-lg font-semibold text-gray-900 mb-6">Learning Statistics</h2>
          
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Learning Time -->
            <div class="bg-gray-50 rounded-lg p-6">
              <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Total Learning Time</p>
                  <h3 class="text-xl font-bold text-gray-900">68 hours</h3>
                </div>
              </div>
              <div class="mt-4">
                <span class="text-sm text-green-600 flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
                  </svg>
                  +12 hours this month
                </span>
              </div>
            </div>
            
            <!-- Courses Completed -->
            <div class="bg-gray-50 rounded-lg p-6">
              <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Courses Completed</p>
                  <h3 class="text-xl font-bold text-gray-900">4 of 8</h3>
                </div>
              </div>
              <div class="mt-4">
                <div class="w-full h-2 bg-gray-200 rounded-full">
                  <div class="h-2 bg-indigo-600 rounded-full" style="width: 50%"></div>
                </div>
              </div>
            </div>
            
            <!-- Certificates Earned -->
            <div class="bg-gray-50 rounded-lg p-6">
              <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                  </svg>
                </div>
                <div>
                  <p class="text-sm text-gray-500">Certificates Earned</p>
                  <h3 class="text-xl font-bold text-gray-900">3</h3>
                </div>
              </div>
              <div class="mt-4">
                <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">View Certificates</a>
              </div>
            </div>
          </div>
          
          <div class="mt-8">
            <h3 class="text-base font-medium text-gray-900 mb-4">Weekly Activity</h3>
            <div class="flex items-center justify-between h-24 space-x-2">
              <div class="flex flex-col items-center justify-end h-full">
                <div class="bg-indigo-100 w-8 rounded-t-md" style="height: 30%"></div>
                <span class="text-xs text-gray-500 mt-1">Mon</span>
              </div>
              <div class="flex flex-col items-center justify-end h-full">
                <div class="bg-indigo-200 w-8 rounded-t-md" style="height: 60%"></div>
                <span class="text-xs text-gray-500 mt-1">Tue</span>
              </div>
              <div class="flex flex-col items-center justify-end h-full">
                <div class="bg-indigo-300 w-8 rounded-t-md" style="height: 45%"></div>
                <span class="text-xs text-gray-500 mt-1">Wed</span>
              </div>
              <div class="flex flex-col items-center justify-end h-full">
                <div class="bg-indigo-400 w-8 rounded-t-md" style="height: 80%"></div>
                <span class="text-xs text-gray-500 mt-1">Thu</span>
              </div>
              <div class="flex flex-col items-center justify-end h-full">
                <div class="bg-indigo-500 w-8 rounded-t-md" style="height: 65%"></div>
                <span class="text-xs text-gray-500 mt-1">Fri</span>
              </div>
              <div class="flex flex-col items-center justify-end h-full">
                <div class="bg-indigo-600 w-8 rounded-t-md" style="height: 40%"></div>
                <span class="text-xs text-gray-500 mt-1">Sat</span>
              </div>
              <div class="flex flex-col items-center justify-end h-full">
                <div class="bg-indigo-700 w-8 rounded-t-md" style="height: 20%"></div>
                <span class="text-xs text-gray-500 mt-1">Sun</span>
              </div>
            </div>
            <div class="mt-2 text-xs text-gray-500 flex justify-between">
              <span>Total this week: 8.5 hours</span>
              <span>Goal: 10 hours</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="bg-white border-t border-gray-200 py-8 mt-8">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <a href="home.php" class="flex items-center">
            <svg class="h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
              <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
            </svg>
            <span class="ml-2 text-xl font-bold text-gray-800">EduSphere</span>
          </a>
          <p class="mt-2 text-gray-600">Empowering learners worldwide with high-quality education and skills training.</p>
        </div>
        
        <div>
          <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Learn</h3>
          <ul class="mt-4 space-y-4">
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Course Catalog</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Learning Paths</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Skills Assessment</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Certificates</a></li>
          </ul>
        </div>
        
        <div>
          <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Company</h3>
          <ul class="mt-4 space-y-4">
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">About Us</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Careers</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Press</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Contact</a></li>
          </ul>
        </div>
        
        <div>
          <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Get Connected</h3>
          <ul class="mt-4 space-y-4">
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Blog</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Community</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Webinars</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Events</a></li>
          </ul>
        </div>
      </div>
      
      <div class="mt-8 border-t border-gray-200 pt-8 flex flex-col md:flex-row justify-between">
        <p class="text-base text-gray-500">&copy; 2025 EduSphere. All rights reserved.</p>
        <div class="mt-4 md:mt-0 flex space-x-6">
          <a href="#" class="text-gray-500 hover:text-indigo-600">
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>
            </svg>
          </a>
          <a href="#" class="text-gray-500 hover:text-indigo-600">
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723 10.097 10.097 0 01-3.127 1.184 4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.937 4.937 0 004.604 3.417 9.868 9.868 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.054 0 13.999-7.496 13.999-13.986 0-.209 0-.42-.015-.63a9.936 9.936 0 002.46-2.548l-.047-.02z"/>
            </svg>
          </a>
          <a href="#" class="text-gray-500 hover:text-indigo-600">
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.897 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.897-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
            </svg>
          </a>
          <a href="#" class="text-gray-500 hover:text-indigo-600">
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
              <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
            </svg>
          </a>
        </div>
      </div>
    </div>
  </footer>

  <script>
    // Theme Toggle
    const themeToggle = document.getElementById('theme-toggle');
    themeToggle.addEventListener('click', () => {
      document.body.classList.toggle('dark-mode');
      
      // Change icon based on current theme
      const isDarkMode = document.body.classList.contains('dark-mode');
      if (isDarkMode) {
        themeToggle.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="5"></circle>
            <line x1="12" y1="1" x2="12" y2="3"></line>
            <line x1="12" y1="21" x2="12" y2="23"></line>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
            <line x1="1" y1="12" x2="3" y2="12"></line>
            <line x1="21" y1="12" x2="23" y2="12"></line>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
          </svg>
        `;
      } else {
        themeToggle.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
          </svg>
        `;
      }
    });
  </script>
</body>
</html>