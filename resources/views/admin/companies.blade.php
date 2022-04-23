@extends('admin.base')

@section('section_title')
    <strong>Companies</strong>
@endsection

@section('section_body')



    <div class="row">
        <div class="col-md-12">
            <div class="box box-solid">
                {{-- <div class="box-header with-border">
                    <h3 class="box-title">Companies</h3>
                </div> --}}

                <div class="box-body">
                    <div class="box-group" id="accordion">

                        <div class="panel box box-primary">
                            <div class="box-header with-border">
                                <h4 class="box-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                                        aria-expanded="true" class="">
                                        Bulk Company Import
                                    </a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse" aria-expanded="true" style="">
                                <div class="box-body">
                                    <form action="companies/bulk-import" method="post" enctype="multipart/form-data">
                                        {!! csrf_field() !!}
                                        <div class="form-group">
                                            <input type="file" name="file" class="pull-left" style="padding-top: 7px" required>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                            <a href="{{ route('company.demo.export') }}" class="btn btn-success">Demo Excel file Download for importing</a> 
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
                                    @if ($pending_companies)
                                        <table class="table table-striped table-bordered table-responsive dataTable">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>URL</th>
                                                    <th>Name</th>
                                                    <th>Submitted By</th>
                                                    <th>Location</th>
                                                    <th>Date</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pending_companies as $c)
                                                    <tr>
                                                        <td>
                                                            {!! $c->id !!}
                                                        </td>
                                                        <td>
                                                            {{ $c->url }}<br>
                                                            <a href="http://{{ $c->url }}" target="_blank">View
                                                                Site</a> |
                                                            <a href="{{ route('reviewsForSite', ['site' => $c->id]) }}"
                                                                target="_blank">View
                                                                Listing</a>
                                                        </td>
                                                        <td>
                                                            {{ $c->business_name }}<br>
                                                            Category: {{ @$c->categories->first()->name }}
                                                        </td>
                                                        <td>
                                                            {{ $c->submitter->name }}<br>
                                                            {{ $c->submitter->email }}
                                                        </td>
                                                        <td>
                                                            {{ $c->location }}
                                                        </td>
                                                        <td>
                                                            {{ $c->created_at }}
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="/admin/companies/approve/{{ $c->id }}">Approve</a>
                                                            <br>
                                                            <a href="/admin/companies/delete/{{ $c->id }}"
                                                                onclick="return confirm('Are you sure?')">
                                                                Delete
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        No pending companies in database.
                                    @endif

                                </div>
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
                            <div id="collapseThree" class="panel-collapse collapse in" aria-expanded="true" style="">
                                @if ($companies)
                                    <table class="table table-striped table-bordered table-responsive dataTable">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>URL</th>
                                                <th>Name</th>
                                                <th>Claimed</th>
                                                <th>Location</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($companies as $c)
                                                <tr>
                                                    <td>
                                                        {!! $c->id !!}
                                                    </td>
                                                    <td>
                                                        {{ $c->url }}<br>
                                                        <a href="http://{{ $c->url }}" target="_blank">View Site</a>
                                                        |
                                                        <a href="{{ route('reviewsForSite', ['site' => $c->url]) }}"
                                                            target="_blank">View Listing</a>
                                                    </td>
                                                    <td>
                                                        {{ $c->business_name }}<br>
                                                        Category: {{ @$c->categories->first()->name }}
                                                    </td>
                                                    <td>
                                                        @if ($c->claimer()->exists())
                                                            {{ $c->claimer->name }}<br>
                                                            {{ $c->claimer->email }}
                                                        @else
                                                            Not Claimed
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $c->location }}
                                                    </td>
                                                    <td>
                                                        {{ $c->created_at }}
                                                    </td>
                                                    <td>
                                                        <a href="/admin/companies/edit/{{ $c->id }}">Edit</a>
                                                        <br>
                                                        <a href="/admin/companies/delete/{{ $c->id }}"
                                                            onclick="return confirm('Are you sure you want to remove this company and all its reviews?')">Delete</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    No approved companies in database.
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
