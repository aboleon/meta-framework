<?php
/**
 * Blade template example file
 */
?>
<div class="row my-3">
    @php
        $media = Mediaclass::on($item)->size('xl')->param('class', 'respimg')->single();
        $img = $media->get();


        $class = match($img['position'] ?? '') {
          'right','left' =>  'col-md-6',
          'up', 'down' => 'col-12',
          default => ''
        };
        $order = match($img['position'] ?? '') {
          'right', 'down' =>  'order-2',
          default => ''
        };
    @endphp
    @if ($img)
        <div class="{{ $class .' '. $order}} single-post-content_text_media img">
            {!!  $media->render() !!}
        </div>
    @endif
    <div class="text-read {{$class . ' '. ($img['position'] ?? '') }} py-4">
        <h2>{{ $item->title }}</h2>
        {!!  $item->content !!}
    </div>
</div>
