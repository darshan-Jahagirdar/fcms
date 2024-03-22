@extends('layouts.main')
@section('body-id', 'photoUpload')
@section('main-bg', 'bg-light')

@section('content')
<div class="p-5">

    <form>
        <div class="border rounded bg-white">
            <div class="d-flex flex-nowrap">
                <div class="uploader-sidebar col-auto border-end">
                    <ul class="p-5 list-unstyled">
                        <li class="d-inline-block rounded-5 border border-2 text-muted p-2 mx-2 text-center">1</li>
                        <li class="d-inline-block rounded-5 border border-2 text-muted p-2 mx-2 text-center">2</li>
                        <li class="d-inline-block rounded-5 border border-2 text-muted p-2 mx-2 text-center active">3</li>
                    </ul>
                    <div class="instructions text-center text-muted">
                        <img style="width: 90px;" src="{{ asset('img/photos.jpg') }}"/>
                        <p class="p-5 pt-1">
                            <b>{{ _gettext('Finishing Up') }}</b><br/>
                            {{ _gettext('Your photos have been uploaded successfully.  Feel free to tag people and add comments.') }}
                        </p>
                    </div>
                </div><!-- /.uploader-sidebar -->
                <div class="uploader-main col p-5">
                    <h5>{{ _gettext('Success') }}</h5>
                @foreach($album->photos as $photo)
                    <div class="d-flex p-3 border-bottom">
                        <div>
                            <img class="" src="{{ route('photo.thumbnail', ['id' => $photo->created_user_id, 'file' => $photo->filename]) }}">
                        </div>
                        <div class="ms-5 flex-grow-1">
                            <div class="mb-3">
                                <label for="comments" class="form-label">
                                    <i class="bi-chat-left-text-fill pe-2"></i>
                                    {{ _gettext('Caption') }}
                                </label>
                                <input type="text" class="form-control" name="caption[{{ $photo->id }}]" value="{{ old('caption[' . $photo->id . ']', $photo->caption) }}">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    <i class="bi-person-plus-fill pe-2"></i>
                                    {{ _gettext('Tag People') }}
                                </label>
                                <input type="text" class="form-control" name="tag[{{ $photo->id }}]" value="">
                            </div>
                        </div>
                    </div>
                @endforeach
                    <div class="uploader-footer d-flex justify-content-between mt-5">
                        <a href="#" class="next btn btn-primary px-4 text-white rounded-5">{{ _gettext('Finish') }}<i class="bi-chevron-compact-right ms-2"></i></a>
                    </div><!-- /.uploader-footer -->
                </div><!-- /.uploader-main -->
            </div>
        </div>

    </form>

</div>
@endsection
