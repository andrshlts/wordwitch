<p align="center">
    <img src="./media/logo-light.webp#gh-light-mode-only" alt="WordWitch logo" width="400">
    <img src="./media/logo-dark.webp#gh-dark-mode-only" alt="WordWitch logo" width="400">
</p>

# 🪄 WordWitch - Your Anagram Magician

**WordWitch** is a fast, powerful anagram finder application based on a lightweight, API-only **Laravel backend**, a fully separate, modern **React Router based frontend**, and a simple **MySQL** database. The project is designed for fast, flexible development and can be run fully containerized using **Docker**.

WordWitch includes:

- 🔤 **Multilingual support** both backend and frontend
- 🌗 **Light & dark mode** on the frontend
- 🧪 **Extensive unit and feature tests** for a reliable codebase
- 🐳 **Full Docker-based environment** for easy development and deployment
- 🔌 **Simple, clean API with two endpoints**:
  - **Fetch Wordbase** - imports a wordbase from a remote source into the database
  - **Find Anagrams** - returns all valid anagrams for a given word, with pagination support
- ⚡ **Multiple powerful anagram algorithms** with smart normalization and Unicode-safe processing  

WordWitch is designed to be lightweight, fast, and easy to extend - perfect for language tools, word games, education apps, and more.

---

## 📦 Tech Stack

```text
Backend:    Laravel 12 (stripped), MySQL 8, PHP 8.4, 
Frontend:   React 19.1.1, React Router 7.9.2, Vite, TailwindCSS
Testing:    PHPUnit, Laravel Test Framework
DevOps:     Docker, Docker Compose
Apidoc:     de:doc Scramble
```

---

## ⚙️ Installation

Clone the repository:

```bash
git clone https://github.com/andrshlts/wordwitch.git
cd wordwitch
```

---

## 🐳 Running with Docker (Recommended)

### ✅ Prerequisites

- Docker Desktop
- `.env` files in root and `./backend`
- `./backend` also requires `.env.testing`

---

### 📄 .env File Example

You may use the provided example files in `./.env.example`, `./backend/.env.example` and `./backend/.env.testing.example`.

---

### 🔧 Run the Project

From the project root, start the environment:

```bash
docker-compose up -d
```

Once ready:

- Visit [http://localhost:5173/](http://localhost:5173/) to access the frontend application.
- Visit [http://localhost:8084/docs/api](http://localhost:8084/docs/api) to see auto-generated apidoc.
- Use [http://localhost:8084/api/v1/refreshWordbase](http://localhost:8084/api/v1/refreshWordbase) to update the application's wordbase.
- Use [http://localhost:8084/api/v1/getAnagrams?word=word](http://localhost:8084/api/v1/getAnagrams?word=word) to fetch an array of anagrams for a given word.

---

## 🎨 Development

The source code lives in:

```
frontend/
backend/
```

Changes reflect live after a browser refresh (no rebuild required).<br>
Hot reloading is also enabled but may be unreliable due to the current Docker setup and the use of polling.

---

## 🧹 Useful Commands

| Command                                            | Description                                |
|----------------------------------------------------|--------------------------------------------|
| `docker compose up -d`                             | Start services in background               |
| `docker compose down`                              | Stop and remove all containers             |
| `docker compose logs -f`                           | View real-time logs                        |
| `docker compose exec backend php artisan test`     | Run API tests                              |

---

### 🧠 Notes

- A separate test database is initialized on first run via `./docker/mysql/init/create_test_db.sql`

---

### 📝 Todo List

Due to a severe lack of spare time, there are some minor hacks and missing pieces. Here's a list of everything I could find.

- **Use SSR for language and theme handling to prevent FOUC and hydration warning in dev**
- Implement properly typed error handling on the frontend
- Implement proper error pages on the frontend
- Implement anagram pagination on the frontend
- Optimize SEO, add missing pieces
- Optimize Docker setup, fix bad hot-reload etc.
- Set CORS headers
- Add throttling to API
- Quality control - as I was in a bit of a rush, there may be some parts that can be designed in better, more efficient ways - I'd be happy to talk about those in person