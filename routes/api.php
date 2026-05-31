<?php

use App\Models\Event;
use App\Models\Opportunity;
use App\Models\Post;
use App\Models\SiteStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public routes (no auth required)
|--------------------------------------------------------------------------
*/

// Posts / actualités
Route::get('/posts', function (Request $request) {
    $query = Post::published()->latest('published_at');
    if ($request->integer('limit') > 0) {
        $query->limit($request->integer('limit'));
    }
    return $query->get()->map(fn ($p) => [
        'id'               => $p->id,
        'title'            => $p->title,
        'slug'             => $p->slug,
        'excerpt'          => $p->excerpt,
        'content'          => $p->content,
        'category'         => $p->category,
        'cover_image'      => $p->cover_image ? asset('storage/' . $p->cover_image) : null,
        'published_at_human' => $p->published_at?->diffForHumans(),
    ]);
});

// Événements
Route::get('/events', function (Request $request) {
    $query = Event::published()->upcoming();
    if ($request->integer('limit') > 0) {
        $query->limit($request->integer('limit'));
    }
    return $query->get()->map(fn ($e) => [
        'id'             => $e->id,
        'title'          => $e->title,
        'slug'           => $e->slug,
        'excerpt'        => $e->excerpt,
        'description'    => $e->content,
        'cover_image'    => $e->cover_image ? asset('storage/' . $e->cover_image) : null,
        'location'       => $e->location,
        'address'        => $e->address,
        'starts_at_human'=> $e->starts_at?->translatedFormat('d M Y à H\hi'),
        'ends_at_human'  => $e->ends_at?->translatedFormat('d M Y à H\hi'),
        'day'            => $e->starts_at?->format('d'),
        'month'          => $e->starts_at?->translatedFormat('M'),
    ]);
});

// Opportunités
Route::get('/opportunities', function (Request $request) {
    $query = Opportunity::active()->latest();
    if ($request->integer('limit') > 0) {
        $query->limit($request->integer('limit'));
    }
    return $query->get()->map(fn ($o) => [
        'id'            => $o->id,
        'title'         => $o->title,
        'slug'          => $o->slug,
        'description'   => $o->description,
        'type'          => $o->type,
        'organization'  => $o->organization,
        'location'      => $o->location,
        'deadline_human'=> $o->deadline?->translatedFormat('d M Y'),
        'link'          => $o->external_url,
        'cover_image'   => $o->cover_image ? asset('storage/' . $o->cover_image) : null,
    ]);
});

// Stats
Route::get('/stats', function () {
    return SiteStat::orderBy('id')->get()->map(fn ($s) => [
        'value' => $s->value,
        'label' => $s->label,
    ]);
});

/*
|--------------------------------------------------------------------------
| Auth routes
|--------------------------------------------------------------------------
*/

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email'    => 'required|email',
        'password' => 'required|string',
    ]);

    if (! auth()->attempt($credentials)) {
        return response()->json(['message' => 'Identifiants incorrects.'], 401);
    }

    $user  = auth()->user();
    $token = $user->createToken('mobile')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user'  => [
            'id'               => $user->id,
            'name'             => $user->name,
            'email'            => $user->email,
            'role'             => $user->role,
            'created_at_human' => $user->created_at->translatedFormat('d M Y'),
        ],
    ]);
});

/*
|--------------------------------------------------------------------------
| Authenticated routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        $user = $request->user();
        return [
            'id'               => $user->id,
            'name'             => $user->name,
            'email'            => $user->email,
            'phone'            => $user->phone ?? null,
            'city'             => $user->city  ?? null,
            'graduation_year'  => $user->graduation_year ?? null,
            'role'             => $user->role,
            'created_at_human' => $user->created_at->translatedFormat('d M Y'),
        ];
    });

    Route::post('/logout', function (Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Déconnecté']);
    });
});
