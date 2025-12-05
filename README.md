# LARAVEL PERMISSION ISSUES

This document helps troubleshooting common permission issues. It ensures directory ownership/permissions are *all correct and consistent* with a macOS + XAMPP setup.

## **Does Laravel create new projects with wrong permissions by default?**

Not exactly “wrong” — it’s just that:

- macOS’s **default group for files is your user’s primary group** (usually `admin`)
- XAMPP/Apache runs as **daemon**
- So when Laravel writes cache or logs, your user can write, but Apache/daemon cannot.

This is **normal on macOS**, because the default `composer create-project` command doesn’t know about Apache’s user (`daemon`).

So it’s not a bug — it’s just Unix permissions + XAMPP user mismatch.

### This guide helps you fix ownership so both you and Apache can access all bootstrap files :

- you (owner) → full access
- daemon (group) → full access
- others → read only (unless working in a devs team)

This is the standard pattern used on Linux web servers.

### ✅ After fixing permissions as explained in sections below, try :

```bash
composer install
php artisan optimize
# these 2 commands will run beautifully
```

### **🎯 Is anything left to fix after running the scripts explained in next sections?**

No — your project will be configured correctly.
If you spin up a dev environment with `php artisan serve`, Apache, or XAMPP, everything will behave properly.

---

# Scripts for either a SOLO project or a Devs Team not using Docker

### ✅ **Key takeaway**

The workflow we set up in the sections below (XAMPP + fix script) is fine for **learning and personal projects**, but:

- Professional developers almost never use XAMPP for serious Laravel development.
- They use **containerization (Sail/Docker)** or **native PHP/MySQL** installations.
- That eliminates **permissions headaches** completely.

### ✅ **XAMPP + permissions juggling approach (sections below) – when it makes sense**

**Use case:**

- Students or hobbyists **learning Laravel**.
- Working in a team via **Git (GitFlow, shared repository)**.
- Each developer may have **different OSes, PHP versions, or databases** (XAMPP, native MySQL, Oracle MySQL, etc.).
- Projects are **small to medium**, not production-critical.

**Why it works:**

