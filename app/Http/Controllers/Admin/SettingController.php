<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    public function create()
    {
        return view('admin.settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:settings',
            'value' => 'nullable|string',
        ]);

        Setting::create($request->only('key', 'value'));

        return redirect()->route('admin.settings.index')->with('success', 'Setting created successfully.');
    }

    public function edit(Setting $setting)
    {
        return view('admin.settings.edit', compact('setting'));
    }

    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'key' => 'required|string|max:255|unique:settings,key,' . $setting->id,
            'value' => 'nullable|string',
        ]);

        $setting->update($request->only('key', 'value'));

        return redirect()->route('admin.settings.index')->with('success', 'Setting updated successfully.');
    }

    public function destroy(Setting $setting)
    {
        $setting->delete();
        return redirect()->route('admin.settings.index')->with('success', 'Setting deleted successfully.');
    }
}
