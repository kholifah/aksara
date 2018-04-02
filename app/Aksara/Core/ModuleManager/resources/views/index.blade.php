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
    {{-- V2 --}}
    @foreach ($moduleGroup as $type => $modules)
    <div>
      <h3>{{ slug_to_title($type) }}</h3>
      <table class='table'>
        <tr>
          <th style="width:100px">{{  __('core:module-manager::default.status') }}</th>
          <th style="width:150px">{{  __('core:module-manager::default.action') }}</th>
          <th>{{  __('core:module-manager::default.name') }}</th>
        </tr>
        @foreach($modules as $module)
        <tr>
          <td>
          @if($module->getActive())
            <span class="label label-success">{{ __('core:module-manager::default.active') }}</span>
          @else
            <span class="label label-danger">{{ __('core:module-manager::default.non-active') }}</span>
          @endif
          </td>
          <td>

              @if($module->getActive())
                <form method='POST' action="{{ route('module-manager.deactivate',['slug'=>$module->getName(),'type'=>$module->getType()]) }}">
                {{ csrf_field() }}
                <input type='submit' class='btn btn-xs btn-default' value="{{  __('core:module-manager::default.deactivate') }}" {{ $pluginRequiredBy->isRequired(module->getName()) ? __('core:module-manager::default.disabled')  : '' }}>
              </form>
            @else
                <a class='btn btn-xs btn-primany' href="{{ route('module-manager.activation-check', [ 'slug' => $module->getName(), 'type' => $module->getType(), ]) }}">{{  __('core:module-manager::default.activate') }}</a>
            @endif
          </td>
          <td>
            <p>{{ slug_to_title($module->getName()) }}</p>
            <p>__('core:module-manager::default.description') }}: {{ $module->getDescription() }}</p>
            @if( sizeof($module->getDependencies()) >0 )
              <p>__('core:module-manager::default.dependencies') }}: {{ implode(',',$module->getDependencies() ) }}</p>
            @endif
            @if ($pluginRequiredBy->isRequired($module->getName()))
              {{  __('core:module-manager::default.currently-used-by') }}:
              @foreach ($pluginRequiredBy->getRequiredBy($module->getName()) as $requiredByItem)
                {{ $requiredByItem }}
              @endforeach
            @endif
          </td>
        </tr>
        @endforeach
      </table>
    </div>
    @endforeach
    {{-- End V2 --}}
    {{-- V1 --}}
    <div>
      <h3>Legacy Modules</h3>
      <table class='table'>
        <tr>
          <th style="width:100px">{{  __('core:module-manager::default.status') }}</th>
          <th style="width:150px">{{  __('core:module-manager::default.action') }}</th>
          <th>{{  __('core:module-manager::default.name') }}</th>
        </tr>
        @foreach( \Config::get('aksara.modules.plugin',[])  as $moduleName => $moduleDescription )
        <tr>
          <td>
          @if($moduleV1->getModuleStatus('plugin',$moduleName))
            <span class="label label-success">{{ __('core:module-manager::default.active') }}</span>
          @else
            <span class="label label-danger">{{ __('core:module-manager::default.non-active') }}</span>
          @endif
          </td>
          <td>

            @if($moduleV1->getModuleStatus('plugin',$moduleName))
              <form method='POST' action="{{ route('module-manager.deactivate',['slug'=>$moduleName,'type'=>'plugin']) }}">
                {{ csrf_field() }}
                <input type='submit' class='btn btn-xs btn-default' value="{{  __('core:module-manager::default.deactivate') }}" {{ $pluginRequiredBy->isRequired($moduleName) ? __('core:module-manager::default.disabled') : '' }}>
              </form>
            @else
              <a class='btn btn-xs btn-primary' href="{{ route('module-manager.activation-check', [ 'slug' => $moduleName, 'type' => 'plugin', ]) }}">{{  __('core:module-manager::default.activate') }}</a>
            @endif
          </td>
          <td>
            <p>{{ $moduleDescription['name'] }}</p>
            <p>__('core:module-manager::default.description') }}: {{ $moduleDescription['description'] }}</p>
            @if( sizeof($moduleDescription['dependencies']) >0 )
              <p>__('core:module-manager::default.dependencies') }}: {{ implode(',',$moduleDescription['dependencies'] ) }}</p>
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
        @foreach( \Config::get('aksara.modules.front-end',[])  as $moduleName => $moduleDescription )
        <tr>
          <td>
          @if($moduleV1->getModuleStatus('front-end',$moduleName))
            <span class="label label-success">{{ __('core:module-manager::default.active') }}</span>
          @else
            <span class="label label-danger">{{ __('core:module-manager::default.non-active') }}</span>
          @endif
          </td>
          <td>

          @if($moduleV1->getModuleStatus('front-end',$moduleName))
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
    {{-- End V1 --}}
</div>

@endsection
