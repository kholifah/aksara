@extends_backend('layouts.layout')

@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">{{ __('core:dashboard::default.dashboard') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('module-manager.index') }}">{{ __('core:module-manager::default.module-manager') }}</a></li>
    <li class="breadcrumb-item active">{{ __('core:module-manager::default.plugin-activation-check') }}</li>
  </ol>
@endsection

@section('content')
  <div class="container">
    <div class="content__head">
      <h2 class="page-title">{{ __('core:module-manager::message.activating-module', ['moduleType' => $type]) }}</h2>
    </div>
    <div class="col-md-6">
      <!-- dependencies -->
      <h3>{{ __('core:module-manager::message.activating-module-name', ['moduleType' => $type, 'moduleName' => $module_name]) }}</h3>
      <p>
      {{ __('core:module-manager::message.activating-module-name-messsage') }}
      </p>
      <ul>
        @foreach($dependencies as $dependency)
          <li>{{ $dependency['module_name'] }} ({{ !$dependency['is_registered'] ? 'Unregistered' : ($dependency['is_active'] ? __('core:module-manager::default.active') : __('core:module-manager::default.inactive')) }}) </li>
        @endforeach
      </ul>
    </div>
    <div class="col-md-6">
      <div class="row">
        <h3><i class="fa fa-exclamation-circle yellow-icon" style="margin-right: 5px;"></i>{{ __('core:module-manager::message.pending-migrations') }}</h3>
        @if(@$migration_paths)
          <div class="jumbo-bubble warning">
            <p>{{ __('core:module-manager::message.pending-migrations-path') }}:</p>
            @foreach($migration_paths as $path)
              <br><code>{{ $path }}</code>
            @endforeach
          </div>
          <div class="jumbo-bubble warning">
            <p>{{ __('core:module-manager::message.pending-migrations-command') }}:</p>
            <!-- migration pending -->
            @foreach($migrations as $migration)
              <br><code>{{ $migration }}</code>
            @endforeach
          </div>
        @else
          <div class="jumbo-bubble success">
            <p>{{ __('core:module-manager::message.no-pending-migrations') }}</p>
          </div>
            @if(@$seed_commands)
              <div class="jumbo-bubble warning">
                <p>{{ __('core:module-manager::message.seed-commands') }}:</p>
                @foreach($seed_commands as $seed)
                  <br><code>{{ $seed }}</code>
                @endforeach
              </div>
            @endif
        @endif
      </div>
      <div class="row">
        <div class="col-md-12 text-right">
          <form method='POST' action="{{ route('module-manager.activate-recursive',['slug'=> $module_name,'type'=>$type]) }}">
            {{ csrf_field() }}

            <input class='btn btn-xs btn-primary'
              type='submit' value="{{ __('core:module-manager::default.next') }}"
              {{ $allow_activation ? '' : 'disabled' }}>
          </form>
        </div>

      </div>
    </div>
  </div>
@endsection
