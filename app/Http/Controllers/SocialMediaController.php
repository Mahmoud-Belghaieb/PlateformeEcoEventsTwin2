<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SocialMediaController extends Controller
{
    /**
     * Share an event to social media platforms
     *
     * @param  Event  $event  The event to share
     * @param  string  $platform  The platform to share to ('facebook' or 'instagram')
     * @return array Success or error message
     */
    public function shareToSocialMedia(Event $event, string $platform)
    {
        try {
            // Validate platform
            if (! in_array($platform, ['facebook', 'instagram'])) {
                return [
                    'success' => false,
                    'message' => 'Invalid platform. Supported platforms: facebook, instagram',
                ];
            }

            // Get credentials from environment variables
            $appId = env('FACEBOOK_APP_ID');
            $appSecret = env('FACEBOOK_APP_SECRET');
            $accessToken = env('FACEBOOK_ACCESS_TOKEN');

            if (! $appId || ! $appSecret || ! $accessToken) {
                return [
                    'success' => false,
                    'message' => 'Social media credentials not configured in environment variables',
                ];
            }

            // Prepare event data for posting
            $postData = $this->prepareEventPostData($event);

            if ($platform === 'facebook') {
                return $this->shareToFacebook($postData, $accessToken);
            } elseif ($platform === 'instagram') {
                return $this->shareToInstagram($postData, $accessToken);
            }

        } catch (\Exception $e) {
            Log::error('Social media sharing failed: '.$e->getMessage());

            return [
                'success' => false,
                'message' => 'Failed to share to social media: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Prepare event data for social media posting
     *
     * @return array
     */
    private function prepareEventPostData(Event $event)
    {
        $eventUrl = url('/events/'.$event->slug);
        $imageUrl = $event->image_url; // Uses the getImageUrlAttribute accessor

        return [
            'message' => $this->generatePostMessage($event),
            'link' => $eventUrl,
            'picture' => $imageUrl,
            'name' => $event->title,
            'description' => $event->short_description ?: substr($event->description, 0, 200).'...',
            'caption' => 'EcoEvents - Sustainable Event Management',
        ];
    }

    /**
     * Generate a compelling post message for the event
     *
     * @return string
     */
    private function generatePostMessage(Event $event)
    {
        $message = "🌱 Join us for: {$event->title}\n\n";
        $message .= '📅 Date: '.$event->start_date->format('M j, Y')."\n";
        $message .= "📍 Location: {$event->location}\n";

        if ($event->price > 0) {
            $message .= "💰 Price: {$event->formatted_price}\n";
        } else {
            $message .= "💰 Free Event!\n";
        }

        $message .= "👥 Available spots: {$event->available_spots}\n\n";
        $message .= 'Help us reduce our carbon footprint and create positive change! #EcoEvents #SustainableLiving';

        return $message;
    }

    /**
     * Share event to Facebook page feed
     *
     * @return array
     */
    private function shareToFacebook(array $postData, string $accessToken)
    {
        // Get Facebook Page ID from environment or config
        $pageId = env('FACEBOOK_PAGE_ID');

        if (! $pageId) {
            return [
                'success' => false,
                'message' => 'Facebook Page ID not configured',
            ];
        }

        // Post to Facebook page feed using Graph API
        $response = Http::post("https://graph.facebook.com/v18.0/{$pageId}/feed", [
            'message' => $postData['message'],
            'link' => $postData['link'],
            'access_token' => $accessToken,
        ]);

        if ($response->successful()) {
            $postId = $response->json()['id'];

            return [
                'success' => true,
                'message' => 'Event successfully shared to Facebook!',
                'post_id' => $postId,
                'platform' => 'facebook',
            ];
        } else {
            $error = $response->json()['error']['message'] ?? 'Unknown Facebook API error';

            return [
                'success' => false,
                'message' => 'Facebook sharing failed: '.$error,
            ];
        }
    }

    /**
     * Share event to Instagram business account
     *
     * @return array
     */
    private function shareToInstagram(array $postData, string $accessToken)
    {
        // Get Instagram Business Account ID
        $instagramAccountId = env('INSTAGRAM_ACCOUNT_ID');

        if (! $instagramAccountId) {
            return [
                'success' => false,
                'message' => 'Instagram Account ID not configured',
            ];
        }

        try {
            // Step 1: Create a media container
            $mediaResponse = Http::post("https://graph.facebook.com/v18.0/{$instagramAccountId}/media", [
                'image_url' => $postData['picture'],
                'caption' => $postData['message'],
                'access_token' => $accessToken,
            ]);

            if (! $mediaResponse->successful()) {
                $error = $mediaResponse->json()['error']['message'] ?? 'Failed to create media container';

                return [
                    'success' => false,
                    'message' => 'Instagram media creation failed: '.$error,
                ];
            }

            $mediaId = $mediaResponse->json()['id'];

            // Step 2: Publish the media container
            $publishResponse = Http::post("https://graph.facebook.com/v18.0/{$instagramAccountId}/media_publish", [
                'creation_id' => $mediaId,
                'access_token' => $accessToken,
            ]);

            if ($publishResponse->successful()) {
                $postId = $publishResponse->json()['id'];

                return [
                    'success' => true,
                    'message' => 'Event successfully shared to Instagram!',
                    'post_id' => $postId,
                    'platform' => 'instagram',
                ];
            } else {
                $error = $publishResponse->json()['error']['message'] ?? 'Failed to publish media';

                return [
                    'success' => false,
                    'message' => 'Instagram publishing failed: '.$error,
                ];
            }

        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Instagram sharing failed: '.$e->getMessage(),
            ];
        }
    }
}
