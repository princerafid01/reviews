@extends('admin.base')

@section('section_title')
    <strong>Categories Overview</strong>
@endsection

@section('section_body')
    <div class="row">
        <div class="col-xs-12 col-md-6">
            @if (empty($catname))
                <form method="POST" action="/admin/add_category">
                @else
                    <form method="POST" action="/admin/update_category">
                        <input type="hidden" name="catID" value="{{ $catID }}">
                        Category Name:
            @endif
            {!! csrf_field() !!}
            <input type="text" name="catname" value="{{ $catname }}" class="form-control">
            <br />
            <input type="submit" name="sb" value="Save Category" class="btn btn-primary">
            </form>
        </div><!-- /.col-xs-12 col-md-6 -->
    </div><!-- /.row -->

    <br />
    <hr />

    @if ($main_categories)
        <table class="table table-striped table-bordered table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Category</th>
                    <th>Companies</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($main_categories as $c)
                    <tr>
                        <td>
                            {!! $c->id !!}
                        </td>
                        <td>
                            {{ $c->name }}
                        </td>
                        <td>
                            {{-- {{ $c->entries(\App\Sites::class)->count() }} --}}
                            0
                        </td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-primary btn-xs" href="/admin/categories?update={!! $c->id !!}">
                                    <i class="glyphicon glyphicon-pencil"></i>
                                </a>
                                <a href="/admin/categories?remove={!! $c->id !!}"
                                    onclick="return confirm('IMPORTANT! Any descendant that category has will also be deleted!');"
                                    class="btn btn-danger btn-xs">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </a>

                                <a href="#" type="button" data-toggle="modal" class="btn btn-info btn-xs"
                                    data-target={{ "#modal-default{$c->id}" }}>
                                    Sub Categories
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        No categories in database.
    @endif

    @foreach ($main_categories as $c)
        <div class="modal fade in" id={{ "modal-default{$c->id}" }} {{-- style="display: block; padding-right: 15px;" --}}>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title">Category: {{ $c->name }}</h4>
                    </div>
                    <div class="modal-body">
                        <table class="table table-striped">
                            <tbody id="wrapper-group">
                                <tr>
                                    <th style="width: 30%">Sub Categories</th>
                                    <th style="width: 70%">Sub Sub Categories(Put Comma between)</th>
                                </tr>
                                @foreach ($c->children as $sub_cat)
                                    <tr class="reusable-group">
                                        <td>
                                            <input class="form-control" type="text" placeholder="Sub Categories"
                                                value="{{ $sub_cat->name }}">
                                        </td>
                                        <td>

                                            @if (!$sub_cat->children->isEmpty())
                                                <input class="form-control subCat" type="text"
                                                    placeholder="Sub Sub Categories"
                                                    value="{{ implode(',', $sub_cat->children->pluck('name')->toArray()) }}"
                                                    data-id="{{ implode(',', $sub_cat->children->pluck('id')->toArray()) }}"
                                                    data-role="tagsinput">
                                            @else
                                                <input class="form-control subCat" type="text"
                                                    placeholder="Sub Sub Categories" value="" data-role="tagsinput">
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="close" data-catid={{ $sub_cat->id }}
                                                id="deleteSubCategory">
                                                <span>×</span>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                {{-- <tr class="reusable-group">
                                    <td>
                                        <input class="form-control" type="text" placeholder="Sub Categories">
                                    </td>
                                    <td>
                                        <input class="form-control subCat" type="text" placeholder="Sub Sub Categories">
                                    </td>
                                    <td>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span></button>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary" id="addInput"> <i class="fa fa-plus"></i></button>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="subCategoryFormSubmit"
                            data-id={{ $c->id }}>Save changes</button>
                    </div>
                </div>

            </div>

        </div>
    @endforeach
@endsection



@section('admin_style')
    <link rel="stylesheet" href={{ asset('resources/assets/admin/plugins/bootstarp-tags/css/bootstrap-tagsinput.css') }}>
@endsection

@section('admin_script')
    <script src="{{ asset('resources/assets/admin/plugins/bootstarp-tags/js/bootstrap-tagsinput.min.js') }}"></script>

    <script>
        var adder = `<tr class="reusable-group">
                <td>
                    <input class="form-control" type="text" placeholder="Sub Categories">
                </td>
                <td>
                    <input class="form-control subCat subCatNew" type="text" placeholder="Sub Sub Categories">
                </td>
                <td>
                    <button type="button" class="close" id="newCatDelete">
                        <span>×</span>
                    </button>
                </td>
        </tr>`;


        $("input.subCat").tagsinput({
            trimValue: true
        });

        // On add click on modal
        $('.modal  #addInput').click(function() {
            const element = $('.modal[aria-hidden="false"] #wrapper-group');
            var cloned = $('.modal[aria-hidden="false"] .reusable-group');
            element.append(adder);
            $("input.subCatNew").tagsinput({
                trimValue: true
            });
            $('#newCatDelete span').click(function() {
                $(this).parent().parent().parent().remove();
            });
        });

        $('input.subCat').on('beforeItemRemove', function(event) {
            const confirmBox = confirm('Are you sure to delete Sub Sub Category?');
            if (confirmBox) {
                var tag = event.item;
                const targetValue = event.currentTarget.value.trim().split(',');
                const targetIds = event.currentTarget.dataset.id.trim().split(',');
                var id = '';
                targetValue.map((item, index) => {
                    if (item === tag) {
                        id = Number(targetIds[index])
                    }
                    return item;
                });

                if (id) {
                    location.href = `${location.origin}/admin/delete_category/${id}`;
                }

            } else {
                event.cancel = true;
            }
        });

        $('#deleteSubCategory span').click(function() {
            const confirmBox = confirm('Are you sure to delete the whole Sub Catetgory and Sub Sub Category?');
            if (confirmBox) {
                var id = $(this).parent().data('catid')
                if (id) {
                    location.href = `${location.origin}/admin/delete_sub_category/subsubcat/${id}`;
                }
            }
        });





        // On submit
        $('.modal #subCategoryFormSubmit').click(function() {
            var data = [];
            $('.modal[aria-hidden="false"] .reusable-group').each(function(index, elem) {
                var inputs = $(elem).find('input');
                var anotherInput = $(elem).find('input.subCat');

                if (inputs[0].value !== '') {
                    data.push({
                        [inputs[0].value]: anotherInput[0].value
                    });
                }
            });


            $.ajax({
                url: '/admin/subcategories',
                type: 'post',
                data: {
                    subcategory_data: data,
                    category_id: $(this).data('id')
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
                },
                success: function(data, status, xhr) {
                    if (status === 'success') {
                        alert('Sub Categories Data have been Saved Succesfully');
                        location.reload();
                    }
                }
            });
        });
    </script>
@endsection
