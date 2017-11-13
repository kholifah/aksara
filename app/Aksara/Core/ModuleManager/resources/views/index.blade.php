@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Module Manager</li>
</ol>
@endsection

@section('content')

<div class="container">
    <div class="content__head">
        <h2 class="page-title">Module Manager</h2>
    </div>
    <!-- /.content__head -->
    <div>
      <table class='table'>
        <tr>
          <th style="width:100px">Status</th>
          <th style="width:150px">Action</th>
          <th>Name</th>
        </tr>
        @foreach( \Config::get('aksara.modules.plugin',[])  as $moduleName => $moduleDescription )
        <tr>
          <td>
          @if($module->getModuleStatus('plugin',$moduleName))
            <span class="label label-success">Active</span>
          @else
            <span class="label label-danger">Not Active</span>
          @endif
          </td>
          <td>

            @if($module->getModuleStatus('plugin',$moduleName))
              <form method='POST' action="{{ route('module-manager.deactivate',['slug'=>$moduleName]) }}">
                {{ csrf_field() }}

                <input type='submit' class='btn btn-xs btn-default' value="deactivate" >
              </form>
            @else
              <form method='POST' action="{{ route('module-manager.activate',['slug'=>$moduleName]) }}">
                {{ csrf_field() }}

                <input class='btn btn-xs btn-primary' type='submit' value="activate" >
              </form>
            @endif
          </td>
          <td>
            <p>{{ $moduleDescription['name'] }}</p>
            <p>Description : {{ $moduleDescription['description'] }}</p>
            @if( sizeof($moduleDescription['dependencies']) >0 )
            <p>Dependencies : {{ implode(',',$moduleDescription['dependencies'] ) }}</p>
            @endif
          </td>
        </tr>
        @endforeach

      </table>
    <div>

    <!-- /.content__body -->
</div>

@endsection
