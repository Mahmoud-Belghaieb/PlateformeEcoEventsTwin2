# 🔧 Complete Setup Guide: SonarQube + Docker + CI/CD

This guide provides step-by-step instructions for setting up SonarQube, Docker, and the complete CI/CD pipeline.

## 🎯 Quick Overview

You'll set up:
1. **SonarQube Cloud** - Code quality analysis
2. **Docker Hub** - Container registry
3. **GitHub Secrets** - Secure credentials
4. **Docker Desktop** - Local development environment

---

## 🔍 Part 1: SonarQube Setup

### Step 1: Create SonarCloud Account

1. **Go to SonarCloud**: Visit [sonarcloud.io](https://sonarcloud.io)

2. **Sign Up/Login**: 
   - Click **"Log in"**
   - Choose **"With GitHub"**
   - Authorize SonarCloud to access your GitHub account

3. **Import Your Repository**:
   - Once logged in, click **"+"** (plus icon) in top-right
   - Select **"Analyze new project"**
   - Choose your repository: `PlateformeEcoEventsTwin2`
   - Click **"Set up"**

### Step 2: Configure Your Project

1. **Project Setup**:
   - **Project Key**: `balsemkhouniblossom_PlateformeEcoEventsTwin2`
   - **Organization**: `balsemkhouniblossom` (or your GitHub username)
   - Click **"Set up"**

2. **Analysis Method**:
   - Choose **"With GitHub Actions"**
   - SonarCloud will show you the configuration (we already have this!)

### Step 3: Get Your SonarQube Token

1. **Go to Security Settings**:
   - Click your profile picture (top-right)
   - Select **"My Account"**
   - Go to **"Security"** tab

2. **Generate Token**:
   - In **"Generate Tokens"** section
   - **Token Name**: `PlateformeEcoEventsTwin2-CI`
   - **Type**: Select **"Global Analysis Token"**
   - **Expires**: Choose **"90 days"** or **"No expiration"**
   - Click **"Generate"**

3. **Copy Token**:
   ```
   ⚠️ IMPORTANT: Copy this token immediately!
   It looks like: squ_1234567890abcdef1234567890abcdef12345678
   You won't be able to see it again!
   ```

### Step 4: Update Project Configuration

1. **Edit sonar-project.properties** in your project:
   ```properties
   sonar.projectKey=balsemkhouniblossom_PlateformeEcoEventsTwin2
   sonar.organization=balsemkhouniblossom
   ```

---

## 🐳 Part 2: Docker Hub Setup

### Step 1: Create Docker Hub Account

1. **Go to Docker Hub**: Visit [hub.docker.com](https://hub.docker.com)

2. **Sign Up**:
   - Click **"Sign Up"**
   - Choose a username (e.g., `your-username`)
   - Use your email and create a password
   - Verify your email

### Step 2: Create Access Token

1. **Go to Account Settings**:
   - Click your profile picture
   - Select **"Account Settings"**
   - Go to **"Security"** tab

2. **Create Access Token**:
   - Click **"New Access Token"**
   - **Token description**: `PlateformeEcoEventsTwin2-CI`
   - **Access permissions**: **Read, Write**
   - Click **"Generate"**

3. **Copy Token**:
   ```
   ⚠️ IMPORTANT: Copy this token immediately!
   It looks like: dckr_pat_1234567890abcdef1234567890abcdef
   ```

### Step 3: Create Repository

1. **Create Docker Repository**:
   - Click **"Create Repository"**
   - **Repository name**: `plateformeecoevents`
   - **Visibility**: **Public** (or Private if you prefer)
   - **Description**: `EcoEvents Platform - Laravel Application`
   - Click **"Create"**

---

## ⚙️ Part 3: GitHub Secrets Configuration

### Step 1: Access Repository Settings

1. **Go to your GitHub repository**: `PlateformeEcoEventsTwin2`
2. **Click "Settings"** tab (top menu)
3. **Go to "Secrets and variables"** → **"Actions"** (left sidebar)

### Step 2: Add Required Secrets

Click **"New repository secret"** for each of these:

#### SonarQube Secrets
```
Name: SONAR_TOKEN
Value: [Paste your SonarCloud token from Part 1, Step 3]

Name: SONAR_HOST_URL
Value: https://sonarcloud.io
```

#### Docker Secrets
```
Name: DOCKER_USERNAME
Value: [Your Docker Hub username]

Name: DOCKER_PASSWORD
Value: [Your Docker Hub access token from Part 2, Step 2]
```

### Step 3: Verify Secrets

Your secrets should look like this:
- ✅ `SONAR_TOKEN` - squ_1234...
- ✅ `SONAR_HOST_URL` - https://sonarcloud.io
- ✅ `DOCKER_USERNAME` - your-dockerhub-username
- ✅ `DOCKER_PASSWORD` - dckr_pat_1234...

---

## 🖥️ Part 4: Docker Desktop Setup

### Step 1: Install Docker Desktop

1. **Download Docker Desktop**:
   - Go to [docker.com/products/docker-desktop](https://www.docker.com/products/docker-desktop/)
   - Download for Windows
   - Run the installer
   - Restart your computer when prompted

2. **Start Docker Desktop**:
   - Open Docker Desktop from Start menu
   - Sign in with your Docker Hub account
   - Wait for Docker to start (green light in bottom-left)

### Step 2: Test Local Docker Setup

1. **Open PowerShell** in your project directory

2. **Build the application**:
   ```powershell
   docker-compose build
   ```

3. **Start the containers**:
   ```powershell
   docker-compose up -d
   ```

4. **Check running containers**:
   ```powershell
   docker-compose ps
   ```

5. **Access your application**:
   - **Laravel App**: http://localhost:8080
   - **phpMyAdmin**: http://localhost:8081
   - **MySQL**: localhost:3307

### Step 3: Useful Docker Commands

```powershell
# View logs
docker-compose logs app

# Stop containers
docker-compose down

# Rebuild and restart
docker-compose down
docker-compose build --no-cache
docker-compose up -d

# Access container shell
docker-compose exec app sh

# Run Laravel commands in container
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear
```

---

## 🚀 Part 5: Testing Your Setup

### Step 1: Trigger CI Pipeline

1. **Make a small change** to your code
2. **Commit and push**:
   ```powershell
   git add .
   git commit -m "Test CI/CD pipeline"
   git push origin mahmoud
   ```

### Step 2: Monitor Pipeline

1. **GitHub Actions**:
   - Go to your repository → **"Actions"** tab
   - Watch the workflow run
   - Check both "test" and "docker-build" jobs

2. **SonarCloud**:
   - Go to [sonarcloud.io](https://sonarcloud.io)
   - Check your project dashboard
   - View code quality metrics

3. **Docker Hub**:
   - Go to [hub.docker.com](https://hub.docker.com)
   - Check your `plateformeecoevents` repository
   - Verify new image was pushed

### Step 3: Local Testing

```powershell
# Pull and run your published image
docker pull your-username/plateformeecoevents:latest
docker run -p 8080:80 your-username/plateformeecoevents:latest
```

---

## 🔍 Part 6: Understanding Your Quality Dashboard

### SonarCloud Metrics

1. **Quality Gate**: Pass/Fail status
2. **Coverage**: Test coverage percentage
3. **Duplications**: Code duplication detection  
4. **Maintainability**: Code smells and technical debt
5. **Reliability**: Bug detection
6. **Security**: Vulnerability scanning

### Key Thresholds

- **Coverage**: Aim for >80%
- **Duplications**: Keep <3%
- **Maintainability Rating**: Target A
- **Security Rating**: Target A

---

## 🛠️ Troubleshooting

### Common Issues

1. **SonarQube Token Invalid**:
   ```
   Solution: Regenerate token in SonarCloud → My Account → Security
   ```

2. **Docker Build Fails**:
   ```
   Solution: Check Dockerfile syntax, verify base images
   ```

3. **GitHub Actions Fails**:
   ```
   Solution: Check secrets are correctly set, verify workflow syntax
   ```

4. **Docker Desktop Won't Start**:
   ```
   Solution: Enable Windows features (Hyper-V, WSL2), restart Windows
   ```

### Getting Help

- **SonarCloud**: [docs.sonarcloud.io](https://docs.sonarcloud.io)
- **Docker**: [docs.docker.com](https://docs.docker.com)
- **GitHub Actions**: [docs.github.com/actions](https://docs.github.com/actions)

---

## 🎉 Success! Your DevOps Pipeline is Ready!

Once everything is set up, you'll have:
- ✅ Automated code quality analysis
- ✅ Docker containerization
- ✅ Automated builds and deployments
- ✅ Comprehensive monitoring

**Next**: Push your changes and watch the magic happen! 🚀