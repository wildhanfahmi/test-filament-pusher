<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Join Shiftmeeting') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <video id="preview" width="100%"></video>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
<script defer>

document.addEventListener("DOMContentLoaded", event => {
  let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
  Instascan.Camera.getCameras().then(cameras => {
    scanner.camera = cameras[cameras.length - 1];
    scanner.start();
  }).catch(e => console.error(e));

  scanner.addListener('scan', content => {
    console.log(content);
  });

});

    
    </script>