@extends("admin.layouts.app")

@section('page-title')
    <section class="content-header">
        <h1><i class="glyphicon glyphicon-text-background"></i> Chi tiết </h1>
        <div class="breadcrumb">
            <a class="btn btn-primary btn-sm" href="{{ route('admin.contact.index') }}" role="button">
                <span class="glyphicon glyphicon-remove do_nos"></span> Thoát
            </a>
        </div>
    </section>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box" id="view">
                    <div class="box-body">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label>Họ và tên <span class="maudo"></span></label>
                                <output type="text" class="form-control"
                                        style="width:100%">{{ data_get($contact, 'name') }}</output>
                            </div>
                            <div class="form-group">
                                <label>SDT <span class="maudo"></span></label>
                                <output type="text" class="form-control"
                                        style="width:100%">{{ data_get($contact, 'phone') }}</output>

                            </div>
                            <div class="form-group">
                                <label>Email <span class="maudo"></span></label>
                                <output type="text" class="form-control"
                                        style="width:100%">{{ data_get($contact, 'email') }}</output>
                            </div>
                            <div class="form-group">
                                <label>Tiêu đề</label>
                                <output type="text" class="form-control"
                                        style="width:100%">{{ data_get($contact, 'title') }}</output>
                            </div>
                            <div class="form-group">
                                <label>Nội dung mail<span class="maudo"></span></label>
                                <textarea rows="10" cols="20"
                                          style="width:100% ;height:100%" id="content"
                                          class="form-control">{{ data_get($contact, 'content') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection


