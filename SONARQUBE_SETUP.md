# 🔍 SonarQube Integration Guide

This guide explains how to set up SonarQube code quality analysis for the EcoEvents platform.

## 📋 Overview

SonarQube provides comprehensive code quality analysis including:
- **Code smells** detection
- **Security vulnerabilities** scanning
- **Code coverage** analysis
- **Duplicated code** identification
- **Maintainability** metrics
- **Reliability** assessment

## 🚀 Quick Setup

### 1. SonarCloud Setup (Recommended)

1. **Create SonarCloud Account**
   - Go to [SonarCloud](https://sonarcloud.io)
   - Sign up with your GitHub account
   - Import your repository

2. **Get Your Token**
   - Go to **My Account** → **Security**
   - Generate a new token
   - Copy the token for later use

### 2. GitHub Repository Configuration

1. **Add GitHub Secrets**
   - Go to your repository → **Settings** → **Secrets and variables** → **Actions**
   - Add these secrets:

   ```
   SONAR_TOKEN: your_sonarcloud_token_here
   SONAR_HOST_URL: https://sonarcloud.io
   ```

2. **Update sonar-project.properties**
   ```properties
   sonar.projectKey=your-organization_your-project
   sonar.organization=your-organization
   ```

### 3. Local SonarQube Server (Alternative)

If you prefer to run SonarQube locally:

```bash
# Using Docker
docker run -d --name sonarqube -p 9000:9000 sonarqube:community

# Access SonarQube at http://localhost:9000
# Default credentials: admin/admin
```

## 📊 Quality Metrics

### Current Project Configuration

Our SonarQube analysis covers:

- **PHP Files**: `app/`, `database/`, `routes/`, `config/`
- **Test Files**: `tests/`
- **Coverage Reports**: `coverage.xml`
- **Exclusions**: `vendor/`, `storage/`, `node_modules/`

### Quality Gate Conditions

| Metric | Condition | Target |
|--------|-----------|--------|
| Coverage | > 80% | New Code |
| Duplicated Lines | < 3% | Overall Code |
| Maintainability Rating | A | New Code |
| Reliability Rating | A | New Code |
| Security Rating | A | New Code |

## 🔧 Configuration Files

### sonar-project.properties

```properties
# Project identification
sonar.projectKey=plateformeecoevents
sonar.projectName=PlateformeEcoEventsTwin2
sonar.projectVersion=1.0

# Source configuration
sonar.sources=app,database,routes,config
sonar.tests=tests
sonar.sourceEncoding=UTF-8

# PHP specific
sonar.php.coverage.reportPaths=coverage.xml
sonar.php.file.suffixes=php

# Exclusions
sonar.exclusions=vendor/**,storage/**,bootstrap/cache/**
sonar.coverage.exclusions=tests/**,database/**,config/**
```

### GitHub Actions Workflow

The CI pipeline includes SonarQube analysis:

```yaml
- name: Run tests with coverage
  run: php artisan test --coverage --coverage-clover=coverage.xml

- name: SonarQube Scan
  uses: sonarsource/sonarqube-scan-action@master
  env:
    GITHUB_TOKEN: ${{ secrets.GITHUB_TOKEN }}
    SONAR_TOKEN: ${{ secrets.SONAR_TOKEN }}
    SONAR_HOST_URL: ${{ secrets.SONAR_HOST_URL }}
```

## 📈 Monitoring & Reports

### Accessing Reports

1. **SonarCloud Dashboard**
   - Go to [SonarCloud](https://sonarcloud.io)
   - Navigate to your project
   - View detailed metrics and issues

2. **GitHub Integration**
   - Pull request checks
   - Automatic quality gate validation
   - Code annotations on problematic lines

### Key Metrics to Monitor

- **Coverage Percentage**: Aim for >80%
- **Technical Debt**: Keep under 30 minutes per 1k lines
- **Duplications**: Maintain <5%
- **Security Hotspots**: Review and resolve all

## 🛠 Troubleshooting

### Common Issues

1. **Token Authentication Errors**
   ```
   Solution: Verify SONAR_TOKEN is correctly set in GitHub secrets
   ```

2. **Coverage Report Not Found**
   ```
   Solution: Ensure coverage.xml is generated before SonarQube scan
   ```

3. **Project Key Conflicts**
   ```
   Solution: Use unique project key format: organization_repository
   ```

### Local Testing

Run SonarQube analysis locally:

```bash
# Generate coverage report
php artisan test --coverage --coverage-clover=coverage.xml

# Run local SonarScanner (if installed)
sonar-scanner \
  -Dsonar.projectKey=plateformeecoevents \
  -Dsonar.sources=. \
  -Dsonar.host.url=http://localhost:9000 \
  -Dsonar.login=your-token
```

## 📝 Best Practices

1. **Regular Monitoring**
   - Check SonarQube reports after each merge
   - Address issues incrementally
   - Set up notification alerts

2. **Quality Gates**
   - Don't merge failing quality gates
   - Maintain high coverage on new code
   - Fix security vulnerabilities immediately

3. **Team Adoption**
   - Include SonarQube reviews in code review process
   - Set team quality standards
   - Regular quality retrospectives

## 🎯 Benefits

- **Early Bug Detection**: Catch issues before production
- **Security**: Identify potential vulnerabilities
- **Maintainability**: Keep code clean and readable
- **Technical Debt Management**: Track and reduce complexity
- **Team Standards**: Enforce consistent code quality

---

**💡 Pro Tip**: Set up SonarQube browser notifications to get real-time alerts on quality gate status!