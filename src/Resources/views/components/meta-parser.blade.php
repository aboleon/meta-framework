<style>
    #mfw-parser-debug {
        top: 0;
        background: #f9f9f9;
        width: 50%;
        height: 100%;
        display: block;
        z-index: 9999;
        right: 0;
        position: fixed;
        overflow-y: scroll;
        transform: translateX(100%);
        transition: transform 0.5s;
    }
    #mfw-toggleButton {
        background: #bd2b56;;
        display: inline-block;
        position: fixed;
        top: 11px;
        right: 15px;
        z-index: 99999;
        padding: 8px 12px;
        color: white;
        font-size: 13px;
        border: 0;
        cursor: pointer;
        transition: 200ms all ease;
    }
    #mfw-toggleButton:hover {
        background: #18668b;
    }
    #mfw-parser-header {
        font-family: 'Monaco', 'Menlo', 'Consolas', 'Courier New', monospace;
        font-size: 18px;
        background: #0f0f0f;
        color: #eabd38;
        text-align: left;
        padding: 16px 0 16px 40px;
    }
    #mfw-parser-debug-handler {
        position: absolute;
        left: -5px;
        top: 0;
        width: 10px;
        height: 100vh;
        background-color: #0e808f;
        cursor: ew-resize;
    }
    #mfw-parser-inner {
        background: #d3d3d3;
        padding: 4%;
    }
    .mfw-parser-iteration {
        background: #156183;
        color: white;
        font-size: 20px;
        font-weight: 700;
        width: 46px;
        height: 46px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .mfw-parser-title {
        display: flex;
        align-items: center;
        padding-left: 25px;
        font-size: 18px;
    }
    #mfw-parser-debug::-webkit-scrollbar {
        width: 8px;
    }

    /* Set the color of the scrollbar track */
    #mfw-parser-debug::-webkit-scrollbar-track {
        background-color: #f0f0f0;
    }

    /* Set the color of the scrollbar thumb */
    #mfw-parser-debug::-webkit-scrollbar-thumb {
        background-color: #0e808f;
        border-radius: 6px;
    }

    /* Change the color of the scrollbar thumb when hovering */
    #mfw-parser-debug::-webkit-scrollbar-thumb:hover {
        background-color: #156183;
    }
</style>
<button type="button" id="mfw-toggleButton">MetaParser</button>
<div id="mfw-parser-debug">
    <div id="mfw-parser-debug-handler"></div>
    <div id="mfw-parser-header">MetaParser >...</div>
    <div id="mfw-parser-inner">
        @if(is_array(session('metaparser')))
            @foreach(session('metaparser') as $key => $item)
                <div style="display: flex">
                    <span class="mfw-parser-iteration">{{ $loop->iteration }}</span>
                    <span class="mfw-parser-title">{{ $key }}</span>
                </div>
                {{ d($item) }}
                <div style="margin: 3% 0"></div>
            @endforeach
        @endif
        @php
            session()->forget('metaparser');
        @endphp
    </div>
</div>
<script>

  const toggleButton = document.getElementById('mfw-toggleButton');
  const resizable = document.getElementById('mfw-parser-debug');
  const handler = document.getElementById('mfw-parser-debug-handler');

  let isResizing = false;
  let startX;

  let isHidden = true;

  toggleButton.addEventListener('click', () => {
    if (isHidden) {
      resizable.style.transform = 'translateX(0)';
    } else {
      resizable.style.transform = 'translateX(100%)';
    }
    isHidden = !isHidden;
  });

  resizableHeight = resizable.scrollHeight;
  handler.style.height = `${resizableHeight}px`;

  handler.addEventListener('mousedown', (event) => {
    isResizing = true;
    startX = event.clientX;
  });

  document.addEventListener('mousemove', (event) => {
    if (!isResizing) return;
    const movementX = startX - event.clientX;
    startX = event.clientX;
    const newWidth = resizable.offsetWidth + movementX;
    console.log(movementX);
    resizable.style.width = `${newWidth}px`;
    resizable.style.left = `${resizable.offsetLeft - movementX}px`;
  });

  document.addEventListener('mouseup', () => {
    isResizing = false;
  });
</script>