@extends('layouts.main')
@section('body-id', 'photoUpload')
@section('main-bg', 'bg-light')

@section('content')
<div class="p-5">

    <form>
        <div class="border rounded bg-white">
            <div class="tab-content">

                <div class="tab-pane fade show active" id="album-pane" role="tabpanel" tabindex="0">
                    <div class="d-flex flex-nowrap">
                        <div class="uploader-sidebar col-auto border-end">
                            <ul class="p-5 list-unstyled">
                                <li class="d-inline-block rounded-5 border border-2 text-muted p-2 mx-2 text-center active">1</li>
                                <li class="d-inline-block rounded-5 border border-2 text-muted p-2 mx-2 text-center">2</li>
                                <li class="d-inline-block rounded-5 border border-2 text-muted p-2 mx-2 text-center">3</li>
                            </ul>
                            <div class="instructions text-center text-muted">
                                <img style="width: 90px;" src="{{ asset('img/albums.jpg') }}"/>
                                <p class="p-5 pt-1">
                                    <b>{{ _gettext('Album') }}</b><br/>
                                    {{ _gettext('Upload your photos to a new or existing album') }}
                                </p>
                            </div>
                        </div><!-- /.uploader-sidebar -->
                        <div class="uploader-main col p-5">
                            <h5>{{ _gettext('Album') }}</h5>
                            <div class="mb-3 required">
                                <label for="title" class="form-label">{{ _gettext('Name') }}</label>
                                <input type="text" class="form-control" id="album-name" name="album-name" value="{{ old('album-name') }}">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">{{ _gettext('Description') }}</label>
                                <textarea class="form-control" id="album-description" name="album-description" value="{{ old('album-description') }}"></textarea>
                            </div>
                        @if ($albums->isNotEmpty())
                            <p class="text-center">-- or --</p>
                            <div class="mb-3 required">
                                <label for="title" class="form-label">{{ _gettext('Existing Album') }}</label>
                                <select class="form-select" id="album-id" name="album-id">
                                    <option></option>
                                @foreach ($albums as $album)
                                    <option value="{{ $album->id }}">{{ $album->name }}</option>
                                @endforeach
                                </select>
                            </div>
                        @endif
                            <div class="uploader-footer d-flex justify-content-end mt-5">
                                <a href="#" class="next btn btn-primary px-4 text-white rounded-5">
                                    {{ _gettext('Next') }}<i class="bi-chevron-compact-right ms-2"></i>
                                </a>
                            </div><!-- /.uploader-footer -->
                        </div><!-- /.uploader-main -->
                    </div>
                </div><!-- /#album-pane -->

                <div class="tab-pane fade" id="photos-pane" role="tabpanel" tabindex="0">
                    <div class="d-flex flex-nowrap">
                        <div class="uploader-sidebar col-auto border-end">
                            <ul class="p-5 list-unstyled">
                                <li class="d-inline-block rounded-5 border border-2 text-muted p-2 mx-2 text-center">1</li>
                                <li class="d-inline-block rounded-5 border border-2 text-muted p-2 mx-2 text-center active">2</li>
                                <li class="d-inline-block rounded-5 border border-2 text-muted p-2 mx-2 text-center">3</li>
                            </ul>
                            <div class="instructions text-center text-muted">
                                <img style="width: 90px;" src="{{ asset('img/photos.jpg') }}"/>
                                <p class="p-5 pt-1">
                                    <b>{{ _gettext('Upload Photos') }}</b><br/>
                                    {{ _gettext('Choose 1 or more photos to upload') }}
                                </p>
                            </div>
                        </div><!-- /.uploader-sidebar -->
                        <div class="uploader-main col p-5">
                            <h5>{{ _gettext('Photos') }}</h5>
                            <div class="photo-area alert alert-info text-center">
                                <p class="mb-1">
                                    <a class="fs-5 text-decoration-none d-block" href="#">
                                        <i class="bi-cloud-arrow-up fs-1 d-block"></i>
                                        {{ _gettext('Select photos to upload') }}
                                    </a>
                                </p>
                                <p class="fs-6"><small>{{ _gettext('or drag and drop it here') }}</small></a>
                                <input type="file" class="d-none" id="photo-picker" multiple accept="image/*">
                            </div>
                            <ul id="photo-list" class="list-unstyled">
                                <li class="template p-3 my-2 border">
                                    <button type="button" class="btn-close float-end" aria-label="{{ _gettext('Close') }}"></button>
                                    <div class="d-flex align-items-center">
                                        <div class="preview" style="height:150px; width:150px;">
                                        </div>
                                        <div class="ms-3 flex-grow-1">
                                            <p class="mb-1 name"><b></b></p>
                                            <div class="progress" style="height:5px">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div id="upload-progress" class="progress d-none">
                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div class="uploader-footer d-flex justify-content-between mt-5">
                                <a href="#" class="prev btn btn-outline-secondary px-4 rounded-5"><i class="bi-chevron-compact-left me-2"></i>{{ _gettext('Previous') }}</a>
                                <a href="#" class="upload btn btn-primary px-4 text-white rounded-5 d-none">{{ _gettext('Upload') }}<i class="bi-cloud-arrow-up ms-2"></i></a>
                            </div><!-- /.uploader-footer -->
                        </div><!-- /.uploader-main -->
                    </div>
                </div><!-- /#photos-pane -->

            </div><!-- /.tab-content -->
        </div>

    </form>

