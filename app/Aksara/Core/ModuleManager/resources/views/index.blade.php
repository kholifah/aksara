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
      <h3>Plugins</h3>
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
              <form method='POST' action="{{ route('module-manager.deactivate',['slug'=>$moduleName,'type'=>'plugin']) }}">
                {{ csrf_field() }}

                <input type='submit' class='btn btn-xs btn-default' value="deactivate" {{ $pluginRequiredBy->isRequired($moduleName) ? 'disabled' : '' }}>
              </form>
            @else
              <a class='btn btn-xs btn-primany' href="{{ route('module-manager.activation-check', [ 'slug' => $moduleName, 'type' => 'plugin', ]) }}">Activate</a>
            @endif
          </td>
          <td>
            <p>{{ $moduleDescription['name'] }}</p>
            <p>Description : {{ $moduleDescription['description'] }}</p>
            @if( sizeof($moduleDescription['dependencies']) >0 )
            <p>Dependencies : {{ implode(',',$moduleDescription['dependencies'] ) }}</p>
            @endif
            @if ($pluginRequiredBy->isRequired($moduleName))
              Currently used by:
              @foreach ($pluginRequiredBy->getRequiredBy($moduleName) as $requiredByItem)
                {{ $requiredByItem }}
              @endforeach
            @endif
          </td>
        </tr>
        @endforeach
      </table>
    </div>
    <div>
      <h3>Plugins V2</h3>
      <table class='table'>
        <tr>
          <th style="width:100px">Status</th>
          <th style="width:150px">Action</th>
          <th>Name</th>
        </tr>
        @foreach($plugins as $plugin)
        <tr>
          <td>
          @if($plugin->getActive())
            <span class="label label-success">Active</span>
          @else
            <span class="label label-danger">Not Active</span>
          @endif
          </td>
          <td>

              @if($plugin->getActive())
                  <form method='POST' action="{{ route('module-manager.deactivate',['slug'=>$plugin->getName(),'type'=>'plugin']) }}">
                {{ csrf_field() }}

                <input type='submit' class='btn btn-xs btn-default' value="deactivate" {{ $pluginRequiredBy->isRequired($plugin->getName()) ? 'disabled' : '' }}>
              </form>
            @else
                <a class='btn btn-xs btn-primany' href="{{ route('module-manager.activation-check', [ 'slug' => $plugin->getName(), 'type' => 'plugin', ]) }}">Activate</a>
            @endif
          </td>
          <td>
              <p>{{ slug_to_title($plugin->getName()) }}</p>
              <p>Description : {{ $plugin->getDescription() }}</p>
              @if( sizeof($plugin->getDependencies()) >0 )
                  <p>Dependencies : {{ implode(',',$plugin->getDependencies() ) }}</p>
            @endif
            @if ($pluginRequiredBy->isRequired($plugin->getName()))
              Currently used by:
              @foreach ($pluginRequiredBy->getRequiredBy($plugin->getName()) as $requiredByItem)
                {{ $requiredByItem }}
              @endforeach
            @endif
          </td>
        </tr>
        @endforeach
      </table>
    </div>
    {{-- End Plugin --}}
    <div>
      <h3>Front End</h3>
      <table class='table'>
        <tr>
          <th style="width:100px">Status</th>
          <th style="width:150px">Action</th>
          <th>Name</th>
        </tr>
        @foreach( \Config::get('aksara.modules.front-end',[])  as $moduleName => $moduleDescription )
        <tr>
          <td>
          @if($module->getModuleStatus('front-end',$moduleName))
            <span class="label label-success">Active</span>
          @else
            <span class="label label-danger">Not Active</span>
          @endif
          </td>
          <td>

            @if($module->getModuleStatus('front-end',$moduleName))
              <form method='POST' action="{{ route('module-manager.deactivate',['slug'=>$moduleName,'type'=>'front-end']) }}">
                {{ csrf_field() }}

                <input type='submit' class='btn btn-xs btn-default' value="deactivate" >
              </form>
            @else
              <a class='btn btn-xs btn-primany' href="{{ route('module-manager.activation-check', [ 'slug' => $moduleName, 'type' => 'front-end', ]) }}">Activate</a>
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
    </div>
    {{-- End Plugin --}}
</div>

@endsection
