use App\Http\Controllers\ChatController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

// Authenticated user
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/chats', [ChatController::class, 'index']);
    Route::post('/chats', [ChatController::class, 'store']);
    Route::get('/chats/{id}', [ChatController::class, 'show']);
    Route::delete('/chats/{id}', [ChatController::class, 'destroy']);

});