<div class="main-save">
    @if(isset($back))
        <a class="btn btn-success btn-warning btn-sm"
           href="{{$back}}">{{__('aboleon-framework.goback')}}</a>
    @endif
    <button type="submit" class="btn btn-success btn-sm">{{ $label }}</button>
</div>
