@extends('template.base')

@section('page-title')
    Manage Meme Generator
@stop

@section('page-content')
    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Memes</h3>
          </div>{{-- /.panel-heading --}}
          <div class="grid-height">
            <div class="grid-loading-overlay hidden">
              <div class="grid-loading-overlay-content">
                <i class="fa fa-refresh fa-fw fa-spin"></i> Loading...
              </div>{{-- /.grid-loading-overlay-content --}}
            </div>{{-- /.grid-loading-overlay.hidden --}}
            <table class="table table-striped table-hover table-condensed row-pointers" id="memes-table">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Hidden</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
          <div class="panel-footer text-right padding-four">
            <div class="btn-group" role="group">
              <button type="button"
                      id="meme-btn-add"
                      class="btn btn-default btn-sm"
                      title="Create New Meme"
                      data-toggle="modal"
                      data-target="#meme-add-modal"
              >
                <i class="fa fa-file-o fa-fw"></i> Create
              </button>
              <button type="button"
                      id="meme-btn-edit"
                      class="btn btn-default btn-sm"
                      title="Edit Selected Meme"
                      data-toggle="modal"
                      data-target="#meme-edit-modal"
                      disabled
              >
                <i class="fa fa-edit fa-fw"></i> Edit
              </button>
              <button type="button"
                      id="meme-btn-delete"
                      class="btn btn-default btn-sm"
                      title="Delete Selected Meme"
                      data-toggle="modal"
                      data-target="#meme-delete-modal"
                      disabled
              >
                <i class="fa fa-trash fa-fw"></i> Delete
              </button>
            </div>{{-- /.btn-group --}}
          </div>{{-- /.panel-footer.text-right.padding-four --}}
        </div>{{-- /.panel.panel-default --}}
      </div>{{-- /.col-md-6 --}}
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Generated Memes</h3>
          </div>{{-- /.panel-heading --}}
          <div class="grid-height">
            <div class="grid-loading-overlay hidden">
              <div class="grid-loading-overlay-content">
                <i class="fa fa-refresh fa-fw fa-spin"></i> Loading...
              </div>{{-- /.grid-loading-overlay-content --}}
            </div>{{-- /.grid-loading-overlay.hidden --}}
            <table class="table table-striped table-hover table-condensed row-pointers" id="generated-memes-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Thumbnail</th>
                  <th>Created At</th>
                </tr>
              </thead>
              <tbody>{{--
                <tr data-row-id="{{ $meme['id'] }}">
                  <td>{{ $meme['id'] }}</td>
                  <td>
                    <img src="{{ $meme['thumbnail_data'] }}" />
                  </td>
                  <td>{{ $meme['created_at'] }}</td>
                </tr>
              --}}
              </tbody>
            </table>
          </div>
          <div class="panel-footer text-right padding-four">
            <button type="button"
                    id="generatedmeme-btn-delete"
                    class="btn btn-default btn-sm"
                    title="Delete Selected Meme(s)"
                    data-toggle="modal"
                    data-target="#generated-delete-modal"
                    disabled
            >
              <i class="fa fa-trash fa-fw"></i> Delete Selected
            </button>
          </div>{{-- /.panel-footer.text-right.padding-four --}}
        </div>{{-- /.panel.panel-default --}}
      </div>{{-- /.col-md-6 --}}
    </div>{{-- /.row --}}
@stop

