<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Course: Introduction to JavaScript - EduSphere</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    .progress-bar {
      background: linear-gradient(to right, #4F46E5 0%, #4F46E5 var(--progress), #E5E7EB var(--progress), #E5E7EB 100%);
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
    .dark-mode .progress-bar {
      background: linear-gradient(to right, #4F46E5 0%, #4F46E5 var(--progress), #374151 var(--progress), #374151 100%);
    }
    .video-container {
      position: relative;
      padding-bottom: 56.25%; /* 16:9 Aspect Ratio */
      height: 0;
      overflow: hidden;
    }
    .video-container iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
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
            <a href="forums.php" class="text-gray-600 hover:text-indigo-600">Forum</a>
            <a href="#" class="text-gray-600 hover:text-indigo-600">Support</a>
          </nav>
          <div class="relative">
            <button class="flex items-center focus:outline-none">
            <?php
          session_start();
          if (isset($_SESSION['user_id'])) {
            // If the user is logged in, show the user-line icon
            $username = $_SESSION['username']; // Assuming 'username' is stored in the session
            echo '<a href="dashboard.php" class="p-2 rounded-full bg-gray-100 hover:bg-gray-200">
                    <img src="user-line.png" alt="User Dashboard" class="h-6 w-6">
                  </a>';
          } else {
            // If the user is logged out, show the Sign In button
            echo '<a href="auth.php" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Sign In</a>';
          }
          ?>
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
      <!-- Back to courses link -->
      <div class="mb-6">
        <a href="courses.php" class="text-indigo-600 hover:text-indigo-800 inline-flex items-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
          </svg>
          Back to Courses
        </a>
      </div>
      
      <!-- Course Title & Info -->
      <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
        <div class="p-6">
          <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div>
              <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 mb-3">
                <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                  <circle cx="4" cy="4" r="3" />
                </svg>
                Web Development
              </span>
              <h1 class="text-3xl font-bold text-white-900">Introduction to JavaScript</h1>
              <p class="mt-2 text-gray-600">Learn the fundamentals of JavaScript programming from scratch</p>
            </div>
            <div class="mt-4 md:mt-0 flex items-center">
              <div class="mr-6">
                <span class="block text-2xl font-bold text-white-900">4.8</span>
                <div class="flex items-center">
                  <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="ml-1 text-sm text-gray-500">(523 reviews)</span>
                </div>
              </div>
              <button class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Continue Learning</button>
            </div>
          </div>
          
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-6">
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
              </svg>
              <span class="text-gray-600">18,245 students</span>
            </div>
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
              </svg>
              <span class="text-gray-600">12 hours of content</span>
            </div>
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
              </svg>
              <span class="text-gray-600">24 lessons</span>
            </div>
            <div class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
              </svg>
              <span class="text-gray-600">Beginner Level</span>
            </div>
          </div>
          
          <div class="mt-6">
            <h3 class="text-lg font-semibold text-white-900">Your Progress</h3>
            <div class="mt-2 flex items-center">
              <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="progress-bar h-2.5 rounded-full" style="--progress: 45%"></div>
              </div>
              <span class="ml-3 text-sm font-medium text-gray-600">45% Complete</span>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Course Content Tabs -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
          <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="border-b border-gray-200">
              <nav class="-mb-px flex">
                <a href="#" class="border-indigo-500 text-indigo-600 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">Lessons</a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">Overview</a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">Reviews</a>
                <a href="#" class="border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-4 px-6 border-b-2 font-medium text-sm">Discussion</a>
              </nav>
            </div>
            
            <!-- Current Lesson -->
            <div class="p-6">
              <h2 class="text-xl font-bold text-white-900 mb-4">Variables and Data Types</h2>
              
              <div class="video-container mb-6">
                <iframe src="https://www.youtube.com/embed/hdI2bqOjy3c" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
              </div>
              
              <div class="prose max-w-none">
                <h3>Introduction to Variables</h3>
                <p>In JavaScript, a variable is a container for a value. You can create a variable using the keywords: <code>var</code>, <code>let</code>, or <code>const</code>.</p>
                
                <pre class="bg-gray-100 p-4 rounded mt-4 mb-4 overflow-x-auto"><code>// Using let (recommended for variables that will change)
let name = "John";
let age = 30;

// Using const (for variables that won't change)
const PI = 3.14159;

// Using var (older way, less recommended)
var score = 100;</code></pre>
                
                <h3>Data Types in JavaScript</h3>
                <p>JavaScript has several built-in data types:</p>
                
                <ul>
                  <li><strong>String:</strong> Used for text</li>
                  <li><strong>Number:</strong> Used for all types of numbers (integers and floating point)</li>
                  <li><strong>Boolean:</strong> true or false</li>
                  <li><strong>Object:</strong> Collection of related data</li>
                  <li><strong>Array:</strong> List of items (technically objects)</li>
                  <li><strong>Null:</strong> Intentional absence of any value</li>
                  <li><strong>Undefined:</strong> Variable declared but not assigned a value</li>
                </ul>
                
                <p>You can check the data type of a variable using the <code>typeof</code> operator:</p>
                
                <pre class="bg-gray-100 p-4 rounded mt-4 mb-4 overflow-x-auto"><code>let name = "John";
let age = 30;
let isStudent = true;

console.log(typeof name);      // "string"
console.log(typeof age);       // "number"
console.log(typeof isStudent); // "boolean"</code></pre>
              </div>
              
              <div class="flex justify-between mt-8">
                <button class="flex items-center text-gray-600 hover:text-indigo-600">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                  </svg>
                  Previous Lesson
                </button>
                <button class="flex items-center text-indigo-600 hover:text-indigo-800">
                  Next Lesson
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                  </svg>
                </button>
              </div>
            </div>
          </div>
          
          <!-- Comments Section -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
              <h3 class="text-lg font-semibold text-white-900 mb-4">Discussion (24 comments)</h3>
              
              <!-- Comment Form -->
              <div class="mb-6">
                <div class="flex items-start">
                  <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="User Avatar" class="h-10 w-10 rounded-full object-cover">
                  <div class="ml-3 flex-1">
                    <textarea class="w-full border border-gray-300 rounded-md shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" rows="3" placeholder="Add a comment..."></textarea>
                    <div class="mt-2 flex justify-end">
                      <button class="px-4 py-2 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Post Comment</button>
                    </div>
                  </div>
                </div>
              </div>
              
              <!-- Comments List -->
              <div class="space-y-6">
                <div class="flex items-start">
                  <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="User Avatar" class="h-10 w-10 rounded-full object-cover">
                  <div class="ml-3">
                    <div class="flex items-center">
                      <h4 class="font-medium text-white-900">Sara Wilson</h4>
                      <span class="ml-2 text-sm text-gray-500">2 days ago</span>
                    </div>
                    <p class="text-gray-600 mt-1">Great explanation of variables! I was confused about the difference between let and const, but now it makes sense. Thank you!</p>
                    <div class="mt-2 flex items-center space-x-4">
                      <button class="text-sm text-gray-500 hover:text-indigo-600">Reply</button>
                      <button class="text-sm text-gray-500 hover:text-indigo-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                        </svg>
                        Like (8)
                      </button>
                    </div>
                  </div>
                </div>
                
                <div class="flex items-start">
                  <img src="https://randomuser.me/api/portraits/men/43.jpg" alt="User Avatar" class="h-10 w-10 rounded-full object-cover">
                  <div class="ml-3">
                    <div class="flex items-center">
                      <h4 class="font-medium text-white-900">Michael Chen</h4>
                      <span class="ml-2 text-sm text-gray-500">1 week ago</span>
                    </div>
                    <p class="text-gray-600 mt-1">Is there any performance difference between using let and var? I've heard that var has some issues with scoping that let fixes.</p>
                    <div class="mt-2 flex items-center space-x-4">
                      <button class="text-sm text-gray-500 hover:text-indigo-600">Reply</button>
                      <button class="text-sm text-gray-500 hover:text-indigo-600 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                          <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                        </svg>
                        Like (3)
                      </button>
                    </div>
                    
                    <!-- Nested Reply -->
                    <div class="mt-4 ml-6">
                      <div class="flex items-start">
                        <img src="https://randomuser.me/api/portraits/women/42.jpg" alt="User Avatar" class="h-8 w-8 rounded-full object-cover">
                        <div class="ml-3">
                          <div class="flex items-center">
                            <h4 class="font-medium text-white-900">Emily Johnson <span class="text-indigo-600">(Instructor)</span></h4>
                            <span class="ml-2 text-sm text-gray-500">6 days ago</span>
                          </div>
                          <p class="text-gray-600 mt-1">Great question, Michael! The main difference is in how they're scoped. 'var' is function-scoped while 'let' is block-scoped, which helps prevent issues with variables leaking outside their intended scope. In terms of raw performance, there's negligible difference.</p>
                          <div class="mt-2 flex items-center space-x-4">
                            <button class="text-sm text-gray-500 hover:text-indigo-600">Reply</button>
                            <button class="text-sm text-gray-500 hover:text-indigo-600 flex items-center">
                              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z" />
                              </svg>
                              Like (12)
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                
                <div class="pt-4">
                  <button class="text-indigo-600 hover:text-indigo-800 font-medium">View all 24 comments</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Course Sidebar -->
        <div>
          <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-6">
              <h3 class="text-lg font-semibold text-white-900 mb-4">Course Content</h3>
              
              <div class="space-y-4">
                <!-- Section 1 -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                  <div class="flex justify-between items-center p-4 bg-gray-50">
                    <h4 class="font-medium text-white-900">1. Getting Started</h4>
                    <span class="text-sm text-gray-500">3/3 lessons • 35 min</span>
                  </div>
                  <div class="p-4 space-y-3">
                    <div class="flex items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                      </svg>
                      <span class="text-white-600">Introduction to the Course</span>
                      <span class="ml-auto text-sm text-gray-500">10 min</span>
                    </div>
                    <div class="flex items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                      </svg>
                      <span class="text-gray-600">Setting Up Your Environment</span>
                      <span class="ml-auto text-sm text-gray-500">15 min</span>
                    </div>
                    <div class="flex items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                      </svg>
                      <span class="text-gray-600">Your First JavaScript Program</span>
                      <span class="ml-auto text-sm text-gray-500">10 min</span>
                    </div>
                  </div>
                </div>
                
                <!-- Section 2 -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                  <div class="flex justify-between items-center p-4 bg-gray-50">
                    <h4 class="font-medium text-white-900">2. JavaScript Fundamentals</h4>
                    <span class="text-sm text-gray-500">2/4 lessons • 55 min</span>
                  </div>
                  <div class="p-4 space-y-3">
                    <div class="flex items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                      </svg>
                      <span class="text-gray-600">Syntax and Statements</span>
                      <span class="ml-auto text-sm text-gray-500">15 min</span>
                    </div>
                    <div class="flex items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                      </svg>
                      <span class="text-gray-600">Variables and Data Types</span>
                      <span class="ml-auto text-sm text-gray-500">20 min</span>
                    </div>
                    <div class="flex items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                      </svg>
                      <span class="text-gray-600">Operators and Expressions</span>
                      <span class="ml-auto text-sm text-gray-500">15 min</span>
                    </div>
                    <div class="flex items-center">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                      </svg>
                      <span class="text-gray-600">Control Flow</span>
                      <span class="ml-auto text-sm text-gray-500">20 min</span>
                    </div>
                  </div>
                </div>
                
                <!-- Section 3 (Collapsed) -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                  <div class="flex justify-between items-center p-4 bg-gray-50">
                    <h4 class="font-medium text-white-900">3. Functions & Scope</h4>
                    <span class="text-sm text-gray-500">0/4 lessons • 65 min</span>
                  </div>
                </div>
                
                <!-- Section 4 (Collapsed) -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                  <div class="flex justify-between items-center p-4 bg-gray-50">
                    <h4 class="font-medium text-white-900">4. Arrays and Objects</h4>
                    <span class="text-sm text-gray-500">0/5 lessons • 80 min</span>
                  </div>
                </div>
                
                <!-- Section 5 (Collapsed) -->
                <div class="border border-gray-200 rounded-md overflow-hidden">
                  <div class="flex justify-between items-center p-4 bg-gray-50">
                    <h4 class="font-medium text-white-900">5. DOM Manipulation</h4>
                    <span class="text-sm text-gray-500">0/4 lessons • 70 min</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <!-- Instructor Info -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
            <div class="p-6">
              <h3 class="text-lg font-semibold text-white-900 mb-4">Your Instructor</h3>
              
              <div class="flex items-center mb-4">
                <img src="https://randomuser.me/api/portraits/women/42.jpg" alt="Instructor" class="h-14 w-14 rounded-full object-cover">
                <div class="ml-3">
                  <h4 class="font-medium text-white-900">Emily Johnson</h4>
                  <p class="text-gray-600 text-sm">Web Development Instructor</p>
                </div>
              </div>
              
              <div class="flex items-center space-x-4 mb-4">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="ml-1 text-gray-600">4.9 Instructor Rating</span>
                </div>
                <span class="text-gray-600">|</span>
                <span class="text-gray-600">73 Courses</span>
              </div>
              
              <p class="text-gray-600 text-sm">Emily is a software engineer with over 10 years of experience in web development. She specializes in JavaScript and front-end frameworks, and has taught over 200,000 students worldwide.</p>
              
              <a href="#" class="mt-4 inline-block text-indigo-600 hover:text-indigo-800 font-medium">View Profile</a>
            </div>
          </div>
          
          <!-- Resources -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
              <h3 class="text-lg font-semibold text-white-900 mb-4">Course Resources</h3>
              
              <ul class="space-y-3">
                <li>
                  <a href="#" class="flex items-center text-indigo-600 hover:text-indigo-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Course Slides (PDF)
                  </a>
                </li>
                <li>
                  <a href="#" class="flex items-center text-indigo-600 hover:text-indigo-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Exercise Files
                  </a>
                </li>
                <li>
                  <a href="#" class="flex items-center text-indigo-600 hover:text-indigo-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    Cheat Sheet
                  </a>
                </li>
                <li>
                  <a href="#" class="flex items-center text-indigo-600 hover:text-indigo-800">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M11 3a1 1 0 10-2 0v1a1 1 0 102 0V3zM15.657 5.757a1 1 0 00-1.414-1.414l-.707.707a1 1 0 001.414 1.414l.707-.707zM18 10a1 1 0 01-1 1h-1a1 1 0 110-2h1a1 1 0 011 1zM5.05 6.464A1 1 0 106.464 5.05l-.707-.707a1 1 0 00-1.414 1.414l.707.707zM5 10a1 1 0 01-1 1H3a1 1 0 110-2h1a1 1 0 011 1zM8 16v-1h4v1a2 2 0 11-4 0zM12 14c.015-.34.208-.646.477-.859a4 4 0 10-4.954 0c.27.213.462.519.476.859h4.002z" />
                    </svg>
                    Further Reading
                  </a>
                </li>
              </ul>
            </div>
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

    // Set theme based on device preference
    const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
    if (prefersDarkScheme.matches) {
      document.body.classList.add('dark-mode');
    }

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