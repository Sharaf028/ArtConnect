<p align="center">
  <a href="#" target="_blank">
    <img src="https://i.ibb.co/k8K4QGR/artconnect-logo.png" width="400" alt="ArtConnect Logo">
  </a>
</p>

<p align="center">
  <a href="#"><img src="https://img.shields.io/badge/status-WIP-yellow" alt="Project Status"></a>
  <a href="#"><img src="https://img.shields.io/badge/Laravel-11.x-red" alt="Laravel Version"></a>
  <a href="#"><img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="License"></a>
  <a href="#"><img src="https://img.shields.io/badge/course-CSE470-blueviolet" alt="Course Badge"></a>
</p>

---

# 🎨 ArtConnect - Community Platform for Artists

> **📚 Course Project 470** | **🚧 Work in Progress**

A beautiful and modern Laravel-based platform where artists can showcase their work and clients can discover and contact them. Designed to empower creativity and build real-world connections.

---

## 🛠️ Technology Stack

- **Backend**: Laravel 11.x
- **Frontend**: Bootstrap 5.3, Blade Templates
- **Icons**: Font Awesome 6.0.0
- **Database**: MySQL/PostgreSQL
- **Authentication**: Laravel Breeze
- **File Storage**: Laravel Storage Facade

---

## 📋 Prerequisites

Make sure your environment has:

- PHP 8.1+
- Composer
- Node.js & NPM
- MySQL or PostgreSQL
- Apache/Nginx or Laravel’s built-in server

---

## 🚀 Installation

```bash
# 1. Clone the repository
git clone <repository-url>
cd artConnect-new

# 2. Install PHP & JS dependencies
composer install
npm install

# 3. Environment Setup
cp .env.example .env
php artisan key:generate

# 4. Configure .env with your DB credentials
# DB_DATABASE=artconnect
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# 5. Run migrations
php artisan migrate

# 6. Create symbolic storage link
php artisan storage:link

# 7. Compile assets
npm run dev

# 8. Start the development server
php artisan serve
```

Visit: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 🎨 UI/UX & Theme

- Responsive layout with Bootstrap 5
- Smooth transitions & animations
- Font Awesome icons integrated
- Clean and accessible design

---

## 🔐 Security Features

- CSRF Protection
- Input validation & sanitization
- File upload protection
- Role-based access control
- Strong password validation

---

## 👥 User Experience

### For Artists:
- Register as an "Artist"
- Upload artworks with images and tags
- Showcase profile and gallery

### For Clients:
- Register as a "Client"
- Browse and filter artwork
- View artist profiles
- Contact artists for commission work

---

## 📈 Project Roadmap

### ✅ Completed
- Core Authentication System
- Role-based Access
- Artwork Upload
- Public Gallery
- Responsive UI

### 🔄 Coming Soon
- Artist-Client Messaging
- Admin Panel
- Review & Rating System
- Search & Filter Optimization

---

## 🤝 Contributing

Feel free to fork, open issues or submit pull requests! This is a student project, but all clean code and ideas are welc
