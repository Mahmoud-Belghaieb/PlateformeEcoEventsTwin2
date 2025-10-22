# 🚀 Quick Setup Checklist

## ✅ Before You Start
- [ ] Have GitHub account ready
- [ ] Install Docker Desktop
- [ ] Open PowerShell in project directory

## 📋 Setup Steps

### 1. SonarCloud (5 minutes)
1. [ ] Go to [sonarcloud.io](https://sonarcloud.io) → Login with GitHub
2. [ ] Import your repository
3. [ ] Go to Profile → My Account → Security → Generate Token
4. [ ] Copy token (starts with `squ_`) ⚠️ **Save immediately!**

### 2. Docker Hub (3 minutes)
1. [ ] Go to [hub.docker.com](https://hub.docker.com) → Sign up
2. [ ] Profile → Account Settings → Security → New Access Token
3. [ ] Copy token (starts with `dckr_pat_`) ⚠️ **Save immediately!**
4. [ ] Create repository: `plateformeecoevents`

### 3. GitHub Secrets (2 minutes)
**Repository → Settings → Secrets and variables → Actions**

Add these 4 secrets:
```
SONAR_TOKEN: [your SonarCloud token]
SONAR_HOST_URL: https://sonarcloud.io
DOCKER_USERNAME: [your Docker Hub username]  
DOCKER_PASSWORD: [your Docker Hub token]
```

### 4. Test Everything (5 minutes)
```powershell
# Test Docker locally
docker-compose up -d

# Test CI/CD pipeline  
git add .
git commit -m "Test CI/CD setup"
git push origin mahmoud
```

## 🔗 Quick Links
- **Your CI/CD**: GitHub → Actions tab
- **Code Quality**: [sonarcloud.io](https://sonarcloud.io)
- **Docker Images**: [hub.docker.com](https://hub.docker.com)
- **Local App**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081

## 🆘 Need Help?
Check `SETUP_GUIDE.md` for detailed instructions!

---
**Total setup time: ~15 minutes** ⏱️