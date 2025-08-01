<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = News::orderBy('created_at', 'desc')->paginate(4);
        
        return view('news.index', compact('news'));
    }

    public function show($id)
    {
        $newsItem = News::findOrFail($id);
        return view('news.show', compact('newsItem'));
    }
}