@section('other-content')
    <div class="modal fade"
         id="meme-add-modal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="meme-add-modal-header"
         aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="meme-add-modal-header"><i class="fa fa-file-o fa-fw"></i> Create New Meme</h4>
          </div>{{-- /.modal-header.bg-primary --}}
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="meme-add-name">Name</label>
                    <input type="text" class="form-control" id="meme-add-name" />
                  </div>{{-- /.form-group --}}
                </div>{{-- /.col-md-12 --}}
              </div>{{-- /.row --}}
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="meme-add-toptemplate">Top Template Text</label>
                    <input type="text" class="form-control" id="meme-add-toptemplate" />
                  </div>{{-- /.form-group --}}
                </div>{{-- /.col-md-12 --}}
              </div>{{-- /.row --}}
              <div class="row">
                <div class="col-md-6 col-md-offset-3">
                  <div class="form-group">
                    <label>Image</label> (Drag image to box)<br />
                    <canvas id="meme-add-image" class="droppable-canvas"></canvas>
                    <img src="" class="meme-add-displayed-image hidden" id="meme-add-image-elem" />
                  </div>{{-- /.form-group --}}
                </div>{{-- /.col-md-6.col-md-offset-3 --}}
              </div>{{-- /.row --}}
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="meme-add-bottomtemplate">Bottom Template Text</label>
                    <input type="text" class="form-control" id="meme-add-bottomtemplate" />
                  </div>{{-- /.form-group --}}
                </div>{{-- /.col-md-12 --}}
              </div>{{-- /.row --}}
              <div class="row">
                <div class="col-md-9">
                  <div class="form-group">
                    <label for="meme-add-tags">Tags (space-separated)</label>
                    <input type="text" class="form-control" id="meme-add-tags" />
                  </div>{{-- /.form-group --}}
                </div>{{-- /.col-md-9 --}}
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="meme-add-hidden">Hidden</label>
                    <select id="meme-add-hidden" class="form-control">
                      <option value="f">False</option>
                      <option value="t">True</option>
                    </select>
                  </div>{{-- /.checkbox --}}
                </div>{{-- /.col-md-3 --}}
              </div>{{-- /.row --}}
            </div>{{-- /.container-fluid --}}
          </div>{{-- /.modal-body --}}
          <div class="modal-footer">
            <button type="button" class="btn btn-link" data-dismiss="modal">Cancel Changes</button>
            <button type="button" class="btn btn-primary" id="meme-add-modal-submit">
              <i class="fa fa-save fa-fw"></i> Create Meme
            </button>
          </div>{{-- /.modal-footer --}}
        </div>{{-- /.modal-content --}}
      </div>{{-- /.modal-dialog --}}
    </div>{{-- /.modal.fade --}}

    <div class="modal fade"
         id="meme-edit-modal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="meme-edit-modal-header"
         aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-warning">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="meme-edit-modal-header"><i class="fa fa-edit fa-fw"></i> Modify Meme</h4>
          </div>{{-- /.modal-header.bg-warning --}}
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="meme-edit-name">Name</label>
                    <input type="text" class="form-control" id="meme-edit-name" />
                  </div>{{-- /.form-group --}}
                </div>{{-- /.col-md-12 --}}
              </div>{{-- /.row --}}
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="meme-edit-toptemplate">Top Template Text</label>
                    <input type="text" class="form-control" id="meme-edit-toptemplate" />
                  </div>{{-- /.form-group --}}
                </div>{{-- /.col-md-12 --}}
              </div>{{-- /.row --}}
              <div class="row">
                <div class="col-md-12">
                  <p><label>Image</label></p>
                  <p class="text-center"><img src="" id="meme-edit-image" /></p>
                </div>{{-- /.col-md-12 --}}
              </div>{{-- /.row --}}
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="meme-edit-bottomtemplate">Bottom Template Text</label>
                    <input type="text" class="form-control" id="meme-edit-bottomtemplate" />
                  </div>{{-- /.form-group --}}
                </div>{{-- /.col-md-12 --}}
              </div>{{-- /.row --}}
              <div class="row">
                <div class="col-md-9">
                  <div class="form-group">
                    <label for="meme-edit-tags">Tags (space-separated)</label>
                    <input type="text" class="form-control" id="meme-edit-tags" />
                  </div>{{-- /.form-group --}}
                </div>{{-- /.col-md-9 --}}
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="meme-edit-hidden">Hidden</label>
                    <select id="meme-edit-hidden" class="form-control">
                      <option value="f">False</option>
                      <option value="t">True</option>
                    </select>
                  </div>{{-- /.checkbox --}}
                </div>{{-- /.col-md-3 --}}
              </div>{{-- /.row --}}
            </div>{{-- /.container-fluid --}}
          </div>{{-- /.modal-body --}}
          <div class="modal-footer">
            <button type="button" class="btn btn-link" data-dismiss="modal">Cancel Changes</button>
            <button type="button" class="btn btn-warning" id="meme-edit-submit-btn">
              <i class="fa fa-save fa-fw"></i> Save Changes
            </button>
          </div>{{-- /.modal-footer --}}
        </div>{{-- /.modal-content --}}
      </div>{{-- /.modal-dialog --}}
    </div>{{-- /.modal.fade --}}

    <div class="modal fade"
         id="meme-delete-modal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="meme-delete-modal-header"
         aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="meme-delete-modal-header"><i class="fa fa-trash fa-fw"></i> Delete Meme</h4>
          </div>{{-- /.modal-header.bg-danger --}}
          <div class="modal-body">
            <p>Are you sure you want to delete the meme &quot;<span id="meme-delete-msglabel"></span>&quot;?</p>
          </div>{{-- /.modal-body --}}
          <div class="modal-footer">
            <button type="button" class="btn btn-link" data-dismiss="modal">Cancel Changes</button>
            <button type="button" class="btn btn-danger" id="meme-delete-submit-btn">
              <i class="fa fa-trash fa-fw"></i> Delete Meme
            </button>
          </div>{{-- /.modal-footer --}}
        </div>{{-- /.modal-content --}}
      </div>{{-- /.modal-dialog --}}
    </div>{{-- /.modal.fade --}}
    
    <div class="modal fade"
         id="generated-delete-modal"
         tabindex="-1"
         role="dialog"
         aria-labelledby="generated-delete-modal-header"
         aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-danger">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="generated-delete-modal-header">
              <i class="fa fa-trash fa-fw"></i> Delete Generated Meme
            </h4>
          </div>{{-- /.modal-header.bg-danger --}}
          <div class="modal-body">
            <p>
              Are you sure you want to delete the generated meme with ID #
              <span id="generated-delete-msglabel"></span>?
            </p>
          </div>{{-- /.modal-body --}}
          <div class="modal-footer">
            <button type="button" class="btn btn-link" data-dismiss="modal">Cancel Changes</button>
            <button type="button" class="btn btn-danger" id="generated-delete-submit-btn">
              <i class="fa fa-trash fa-fw"></i> Delete Meme
            </button>
          </div>{{-- /.modal-footer --}}
        </div>{{-- /.modal-content --}}
      </div>{{-- /.modal-dialog --}}
    </div>{{-- /.modal.fade --}}
@stop

@section('page-js')
    <script type="text/javascript" src="{{ URL::asset('js/bs-enhanced-table.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/manage/memes.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/manage/generatedmemes.js') }}"></script>
@stop

@section('onload')
    $('#meme-nav-manage').addClass('active');
    manageMemes.init();
    manageGeneratedMemes.init();
@stop
