<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SocialShareController extends Controller
{
    /**
     * Generate share URLs for different social media platforms
     */
    public function getShareUrls(Event $event): JsonResponse
    {
        $baseUrl = config('app.url');
        $eventUrl = $baseUrl . '/events/' . $event->slug;
        $shareText = "Découvrez cet événement: " . $event->title;
        $shareTextEn = "Discover this event: " . $event->title;

        $shareUrls = [
            'facebook' => "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($eventUrl),
            'twitter' => "https://twitter.com/intent/tweet?text=" . urlencode($shareText) . "&url=" . urlencode($eventUrl),
            'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url=" . urlencode($eventUrl),
            'whatsapp' => "https://wa.me/?text=" . urlencode($shareText . " " . $eventUrl),
            'telegram' => "https://t.me/share/url?url=" . urlencode($eventUrl) . "&text=" . urlencode($shareText),
            'email' => "mailto:?subject=" . urlencode($event->title) . "&body=" . urlencode($shareText . "\n\n" . $eventUrl),
            'copy_link' => $eventUrl
        ];

        return response()->json([
            'event' => [
                'id' => $event->id,
                'title' => $event->title,
                'slug' => $event->slug,
                'url' => $eventUrl
            ],
            'share_urls' => $shareUrls
        ]);
    }

    /**
     * Share event on Facebook
     */
    public function shareOnFacebook(Event $event)
    {
        $eventUrl = config('app.url') . '/events/' . $event->slug;
        $shareUrl = "https://www.facebook.com/sharer/sharer.php?u=" . urlencode($eventUrl);

        return redirect($shareUrl);
    }

    /**
     * Share event on Twitter
     */
    public function shareOnTwitter(Event $event)
    {
        $eventUrl = config('app.url') . '/events/' . $event->slug;
        $shareText = "Découvrez cet événement: " . $event->title;
        $shareUrl = "https://twitter.com/intent/tweet?text=" . urlencode($shareText) . "&url=" . urlencode($eventUrl);

        return redirect($shareUrl);
    }

    /**
     * Share event on LinkedIn
     */
    public function shareOnLinkedIn(Event $event)
    {
        $eventUrl = config('app.url') . '/events/' . $event->slug;
        $shareUrl = "https://www.linkedin.com/sharing/share-offsite/?url=" . urlencode($eventUrl);

        return redirect($shareUrl);
    }

    /**
     * Share event on WhatsApp
     */
    public function shareOnWhatsApp(Event $event)
    {
        $eventUrl = config('app.url') . '/events/' . $event->slug;
        $shareText = "Découvrez cet événement: " . $event->title;
        $shareUrl = "https://wa.me/?text=" . urlencode($shareText . " " . $eventUrl);

        return redirect($shareUrl);
    }

    /**
     * Share event on Instagram (via web intent)
     */
    public function shareOnInstagram(Event $event)
    {
        // Instagram doesn't have a direct web share URL like other platforms
        // We'll redirect to a page with instructions or fallback to copying the link
        $eventUrl = config('app.url') . '/events/' . $event->slug;
        
        // Since Instagram requires the mobile app, we'll create a web share intent
        // that will prompt users to copy the link for Instagram
        $shareText = "Découvrez cet événement: " . $event->title . " " . $eventUrl;
        
        // Use navigator.share API if available, otherwise copy to clipboard
        return redirect()->back()->with([
            'instagram_share' => true,
            'share_text' => $shareText,
            'event_url' => $eventUrl,
            'message' => 'Copiez ce lien pour le partager sur Instagram!'
        ]);
    }

    /**
     * Share event via email
     */
    public function shareViaEmail(Event $event)
    {
        $eventUrl = config('app.url') . '/events/' . $event->slug;
        $subject = $event->title;
        $body = "Découvrez cet événement: " . $event->title . "\n\n" . $eventUrl;
        $shareUrl = "mailto:?subject=" . urlencode($subject) . "&body=" . urlencode($body);

        return redirect($shareUrl);
    }

    /**
     * Get embed code for event
     */
    public function getEmbedCode(Event $event): JsonResponse
    {
        $eventUrl = config('app.url') . '/events/' . $event->slug;

        $embedCode = '<iframe src="' . $eventUrl . '/embed" width="600" height="400" frameborder="0" allowfullscreen></iframe>';

        return response()->json([
            'embed_code' => $embedCode,
            'event_url' => $eventUrl
        ]);
    }

    /**
     * Track social media shares (for analytics)
     */
    public function trackShare(Request $request, Event $event): JsonResponse
    {
        $request->validate([
            'platform' => 'required|string|in:facebook,twitter,linkedin,whatsapp,email,copy_link'
        ]);

        // Here you could log the share event to a database table for analytics
        // For now, we'll just return success

        \Log::info('Event shared', [
            'event_id' => $event->id,
            'platform' => $request->platform,
            'user_id' => auth()->id(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Share tracked successfully',
            'platform' => $request->platform
        ]);
    }
}
