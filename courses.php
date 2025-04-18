<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Courses - EduSphere</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
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
    .dark-mode .bg-gray-50 {
      background-color: #111827;
    }
    .dark-mode .bg-gray-100 {
      background-color: #1F2937;
    }
    .dark-mode .border-gray-200 {
      border-color: #374151;
    }
    .dark-mode .filter-item {
      background-color: #374151;
      border-color: #4B5563;
    }
    .filter-item.active {
      background-color: rgba(79, 70, 229, 0.1);
      color: #4F46E5;
    }
    .dark-mode .filter-item.active {
      background-color: rgba(99, 102, 241, 0.2);
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
  <header class="bg-white shadow sticky top-0 z-10">
    <div class="container mx-auto px-4 py-4">
      <div class="flex justify-between items-center">
        <div class="flex items-center">
          <a href="home.php" class="flex items-center">
            <svg class="h-10 w-10 text-indigo-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
              <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
            </svg>
            <span class="ml-2 text-xl font-bold text-gray-800">EduSphere</span>
          </a>
        </div>
        <nav class="hidden md:flex items-center space-x-8">
          <a href="home.php" class="text-gray-600 hover:text-indigo-600">Home</a>
          <a href="courses.php" class="text-indigo-600 font-medium">Courses</a>
          <a href="forums.php" class="text-gray-600 hover:text-indigo-600">Forums</a>
          <a href="dashboard.php" class="text-gray-600 hover:text-indigo-600">Dashboard</a>
          <a href="#" class="text-gray-600 hover:text-indigo-600">About</a>
        </nav>
        <div class="flex items-center space-x-4">
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
          <!-- Theme toggle button -->
          <button id="theme-toggle" class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
          </button>

        </div>
      </div>
    </div>
  </header>

  <main class="flex-grow container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row">
      <!-- Filters Sidebar -->
      <div class="md:w-1/4 pr-0 md:pr-8 mb-8 md:mb-0">
        <div class="bg-white p-6 rounded-lg shadow">
          <h2 class="text-xl font-bold text-gray-800 mb-4">Filter Courses</h2>
          
          <!-- Search Box -->
          <div class="mb-6">
            <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <div class="relative">
              <input type="text" id="search" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Search courses...">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
              </div>
            </div>
          </div>
          
          <!-- Categories Filter -->
          <div class="mb-6">
            <h3 class="text-md font-medium text-gray-800 mb-2">Categories</h3>
            <div class="space-y-2">
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">Web Development (24)</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">Data Science (18)</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">Mobile Development (12)</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">Cloud Computing (8)</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">DevOps (6)</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">Artificial Intelligence (14)</span>
              </label>
            </div>
            <button class="text-sm text-indigo-600 mt-2 hover:text-indigo-800">Show more</button>
          </div>
          
          <!-- Skill Level Filter -->
          <div class="mb-6">
            <h3 class="text-md font-medium text-gray-800 mb-2">Skill Level</h3>
            <div class="space-y-2">
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">Beginner (32)</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">Intermediate (28)</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">Advanced (16)</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">All Levels (6)</span>
              </label>
            </div>
          </div>
          
          <!-- Price Filter -->
          <div class="mb-6">
            <h3 class="text-md font-medium text-gray-800 mb-2">Price</h3>
            <div class="space-y-2">
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">Free (8)</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">Paid (74)</span>
              </label>
            </div>
          </div>
          
          <!-- Rating Filter -->
          <div class="mb-6">
            <h3 class="text-md font-medium text-gray-800 mb-2">Rating</h3>
            <div class="space-y-2">
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700 flex items-center">
                  <span class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                  </span>
                  <span class="ml-1">& up (42)</span>
                </span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700 flex items-center">
                  <span class="flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                    </svg>
                  </span>
                  <span class="ml-1">& up (68)</span>
                </span>
              </label>
            </div>
          </div>
          
          <!-- Duration Filter -->
          <div class="mb-6">
            <h3 class="text-md font-medium text-gray-800 mb-2">Duration</h3>
            <div class="space-y-2">
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">0-2 Hours (12)</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">3-6 Hours (24)</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">7-16 Hours (36)</span>
              </label>
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                <span class="ml-2 text-sm text-gray-700">17+ Hours (10)</span>
              </label>
            </div>
          </div>
          
          <div class="flex space-x-2">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded-md font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Apply Filters</button>
            <button class="px-4 py-2 border border-gray-300 text-gray-700 rounded-md font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Reset</button>
          </div>
        </div>
      </div>
      
      <!-- Courses Grid -->
      <div class="md:w-3/4">
        <!-- Filter Bar -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 bg-white p-4 rounded-lg shadow">
          <div>
            <h1 class="text-2xl font-bold text-gray-800">All Courses</h1>
            <p class="text-gray-600">Showing 12 of 82 courses</p>
          </div>
          <div class="mt-4 sm:mt-0 flex items-center">
            <span class="text-sm text-gray-600 mr-2">Sort by:</span>
            <select class="border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-sm">
              <option class="text-black">Most Popular</option>
              <option class="text-black">Highest Rated</option>
              <option class="text-black">Newest</option>
              <option class="text-black">Price: Low to High</option>
              <option class="text-black">Price: High to Low</option>
            </select>
          </div>
        </div>
        
        <!-- Mobile Filter Button -->
        <div class="mb-4 md:hidden">
          <button class="w-full py-2 px-4 border border-gray-300 rounded-md text-gray-700 font-medium flex items-center justify-center hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
            </svg>
            Filter Courses
          </button>
        </div>
        
        <!-- Course Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <!-- Course 1 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden course-card">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1052&q=80" alt="JavaScript Mastery" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                <a href="course-detail.php" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
              </div>
              <div class="absolute top-4 right-4 bg-indigo-600 text-white text-sm font-bold px-3 py-1 rounded">Bestseller</div>
            </div>
            <div class="p-6">
              <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-indigo-600">JavaScript</span>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-sm text-gray-600 ml-1">4.9</span>
                </div>
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">JavaScript Mastery: ES6 to Advanced Concepts</h3>
              <p class="text-gray-600 mb-4">Learn modern JavaScript from basics to advanced topics with practical examples.</p>
              <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-800">$69.99</span>
                <span class="text-sm text-gray-500">42 hours</span>
              </div>
            </div>
          </div>
          
          <!-- Course 2 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden course-card">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1488590528505-98d2b5aba04b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="React Course" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                <a href="course-detail.php" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
              </div>
            </div>
            <div class="p-6">
              <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-indigo-600">React</span>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-sm text-gray-600 ml-1">4.8</span>
                </div>
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">React - The Complete Guide with Hooks</h3>
              <p class="text-gray-600 mb-4">From fundamentals to advanced patterns with React, Redux, and React Native.</p>
              <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-800">$89.99</span>
                <span class="text-sm text-gray-500">48 hours</span>
              </div>
            </div>
          </div>
          
          <!-- Course 3 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden course-card">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1580894732930-0babd100d356?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="Python Course" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                <a href="course-detail.php" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
              </div>
              <div class="absolute top-4 right-4 bg-green-500 text-white text-sm font-bold px-3 py-1 rounded">New</div>
            </div>
            <div class="p-6">
              <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-indigo-600">Python</span>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-sm text-gray-600 ml-1">4.7</span>
                </div>
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">Python Programming Masterclass</h3>
              <p class="text-gray-600 mb-4">Learn Python from scratch with projects in web development, data science, and AI.</p>
              <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-800">$79.99</span>
                <span class="text-sm text-gray-500">56 hours</span>
              </div>
            </div>
          </div>
          
          <!-- Course 4 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden course-card">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="Machine Learning" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
              </div>
            </div>
            <div class="p-6">
              <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-indigo-600">Machine Learning</span>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-sm text-gray-600 ml-1">4.9</span>
                </div>
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">Machine Learning & Deep Learning in Python</h3>
              <p class="text-gray-600 mb-4">Master machine learning algorithms and techniques with real-world projects.</p>
              <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-800">$99.99</span>
                <span class="text-sm text-gray-500">62 hours</span>
              </div>
            </div>
          </div>
          
          <!-- Course 5 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden course-card">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1618761714954-0b8cd0026356?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="AWS Cloud" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
              </div>
            </div>
            <div class="p-6">
              <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-indigo-600">AWS</span>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-sm text-gray-600 ml-1">4.7</span>
                </div>
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">AWS Certified Solutions Architect</h3>
              <p class="text-gray-600 mb-4">Complete preparation for the Solutions Architect Associate certification.</p>
              <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-800">$129.99</span>
                <span class="text-sm text-gray-500">32 hours</span>
              </div>
            </div>
          </div>
          
          <!-- Course 6 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden course-card">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="Node.js" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
              </div>
            </div>
            <div class="p-6">
              <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-indigo-600">Node.js</span>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-sm text-gray-600 ml-1">4.6</span>
                </div>
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">Complete Node.js Developer Course</h3>
              <p class="text-gray-600 mb-4">Build and deploy powerful backend applications with Node.js, Express and MongoDB.</p>
              <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-800">$74.99</span>
                <span class="text-sm text-gray-500">38 hours</span>
              </div>
            </div>
          </div>
          
          <!-- Course 7 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden course-card">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1610563166150-b34df4f3bcd6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="Angular" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
              </div>
            </div>
            <div class="p-6">
              <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-indigo-600">Angular</span>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-sm text-gray-600 ml-1">4.5</span>
                </div>
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">Angular - The Complete Guide</h3>
              <p class="text-gray-600 mb-4">Master Angular 13 with practical applications and industry best practices.</p>
              <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-800">$84.99</span>
                <span class="text-sm text-gray-500">33 hours</span>
              </div>
            </div>
          </div>
          
          <!-- Course 8 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden course-card">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1603468620905-8de7d86b781e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1055&q=80" alt="UI/UX Design" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
              </div>
            </div>
            <div class="p-6">
              <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-indigo-600">UI/UX Design</span>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-sm text-gray-600 ml-1">4.8</span>
                </div>
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">UI/UX Design Masterclass</h3>
              <p class="text-gray-600 mb-4">Learn professional UI/UX design processes with Figma, Adobe XD, and user research.</p>
              <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-800">$89.99</span>
                <span class="text-sm text-gray-500">26 hours</span>
              </div>
            </div>
          </div>
          
          <!-- Course 9 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden course-card">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1544197150-b99a580bb7a8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="Docker & Kubernetes" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
              </div>
              <div class="absolute top-4 right-4 bg-green-500 text-white text-sm font-bold px-3 py-1 rounded">New</div>
            </div>
            <div class="p-6">
              <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-indigo-600">Docker & Kubernetes</span>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-sm text-gray-600 ml-1">4.7</span>
                </div>
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">Docker and Kubernetes: The Complete Guide</h3>
              <p class="text-gray-600 mb-4">Master containerization and orchestration for modern application deployment.</p>
              <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-800">$94.99</span>
                <span class="text-sm text-gray-500">22 hours</span>
              </div>
            </div>
          </div>
        </div>
        
        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
          <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
              <span class="sr-only">Previous</span>
              <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
              </svg>
            </a>
            <a href="#" aria-current="page" class="z-10 bg-indigo-50 border-indigo-500 text-indigo-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
              1
            </a>
            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
              2
            </a>
            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
              3
            </a>
            <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
              ...
            </span>
            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
              8
            </a>
            <a href="#" class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
              9
            </a>
            <a href="#" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
              <span class="sr-only">Next</span>
              <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10l-3.293-3.293a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
              </svg>
            </a>
          </nav>
        </div>
      </div>
    </div>
  </main>

  <footer class="bg-gray-800 text-white py-12 mt-16">
    <div class="container mx-auto px-4">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
        <div>
          <div class="flex items-center mb-4">
            <svg class="h-8 w-8 text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
              <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
            </svg>
            <span class="ml-2 text-xl font-bold">EduSphere</span>
          </div>
          <p class="text-gray-400 mb-4">Empowering learners worldwide with quality education and practical skills.</p>
          <div class="flex space-x-4">
            <a href="#" class="text-gray-400 hover:text-white">
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
              </svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-white">
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd" />
              </svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-white">
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
              </svg>
            </a>
            <a href="#" class="text-gray-400 hover:text-white">
              <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd" />
              </svg>
            </a>
          </div>
        </div>
        
        <div>
          <h3 class="text-lg font-semibold mb-4">Course Categories</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-gray-400 hover:text-white">Web Development</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white">Data Science</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white">Mobile Development</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white">Cloud Computing</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white">Artificial Intelligence</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white">DevOps</a></li>
          </ul>
        </div>
        
        <div>
          <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
          <ul class="space-y-2">
            <li><a href="home.php" class="text-gray-400 hover:text-white">Home</a></li>
            <li><a href="courses.php" class="text-gray-400 hover:text-white">Courses</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white">About Us</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white">Contact</a></li>
            <li><a href="#" class="text-gray-400 hover:text-white">Become an Instructor</a></li>
            <li><a href="auth.php" class="text-gray-400 hover:text-white">Sign In / Sign Up</a></li>
          </ul>
        </div>
        
        <div>
          <h3 class="text-lg font-semibold mb-4">Contact Info</h3>
          <ul class="space-y-2">
            <li class="flex items-start">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 mt-0.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
              </svg>
              <span class="text-gray-400">123 Education St, Learning City, 94567</span>
            </li>
            <li class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
              <span class="text-gray-400">support@edusphere.com</span>
            </li>
            <li class="flex items-center">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
              <span class="text-gray-400">+1 (555) 123-4567</span>
            </li>
          </ul>
          <h3 class="text-lg font-semibold mt-6 mb-4">Subscribe to Newsletter</h3>
          <form class="flex">
            <input type="email" placeholder="Your email" class="px-4 py-2 w-full rounded-l focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-800 bg-blue-400 ">
            <button class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-r">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
              </svg>
            </button>
          </form>
        </div>
      </div>
      
      <div class="border-t border-gray-700 mt-10 pt-6 text-center">
        <p class="text-gray-400">© 2023 EduSphere. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script>
    // Dark mode toggle functionality
    const themeToggle = document.getElementById('theme-toggle');
    const body = document.body;
    
    themeToggle.addEventListener('click', () => {
      body.classList.toggle('dark-mode');
      
      // Update the toggle icon
      const isDarkMode = body.classList.contains('dark-mode');
      themeToggle.innerHTML = isDarkMode ? 
        `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="5"></circle>
          <line x1="12" y1="1" x2="12" y2="3"></line>
          <line x1="12" y1="21" x2="12" y2="23"></line>
          <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
          <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
          <line x1="1" y1="12" x2="3" y2="12"></line>
          <line x1="21" y1="12" x2="23" y2="12"></line>
          <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
          <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
        </svg>` : 
        `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
        </svg>`;
    });
    
    // Check for saved theme preference or respect OS theme setting
    const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");
    if (localStorage.getItem("theme") === "dark" || (!localStorage.getItem("theme") && prefersDarkScheme.matches)) {
      body.classList.add("dark-mode");
      themeToggle.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
    
    // Mobile filter toggle
    const mobileFilterBtn = document.querySelector('.md\\:hidden button');
    const filterSidebar = document.querySelector('.md\\:w-1\\/4');
    
    if (mobileFilterBtn && filterSidebar) {
      mobileFilterBtn.addEventListener('click', () => {
        filterSidebar.classList.toggle('hidden');
      });
    }
  </script>
</body>
</html>