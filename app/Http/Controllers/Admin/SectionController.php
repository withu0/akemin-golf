<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    public function index()
    {
        return view('admin.sections.index', [
            'sections' => Section::orderBy('sort')->get(),
        ]);
    }

    public function edit(Section $section)
    {
        return view('admin.sections.form', ['section' => $section]);
    }

    public function update(Request $request, Section $section)
    {
        $data = $request->validate([
            'eyebrow' => ['nullable', 'string', 'max:120'],
            'title'   => ['nullable', 'array'],
            'lead'    => ['nullable', 'array'],
            'body'    => ['nullable', 'array'],
            'image'   => ['nullable', 'image', 'max:25600'],
        ]);

        $section->eyebrow = $data['eyebrow'] ?? $section->eyebrow;
        $section->title   = $data['title'] ?? $section->title;
        $section->lead    = $data['lead'] ?? $section->lead;
        $section->body    = $data['body'] ?? $section->body;

        if ($request->hasFile('image')) {
            if ($section->image) {
                Storage::disk('public')->delete($section->image);
            }
            $section->image = $request->file('image')->store('uploads/sections', 'public');
        }

        $section->save();

        return redirect()->route('admin.sections.index')->with('status', 'ページ内容を更新しました。');
    }
}
