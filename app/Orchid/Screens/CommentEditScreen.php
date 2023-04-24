<?php

namespace App\Orchid\Screens;

use App\Models\Article;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class CommentEditScreen extends Screen
{
    public bool $exists = false;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Comment $comment): iterable
    {
        $this->exists = $comment->exists;

        return [
            'comment' => $comment,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Comment Approving';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Create comment')
                ->icon('icon-plus')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),


            Button::make('Update')
                ->icon('icon-note')
                ->method('createOrUpdate')
                ->canSee($this->exists),


            Button::make('Delete')
                ->icon('icon-trash')
                ->method('remove')
                ->canSee($this->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('comment.approved')
                    ->title('Status')
                    ->placeholder('Attractive but mysterious status')
                    ->help('Specify a short descriptive title for this article.'),

                Relation::make('comment.user_id')
                    ->title('Author')
                    ->fromModel(User::class, 'name', 'id'),

                Relation::make('comment.post_id')
                    ->title('Post')
                    ->fromModel(Post::class, 'text', 'id'),

                Input::make('comment.text')
                    ->title('Main text')
            ])

        ];
    }


    public function createOrUpdate(Comment $comment, Request $request): \Illuminate\Http\RedirectResponse
    {
        $comment->fill($request->get("comment"))->save();
        Alert::info('You have successfully created an article.');
        return redirect()->route('platform.comments.list');
    }

    public function remove(Comment $comment)
    {
        $comment->delete()
            ? Alert::info('You have successfully deleted the article.')
            : Alert::warning('An error has occurred');
    }
}
