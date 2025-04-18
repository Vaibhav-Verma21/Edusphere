# EduSphere Learning Platform - HTML Version

This is a comprehensive HTML implementation of the EduSphere Learning Platform interface. It includes responsive design with dark mode toggle functionality and multiple interactive pages.

## Files Included

- `index.html` - Redirects to the home page
- `home.html` - The landing page with features overview
- `courses.html` - Course catalog page with filtering options
- `course-detail.html` - Detailed view of a specific course with lessons
- `dashboard.html` - Student dashboard with progress tracking
- `profile.html` - User profile with learning statistics
- `forum.html` - Discussion forum for student interaction
- `auth.html` - Authentication page (login/register)
- `server.js` - A simple Node.js server to serve the HTML files

## Running Locally

1. Make sure you have Node.js installed
2. Run `node server.js` or `npm start`
3. Open your browser to `http://localhost:3000`

## Features

- Responsive design (mobile, tablet, desktop)
- Dark mode toggle on all pages
- Interactive course catalog with filtering
- Detailed course view with lessons, resources, and discussions
- Student dashboard with progress tracking and recommended courses
- User profile with skills display and learning statistics
- Discussion forum with categories and topics
- Authentication UI (login/registration)

## Navigation Flow

1. Home Page → Authentication
2. Authentication → Dashboard
3. Dashboard → Courses/Profile/Forum
4. Courses → Course Detail
5. Dashboard → Profile

## Notes

This is a frontend-only implementation. The backend functionality would need to be implemented separately. All data is static and for demonstration purposes only.