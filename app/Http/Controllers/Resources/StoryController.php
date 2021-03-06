<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use DB;
use App\Story;
use App\DraftConverter;
use Dingo\Api\Routing\Helpers;

class StoryController extends Controller
{
    use Helpers;

	public function __construct()
	{
		$this->middleware('api.auth', ['only' => ['store', 'update']]);
	}

    /**
     * Show all the stories, sorted by popularity.
     *
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request)
    {
		$stories = Story::with('author')
			->orderBy('score', 'DESC')
			->paginate(25);

        return $stories;
    }

    /**
     * Show a specific story.
     *
     * @param  String $id
     * @return Response
     */
    public function show($id)
    {
        $story = Story::findOrFail($id);

		$story->related = Story::related($story)
            ->with('categories')
            ->with('author')
			->take(10)
			->get();

		return $story;
    }

    /**
     * Store a new story.
     *
     * @param  Request $request
     * @return Response
     */
	public function store(Request $request)
	{
		$user = app('Dingo\Api\Auth\Auth')->user();

		$story = new Story();
		$story->fill($request->all());
		$story->author()->associate($user);

		$draft = new DraftConverter($request->draft, $request->allFiles());
		$story->body = $draft->export();
        $story->save();

        $location = app('api.url')
            ->version('v1')
            ->route('api.stories.show', $story->id);

		return response($story, 201);
	}

    /**
     * Update an existing story.
     *
     * @param  Request $request
     * @param  String  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $story = Story::findOrFail($id);

        $story->update($request->all());
        $story->save();

        return $this->response->noContent();
    }

}
