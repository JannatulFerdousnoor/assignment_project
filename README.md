# 🎓 AI-Enhanced Academic Progress & Tracking System (AEAPTS)
### *An Intelligent Framework for Academic Management, Sentiment Analysis, and Performance Forecasting*

---

## 📖 Table of Contents
1. [Project Motivation](#-project-motivation)
2. [AI Core Architecture](#-ai-core-architecture)
3. [Key Features & Modules](#-key-features--modules)
4. [Technical Specifications](#-technical-specifications)
5. [Database Schema Design](#-database-schema-design)
6. [Installation & Local Setup](#-installation--local-setup)
7. [Security & Optimization](#-security--optimization)
8. [Future Research Directions](#-future-research-directions)
9. [Developer Information](#-developer-information)

---

## 🌟 Project Motivation
Traditional academic portals are often limited to static data storage. The **AEAPTS** project aims to revolutionize this by integrating **Artificial Intelligence** to provide proactive insights. By analyzing historical data and qualitative feedback, the system helps instructors identify students who are "at risk" and allows students to understand their progress through the lens of AI-driven analytics.

---

## 🧠 AI Core Architecture
The intelligence of this system is built on three primary pillars:

### 1. NLP-Based Sentiment Analysis Engine
The system parses natural language feedback from instructors using a custom-built scoring algorithm.
- **Logic:** It tokenizes feedback strings to identify positive, neutral, and critical sentiments.
- **Impact:** Converts subjective comments into objective data points for performance tracking.

### 2. Predictive Performance Modeling (Forecasting)
A mathematical model that calculates a **Success Probability Score** (0-100%).
- **Weighted Variables:** It considers total submissions, grade consistency, and recent trends.
- **Visual Feedback:** Uses a dynamic progress bar to show the "Growth Trend" (High, Steady, or Declining).

### 3. Automated Quality Benchmarking
Upon every submission, the system generates a **Quality Confidence Score**.
- **Algorithm:** Simulates a peer-review score based on submission timeliness and historical data.

---

## ✨ Key Features & Modules

### 👨‍🎓 Student & Analytics Dashboard
- **Real-Time Statistics:** Total submissions, pending feedback, and latest grade.
- **AI Smart Insights:** Context-aware recommendations (e.g., "AI Suggests: Focus on technical implementation").
- **Success Probability Tracker:** A circular visualization of projected academic success.

### 📁 Smart Submission Portal
- **Automated Directory Management:** Files are organized by User ID and Timestamp for zero-collision storage.
- **File Integrity Checks:** Prevents corrupted or unauthorized file types from entering the system.

### 🛠 Administrative Control Center
- **Full CRUD Support:** Add, View, Update, and Delete assignments.
- **AI Recalculation:** The system automatically updates AI insights whenever a grade or feedback is modified.

---

## 🛠 Technical Specifications

| Component | Technology | Description |
|:--- |:--- |:--- |
| **User Interface** | HTML5, CSS3, JS | Modern "Elegance" Dark Theme with CSS Variables. |
| **Server-Side** | PHP 8.1+ (Native) | High-performance scripting for AI logic & sessions. |
| **Data Storage** | MySQL 8.0 | Relational database with optimized indexing. |
| **Icons & Fonts** | FontAwesome 6.0 | Professional vector icons for UI/UX clarity. |
| **Logic Implementation** | AI & NLP Patterns | Pattern matching and weighted average algorithms. |

---

## 🗄 Database Schema Design
The project uses an optimized relational structure. Key columns in the `assignments` table include:
- `id`: Primary Key (Auto-increment)
- `user_id`: Foreign Key for student identification.
- `subject_name`: String (Categorical data).
- `file_name`: String (Unique file reference).
- `status`: Enum (Submitted, Opened, Closed).
- `grade`: String (A+, A, B, etc.).
- `ai_score`: Integer (AI-generated quality score).
- `sentiment_result`: String (NLP classification output).

---

## 🚀 Installation & Local Setup

### Step 1: Environment Preparation
Install **XAMPP/WAMP/Laragon** with PHP version **8.0** or above.

### Step 2: Clone the Repository
```bash
git clone [https://github.com/JannatulFerdousnoor/assignment_project.git](https://github.com/JannatulFerdousnoor/assignment_project.git)
