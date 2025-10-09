# 🚀 ICI IT Basic PHP & MySQL Environment for GitHub Codespaces

A simple, focused **PHP 8.1+** and **MySQL 8.0+** development environment designed specifically for **ICI students** using **GitHub Codespaces**. Perfect for learning the fundamentals of PHP and MySQL without unnecessary complexity.

## 👨‍🎓 For ICI Students

### 📧 **Important: Use Your ICI Email Address**
Students should use their **ICI-email supplied email address** to use the privileges in the Codespace.

**Free Usage Limits:**
- **Free Accounts**: 120 hours per month
- **Verified Student/Teacher** (GitHub Student Developer Pack): **180 hours per month**
- Usage resets every month

### 🎓 GitHub Student Developer Pack Setup

**To get FREE extended Codespaces usage:**

1. **Register your ICI email** to GitHub if not done yet
2. **Visit** [https://education.github.com/pack](https://education.github.com/pack) to activate
3. **Allow location tracking** from browser prompt (needed for GitHub verification)
4. **Verification is automatic** - GitHub needs evidence you're an enrolled ICI student
5. **Optional**: Upload your Student ID (front and back as one image)
6. **Optional**: Upload your COR (Certificate of Registration) as verification showing the school logo.
7. **Wait for approval** - expect email "Welcome to GitHub Global Campus"

## ✨ What's Included

### 🛠️ Essential Components
- **PHP 8.1** with essential extensions (MySQLi)
- **MySQL 8.0** with sample database
- **Apache 2.4** web server
- **phpMyAdmin** integrated at `/phpmyadmin` path

### 🎓 Learning-Focused Features
- Simple, clean interface
- Pre-configured sample database with data
- Basic CRUD demo application
- No complex configurations to learn
- Focus on PHP and MySQL fundamentals

## 🚀 Quick Start / Setup

### 1. Create Your Environment
1. **Fork this repository** to your GitHub account (or use "Use this template")
2. **Click "Code" → "Create codespace on main"**
3. **Wait 2-3 minutes** for automatic setup
4. **Start coding!** Everything is ready to use

### 2. Access Your Environment

**🖥️ How to Access Your Application (see screenshot):**

1. **Wait for port forwarding** - VS Code will show port notifications
2. **Look for "Port 80" in the PORTS tab** at the bottom of VS Code
3. **Click the globe icon** 🌐 next to port 80 in the PORTS tab
4. **Or click "Open in Browser"** when the notification appears

**Services Available:**

| Service | How to Access |
|---------|---------------|
| **Your Website** | Click globe icon 🌐 next to Port 80 in PORTS tab |
| **phpMyAdmin** | Go to your website, then add `/phpmyadmin` to the URL |
| **MySQL** | Use `mysql` as hostname in your PHP code (auto-forwarded) |

**📌 Important for Codespaces:**
- **phpMyAdmin**: Access via `https://your-codespace-url.githubpreview.dev/phpmyadmin`
- **No separate ports** - everything works through the main web server (port 80)
- **Simple URL structure** - just add `/phpmyadmin` to your main site URL

## 📋 Database Setup & Credentials

### 🔑 Database Credentials
**Use these credentials to connect to the MySQL database:**

- **Host**: `mysql` (not localhost!)
- **Username**: `root` or `student`
- **Password**: `root` or `student`
- **Database**: `basic_db`

### 💻 PHP MySQL Connection Example
```php
<?php
// Basic PHP MySQL connection
$servername = "mysql";    // Important: use "mysql", not "localhost"
$username = "root";       // or "student"
$password = "root";       // or "student"  
$dbname = "basic_db";

// Create connection using MySQLi
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully!";

// Close connection when done
mysqli_close($conn);
?>
```

### Sample Data
Your environment comes with:
- A `users` table with sample data
- Basic database structure for learning
- Two user accounts: `root/root` and `student/student`

## 📁 File Structure

```
/var/www/html/          ← Your web root (put PHP files here)
├── index.php           ← Welcome page
├── db-test.php         ← Test database connection
├── simple-crud.php     ← Simple CRUD example
└── phpinfo.php         ← PHP configuration info
```

## 💻 Learning Examples

### 1. Basic Database Connection
```php
<?php
$conn = mysqli_connect("mysql", "root", "root", "basic_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected to database!";
mysqli_close($conn);
?>
```

### 2. Simple Query
```php
<?php
$conn = mysqli_connect("mysql", "root", "root", "basic_db");
$result = mysqli_query($conn, "SELECT * FROM users");
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

foreach ($users as $user) {
    echo $user['name'] . " - " . $user['email'] . "<br>";
}
mysqli_close($conn);
?>
```

### 3. Insert Data
```php
<?php
$conn = mysqli_connect("mysql", "root", "root", "basic_db");
$stmt = mysqli_prepare($conn, "INSERT INTO users (name, email) VALUES (?, ?)");
mysqli_stmt_bind_param($stmt, "ss", "John Doe", "john@example.com");
mysqli_stmt_execute($stmt);
echo "User added!";
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
```

## 🎯 What You Can Learn

### PHP Basics
- Variables and data types
- Control structures (if, for, while)
- Functions and arrays
- Form handling
- File inclusion

### Database Fundamentals
- Connecting to MySQL with MySQLi
- SELECT, INSERT, UPDATE, DELETE operations
- Prepared statements for security
- Basic database design

### Web Development
- HTML and PHP integration
- Processing form data
- Session management
- Basic security practices

## 🛠️ Development Workflow

1. **Write PHP code** in `/var/www/html/` (the www folder in your Codespace)
2. **View your work** through port 80 forwarding (see PORTS tab)
3. **Manage database** with phpMyAdmin at `/phpmyadmin`
4. **Test connections** with the built-in test page
5. **Save your work** using Git (see Git workflow below)

## 💾 How to Save Your Work (Git Commit & Push)

### 📝 Using VS Code Source Control Interface

**Step-by-step guide to commit and push your changes:**

1. **🔍 Open Source Control Panel**
   - **Click the Source Control icon** in the left sidebar (looks like a branch)
   - **Or use keyboard shortcut**: `Ctrl+Shift+G` (Windows) or `Cmd+Shift+G` (Mac)

2. **📋 Review Your Changes**
   - **See modified files** under "CHANGES" section
   - **View what you changed** by clicking on file names
   - **Green lines** = added code, **Red lines** = deleted code

3. **💬 Write a Commit Message**
   - **Click in the message box** at the top (says "Message (Ctrl+Enter to commit on 'main')")
   - **Type a clear description** of what you changed
   - **Examples**: 
     - `"Add user registration form"`
     - `"Fix database connection bug"`
     - `"Complete assignment 1 - CRUD operations"`

4. **✅ Commit Your Changes**
   - **Click the "Commit" button** (checkmark icon)
   - **Or press `Ctrl+Enter`** (Windows) or `Cmd+Enter` (Mac)
   - Your changes are now saved locally

5. **🚀 Push to GitHub**
   - **Click "Sync Changes"** button (appears after commit)
   - **Or click the cloud upload icon** next to the branch name
   - Your code is now backed up on GitHub!

### 🎯 Quick Commit Workflow
```
Write Code → Save Files → Source Control → Add Message → Commit → Push
```

### 📌 Important Notes for ICI Students

**✅ **Best Practices for Commit Messages:**
- ✅ **Be descriptive**: "Add login functionality" not "update"
- ✅ **Use present tense**: "Fix bug" not "Fixed bug"  
- ✅ **Keep it short**: Under 50 characters when possible
- ✅ **Include assignment info**: "Assignment 2: User management system"

**⚠️ **When to Commit:**
- ✅ **After completing a feature** (like a working contact form)
- ✅ **Before trying something risky** (backup before experimenting)
- ✅ **At the end of each coding session** (daily backup)
- ✅ **When assignment is complete** (final submission)

**📁 **What Gets Saved:**
- ✅ **All your PHP files** in the www directory
- ✅ **Database structure** (if you export it to a .sql file)
- ✅ **Configuration changes** you made
- ❌ **Database data** (unless exported to .sql file)

## 📝 Usage Guidelines for ICI Students

### 📁 Where to Put Your Work
- **Upload all your PHP files** to the `www` directory (this becomes `/var/www/html/`)
- **This is your web root** - all PHP files go here
- **Test with**: Access your files via the forwarded port 80 URL

### 🖥️ How to Run/Start Servers (if they don't start automatically)

#### Start Apache/PHP Server:
```bash
# Open Terminal in VS Code and run:
sudo service apache2 start
```

#### Start MySQL Server:
```bash
# Usually starts automatically, but if needed:
sudo service mysql start
```

### 🗄️ How to Access phpMyAdmin
1. **Open your main website** (Port 80)
2. **Add `/phpmyadmin`** to the URL
3. **Login with**: Username: `root`, Password: `root`

### ✅ Do's and Don'ts

#### ✅ **DO's**
- ✅ **Upload your work** to the `www` directory
- ✅ **Use phpMyAdmin** for database management  
- ✅ **Collaborate using Live Share** for real-time coding sessions
- ✅ **Follow database export instructions** when needed
- ✅ **Use proper PHP/MySQL coding practices**
- ✅ **Test your code regularly** using the test files provided

#### ❌ **DON'Ts**
- ❌ **Don't modify or delete** configuration files unless you know what you're doing
- ❌ **Don't store sensitive information** in the repository
- ❌ **Don't share your Codespace URL** publicly
- ❌ **Don't delete files** outside the `www` directory
- ❌ **Don't delete the `www` directory** itself
- ❌ **Don't use `localhost`** in your database connections - use `mysql`

## 🎓 For Educators

### Why This Setup?
- **No Installation Hassles**: Works in any web browser
- **Consistent Environment**: Every student has identical setup
- **Focus on Learning**: No time wasted on configuration
- **Immediate Results**: Students can see their code work instantly
- **Easy Sharing**: Just share the repository link

### Classroom Use
- Students fork the repository
- Create their own Codespace
- Start learning immediately
- Share work through GitHub
- No "it works on my machine" problems

## � Export Database (For Submissions)

### Method 1: Using phpMyAdmin (Recommended)
1. **Access phpMyAdmin** at `/phpmyadmin`
2. **Select your database** from the left sidebar
3. **Click "Export" tab** at the top
4. **Choose "Quick" export method**
5. **Download the .sql file**

### Method 2: Using VS Code Task (if available)
1. **Open Command Palette** (Ctrl+Shift+P or Cmd+Shift+P)
2. **Type "Tasks: Run Task"** and select it
3. **Choose "Export Database"** from the list
4. **Check your workspace** for the exported .sql file

## 🚀 Next Steps for Students

After setting up your environment:

1. **📝 Add Your Code**: Start adding your PHP files to the `www` directory
2. **👥 Collaborate**: Use VS Code Live Share to work with teammates in real-time
3. **🧪 Test and Debug**: Use the integrated terminal and debugging tools
4. **🚀 Deploy**: When ready, consider deploying to a production environment
5. **📚 Keep Learning**: Explore advanced PHP frameworks like Laravel or CodeIgniter

## �🔧 Quick Commands

### Check Service Status
```bash
docker-compose ps
```

### View Logs
```bash
docker-compose logs
```

### Restart Services
```bash
docker-compose restart
```

### Access MySQL Command Line
```bash
docker-compose exec mysql mysql -u root -p
```

## 🐛 Troubleshooting

### 🚨 Codespace Not Starting?
- **Check permissions**: Ensure you have necessary permissions to create Codespaces
- **Check resources**: Make sure you haven't exceeded your monthly Codespace hours
- **Try again**: Sometimes GitHub servers are busy - wait and retry

### 🌐 Can't Access Your Website?
- **Wait for port forwarding**: Look for notifications about port 80 being forwarded
- **Check PORTS tab**: Click the PORTS tab at the bottom of VS Code
- **Click the globe icon** 🌐 next to port 80
- **Or use "Open in Browser"** button when prompted

### 🖥️ Services Not Starting Automatically?

#### Start Apache/PHP Server Manually:
```bash
sudo service apache2 start
```

#### Start MySQL Server Manually:
```bash
sudo service mysql start
```

#### Check All Services:
```bash
docker-compose ps
```

### 🗄️ Database Connection Issues?
- **Use `mysql` as host** (NOT `localhost`!)
- **Wait for MySQL to fully start** (can take 1-2 minutes)
- **Check credentials**: `root/root` or `student/student`
- **Verify database name**: `basic_db`

### 🛠️ phpMyAdmin Not Working?
✅ **Now integrated into main web server!** phpMyAdmin is accessible at `/phpmyadmin` path.

**How to Access phpMyAdmin:**
1. **Wait for all services to start** (2-3 minutes)
2. **Open your main website** in the browser (Port 80)
3. **Add `/phpmyadmin`** to the end of your URL
4. **Example**: `https://your-codespace-url.githubpreview.dev/phpmyadmin`
5. **Login**: Username: `root`, Password: `root`

### 📁 File Permission Errors?
```bash
# Fix file permissions if needed
sudo chmod -R 755 /var/www/html
sudo chown -R www-data:www-data /var/www/html
```
4. Or click the "🛠️ phpMyAdmin" button on your homepage

**Example URL:** `https://your-codespace-url.githubpreview.dev/phpmyadmin`

**Login Credentials:**
- Username: `root`
- Password: `root`

**Benefits of this approach:**
- ✅ **No port forwarding issues** - uses the same domain as your website
- ✅ **Simple URL structure** - just add `/phpmyadmin` to your site
- ✅ **Works reliably** in Codespaces without subdomain complications

## � Next Steps

Once you're comfortable with the basics:

1. **Learn PHP Frameworks**: Try Laravel or CodeIgniter
2. **Add Frontend**: Learn JavaScript and CSS
3. **🔒 Security**: Study prepared statements and validation
4. **📊 Advanced MySQL**: Explore joins, indexes, and optimization
5. **📝 Version Control**: Use Git for your projects
6. **🚀 Deploy**: Learn about web hosting and deployment

## 🆘 Getting Help & Support

### For ICI Students:
- **Ask your instructor** for technical assistance
- **Use VS Code Live Share** to collaborate with classmates
- **Check the troubleshooting section** above for common issues
- **Follow ICI IT Department guidelines** for coursework

### Technical Issues:
- **GitHub Codespaces Issues**: Check [GitHub Status](https://www.githubstatus.com/)
- **Environment Problems**: Review the troubleshooting section
- **Database Questions**: Use phpMyAdmin to inspect your database

## 📋 About This Environment

**Designed specifically for ICI students** learning web development with PHP and MySQL. This environment provides:

- ✅ **Pre-configured development setup** - no installation needed
- ✅ **GitHub Codespaces integration** - works in any browser
- ✅ **Educational focus** - simplified for learning
- ✅ **Industry-standard tools** - PHP 8.1, MySQL 8.0, Apache 2.4
- ✅ **Real-world workflow** - same tools used by professional developers

## 📄 License

This project is open source and available under the MIT License.

---

## 🎓 **Ready to start your ICI web development journey?**

**🚀 Fork this repository → Create your Codespace → Start coding!**

*This environment removes all the complexity and lets you focus on what matters: **learning to code!*** 

**Happy coding, ICI students! 💻✨**
