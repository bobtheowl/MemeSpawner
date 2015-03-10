@extends('template.base')

@section('page-title')
    Spawn Memes
@stop

@section('navbar-right')
    <ul class="nav navbar-nav navbar-right">
      <li id="meme-create-blank"><a href="#" data-toggle="modal" data-target="#meme-modal">
        <i class="fa fa-file-o fa-fw"></i> Create Blank Meme
      </a></li>
    </ul>
    <form class="navbar-form navbar-right" role="search">
      <div class="input-group">
        <span class="input-group-addon">
          <i class="fa fa-search fa-fw"></i>
        </span>
        <input type="text" class="form-control" id="search-input" placeholder="Search" />
        <span class="input-group-btn">
          <button class="btn btn-default" type="reset" title="Clear Search" id="meme-search-reset">
            <i class="fa fa-times fa-fw"></i>
          </button>
        </span>
      </div>{{-- /.form-group --}}
    </form>
@stop

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/fakesite.css') }}" />
@stop

@section('page-content')
    <div class="row">
    @foreach ($memes as $meme)
<?php
    $tagString = [];
    foreach ($meme['tags'] as $tag) {
        $tagString[] = $tag['name'];
    }//end foreach
    $tagString = implode(' ', $tagString);
?>
      <div class="col-md-2 meme-container">
        <button type="button"
                class="btn btn-default btn-meme"
                title="{{ $meme['name'] }}"
                data-meme-id="{{ $meme['id'] }}"
                data-meme-tags="{{ $tagString }}"
        >
          <div class="meme-btn-image-container">
            <img src="{{ $meme['thumbnail_data'] }}" />
          </div>
        </button>
      </div>{{-- /.col-md-2 --}}
    @endforeach
    </div>{{-- /.row --}}
    <div class="row hidden" id="meme-hidden-row">
    @foreach ($hidden as $meme)
<?php
    $tagString = [];
    foreach ($meme['tags'] as $tag) {
        $tagString[] = $tag['name'];
    }//end foreach
    $tagString = implode(' ', $tagString);
?>
      <div class="col-md-2 meme-container">
        <button type="button"
                class="btn btn-warning btn-meme"
                title="{{ $meme['name'] }}"
                data-meme-id="{{ $meme['id'] }}"
                data-meme-tags="{{ $tagString }}"
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
    <div class="modal fade" id="meme-modal">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label class="sr-only" for="meme-top-text">Meme Top Text</label>
              <input type="text" class="form-control" id="meme-top-text" placeholder="Meme Top Text">
            </div>
            <p class="text-center"><canvas id="meme-image"></canvas></p>
            <div class="form-group">
              <label class="sr-only" for="meme-bottom-text">Meme Bottom Text</label>
              <input type="text" class="form-control" id="meme-bottom-text" placeholder="Meme Bottom Text">
            </div>
          </div>
          <div class="modal-footer clearfix">
            <div class="pull-left">
              <div class="btn-group" data-toggle="buttons">
                <label class="btn btn-primary active">
                  <input type="radio" name="text-color" id="text-color-white" checked> White Text
                </label>
                <label class="btn btn-primary">
                  <input type="radio" name="text-color" id="text-color-black"> Black Text
                </label>
              </div>
            </div>
            <div class="pull-right">
              <button type="button" class="btn btn-default" data-dismiss="modal">
                <i class="glyphicon glyphicon-remove"></i> Close
              </button>
              <button type="button" class="btn btn-primary" id="save-meme">
                <i class="glyphicon glyphicon-ok"></i> Generate
              </button>
            </div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    
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
    <script type="text/javascript" src="{{ URL::asset('js/plugins/konami/konami.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/meme-object.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/fakesite.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/viewer.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/generator.js') }}"></script>
@stop

@section('onload')
    $('#meme-nav-generator').addClass('active');
    //fakesite.init();
    viewer.init();
    generator.init();
@stop
