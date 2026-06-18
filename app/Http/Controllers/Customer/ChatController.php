<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    /**
     * Display chat page.
     */
    public function index()
    {
        $messages = ChatMessage::where('user_id', Auth::id())
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark admin messages as read
        ChatMessage::where('user_id', Auth::id())
            ->where('sender_type', 'admin')
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('customer.chat.index', compact('messages'));
    }

    /**
     * Send a new message.
     */
    public function send(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000'
            ]);

            $message = ChatMessage::create([
                'user_id' => Auth::id(),
                'message' => $request->message,
                'sender_type' => 'customer',
                'is_read' => false,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully!',
                'data' => [
                    'id' => $message->id,
                    'message' => $message->message,
                    'sender_type' => $message->sender_type,
                    'created_at' => $message->created_at->diffForHumans(),
                    'formatted_time' => $message->created_at->format('h:i A'),
                ],
                'html' => view('customer.chat.partials.message', compact('message'))->render()
            ]);

        } catch (\Exception $e) {
            Log::error('Chat send error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to send message. Please try again.'
            ], 500);
        }
    }

    /**
     * Get all messages (for AJAX polling).
     */
    public function getMessages()
    {
        try {
            $messages = ChatMessage::where('user_id', Auth::id())
                ->orderBy('created_at', 'asc')
                ->get();

            // Mark admin messages as read
            ChatMessage::where('user_id', Auth::id())
                ->where('sender_type', 'admin')
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            return response()->json([
                'success' => true,
                'messages' => $messages,
                'html' => view('customer.chat.partials.messages', compact('messages'))->render(),
                'unread_count' => 0
            ]);

        } catch (\Exception $e) {
            Log::error('Chat get messages error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load messages.'
            ], 500);
        }
    }

    /**
     * Get unread count for navbar badge.
     */
    public function getUnreadCount()
    {
        try {
            $count = ChatMessage::where('user_id', Auth::id())
                ->where('sender_type', 'admin')
                ->where('is_read', false)
                ->count();

            return response()->json(['count' => $count]);

        } catch (\Exception $e) {
            Log::error('Chat unread count error: ' . $e->getMessage());
            return response()->json(['count' => 0]);
        }
    }

    /**
     * Mark all messages as read.
     */
    public function markAllAsRead()
    {
        try {
            ChatMessage::where('user_id', Auth::id())
                ->where('sender_type', 'admin')
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            return response()->json([
                'success' => true,
                'message' => 'All messages marked as read.'
            ]);

        } catch (\Exception $e) {
            Log::error('Chat mark all read error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to mark messages as read.'
            ], 500);
        }
    }

    /**
     * Delete a message (only customer's own messages).
     */
    public function destroy($id)
    {
        try {
            $message = ChatMessage::where('user_id', Auth::id())
                ->where('id', $id)
                ->where('sender_type', 'customer')
                ->firstOrFail();

            $message->delete();

            return response()->json([
                'success' => true,
                'message' => 'Message deleted successfully.'
            ]);

        } catch (\Exception $e) {
            Log::error('Chat delete error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete message.'
            ], 500);
        }
    }

    /**
     * Update a message (only customer's own messages).
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:1000'
            ]);

            $message = ChatMessage::where('user_id', Auth::id())
                ->where('id', $id)
                ->where('sender_type', 'customer')
                ->firstOrFail();

            $message->update([
                'message' => $request->message,
                'updated_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Message updated successfully.',
                'data' => [
                    'id' => $message->id,
                    'message' => $message->message,
                    'updated_at' => $message->updated_at->diffForHumans(),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Chat update error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update message.'
            ], 500);
        }
    }

    /**
     * Clear all messages for the user.
     */
    public function clearAll()
    {
        try {
            ChatMessage::where('user_id', Auth::id())->delete();

            return response()->json([
                'success' => true,
                'message' => 'All messages cleared.'
            ]);

        } catch (\Exception $e) {
            Log::error('Chat clear error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear messages.'
            ], 500);
        }
    }

    /**
     * Get chat history for a specific date range.
     */
    public function getHistory(Request $request)
    {
        try {
            $query = ChatMessage::where('user_id', Auth::id());

            if ($request->has('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }
            if ($request->has('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }
            if ($request->has('sender_type') && in_array($request->sender_type, ['customer', 'admin'])) {
                $query->where('sender_type', $request->sender_type);
            }

            $messages = $query->orderBy('created_at', 'asc')->paginate(50);

            return response()->json([
                'success' => true,
                'messages' => $messages
            ]);

        } catch (\Exception $e) {
            Log::error('Chat history error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load chat history.'
            ], 500);
        }
    }

    /**
     * Get latest messages (for real-time updates).
     */
    public function getLatest(Request $request)
    {
        try {
            $lastId = $request->input('last_id', 0);

            $messages = ChatMessage::where('user_id', Auth::id())
                ->where('id', '>', $lastId)
                ->orderBy('created_at', 'asc')
                ->get();

            ChatMessage::where('user_id', Auth::id())
                ->where('sender_type', 'admin')
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);

            return response()->json([
                'success' => true,
                'messages' => $messages,
                'html' => view('customer.chat.partials.messages', compact('messages'))->render(),
                'last_id' => $messages->isNotEmpty() ? $messages->last()->id : $lastId
            ]);

        } catch (\Exception $e) {
            Log::error('Chat latest error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to load latest messages.'
            ], 500);
        }
    }

    /**
     * Upload chat attachment (image/file).
     */
    public function uploadAttachment(Request $request)
    {
        try {
            $request->validate([
                'attachment' => 'required|file|max:5120|mimes:jpg,jpeg,png,gif,pdf,doc,docx'
            ]);

            $file = $request->file('attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('chat_attachments', $fileName, 'public');

            $message = ChatMessage::create([
                'user_id' => Auth::id(),
                'message' => '📎 File attached: ' . $file->getClientOriginalName(),
                'sender_type' => 'customer',
                'is_read' => false,
                'attachment' => $filePath,
                'attachment_type' => $file->getMimeType(),
                'attachment_name' => $file->getClientOriginalName(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully!',
                'data' => [
                    'id' => $message->id,
                    'attachment' => asset('storage/' . $filePath),
                    'attachment_name' => $file->getClientOriginalName(),
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Chat upload error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to upload file. Please try again.'
            ], 500);
        }
    }
}