<?php 
session_start(); // Start the session
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        // Registration logic
        $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (full_name, username, email, password) VALUES ('$full_name', '$username', '$email', '$hashed_password')";

        if (mysqli_query($conn, $sql)) {
            header("Location: home.php");
            exit();
        } else {
            echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
        }
    } elseif (isset($_POST['login'])) {
        // Login logic
        $username_or_email = mysqli_real_escape_string($conn, $_POST['username_or_email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Check if the user exists
        $sql = "SELECT * FROM users WHERE username = '$username_or_email' OR email = '$username_or_email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $user = mysqli_fetch_assoc($result);

            // Verify the password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error_message = 'Incorrect password. Forgot your password?';
            }
        } else {
            $error_message = 'This account does not exist.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In / Register - EduSphere</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    .auth-banner {
      background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
    }
    .dark-mode {
      background-color: #111827;
      color: #F9FAFB;
    }
    .dark-mode .auth-form {
      background-color: #1F2937;
      border-color: #374151;
    }
    .dark-mode .auth-form input {
      background-color: #374151;
      color: #F9FAFB;
      border-color: #4B5563;
    }
    .dark-mode .auth-form input::placeholder {
      color: #9CA3AF;
    }
    .dark-mode .auth-tabs button {
      color: #D1D5DB;
    }
    .dark-mode .auth-tabs button.active {
      color: #F9FAFB;
      border-color: #7C3AED;
    }
    .auth-form {
      padding: 2rem; /* Add padding inside the form */
      border-radius: 1rem; /* Make the corners rounded */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Add a subtle shadow */
      background-color: #ffffff; /* Ensure the background is white */
    }

    .auth-form input {
      border-radius: 0.5rem; /* Round the corners of input fields */
      padding: 0.75rem; /* Add more padding inside input fields */
    }

    .auth-form button {
      border-radius: 0.5rem; /* Round the corners of the button */
    }

    .auth-form .mb-4,
    .auth-form .mb-6 {
      margin-bottom: 1.5rem; /* Add more spacing between form elements */
    }

    /* Dark mode styles for header and footer */
    .dark-mode header {
      background-color: #1F2937; /* Dark background for header */
      color: #F9FAFB; /* Light text color */
    }

    .dark-mode footer {
      background-color: #1F2937; /* Dark background for footer */
      color: #F9FAFB; /* Light text color */
    }

    .dark-mode footer a {
      color: #9CA3AF; /* Light gray links */
    }

    .dark-mode footer a:hover {
      color: #F9FAFB; /* Light text color on hover */
    }

    /* Dark mode styles for the EduSphere logo text */
    .dark-mode .text-gray-800 {
      color: #F9FAFB !important; /* Light text color for dark mode */
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
        <div>
          <button id="theme-toggle" class="p-2 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </header>

  <main class="flex-grow flex">
    <div class="container mx-auto px-4 py-12 flex flex-col lg:flex-row">
      <!-- Auth Form Section -->
      <div class="lg:w-1/2 lg:pr-10 mb-10 lg:mb-0">
        <div class="max-w-md mx-auto">
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Welcome to EduSphere</h1>
          <p class="text-gray-600 mb-8">Join our learning community to access all courses and features.</p>
          
          <!-- Auth Tabs -->
          <div class="flex auth-tabs mb-6 border-b border-gray-200">
            <button id="login-tab" class="px-4 py-2 font-medium text-sm text-indigo-600 border-b-2 border-indigo-600 active">Sign In</button>
            <button id="register-tab" class="px-4 py-2 font-medium text-sm text-gray-500 hover:text-gray-700">Register</button>
          </div>
          
          <!-- Login Form -->
          <form id="login-form" class="auth-form" method="POST" action="">
            <?php if (!empty($error_message)): ?>
                <div class="mb-4 text-red-600 text-sm">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <div class="mb-4">
              <label for="login-username-or-email" class="block text-sm font-medium text-gray-700 mb-1">Username or Email</label>
              <input type="text" id="login-username-or-email" name="username_or_email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Enter your username or email" required>
            </div>
            
            <div class="mb-6">
              <label for="login-password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
              <input type="password" id="login-password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Enter your password" required>
              <div class="flex justify-end mt-1">
                <a href="forgot_password.php" class="text-sm text-indigo-600 hover:text-indigo-500">Forgot password?</a>
              </div>
            </div>
            
            <button type="submit" name="login" class="w-full py-2 px-4 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Sign In</button>
          </form>
          
          <!-- Register Form (hidden by default) -->
          <form id="register-form" class="auth-form hidden" method="POST" action="">
            <div class="mb-4">
              <label for="register-fullname" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
              <input type="text" id="register-fullname" name="full_name" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Enter your full name" required>
            </div>
            
            <div class="mb-4">
              <label for="register-username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
              <input type="text" id="register-username" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Choose a username" required>
            </div>
            
            <div class="mb-4">
              <label for="register-email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
              <input type="email" id="register-email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Enter your email" required>
            </div>
            
            <div class="mb-6">
              <label for="register-password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
              <input type="password" id="register-password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Create a password" required>
              <p class="mt-1 text-sm text-gray-500">Password must be at least 8 characters long</p>
            </div>
            
            <div class="mb-6">
              <label class="flex items-center">
                <input type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded" required>
                <span class="ml-2 text-sm text-gray-700">
                  I agree to the <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms of Service</a> and <a href="#" class="text-indigo-600 hover:text-indigo-500">Privacy Policy</a>
                </span>
              </label>
            </div>
            
            <button type="submit" name="submit" class="w-full py-2 px-4 bg-indigo-600 text-white font-medium rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Create Account</button>
          </form>
        </div>
      </div>
      
      <!-- Banner Section -->
      <div class="lg:w-1/2 auth-banner rounded-lg overflow-hidden flex flex-col text-white">
        <div class="p-8 md:p-12 flex flex-col h-full justify-between">
          <div>
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Start your learning journey today</h2>
            <p class="text-lg mb-8">
              Join thousands of students already expanding their knowledge and skills on EduSphere.
            </p>
            
            <div class="space-y-6">
              <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                  <h3 class="font-semibold text-lg">Expert Instructors</h3>
                  <p>Learn from industry experts with proven track records.</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                  <h3 class="font-semibold text-lg">Interactive Learning</h3>
                  <p>Engage with quizzes, projects, and real-world applications.</p>
                </div>
              </div>
              
              <div class="flex items-start">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                  <h3 class="font-semibold text-lg">Recognized Certificates</h3>
                  <p>Earn certificates that stand out to employers.</p>
                </div>
              </div>
            </div>
          </div>
          
          <div class="mt-8">
            <div class="flex flex-wrap -mx-1">
              <div class="px-1">
                <img src="https://randomuser.me/api/portraits/women/32.jpg" alt="Student" class="h-10 w-10 rounded-full border-2 border-white">
              </div>
              <div class="px-1 -ml-2">
                <img src="https://randomuser.me/api/portraits/men/44.jpg" alt="Student" class="h-10 w-10 rounded-full border-2 border-white">
              </div>
              <div class="px-1 -ml-2">
                <img src="https://randomuser.me/api/portraits/women/68.jpg" alt="Student" class="h-10 w-10 rounded-full border-2 border-white">
              </div>
              <div class="px-1 -ml-2">
                <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Student" class="h-10 w-10 rounded-full border-2 border-white">
              </div>
              <div class="px-1 -ml-2 flex items-center justify-center h-10 w-10 rounded-full border-2 border-white bg-indigo-700 text-xs font-bold">
                +5K
              </div>
            </div>
            <p class="mt-3">Join over 5,000 students already learning on our platform</p>
          </div>
        </div>
      </div>
    </div>
  </main>

  <footer class="bg-white py-6 border-t border-gray-200">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="mb-4 md:mb-0">
          <p class="text-gray-600 text-sm">&copy; 2023 EduSphere. All rights reserved.</p>
        </div>
        <div>
          <ul class="flex space-x-6">
            <li><a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Terms</a></li>
            <li><a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Privacy</a></li>
            <li><a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Help</a></li>
            <li><a href="#" class="text-gray-600 hover:text-indigo-600 text-sm">Contact</a></li>
          </ul>
        </div>
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
    
    // Tab switching functionality
    const loginTab = document.getElementById('login-tab');
    const registerTab = document.getElementById('register-tab');
    const loginForm = document.getElementById('login-form');
    const registerForm = document.getElementById('register-form');

    loginTab.addEventListener('click', () => {
      // Add active styles to the login tab
      loginTab.classList.add('text-indigo-600', 'border-b-2', 'border-indigo-600');
      loginTab.classList.remove('text-gray-500');

      // Remove active styles from the register tab
      registerTab.classList.remove('text-indigo-600', 'border-b-2', 'border-indigo-600');
      registerTab.classList.add('text-gray-500');

      // Show login form and hide register form
      loginForm.classList.remove('hidden');
      registerForm.classList.add('hidden');
    });

    registerTab.addEventListener('click', () => {
      // Add active styles to the register tab
      registerTab.classList.add('text-indigo-600', 'border-b-2', 'border-indigo-600');
      registerTab.classList.remove('text-gray-500');

      // Remove active styles from the login tab
      loginTab.classList.remove('text-indigo-600', 'border-b-2', 'border-indigo-600');
      loginTab.classList.add('text-gray-500');

      // Show register form and hide login form
      registerForm.classList.remove('hidden');
      loginForm.classList.add('hidden');
    });
  </script>
</body>
</html>