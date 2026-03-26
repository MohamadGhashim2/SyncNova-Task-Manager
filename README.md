# SyncNova - Smart Task Management System 🚀

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Alpine.js](https://img.shields.io/badge/Alpine.js-2D3441?style=for-the-badge&logo=alpine.js&logoColor=white)

**SyncNova** is a modern, Kanban-based task management application designed for speed, efficiency, and a seamless user experience. Built with Laravel, it features a highly interactive UI without the need for a heavy frontend framework.

**SyncNova (سينك نوفا)** هو نظام حديث لإدارة المهام يعتمد على لوحات "كانبان"، مصمم ليوفر سرعة وكفاءة وتجربة مستخدم سلسة. تم بناؤه باستخدام لارافيل، ويتميز بواجهة تفاعلية ذكية.

---

## ✨ Features | الميزات الأساسية

- 📋 **Interactive Kanban Board:** Drag and drop tasks smoothly between columns (Pending, In Progress, Completed).
- 🌙 **Smart Dark Mode:** Fully integrated dark/light theme that respects user OS preferences and saves locally.
- 🔍 **Live Search:** Filter tasks instantly by title or description without page reloads.
- 🏷️ **Task Priorities:** Categorize tasks by priority (High 🔴, Medium 🟡, Low 🔵).
- ⏰ **Due Dates & Deadlines:** Set deadlines for tasks with smart indicators for overdue and remaining days.
- 🔔 **Toast Notifications:** Elegant, non-intrusive floating alerts for user actions using Alpine.js.
- ⚡ **No Page Reloads:** Fast state updates using Fetch API and Alpine.js for a SPA-like feel.

---

## 🛠️ Tech Stack | التقنيات المستخدمة

- **Backend:** Laravel (PHP)
- **Frontend:** Blade, Tailwind CSS, Alpine.js
- **Database:** MySQL / SQLite
- **Libraries:** Sortable.js (for Drag & Drop)

---

## 🚀 Installation & Setup | طريقة التشغيل

Follow these steps to run the project locally on your machine:

1. **Clone the repository:**
   ```bash
   git clone [https://github.com/YourUsername/SyncNova.git](https://github.com/YourUsername/SyncNova.git)
   cd SyncNova

2. Install PHP dependencies:
    ```bash
    composer install

3. Install NPM dependencies and compile assets:
    ```bash
    npm install
    npm run build

4. Set up environment variables:
    ```bash
    cp .env.example .env
    php artisan key:generate

5. Configure your database in .env and run migrations:

    ```bash
    php artisan migrate

6. Start the local development server:

    ```bash
    php artisan serve


Visit http://localhost:8000 in your browser and start managing your tasks! 🎉


👨‍💻 Developer | المطور
Developed with ❤️ by mohamad Ghashim


### لمسة أخيرة قبل الحفظ:
في السطر الخاص بـ `git clone` داخل الكود أعلاه، لا تنسَ تبديل `YourUsername` باسم حسابك الحقيقي على GitHub لكي يعمل الرابط بشكل صحيح.

