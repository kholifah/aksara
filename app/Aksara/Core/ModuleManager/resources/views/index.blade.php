@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">{{ __('core:dashboard::default.dashboard') }}</a></li>
    <li class="breadcrumb-item active">{{ __('core:module-manager::default.module-manager') }}</li>
</ol>
@endsection

@section('content')

<div class="container">
    <div class="content__head">
        <h2 class="page-title">{{ __('core:module-manager::default.module-manager') }}</h2>
    </div>
    <!-- /.content__head -->
    <div>
      <h3>{{  __('core:module-manager::default.plugins') }}</h3>
      <table class='table'>
        <tr>
          <th style="width:100px">{{  __('core:module-manager::default.status') }}</th>
          <th style="width:150px">{{  __('core:module-manager::default.action') }}</th>
          <th>{{  __('core:module-manager::default.name') }}</th>
        </tr>
        @foreach( \Config::get('aksara.modules.plugin',[])  as $moduleName => $moduleDescription )
        <tr>
          <td>
          @if($module->getModuleStatus('plugin',$moduleName))
            <span class="label label-success">{{ __('core:module-manager::default.active') }}</span>
          @else
            <span class="label label-danger">{{ __('core:module-manager::default.non-active') }}</span>
          @endif
          </td>
          <td>

            @if($module->getModuleStatus('plugin',$moduleName))
              <form method='POST' action="{{ route('module-manager.deactivate',['slug'=>$moduleName,'type'=>'plugin']) }}">
                {{ csrf_field() }}

                <input type='submit' class='btn btn-xs btn-default' value="{{  __('core:module-manager::default.deactivate') }}" {{ $pluginRequiredBy->isRequired($moduleName) ? __('core:module-manager::default.disabled')  : '' }}>
              </form>
            @else
              <a class='btn btn-xs btn-primany' href="{{ route('module-manager.activation-check', [ 'slug' => $moduleName, 'type' => 'plugin', ]) }}">{{  __('core:module-manager::default.activate') }}</a>
            @endif
          </td>
          <td>
            <p>{{ $moduleDescription['name'] }}</p>
            <p>{{  __('core:module-manager::default.description') }} : {{ $moduleDescription['description'] }}</p>
            @if( sizeof($moduleDescription['dependencies']) >0 )
            <p>{{  __('core:module-manager::default.dependencies') }} : {{ implode(',',$moduleDescription['dependencies'] ) }}</p>
            @endif
            @if ($pluginRequiredBy->isRequired($moduleName))
              {{  __('core:module-manager::default.currently-used-by') }}:
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
      <h3>{{  __('core:module-manager::default.plugins-v2') }}</h3>
      <table class='table'>
        <tr>
          <th style="width:100px">{{  __('core:module-manager::default.status') }}</th>
          <th style="width:150px">{{  __('core:module-manager::default.action') }}</th>
          <th>{{  __('core:module-manager::default.name') }}</th>
        </tr>
        @foreach($plugins as $plugin)
        <tr>
          <td>
          @if($plugin->getActive())
            <span class="label label-success">{{ __('core:module-manager::default.active') }}</span>
          @else
            <span class="label label-danger">{{ __('core:module-manager::default.non-active') }}</span>
          @endif
          </td>
          <td>

              @if($plugin->getActive())
                  <form method='POST' action="{{ route('module-manager.deactivate',['slug'=>$plugin->getName(),'type'=>'plugin']) }}">
                {{ csrf_field() }}

                <input type='submit' class='btn btn-xs btn-default' value="{{  __('core:module-manager::default.deactivate') }}" {{ $pluginRequiredBy->isRequired($plugin->getName()) ? __('core:module-manager::default.disabled') : '' }}>
              </form>
            @else
                <a class='btn btn-xs btn-primany' href="{{ route('module-manager.activation-check', [ 'slug' => $plugin->getName(), 'type' => 'plugin', ]) }}">{{  __('core:module-manager::default.activate') }}</a>
            @endif
          </td>
          <td>
              <p>{{ slug_to_title($plugin->getName()) }}</p>
              <p>{{  __('core:module-manager::default.description') }} : {{ $plugin->getDescription() }}</p>
              @if( sizeof($plugin->getDependencies()) >0 )
                  <p>{{  __('core:module-manager::default.dependencies') }} : {{ implode(',',$plugin->getDependencies() ) }}</p>
            @endif
            @if ($pluginRequiredBy->isRequired($plugin->getName()))
              {{  __('core:module-manager::default.currently-used-by') }}:
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
      <h3>{{  __('core:module-manager::default.front-end') }}</h3>
      <table class='table'>
        <tr>
          <th style="width:100px">{{  __('core:module-manager::default.status') }}</th>
          <th style="width:150px">{{  __('core:module-manager::default.action') }}</th>
          <th>{{  __('core:module-manager::default.name') }}</th>
        </tr>
        @foreach( \Config::get('aksara.modules.front-end',[])  as $moduleName => $moduleDescription )
        <tr>
          <td>
          @if($module->getModuleStatus('front-end',$moduleName))
            <span class="label label-success">{{ __('core:module-manager::default.active') }}</span>
          @else
            <span class="label label-danger">{{ __('core:module-manager::default.non-active') }}</span>
          @endif
          </td>
          <td>

            @if($module->getModuleStatus('front-end',$moduleName))
              <form method='POST' action="{{ route('module-manager.deactivate',['slug'=>$moduleName,'type'=>'front-end']) }}">
                {{ csrf_field() }}

                <input type='submit' class='btn btn-xs btn-default' value="{{  __('core:module-manager::default.deactivate') }}" >
              </form>
            @else
              <a class='btn btn-xs btn-primany' href="{{ route('module-manager.activation-check', [ 'slug' => $moduleName, 'type' => 'front-end', ]) }}">{{  __('core:module-manager::default.activate') }}</a>
            @endif
          </td>
          <td>
            <p>{{ $moduleDescription['name'] }}</p>
            <p>{{  __('core:module-manager::default.description') }} : {{ $moduleDescription['description'] }}</p>
            @if( sizeof($moduleDescription['dependencies']) >0 )
            <p>{{  __('core:module-manager::default.dependencies') }} : {{ implode(',',$moduleDescription['dependencies'] ) }}</p>
            @endif
          </td>
        </tr>
        @endforeach
      </table>
    </div>
    {{-- End Plugin --}}
</div>

@endsection
