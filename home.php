<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EduSphere - Online Learning Platform</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css"> -->
  <script src="https://cdn.tailwindcss.com"></script>

<style>
    body {
      font-family: 'Inter', sans-serif;
    }
    .hero {
      background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
    }
    .feature-card:hover {
      transform: translateY(-5px);
    }
    .testimonial-card:hover {
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
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
    .dark-mode .faq-item h3 {
      color: #F9FAFB;
    }
    .dark-mode .faq-item p {
      color: #D1D5DB;
    }
    .dark-mode .border-gray-200 {
      border-color: #374151;
    }
    .dark-mode .feature-card {
      background-color: #1F2937;
      border-color: #374151;
    }
    .dark-mode .testimonial-card {
      background-color: #1F2937;
      border-color: #374151;
    }
    .dark-mode .stats-item {
      background-color: #1F2937;
      border-color: #374151;
    }
    .dark-mode .faq-item {
      border-color: #374151;
      background-color: #1F2937;
    }
    .dark-mode .bg-gray-50 {
      background-color: #111827;
    }
    .course-card:hover .course-card-overlay {
      opacity: 1;
    }

    /* Theme toggle button styles */
    #theme-toggle {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: 2px solid transparent; /* Default border */
      transition: all 0.3s ease;
    }

    /* Light mode styles */
    body:not(.dark-mode) #theme-toggle {
      background-color: #f3f4f6; /* Light gray background */
      border-color: #d1d5db; /* Light gray border */
      color: #374151; /* Dark gray icon color */
    }

    /* Dark mode styles */
    body.dark-mode #theme-toggle {
      background-color: #374151; /* Dark gray background */
      border-color: #4b5563; /* Dark gray border */
      color: #f9fafb; /* Light icon color */
    }

    /* Hover effect */
    #theme-toggle:hover {
      border-color: #6366f1; /* Indigo border on hover */
    }

    /* Dark mode styles for the input field */
    body.dark-mode input[name="subscriber_email"] {
      background-color: #374151; /* Dark gray background */
      color: #f9fafb; /* Light text color */
      border-color: #4b5563; /* Dark gray border */
    }

    body.dark-mode input[name="subscriber_email"]::placeholder {
      color: #9ca3af; /* Light gray placeholder text */
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
        <nav class="hidden md:flex items-center space-x-8">
          <a href="home.php" class="text-indigo-600 font-medium">Home</a>
          <a href="courses.php" class="text-gray-600 hover:text-indigo-600">Courses</a>
          <a href="#" class="text-gray-600 hover:text-indigo-600">About</a>
          <a href="#" class="text-gray-600 hover:text-indigo-600">Contact</a>
          <a href="#" class="text-gray-600 hover:text-indigo-600">Blog</a>
        </nav>
        <div class="flex items-center space-x-4">
        <?php
          if (isset($_SESSION['user_id'])) {
            // If the user is logged in, show the user-line icon
            $username = htmlspecialchars($_SESSION['username']); // Assuming 'username' is stored in the session
            echo '<a href="dashboard.php" class="p-2 rounded-full bg-gray-100 hover:bg-gray-200">
                    <img src="user-line.png" alt="User Dashboard" class="h-6 w-6">
                  </a>';
            echo '<span class="text-gray-800 font-medium">' . $username . '</span>'; // Display the username
          } else {
            // If the user is logged out, show the Sign In button
            echo '<a href="auth.php" class="px-4 py-2 rounded bg-indigo-600 text-white hover:bg-indigo-700">Sign In</a>';
          }
          ?>
          <button id="theme-toggle" class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </header>

  <main class="flex-grow">
    <!-- Hero Section -->
    <section class="hero py-20 md:py-32 text-white">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center">
          <div class="md:w-1/2 mb-10 md:mb-0">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">Expand Your Knowledge and Skills with Online Courses</h1>
            <p class="text-lg md:text-xl mb-8">Learn from industry experts and gain valuable skills that will help you advance in your career or explore new passions.</p>
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
              <a href="courses.php" class="px-6 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100 text-center">Explore Courses</a>
              <a href="auth.php" class="px-6 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:bg-opacity-10 text-center">Join for Free</a>
            </div>
          </div>
          <div class="md:w-1/2">
            <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=870&q=80" alt="Students learning online" class="rounded-lg shadow-xl">
          </div>
        </div>
      </div>
    </section>
    
    <!-- Stats Section -->
    <section class="py-16 bg-white">
      <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
          <div class="stats-item bg-gray-50 rounded-lg p-6 text-center border border-gray-100">
            <div class="text-4xl font-bold text-indigo-600 mb-2">5M+</div>
            <div class="text-gray-600">Students</div>
          </div>
          <div class="stats-item bg-gray-50 rounded-lg p-6 text-center border border-gray-100">
            <div class="text-4xl font-bold text-indigo-600 mb-2">10K+</div>
            <div class="text-gray-600">Courses</div>
          </div>
          <div class="stats-item bg-gray-50 rounded-lg p-6 text-center border border-gray-100">
            <div class="text-4xl font-bold text-indigo-600 mb-2">250+</div>
            <div class="text-gray-600">Instructors</div>
          </div>
          <div class="stats-item bg-gray-50 rounded-lg p-6 text-center border border-gray-100">
            <div class="text-4xl font-bold text-indigo-600 mb-2">15M+</div>
            <div class="text-gray-600">Course Enrollments</div>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Featured Courses Section -->
    <section class="py-16 bg-gray-50">
      <div class="container mx-auto px-4">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">Featured Courses</h2>
          <p class="text-gray-600 max-w-xl mx-auto">Explore our most popular courses and start your learning journey today.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Course 1 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden course-card">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1052&q=80" alt="JavaScript Mastery" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
              </div>
              <div class="absolute top-4 right-4 bg-indigo-600 text-white text-sm font-bold px-3 py-1 rounded">Bestseller</div>
            </div>
            <div class="p-6">
              <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-indigo-600">Programming</span>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-sm text-gray-600 ml-1">4.9 (2.5k reviews)</span>
                </div>
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">JavaScript Mastery: ES6 to Advanced Concepts</h3>
              <p class="text-gray-600 mb-4">Master modern JavaScript from basics to advanced topics with practical examples.</p>
              <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-800">$69.99</span>
                <a href="#" class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg font-medium">Enroll Now</a>
              </div>
            </div>
          </div>
          
          <!-- Course 2 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden course-card">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1580894732930-0babd100d356?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="Python Course" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
              </div>
              <div class="absolute top-4 right-4 bg-green-500 text-white text-sm font-bold px-3 py-1 rounded">New</div>
            </div>
            <div class="p-6">
              <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-indigo-600">Data Science</span>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-sm text-gray-600 ml-1">4.7 (1.8k reviews)</span>
                </div>
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">Python Programming Masterclass</h3>
              <p class="text-gray-600 mb-4">Learn Python from scratch with projects in web development, data science, and AI.</p>
              <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-800">$79.99</span>
                <a href="#" class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg font-medium">Enroll Now</a>
              </div>
            </div>
          </div>
          
          <!-- Course 3 -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden course-card">
            <div class="relative">
              <img src="https://images.unsplash.com/photo-1633356122544-f134324a6cee?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1050&q=80" alt="Machine Learning" class="w-full h-48 object-cover">
              <div class="absolute inset-0 bg-black bg-opacity-60 opacity-0 transition-opacity duration-300 flex items-center justify-center course-card-overlay">
                <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 transition">View Details</a>
              </div>
            </div>
            <div class="p-6">
              <div class="flex justify-between items-center mb-3">
                <span class="text-sm font-medium text-indigo-600">Artificial Intelligence</span>
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                  <span class="text-sm text-gray-600 ml-1">4.9 (3.2k reviews)</span>
                </div>
              </div>
              <h3 class="text-xl font-bold text-gray-800 mb-2">Machine Learning & Deep Learning in Python</h3>
              <p class="text-gray-600 mb-4">Master machine learning algorithms and techniques with real-world projects.</p>
              <div class="flex justify-between items-center">
                <span class="text-2xl font-bold text-gray-800">$99.99</span>
                <a href="#" class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-lg font-medium">Enroll Now</a>
              </div>
            </div>
          </div>
        </div>
        
        <div class="text-center mt-10">
          <a href="courses.php" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 inline-block">View All Courses</a>
        </div>
      </div>
    </section>
    
    <!-- Features Section -->
    <section class="py-16 bg-white">
      <div class="container mx-auto px-4">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">Why Choose EduSphere?</h2>
          <p class="text-gray-600 max-w-xl mx-auto">Our platform offers a variety of features designed to provide the best learning experience.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Feature 1 -->
          <div class="feature-card p-6 rounded-lg border border-gray-200 bg-gray-50 transition duration-300">
            <div class="text-indigo-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Diverse Course Library</h3>
            <p class="text-gray-600">Access thousands of courses across various categories, from programming to business and beyond.</p>
          </div>
          
          <!-- Feature 2 -->
          <div class="feature-card p-6 rounded-lg border border-gray-200 bg-gray-50 transition duration-300">
            <div class="text-indigo-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Expert Instructors</h3>
            <p class="text-gray-600">Learn from industry experts and professionals with years of experience in their respective fields.</p>
          </div>
          
          <!-- Feature 3 -->
          <div class="feature-card p-6 rounded-lg border border-gray-200 bg-gray-50 transition duration-300">
            <div class="text-indigo-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Lifetime Access</h3>
            <p class="text-gray-600">Once enrolled, you can access course materials anytime, allowing you to learn at your own pace.</p>
          </div>
          
          <!-- Feature 4 -->
          <div class="feature-card p-6 rounded-lg border border-gray-200 bg-gray-50 transition duration-300">
            <div class="text-indigo-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Recognized Certificates</h3>
            <p class="text-gray-600">Earn certificates upon course completion that are recognized by employers and institutions.</p>
          </div>
          
          <!-- Feature 5 -->
          <div class="feature-card p-6 rounded-lg border border-gray-200 bg-gray-50 transition duration-300">
            <div class="text-indigo-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Community Support</h3>
            <p class="text-gray-600">Connect with fellow learners and instructors through discussion forums and community features.</p>
          </div>
          
          <!-- Feature 6 -->
          <div class="feature-card p-6 rounded-lg border border-gray-200 bg-gray-50 transition duration-300">
            <div class="text-indigo-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
              </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">Interactive Learning</h3>
            <p class="text-gray-600">Engage with quizzes, projects, and interactive content to enhance your learning experience.</p>
          </div>
        </div>
      </div>
    </section>
    
    <!-- Categories Section -->
    <section class="py-16 bg-gray-50">
      <div class="container mx-auto px-4">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">Explore Course Categories</h2>
          <p class="text-gray-600 max-w-xl mx-auto">Browse courses by category to find the perfect learning path for your goals.</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
          <!-- Category 1 -->
          <a href="#" class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition duration-300 border border-gray-200">
            <div class="text-indigo-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
              </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Programming</h3>
            <p class="text-gray-600 text-sm">482 Courses</p>
          </a>
          
          <!-- Category 2 -->
          <a href="#" class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition duration-300 border border-gray-200">
            <div class="text-indigo-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Web Development</h3>
            <p class="text-gray-600 text-sm">645 Courses</p>
          </a>
          
          <!-- Category 3 -->
          <a href="#" class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition duration-300 border border-gray-200">
            <div class="text-indigo-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
              </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Data Science</h3>
            <p class="text-gray-600 text-sm">392 Courses</p>
          </a>
          
          <!-- Category 4 -->
          <a href="#" class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition duration-300 border border-gray-200">
            <div class="text-indigo-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
              </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Artificial Intelligence</h3>
            <p class="text-gray-600 text-sm">278 Courses</p>
          </a>
          
          <!-- Category 5 -->
          <a href="#" class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition duration-300 border border-gray-200">
            <div class="text-indigo-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
              </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Mobile Development</h3>
            <p class="text-gray-600 text-sm">325 Courses</p>
          </a>
          
          <!-- Category 6 -->
          <a href="#" class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition duration-300 border border-gray-200">
            <div class="text-indigo-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
              </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Digital Marketing</h3>
            <p class="text-gray-600 text-sm">210 Courses</p>
          </a>
          
          <!-- Category 7 -->
          <a href="#" class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition duration-300 border border-gray-200">
            <div class="text-indigo-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Business & Finance</h3>
            <p class="text-gray-600 text-sm">430 Courses</p>
          </a>
          
          <!-- Category 8 -->
          <a href="#" class="bg-white rounded-lg p-6 text-center shadow-sm hover:shadow-md transition duration-300 border border-gray-200">
            <div class="text-indigo-600 mb-4">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
              </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mb-1">Design & Creativity</h3>
            <p class="text-gray-600 text-sm">365 Courses</p>
          </a>
        </div>
        
        <div class="text-center mt-10">
          <a href="courses.php" class="px-6 py-3 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 inline-block">View All Categories</a>
        </div>
      </div>
    </section>
    
    <!-- Testimonials Section -->
    <section class="py-16 bg-white">
      <div class="container mx-auto px-4">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">What Our Students Say</h2>
          <p class="text-gray-600 max-w-xl mx-auto">Discover how EduSphere has helped thousands of students achieve their learning goals.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
          <!-- Testimonial 1 -->
          <div class="testimonial-card p-6 rounded-lg border border-gray-200 bg-gray-50 transition duration-300">
            <div class="flex items-center mb-4">
              <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Student" class="h-12 w-12 rounded-full object-cover mr-4">
              <div>
                <h4 class="text-lg font-bold text-gray-800">Sarah Johnson</h4>
                <p class="text-gray-600">Software Developer</p>
              </div>
            </div>
            <div class="mb-4">
              <div class="flex text-yellow-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              </div>
            </div>
            <p class="text-gray-600">"The JavaScript Mastery course completely transformed my career. The instructor's approach was clear and practical. I landed a job as a frontend developer within months of completion."</p>
          </div>
          
          <!-- Testimonial 2 -->
          <div class="testimonial-card p-6 rounded-lg border border-gray-200 bg-gray-50 transition duration-300">
            <div class="flex items-center mb-4">
              <img src="https://randomuser.me/api/portraits/men/44.jpg" alt="Student" class="h-12 w-12 rounded-full object-cover mr-4">
              <div>
                <h4 class="text-lg font-bold text-gray-800">Michael Chen</h4>
                <p class="text-gray-600">Data Scientist</p>
              </div>
            </div>
            <div class="mb-4">
              <div class="flex text-yellow-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              </div>
            </div>
            <p class="text-gray-600">"I took the Python for Data Science course and it exceeded my expectations. The projects were relevant to real-world scenarios, and the community support was invaluable. Highly recommend!"</p>
          </div>
          
          <!-- Testimonial 3 -->
          <div class="testimonial-card p-6 rounded-lg border border-gray-200 bg-gray-50 transition duration-300">
            <div class="flex items-center mb-4">
              <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Student" class="h-12 w-12 rounded-full object-cover mr-4">
              <div>
                <h4 class="text-lg font-bold text-gray-800">Emily Rodriguez</h4>
                <p class="text-gray-600">UX Designer</p>
              </div>
            </div>
            <div class="mb-4">
              <div class="flex text-yellow-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
              </div>
            </div>
            <p class="text-gray-600">"The UI/UX Design course gave me the skills and confidence to switch careers. The feedback from instructors was detailed and helped me build an impressive portfolio."</p>
          </div>
        </div>
      </div>
    </section>
    
    <!-- FAQ Section -->
    <section class="py-16 bg-gray-50">
      <div class="container mx-auto px-4">
        <div class="text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">Frequently Asked Questions</h2>
          <p class="text-gray-600 max-w-xl mx-auto">Find answers to common questions about our platform and courses.</p>
        </div>
        
        <div class="max-w-3xl mx-auto">
          <!-- FAQ Item 1 -->
          <div class="faq-item mb-6 border-b border-gray-200 pb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-2">How do I enroll in a course?</h3>
            <p class="text-gray-600">To enroll in a course, browse our course catalog, select the course you're interested in, and click on the "Enroll Now" button. You'll need to create an account or log in if you already have one. Follow the checkout process to complete your enrollment.</p>
          </div>
          
          <!-- FAQ Item 2 -->
          <div class="faq-item mb-6 border-b border-gray-200 pb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Do I get lifetime access to courses?</h3>
            <p class="text-gray-600">Yes, once you enroll in a course, you'll have lifetime access to all course materials, updates, and community features. You can learn at your own pace and revisit course content whenever you need to.</p>
          </div>
          
          <!-- FAQ Item 3 -->
          <div class="faq-item mb-6 border-b border-gray-200 pb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Are there any prerequisites for courses?</h3>
            <p class="text-gray-600">Prerequisites vary by course. Each course description includes detailed information about any prior knowledge or skills required. We offer courses for all levels, from beginners to advanced learners, so you can find the right starting point for your journey.</p>
          </div>
          
          <!-- FAQ Item 4 -->
          <div class="faq-item mb-6 border-b border-gray-200 pb-6">
            <h3 class="text-xl font-bold text-gray-800 mb-2">How do I get a certificate?</h3>
            <p class="text-gray-600">Certificates are awarded upon successful completion of courses. This typically includes watching all lessons, completing quizzes or assignments, and passing the final assessment. Once complete, you can download your certificate directly from your dashboard.</p>
          </div>
          
          <!-- FAQ Item 5 -->
          <div class="faq-item">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Can I get a refund if I'm not satisfied?</h3>
            <p class="text-gray-600">Yes, we offer a 30-day money-back guarantee for most courses. If you're not satisfied with your purchase, you can request a refund within 30 days of enrollment. Please refer to our refund policy for more details.</p>
          </div>
        </div>
      </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-16 bg-indigo-600 text-white">
      <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
          <h2 class="text-3xl font-bold mb-6">Ready to Start Your Learning Journey?</h2>
          <p class="text-lg mb-8">Join thousands of students who are already learning and growing with EduSphere.</p>
          <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="courses.php" class="px-8 py-3 bg-white text-indigo-600 font-semibold rounded-lg hover:bg-gray-100 text-center">Explore Courses</a>
            <a href="auth.php" class="px-8 py-3 border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:bg-opacity-10 text-center">Sign Up for Free</a>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="bg-gray-800 text-white py-12">
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
              <span class="text-gray-400">LPU Phagwara, Punjab, India, 144401</span>
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
              <span class="text-gray-400">+91 940500934</span>
            </li>
          </ul>
          <h3 class="text-lg font-semibold mt-6 mb-4">Subscribe to Newsletter</h3>
          <form method="POST" class="flex">
            <input 
              type="email" 
              name="subscriber_email" 
              placeholder="Your email" 
              class="px-4 py-2 w-full rounded-l focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent text-gray-900 bg-white" 
              required>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-r">
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

      // Save preference to localStorage
      if (body.classList.contains('dark-mode')) {
        localStorage.setItem('theme', 'dark');

        // Update toggle icon for dark mode
        themeToggle.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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

        // Update toggle icon for light mode
        themeToggle.innerHTML = `
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
          </svg>`;
      }
    });
    
    // Check for saved theme preference or respect OS theme setting
    const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");
    if (localStorage.getItem("theme") === "dark" || (!localStorage.getItem("theme") && prefersDarkScheme.matches)) {
      body.classList.add("dark-mode");
      
      // Update toggle icon
      themeToggle.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-200" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
    
    // Mobile menu toggle
    const mobileMenuButton = document.querySelector('.md\\:hidden button');
    const mobileMenu = document.querySelector('.md\\:hidden.hidden');
    
    if (mobileMenuButton && mobileMenu) {
      mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
      });
    }
  </script>

  <?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;

  require 'vendor/autoload.php';

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['subscriber_email'])) {
      $subscriber_email = $_POST['subscriber_email'];

      $mail = new PHPMailer(true);

      try {
          // SMTP configuration
          $mail->isSMTP();
          $mail->Host       = 'smtp.gmail.com';
          $mail->SMTPAuth   = true;
          $mail->Username   = 'vermavaibhav268@gmail.com'; // Your Gmail address
          $mail->Password   = 'vpdh aolk hnpr wgov'; // Your Gmail app password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
          $mail->Port       = 587;

          // Email content
          $mail->setFrom('vermavaibhav268@gmail.com', 'EduSphere');
          $mail->addAddress($subscriber_email); // Send email to the subscriber

          $mail->isHTML(true);
          $mail->Subject = 'Welcome to EduSphere Newsletter!';
          $mail->Body    = 'Thank you for subscribing to the EduSphere newsletter. Stay tuned for updates!';
          $mail->AltBody = 'Thank you for subscribing to the EduSphere newsletter. Stay tuned for updates!';

          $mail->send();
          echo '<p class="text-green-500">✅ Subscription successful! A confirmation email has been sent to your email address.</p>';
      } catch (Exception $e) {
          echo '<p class="text-red-500">❌ Subscription failed. Mailer Error: ' . $mail->ErrorInfo . '</p>';
      }
  }
  ?>
</body>
</html>