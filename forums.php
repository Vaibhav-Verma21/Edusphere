<?php
// Include the database connection
require 'db.php';

// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Fetch the user's data from the database
    $user_id = $_SESSION['user_id'];
    $query = "SELECT full_name, username FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_name = htmlspecialchars($user['full_name']); // Escape for security
        $user_username = htmlspecialchars($user['username']); // Escape for security
    } else {
        $user_name = "Unknown User"; // Fallback if user not found
        $user_username = "Unknown Username";
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
  <title>Forum Discussions - EduSphere</title>
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
            <a href="forum.php" class="text-indigo-600 border-b-2 border-indigo-600 pb-1">Forum</a>
            <a href="#" class="text-gray-600 hover:text-indigo-600">Support</a>
          </nav>
          <div class="relative">
            <button class="flex items-center focus:outline-none">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User Avatar" class="h-8 w-8 rounded-full object-cover">
              <span class="hidden md:block ml-2 text-sm font-medium text-gray-700"><?php echo $user_username; ?></span>
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
      <!-- Page Header -->
      <div class="mb-6 flex items-center justify-between">
        <div>
          <h1 class="text-3xl font-bold text-white-900">Community Forum</h1>
          <p class="mt-1 text-gray-600">Connect with fellow learners and instructors</p>
        </div>
        <div>
          <button class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Create New Topic
          </button>
        </div>
      </div>
      
      <!-- Search and Filter -->
      <div class="mb-8 bg-white rounded-lg shadow-md p-4">
        <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
          <div class="w-full md:w-1/2">
            <div class="relative">
              <input type="text" placeholder="Search discussions..." class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <select class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option>All Categories</option>
              <option>Web Development</option>
              <option>Data Science</option>
              <option>Business</option>
              <option>Design</option>
              <option>Mobile Development</option>
            </select>
            <select class="px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
              <option>Latest Activity</option>
              <option>Most Popular</option>
              <option>Newest</option>
              <option>Oldest</option>
            </select>
          </div>
        </div>
      </div>
      
      <!-- Main Forum Content -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Forum Categories and Topics -->
        <div class="lg:col-span-2">
          <!-- Category: General Discussion -->
          <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
            <div class="bg-indigo-600 px-6 py-3">
              <h2 class="text-lg font-semibold text-white">General Discussion</h2>
            </div>
            
            <!-- Topic List -->
            <div class="divide-y divide-gray-200">
              <!-- Topic 1 -->
              <div class="p-6 hover:bg-gray-50">
                <div class="flex items-start">
                  <div class="flex-shrink-0 mr-4">
                    <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="User Avatar" class="h-10 w-10 rounded-full object-cover">
                  </div>
                  <div class="flex-1 min-w-0">
                    <a href="#" class="text-lg font-medium text-indigo-600 hover:text-indigo-800">Tips for staying motivated during long courses</a>
                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                      I'm finding it challenging to stay motivated through some of the longer courses. Does anyone have any strategies they'd like to share? I find that setting small goals and...
                    </p>
                    <div class="mt-2 flex items-center">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Motivation</span>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 ml-2">Study Tips</span>
                    </div>
                  </div>
                  <div class="flex-shrink-0 ml-4 text-sm text-right">
                    <span class="text-gray-500">Sara Wilson</span>
                    <p class="mt-1 text-gray-500">2 hours ago</p>
                    <div class="mt-2 flex items-center justify-end space-x-2">
                      <span class="flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        24
                      </span>
                      <span class="flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        487
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Topic 2 -->
              <div class="p-6 hover:bg-gray-50">
                <div class="flex items-start">
                  <div class="flex-shrink-0 mr-4">
                    <img src="https://randomuser.me/api/portraits/men/43.jpg" alt="User Avatar" class="h-10 w-10 rounded-full object-cover">
                  </div>
                  <div class="flex-1 min-w-0">
                    <a href="#" class="text-lg font-medium text-indigo-600 hover:text-indigo-800">What learning path should I take for web development?</a>
                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                      I'm new to programming and want to become a web developer. There are so many options and technologies to learn. Should I start with front-end or back-end? What languages...
                    </p>
                    <div class="mt-2 flex items-center">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">Career Advice</span>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 ml-2">Web Development</span>
                    </div>
                  </div>
                  <div class="flex-shrink-0 ml-4 text-sm text-right">
                    <span class="text-gray-500">Michael Chen</span>
                    <p class="mt-1 text-gray-500">Yesterday</p>
                    <div class="mt-2 flex items-center justify-end space-x-2">
                      <span class="flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        42
                      </span>
                      <span class="flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        936
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Topic 3 -->
              <div class="p-6 hover:bg-gray-50">
                <div class="flex items-start">
                  <div class="flex-shrink-0 mr-4">
                    <img src="https://randomuser.me/api/portraits/women/42.jpg" alt="User Avatar" class="h-10 w-10 rounded-full object-cover">
                  </div>
                  <div class="flex-1 min-w-0">
                    <a href="#" class="text-lg font-medium text-indigo-600 hover:text-indigo-800">Certificates: Are they worth it and do employers value them?</a>
                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                      I'm considering upgrading to get certificates for the courses I complete. Has anyone found these certificates helpful in their job search or career advancement? Do employers...
                    </p>
                    <div class="mt-2 flex items-center">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-pink-100 text-pink-800">Certificates</span>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800 ml-2">Career</span>
                    </div>
                  </div>
                  <div class="flex-shrink-0 ml-4 text-sm text-right">
                    <span class="text-gray-500">Emily Johnson</span>
                    <p class="mt-1 text-gray-500">2 days ago</p>
                    <div class="mt-2 flex items-center justify-end space-x-2">
                      <span class="flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        56
                      </span>
                      <span class="flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        1,120
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Category: Course-Specific Discussions -->
          <div class="bg-white rounded-lg shadow-md mb-6 overflow-hidden">
            <div class="bg-indigo-600 px-6 py-3">
              <h2 class="text-lg font-semibold text-white">Course-Specific Discussions</h2>
            </div>
            
            <!-- Topic List -->
            <div class="divide-y divide-gray-200">
              <!-- Topic 1 -->
              <div class="p-6 hover:bg-gray-50">
                <div class="flex items-start">
                  <div class="flex-shrink-0 mr-4">
                    <img src="https://randomuser.me/api/portraits/men/67.jpg" alt="User Avatar" class="h-10 w-10 rounded-full object-cover">
                  </div>
                  <div class="flex-1 min-w-0">
                    <a href="#" class="text-lg font-medium text-indigo-600 hover:text-indigo-800">Help with JavaScript Promises in Module 4</a>
                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                      I'm stuck on the async/await section of the JavaScript course. The exercise in module 4 about fetching multiple APIs is confusing me. Can someone explain how to chain promises...
                    </p>
                    <div class="mt-2 flex items-center">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">JavaScript</span>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">Help Needed</span>
                    </div>
                  </div>
                  <div class="flex-shrink-0 ml-4 text-sm text-right">
                    <span class="text-gray-500">David Wilson</span>
                    <p class="mt-1 text-gray-500">4 hours ago</p>
                    <div class="mt-2 flex items-center justify-end space-x-2">
                      <span class="flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        18
                      </span>
                      <span class="flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        324
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Topic 2 -->
              <div class="p-6 hover:bg-gray-50">
                <div class="flex items-start">
                  <div class="flex-shrink-0 mr-4">
                    <img src="https://randomuser.me/api/portraits/women/23.jpg" alt="User Avatar" class="h-10 w-10 rounded-full object-cover">
                  </div>
                  <div class="flex-1 min-w-0">
                    <a href="#" class="text-lg font-medium text-indigo-600 hover:text-indigo-800">Project ideas for the Python for Data Science course</a>
                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                      I've finished all the modules in the Python for Data Science course and want to build a project to solidify my skills. Does anyone have suggestions for beginner-friendly...
                    </p>
                    <div class="mt-2 flex items-center">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Python</span>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">Project Ideas</span>
                    </div>
                  </div>
                  <div class="flex-shrink-0 ml-4 text-sm text-right">
                    <span class="text-gray-500">Sophia Martinez</span>
                    <p class="mt-1 text-gray-500">1 day ago</p>
                    <div class="mt-2 flex items-center justify-end space-x-2">
                      <span class="flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        35
                      </span>
                      <span class="flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        764
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Topic 3 -->
              <div class="p-6 hover:bg-gray-50">
                <div class="flex items-start">
                  <div class="flex-shrink-0 mr-4">
                    <img src="https://randomuser.me/api/portraits/men/85.jpg" alt="User Avatar" class="h-10 w-10 rounded-full object-cover">
                  </div>
                  <div class="flex-1 min-w-0">
                    <a href="#" class="text-lg font-medium text-indigo-600 hover:text-indigo-800">Anyone else having issues with the UI Design final quiz?</a>
                    <p class="mt-1 text-sm text-gray-600 line-clamp-2">
                      I think there might be a bug in the UI Design course's final quiz. Question #7 about color theory seems to mark the correct answer as wrong. Has anyone else encountered this...
                    </p>
                    <div class="mt-2 flex items-center">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">UI Design</span>
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 ml-2">Bug Report</span>
                    </div>
                  </div>
                  <div class="flex-shrink-0 ml-4 text-sm text-right">
                    <span class="text-gray-500">James Taylor</span>
                    <p class="mt-1 text-gray-500">3 days ago</p>
                    <div class="mt-2 flex items-center justify-end space-x-2">
                      <span class="flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        27
                      </span>
                      <span class="flex items-center text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                        512
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <!-- View More Button -->
            <div class="bg-gray-50 px-6 py-4">
              <button class="w-full text-indigo-600 hover:text-indigo-800 font-medium">
                View More Discussions
              </button>
            </div>
          </div>
        </div>
        
        <!-- Sidebar -->
        <div>
          <!-- User Stats -->
          <div class="bg-white rounded-lg shadow-md mb-6 p-6">
            <div class="flex items-center">
              <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User Avatar" class="h-16 w-16 rounded-full object-cover">
              <div class="ml-4">
                <h3 class="text-lg font-semibold text-white-900"><?php echo $user_username; ?></h3>
                <p class="text-sm text-gray-600">Member since Mar 2025</p>
              </div>
            </div>
            
            <div class="mt-6 grid grid-cols-2 gap-4">
              <div class="bg-gray-50 rounded-lg p-4 text-center">
                <span class="block text-2xl font-bold text-indigo-600">24</span>
                <span class="text-sm text-gray-600">Posts</span>
              </div>
              <div class="bg-gray-50 rounded-lg p-4 text-center">
                <span class="block text-2xl font-bold text-indigo-600">87</span>
                <span class="text-sm text-gray-600">Replies</span>
              </div>
            </div>
            
            <div class="mt-6">
              <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium">View My Activity</a>
            </div>
          </div>
          
          <!-- Popular Tags -->
          <div class="bg-white rounded-lg shadow-md mb-6 p-6">
            <h3 class="text-lg font-semibold text-white-900 mb-4">Popular Tags</h3>
            
            <div class="flex flex-wrap gap-2">
              <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-indigo-100 text-gray-800 hover:text-indigo-800 rounded-full text-sm">JavaScript</a>
              <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-indigo-100 text-gray-800 hover:text-indigo-800 rounded-full text-sm">Python</a>
              <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-indigo-100 text-gray-800 hover:text-indigo-800 rounded-full text-sm">Web Development</a>
              <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-indigo-100 text-gray-800 hover:text-indigo-800 rounded-full text-sm">Data Science</a>
              <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-indigo-100 text-gray-800 hover:text-indigo-800 rounded-full text-sm">UI Design</a>
              <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-indigo-100 text-gray-800 hover:text-indigo-800 rounded-full text-sm">Career</a>
              <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-indigo-100 text-gray-800 hover:text-indigo-800 rounded-full text-sm">Project Ideas</a>
              <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-indigo-100 text-gray-800 hover:text-indigo-800 rounded-full text-sm">Help Needed</a>
              <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-indigo-100 text-gray-800 hover:text-indigo-800 rounded-full text-sm">Certificates</a>
              <a href="#" class="px-3 py-1 bg-gray-100 hover:bg-indigo-100 text-gray-800 hover:text-indigo-800 rounded-full text-sm">Study Tips</a>
            </div>
          </div>
          
          <!-- Top Contributors -->
          <div class="bg-white rounded-lg shadow-md mb-6 p-6">
            <h3 class="text-lg font-semibold text-white-900 mb-4">Top Contributors</h3>
            
            <ul class="space-y-4">
              <li class="flex items-center">
                <span class="flex-shrink-0 w-8 text-center text-gray-500 font-medium">1</span>
                <img src="https://randomuser.me/api/portraits/women/42.jpg" alt="User Avatar" class="h-10 w-10 rounded-full object-cover mx-3">
                <div>
                  <span class="block font-medium text-white-900">Emily Johnson</span>
                  <span class="text-sm text-gray-600">542 contributions</span>
                </div>
              </li>
              <li class="flex items-center">
                <span class="flex-shrink-0 w-8 text-center text-gray-500 font-medium">2</span>
                <img src="https://randomuser.me/api/portraits/men/54.jpg" alt="User Avatar" class="h-10 w-10 rounded-full object-cover mx-3">
                <div>
                  <span class="block font-medium text-white-900">Robert Smith</span>
                  <span class="text-sm text-gray-600">437 contributions</span>
                </div>
              </li>
              <li class="flex items-center">
                <span class="flex-shrink-0 w-8 text-center text-gray-500 font-medium">3</span>
                <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="User Avatar" class="h-10 w-10 rounded-full object-cover mx-3">
                <div>
                  <span class="block font-medium text-white-900">Sara Wilson</span>
                  <span class="text-sm text-gray-600">389 contributions</span>
                </div>
              </li>
              <li class="flex items-center">
                <span class="flex-shrink-0 w-8 text-center text-gray-500 font-medium">4</span>
                <img src="https://randomuser.me/api/portraits/men/43.jpg" alt="User Avatar" class="h-10 w-10 rounded-full object-cover mx-3">
                <div>
                  <span class="block font-medium text-white-900">Michael Chen</span>
                  <span class="text-sm text-gray-600">356 contributions</span>
                </div>
              </li>
              <li class="flex items-center">
                <span class="flex-shrink-0 w-8 text-center text-gray-500 font-medium">5</span>
                <img src="https://randomuser.me/api/portraits/women/23.jpg" alt="User Avatar" class="h-10 w-10 rounded-full object-cover mx-3">
                <div>
                  <span class="block font-medium text-white-900">Sophia Martinez</span>
                  <span class="text-sm text-gray-600">312 contributions</span>
                </div>
              </li>
            </ul>
          </div>
          
          <!-- Community Guidelines -->
          <div class="bg-white rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-white-900 mb-4">Community Guidelines</h3>
            
            <ul class="space-y-3 text-sm text-gray-600">
              <li class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Be respectful and kind to other community members</span>
              </li>
              <li class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Stay on topic and keep discussions relevant to learning</span>
              </li>
              <li class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>No spamming, advertising, or self-promotion</span>
              </li>
              <li class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Give credit when sharing others' content or code</span>
              </li>
              <li class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600 mr-2 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <span>Report inappropriate content to moderators</span>
              </li>
            </ul>
            
            <a href="#" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-medium">View Full Guidelines</a>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="bg-white border-t border-gray-200 py-8">
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
          <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Community</h3>
          <ul class="mt-4 space-y-4">
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Forum</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Events</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Discord Server</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Mentorship</a></li>
          </ul>
        </div>
        
        <div>
          <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">Get Connected</h3>
          <ul class="mt-4 space-y-4">
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Blog</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Newsletter</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Support</a></li>
            <li><a href="#" class="text-base text-gray-600 hover:text-indigo-600">Contact</a></li>
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
              <path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/>
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
            z
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