@extends('adminlte::page')

@section('title', 'Manage Testimonials')

@section('content_header')
    <h1 class="m-0 text-dark">Manage Testimonials</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company</th>
                        <th>Review</th>
                        <th>Rating</th>
                        <th>Status</th>
                        <th>Submitted At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $testimonial)
                        <tr>
                            <td>{{ $testimonial->id }}</td>
                            <td>{{ $testimonial->user->name }}</td>
                            <td>{{ Str::limit($testimonial->content, 100) }}</td>
                            <td>
                                @for($i = 0; $i < $testimonial->rating; $i++)
                                    <i class="fas fa-star text-warning"></i>
                                @endfor
                            </td>
                            <td>
                                <span class="badge {{ $testimonial->is_published ? 'badge-success' : 'badge-warning' }}">
                                    {{ $testimonial->is_published ? 'Published' : 'Pending' }}
                                </span>
                            </td>
                            <td>{{ $testimonial->created_at->format('d M Y') }}</td>
                            <td>
                                <!-- Publish/Unpublish -->
                                <form action="{{ route('admin.testimonials.update', $testimonial) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    @if($testimonial->is_published)
                                        <input type="hidden" name="is_published" value="0">
                                        <button type="submit" class="btn btn-sm btn-secondary" title="Unpublish"><i class="fas fa-eye-slash"></i></button>
                                    @else
                                        <input type="hidden" name="is_published" value="1">
                                        <button type="submit" class="btn btn-sm btn-success" title="Publish"><i class="fas fa-eye"></i></button>
                                    @endif
                                </form>

                                <!-- Delete -->
                                <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No testimonials yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $testimonials->links() }}
            </div>
        </div>
    </div>
@stop 