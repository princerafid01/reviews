@extends('admin.base')

@section('section_title')
    <strong>Approved Reviews</strong>
@endsection

@section('section_body')



    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                <div class="box-body">
                    <div class="box-group" id="accordion">

                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                        aria-expanded="true" class="">Bulk Review Import</a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" aria-expanded="true" style="">
                                <div class="box-body">
                                    <form action="reviews/bulk-import" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="form-group">
                                            <input type="file" name="file" class="pull-left" style="padding-top: 7px"
                                                required>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                            <a href="{{ route('review.demo.export') }}" class="btn btn-success">Demo
                                                Excel file Download for importing</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"
                                        aria-expanded="true" class="">
                                        Pending Approval
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseTwo" class="panel-collapse collapse" aria-expanded="true" style="">
                                <div class="box-body">


                                    @if ($pending_reviews)
                                        <table class="table table-striped table-bordered table-responsive dataTable">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Reviewed Item</th>
                                                    <th>Reviewed By</th>
                                                    <th>Title</th>
                                                    <th>Content</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pending_reviews as $r)
                                                    <tr>
                                                        <td>
                                                            {!! $r->id !!}
                                                        </td>
                                                        <td>
                                                            {{ $r->site->url }}<br>
                                                            <a href="{{ route('reviewsForSite', ['site' => $r->site->url]) }}"
                                                                target="_blank">View Listing</a>
                                                        </td>
                                                        <td>
                                                            {{ $r->user->name ?? 'Admin' }}<br>
                                                            {{ $r->user->email ?? 'admin@admin.com' }}
                                                        </td>
                                                        <td>
                                                            {!! str_repeat('<i class="fa fa-star"></i>', $r->rating) !!}
                                                            <br>
                                                            {{ $r->review_title }}
                                                        </td>
                                                        <td>
                                                            {{ $r->review_content }}
                                                        </td>
                                                        <td>
                                                            {{ $r->created_at }}
                                                        </td>
                                                        <td>
                                                            <a href="/admin/reviews/approve/{{ $r->id }}">Approve</a>
                                                            <br>
                                                            <a href="/admin/reviews/edit/{{ $r->id }}">Edit</a>
                                                            <br>
                                                            <a href="/admin/reviews/delete/{{ $r->id }}"
                                                                onclick="return confirm('Are you sure?')">
                                                                Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        No pending reviews in database.
                                    @endif

                                </div>
                            </div>
                            <div class="panel box box-primary">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"
                                            aria-expanded="true" class="">
                                            Approved Companies
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse in" aria-expanded="true"
                                    style="">
                                    @if ($reviews)
                                        <table class="table table-striped table-bordered table-responsive review-datatable">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Reviewed Item</th>
                                                    <th>Reviewed By</th>
                                                    <th>Title</th>
                                                    <th>Content</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- @foreach ($reviews->take(100) as $r)
                                                    <tr>
                                                        <td>
                                                            {!! $r->id !!}
                                                        </td>
                                                        <td>
                                                            {{ @$r->site->url }}<br>
                                                            @if (@$r->site->url)
                                                            <a href="{{ route('reviewsForSite', ['site' => @$r->site->url]) }}"
                                                                target="_blank">View Listing</a>
                                                                @endif
                                                        </td>
                                                        <td>
                                                            {{ $r->user->name ?? 'Admin' }}<br>
                                                            {{ $r->user->email ?? 'admin@admin.com' }}
                                                        </td>
                                                        <td>
                                                            {!! str_repeat('<i class="fa fa-star"></i>', $r->rating) !!}
                                                            <br>
                                                            {{ $r->review_title }}
                                                        </td>
                                                        <td>
                                                            {{ $r->review_content }}
                                                        </td>
                                                        <td>
                                                            {{ $r->created_at }}
                                                        </td>
                                                        <td>
                                                            <br>
                                                            <a href="/admin/reviews/edit/{{ $r->id }}">Edit</a>
                                                            <br>
                                                            <a href="/admin/reviews/delete/{{ $r->id }}"
                                                                onclick="return confirm('Are you sure?')">
                                                                Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach --}}
                                            </tbody>
                                        </table>
                                    @else
                                        No pending reviews in database.
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    @endsection

    @section('admin_script')
        <script type="text/javascript">
            $(function() {

                var table = $('.review-datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('reviews.list') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'site_url',
                            name: 'site_url'
                        },
                        {
                            data: 'reviewed_by',
                            name: 'reviewed_by'
                        },
                        {
                            data: 'review_title',
                            name: 'review_title'
                        },
                        {
                            data: 'review_content',
                            name: 'review_content'
                        },
                        {
                            data: 'created_at',
                            name: 'created_at'
                        },
                        {
                            data: 'action',
                            name: 'action'
                        },
                    ]
                });

            });
        </script>
    @endsection
