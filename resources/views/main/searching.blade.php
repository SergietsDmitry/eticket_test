@extends('layouts.base')

@section('content')

<div class="container">
    <div class="jumbotron">
        <p>
        Поиск авиабилетов
        <i class="fa fa-cog fa-spin fa-1x fa-fw"></i>
        <span class="sr-only">Loading...</span>
        </p>
    </div>
    
    <div>
        <table class="table">
            <tbody>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Actions</th>
            </tr>
            {{--
            @foreach ($blocks as $block)
                <tr>
                    <td>{{ $block->id }}</td>
                    <td>{{ $block->name }}</td>
                    <td>{{ $block->type->name }}</td>
                    <td>
                        {{ link_to('/?c=editblock&id=' .  $block->id, 'Edit', array('class="btn btn-primary"')) }}
                        {{ link_to('/delete_block/' . $block->id, 'Delete', array('class' => "btn btn-danger",
                            'data-method' => "delete", 'data-token' =>  csrf_token())) }}
                    </td>
                </tr>
            @endforeach
            --}}
            </tbody>
        </table>
    </div>
</div>

<div id="ui-ajax-request" data-fail-url="{{route('index')}}" data-url="{{route('get.search.result', ['request_id' => $request_id])}}"></div>

@endsection

@section('javascript')
    <script type="text/javascript">
        
        function runAjaxRequest($url, $fail_url) {
            $.ajax({
                url: $url,
                dataType: 'json',
                method: 'POST'
            }).done(function($data) {
                console.log($data);
                if ($data['status'] == 'error')
                {
                    window.location = $fail_url;
                }

            }).fail(function(jqXHR, textStatus, errorThrown) {
                window.location = $fail_url;
            });
        }
        
        $(document).ready(function () {
            
            $success_url = $('#ui-ajax-request').attr('data-success-url');
            $fail_url    = $('#ui-ajax-request').attr('data-fail-url');
            $url         = $('#ui-ajax-request').attr('data-url');
            
            runAjaxRequest($url, $fail_url);
        });
        
    </script>
@append