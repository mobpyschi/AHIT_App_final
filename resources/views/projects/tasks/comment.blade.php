@foreach ($comments as $comment)
    <div class="display-comment" @if ($comment->parent_id != null) style="margin-left:20px;" @endif>

        <div class="media mb-1">
            <div class="d-flex mr-3">
                <a href="#"> <img class="media-object rounded-circle avatar-sm" alt="64x64"
                        src="/images/users/{{ $comment->user->avatar }}">
                </a>
            </div>
            <div class="media-body">
                <h5 class="font-15 mt-0 mb-0">{{ $comment->user->name }}</h5>
                <p class="font-15 text-muted mb-1">
                    <a href="" class="text-primary"></a>
                    {{ $comment->body }} .
                </p>
                {{-- <a href="" class="text-success font-13">Reply</a> --}}
                <form method="post" action="{{ route('comments.store') }}">
                    @csrf
                    <div class="form-group">
                        <input type=text name=body class="form-control" placeholder="reply">
                        <input type=hidden name=project_id value="{{ $project_id }}">
                        <input type=hidden name=parent_id value="{{ $comment->id }}">
                    </div>
                    <input type=submit class="btn btn-warning btn-xs" value="Reply">
                </form>
                @include('projects.tasks.comment', ['comments' => $comment->replies])
            </div>
        </div>

    </div>
@endforeach
