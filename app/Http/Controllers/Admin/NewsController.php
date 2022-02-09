<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CreateNewsRequest;
use App\Http\Requests\Admin\UpdateNewsRequest;
use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $articles = News::latest()->paginate(15);

        return view('admin.news.list', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateNewsRequest $request)
    {

        $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
        $news = News::create([
            'published_from' => $request->input('published_from') ?: now(),
            'image' => $filename
        ]);

        foreach(config('app.locales') as $key => $locale) {
            $news->translateOrNew($key)->title = $request->input('title.' . $key);
            $news->translateOrNew($key)->content = $request->input('content.' . $key);
        }

        $news->save();

        $request->file('image')->storeAs(
            'public', $filename
        );

        return redirect()->route('admin.news.edit', $news->id)
            ->with(['success' => 'News has been successfuly created']);

    }


    public function edit(News $news)
    {
        return view('admin.news.form', compact('news'));
    }


    public function update(UpdateNewsRequest $request, News $news)
    {
        if($request->file('image')) {
            $filename = Str::uuid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs(
                'public', $filename
            );

            $news->image = $filename;
        }

        foreach(config('app.locales') as $key => $locale) {
            $news->translateOrNew($key)->title = $request->input('title.' . $key);
            $news->translateOrNew($key)->content = $request->input('content.' . $key);
        }

        $news->published_from = $request->input('published_from');

        $news->save();
        return redirect()->back()
            ->with(['success' => 'News has been succesfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
