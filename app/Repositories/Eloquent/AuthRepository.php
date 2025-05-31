<?php
namespace App\Repositories\Eloquent;
use App\Models\User;
use App\Models\FcmToken;
use App\Models\Notification;
use App\Repositories\Interfaces\IAuthRepository;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;
class AuthRepository implements IAuthRepository
{
    protected $fcmtokenmodel;
    protected $model;
    protected $notificationmodel;
    public function __construct(User $model, FcmToken $fcmtokenmodel, Notification $notificationmodel)
    {
        $this->model = $model;
        $this->fcmtokenmodel = $fcmtokenmodel;
        $this->notificationmodel = $notificationmodel;
    }
    public function getAll()
    {
        return $this->model->all();
    }
    public function getById($id)
    {
        return $this->model->findOrFail($id);
    }
    public function create(array $data)
    {
        return $this->model->create($data);
    }
    public function update($id, array $data)
    {
        $record = $this->model->findOrFail($id);
        $record->update($data);
        return $record;
    }
    public function delete($id)
    {
        $record = $this->model->findOrFail($id);
        $record->delete();
    }
    public function saveFcmToken(array $data): \Illuminate\Http\JsonResponse
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        try {
            $existing = $this->fcmtokenmodel->where('token', $data['token'])->first();
            if ($existing && $existing->user_id !== $user->user_id) {
                $existing->delete();
            }
            $this->fcmtokenmodel->updateOrCreate(
                [
                    'user_id' => $user->user_id,
                    'device_info' => $data['device_info'],
                ],
                [
                    'token' => $data['token'],
                ]
            );
            return response()->json(['message' => 'Token saved']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function sendNotification(int $senderId, int $receiverId, string $content, int $week_id)
    {
        $user = $this->model->findOrFail($receiverId);
        $token = $user->fcmTokens()->latest()->first()?->token;
        $this->notificationmodel::create([
            'title' => 'notice week ' . $week_id,
            'user_id' => $receiverId,
            'sender_id' => $senderId,
            'content' => $content,
            'week_id' => $week_id,
            'is_read' => false,
        ]);
        if (!$token) {
            return response()->json(['message' => 'No FCM token available'], 200);
        }
        try {
            $credentialsPath = storage_path('/firebase/firebase-service-account.json');
            $credentials = new ServiceAccountCredentials(
                'https://www.googleapis.com/auth/firebase.messaging',
                $credentialsPath
            );
            $accessToken = $credentials->fetchAuthToken()['access_token'];
            $projectId = env('FIREBASE_PROJECT_ID');
            $response = Http::withToken($accessToken)
                ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                    'message' => [
                        'token' => $token,
                        'notification' => [
                            'title' => "notice week $week_id",
                            'body' => $content,
                        ],
                        'data' => [
                            'sender_id' => (string)$senderId,
                            'content' => $content,
                            'week_id' => (string)$week_id,
                        ],
                    ],
                ]);
            if ($response->failed()) {
                return response()->json(['message' => 'FCM send failed', 'error' => $response->json()], 400);
            }
            return response()->json(['message' => 'Notification sent and saved']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Notification saved, but FCM failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function remindDeadline(){
        $start = microtime(true);
        $users = $this->model->where('role', '=', 'student')->get();
        if ($users->isEmpty()) {
            return ['message' => 'No users found to send notifications'];
        }
        $credentialsPath = storage_path('/firebase/firebase-service-account.json');
        $credentials = new ServiceAccountCredentials(
            'https://www.googleapis.com/auth/firebase.messaging',
            $credentialsPath
        );
        $accessToken = $credentials->fetchAuthToken()['access_token'];
        $projectId = env('FIREBASE_PROJECT_ID');

        $successCount = 0;
        $failedCount = 0;

        foreach ($users as $user) {
            $token = $user->fcmTokens()->latest()->first()?->token;
            if (!$token) {
                \Log::warning("No FCM token for user_id: {$user->id}");
                continue;
            }
            $content = "DO journal pls";
            try {
                $response = Http::withToken($accessToken)
                    ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", [
                        'message' => [
                            'token' => $token,
                            'notification' => [
                                'title' => "Remind: you need to finish all deadline you have",
                                'body' => $content,
                            ],
                            'data' => [
                                'sender_id' => '1',
                                'content' => $content,
                            ],
                        ],
                    ]);
                $successCount++;
            } catch (\Exception $e) {
                \Log::error("Failed to send FCM to user_id: {$user->id}, error: " . $e->getMessage());
                $failedCount++;
            }
        }

        \Log::info("remindDeadline took " . (microtime(true) - $start) . " seconds. Success: $successCount, Failed: $failedCount");
        return [
            'message' => 'Notifications processed',
            'success_count' => $successCount,
            'failed_count' => $failedCount,
        ];
    }
}
