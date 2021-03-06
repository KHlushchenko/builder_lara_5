@section('title')
  {{ __cms($def['options']['caption']) }}
@stop

@section('ribbon')
   <ol class="breadcrumb">
        <li><a href="/admin"> {{__cms('Главная')}}</a></li>
        <li>{{__cms($def['options']['caption']) }}</li>
   </ol>
@stop
<section id="widget-grid" class="">
    <div class="row" style="padding-right: 13px; padding-left: 13px;">
        <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-right: 0px; padding-left: 0px;">
            <div id="table-preloader" class="smoke_lol"><i class="fa fa-gear fa-4x fa-spin"></i></div>
            <div class="jarviswidget jarviswidget-color-blue" id="wid-id-1"
                data-widget-editbutton="false"
                data-widget-colorbutton="false"
                data-widget-deletebutton="false"
                data-widget-sortable="false">
                @include('admin::tb.table_filter')

                <header>
                    <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                    <h2>{{ __cms($def['options']['caption']) }}</h2>
                    @if (isset($def['buttons']))
                     {!! $controller->buttons->fetch() !!}
                    @endif
                    @if (isset($def['import']) && $def['import'])
                    {!! $controller->import->fetch() !!}
                    @endif
                    @if (isset($def['export']) && $def['export'])
                    {!!  $controller->export->fetch() !!}
                    @endif
                </header>
                <div>
                    <div class="jarviswidget-editbox"></div>
                    <div class="widget-body no-padding">

                        <form id="{{ $def['options']['table_ident'] }}"
                              action="{{ $def['options']['action_url'] }}"
                              method="post"
                              class="form-horizontal tb-table"
                              target="submiter" >

                                <table id="datatable_fixed_column" class="table  table-hover table-bordered">
                                    <thead>
                                        @include('admin::tb.table_thead')
                                    </thead>
                                    <tbody>
                                        @include('admin::tb.table_tbody')
                                    </tbody>
                                    @include('admin::tb.table_tfoot')
                                </table>
                                @include('admin::tb.table_pagination')
                        </form>
                    </div>
                </div>
            </div>
        </article>
    </div>
</section>
<script>
    $(".breadcrumb").html("<li><a href='/admin'>{{__cms('Главная')}}</a></li> <li>{{ __cms($def['options']['caption']) }}</li>");
    $("title").text("{{ __cms($def['options']['caption']) }} - {{ __cms(Config::get('builder.admin.caption')) }}");
</script>