- Everyone can run Laravel locally on their own setup.
- The “fix permissions” script standardizes file access for **storage/ and bootstrap/cache/**.
- Git ensures code consistency even if local environments differ.
- Team members **don’t need to match exact PHP versions or OS configs** to collaborate.

### ✅ **Why permissions issues happen when cloning a Laravel project**

When a student **clones another student’s GitHub repository**:

- All files are owned by the **user who cloned the repo**.
- On macOS/XAMPP, the Apache user is `daemon`. On Linux it might be `www-data`. On Windows with XAMPP it’s usually the XAMPP Apache user.
- `storage/` and `bootstrap/cache/` **need to be writable** by the web server.
- Since the cloned files are owned by the student’s user, **Apache cannot write** → `Permission denied`.

This is the **classic scenario for the XAMPP + permissions juggling approach**.

---

## **1️⃣ SOLO PROJECT : Script to fix permissions in Laravel on macOS + XAMPP**

Here’s a **safe shell script** you can run anytime you hit permissions errors:

```bash
#!/bin/bash
# fix-laravel-permissions.sh
# Run from the root of your Laravel project

# Change ownership: your user + daemon group
sudo chown -R $USER:daemon .

# Folders: readable, writable, and executable by owner & group
find . -type d -exec chmod 775 {} \;

# Files: readable & writable by owner & group
find . -type f -exec chmod 664 {} \;

echo "✅ Laravel permissions fixed for macOS + XAMPP!"
```

### How to use it:

1. Save as `fix-laravel-permissions.sh` in your project root.
2. Make it executable :
    
    ```bash
    chmod +x fix-laravel-permissions.sh
    ```
    
3. Run it anytime :
    
    ```bash
    ./fix-laravel-permissions.sh
    ```
    

It fixes:

- `storage/`
- `bootstrap/cache/`
- `bootstrap/app.php` and all other files
- Everything else in your project for safe Laravel + XAMPP usage

When creating a new project (e.g `<project-name>`) we can run 3 commands in the same line to set everything right :

```bash
laravel new project-name && cd project-name && ./fix-laravel-permissions.sh
```

---

## **2️⃣ DEVs Group on same computer or cloning your repo : Multi-user setup**

If multiple users work on the same Mac or are going to clone your repo to work on the same Laravel project we can use a script that serve both, solo projects and multi-user setups :

- **Solo use:** It just sets your user as owner and `daemon` as the group for Laravel’s writable directories, fixing XAMPP permissions.
- **Multi-user use:** If you configure a shared group (like `laraveldev`) and include all users + Apache in that group, the same script fixes permissions so **everyone can read/write safely**.

We need a script that :

1. Detect the **project root**
2. Correct **ownership** (user + group)
3. Fix **permissions**: 775 for directories, 664 for files
4. Optionally, apply `setgid` on directories so new files inherit the group (important for team projects)

This way, the same script works seamlessly whether it’s **only you** or **multiple developers**.

### This is a safe script to use including `setgid` for team-friendly directories :

```bash
#!/bin/bash
# fix-laravel-permissions.sh
# Fixes Laravel permissions for macOS + XAMPP (solo or multi-user)

# ===============================
# CONFIGURATION
# ===============================
# Change these if using a team group
PROJECT_GROUP="daemon"    # Default for XAMPP solo setup
# For team projects, create a group like 'laraveldev' and include all users + daemon
# PROJECT_GROUP="laraveldev"

# ===============================
# SCRIPT
# ===============================
echo "🔧 Fixing Laravel permissions..."

# Ensure the script is run from project root
if [ ! -f "artisan" ]; then
    echo "❌ artisan not found! Run this script from the root of your Laravel project."
    exit 1
fi

# Fix ownership: your user + configured group
sudo chown -R $USER:$PROJECT_GROUP .

# Fix directories: read/write/execute for owner & group, others read/execute
# Also set setgid so new files inherit the group
find . -type d -exec sudo chmod 2775 {} \;

# Fix files: read/write for owner & group, read-only for others
find . -type f -exec sudo chmod 664 {} \;

echo "✅ Laravel permissions fixed!"
echo "ℹ️ Directories: 775 + setgid, Files: 664"
echo "📁 Owner: $USER, Group: $PROJECT_GROUP"
```

**The script above is a a robust, one-script solution for macOS + Laravel + XAMPP that works for solo projects or multi-user setups.**

### **How it works**

1. **Ownership**: Sets your user as owner and `daemon` (or your team group) as group.
2. **Directories**: `2775` = rwxrwxr-x + **setgid**, so new files inherit the group.
3. **Files**: `664` = rw-rw-r--, safe for both Apache (`daemon`) and users.
4. **Solo use**: Default group `daemon` works for XAMPP.
5. **Team use**: Just change `PROJECT_GROUP` to your shared group (e.g., `laraveldev`).

## ✅ Usage

1. Save the script as `fix-laravel-permissions.sh` in the root of your Laravel project.
2. Make it executable :
    
    ```bash
    chmod +x fix-laravel-permissions.sh
    ```
    
3. Run it from the project root :
    
    ```bash
    ./fix-laravel-permissions.sh
    ```
    
4. Done — now **Composer, Artisan, and Apache** all have proper access.

## ✅ **Benefits**

- Fixes storage, bootstrap/cache, bootstrap/app.php, and everything else.
- Prevents future permission issues with XAMPP or multiple users.
- Safe: no world-writable 777 directories.
- Easy to reuse across projects.

# Workflow

When creating a new project (e.g `<project-name>`) we can run 3 commands in the same line to set everything right :

```bash
laravel new project-name && cd project-name && ./fix-laravel-permissions.sh
```

### How it works:

1. `laravel new myproject` → creates the new Laravel project.
2. `cd myproject` → moves into the project folder.
3. `./fix-laravel-permissions.sh` → fixes **all ownership and permissions**, so Composer, Artisan, and Apache can run without issues.

### Tips:

- Make sure `fix-laravel-permissions.sh` is **copied** into a location you can reference, e.g., your home folder:

```bash
cp ~/scripts/fix-laravel-permissions.sh .
```

Then you can run the one-liner right after creating a project.

- After this, you’ll never need `sudo` for Composer installs or Artisan commands inside that project.
- If you’re doing multiple new projects, you can create a small folder `~/laravel-scripts/` with `fix-laravel-permissions.sh` and just copy it into the new project each time.