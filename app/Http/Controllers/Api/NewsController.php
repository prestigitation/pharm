<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\News;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return News::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->formProps = json_decode($request->props);
            News::create([
                'title' => $this->formProps->title,
                'content' => $this->formProps->content
            ]);
            if($request->hasFile('file')) {
                Storage::putFileAs('./public/img/news/',$request->file('file'),(string) News::count().'.jpeg');
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return News::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->formProps = json_decode($request->props);
        $news = News::findOrFail($id); // id запрашиваемой статьи
        $news->update([ // если определенные параметры заданы
            'title' =>  $this->formProps->title ?? $news->title,
            'content'=> $this->formProps->content ?? $news->content
        ]);
        if($request->hasFile('file')) {
            $fileController = new FileController();
            $fileController->updateFile($request,'products',$id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();
    }
}