<script>
$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        }
    });

    // From Step 1 -> Step 2 (Album)
    $('#album-pane .uploader-footer > a.next').click(function(e) {
        e.preventDefault();
        $('.tab-pane').removeClass('show active');
        $('#photos-pane').addClass('show active');
    });

    // From Step 2 -> Step 1 (Upload)
    $('#photos-pane .uploader-footer > a.prev').click(function(e) {
        e.preventDefault();
        $('.tab-pane').removeClass('show active');
        $('#album-pane').addClass('show active');
    });

    // Upload
    $('#photos-pane .uploader-footer > a.upload').click(function(e) {
        e.preventDefault();

        $('#upload-progress').removeClass('d-none');
        $('.photo-area').addClass('d-none');

        uploadPhotos();
    });

    // some globals for the uploader
    let formData;
    let lastAlbumId;
    let url;

    async function uploadPhotos()
    {
        let photoPicker = $('#photo-picker')[0];
        let totalFiles  = photoPicker.files.length;
        let finished    = 0;

        for (var index = 0; index < totalFiles; index++) {
            formData = new FormData();

            if (index == 0)
            {
                formData.append("album-name", $('#album-name').val());
                formData.append("album-description", $('#album-description').val());

                if ($('#album-id').length)
                {
                    if ($('#album-id').val() !== '')
                    {
                        formData.append("album-id", $('#album-id').val());
                    }
                }
            }
            else
            {
                formData.append('album-id', lastAlbumId);
            }

            // Set the next photo for uploading
            formData.append("photo", photoPicker.files[index]);

            let result = await uploadPhoto(index, formData);

            finished++;

            // show the total upload progress
            let percentage = (finished / totalFiles) * 100;
            $('#upload-progress .progress-bar').width(percentage + '%');
        }

        // From Step 2 -> Step 3 (Comments)
        window.location.href = url;
    }

    async function uploadPhoto(index, formData)
    {
        return await
            $.ajax({
                url         : '{{ route('photos.create') }}',
                type        : 'post',
                data        : formData,
                dataType    : 'json',
                enctype     : 'multipart/form-data',
                processData : false,
                contentType : false
        }).then(
            // success
            function(data) {
                $('li.index-'+index+' .progress-bar').width('100%');
                lastAlbumId = data.album.id;
                url = data.album.url;
            // failure
            }, function(data) {
                $('li.index-'+index+' .progress-bar').addClass('bg-danger');
            }
        );
    }

    // Open the file picker
    $('.photo-area a').click(function(e) {
        e.preventDefault();
        $('#photo-picker').trigger('click');
    });

    $('#photo-picker').on('change', function() {
        let input   = this;
        let $output = $('#photo-list');

        if (input.files)
        {
            $('#photos-pane .uploader-footer > a.upload').removeClass('d-none');

            let totalFiles = input.files.length;

            for (i = 0; i < totalFiles; i++)
            {
                let filename = input.files[i].name;

                let $li = $('#photo-list > li.template').clone();

                $li.removeClass('template');
                $li.addClass('index-'+i);

                let reader = new FileReader();

                reader.onload = function(event)
                {
                    let img = document.createElement('img');
                    img.src = event.target.result;
                    img.classList.add('object-fit-cover');
                    img.classList.add('h-100');
                    img.classList.add('w-100');

                    $li.find('.name > b').text(filename);
                    $li.find('div.preview').append(img);
                    $output.append($li);
                }

                reader.readAsDataURL(input.files[i]);
            }
        }
    });
});
</script>

</div>
@endsection
