<?php

namespace app\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Request;

class ArticlesController extends Controller
{
	/*
	|-------------------------------------------------------------------------------
	| Get All Articles
	|-------------------------------------------------------------------------------
	| URL:            /api/article/get
	| Method:         GET
	| Description:    Gets all of the articles in the application
	*/
	public function getArticle() {
		$articles = Article::all();
		foreach ($articles as $article)
			$article->tags = explode(',', $article->tags);
		return response()->json($articles, 201);
	}

	/*
	|-------------------------------------------------------------------------------
	| Adds a New Article
	|-------------------------------------------------------------------------------
	| URL:            /api/article/post
	| Method:         POST
	| Description:    Adds a new article to the application
	*/
	public function postArticle() {
		$article = new Article();
		$article->title = Request::get('title');
		$article->content = Request::get('content');
		$article->tags = join(',', Request::get('tags'));
		$article->save();
		$article->tags = explode(',', $article->tags);
		return response()->json($article, 201);
	}

	/*
	|-------------------------------------------------------------------------------
	| Delete An Individual Article
	|-------------------------------------------------------------------------------
	| URL:            /api/article/delete
	| Method:         DELETE
	| Description:    Deletes an individual article
	*/
	public function deleteArticle() {
		$article = Article::find(Request::get('id'))->delete();
		return response()->json($article, 201);
	}
}