@extends('layouts.app')

@section('content')
<div class="container-fluid">


    <div class="row">
        <div class="col-md-2">
            <aside >
                <ul >
                    <li>
                        <router-link to="/consumers" class="nav-link">Consumers</router-link>
                    </li>
                    <li >
                        <router-link to="/about" class="nav-link">About</router-link>
                    </li>
                </ul>
            </aside>
        </div>
        <div class="col-md-10">
            <router-view></router-view>
        </div>
    </div>
</div>
@endsection
