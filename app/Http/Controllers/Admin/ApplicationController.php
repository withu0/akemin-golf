<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index()
    {
        return view('admin.applications.index', [
            'applications' => Application::latest()->get(),
        ]);
    }

    public function update(Request $request, Application $application)
    {
        $application->update(['handled' => $request->boolean('handled')]);

        return back()->with('status', '状態を更新しました。');
    }

    public function destroy(Application $application)
    {
        $application->delete();

        return back()->with('status', '応募を削除しました。');
    }
}
