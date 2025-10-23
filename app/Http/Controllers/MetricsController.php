<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Prometheus\CollectorRegistry;
use Prometheus\Storage\InMemory;
use Prometheus\RenderTextFormat;
use App\Models\User;
use App\Models\Event;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class MetricsController extends Controller
{
    private CollectorRegistry $registry;

    public function __construct()
    {
        $this->registry = new CollectorRegistry(new InMemory());
    }

    /**
     * Return Prometheus metrics in the expected format
     */
    public function index(): Response
    {
        // Application metrics
        $this->collectApplicationMetrics();
        
        // Business metrics
        $this->collectBusinessMetrics();
        
        // Database metrics
        $this->collectDatabaseMetrics();

        $renderer = new RenderTextFormat();
        $result = $renderer->render($this->registry->getMetricFamilySamples());

        return response($result, 200, [
            'Content-Type' => RenderTextFormat::MIME_TYPE
        ]);
    }

    /**
     * Collect application performance metrics
     */
    private function collectApplicationMetrics(): void
    {
        // HTTP request duration
        $requestDuration = $this->registry->getOrRegisterHistogram(
            'http',
            'request_duration_seconds',
            'Duration of HTTP requests',
            ['method', 'route', 'status_code'],
            [0.1, 0.5, 1.0, 2.0, 5.0]
        );

        // Memory usage
        $memoryUsage = $this->registry->getOrRegisterGauge(
            'laravel',
            'memory_usage_bytes',
            'Current memory usage in bytes'
        );
        $memoryUsage->set(memory_get_usage(true));

        // Cache hit ratio
        $cacheHits = Cache::get('metrics_cache_hits', 0);
        $cacheMisses = Cache::get('metrics_cache_misses', 0);
        $totalRequests = $cacheHits + $cacheMisses;
        
        if ($totalRequests > 0) {
            $cacheHitRatio = $this->registry->getOrRegisterGauge(
                'laravel',
                'cache_hit_ratio',
                'Cache hit ratio percentage'
            );
            $cacheHitRatio->set(($cacheHits / $totalRequests) * 100);
        }
    }

    /**
     * Collect business-specific metrics
     */
    private function collectBusinessMetrics(): void
    {
        // Total users
        $totalUsers = $this->registry->getOrRegisterGauge(
            'ecoevents',
            'total_users',
            'Total number of registered users'
        );
        $totalUsers->set(User::count());

        // Total events
        $totalEvents = $this->registry->getOrRegisterGauge(
            'ecoevents',
            'total_events',
            'Total number of events'
        );
        $totalEvents->set(Event::count());

        // Active events (not past)
        $activeEvents = $this->registry->getOrRegisterGauge(
            'ecoevents',
            'active_events',
            'Number of upcoming events'
        );
        $activeEvents->set(Event::where('date', '>=', now())->count());

        // Total registrations
        $totalRegistrations = $this->registry->getOrRegisterGauge(
            'ecoevents',
            'total_registrations',
            'Total number of event registrations'
        );
        $totalRegistrations->set(Registration::count());

        // New users today
        $newUsersToday = $this->registry->getOrRegisterGauge(
            'ecoevents',
            'new_users_today',
            'Number of users registered today'
        );
        $newUsersToday->set(User::whereDate('created_at', today())->count());

        // Events created this month
        $eventsThisMonth = $this->registry->getOrRegisterGauge(
            'ecoevents',
            'events_created_this_month',
            'Number of events created this month'
        );
        $eventsThisMonth->set(Event::whereMonth('created_at', now()->month)->count());
    }

    /**
     * Collect database performance metrics
     */
    private function collectDatabaseMetrics(): void
    {
        // Database connection count
        $dbConnections = $this->registry->getOrRegisterGauge(
            'laravel',
            'database_connections_active',
            'Number of active database connections'
        );
        
        try {
            $activeConnections = DB::select("SHOW STATUS LIKE 'Threads_connected'");
            if (!empty($activeConnections)) {
                $dbConnections->set((float) $activeConnections[0]->Value);
            }
        } catch (\Exception $e) {
            // If we can't get connection count, set to 0
            $dbConnections->set(0);
        }

        // Query execution time (simplified - you'd typically track this via middleware)
        $queryTime = $this->registry->getOrRegisterHistogram(
            'laravel',
            'database_query_duration_seconds',
            'Database query execution time',
            ['query_type'],
            [0.001, 0.01, 0.1, 0.5, 1.0, 2.0]
        );

        // Database size metrics
        try {
            $dbSize = DB::select("
                SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS db_size 
                FROM information_schema.tables 
                WHERE table_schema = DATABASE()
            ");
            
            if (!empty($dbSize)) {
                $databaseSize = $this->registry->getOrRegisterGauge(
                    'laravel',
                    'database_size_mb',
                    'Database size in megabytes'
                );
                $databaseSize->set((float) $dbSize[0]->db_size);
            }
        } catch (\Exception $e) {
            // Handle error gracefully
        }
    }
}