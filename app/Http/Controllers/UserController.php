<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = User::query()->select('id', 'name', 'email', 'role', 'is_banned', 'created_at');
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }
        if ($request->has('is_banned') && $request->is_banned !== '') {
            $query->where('is_banned', $request->is_banned);
        }
        $users = $query->orderBy('created_at', 'desc')->get();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::select('id', 'name', 'email', 'role', 'is_banned', 'created_at')->findOrFail($id);
        return response()->json($user);
    }

    public function ban(Request $request, $id)
    {
        $target = User::findOrFail($id);
        $this->authorize('ban', $target);
        $target->update(['is_banned' => true]);
        return response()->json(['banned' => true, 'message' => 'User banned successfully']);
    }

    public function unban(Request $request, $id)
    {
        $target = User::findOrFail($id);
        $this->authorize('unban', $target);
        $target->update(['is_banned' => false]);
        return response()->json(['banned' => false, 'message' => 'User unbanned successfully']);
    }

    public function report(Request $request, $id)
    {
        $data = $request->validate(['reason' => 'required|string|max:255']);
        $report = Report::create([
            'reporter_id' => $request->user()->id,
            'reported_user_id' => $id,
            'reason' => $data['reason'],
        ]);
        return response()->json($report, 201);
    }
}
