<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ThemeController extends Controller
{
    public function index()
    {
        $theme = Theme::all();

        return Inertia::render('Themes', [
            'theme' => $theme,
        ]);
    }

    public function create()
    {
        $theme = Theme::all();

        return Inertia::render('CreateTheme', [
            'theme' => $theme,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:themes,name'],
            'primary' => ['required', 'string', 'size:7'],
            'primary_dark' => ['required', 'string', 'size:7'],
            'secondary' => ['required', 'string', 'size:7'],
            'text' => ['required', 'string', 'size:7'],
            'text_secondary' => ['required', 'string', 'size:7'],
            'background' => ['required', 'string', 'size:7'],
            'background_card' => ['required', 'string', 'size:7'],
        ]);

        $theme = new Theme;
        $theme->name = $validated['name'];
        $theme->primary = $validated['primary'];
        $theme->primary_dark = $validated['primary_dark'];
        $theme->secondary = $validated['secondary'];
        $theme->text = $validated['text'];
        $theme->text_secondary = $validated['text_secondary'];
        $theme->background = $validated['background'];
        $theme->background_card = $validated['background_card'];
        $theme->save();

        return redirect()->route('theme.index');
    }

    public function show($id)
    {
        $theme = Theme::findOrFail($id);

        return Inertia::render('ShowTheme', [
            'theme' => $theme,
        ]);
    }

    public function edit($id)
    {
        $theme = Theme::findOrFail($id);

        return Inertia::render('EditTheme', [
            'theme' => $theme,
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:themes,name,'.$id],
            'primary' => ['required', 'string', 'size:7'],
            'primary_dark' => ['required', 'string', 'size:7'],
            'secondary' => ['required', 'string', 'size:7'],
            'text' => ['required', 'string', 'size:7'],
            'text_secondary' => ['required', 'string', 'size:7'],
            'background' => ['required', 'string', 'size:7'],
            'background_card' => ['required', 'string', 'size:7'],
        ]);

        $theme = Theme::findOrFail($id);
        $theme->name = $validated['name'];
        $theme->primary = $validated['primary'];
        $theme->primary_dark = $validated['primary_dark'];
        $theme->secondary = $validated['secondary'];
        $theme->text = $validated['text'];
        $theme->text_secondary = $validated['text_secondary'];
        $theme->background = $validated['background'];
        $theme->background_card = $validated['background_card'];
        $theme->save();

        return redirect()->route('theme.index');
    }

    public function destroy($id)
    {
        $theme = Theme::findOrFail($id);
        $theme->delete();

        return redirect()->route('theme.index');
    }
}
