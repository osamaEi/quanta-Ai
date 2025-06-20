@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1>Admin Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-4 col-6">
            <x-adminlte-small-box title="{{ $usersCount }}" text="Users" icon="fas fa-users text-dark"
                theme="teal" url="admin/users" url-text="View all"/>
        </div>
        <div class="col-lg-4 col-6">
            <x-adminlte-small-box title="{{ $blogsCount }}" text="Blog Posts" icon="fas fa-blog text-dark"
                theme="purple" url="admin/blogs" url-text="View all"/>
        </div>
        <div class="col-lg-4 col-6">
            <x-adminlte-small-box title="{{ $settingsCount }}" text="Settings" icon="fas fa-cogs text-dark"
                theme="warning" url="admin/settings" url-text="View all"/>
        </div>
    </div>
    <p>Welcome to the admin dashboard.</p>
@stop 