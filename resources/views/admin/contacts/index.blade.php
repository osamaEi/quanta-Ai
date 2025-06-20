@extends('adminlte::page')

@section('title', 'Contact Messages')

@section('content_header')
    <h1>Contact Messages</h1>
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
                        <th style="width: 10px">#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Received At</th>
                        <th style="width: 40px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $contact->name }}</td>
                            <td>{{ $contact->email }}</td>
                            <td>{{ $contact->message }}</td>
                            <td>{{ $contact->created_at->format('d M Y, H:i') }}</td>
                            <td>
                                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop 