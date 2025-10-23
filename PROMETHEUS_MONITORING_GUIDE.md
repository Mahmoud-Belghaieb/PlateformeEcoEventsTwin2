# 🔍 Prometheus Monitoring Setup for PlateformeEcoEvents

## 📊 **What We're Monitoring**

### **1. Application Metrics**
- HTTP request duration and status codes
- Memory usage and performance
- Cache hit/miss ratios
- Laravel-specific metrics

### **2. Business Metrics**
- Total registered users
- Number of events (total and active)
- Event registrations
- Daily/monthly growth metrics

### **3. Infrastructure Metrics**
- CPU and memory usage (Node Exporter)
- MySQL database performance and connections
- Redis cache performance
- Docker container metrics

### **4. CI/CD Pipeline Metrics**
- Build duration and success rates
- Test execution metrics
- Deployment frequency

## 🚀 **Getting Started**

### **1. Start the Monitoring Stack**
```bash
# Start all services including Prometheus and Grafana
docker-compose up -d

# Check if all services are running
docker-compose ps
```

### **2. Access Monitoring Dashboards**
- **Prometheus**: http://localhost:9090
- **Grafana**: http://localhost:3000 (admin/admin123)
- **Application Metrics**: http://localhost:8080/metrics

### **3. Install Laravel Dependencies**
```bash
# Install Prometheus PHP client
composer install

# Clear caches
php artisan config:clear
php artisan route:clear
```

## 📈 **Grafana Dashboards**

### **Default Login**
- Username: `admin`
- Password: `admin123`

### **Pre-configured Datasources**
- Prometheus is automatically configured at startup

### **Recommended Dashboard Imports**
1. **Laravel Application Dashboard** (Custom)
2. **MySQL Overview**: Import dashboard ID `7362`
3. **Node Exporter Full**: Import dashboard ID `1860`
4. **Redis Dashboard**: Import dashboard ID `763`

## 🔧 **Customization**

### **Adding Custom Metrics**
Edit `app/Http/Controllers/MetricsController.php`:

```php
// Add your custom business metric
$customMetric = $this->registry->getOrRegisterGauge(
    'ecoevents',
    'custom_metric_name',
    'Description of your metric'
);
$customMetric->set($yourValue);
```

### **Adding Alert Rules**
Edit `docker/prometheus/rules/alerts.yml`:

```yaml
- alert: YourCustomAlert
  expr: your_metric > threshold
  for: 5m
  labels:
    severity: warning
  annotations:
    summary: "Your alert description"
```

## 📊 **Key Metrics to Watch**

### **Application Health**
- `http_request_duration_seconds` - Response times
- `laravel_memory_usage_bytes` - Memory consumption  
- `laravel_cache_hit_ratio` - Cache efficiency

### **Business KPIs**
- `ecoevents_total_users` - User growth
- `ecoevents_active_events` - Active events count
- `ecoevents_total_registrations` - Registration volume

### **Infrastructure**
- `node_cpu_seconds_total` - CPU usage
- `node_memory_MemAvailable_bytes` - Available memory
- `mysql_global_status_connections` - DB connections

## 🚨 **Alerting**

### **Critical Alerts**
- Database down (`mysql_up == 0`)
- High error rate (`5xx responses > 10%`)
- Memory usage (`> 85%`)
- CPU usage (`> 80%`)

### **Warning Alerts**
- Slow responses (`> 2 seconds`)
- Cache hit ratio low (`< 70%`)
- Disk space low (`< 20%`)

## 🔄 **CI/CD Integration**

The pipeline automatically:
1. Collects build metrics
2. Reports test results
3. Tracks deployment frequency
4. Monitors build duration

## 📱 **Production Considerations**

### **Security**
- Metrics endpoint (`/metrics`) should be restricted in production
- Use proper authentication for Grafana
- Secure Prometheus with TLS

### **Performance**
- Metrics collection adds minimal overhead (`< 1ms per request`)
- Consider using Redis storage for high-traffic applications
- Set appropriate retention policies

### **Scaling**
- Use Prometheus federation for multiple environments
- Consider Thanos for long-term storage
- Implement service discovery for dynamic services

## 🛠️ **Troubleshooting**

### **Common Issues**

1. **Metrics endpoint returns 500 error**
   ```bash
   # Install missing Prometheus package
   composer require prometheus/client_php
   ```

2. **Grafana can't connect to Prometheus**
   ```bash
   # Check if Prometheus is accessible
   docker exec grafana curl http://prometheus:9090/api/v1/query?query=up
   ```

3. **No data in dashboards**
   ```bash
   # Verify metrics are being generated
   curl http://localhost:8080/metrics
   ```

## 📚 **Resources**

- [Prometheus Documentation](https://prometheus.io/docs/)
- [Grafana Documentation](https://grafana.com/docs/)
- [Laravel Metrics Best Practices](https://laravel.com/docs/monitoring)
- [Prometheus PHP Client](https://github.com/PromPHP/prometheus_client_php)