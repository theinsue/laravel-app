<?php

namespace App\Http\Controllers;

use App\News;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feed = \Feeds::make(config('feeds.url'));

        // loop each feed items
        foreach ($feed->get_items() as $feedItem) {

            $data = $this->retrieveFeedItems($feedItem);

            $this->checkExisting($data);
        }

        $news = News::all();

        return view('news.index', compact('news'));
    }

    /**
     * Retrieve each feed items
     *
     * @param array $item
     * @return array $feedItem;
     */
    public function retrieveFeedItems($item)
    {
        $data = $item->data['child'][''];

        $feedItem['title'] = html_entity_decode($data['title'][0]['data']);
        $feedItem['link'] = html_entity_decode($data['link'][0]['data']);
        $feedItem['description'] = html_entity_decode($data['description'][0]['data']);
        $feedItem['guid'] = html_entity_decode($data['guid'][0]['data']);
        $feedItem['pubDate'] = html_entity_decode($data['pubDate'][0]['data']);
        $feedItem['creator'] = html_entity_decode($item->data['child']['http://purl.org/dc/elements/1.1/']['creator'][0]['data']);
        $feedItem['thumbnail'] = html_entity_decode($item->data['child']['http://search.yahoo.com/mrss/']['thumbnail'][0]['attribs']['']['url']);

        return $feedItem;
    }

    /**
     * Check existing news or not by guid,
     * if new feed item, save into database
     * if existing one, update metada if any
     *
     * @param array $data
     * @return bool
     */
    public function checkExisting($data)
    {
        $news = News::existing($data['guid'])->first();

        if ( !$news['guid'] ) {

            // save new
            $this->store($data);
        }
        else {
            // TO DO
            //$this->update($data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    public function store($data)
    {
        if ($this->validateItems($data)->fails()) {
          return back();
        }

        News::create([
            'title' => $data['title'],
            'description' =>  $data['description'],
            'link'  =>  $data['link'],
            'creator'  =>  $data['creator'],
            'guid'  =>  $data['guid'],
            'thumbnail'  =>  $data['thumbnail'],
            'pubDate'  =>  Carbon::parse($data['pubDate'])
        ]);
    }

    /**
     * Validate feeds items
     *
     * @param array $data
     * @return mixed
     */
    public function validateItems($data)
    {
        $validator = \Validator::make($data, [
            'title' => 'required',
            'description'  => 'required',
            'link'  => 'required',
            'creator'  => 'required',
            'guid'  => 'required',
            'thumbnail'  => 'required',
            'pubDate'  => 'required'
        ]);

        return $validator;
    }

    /**
     * Display the specified resource.
     *
     * @param  News $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
