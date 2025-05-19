@extends('layouts.app')

@section('title', 'All Member List || ' . env('APP_NAME'))

@section('extra_css')
    <style>
        .info-box-member {
            gap: 16px;
            display: flex;
            flex-direction: column;
        }

        .info-box-member:hover {
            transition: 500ms all ease;
            box-shadow: 0px 4px 14px #1c294d55;
        }

        .member-profile-img {
            width: 75px;
            aspect-radio: 1/1;
            object-fit: cover;
        }
    </style>
@endsection

@section('content')
    <section class="search-bar">
        <div class="container">
            <div class="cart">
                <div class="card-body">
                    <div class="form-body">
                        <form action="{{ route('frontend.member.filter', ['id' => $id, 'category_name' => $category_name]) }}" method="GET">
                            <fieldset>
                                <legend>Search a member</legend>
                                <div class="row">
                                    <div class="col-12">
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Search By Name/Position/Member ID" value="{{ request('name') }}">
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- all members list -->
    <section class="all-member p-0">
        <div class="container">
            <div class="row justify-content-center" id="memberList">
                @foreach ($people as $item)
                    @include('frontend.member.member_card', ['item' => $item])
                @endforeach
            </div>
        </div>
    </section>
@endsection

@section('extra_js')
    <script>        
        $(document).ready(function () {
            $('#name').on('input', function (e) {
                e.preventDefault();
                
                let searchQuery = $('#name').val();
                let categoryId = "{{ $id }}";
                let categoryName = "{{ $category_name }}";

                $.ajax({
                    url: "{{ route('frontend.filter.member') }}",
                    type: "GET",
                    data: {
                        name: searchQuery,
                        id: categoryId,
                        category_name: categoryName,
                    },
                    success: function (response) {
                        $('#memberList').html(response);
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
@endsection
