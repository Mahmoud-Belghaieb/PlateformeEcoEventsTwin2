# 🐳 Docker + GitHub Actions Guide

## 📋 **What You Have**

✅ **Local Docker Setup**: Your app runs locally on Docker
✅ **GitHub Actions Pipeline**: Automatically builds and pushes Docker images
✅ **Multi-stage Docker**: Optimized production-ready images

## 🔗 **Your Application URLs**

When running locally with `docker-compose up -d`:

- **🌐 Laravel App**: http://localhost:8080
- **🗄️ phpMyAdmin**: http://localhost:8082  
- **📊 Redis**: localhost:6380
- **🛢️ MySQL**: localhost:3308

## 🚀 **How Your Pipeline Works**

### **Every Push to `mahmoud` or `main` branch:**
1. **Tests Run** ✅ PHPUnit, Code Style, SonarQube
2. **Quality Check** ✅ SonarQube analysis

### **Every Push to `main` branch (after tests pass):**
3. **Docker Build** 🐳 Creates production Docker image
4. **Docker Push** 📦 Pushes to Docker Hub registry

## 🔧 **Quick Setup Steps**

### 1. **Set GitHub Secrets** (Required)
Go to: **Repository → Settings → Secrets and variables → Actions**

```
SONAR_TOKEN: [Get from sonarcloud.io]
SONAR_HOST_URL: https://sonarcloud.io  
DOCKER_USERNAME: [Your Docker Hub username]
DOCKER_PASSWORD: [Your Docker Hub access token]
```

### 2. **Test Your Pipeline**
```bash
# Make a small change
echo "# Pipeline test" >> README.md

# Commit and push
git add .
git commit -m "Test Docker pipeline"  
git push origin mahmoud
```

### 3. **Check Results**
- **GitHub Actions**: Repository → Actions tab
- **Docker Hub**: hub.docker.com → Your repositories
- **SonarQube**: sonarcloud.io → Your project

## 🐳 **Docker Commands You Can Use**

### **Local Development**
```powershell
# Start all services
docker-compose up -d

# View logs
docker-compose logs -f app

# Stop services  
docker-compose down

# Rebuild after code changes
docker-compose build
docker-compose up -d
```

### **Production Deployment** 
```powershell
# Pull your latest image from Docker Hub
docker pull yourusername/plateformeecoevents:latest

# Run in production
docker run -d \
  -p 80:80 \
  -e APP_ENV=production \
  -e DB_HOST=your-db-host \
  yourusername/plateformeecoevents:latest
```

## 📦 **Image Tagging Strategy**

Your pipeline creates these Docker tags automatically:

- `latest` - Latest main branch build
- `main-abc123` - Main branch with commit SHA
- `mahmoud-xyz789` - Mahmoud branch with commit SHA

## 🎯 **Next Steps**

1. **Setup Secrets** (15 minutes) - Follow SETUP_GUIDE.md
2. **Push to `main`** - Trigger first Docker build
3. **Deploy Anywhere** - Use your Docker image on any platform

## 🚀 **Deployment Options**

Your Docker image can be deployed to:
- **DigitalOcean** App Platform
- **AWS** ECS/Fargate  
- **Google Cloud** Run
- **Azure** Container Instances
- **Heroku** Container Registry
- **Any VPS** with Docker

## 🛠️ **Troubleshooting**

### Pipeline Fails?
- Check GitHub Actions logs
- Verify all 4 secrets are set
- Ensure SonarCloud project exists

### Docker Build Fails?
- Check Dockerfile syntax
- Verify composer.lock exists
- Check build logs in Actions

### Can't Access App?
```powershell
# Check if containers are running
docker-compose ps

# Check logs
docker-compose logs app

# Restart services
docker-compose restart
```

---

**🎉 Your DevOps pipeline is ready!** Push to `main` and watch the magic happen!