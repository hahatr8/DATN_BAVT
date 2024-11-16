<!-- admin/comments/index.blade.php -->
@extends('admin.dashboard')
@section('content')
<table>
    <tr>
        <th>ID</th>
        <th>Content</th>
        <th>User</th>
        <th>Product</th>
        <th>Actions</th>
    </tr>
    @foreach($comments as $comment)
    <tr>
        <td>{{ $comment->id }}</td>
        <td>{{ $comment->content }}</td>
        <td>{{ $comment->user->name }}</td>
        <td>{{ $comment->product->name }}</td>
        <td>
            <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>
@endsection