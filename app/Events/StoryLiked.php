<?php

namespace App\Events;

use Auth;
use App\Like;
use App\Story;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StoryLiked extends Event implements ShouldBroadcast
{
    use SerializesModels;

	/**
	 * The like of the event.
	 *
	 * @var Like
	 */
	public $like;

	/**
	 * The story of the event.
	 *
	 * @var Story
	 */
	public $story;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Like $like)
    {
		$user = Auth::user();
		$this->story = Story::findOrFail($like->story_id);
		$this->like = $like;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return ['events'];
    }

	/**
	 * Get the broadcast event name.
	 *
	 * @return string
	 */
	public function broadcastAs()
	{
	    return 'story.liked';
	}
}
