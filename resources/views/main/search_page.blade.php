@extends('layouts.base')

@section('content')

<div class="container">
    @include('flash::message')
    <div class="row">
        <h1>{{$title}}</h1>
        <br>
        <br>
        
        {{ Form::open( array(
            'route'  => 'get.search.id',
            'method' => 'post',
            'id'     => 'ui-form-add-block',
            'class'  => 'form-inline'
        ) ) }}
        
            <div class="row">
                {{ Form::date('departure_datetime', date('Y-m-d'), array(
                    'id'          => 'ui-block-name',
                    'placeholder' => 'Departure datetime',
                    'required'    => true,
                    'class'       => 'ui-datepicker form-control'
                ) ) }}
            </div>
            <br>
            <div class="row">
                {{ Form::text('original_location', '', array(
                    'id'          => 'ui-block-name',
                    'placeholder' => 'Original location',
                    'minlength'   => 3,
                    'maxlength'   => 3,
                    'required'    => true,
                    'class'       => 'form-control'
                ) ) }}
            </div>
            <br>
            <div class="row">
                {{ Form::text('destination_location', '', array(
                    'id'          => 'ui-block-name',
                    'placeholder' => 'Destination location',
                    'minlength'   => 3,
                    'maxlength'   => 3,
                    'required'    => true,
                    'class'       => 'form-control'
                ) ) }}
            </div>
            <br>
            <div class="row">
                {{ Form::number('passangers_quantity', '', array(
                'id'          => 'ui-block-name',
                'placeholder' => 'Passangers quantity',
                'min'         => 1,
                'required'    => true,
                'class'       => 'form-control'
            ) ) }}
            </div>
            <br>

            {{ Form::submit( 'Add', array(
                'id'    => 'ui-add-block-btn',
                'class' => 'btn btn-success'
            ) ) }}

        {{ Form::close() }}
    </div>
</div>

@endsection

@section('javascript')
    <script type="text/javascript">
        $(document).ready(function () {
            $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
            $( ".ui-datepicker" ).datepicker({
                dateFormat: "yy-mm-dd"
            });
        });
    </script>
@append