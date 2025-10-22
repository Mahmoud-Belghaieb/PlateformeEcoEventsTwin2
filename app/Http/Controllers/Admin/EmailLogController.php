<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class EmailLogController extends Controller
{
    /**
     * Afficher les emails du log
     */
    public function index()
    {
        $logFile = storage_path('logs/laravel.log');
        
        if (!File::exists($logFile)) {
            return view('admin.email-logs', ['emails' => [], 'logExists' => false]);
        }
        
        $logContent = File::get($logFile);
        $emails = $this->parseResetEmails($logContent);
        
        return view('admin.email-logs', [
            'emails' => $emails,
            'logExists' => true,
            'logSize' => $this->formatBytes(File::size($logFile))
        ]);
    }
    
    /**
     * Parser les emails de reset password du fichier log
     */
    private function parseResetEmails($content)
    {
        $emails = [];
        $lines = explode("\n", $content);
        
        foreach ($lines as $index => $line) {
            // Chercher les URLs de reset password
            if (preg_match('/http[s]?:\/\/[^\s]+reset-password\/([^\s?]+)\?email=([^\s&]+)/', $line, $matches)) {
                $fullUrl = $matches[0];
                $token = $matches[1];
                $email = urldecode($matches[2]);
                
                // Extraire le timestamp de la ligne de log
                $timestamp = 'Inconnu';
                if (preg_match('/\[([\d\-:\s]+)\]/', $line, $timeMatch)) {
                    $timestamp = $timeMatch[1];
                }
                
                $emails[] = [
                    'email' => $email,
                    'token' => $token,
                    'url' => $fullUrl,
                    'timestamp' => $timestamp,
                    'short_token' => substr($token, 0, 20) . '...'
                ];
            }
        }
        
        // Retourner les 20 derniers emails (les plus récents en premier)
        return array_slice(array_reverse($emails), 0, 20);
    }
    
    /**
     * Vider les logs
     */
    public function clear()
    {
        $logFile = storage_path('logs/laravel.log');
        
        if (File::exists($logFile)) {
            File::put($logFile, '');
        }
        
        return redirect()->route('admin.email-logs')
            ->with('success', 'Logs vidés avec succès');
    }
    
    /**
     * Formater la taille du fichier
     */
    private function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
