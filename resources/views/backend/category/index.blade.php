@extends('backend.layouts.main')

@section('content')

    <section class="content">
        <div class="row">
            <div class="col-md-12">
        <div class="box">
          <div class="box-header with-border">
            <h3 class="box-title">Danh sach category</h3>
            <td>
                <a href="{{route('admin.category.create')}}" class="btn btn-primary pull-right">Thêm mới</a>
            </td>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
        <table class="table table-bordered">
            <tr>
                <th style="width: 10px">TT</th>
                <th>Hinh anh</th>
                <th>Tên</th>
                <th>Danh mục cha</th>
                <th>Trạng thái</th>
                <th>Sắp xếp</th>
                <th>Hàng động</th>
            </tr>
        @foreach ($category as $key => $item )
            <tr class="item-{{$item->id}}">
                <td>{{$key + 1}}</td>
                <td>
                    @if ($item->image && is_file(public_path($item->image)) )
                        <img src="{{asset($item->image)}}" width="100px" height="75px" alt="">
                    @else
                        <img src="{{asset('upload/category/1658714085_123.jpg')}}"width="100px" height="75px" alt="">
                    @endif
                </td>
                <td>
                    {{$item->name}}
                </td>
                <td>
                    {{$item->parent_id > 0 ? @$item->parent->name : ''}}
                    {{-- {{$item->parent_id > 0 ? data_get($item->parent, 'name') : ''}} --}}
                </td>
                <td>
                 {!! $item->is_active == 1 ? '<span class="badge bg-green">ON</span>' : '<span class="badge bg-red">OFF</span>' !!}
                </td>
                <td>
                    {{$item->position}}
                </td>
                <td>
                    <a href="{{ route('admin.category.edit' ,['category' => $item->id]) }}"><span title="Chỉnh sửa" type="button" class="btn btn-flat btn-primary"><i class="fa fa-edit"></i></span></a>
                    <span data-id="{{ $item->id }}" data-url="{{route('admin.category.destroy', $item->id)}}" title="Xóa" class="btn btn-flat btn-danger deleteItem"><i class="fa fa-trash"></i></span>
                </td>
            </tr>
        @endforeach
        </table>
          </div>
          <!-- /.box-body -->
          <div class="box-footer clearfix">
            <ul class="pagination pagination-sm no-margin pull-right">
              <li><a href="#">«</a></li>
              <li><a href="#">1</a></li>
              <li><a href="#">2</a></li>
              <li><a href="#">3</a></li>
              <li><a href="#">»</a></li>
            </ul>
          </div>

      </div>
    </div>
    <!-- /.row -->
  </section>
@endsection

@section('js')
    <script type="text/javascript">
        $( document ).ready(function() {
            CKEDITOR.replace( 'description' );

            $('.deleteItem').click(function () {
                var id = $(this).attr('data-id');
                var url = $(this).attr('data-url');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                    url : url,
                    type: 'DELETE',
                    data: {},
                    success: function (res) {
                        if(res ==1 ) {
                            $('.item-'+id).remove();
                            alert('Bạn đã xoá thành công')
                        } else {
                            alert('Không tìm thấy id')
                        }
                    },
                });
            }
        })
    });
});
    </script>
@endsection

