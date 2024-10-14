<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\http;
use App\Models\News;

class NewsController extends Controller
{
    public function index()
{
    $response = Http::get('http://your-fastapi-url/news-types/active'); // เปลี่ยน URL ให้ตรงกับ FastAPI ของคุณ
    $newsTypes = json_decode($response->body());

    return view('news-list', ['news' => $newsTypes]);
}
    public function show($id)
    {
        $news = DB::table('news')
            ->join('categories as c1', 'news.category_level_1', '=', 'c1.id')
            ->join('categories as c2', 'news.category_level_2', '=', 'c2.id')
            ->join('news_types', 'news.news_type_id', '=', 'news_types.id')
            ->where('news.id', $id)
            ->select('news.id', 'news.title', 'news.content', 'c1.name as c1name', 'c2.name as c2name')
            ->first();

        if (!$news) {
            return redirect('/news-list')->with('error', 'ไม่พบข่าวที่คุณเลือก');
        }

        return view('show', compact('news'));
    }
}
