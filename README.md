# 🚀 SyncNova - Professional Kanban Task Management System

**SyncNova** is a modern, full-stack task management application built with **Laravel 11**, designed to help users organize their workflow efficiently using an interactive Kanban board. It features a sleek interface with full dark mode support and multi-language capabilities.

---

## 🌐 Live Demo
🔥 **Check out the live application here:** [https://syncnova.onrender.com](https://syncnova.onrender.com)

---

## ✨ Key Features

* **📊 Interactive Kanban Board:** Drag and drop tasks between *Pending*, *In Progress*, and *Completed* columns seamlessly using **SortableJS**.
* **🌍 Multi-Language Support:** Full localization in **Arabic 🇸🇦**, **Turkish 🇹🇷**, and **English 🇺🇸**.
* **🌙 Dark Mode:** A beautiful, eye-friendly dark interface that persists based on user preference.
* **🔍 Real-time Search:** Instantly filter tasks by title or description without reloading the page.
* **📅 Deadlines & Priorities:** Assign due dates and set priorities (Low, Medium, High) with visual indicators.
* **⚡ Real-time Feedback:** Smooth notifications for every action (Add, Edit, Delete, Move).
* **📱 Fully Responsive:** Works perfectly on desktops, tablets, and mobile devices.

---

## 🛠️ Tech Stack

* **Backend:** PHP 8.2+ | Laravel 11
* **Frontend:** Tailwind CSS | Alpine.js | Blade Components
* **Database:** PostgreSQL (Production) | MySQL (Local)
* **Interactions:** SortableJS (Drag & Drop Engine)
* **Deployment:** Dockerized Environment | Hosted on Render

---

## 🚀 Installation & Local Setup

If you want to run this project locally, follow these steps:

1.  **Clone the repository:**
    ```bash
    git clone [https://github.com/mahmoud-ghashim/SyncNova.git](https://github.com/mahmoud-ghashim/SyncNova.git)
    cd SyncNova
    ```

2.  **Install PHP dependencies:**
    ```bash
    composer install
    ```

3.  **Install NPM dependencies & build assets:**
    ```bash
    npm install
    npm run build
    ```

4.  **Setup Environment:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

5.  **Configure Database:**
    Update your `.env` file with your local database credentials, then run:
    ```bash
    php artisan migrate
    ```

6.  **Run the Server:**
    ```bash
    php artisan serve
    ```

---

## 🐳 Docker Deployment (Production)

This project is fully dockerized for easy deployment. Use the provided `Dockerfile` to build your container:

```bash
docker build -t syncnova-app .


👨‍💻 Developed By
Mohamad Ghashim

LinkedIn: www.linkedin.com/in/mohamad-ghashim-aa93003b7

GitHub: @MohamadGhashim2

📝 License
This project is open-source and available under the MIT License.



