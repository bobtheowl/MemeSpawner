@extends('template.base')

@section('page-title')
    View Memes
@stop

@section('page-content')
    <div class="row">
    @foreach ($memes as $meme)
      <div class="col-md-2 meme-container">
        <button type="button"
                class="btn btn-default btn-generated"
                title="Meme #{{ $meme['id'] }} generated on {{ $meme['created_at'] }}"
                data-meme-id="{{ $meme['id'] }}"
        >
          <div class="meme-btn-image-container">
            <img src="{{ $meme['thumbnail_data'] }}" />
          </div>
        </button>
      </div>{{-- /.col-md-2 --}}
    @endforeach
    </div>{{-- /.row --}}
@stop

@section('other-content')
    <div class="modal fade" id="view-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">Meme Image</h4>
          </div>
          <div class="modal-body">
            <p class="text-center"><img id="meme-image-display" src="" /></p>
            <p class="text-center"><a href="" id="meme-image-link"></a></p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">
              <i class="glyphicon glyphicon-remove"></i> Close
            </button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@stop

@section('page-js')
    <script type="text/javascript" src="{{ URL::asset('js/viewer.js') }}"></script>
@stop

@section('onload')
    $('#meme-nav-viewer').addClass('active');
    viewer.init();
@stop
