@extends('layout.default')

@section('breadcrumb')
    <li class="active">
        <a href="{{ route('inbox') }}">
            <span itemprop="title" class="l-breadcrumb-item-link-title">
                {{ trans('pm.inbox') }}
            </span>
        </a>
    </li>
@endsection

@section('content')
    <div class="container">
        <div class="header gradient silver">
            <div class="inner_content">
                <h1>{{ trans('pm.private') }} {{ trans('pm.messages') }} - {{ trans('pm.inbox') }}</h1>
            </div>
        </div>
        <div class="row">
            @include('partials.pmmenu')
            <div class="col-md-10">
                <div class="block">
                    <div class="row">
                        <div class="col-md-8 col-xs-5">
                            <div class="btn-group">
                                <a href="{{ route('mark-all-read') }}">
                                    <button type="button" id="mark-all-read" class="btn btn-success dropdown-toggle"
                                            data-toggle="tooltip" data-placement="top"
                                            data-original-title="{{ trans('pm.mark-all-read') }}"><i
                                                class="{{ config('other.font-awesome') }} fa-eye"></i></button>
                                </a>
                                <a href="{{ route('inbox') }}">
                                    <button type="button" id="btn_refresh" class="btn btn-primary dropdown-toggle"
                                            data-toggle="tooltip" data-placement="top"
                                            data-original-title="{{ trans('pm.refresh') }}"><i
                                                class="{{ config('other.font-awesome') }} fa-sync-alt"></i></button>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-7">
                            <div class="input-group pull-right">
                                <form role="form" method="POST" action="{{ route('searchPMInbox') }}">
                                    @csrf
                                    <input type="text" name="subject" id="subject" class="form-control"
                                           placeholder="{{ trans('pm.search') }}">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-condensed table-bordered table-striped table-hover">
                            <thead>
                            <tr>
                                <td class="col-sm-2">{{ trans('pm.from') }}</td>
                                <td class="col-sm-5">{{ trans('pm.subject') }}</td>
                                <td class="col-sm-2">{{ trans('pm.recieved-at') }}</td>
                                <td class="col-sm-2">{{ trans('pm.read') }}</td>
                                <td class="col-sm-2">{{ trans('pm.delete') }}</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($pms as $p)
                                <tr>
                                    <td class="col-sm-2">
                                        <a href="{{ route('profile', ['username' => $p->sender->username, 'id' => $p->sender->id]) }}"
                                          >{{ $p->sender->username}}
                                        </a>
                                    </td>
                                    <td class="col-sm-5">
                                        <a href="{{ route('message', ['id' => $p->id]) }}">
                                            {{ $p->subject }}
                                        </a>
                                    </td>
                                    <td class="col-sm-2">
                                        {{ $p->created_at->diffForHumans() }}
                                    </td>
                                    @if ($p->read == 0)
                                        <td class="col-sm-2">
                                            <span class='label label-danger'>
                                                {{ trans('pm.unread') }}
                                            </span>
                                        </td>
                                    @else ($p->read >= 1)
                                        <td class="col-sm-2">
                                            <span class='label label-success'>
                                                {{ trans('pm.read') }}
                                            </span>
                                        </td>
                                    @endif
                                    <td class="col-sm-2">
                                        <form role="form" method="POST" action="{{ route('delete-pm',['id' => $p->id]) }}">
                                            @csrf
                                            <div class="col-sm-1">
                                                <button type="submit" class="btn btn-xs btn-danger"
                                                        title="{{ trans('pm.delete') }}"><i class="{{ config('other.font-awesome') }} fa-trash"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="align-center">{{ $pms->links() }}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
