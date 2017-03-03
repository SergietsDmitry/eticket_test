@extends('layouts.base')

@section('content')

<div class="container">
    <div class="row">
        <h1>{{$title}}</h1>
        <br>
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
        <br>
        {{ Form::open( array(
            'route'  => 'search.flight',
            'method' => 'post',
            'id'     => 'ui-form-add-block',
            'class'  => 'form-inline'
        ) ) }}
        <div class="form-group">
            {{ Form::text('name', '', array(
                'id'          => 'ui-block-name',
                'placeholder' => 'Name',
                'maxlength'   => 255,
                'required'    => true,
                'class'       => 'form-control'
            ) ) }}
        </div>

        {{ Form::submit( 'Add', array(
            'id'    => 'ui-add-block-btn',
            'class' => 'btn btn-success'
        ) ) }}

        {{ Form::close() }}
    </div>
</div>

@endsection