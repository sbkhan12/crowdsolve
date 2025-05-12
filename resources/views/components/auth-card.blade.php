<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-blue-300 via-white to-blue-400 py-12 px-4 sm:px-6 lg:px-8">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full max-w-md mt-8 bg-white/90 backdrop-blur-md rounded-xl shadow-xl p-8 border border-blue-100">
        {{ $slot }}
    </div>
</div>
