@extends('admin:aksara::layouts.layout')

@section('breadcrumb')
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.root') }}">Dashboard</a></li>
    <li class="breadcrumb-item"><a href="{{ route('module-manager.index') }}">Module Manager</a></li>
    <li class="breadcrumb-item active">Plugin Activation Check</li>
  </ol>
@endsection

@section('content')
  <div class="container">
    <div class="content__head">
      <h2 class="page-title">Activating {{ $type }}</h2>
    </div>
    <div class="col-md-6">
      <!-- dependencies -->
      <h3>Activating {{ $type }} : {{ $slug }}</h3>
      <p>
      The following plugin(s) will be activated if inactive because of dependency
      </p>
      <ul>
        @foreach($dependencies as $dependency)
          <li>{{ $dependency->getModuleName() }} ({{ !$dependency->getIsRegistered() ? 'Unregistered' : ($dependency->getIsActive() ? 'Active' : 'Inactive') }}) </li>
        @endforeach
      </ul>
    </div>
    <div class="col-md-6">
      <div class="row">
        <h3>Pending Migrations</h3>
        <p>Please run the following migration(s)</p>
        <!-- migration pending -->
          @foreach($migrations as $migration)
            <br><code>php artisan migrate --path={{ str_replace(base_path() . '/', '', $migration) }}</code>
          @endforeach
        </ul>
      </div>
      <div class="row">
        <div class="col-md-12 text-right">
          <form method='POST' action="{{ route('module-manager.activate-recursive',['slug'=> $slug,'type'=>$type]) }}">
            {{ csrf_field() }}

            <input class='btn btn-xs btn-primary'
              type='submit' value="Next"
              {{ $allow_activation ? '' : 'disabled' }}>
          </form>
        </div>

      </div>
    </div>
  </div>
@endsection
