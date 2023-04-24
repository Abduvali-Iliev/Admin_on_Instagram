<?php

namespace App\Orchid\Layouts;

use App\Models\Comment;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class CommentListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'comments';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID')->sort(),
            TD::make('approved', 'Status')->render(function (Comment $comment) {
                return Link::make($comment->approved)
                    ->route('platform.comments.edit', ['comment' => $comment]);
            })->sort(),
            TD::make('text', 'Text')->filter(TD::FILTER_TEXT)->sort(),
            TD::make('created_at', 'Created date')->sort(),
        ];
    }
}
